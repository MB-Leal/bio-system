<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Aluno: ') }} {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('students.update', $student) }}" method="POST" class="space-y-6 max-w-2xl">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Nome Completo')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $student->name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('E-mail')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $student->email)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="group_id" :value="__('Grupo / Desafio')" />
                                <select id="group_id" name="group_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- Sem Grupo --</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" {{ old('group_id', $student->group_id) == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('group_id')" />
                            </div>

                            <div>
                                <x-input-label for="gender" :value="__('Sexo')" />
                                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="M" {{ old('gender', $student->gender) == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('gender', $student->gender) == 'F' ? 'selected' : '' }}>Feminino</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                            </div>

                            <div>
                                <x-input-label for="birth_date" :value="__('Data de Nascimento')" />
                                <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $student->birth_date)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                            </div>

                            <div>
                                <x-input-label for="height" :value="__('Altura (m)')" />
                                <x-text-input id="height" name="height" type="number" step="0.01" class="mt-1 block w-full" :value="old('height', $student->height)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('height')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="health_notes" :value="__('Observações de Saúde / Restrições')" />
                            <textarea id="health_notes" name="health_notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('health_notes', $student->health_notes) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('health_notes')" />
                        </div>

                        <div class="flex items-center gap-4 border-t border-gray-100 pt-6">
                            <x-primary-button>{{ __('Guardar Alterações') }}</x-primary-button>
                            <a href="{{ route('students.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>