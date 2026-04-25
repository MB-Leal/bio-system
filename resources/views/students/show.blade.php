<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black shadow-lg">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="font-black text-2xl text-slate-800 leading-tight">{{ $student->name }}</h2>
                    <p class="text-sm text-slate-500 font-medium">Aluno desde {{ $student->created_at->format('d/m/Y') }} • Grupo: {{ $student->group->name ?? 'Sem Grupo' }}</p>
                </div>
            </div>

            <div class="flex gap-3">
                @php
                // 1. O Peso Inicial é SEMPRE o que está na ficha do aluno (Tabela Students)
                $pesoInicial = (float) ($student->weight ?? 0);

                // 2. Buscamos a avaliação mais recente ORDENADA PELA DATA (ou ID se preferir)
                // Usamos 'desc' para pegar a última criada
                $latest = $student->evaluations()->orderBy('evaluation_date', 'desc')->latest()->first();

                // 3. O Peso Atual DEVE ser o da última avaliação.
                // Se ainda não houver nenhuma avaliação, usamos o peso inicial do cadastro.
                $pesoAtual = $latest ? (float) $latest->weight : $pesoInicial;

                // 4. A Diferença (Evolução Real)
                $diff = $pesoAtual - $pesoInicial;
                @endphp

                @if($latest && $latest->hash_slug)
                @php
                $waMsg = urlencode("Olá " . $student->name . "! Sua evolução no BioSystem está atualizada. Confira aqui: " . route('public.report', ['slug' => $latest->hash_slug]));
                $waLink = "https://wa.me/55" . preg_replace('/[^0-9]/', '', $student->phone) . "?text=" . $waMsg;
                @endphp
                <a href="{{ $waLink }}" target="_blank" class="bg-emerald-500 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase hover:bg-emerald-600 transition-all">
                    Enviar WhatsApp
                </a>
                @endif
                <a href="{{ route('students.evaluations.create', $student) }}" class="bg-slate-900 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-lg shadow-slate-200">
                    Nova Avaliação
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <div class="text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Peso Inicial</p>
                    <p class="text-2xl font-black text-slate-700">{{ number_format($pesoInicial, 1, ',', '.') }} kg</p>
                </div>
                <div class="text-center border-l border-slate-50">
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Peso Atual</p>
                    <p class="text-2xl font-black text-blue-600">{{ number_format($pesoAtual, 1, ',', '.') }} kg</p>
                </div>
                <div class="text-center border-l border-slate-50">
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Evolução Real</p>
                    <p class="text-2xl font-black {{ $diff <= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                        {{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1, ',', '.') }} kg
                    </p>
                </div>
                <div class="text-center border-l border-slate-50">
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Gordura Atual</p>
                    <p class="text-2xl font-black text-slate-700">{{ $latest->body_fat_pct ?? '--' }}%</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-8 border-b border-slate-50 bg-slate-50/50">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest italic">Histórico de Avaliações</h3>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/30 text-[10px] uppercase font-black text-slate-300">
                                <tr>
                                    <th class="px-8 py-4">Data</th>
                                    <th class="px-8 py-4">Peso</th>
                                    <th class="px-8 py-4">% Gordura</th>
                                    <th class="px-8 py-4 text-right">Relatórios</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($student->evaluations()->orderBy('evaluation_date', 'desc')->get() as $eval)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-5 text-sm font-black text-slate-700">{{ $eval->evaluation_date->format('d/m/Y') }}</td>
                                    <td class="px-8 py-5 text-sm font-bold text-slate-600">{{ number_format($eval->weight, 1, ',', '.') }} kg</td>
                                    <td class="px-8 py-5 text-sm font-bold text-blue-600">{{ $eval->body_fat_pct }} %</td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('public.report', $eval->hash_slug) }}" target="_blank" class="text-[10px] font-black text-blue-500 uppercase tracking-widest hover:underline">Web</a>
                                            <a href="{{ route('evaluations.pdf', $eval) }}" class="text-[10px] font-black text-rose-500 uppercase tracking-widest hover:underline">PDF</a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-10 text-center text-slate-400 italic">Nenhuma avaliação realizada.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-slate-900 p-8 rounded-[40px] shadow-xl text-white">
                        <h3 class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-6">Ficha Clínica</h3>
                        <div class="space-y-6">
                            @if($student->surgeries)
                            <div>
                                <p class="text-[9px] font-black text-slate-500 uppercase mb-1 italic">Cirurgias</p>
                                <p class="text-xs font-bold text-slate-200">{{ $student->surgeries }}</p>
                            </div>
                            @endif
                            @if($student->orthopedic_issues)
                            <div>
                                <p class="text-[9px] font-black text-slate-500 uppercase mb-1 italic">Limitações</p>
                                <p class="text-xs font-bold text-slate-200">{{ $student->orthopedic_issues }}</p>
                            </div>
                            @endif
                            @if($student->has_fracture)
                            <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl">
                                <p class="text-[9px] font-black text-rose-400 uppercase mb-1">Histórico de Fratura</p>
                                <p class="text-xs font-bold text-rose-100">{{ $student->fracture_location }} ({{ $student->fracture_date }})</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Contacto</h3>
                        <p class="text-sm font-bold text-slate-700">{{ $student->phone }}</p>
                        <p class="text-xs font-medium text-slate-400">{{ $student->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>