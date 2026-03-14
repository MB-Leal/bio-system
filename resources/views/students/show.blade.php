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
        // Definimos a variável $latest aqui caso o Controller não a tenha enviado
        $latest = $student->evaluations()->latest('evaluation_date')->first();
    @endphp

    @if($latest && $latest->hash_slug)
        @php
            $waMsg = urlencode("Olá " . $student->name . "! A tua evolução no BioSystem está atualizada. Podes conferir os resultados aqui: " . route('public.report', ['slug' => $latest->hash_slug]));
            $waLink = "https://wa.me/55" . preg_replace('/[^0-9]/', '', $student->phone) . "?text=" . $waMsg;
        @endphp

        <a href="{{ $waLink }}" target="_blank" class="bg-emerald-500 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-100 flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.634 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
            Enviar Resultados
        </a>
    @endif

                <a href="{{ route('students.evaluations.create', $student) }}" class="bg-slate-900 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                    Nova Avaliação
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-8">

                    <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Peso Inicial</p>
                            <p class="text-xl font-black text-slate-700">{{ $first->weight ?? '--' }}kg</p>
                        </div>
                        <div class="text-center border-l border-slate-50">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Peso Atual</p>
                            <p class="text-xl font-black text-blue-600">{{ $latest->weight ?? '--' }}kg</p>
                        </div>
                        <div class="text-center border-l border-slate-50">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Evolução</p>
                            @php $diff = ($latest->weight ?? 0) - ($first->weight ?? 0); @endphp
                            <p class="text-xl font-black {{ $diff <= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }}kg
                            </p>
                        </div>
                        <div class="text-center border-l border-slate-50">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Gordura</p>
                            <p class="text-xl font-black text-slate-700">{{ $latest->body_fat_pct ?? '--' }}%</p>
                        </div>
                    </div>

                    <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 flex items-center gap-2">
                            <span class="w-2 h-4 bg-purple-600 rounded-full"></span>
                            Histórico de Saúde & Anamnese
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase">Condições Específicas</label>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @if($student->is_smoker) <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold">FUMANTE</span> @endif
                                        @if($student->is_hypertensive) <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-bold">HIPERTENSO</span> @endif
                                        @if($student->is_diabetic) <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold">DIABÉTICO</span> @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase">Cirurgias / Tratamentos</label>
                                    <p class="text-sm text-slate-700 font-medium mt-1">{{ $student->surgeries ?? 'Nada declarado' }}</p>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase">Observações Ortopédicas</label>
                                    <p class="text-sm text-slate-700 font-medium mt-1">{{ $student->orthopedic_issues ?? 'Sem restrições' }}</p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase">Notas Adicionais</label>
                                    <p class="text-sm text-slate-600 italic mt-1">{{ $student->health_notes ?? 'Sem observações' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-8 border-b border-slate-50">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest italic">Linha do Tempo de Avaliações</h3>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-[10px] uppercase font-black text-slate-400">
                                <tr>
                                    <th class="px-8 py-4">Data</th>
                                    <th class="px-8 py-4">Peso</th>
                                    <th class="px-8 py-4">% Gordura</th>
                                    <th class="px-8 py-4 text-right">Relatórios</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($evaluations as $eval)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-5 text-sm font-bold text-slate-700">{{ $eval->evaluation_date->format('d/m/Y') }}</td>
                                    <td class="px-8 py-5 text-sm font-medium text-slate-600">{{ $eval->weight }} kg</td>
                                    <td class="px-8 py-5 text-sm font-medium text-blue-600">{{ $eval->body_fat_pct }}%</td>
                                    <td class="px-8 py-5 text-right flex justify-end gap-3">
                                        <a href="{{ route('public.report', $eval->hash_slug) }}" target="_blank" class="text-blue-600 hover:underline text-[10px] font-black uppercase">Web</a>
                                        <a href="{{ route('evaluations.pdf', $eval) }}" class="text-rose-500 hover:underline text-[10px] font-black uppercase">PDF</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-slate-400 italic text-sm">Nenhuma avaliação realizada ainda.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-slate-900 p-8 rounded-[40px] shadow-xl text-white">
                        <h3 class="text-xs font-black text-blue-400 uppercase tracking-widest mb-6 italic">Exames do Cadastro</h3>
                        @if($student->exam_pdf_path)
                        <div class="flex items-center justify-between p-4 bg-slate-800 rounded-2xl border border-slate-700">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-rose-500/20 text-rose-400 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-tighter">Exame Inicial.pdf</span>
                            </div>
                            <a href="{{ asset('storage/' . $student->exam_pdf_path) }}" target="_blank" class="text-[10px] font-black bg-white text-slate-900 px-3 py-1 rounded-lg uppercase">Abrir</a>
                        </div>
                        @else
                        <div class="text-center py-6 border border-dashed border-slate-700 rounded-3xl">
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest">Nenhum anexo</p>
                        </div>
                        @endif
                    </div>

                    <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Contacto</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase">E-mail</p>
                                <p class="text-sm font-bold text-slate-700">{{ $student->email }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase">WhatsApp</p>
                                <p class="text-sm font-bold text-slate-700">{{ $student->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>