@csrf

<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <div>
        <label for="type" class="mb-1 block text-sm font-medium text-slate-700">Name</label>
        <input
            id="type"
            name="type"
            type="text"
            value="{{ old('type', $product->type ?? '') }}"
            required
            maxlength="255"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
        >
        @error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Type</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $product->name ?? '') }}"
            required
            maxlength="255"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
        >
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="barcode" class="mb-1 block text-sm font-medium text-slate-700">Barcode</label>
        <input
            id="barcode"
            name="barcode"
            type="text"
            value="{{ old('barcode', $product->barcode ?? '') }}"
            maxlength="255"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
        >
        @error('barcode')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="description" class="mb-1 block text-sm font-medium text-slate-700">Description</label>
        <input
            id="description"
            name="description"
            type="text"
            value="{{ old('description', $product->description ?? '') }}"
            maxlength="255"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
        >
        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
        Cancel
    </a>
</div>
