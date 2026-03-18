<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Ficha de Anamnese: ') }} {{ $student->name }}
            </h2>
            <a href="{{ route('students.show', $student) }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest">Voltar ao Perfil</a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ gender: '{{ old('gender', $student->gender) }}', hasFracture: {{ old('has_fracture', $student->has_fracture) ? 'true' : 'false' }} }">
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
                            <x-text-input name="phone" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ex: 91981223344" class="w-full mt-1" :value="old('phone', $student->phone)" />
                        </div>
                        <div>
                            <x-input-label for="birth_date" :value="__('Data de Nascimento')" />
                            <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : '')" required />
                        </div>
                        <div>
                            <x-input-label for="gender" :value="__('Gênero')" />
                            <select name="gender" x-model="gender" class="mt-1 block w-full border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                        </div>
                        
                        <div>
                            <x-input-label value="Célula (Casais Labaredas)" />
                            <select name="cell_group" class="mt-1 block w-full border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="Não">Não participo</option>
                                @for ($i = 1; $i <= 38; $i++)
                                    @php $val = 'CL' . str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                    <option value="{{ $val }}" {{ old('cell_group', $student->cell_group) == $val ? 'selected' : '' }}>{{ $val }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <x-input-label for="height" :value="__('Altura Base (m)')" />
                            <x-text-input name="height" type="number" step="0.01" class="mt-1 block w-full" :value="old('height', $student->height)" />
                        </div>
                        <div>
                            <x-input-label value="Peso Inicial (kg)" />
                            <x-text-input name="weight" type="number" step="0.1" class="w-full mt-1" :value="old('weight', $student->weight)" />
                        </div>
                        <div>
                            <x-input-label for="group_id" :value="__('Grupo de Treino')" />
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
                        <div class="md:col-span-2">
                            <x-input-label value="Observações sobre Alimentação" />
                            <x-text-input name="diet_type" class="w-full mt-1" :value="old('diet_type', $student->diet_type)" />
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tighter flex items-center gap-2">
                        <span class="w-2 h-8 bg-purple-600 rounded-full"></span>
                        Histórico Médico e Lesões
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <x-input-label value="Cirurgias Anteriores" />
                            <textarea name="surgeries" rows="2" class="w-full mt-1 border-slate-200 rounded-2xl">{{ old('surgeries', $student->surgeries) }}</textarea>
                        </div>
                        <div>
                            <x-input-label value="Problemas Ortopédicos / Restrições" />
                            <textarea name="orthopedic_issues" rows="2" class="w-full mt-1 border-slate-200 rounded-2xl">{{ old('orthopedic_issues', $student->orthopedic_issues) }}</textarea>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 rounded-[32px] border border-slate-100">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="hasFracture" name="has_fracture" value="1" {{ old('has_fracture', $student->has_fracture) ? 'checked' : '' }} class="rounded text-blue-600">
                            <span class="text-sm font-black text-slate-700 uppercase italic">Histórico de Fraturas?</span>
                        </label>

                        <div x-show="hasFracture" x-transition class="mt-6 space-y-4 border-t border-slate-200 pt-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label value="Local da fratura" />
                                    <x-text-input name="fracture_location" :value="old('fracture_location', $student->fracture_location)" class="w-full mt-1 text-sm" />
                                </div>
                                <div>
                                    <x-input-label value="Data aproximada" />
                                    <x-text-input name="fracture_date" :value="old('fracture_date', $student->fracture_date)" class="w-full mt-1 text-sm" />
                                </div>
                            </div>
                            <div>
                                <x-input-label value="Presença de implantes (Pinos, placas ou parafusos?)" />
                                <x-text-input name="implants_details" :value="old('implants_details', $student->implants_details)" class="w-full mt-1 text-sm" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 p-8 rounded-[40px] shadow-xl text-white">
                    <h3 class="text-lg font-black text-blue-400 mb-6 uppercase tracking-tighter flex items-center gap-2">
                        <span class="w-2 h-8 bg-blue-400 rounded-full"></span>
                        Exames e Documentos (PDF)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div>
                            @php $latestEval = $student->evaluations->sortByDesc('evaluation_date')->first(); @endphp
                            @if($latestEval && $latestEval->exam_pdf_path)
                            <div class="flex items-center gap-4 bg-slate-800 p-4 rounded-2xl border border-slate-700">
                                <svg class="w-8 h-8 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2zm10-12a1 1 0 110 2h-4a1 1 0 110-2h4z" /></svg>
                                <div class="flex-1">
                                    <p class="text-xs font-bold">Arquivo Atual</p>
                                    <a href="{{ asset('storage/' . $latestEval->exam_pdf_path) }}" target="_blank" class="text-[10px] text-blue-400 underline uppercase font-black">Visualizar Exame</a>
                                </div>
                            </div>
                            @else
                            <div class="p-4 bg-slate-800/50 rounded-2xl border border-dashed border-slate-700 text-center text-xs text-slate-500 uppercase font-black">Nenhum PDF anexado</div>
                            @endif
                        </div>
                        <div>
                            <x-input-label value="Substituir PDF de Exame" class="text-slate-400" />
                            <input type="file" name="exam_pdf" accept="application/pdf" class="mt-2 block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        </div>
                    </div>
                </div>

                <div x-show="gender === 'F'" x-transition class="bg-rose-50/50 p-8 rounded-[40px] shadow-sm border border-rose-100">
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

                <div class="flex items-center justify-end gap-4 pt-4 pb-12">
                    <a href="{{ route('students.show', $student) }}" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Descartar</a>
                    <x-primary-button class="h-16 px-12 rounded-3xl shadow-xl shadow-blue-100 text-lg">
                        {{ __('Atualizar Ficha') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>