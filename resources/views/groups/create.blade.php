<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Novo Grupo</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf
                    <div>
                        <x-input-label value="Nome do Grupo (Ex: Turma da Noite)" />
                        <x-text-input name="name" class="w-full mt-1" required autofocus />
                    </div>
                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('groups.index') }}" class="py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Cancelar</a>
                        <x-primary-button class="rounded-2xl h-12">Salvar Grupo</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>