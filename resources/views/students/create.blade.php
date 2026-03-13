<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Novo Aluno (Ficha de Anamnese)') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ gender: 'F' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-2xl shadow-sm">
                <p class="font-bold">Verifique os campos abaixo:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tighter flex items-center gap-2">
                        <span class="w-2 h-8 bg-blue-600 rounded-full"></span>
                        1. Dados Pessoais
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-2">
                            <x-input-label value="Nome Completo" />
                            <x-text-input name="name" class="w-full mt-1" required autofocus :value="old('name')" />
                        </div>
                        <div>
                            <x-input-label value="E-mail" />
                            <x-text-input name="email" type="email" class="w-full mt-1" required :value="old('email')" />
                        </div>
                        <div>
                            <x-input-label value="WhatsApp (Apenas números)" />
                            <x-text-input
                                name="phone"
                                maxlength="11"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                placeholder="Ex: 91981223344"
                                class="w-full mt-1"
                                :value="old('phone')" />
                        </div>
                        <div>
                            <x-input-label value="Data de Nascimento" />
                            <x-text-input name="birth_date" type="date" class="w-full mt-1" required :value="old('birth_date')" />
                        </div>
                        <div>
                            <x-input-label value="Sexo" />
                            <select name="gender" x-model="gender" class="w-full mt-1 border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Feminino</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label value="Altura (m)" />
                            <x-text-input
                                name="height"
                                type="number"
                                step="0.01"
                                placeholder="Ex: 1.75"
                                class="w-full mt-1"
                                :value="old('height')"
                                required />
                        </div>
                        <div>
                            <x-input-label value="Grupo" />
                            <select name="group_id" class="w-full mt-1 border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="">Sem Grupo</option>
                                @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tighter flex items-center gap-2">
                        <span class="w-2 h-8 bg-purple-600 rounded-full"></span>
                        2. Histórico de Saúde
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        @php
                        $checks = [
                        'is_smoker' => 'Fumante',
                        'is_hypertensive' => 'Hipertenso',
                        'is_diabetic' => 'Diabético',
                        'has_pacemaker' => 'Marcapasso',
                        'is_epileptic' => 'Epilético'
                        ];
                        @endphp
                        @foreach($checks as $key => $label)
                        <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl cursor-pointer hover:bg-slate-100 transition-all">
                            <input type="checkbox" name="{{ $key }}" value="1" {{ old($key) ? 'checked' : '' }} class="rounded text-purple-600 focus:ring-purple-500">
                            <span class="text-xs font-bold uppercase text-slate-600">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label value="Cirurgias ou Tratamentos" />
                            <textarea name="surgeries" rows="3" class="w-full mt-1 border-slate-200 rounded-2xl focus:ring-purple-500">{{ old('surgeries') }}</textarea>
                        </div>
                        <div>
                            <x-input-label value="Observações Adicionais" />
                            <textarea name="health_notes" rows="3" class="w-full mt-1 border-slate-200 rounded-2xl focus:ring-purple-500">{{ old('health_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 p-8 rounded-[40px] shadow-xl text-white">
                    <h3 class="text-lg font-black text-blue-400 mb-4 uppercase tracking-tighter">3. Quadro Clínico (PDF)</h3>
                    <p class="text-xs text-slate-500 mb-6 uppercase font-bold">Anexe o exame clínico inicial do aluno, se houver.</p>
                    <input type="file" name="exam_pdf" accept="application/pdf" class="block w-full text-sm text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                </div>

                <div class="flex justify-center pt-4">
                    <x-primary-button class="h-16 w-full md:w-96 justify-center rounded-3xl text-lg shadow-xl shadow-blue-100">
                        Cadastrar Aluno
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>