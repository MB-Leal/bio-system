<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gerenciamento de Alunos') }}
            </h2>
            <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-all shadow-sm">
                Novo Aluno
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 font-medium rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 text-[10px] uppercase font-black tracking-widest">
                                <th class="py-4 px-2">Aluno</th>
                                <th class="py-4 px-2">Status / Grupo</th>
                                <th class="py-4 px-2">Última Avaliação</th>
                                <th class="p-4 text-[10px] uppercase font-black text-slate-400 tracking-widest">Célula</th>
                                <th class="py-4 px-2 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($students as $student)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-2">
                                    <a href="{{ route('students.show', $student) }}" class="group">
                                        <div class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                            {{ $student->name }}
                                        </div>
                                        <div class="text-xs text-slate-400 font-medium">
                                            {{ $student->email }}
                                        </div>
                                    </a>
                                </td>
                                <td class="py-4 px-2">
                                    @if($student->group)
                                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase border border-blue-100">
                                        {{ $student->group->name }}
                                    </span>
                                    @else
                                    <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-bold uppercase border border-amber-100">
                                        Aguardando Grupo
                                    </span>
                                    @endif
                                </td>
                                <td class="py-4 px-2 text-sm text-slate-500 font-medium">
                                    {{ $student->evaluations->first()?->evaluation_date->format('d/m/Y') ?? 'Nenhuma' }}
                                </td>
                                <td class="p-4">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase">
                                        {{ $student->cell_group ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-4 px-2">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('students.evaluations.create', $student) }}"
                                            class="bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-tighter transition-all">
                                            Avaliar
                                        </a>

                                        <a href="{{ route('students.edit', $student) }}"
                                            class="bg-slate-100 text-slate-600 hover:bg-slate-200 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-tighter transition-all">
                                            Editar
                                        </a>

                                        @if($student->evaluations->isNotEmpty())
                                        @php $latestEval = $student->evaluations->sortByDesc('evaluation_date')->first(); @endphp
                                        <a href="{{ route('public.report', $latestEval->hash_slug) }}"
                                            target="_blank"
                                            title="Abrir Relatório Público"
                                            class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white p-2 rounded-xl transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-400 italic">
                                    Nenhum aluno cadastrado ainda.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>