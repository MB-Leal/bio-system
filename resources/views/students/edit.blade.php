<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Perfil: ') }} {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('students.update', $student) }}" method="POST" class="space-y-8">
                @csrf
                @method('PATCH')

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 border-b pb-2">Dados Pessoais</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="name" :value="__('Nome Completo')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $student->name)" required />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('E-mail')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $student->email)" required />
                        </div>
                        <div>
                            <x-input-label for="phone" :value="__('WhatsApp')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $student->phone)" />
                        </div>
                        <div>
                            <x-input-label for="birth_date" :value="__('Data de Nascimento')" />
                            <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $student->birth_date?->format('Y-m-d'))" required />
                        </div>
                        <div>
                            <x-input-label for="gender" :value="__('Sexo')" />
                            <select id="gender" name="gender" class="mt-1 block w-full border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="M" {{ old('gender', $student->gender) == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('gender', $student->gender) == 'F' ? 'selected' : '' }}>Feminino</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 border-b pb-2">Estilo de Vida e Saúde</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div>
                                <x-input-label value="Atividade Física" />
                                <x-text-input name="physical_activity" class="w-full mt-1" :value="old('physical_activity', $student->physical_activity)" />
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                <input type="checkbox" name="is_smoker" value="1" {{ old('is_smoker', $student->is_smoker) ? 'checked' : '' }} class="rounded text-blue-600">
                                <span class="text-sm font-bold text-slate-700">Fumante?</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <x-input-label value="Histórico de Cirurgias" />
                                <textarea name="surgeries" class="w-full mt-1 border-slate-200 rounded-2xl focus:ring-blue-500" rows="2">{{ old('surgeries', $student->surgeries) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                @if($student->gender === 'F')
                <div class="bg-rose-50/50 p-8 rounded-[40px] shadow-sm border border-rose-100">
                    <h3 class="text-lg font-bold text-rose-700 mb-6 border-b border-rose-200 pb-2">Saúde Feminina</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-rose-100">
                            <input type="checkbox" name="is_pregnant" value="1" {{ old('is_pregnant', $student->is_pregnant) ? 'checked' : '' }} class="rounded text-rose-500">
                            <span class="text-sm font-bold text-rose-700">Gestante?</span>
                        </div>
                        <div>
                            <x-input-label value="Anticoncepcional" class="text-rose-700" />
                            <x-text-input name="contraception_method" class="w-full mt-1" :value="old('contraception_method', $student->contraception_method)" />
                        </div>
                    </div>
                </div>
                @endif

                <div class="flex items-center justify-end gap-4 p-4">
                    <a href="{{ route('students.index') }}" class="text-sm font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Cancelar</a>
                    <x-primary-button class="h-14 px-10 rounded-2xl shadow-lg shadow-blue-100">Salvar Alterações</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>