<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - {{ config('app.name') }}</title>
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
</head>
<body class="h-full bg-slate-50">
    <main class="flex min-h-full items-center justify-center p-4">
        <section class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h1 class="text-xl font-semibold text-slate-900">Admin Login</h1>
            <p class="mt-1 text-sm text-slate-500">Sign in to access the custom admin panel.</p>

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1" class="rounded border-slate-300">
                    Remember me
                </label>
                <button type="submit" class="w-full rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">
                    Sign In
                </button>
            </form>
        </section>
    </main>
</body>
</html>
