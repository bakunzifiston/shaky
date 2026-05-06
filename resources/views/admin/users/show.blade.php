<x-layouts.admin title="View User">
    <section class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900">User Details</h2>
                <p class="mt-1 text-sm text-slate-500">View and manage this user record.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <dt class="text-sm text-slate-500">Name</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Email</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Email Verified At</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $user->email_verified_at?->format('Y-m-d H:i') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Created At</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $user->created_at?->format('Y-m-d H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Updated At</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $user->updated_at?->format('Y-m-d H:i') }}</dd>
                </div>
            </dl>
        </div>
    </section>
</x-layouts.admin>
