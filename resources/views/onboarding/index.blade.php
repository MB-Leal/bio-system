<x-guest-layout>
    <div class="max-w-7xl mx-auto" x-data="{ gender: 'F' }">
        
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black text-slate-800 tracking-tighter uppercase">Ficha de Avaliação Inicial</h1>
            <p class="text-slate-500 text-lg">Bio-System: Inteligência em Composição Corporal</p>
        </div>

        <form action="{{ route('onboarding.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="bg-white p-8 md:p-12 rounded-[40px] shadow-sm border border-slate-100">
                <h2 class="text-2xl font-black text-slate-800 mb-8 flex items-center gap-4">
                    <span class="bg-blue-600 text-white w-10 h-10 rounded-2xl flex items-center justify-center text-lg shadow-lg shadow-blue-200">1</span>
                    Dados Pessoais
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="lg:col-span-2">
                        <x-input-label value="Nome Completo" />
                        <x-text-input name="name" class="w-full mt-2" required />
                    </div>
                    <div>
                        <x-input-label value="Data de Nascimento" />
                        <x-text-input type="date" name="birth_date" class="w-full mt-2" required />
                    </div>
                    <div>
                        <x-input-label value="Sexo" />
                        <select name="gender" x-model="gender" class="w-full mt-2 border-slate-200 rounded-2xl focus:ring-blue-500 h-[46px]">
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                    <div class="lg:col-span-2">
                        <x-input-label value="E-mail" />
                        <x-text-input type="email" name="email" class="w-full mt-2" required />
                    </div>
                    <div class="lg:col-span-2">
                        <x-input-label value="Telefone / WhatsApp" />
                        <x-text-input name="phone" placeholder="(00) 00000-0000" class="w-full mt-2" />
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 md:p-12 rounded-[40px] shadow-sm border border-slate-100">
                <h2 class="text-2xl font-black text-slate-800 mb-8 flex items-center gap-4">
                    <span class="bg-emerald-500 text-white w-10 h-10 rounded-2xl flex items-center justify-center text-lg shadow-lg shadow-emerald-100">2</span>
                    Avaliação Corporal (cm)
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    <div class="lg:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-6">
                        @php
                            $medidas = [
                                'height' => 'Altura (m)', 'weight' => 'Peso (kg)', 'bust' => 'Busto',
                                'waist' => 'Cintura', 'abdomen' => 'Abdômen', 'hip' => 'Quadril',
                                'right_arm' => 'Braço Dir.', 'left_arm' => 'Braço Esq.', 'right_thigh' => 'Coxa D.',
                                'left_thigh' => 'Coxa Esq.', 'right_calf' => 'Panturrilha. Dir.', 'left_calf' => 'Panturrilha. Esq.'
                            ];
                        @endphp
                        @foreach($medidas as $key => $label)
                        <div>
                            <x-input-label value="{{ $label }}" />
                            <x-text-input name="{{ $key }}" step="0.01" type="number" class="w-full mt-2" />
                        </div>
                        @endforeach
                    </div>
                    <div class="lg:col-span-5 bg-slate-50 p-8 rounded-[32px] border border-slate-200 text-center">
                        <p class="text-xs font-black text-slate-400 uppercase mb-6 tracking-widest">Guia de Medição Corporal</p>
                        <img src="{{ asset('imagens/guia-medidas.png') }}" class="rounded-2xl shadow-2xl mx-auto border-8 border-white max-h-[450px] object-contain">
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 p-8 md:p-12 rounded-[40px] shadow-2xl text-white">
                <h2 class="text-2xl font-black text-blue-400 mb-8 flex items-center gap-4">
                    <span class="bg-blue-400 text-slate-900 w-10 h-10 rounded-2xl flex items-center justify-center text-lg">3</span>
                    Dados da Balança (Bioimpedância)
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                    @php
                        $bio = [
                            'bmi' => 'IMC', 'body_fat_pct' => '% Gordura', 'fat_mass_kg' => 'Massa Gord.',
                            'muscle_mass_pct' => 'Massa Musc.', 'lean_mass_kg' => 'Massa Magra',
                            'body_water_pct' => 'Água Corp.', 'visceral_fat' => 'Gord. Visc.',
                            'bone_mass' => 'Massa Óssea', 'bmr' => 'Taxa Metab.', 'metabolic_age' => 'Idade Metab.'
                        ];
                    @endphp
                    @foreach($bio as $key => $label)
                    <div>
                        <label class="text-[10px] font-black text-slate-500 uppercase mb-2 block">{{ $label }}</label>
                        <input type="number" step="0.1" name="{{ $key }}" class="w-full bg-slate-800 border-slate-700 rounded-2xl text-white focus:ring-blue-400 focus:border-blue-400 py-3">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-center pt-8">
                <x-primary-button class="h-20 w-full md:w-96 text-xl justify-center rounded-[30px] shadow-2xl shadow-blue-200 transition-all hover:scale-105">
                    Finalizar Cadastro
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>