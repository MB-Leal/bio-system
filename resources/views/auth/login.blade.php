<x-guest-layout>
    <div class="min-h-[60vh] flex flex-col justify-center items-center px-4">
        
        <div class="w-full sm:max-w-md bg-white p-8 md:p-10 rounded-[40px] shadow-2xl shadow-slate-200 border border-slate-100">
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Área do Professor</h2>
                <p class="text-sm text-slate-400 font-medium">Faça login para gerenciar seus grupos</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('E-mail')" class="text-slate-500 font-bold ml-1" />
                    <x-text-input id="email" class="block mt-1 w-full border-slate-200 rounded-2xl focus:ring-blue-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Senha')" class="text-slate-500 font-bold ml-1" />
                    <x-text-input id="password" class="block mt-1 w-full border-slate-200 rounded-2xl focus:ring-blue-500"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="block">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded-md border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ms-2 text-sm text-slate-500 font-medium">{{ __('Lembrar de mim') }}</span>
                    </label>
                </div>

                <div class="flex flex-col gap-4 items-center justify-end mt-4">
                    <x-primary-button class="w-full h-14 justify-center rounded-2xl text-lg shadow-lg shadow-blue-100">
                        {{ __('Entrar no Sistema') }}
                    </x-primary-button>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-slate-400 hover:text-blue-600 transition-colors font-medium" href="{{ route('password.request') }}">
                            {{ __('Esqueceu sua senha?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <p class="mt-8 text-[10px] text-slate-400 font-black uppercase tracking-[0.2em]">
            Bio-System &copy; 2026
        </p>
    </div>
</x-guest-layout>