<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase tracking-tighter italic">Ranking por Célula (CL)</h2>
            
            <form action="{{ route('ranking.cl') }}" method="GET" id="clFilter">
                <select name="cl" onchange="document.getElementById('clFilter').submit()" class="rounded-2xl border-slate-200 text-xs font-bold uppercase">
                    @for ($i = 1; $i <= 38; $i++)
                        @php $val = 'CL' . str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                        <option value="{{ $val }}" {{ $selectedCl == $val ? 'selected' : '' }}>{{ $val }}</option>
                    @endfor
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <h3 class="text-center text-2xl font-black text-slate-800 mb-8 uppercase">Líderes de Frequência: {{ $selectedCl }}</h3>
                
                <div class="space-y-4">
                    @forelse($ranking as $index => $student)
                    <div class="flex items-center justify-between p-6 {{ $index < 3 ? 'bg-blue-50 border border-blue-100' : 'bg-slate-50' }} rounded-[30px] transition-all hover:scale-[1.02]">
                        <div class="flex items-center gap-6">
                            <span class="text-2xl font-black {{ $index == 0 ? 'text-yellow-500' : ($index == 1 ? 'text-slate-400' : ($index == 2 ? 'text-orange-400' : 'text-slate-300')) }}">
                                #{{ $index + 1 }}
                            </span>
                            <div>
                                <p class="text-lg font-black text-slate-800">{{ $student->name }}</p>
                                <p class="text-xs font-bold text-slate-500">
                                    Última presença: 
                                    {{ $student->attendances->first() ? $student->attendances->first()->created_at->format('d/m/Y') : 'Nenhuma' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-black text-blue-600">{{ $student->attendances_count }}</p>
                            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Treinos</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 font-bold py-10">Nenhum aluno encontrado para esta CL.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>