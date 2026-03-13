<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ficha do Aluno: {{ $student->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('students.edit', $student) }}" class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold uppercase hover:bg-slate-50 transition-all">Editar Perfil</a>
                <a href="{{ route('students.evaluations.create', $student) }}" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-bold uppercase hover:bg-blue-700 transition-all">Nova Avaliação</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 space-y-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 text-center">
                        <div class="w-24 h-24 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-3xl font-black mx-auto mb-4">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">{{ $student->name }}</h3>
                        <p class="text-sm text-slate-500">{{ $student->group->name ?? 'Sem Grupo' }}</p>
                        
                        <div class="mt-6 pt-6 border-t border-slate-50 grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <span class="block text-[10px] font-black text-slate-400 uppercase">Idade</span>
                                <span class="font-bold">{{ \Carbon\Carbon::parse($student->birth_date)->age }} anos</span>
                            </div>
                            <div class="text-center border-l border-slate-50">
                                <span class="block text-[10px] font-black text-slate-400 uppercase">Altura</span>
                                <span class="font-bold">{{ $student->height }}m</span>
                            </div>
                        </div>
                    </div>

                    @if($latestEvaluation && $latestEvaluation->exam_pdf_path)
                    <div class="bg-slate-900 p-6 rounded-3xl shadow-xl text-white">
                        <h4 class="text-xs font-black uppercase text-blue-400 mb-4 tracking-widest">Quadro Clínico</h4>
                        <div class="flex items-center gap-4 bg-slate-800 p-4 rounded-2xl border border-slate-700">
                            <svg class="w-8 h-8 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2zm10-12a1 1 0 110 2h-4a1 1 0 110-2h4z"/></svg>
                            <div class="flex-1 overflow-hidden">
                                <p class="text-xs font-bold truncate">Exame_Anexado.pdf</p>
                                <p class="text-[10px] text-slate-500">PDF Recebido</p>
                            </div>
                            <a href="{{ asset('storage/' . $latestEvaluation->exam_pdf_path) }}" target="_blank" class="text-blue-400 hover:text-blue-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                            <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Anamnese e Histórico de Saúde
                            </h3>
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                            <div class="space-y-4">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase">Estilo de Vida</h4>
                                <div>
                                    <p class="text-xs text-slate-500">Atividade Física:</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $student->physical_activity ?? 'Não informado' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Alimentação:</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $student->diet_type ?? 'Não informado' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Fumante?</p>
                                    <p class="text-sm font-bold {{ $student->is_smoker ? 'text-rose-500' : 'text-emerald-500' }}">{{ $student->is_smoker ? 'Sim' : 'Não' }}</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase">Saúde e Riscos</h4>
                                <div>
                                    <p class="text-xs text-slate-500">Hipertensão:</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $student->is_hypertensive ? 'Sim' : 'Não' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Diabetes:</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $student->is_diabetic ? 'Sim' : 'Não' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Metais no Corpo:</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $student->metals_in_body ?? 'Nenhum' }}</p>
                                </div>
                            </div>

                            @if($student->gender == 'F')
                            <div class="md:col-span-2 bg-rose-50 p-6 rounded-2xl border border-rose-100">
                                <h4 class="text-[10px] font-black text-rose-400 uppercase mb-4">Saúde Feminina</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div>
                                        <p class="text-[10px] text-rose-300 uppercase">Gestante?</p>
                                        <p class="text-sm font-bold text-rose-700">{{ $student->is_pregnant ? 'Sim' : 'Não' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-rose-300 uppercase">Ciclo Regular?</p>
                                        <p class="text-sm font-bold text-rose-700">{{ $student->regular_cycle ? 'Sim' : 'Não' }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-[10px] text-rose-300 uppercase">Anticoncepcional?</p>
                                        <p class="text-sm font-bold text-rose-700">{{ $student->contraception_method ?? 'Não usa' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-50">
                            <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest italic">Histórico de Resultados</h3>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-[10px] uppercase font-black text-slate-400">
                                <tr>
                                    <th class="p-4">Data</th>
                                    <th class="p-4">Peso</th>
                                    <th class="p-4">% Gordura</th>
                                    <th class="p-4">Cintura</th>
                                    <th class="p-4 text-right">Relatório</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($evaluations as $eval)
                                <tr>
                                    <td class="p-4 text-sm font-bold text-slate-600">{{ $eval->evaluation_date->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm text-slate-700">{{ $eval->weight }}kg</td>
                                    <td class="p-4 text-sm text-slate-700">{{ $eval->body_fat_pct }}%</td>
                                    <td class="p-4 text-sm text-slate-700">{{ $eval->waist ?? '--' }}cm</td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('public.report', $eval->hash_slug) }}" target="_blank" class="text-blue-600 hover:underline text-xs font-bold">Ver Online</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>