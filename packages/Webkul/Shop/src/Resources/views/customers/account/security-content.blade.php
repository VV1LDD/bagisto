@php
    $customer = auth()->guard('customer')->user();
    $hasSeed = !is_null($customer->mnemonic_hash);
    $isVerified = (bool) $customer->mnemonic_verified_at;
    $passkeyCount = $customer->passkeys()->count();
    $isOnboarding = $isOnboarding ?? false;
@endphp

<div class="{{ $isOnboarding ? 'space-y-3' : 'space-y-3' }}">
    {{-- Seed Phrase --}}
    @php
        $pendingActivation = str_starts_with($customer->credits_id, 'M-') || 
                        (str_starts_with($customer->credits_id, '0x') && is_null($customer->encrypted_private_key));
    @endphp

    @if (!$isVerified || $pendingActivation)
        <a href="{{ route('shop.customers.account.profile.generate_recovery_key') }}" 
            class="group relative block w-full bg-white border-4 border-zinc-900 p-3 md:p-4 transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[6px_6px_0px_0px_rgba(24,24,27,1)] active:translate-x-0 active:translate-y-0 active:shadow-none shadow-[4px_4px_0px_0px_rgba(255,77,109,1)]">
            <div class="flex items-start {{ $isOnboarding ? 'gap-3' : 'gap-4' }}">
                <div class="{{ $isOnboarding ? 'w-10 h-10' : 'w-12 h-12' }} flex items-center justify-center {{ $pendingActivation ? 'bg-amber-400' : 'bg-[#FF4D6D]' }} border-3 border-zinc-900 shadow-[2px_2px_0px_0px_rgba(24,24,27,1)] shrink-0 transition-transform group-hover:rotate-3">
                    <svg class="{{ $isOnboarding ? 'w-5 h-5' : 'w-6 h-6' }} text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <span class="text-zinc-900 {{ $isOnboarding ? 'text-base' : 'text-lg' }} font-black uppercase tracking-tight">Фразы восстановления</span>
                        @if ($pendingActivation)
                            <span class="bg-amber-400 border-2 border-zinc-900 px-2 py-0.5 text-[9px] font-black uppercase tracking-widest shadow-[2px_2px_0px_0px_rgba(24,24,27,1)]">активация nft 💎</span>
                        @else
                            <span class="bg-[#FF4D6D] border-2 border-zinc-900 px-2 py-0.5 text-[9px] font-black uppercase tracking-widest text-white shadow-[2px_2px_0px_0px_rgba(24,24,27,1)]">критично</span>
                        @endif
                    </div>
                    <p class="{{ $isOnboarding ? 'text-[9px]' : 'text-[11px]' }} text-zinc-600 font-black uppercase tracking-wider leading-tight">
                        {{ $pendingActivation ? 'Активируйте современный кошелек для NFT-подарков' : 'Единственный способ вернуть доступ к данным' }}
                    </p>
                </div>
                <div class="pt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-6 h-6 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </div>
            </div>
        </a>
    @endif

    {{-- Manage Passkeys --}}
    <a href="{{ route('shop.customers.account.passkeys.index', ['onboarding' => $isOnboarding]) }}" 
        class="group relative block w-full bg-white border-4 border-zinc-900 p-3 md:p-4 transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[6px_6px_0px_0px_rgba(24,24,27,1)] active:translate-x-0 active:translate-y-0 active:shadow-none shadow-[4px_4px_0px_0px_rgba(124,69,245,1)]">
        <div class="flex items-start {{ $isOnboarding ? 'gap-3' : 'gap-4' }}">
            <div class="{{ $isOnboarding ? 'w-10 h-10' : 'w-12 h-12' }} flex items-center justify-center bg-[#7C45F5] border-3 border-zinc-900 shadow-[2px_2px_0px_0px_rgba(24,24,27,1)] shrink-0 transition-transform group-hover:-rotate-3 text-white">
                <svg class="{{ $isOnboarding ? 'w-5 h-5' : 'w-6 h-6' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0 pt-0.5">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <span class="text-zinc-900 {{ $isOnboarding ? 'text-base' : 'text-lg' }} font-black uppercase tracking-tight">Устройства (Passkeys)</span>
                    @if($passkeyCount > 0)
                        <span class="bg-[#7C45F5] border-2 border-zinc-900 px-2 py-0.5 text-[8px] font-black uppercase tracking-widest text-white shadow-[1px_1px_0px_0px_rgba(24,24,27,1)]">
                            {{ $passkeyCount }} {{ $passkeyCount === 1 ? 'ключ' : 'ключа' }}
                        </span>
                    @endif
                </div>
                <p class="{{ $isOnboarding ? 'text-[9px]' : 'text-[11px]' }} text-zinc-600 font-black uppercase tracking-wider leading-tight">Вход без пароля на любых устройствах</p>
            </div>
            <div class="pt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                <svg class="w-6 h-6 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </div>
        </div>
    </a>

    {{-- Items hidden during onboarding --}}
    @if (!$isOnboarding)
        {{-- Activity Log --}}
        <a href="{{ route('shop.customers.account.login_activity.index') }}" 
            class="group relative block w-full bg-white border-4 border-zinc-900 p-3 md:p-4 transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[6px_6px_0px_0px_rgba(24,24,27,1)] active:translate-x-0 active:translate-y-0 active:shadow-none shadow-[4px_4px_0px_0px_rgba(0,255,148,1)]">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 flex items-center justify-center bg-[#00FF94] border-3 border-zinc-900 shadow-[2px_2px_0px_0px_rgba(24,24,27,1)] shrink-0 transition-transform group-hover:rotate-6 text-zinc-900">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A9 9 0 112.182 19.818l4.636-4.636a2.121 2.121 0 113.001-3.001l4.635-4.635z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <span class="text-zinc-900 text-lg font-black uppercase tracking-tight block mb-1">Активность входа</span>
                    <p class="text-[11px] text-zinc-600 font-black uppercase tracking-wider leading-tight">Мониторинг активных сессий</p>
                </div>
                <div class="pt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-6 h-6 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </div>
            </div>
        </a>
    @endif
</div>
