<x-layouts.app title="Profil Saya">

<div class="bg-white dark:bg-surface-950 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Profil Saya</h1>
        <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Kelola informasi akun dan pengaturan.</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 lg:p-8">
        <h2 class="text-base font-bold text-surface-900 dark:text-white font-display mb-6 flex items-center gap-2.5">
            <span class="w-1.5 h-5 bg-primary-500 rounded-full"></span>
            Informasi Profil
        </h2>
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 lg:p-8">
        <h2 class="text-base font-bold text-surface-900 dark:text-white font-display mb-6 flex items-center gap-2.5">
            <span class="w-1.5 h-5 bg-accent-500 rounded-full"></span>
            Ubah Password
        </h2>
        @include('profile.partials.update-password-form')
    </div>

    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-red-200 dark:border-red-800/50 p-6 lg:p-8">
        <h2 class="text-base font-bold text-red-600 dark:text-red-400 font-display mb-6 flex items-center gap-2.5">
            <span class="w-1.5 h-5 bg-red-500 rounded-full"></span>
            Hapus Akun
        </h2>
        @include('profile.partials.delete-user-form')
    </div>
</div>

</x-layouts.app>
