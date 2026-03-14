<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Ficha de Anamnese: ') }} {{ $student->name }}
            </h2>
            <a href="{{ route('students.show', $student) }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest">Voltar ao Perfil</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PATCH')
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
                    <p class="font-bold">Atenção! Verifique os seguintes erros:</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tighter flex items-center gap-2">
                        <span class="w-2 h-8 bg-blue-600 rounded-full"></span>
                        Dados Pessoais
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-2">
                            <x-input-label for="name" :value="__('Nome Completo')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $student->name)" required />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('E-mail')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $student->email)" required />
                        </div>
                        <div>
                            <x-input-label for="phone" :value="__('WhatsApp')" />
                            <x-text-input
                                name="phone"
                                maxlength="11"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                placeholder="Ex: 91981223344"
                                class="w-full mt-1"
                                :value="old('phone', $student->phone ?? '')" />
                        </div>
                        <div>
                            <x-input-label for="birth_date" :value="__('Data de Nascimento')" />
                            <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $student->birth_date?->format('Y-m-d'))" required />
                        </div>
                        <div>
                            <x-input-label for="gender" :value="__('Gênero')" />
                            <select name="gender" class="mt-1 block w-full border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="M" {{ old('gender', $student->gender) == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('gender', $student->gender) == 'F' ? 'selected' : '' }}>Feminino</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="height" :value="__('Altura Base (m)')" />
                            <x-text-input name="height" type="number" step="0.01" class="mt-1 block w-full" :value="old('height', $student->height)" />
                        </div>
                        <div>
                            <x-input-label value="Peso Inicial (kg)" />
                            <x-text-input name="weight" type="number" step="0.1" class="w-full mt-1" :value="old('weight', $student->weight)" placeholder="Ex: 85.5" />
                            <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold italic text-center">Peso base do cadastro</p>
                        </div>
                        <div>
                            <x-input-label for="group_id" :value="__('Grupo')" />
                            <select name="group_id" class="mt-1 block w-full border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="">Sem Grupo</option>
                                @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id', $student->group_id) == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tighter flex items-center gap-2">
                        <span class="w-2 h-8 bg-emerald-500 rounded-full"></span>
                        Estilo de Vida
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label value="Tempo permanecendo sentada" />
                            <x-text-input name="sitting_time" class="w-full mt-1" :value="old('sitting_time', $student->sitting_time)" />
                        </div>
                        <div>
                            <x-input-label value="Atividade Física / Frequência" />
                            <x-text-input name="physical_activity" class="w-full mt-1" :value="old('physical_activity', $student->physical_activity)" />
                        </div>
                        <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl">
                            <input type="checkbox" name="is_smoker" value="1" {{ old('is_smoker', $student->is_smoker) ? 'checked' : '' }} class="rounded text-blue-600">
                            <span class="text-sm font-bold text-slate-700">É fumante?</span>
                        </div>
                        <div>
                            <x-input-label value="Tipo de Alimentação" />
                            <x-text-input name="diet_type" class="w-full mt-1" :value="old('diet_type', $student->diet_type)" />
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tighter flex items-center gap-2">
                        <span class="w-2 h-8 bg-purple-600 rounded-full"></span>
                        Histórico Médico e Saúde
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label value="Cirurgias Anteriores" />
                            <textarea name="surgeries" rows="2" class="w-full mt-1 border-slate-200 rounded-2xl">{{ old('surgeries', $student->surgeries) }}</textarea>
                        </div>
                        <div>
                            <x-input-label value="Alergias Conhecidas" />
                            <textarea name="allergies" rows="2" class="w-full mt-1 border-slate-200 rounded-2xl">{{ old('allergies', $student->allergies) }}</textarea>
                        </div>

                        <div class="md:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl cursor-pointer">
                                <input type="checkbox" name="is_hypertensive" value="1" {{ old('is_hypertensive', $student->is_hypertensive) ? 'checked' : '' }}>
                                <span class="text-xs font-bold uppercase">Hipertensão</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl cursor-pointer">
                                <input type="checkbox" name="is_diabetic" value="1" {{ old('is_diabetic', $student->is_diabetic) ? 'checked' : '' }}>
                                <span class="text-xs font-bold uppercase">Diabetes</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl cursor-pointer">
                                <input type="checkbox" name="has_pacemaker" value="1" {{ old('has_pacemaker', $student->has_pacemaker) ? 'checked' : '' }}>
                                <span class="text-xs font-bold uppercase">Marcapasso</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl cursor-pointer">
                                <input type="checkbox" name="is_epileptic" value="1" {{ old('is_epileptic', $student->is_epileptic) ? 'checked' : '' }}>
                                <span class="text-xs font-bold uppercase">Epilepsia</span>
                            </label>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label value="Outras Observações de Saúde / Restrições" />
                            <textarea name="health_notes" rows="3" class="w-full mt-1 border-slate-200 rounded-2xl">{{ old('health_notes', $student->health_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 p-8 rounded-[40px] shadow-xl text-white">
                    <h3 class="text-lg font-black text-blue-400 mb-6 uppercase tracking-tighter flex items-center gap-2">
                        <span class="w-2 h-8 bg-blue-400 rounded-full"></span>
                        Quadro Clínico (PDF)
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div>
                            <p class="text-sm text-slate-400 mb-4">Gerencie os exames e documentos anexados pelo aluno.</p>
                            @php
                            $latestEval = $student->evaluations->sortByDesc('evaluation_date')->first();
                            @endphp

                            @if($latestEval && $latestEval->exam_pdf_path)
                            <div class="flex items-center gap-4 bg-slate-800 p-4 rounded-2xl border border-slate-700 mb-4">
                                <svg class="w-8 h-8 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 18h12a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2zm10-12a1 1 0 110 2h-4a1 1 0 110-2h4z" />
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs font-bold">Exame Atual</p>
                                    <a href="{{ asset('storage/' . $latestEval->exam_pdf_path) }}" target="_blank" class="text-[10px] text-blue-400 underline uppercase font-black">Visualizar PDF</a>
                                </div>
                            </div>
                            @else
                            <div class="p-4 bg-slate-800/50 rounded-2xl border border-dashed border-slate-700 text-center text-xs text-slate-500 uppercase font-black">
                                Nenhum PDF anexado
                            </div>
                            @endif
                        </div>

                        <div>
                            <x-input-label value="Substituir / Adicionar Novo PDF" class="text-slate-400" />
                            <input type="file" name="exam_pdf" accept="application/pdf" class="mt-2 block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        </div>
                    </div>
                </div>

                @if($student->gender === 'F')
                <div class="bg-rose-50/50 p-8 rounded-[40px] shadow-sm border border-rose-100">
                    <h3 class="text-lg font-bold text-rose-700 mb-6 uppercase tracking-tighter flex items-center gap-2">
                        <span class="w-2 h-8 bg-rose-500 rounded-full"></span>
                        Saúde Feminina
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <label class="flex items-center gap-3 p-4 bg-white rounded-2xl border border-rose-100 cursor-pointer">
                            <input type="checkbox" name="is_pregnant" value="1" {{ old('is_pregnant', $student->is_pregnant) ? 'checked' : '' }} class="rounded text-rose-500">
                            <span class="text-sm font-bold text-rose-700">Gestante?</span>
                        </label>
                        <div>
                            <x-input-label value="Filhos (Quantidade)" class="text-rose-700" />
                            <x-text-input name="children_count" type="number" class="w-full mt-1 border-rose-100" :value="old('children_count', $student->children_count)" />
                        </div>
                        <div>
                            <x-input-label value="Método Anticoncepcional" class="text-rose-700" />
                            <x-text-input name="contraception_method" class="w-full mt-1 border-rose-100" :value="old('contraception_method', $student->contraception_method)" />
                        </div>
                    </div>
                </div>
                @endif

                <div class="flex items-center justify-end gap-4 pt-4 pb-12">
                    <a href="{{ route('students.index') }}" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Cancelar</a>
                    <x-primary-button class="h-16 px-12 rounded-3xl shadow-xl shadow-blue-100 text-lg">
                        {{ __('Salvar Alterações') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>