<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Meus Grupos de Treino</h2>
            <a href="{{ route('groups.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                Novo Grupo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 text-emerald-700 rounded-2xl font-bold">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-100 text-rose-700 rounded-2xl font-bold">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($groups as $group)
                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase">Grupo</span>
                            <span class="text-slate-400 font-bold text-xs">{{ $group->students_count }} Alunos</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tighter">{{ $group->name }}</h3>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <a href="{{ route('groups.edit', $group) }}" class="text-[10px] font-black uppercase text-slate-400 hover:text-blue-600">Editar</a>
                        <form action="{{ route('groups.destroy', $group) }}" method="POST" onsubmit="return confirm('Excluir este grupo?')">
                            @csrf @method('DELETE')
                            <button class="text-[10px] font-black uppercase text-rose-400 hover:text-rose-600">Excluir</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>