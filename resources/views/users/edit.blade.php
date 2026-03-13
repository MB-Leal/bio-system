<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuário: ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">

                <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label value="Nome Completo" />
                        <x-text-input name="name" class="w-full mt-1" :value="old('name', $user->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label value="E-mail" />
                        <x-text-input type="email" name="email" class="w-full mt-1" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 space-y-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Alterar Senha (Opcional)</p>
                        <p class="text-xs text-slate-400 italic mb-4">Deixe em branco para manter a senha atual.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label value="Nova Senha" />
                                <x-text-input type="password" name="password" class="w-full mt-1" autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label value="Confirmar Nova Senha" />
                                <x-text-input type="password" name="password_confirmation" class="w-full mt-1" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-4">
                        <a href="{{ route('users.index') }}" class="text-xs font-black text-slate-400 uppercase tracking-widest py-4 hover:text-slate-600 transition-colors">
                            Cancelar
                        </a>
                        <x-primary-button class="rounded-2xl h-12 px-8">
                            Salvar Alterações
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>