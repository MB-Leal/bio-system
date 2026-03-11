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
                                <th class="py-4 px-2 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($students as $student)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-2">
                                    <div class="font-bold text-slate-800">{{ $student->name }}</div>
                                    <div class="text-xs text-slate-400 font-medium">{{ $student->email }}</div>
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
                                            <a href="{{ $student->evaluations->sortByDesc('evaluation_date')->first()->getWhatsappUrl() }}" 
                                               target="_blank" 
                                               class="text-green-500 hover:scale-110 transition-transform">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
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

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Link do relatório copiado para a área de transferência!');
    });
}
</script>