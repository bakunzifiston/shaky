<x-layouts.admin title="E-Commerce Videos">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Catalog</p>
            <h2 class="text-2xl font-semibold text-slate-900">Videos</h2>
            <p class="mt-1 text-sm text-slate-600">Upload and manage short videos displayed on the storefront home page.</p>
        </header>

        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.ecommerce.catalog.videos.store') }}" enctype="multipart/form-data" class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            <h3 class="text-lg font-semibold text-slate-900">Upload Video</h3>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div>
                    <label for="title" class="mb-1 block text-sm font-medium text-slate-700">Title (optional)</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none">
                    <p class="mt-1 text-xs text-slate-500">If multiple videos are selected, this text is used as a prefix.</p>
                    @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="sort_order" class="mb-1 block text-sm font-medium text-slate-700">Sort Order</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" max="9999" value="{{ old('sort_order', 0) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none">
                    @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="video_file" class="mb-1 block text-sm font-medium text-slate-700">Video File (mp4, webm, ogg, mov)</label>
                    <input id="video_file" name="video_files[]" type="file" accept=".mp4,.webm,.ogg,.mov,.qt,video/mp4,video/webm,video/ogg,video/quicktime" multiple required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none">
                    <p class="mt-1 text-xs text-slate-500">Maximum file size per video: {{ $maxVideoMb }}MB.</p>
                    @error('video_files')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('video_files.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    Show on storefront home page
                </label>
            </div>
            <button type="submit" class="mt-5 rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">Upload Video</button>
        </form>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Preview</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Title</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Sort</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($videos as $video)
                        <tr>
                            <td class="px-4 py-3">
                                <video class="h-16 w-28 rounded-md object-cover ring-1 ring-slate-200" muted playsinline preload="metadata">
                                    <source src="{{ asset('storage/' . $video->video_path) }}">
                                </video>
                            </td>
                            <td class="px-4 py-3 text-slate-800">{{ $video->title }}</td>
                            <td class="px-4 py-3">
                                @if ($video->is_active)
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-emerald-200">Active</span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 ring-1 ring-slate-200">Hidden</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ $video->sort_order }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <details class="group">
                                        <summary class="cursor-pointer list-none rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                            Edit
                                        </summary>
                                        <form method="POST" action="{{ route('admin.ecommerce.catalog.videos.update', $video) }}" enctype="multipart/form-data" class="mt-3 w-72 space-y-2 rounded-lg border border-slate-200 bg-slate-50 p-3">
                                            @csrf
                                            @method('PUT')
                                            <div>
                                                <label class="mb-1 block text-xs font-medium text-slate-700">Title</label>
                                                <input name="title" type="text" value="{{ old('title', $video->title) }}" required maxlength="120" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                                            </div>
                                            <div>
                                                <label class="mb-1 block text-xs font-medium text-slate-700">Sort Order</label>
                                                <input name="sort_order" type="number" min="0" max="9999" value="{{ old('sort_order', $video->sort_order) }}" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                                            </div>
                                            <div>
                                                <label class="mb-1 block text-xs font-medium text-slate-700">Replace Video (optional)</label>
                                                <input name="video_file" type="file" accept=".mp4,.webm,.ogg,.mov,.qt,video/mp4,video/webm,video/ogg,video/quicktime" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-xs">
                                            </div>
                                            <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                                                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $video->is_active)) class="rounded border-slate-300 text-teal-600">
                                                Show on storefront home page
                                            </label>
                                            <button type="submit" class="rounded-lg bg-teal-700 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-teal-800">Save</button>
                                        </form>
                                    </details>

                                    <form method="POST" action="{{ route('admin.ecommerce.catalog.videos.destroy', $video) }}" onsubmit="return confirm('Delete this video?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-100">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">No videos uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-layouts.admin>
