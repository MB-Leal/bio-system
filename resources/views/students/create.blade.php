<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Novo Aluno') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100">
                <div class="p-8 text-gray-900">
                    
                    <form action="{{ route('students.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="name" :value="__('Nome Completo')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('E-mail')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="group_id" :value="__('Vincular a um Grupo')" />
                                <select name="group_id" id="group_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all">
                                    <option value="">-- Selecione um Grupo (Opcional) --</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('group_id')" />
                            </div>

                            <div>
                                <x-input-label for="birth_date" :value="__('Data de Nascimento')" />
                                <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                            </div>

                            <div>
                                <x-input-label for="height" :value="__('Altura (m)')" />
                                <x-text-input id="height" name="height" type="number" step="0.01" placeholder="Ex: 1.75" class="mt-1 block w-full" :value="old('height')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('height')" />
                            </div>

                            <div>
                                <x-input-label for="gender" :value="__('Gênero')" />
                                <div class="mt-2 flex gap-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="gender" value="M" class="text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('gender') == 'M' ? 'checked' : '' }} required>
                                        <span class="ml-2 text-sm text-gray-600">Masculino</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="gender" value="F" class="text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('gender') == 'F' ? 'checked' : '' }} required>
                                        <span class="ml-2 text-sm text-gray-600">Feminino</span>
                                    </label>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="health_notes" :value="__('Observações de Saúde / Restrições')" />
                            <textarea id="health_notes" name="health_notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm">{{ old('health_notes') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('health_notes')" />
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('students.index') }}" class="text-sm text-slate-400 hover:text-slate-600 font-bold uppercase tracking-widest">
                                Cancelar
                            </a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                                {{ __('Cadastrar Aluno') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>