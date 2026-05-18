<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('storefront_gallery_albums', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('storefront_gallery_photos', function (Blueprint $table): void {
            $table->foreignId('album_id')
                ->nullable()
                ->after('id')
                ->constrained('storefront_gallery_albums')
                ->cascadeOnDelete();
        });

        if (! Schema::hasTable('storefront_gallery_photos')) {
            return;
        }

        $photos = DB::table('storefront_gallery_photos')->orderBy('sort_order')->orderBy('id')->get();

        foreach ($photos as $photo) {
            $albumId = DB::table('storefront_gallery_albums')->insertGetId([
                'title' => $photo->title,
                'is_active' => (bool) $photo->is_active,
                'sort_order' => (int) $photo->sort_order,
                'created_at' => $photo->created_at ?? now(),
                'updated_at' => $photo->updated_at ?? now(),
            ]);

            DB::table('storefront_gallery_photos')
                ->where('id', $photo->id)
                ->update(['album_id' => $albumId]);
        }
    }

    public function down(): void
    {
        Schema::table('storefront_gallery_photos', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('album_id');
        });

        Schema::dropIfExists('storefront_gallery_albums');
    }
};
