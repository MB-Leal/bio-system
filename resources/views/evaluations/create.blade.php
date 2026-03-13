<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nova Avaliação: <span class="text-blue-600">{{ $student->name }}</span>
            </h2>
            <a href="{{ route('students.show', $student) }}" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600">Voltar ao Perfil</a>
        </div>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('students.evaluations.store', $student) }}" method="POST" enctype="multipart/form-data" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @csrf
            
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <x-input-label for="evaluation_date" value="Data da Avaliação" />
                        <x-text-input type="date" name="evaluation_date" class="w-full mt-2" required value="{{ date('Y-m-d') }}" />
                    </div>
                    <div>
                        <x-input-label for="weight" value="Peso Atual (kg)" />
                        <x-text-input type="number" step="0.1" name="weight" class="w-full mt-2" required placeholder="00.0" />
                    </div>
                    <div class="flex items-end pb-2">
                        <p class="text-xs text-slate-400 italic">Preencha os dados abaixo para gerar o comparativo de evolução.</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 p-8 md:p-10 rounded-[40px] shadow-2xl text-white">
                <h3 class="text-blue-400 font-black uppercase text-xs tracking-widest mb-8 flex items-center gap-2">
                    <span class="w-2 h-5 bg-blue-400 rounded-full"></span>
                    1. Indicadores da Balança (Bioimpedância)
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    @php
                        $bioFields = [
                            'bmi' => 'IMC', 'body_fat_pct' => '% Gordura', 'fat_mass_kg' => 'Massa Gord. (kg)',
                            'muscle_mass_pct' => 'Massa Musc. (%)', 'lean_mass_kg' => 'Massa Magra (kg)',
                            'body_water_pct' => 'Água Corp. (%)', 'visceral_fat' => 'Gord. Visceral',
                            'bone_mass' => 'Massa Óssea', 'bmr' => 'Taxa Metab. (TMB)', 'metabolic_age' => 'Idade Metab.'
                        ];
                    @endphp
                    @foreach($bioFields as $key => $label)
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase mb-2 block tracking-widest">{{ $label }}</label>
                            <input type="number" step="0.1" name="{{ $key }}" class="w-full bg-slate-800 border-slate-700 rounded-2xl text-white focus:ring-blue-400 focus:border-blue-400 py-3">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-[40px] shadow-sm border border-slate-100">
                <h3 class="text-emerald-500 font-black uppercase text-xs tracking-widest mb-8 flex items-center gap-2">
                    <span class="w-2 h-5 bg-emerald-500 rounded-full"></span>
                    2. Medidas de Fita (cm)
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @php
                        $medidas = [
                            'bust' => 'Busto', 'waist' => 'Cintura', 'abdomen' => 'Abdômen', 'hip' => 'Quadril',
                            'neck' => 'Pescoço', 'right_arm' => 'Braço D.', 'left_arm' => 'Braço E.',
                            'right_thigh' => 'Coxa D.', 'left_thigh' => 'Coxa E.',
                            'right_calf' => 'Pant. D.', 'left_calf' => 'Pant. E.'
                        ];
                    @endphp
                    @foreach($medidas as $key => $label)
                        <div>
                            <x-input-label value="{{ $label }}" />
                            <x-text-input type="number" step="0.1" name="{{ $key }}" class="w-full mt-2" placeholder="00.0" />
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-slate-50 p-8 rounded-[40px] border border-slate-200">
                <h3 class="text-slate-500 font-black uppercase text-xs tracking-widest mb-8 flex items-center gap-2">
                    <span class="w-2 h-5 bg-slate-400 rounded-full"></span>
                    3. Quadro Clínico e Exames (PDF)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="space-y-4">
                        <p class="text-xs font-bold text-slate-500 uppercase">Documento Atual do Aluno:</p>
                        @php
                            $lastEvalWithPdf = $student->evaluations()->whereNotNull('exam_pdf_path')->orderBy('evaluation_date', 'desc')->first();
                        @endphp
                        
                        @if($lastEvalWithPdf)
                            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-slate-200 shadow-sm">
                                <div class="bg-rose-100 p-3 rounded-2xl text-rose-600">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2zm10-12a1 1 0 110 2h-4a1 1 0 110-2h4z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-black text-slate-700">Exame_Anterior.pdf</p>
                                    <p class="text-[10px] text-slate-400">Enviado em {{ $lastEvalWithPdf->evaluation_date->format('d/m/Y') }}</p>
                                </div>
                                <a href="{{ asset('storage/' . $lastEvalWithPdf->exam_pdf_path) }}" target="_blank" class="bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase">Ver PDF</a>
                            </div>
                        @else
                            <div class="p-6 bg-white rounded-3xl border border-dashed border-slate-300 text-center">
                                <p class="text-[10px] font-black text-slate-400 uppercase">Nenhum exame anexado anteriormente</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <x-input-label value="Anexar Novo Exame para esta Avaliação" />
                        <input type="file" name="exam_pdf" accept="application/pdf" class="mt-3 block w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer shadow-sm" />
                    </div>
                </div>
            </div>

            <div class="flex justify-center pt-4 pb-12">
                <x-primary-button class="w-full md:w-96 justify-center h-20 text-xl rounded-3xl shadow-2xl shadow-blue-200 transition-transform hover:scale-105">
                    Salvar e Gerar Relatório
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>