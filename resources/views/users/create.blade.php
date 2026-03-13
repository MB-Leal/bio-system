<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Novo Usuário do Sistema') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
                <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <x-input-label value="Nome Completo" />
                        <x-text-input name="name" class="w-full mt-1" required />
                    </div>
                    <div>
                        <x-input-label value="E-mail" />
                        <x-text-input type="email" name="email" class="w-full mt-1" required />
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label value="Senha" />
                            <x-text-input type="password" name="password" class="w-full mt-1" required />
                        </div>
                        <div>
                            <x-input-label value="Confirmar Senha" />
                            <x-text-input type="password" name="password_confirmation" class="w-full mt-1" required />
                        </div>
                    </div>
                    <div class="flex justify-end gap-4 pt-4">
                        <a href="{{ route('users.index') }}" class="text-xs font-black text-slate-400 uppercase tracking-widest py-4">Cancelar</a>
                        <x-primary-button class="rounded-2xl h-12">Criar Acesso</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>