<x-layouts.app title="Paket Premium">

{{-- Header --}}
<div class="bg-white dark:bg-surface-950 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-accent-50 dark:bg-accent-900/20 border border-accent-200 dark:border-accent-800/50 text-accent-700 dark:text-accent-400 text-xs font-semibold mb-4">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            CekDulu Premium
        </span>
        <h1 class="text-3xl lg:text-4xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">
            Belanja Lebih Cerdas
        </h1>
        <p class="mt-3 text-surface-500 dark:text-surface-400 max-w-lg mx-auto">
            Pilih paket yang sesuai dan nikmati fitur eksklusif untuk pengalaman belanja terbaik.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Active Membership Banner --}}
    @auth
        @if(Auth::user()->activeMembership)
            @php $membership = Auth::user()->activeMembership; @endphp
            <div class="mb-10 bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Kamu sudah Premium!</p>
                        <p class="text-xs text-primary-100">Aktif hingga {{ $membership->ends_at?->format('d M Y') }}</p>
                    </div>
                </div>
                <a href="{{ route('membership.transactions') }}" class="btn btn-sm bg-white/15 hover:bg-white/25 text-white border border-white/20 shrink-0">
                    Lihat Transaksi
                </a>
            </div>
        @endif
    @endauth

    {{-- Plans Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-{{ $plans->count() > 2 ? '3' : '2' }} gap-6">
        @foreach($plans as $plan)
            @php
                $isPopular = $plan->is_popular ?? false;
                $features = is_array($plan->features) ? $plan->features : json_decode($plan->features ?? '[]', true);
            @endphp
            <div class="relative flex flex-col rounded-2xl border-2 {{ $isPopular ? 'border-primary-500 shadow-xl shadow-primary-500/10' : 'border-surface-200 dark:border-surface-700' }} bg-white dark:bg-surface-900 overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">

                @if($isPopular)
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-500 to-primary-400"></div>
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary-600 text-white text-[10px] font-bold rounded-full uppercase tracking-wider">
                            Terpopuler
                        </span>
                    </div>
                @endif

                <div class="p-6 flex-1">
                    <h3 class="text-base font-bold text-surface-900 dark:text-white font-display mb-1">{{ $plan->name }}</h3>
                    @if($plan->description)
                        <p class="text-xs text-surface-500 dark:text-surface-400 mb-5">{{ $plan->description }}</p>
                    @endif

                    <div class="mb-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">
                                Rp {{ number_format($plan->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <p class="text-xs text-surface-400 dark:text-surface-500 mt-0.5">
                            / {{ $plan->duration_days }} hari
                        </p>
                    </div>

                    <ul class="space-y-2.5 mb-6">
                        @foreach($features as $feature)
                            <li class="flex items-start gap-2.5 text-sm text-surface-700 dark:text-surface-300">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="px-6 pb-6">
                    @auth
                        @if(Auth::user()->activeMembership)
                            <button disabled class="btn btn-secondary btn-md w-full justify-center opacity-60 cursor-not-allowed">
                                Sudah Aktif
                            </button>
                        @else
                            <a href="{{ route('membership.checkout', $plan) }}"
                               class="btn {{ $isPopular ? 'btn-primary' : 'btn-outline' }} btn-md w-full justify-center">
                                Pilih Paket
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="btn {{ $isPopular ? 'btn-primary' : 'btn-outline' }} btn-md w-full justify-center">
                            Masuk untuk Berlangganan
                        </a>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>

    {{-- FAQ --}}
    <div class="mt-16">
        <h2 class="text-xl font-extrabold text-surface-900 dark:text-white font-display text-center mb-8">Pertanyaan Umum</h2>
        <div class="space-y-3 max-w-2xl mx-auto" x-data="{ open: null }">
            @foreach([
                ['q' => 'Bagaimana cara pembayaran?', 'a' => 'Pembayaran dilakukan melalui transfer bank. Setelah transfer, upload bukti pembayaran dan tim kami akan memverifikasi dalam 1x24 jam.'],
                ['q' => 'Apakah bisa refund?', 'a' => 'Refund dapat dilakukan dalam 3 hari setelah pembayaran jika membership belum digunakan.'],
                ['q' => 'Apa yang didapat dengan Premium?', 'a' => 'Akses ke price alert, analitik mendalam, diskon eksklusif, dan fitur perbandingan lanjutan.'],
            ] as $i => $faq)
                <div class="bg-white dark:bg-surface-900 rounded-xl border border-surface-200 dark:border-surface-800 overflow-hidden">
                    <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                            class="flex items-center justify-between w-full px-5 py-4 text-left">
                        <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">{{ $faq['q'] }}</span>
                        <svg class="w-4 h-4 text-surface-400 transition-transform duration-200 flex-shrink-0 ml-3"
                             :class="open === {{ $i }} ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === {{ $i }}"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-5 pb-4 text-sm text-surface-500 dark:text-surface-400 leading-relaxed border-t border-surface-100 dark:border-surface-800 pt-3"
                         style="display:none">
                        {{ $faq['a'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

</x-layouts.app>
