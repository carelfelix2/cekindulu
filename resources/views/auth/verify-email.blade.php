<x-layouts.guest>
    <div class="text-center mb-6">
        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center">
            <svg class="w-7 h-7 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h1 class="text-xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Verifikasi Email</h1>
        <p class="mt-2 text-sm text-surface-500 dark:text-surface-400 leading-relaxed">
            Kami telah mengirimkan link verifikasi ke emailmu. Cek inbox atau folder spam.
        </p>
    </div>

    @if(session('status') == 'verification-link-sent')
        <div class="mb-4 px-4 py-3 rounded-xl bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800/50 text-sm text-primary-700 dark:text-primary-400">
            Link verifikasi baru telah dikirim ke emailmu.
        </div>
    @endif

    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-md w-full justify-center">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-ghost btn-md w-full justify-center text-surface-500">
                Keluar
            </button>
        </form>
    </div>
</x-layouts.guest>
