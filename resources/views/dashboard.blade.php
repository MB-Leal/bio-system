<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel de Gestão') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Alunos Ativos</span>
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <h4 class="text-3xl font-black text-slate-800 mt-2">{{ $totalStudents }}</h4>
            </div>

            <a href="{{ route('students.index') }}" class="block transform transition hover:scale-105">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-amber-200 bg-amber-50">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Novos Cadastros</span>
                        <span class="px-2 py-1 bg-white text-xs font-bold rounded-full shadow-sm">{{ $newStudents }}</span>
                    </div>
                    <h4 class="text-3xl font-black text-slate-800 mt-2">{{ $newStudents }}</h4>
                    <p class="text-[10px] text-slate-500 mt-2 uppercase">Aguardando alocação em grupo</p>
                </div>
            </a>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Avaliações (Mês Atual)</span>
                <h4 class="text-3xl font-black text-emerald-600 mt-2">{{ $evaluationsThisMonth }}</h4>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 italic">⚠️ Avaliações Pendentes (+30 dias)</h3>
                </div>

                <div class="divide-y divide-slate-50">
                    @forelse($pendingEvaluations as $student)
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-700">{{ $student->name }}</p>
                            <p class="text-[10px] text-slate-400 uppercase italic">
                                Última: {{ $student->evaluations->sortByDesc('evaluation_date')->first()?->evaluation_date->format('d/m/Y') ?? 'Nunca avaliado' }}
                            </p>
                        </div>
                        <a href="{{ route('students.evaluations.create', $student) }}" class="text-xs font-bold text-blue-600 hover:underline">Avaliar agora</a>
                    </div>
                    @empty
                    <div class="p-10 text-center text-slate-400 text-sm italic">Tudo em dia! Todos os alunos foram avaliados recentemente.</div>
                    @endforelse
                </div>

                <div class="p-8 bg-slate-50/50 border-t border-slate-100">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-2 h-4 bg-emerald-500 rounded-full"></span>
                        Ranking de Frequência (Top 5)
                    </h3>
                    <div class="space-y-4">
                        @foreach($ranking as $student)
                        <div class="flex items-center gap-4 p-4 bg-white rounded-3xl border border-slate-100 shadow-sm">
                            <div class="w-8 h-8 bg-blue-600 text-white rounded-xl flex items-center justify-center font-black text-xs">
                                {{ $loop->iteration }}º
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800">{{ $student->name }}</p>
                                <p class="text-[10px] font-black text-blue-500 uppercase">{{ $student->cell_group ?? 'Sem CL' }}</p>
                                <p class="text-[10px] text-slate-400 uppercase font-bold">{{ $student->attendances_count }} Presenças</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[40px] shadow-xl p-8 text-white">
                <h3 class="font-black uppercase tracking-tighter text-blue-400 mb-8 text-center italic">🏆 Destaques do Mês (Evolução)</h3>
                <div class="space-y-4">
                    @foreach($topPerformers as $eval)
                    @php
                    // Proteção: busca o peso inicial do cadastro do aluno
                    $pInicial = $eval->student?->weight ?? 0;
                    $diff = $pInicial > 0 ? ($eval->weight - $pInicial) : 0;
                    @endphp
                    <div class="flex items-center gap-4 bg-slate-800 p-4 rounded-3xl border border-slate-700 transition-hover hover:scale-[1.02]">
                        <div class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center font-black text-sm italic shadow-lg shadow-blue-900/20">
                            {{ $loop->iteration }}º
                        </div>
                        <div class="flex-1">
                            <p class="font-black text-sm text-white">
                                {{ $eval->student->name ?? $eval->name ?? 'Nome indisponível' }}
                            </p>
                            <p class="text-[10px] text-slate-400 uppercase font-bold">
                                Atual: {{ number_format($eval->weight, 1) }}kg
                                @if($diff != 0)
                                ({{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }}kg total)
                                @endif
                            </p>
                        </div>
                        <div class="text-emerald-400 font-black text-xs uppercase tracking-widest italic">
                            {{ $diff <= 0 ? 'Evoluindo!' : 'Foco!' }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>