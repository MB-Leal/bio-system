<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nova Avaliação: <span class="text-blue-600">{{ $student->name }}</span>
            </h2>
            <div class="flex items-center gap-4">
                <span class="text-[10px] font-black uppercase text-slate-400">Altura Base: {{ $student->height }}m</span>
                <a href="{{ route('students.show', $student) }}" class="text-xs font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest">Voltar</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ 
        weight: 0, 
        fat_pct: 0, 
        height: {{ $student->height ?? 0 }},
        get bmi() { return (this.weight / (this.height * this.height)).toFixed(2) },
        get fat_kg() { return ((this.weight * this.fat_pct) / 100).toFixed(2) },
        get lean_kg() { return (this.weight - this.fat_kg).toFixed(2) }
    }">
        <form action="{{ route('students.evaluations.store', $student) }}" method="POST" enctype="multipart/form-data" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @csrf

            <div class="bg-amber-50 p-6 rounded-[32px] border border-amber-100 flex gap-6 items-center">
                <div class="bg-amber-100 p-3 rounded-2xl text-amber-600 font-bold">ALERTA</div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 flex-1">
                    <div>
                        <p class="text-[10px] font-black text-amber-700 uppercase">Lesões/Dores</p>
                        <p class="text-xs text-amber-900">{{ $student->orthopedic_issues ?? 'Nenhuma informada' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-amber-700 uppercase">Restrições</p>
                        <p class="text-xs text-amber-900">{{ $student->health_notes ?? 'Nenhuma' }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-8">

                    <div class="bg-slate-900 p-8 rounded-[40px] shadow-xl text-white">
                        <h3 class="text-blue-400 font-black uppercase text-xs tracking-widest mb-8">1. Composição Corporal (Balança)</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label value="Peso (kg)" class="text-slate-400" />
                                <input type="number" step="0.1" name="weight" x-model="weight" class="w-full mt-1 bg-slate-800 border-slate-700 rounded-2xl text-white py-3" required>
                            </div>
                            <div>
                                <x-input-label value="% Gordura" class="text-slate-400" />
                                <input type="number" step="0.1" name="body_fat_pct" x-model="fat_pct" class="w-full mt-1 bg-slate-800 border-slate-700 rounded-2xl text-white py-3" required>
                            </div>
                            <div>
                                <x-input-label value="Gordura Visceral" class="text-slate-400" />
                                <x-text-input type="number" name="visceral_fat" class="w-full mt-1 bg-slate-800 border-slate-700 text-white" />
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-3 gap-4 border-t border-slate-800 pt-8">
                            <div class="text-center">
                                <p class="text-[10px] font-black text-slate-500 uppercase">IMC</p>
                                <p class="text-2xl font-black text-white" x-text="bmi"></p>
                            </div>
                            <div class="text-center">
                                <p class="text-[10px] font-black text-slate-500 uppercase">Massa Gorda</p>
                                <p class="text-2xl font-black text-rose-400" x-text="fat_kg + 'kg'"></p>
                            </div>
                            <div class="text-center">
                                <p class="text-[10px] font-black text-slate-500 uppercase">Massa Magra</p>
                                <p class="text-2xl font-black text-emerald-400" x-text="lean_kg + 'kg'"></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                        <h3 class="text-emerald-500 font-black uppercase text-xs tracking-widest mb-8">2. Perímetros (cm)</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            @php
                            $campos = [
                            'waist' => 'Cintura', 'abdomen' => 'Abdômen', 'hip' => 'Quadril',
                            'right_arm' => 'Braço D.', 'left_arm' => 'Braço E.',
                            'right_thigh' => 'Coxa D.', 'left_thigh' => 'Coxa E.'
                            ];
                            @endphp
                            @foreach($campos as $key => $label)
                            <div>
                                <x-input-label value="{{ $label }}" />
                                <x-text-input type="number" step="0.1" name="{{ $key }}" class="w-full mt-1" />
                                @if($latestEvaluation && $latestEvaluation->$key)
                                <span class="text-[10px] text-slate-400 font-bold uppercase italic">Anterior: {{ $latestEvaluation->$key }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 sticky top-8">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Último Resultado</h3>

                        @if($latestEvaluation)
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-[10px] font-black text-slate-400 uppercase">Data</span>
                                <span class="text-sm font-bold">{{ $latestEvaluation->evaluation_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-[10px] font-black text-slate-400 uppercase">Peso</span>
                                <span class="text-sm font-bold text-blue-600">{{ $latestEvaluation->weight }}kg</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-[10px] font-black text-slate-400 uppercase">Gordura</span>
                                <span class="text-sm font-bold text-rose-500">{{ $latestEvaluation->body_fat_pct }}%</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-[10px] font-black text-slate-400 uppercase">Massa Musc.</span>
                                <span class="text-sm font-bold text-emerald-500">{{ $latestEvaluation->muscle_mass_pct }}%</span>
                            </div>
                        </div>
                        @else
                        <div class="text-center p-6 border-2 border-dashed border-slate-200 rounded-3xl">
                            <p class="text-xs text-slate-400 font-bold uppercase">Primeira Avaliação</p>
                        </div>
                        @endif

                        <div class="mt-8">
                            <x-primary-button class="w-full justify-center h-16 rounded-3xl shadow-xl shadow-blue-100">
                                Salvar Avaliação
                            </x-primary-button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>