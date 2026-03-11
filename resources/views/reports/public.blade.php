<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Evolução - {{ $student->name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 antialiased text-slate-900">

    <div class="max-w-xl mx-auto p-4 pb-20">
        
        <header class="text-center py-8">
            <h1 class="text-2xl font-black text-blue-600 uppercase tracking-tighter">Bio<span class="text-slate-800">System</span></h1>
            <p class="text-slate-500 text-sm font-medium">Relatório de Composição Corporal</p>
        </header>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 mb-6 flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">
                {{ substr($student->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-xl font-bold">{{ $student->name }}</h2>
                <p class="text-slate-500 text-sm">{{ $evaluation->evaluation_date->format('d/m/Y') }} • {{ $student->height }}m</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-xs">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Peso Total</span>
                <div class="flex items-baseline gap-1 mt-1">
                    <span class="text-2xl font-black text-slate-800">{{ $evaluation->weight }}</span>
                    <span class="text-xs font-bold text-slate-500">kg</span>
                </div>
                @if($previous)
                    <div class="mt-2 text-[10px] font-bold {{ $evaluation->weight <= $previous->weight ? 'text-emerald-500' : 'text-rose-500' }}">
                        {{ $evaluation->weight <= $previous->weight ? '↓' : '↑' }} {{ abs($evaluation->weight - $previous->weight) }}kg vs anterior
                    </div>
                @endif
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-xs">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">% Gordura</span>
                <div class="flex items-baseline gap-1 mt-1">
                    <span class="text-2xl font-black text-slate-800">{{ $evaluation->body_fat_pct }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-1.5 mt-3 rounded-full overflow-hidden">
                    <div class="bg-rose-500 h-full" style="width: {{ $evaluation->body_fat_pct }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs mb-6">
            <h3 class="text-sm font-bold text-slate-800 mb-4 italic">Evolução de Peso</h3>
            <canvas id="weightChart"></canvas>
        </div>

        <div class="bg-slate-900 rounded-3xl p-6 text-white mb-6">
            <h3 class="text-sm font-bold text-blue-400 mb-6 uppercase tracking-widest text-center">Medidas de Perímetros (cm)</h3>
            <div class="grid grid-cols-2 gap-y-6">
                <div class="text-center">
                    <span class="text-slate-400 text-[10px] uppercase font-bold block">Cintura</span>
                    <span class="text-xl font-bold">{{ $evaluation->waist ?? '--' }}</span>
                </div>
                <div class="text-center border-l border-slate-800">
                    <span class="text-slate-400 text-[10px] uppercase font-bold block">Abdômen</span>
                    <span class="text-xl font-bold">{{ $evaluation->abdomen ?? '--' }}</span>
                </div>
                <div class="text-center border-t border-slate-800 pt-4">
                    <span class="text-slate-400 text-[10px] uppercase font-bold block">Braço</span>
                    <span class="text-xl font-bold">{{ $evaluation->right_arm ?? '--' }}</span>
                </div>
                <div class="text-center border-l border-t border-slate-800 pt-4">
                    <span class="text-slate-400 text-[10px] uppercase font-bold block">Coxa</span>
                    <span class="text-xl font-bold">{{ $evaluation->right_thigh ?? '--' }}</span>
                </div>
            </div>
        </div>

        <p class="text-center text-slate-400 text-[10px] font-medium uppercase tracking-widest">
            Gerado automaticamente por BioSystem
        </p>

    </div>

    <script>
        const ctx = document.getElementById('weightChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($history->map(fn($e) => $e->evaluation_date->format('d/m'))) !!},
                datasets: [{
                    label: 'Peso (kg)',
                    data: {!! json_encode($history->pluck('weight')) !!},
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#2563eb'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { display: false },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>