<x-guest-layout>
    <div class="py-12 bg-slate-50 min-h-screen" x-data="{ gender: 'F' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-12">
                <h1 class="text-4xl font-black text-slate-800 tracking-tighter uppercase">Ficha de Avaliação Inicial</h1>
                <p class="text-slate-500 text-lg">Bio-System: Inteligência em Composição Corporal</p>
            </div>

            <form action="{{ route('onboarding.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="bg-white p-8 md:p-10 rounded-[40px] shadow-sm border border-slate-100">
                    <h2 class="text-2xl font-black text-slate-800 mb-8 flex items-center gap-3">
                        <span class="bg-blue-600 text-white w-10 h-10 rounded-2xl flex items-center justify-center text-base shadow-lg shadow-blue-100">1</span>
                        Dados Pessoais
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-2">
                            <x-input-label value="Nome Completo" />
                            <x-text-input name="name" class="w-full mt-1" required />
                        </div>
                        <div>
                            <x-input-label value="Data de Nascimento" />
                            <x-text-input type="date" name="birth_date" class="w-full mt-1" required />
                        </div>
                        <div>
                            <x-input-label value="Sexo" />
                            <select name="gender" x-model="gender" class="w-full mt-1 border-slate-200 rounded-2xl focus:ring-blue-500 h-[46px]">
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <x-input-label value="E-mail" />
                            <x-text-input type="email" name="email" class="w-full mt-1" />
                        </div>
                        <div class="lg:col-span-2">
                            <x-input-label value="WhatsApp" />
                            <x-text-input
                                name="phone"
                                maxlength="11"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                placeholder="Ex: 91988887777"
                                class="w-full mt-1"
                                :value="old('phone', $student->phone ?? '')" />
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 md:p-10 rounded-[40px] shadow-sm border border-slate-100">
                    <h2 class="text-2xl font-black text-slate-800 mb-8 flex items-center gap-3">
                        <span class="bg-emerald-500 text-white w-10 h-10 rounded-2xl flex items-center justify-center text-base shadow-lg shadow-emerald-100">2</span>
                        Medidas de Fita (cm)
                    </h2>
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-12">
                        <div class="xl:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-5">
                            @php
                            $medidas = [
                            'height' => 'Altura (m)', 'weight' => 'Peso (kg)', 'bust' => 'Busto',
                            'waist' => 'Cintura', 'abdomen' => 'Abdômen', 'hip' => 'Quadril',
                            'right_arm' => 'Braço Dir.', 'left_arm' => 'Braço Esq.', 'right_thigh' => 'Coxa Dir.',
                            'left_thigh' => 'Coxa Esq.', 'right_calf' => 'Panturrilha. Dir.', 'left_calf' => 'Panturrilha. Esq.'
                            ];
                            @endphp
                            @foreach($medidas as $key => $label)
                            <div>
                                <x-input-label value="{{ $label }}" />
                                <x-text-input name="{{ $key }}" step="0.01" type="number" class="w-full mt-1" />
                            </div>
                            @endforeach
                        </div>
                        <div class="xl:col-span-5 bg-slate-50 p-8 rounded-[32px] border border-slate-200 flex flex-col items-center justify-center">
                            <p class="text-xs font-black text-slate-400 uppercase mb-6 tracking-widest text-center">Referência para Medidas</p>
                            <img src="{{ asset('imagens/guia-medidas.png') }}" class="rounded-2xl shadow-xl w-full max-w-sm border-4 border-white">
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 p-8 md:p-10 rounded-[40px] shadow-xl text-white">
                    <h2 class="text-2xl font-black text-blue-400 mb-8 flex items-center gap-3">
                        <span class="bg-blue-400 text-slate-900 w-10 h-10 rounded-2xl flex items-center justify-center text-base">3</span>
                        Dados da Balança (Bioimpedância)
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                        @php
                        $bioFields = [
                        'bmi' => 'IMC', 'body_fat_pct' => '% Gordura', 'fat_mass_kg' => 'Massa Gordura',
                        'muscle_mass_pct' => 'Massa Muscular', 'lean_mass_kg' => 'Massa Magra',
                        'body_water_pct' => 'Água Corporal', 'visceral_fat' => 'Gord. Visceral',
                        'bone_mass' => 'Massa Óssea', 'bmr' => 'Taxa Metabólica', 'metabolic_age' => 'Idade Metabólica'
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
                    <h2 class="text-2xl font-black text-slate-800 mb-8 flex items-center gap-3">
                        <span class="bg-purple-600 text-white w-10 h-10 rounded-2xl flex items-center justify-center text-base shadow-lg shadow-purple-100">4</span>
                        Anamnese e Estilo de Vida
                    </h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <div class="space-y-6">
                            <h3 class="font-black text-slate-400 uppercase text-[10px] tracking-widest border-b pb-2">Hábitos</h3>
                            <div><x-input-label value="Permanece muito tempo sentada?" /><x-text-input name="sitting_time" class="w-full mt-1" /></div>
                            <div><x-input-label value="Atividade física? Quais?" /><x-text-input name="physical_activity" class="w-full mt-1" /></div>
                            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl">
                                <input type="checkbox" name="is_smoker" class="rounded text-purple-600"> <span class="text-sm font-bold text-slate-700">É fumante?</span>
                            </div>
                        </div>

                        <div class="space-y-4" x-data="{ sur: false, ort: false }">
                            <h3 class="font-black text-slate-400 uppercase text-[10px] tracking-widest border-b pb-2">Saúde Geral</h3>
                            <div class="p-4 bg-slate-50 rounded-2xl">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" x-model="sur" name="has_surgery" class="rounded text-purple-600">
                                    <span class="text-sm font-bold text-slate-700">Cirurgias Anteriores?</span>
                                </label>
                                <div x-show="sur" x-transition class="mt-3">
                                    <x-text-input name="surgeries" placeholder="Quais?" class="w-full text-sm" />
                                </div>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" x-model="ort" name="has_ortho" class="rounded text-purple-600">
                                    <span class="text-sm font-bold text-slate-700">Problemas Ortopédicos?</span>
                                </label>
                                <div x-show="ort" x-transition class="mt-3">
                                    <x-text-input name="orthopedic_issues" placeholder="Quais?" class="w-full text-sm" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="gender === 'F'" x-transition class="mt-12 pt-10 border-t border-rose-100">
                        <h3 class="font-black text-rose-500 uppercase text-[10px] tracking-widest mb-6 italic">Saúde Feminina</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="flex items-center gap-3 p-4 bg-rose-50 rounded-2xl">
                                <input type="checkbox" name="is_pregnant" class="rounded text-rose-500"> <span class="text-sm font-bold text-rose-700">Gestante?</span>
                            </div>
                            <div><x-input-label value="Filhos (Nº)" /><x-text-input type="number" name="children_count" class="w-full mt-1" /></div>
                            <div class="md:col-span-2"><x-input-label value="Anticoncepcional (Qual?)" /><x-text-input name="contraception_method" class="w-full mt-1" /></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 md:p-10 rounded-[40px] shadow-sm border border-slate-100">
                    <h2 class="text-2xl font-black text-slate-800 mb-8 flex items-center gap-3">
                        <span class="bg-slate-800 text-white w-10 h-10 rounded-2xl flex items-center justify-center text-base shadow-lg shadow-slate-100">5</span>
                        Quadro Clínico (Anexar Exame)
                    </h2>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-44 border-2 border-slate-300 border-dashed rounded-[32px] cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-12 h-12 mb-4 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="mb-2 text-sm text-slate-500 font-bold">Clique para enviar ou arraste o seu exame (PDF)</p>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest">Tamanho máximo: 10MB</p>
                            </div>
                            <input name="exam_pdf" type="file" class="hidden" accept="application/pdf" />
                        </label>
                    </div>
                </div>

                <div class="flex justify-center pb-20">
                    <x-primary-button class="h-20 w-full md:w-1/2 text-xl justify-center rounded-[32px] shadow-2xl shadow-blue-200 hover:scale-105 transition-transform">
                        Finalizar e Salvar Avaliação
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>