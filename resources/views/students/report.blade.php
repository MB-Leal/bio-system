<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase tracking-tighter">
                Análise Comparativa: {{ $student->name }}
            </h2>
            <a href="{{ route('students.show', $student) }}" class="text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600">Voltar ao Perfil</a>
        </div>
    </x-slot>

    <div class="py-12 space-y-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $first = $evaluations->first();
                    $last = $evaluations->last();
                    $weightDiff = $last->weight - $first->weight;
                    $fatDiff = $last->body_fat_pct - $first->body_fat_pct;
                @endphp
                
                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 text-center">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Variação de Peso</span>
                    <p class="text-3xl font-black mt-2 {{ $weightDiff <= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                        {{ $weightDiff > 0 ? '+' : '' }}{{ number_format($weightDiff, 1) }}kg
                    </p>
                </div>

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 text-center">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Variação de Gordura</span>
                    <p class="text-3xl font-black mt-2 {{ $fatDiff <= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                        {{ $fatDiff > 0 ? '+' : '' }}{{ number_format($fatDiff, 1) }}%
                    </p>
                </div>

                <div class="bg-slate-900 p-8 rounded-[40px] shadow-xl text-center text-white">
                    <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Total de Avaliações</span>
                    <p class="text-3xl font-black mt-2">{{ $evaluations->count() }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 italic">Curva de Peso (kg)</h3>
                    <canvas id="weightChart"></canvas>
                </div>

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 italic">Composição Corporal (%)</h3>
                    <canvas id="compositionChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                        <tr>
                            <th class="p-6">Data</th>
                            <th class="p-6">Peso</th>
                            <th class="p-6">% Gordura</th>
                            <th class="p-6">% Músculo</th>
                            <th class="p-6">Cintura</th>
                            <th class="p-6">Coxa D.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($evaluations->reverse() as $index => $eval)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-6 font-bold text-slate-700">{{ $eval->evaluation_date->format('d/m/Y') }}</td>
                            <td class="p-6 text-slate-600 font-medium">{{ $eval->weight }}kg</td>
                            <td class="p-6 text-blue-600 font-bold">{{ $eval->body_fat_pct }}%</td>
                            <td class="p-6 text-emerald-600 font-bold">{{ $eval->muscle_mass_pct }}%</td>
                            <td class="p-6 text-slate-500">{{ $eval->waist }}cm</td>
                            <td class="p-6 text-slate-500">{{ $eval->right_thigh }}cm</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Peso
        new Chart(document.getElementById('weightChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Peso (kg)',
                    data: {!! json_encode($weights) !!},
                    borderColor: '#2563eb',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(37, 99, 235, 0.05)'
                }]
            }
        });

        // Gráfico de Composição
        new Chart(document.getElementById('compositionChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    {
                        label: '% Gordura',
                        data: {!! json_encode($fat) !!},
                        backgroundColor: '#fb7185'
                    },
                    {
                        label: '% Músculo',
                        data: {!! json_encode($muscle) !!},
                        backgroundColor: '#10b981'
                    }
                ]
            },
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</x-app-layout>