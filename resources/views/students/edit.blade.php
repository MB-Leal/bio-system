<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase italic tracking-tighter">
                Editar Ficha: {{ $student->name }}
            </h2>
            <a href="{{ route('students.show', $student) }}" class="text-xs font-black text-slate-400 uppercase hover:text-slate-600 transition-colors">Voltar ao Perfil</a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ has_fracture: {{ old('has_fracture', $student->has_fracture) ? 'true' : 'false' }} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-2xl shadow-sm">
                <p class="font-bold">Verifique os campos abaixo:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PATCH')

                <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 italic">1. Identificação Básica</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-2">
                            <x-input-label value="Nome Completo" />
                            <x-text-input name="name" :value="old('name', $student->name)" required class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="WhatsApp" />
                            <x-text-input name="phone" :value="old('phone', $student->phone)" required class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Célula (CL)" />
                            <x-text-input name="cell_group" :value="old('cell_group', $student->cell_group)" class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="E-mail" />
                            <x-text-input name="email" type="email" :value="old('email', $student->email)" required class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Data de Nascimento" />
                            <x-text-input name="birth_date" type="date" :value="old('birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : '')" required class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Gênero" />
                            <select name="gender" class="w-full mt-1 border-slate-200 rounded-2xl">
                                <option value="M" {{ old('gender', $student->gender) == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('gender', $student->gender) == 'F' ? 'selected' : '' }}>Feminino</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label value="Grupo / Turma" />
                            <select name="group_id" class="w-full mt-1 border-slate-200 rounded-2xl">
                                <option value="">Sem Grupo</option>
                                @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id', $student->group_id) == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 italic">2. Referências Iniciais</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label value="Peso Inicial (kg) - Cadastro" />
                            <x-text-input name="weight" type="number" step="0.1" :value="old('weight', $student->weight)" required class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Altura (m)" />
                            <x-text-input name="height" type="number" step="0.01" :value="old('height', $student->height)" required class="w-full mt-1" />
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 italic">3. Saúde e Hábitos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label value="Tempo sentado por dia" />
                            <x-text-input name="sitting_time" :value="old('sitting_time', $student->sitting_time)" class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Atividade Física atual" />
                            <x-text-input name="physical_activity" :value="old('physical_activity', $student->physical_activity)" class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Cirurgias realizadas" />
                            <textarea name="surgeries" rows="2" class="w-full mt-1 border-slate-200 rounded-2xl">{{ old('surgeries', $student->surgeries) }}</textarea>
                        </div>
                        <div>
                            <x-input-label value="Problemas Ortopédicos" />
                            <textarea name="orthopedic_issues" rows="2" class="w-full mt-1 border-slate-200 rounded-2xl">{{ old('orthopedic_issues', $student->orthopedic_issues) }}</textarea>
                        </div>

                        <div class="md:col-span-2 p-6 bg-slate-50 rounded-3xl border border-slate-100 space-y-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="has_fracture" x-model="has_fracture" class="rounded text-blue-600">
                                <span class="ml-3 text-xs font-black text-slate-700 uppercase italic">Possui histórico de fraturas ou implantes?</span>
                            </label>

                            <div x-show="has_fracture" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label value="Onde (Local)" />
                                    <x-text-input name="fracture_location" :value="old('fracture_location', $student->fracture_location)" class="w-full mt-1" />
                                </div>
                                <div>
                                    <x-input-label value="Data aproximada" />
                                    <x-text-input name="fracture_date" :value="old('fracture_date', $student->fracture_date)" class="w-full mt-1" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100 mt-8">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 italic">
                        4. Correção de Medidas Iniciais (Marco Zero)
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <x-input-label value="Busto (cm)" />
                            <x-text-input name="bust" type="number" step="0.1" :value="old('bust', $student->bust)" class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Cintura (cm)" />
                            <x-text-input name="waist" type="number" step="0.1" :value="old('waist', $student->waist)" class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Abdômen (cm)" />
                            <x-text-input name="abdomen" type="number" step="0.1" :value="old('abdomen', $student->abdomen)" class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="Quadril (cm)" />
                            <x-text-input name="hip" type="number" step="0.1" :value="old('hip', $student->hip)" class="w-full mt-1" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-center pb-20">
                    <button type="submit" class="h-20 w-full md:w-96 bg-slate-900 text-white rounded-[30px] font-black uppercase tracking-[0.2em] shadow-2xl hover:bg-blue-600 transition-all">
                        Atualizar Dados
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>