@csrf

<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <div>
        <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Name</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $user->name ?? '') }}"
            required
            maxlength="255"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
        >
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email', $user->email ?? '') }}"
            required
            maxlength="255"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
        >
        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="email_verified_at" class="mb-1 block text-sm font-medium text-slate-700">Email Verified At</label>
        <input
            id="email_verified_at"
            name="email_verified_at"
            type="datetime-local"
            value="{{ old('email_verified_at', isset($user) && $user->email_verified_at ? $user->email_verified_at->format('Y-m-d\TH:i') : '') }}"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
        >
        @error('email_verified_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
        <input
            id="password"
            name="password"
            type="password"
            required
            maxlength="255"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
        >
        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
        Cancel
    </a>
</div>
