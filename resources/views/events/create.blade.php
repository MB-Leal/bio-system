<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agendar Novo Treino / Aula') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100 p-8">
                
                <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="group_id" :value="__('Para qual grupo é este treino?')" />
                        <select name="group_id" id="group_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all" required>
                            <option value="">-- Selecione o Grupo --</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('group_id')" />
                    </div>

                    <div>
                        <x-input-label for="title" :value="__('Título do Evento')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="Ex: Aula de Terça, Treino Especial de Domingo" required />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="scheduled_at" :value="__('Data e Horário')" />
                        <x-text-input id="scheduled_at" name="scheduled_at" type="datetime-local" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('scheduled_at')" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Descrição / Local (Opcional)')" />
                        <textarea id="description" name="description" rows="2" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm" placeholder="Ex: Treino na Praça Central"></textarea>
                    </div>

                    <div class="flex items-center justify-end mt-4 gap-4">
                        <a href="{{ route('events.index') }}" class="text-sm text-slate-400 hover:text-slate-600 font-bold uppercase tracking-widest">
                            Cancelar
                        </a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                            {{ __('Salvar Agendamento') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>