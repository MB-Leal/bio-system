<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Gestão de Usuários') }}</h2>
            <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                Novo Usuário
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 rounded-r-2xl">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                        <tr>
                            <th class="p-6">Nome</th>
                            <th class="p-6">E-mail</th>
                            <th class="p-6 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-6 font-bold text-slate-700">{{ $user->name }}</td>
                            <td class="p-6 text-slate-500">{{ $user->email }}</td>
                            <td class="p-6 text-right flex justify-end gap-2">
                                <a href="{{ route('users.edit', $user) }}" class="text-blue-600 font-black text-[10px] uppercase tracking-widest hover:underline">Editar</a>

                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Excluir este usuário?')">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-500 font-black text-[10px] uppercase tracking-widest hover:underline">Excluir</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>