<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ranking: {{ $group->name }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 bg-slate-900 text-white">
                    <h3 class="text-lg font-black uppercase tracking-tighter">🔥 Top Evolução</h3>
                    <p class="text-slate-400 text-xs">Maior perda de % de gordura</p>
                </div>
                
                <div class="p-6 space-y-4">
                    @foreach($fatLossRanking as $index => $item)
                        <div class="flex items-center justify-between p-4 {{ $index < 3 ? 'bg-blue-50 border border-blue-100' : 'bg-slate-50' }} rounded-2xl">
                            <div class="flex items-center gap-4">
                                <span class="text-lg font-black {{ $index == 0 ? 'text-yellow-500' : ($index == 1 ? 'text-slate-400' : ($index == 2 ? 'text-amber-600' : 'text-slate-300')) }}">
                                    #{{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $item['name'] }}</p>
                                    <p class="text-[10px] text-slate-500 uppercase">Início: {{ $item['initial'] }}% • Atual: {{ $item['current'] }}%</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xl font-black text-blue-600">-{{ $item['diff'] }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 bg-emerald-600 text-white">
                    <h3 class="text-lg font-black uppercase tracking-tighter">📅 Top Frequência</h3>
                    <p class="text-emerald-100 text-xs">Alunos mais presentes nos treinos</p>
                </div>

                <div class="p-6 space-y-4">
                    @foreach($attendanceRanking as $index => $item)
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                            <div class="flex items-center gap-4">
                                <span class="text-lg font-black text-slate-300">#{{ $index + 1 }}</span>
                                <p class="font-bold text-slate-800">{{ $item['name'] }}</p>
                            </div>
                            <div class="text-right flex items-center gap-3">
                                <div class="hidden md:block w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full" style="width: {{ $item['rate'] }}%"></div>
                                </div>
                                <span class="font-black text-emerald-600">{{ $item['rate'] }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>