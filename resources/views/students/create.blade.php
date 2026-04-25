<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase italic tracking-tighter">
                {{ __('Cadastrar Novo Aluno') }}
            </h2>
            <a href="{{ route('students.index') }}" class="text-xs font-black text-slate-400 uppercase hover:text-slate-600 transition-colors">Voltar</a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ has_fracture: false }">
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

                <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 italic">1. Dados Pessoais</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-2">
                            <x-input-label value="Nome Completo" />
                            <x-text-input name="name" :value="old('name')" required class="w-full mt-1" placeholder="Ex: João Silva" />
                        </div>
                        <div>
                            <x-input-label value="WhatsApp (DDD + Número)" />
                            <x-text-input name="phone" :value="old('phone')" required class="w-full mt-1" placeholder="91999999999" />
                        </div>
                        <div>
                            <x-input-label value="Célula (CL)" />
                            <x-text-input name="cell_group" :value="old('cell_group')" class="w-full mt-1" placeholder="Ex: CL01" />
                        </div>
                        <div class="lg:col-span-2">
                            <x-input-label value="E-mail" />
                            <x-text-input name="email" type="email" :value="old('email')" required class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Data de Nascimento" />
                            <x-text-input name="birth_date" type="date" :value="old('birth_date')" required class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Gênero" />
                            <select name="gender" class="w-full mt-1 border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Feminino</option>
                                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <x-input-label value="Atribuir a um Grupo / Turma" />
                            <select name="group_id" class="w-full mt-1 border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="">-- Selecione um Grupo (Opcional) --</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 italic">2. Medidas de Referência (Cadastro)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label value="Altura (m) - Ex: 1.75" />
                            <x-text-input name="height" type="number" step="0.01" :value="old('height')" required class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Peso Inicial (kg) - Ex: 80.5" />
                            <x-text-input name="weight" type="number" step="0.1" :value="old('weight')" required class="w-full mt-1" />
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 italic">3. Saúde e Estilo de Vida</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label value="Tempo sentado por dia" />
                            <x-text-input name="sitting_time" :value="old('sitting_time')" class="w-full mt-1" placeholder="Ex: 8 horas" />
                        </div>
                        <div>
                            <x-input-label value="Atividade Física atual" />
                            <x-text-input name="physical_activity" :value="old('physical_activity')" class="w-full mt-1" placeholder="Ex: Caminhada 3x na semana" />
                        </div>
                        <div>
                            <x-input-label value="Cirurgias Realizadas" />
                            <textarea name="surgeries" rows="2" class="w-full mt-1 border-slate-200 rounded-2xl">{{ old('surgeries') }}</textarea>
                        </div>
                        <div>
                            <x-input-label value="Problemas Ortopédicos / Limitações" />
                            <textarea name="orthopedic_issues" rows="2" class="w-full mt-1 border-slate-200 rounded-2xl">{{ old('orthopedic_issues') }}</textarea>
                        </div>

                        <div class="md:col-span-2 p-6 bg-slate-50 rounded-3xl border border-slate-100 space-y-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="has_fracture" x-model="has_fracture" class="rounded text-blue-600">
                                <span class="ml-3 text-xs font-black text-slate-700 uppercase italic">Possui histórico de fraturas ou implantes?</span>
                            </label>
                            
                            <div x-show="has_fracture" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4" x-cloak>
                                <div>
                                    <x-input-label value="Onde (Local da Fratura/Implante)" />
                                    <x-text-input name="fracture_location" :value="old('fracture_location')" class="w-full mt-1" />
                                </div>
                                <div>
                                    <x-input-label value="Data Aproximada" />
                                    <x-text-input name="fracture_date" :value="old('fracture_date')" class="w-full mt-1" placeholder="Ex: Jan/2023" />
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label value="Observações Adicionais de Saúde" />
                            <textarea name="health_notes" rows="3" class="w-full mt-1 border-slate-200 rounded-2xl">{{ old('health_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 p-10 rounded-[40px] shadow-xl text-white">
                    <h3 class="text-xs font-black text-blue-400 uppercase tracking-widest mb-4 italic">4. Documentação Clínica</h3>
                    <p class="text-xs text-slate-500 mb-6 uppercase font-bold">Anexe o exame clínico inicial ou laudo (PDF), se houver.</p>
                    <input type="file" name="exam_pdf" accept="application/pdf" class="block w-full text-sm text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                </div>

                <div class="flex justify-center pb-20">
                    <button type="submit" class="h-20 w-full md:w-96 bg-slate-900 text-white rounded-[30px] font-black uppercase tracking-[0.2em] shadow-2xl hover:bg-blue-600 transition-all">
                        {{ __('Finalizar Cadastro') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>