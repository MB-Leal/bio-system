<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Grupos / Desafios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-blue-500">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Novo Grupo</h2>
                        <p class="mt-1 text-sm text-gray-600">Crie um novo grupo para agrupar alunos e gerar rankings.</p>
                    </header>

                    <form action="{{ route('groups.store') }}" method="POST" class="mt-6 flex items-center gap-4">
                        @csrf
                        <div class="w-full max-w-sm">
                            <x-input-label for="name" value="Nome do Grupo" class="sr-only" />
                            <x-text-input id="name" name="name" type="text" class="w-full" placeholder="Ex: Casais em Ação" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <x-primary-button>Criar Grupo</x-primary-button>
                    </form>
                </section>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($groups as $group)
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Grupo Ativo</span>
                            <h3 class="text-xl font-black text-gray-800 mt-1">{{ $group->name }}</h3>
                            <p class="text-gray-500 text-sm mt-2">
                                <strong>{{ $group->students_count }}</strong> alunos vinculados
                            </p>
                        </div>
                        
                        <div class="mt-6 flex justify-between items-center">
                            <a href="{{ route('groups.show', $group) }}" class="text-sm font-bold text-gray-900 hover:underline">
                                Ver Ranking →
                            </a>
                            
                            <form action="{{ route('groups.destroy', $group) }}" method="POST" onsubmit="return confirm('Excluir este grupo?')">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-10">
                        <p class="text-gray-400">Você ainda não criou nenhum grupo.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>