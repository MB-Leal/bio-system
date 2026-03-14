<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evolução BioSystem - {{ $student->name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 antialiased text-slate-900 pb-10">

    <div class="max-w-xl mx-auto p-4">
        
        <header class="text-center py-6">
            <h1 class="text-2xl font-black text-blue-600 uppercase tracking-tighter">Bio<span class="text-slate-800">System</span></h1>
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Relatório de Evolução Corporal</p>
        </header>

        <div class="bg-white rounded-[32px] p-6 shadow-sm border border-slate-100 mb-6 flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-blue-100">
                {{ substr($student->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-lg font-bold leading-tight">{{ $student->name }}</h2>
                <p class="text-slate-400 text-xs font-medium">{{ $evaluation->evaluation_date->format('d/m/Y') }} • {{ $student->height }}m</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-5 rounded-[32px] border border-slate-100 shadow-sm">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Peso Atual</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-black text-slate-800">{{ $evaluation->weight }}</span>
                    <span class="text-xs font-bold text-slate-500">kg</span>
                </div>
                @if($previous)
                    <div class="mt-2 text-[10px] font-bold {{ $evaluation->weight <= $previous->weight ? 'text-emerald-500' : 'text-rose-500' }}">
                        {{ $evaluation->weight <= $previous->weight ? '↓' : '↑' }} {{ abs(number_format($evaluation->weight - $previous->weight, 1)) }}kg vs anterior
                    </div>
                @endif
            </div>

            <div class="bg-white p-5 rounded-[32px] border border-slate-100 shadow-sm">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">% Gordura</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-black text-blue-600">{{ $evaluation->body_fat_pct }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-1.5 mt-3 rounded-full overflow-hidden">
                    <div class="bg-blue-600 h-full" style="width: {{ $evaluation->body_fat_pct }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm mb-6">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 italic">Evolução de Peso</h3>
            <canvas id="weightChart" height="200"></canvas>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Massa Muscular</span>
                <span class="text-lg font-black text-slate-700">{{ $evaluation->muscle_mass_pct }}%</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Gord. Visceral</span>
                <span class="text-lg font-black text-slate-700">{{ $evaluation->visceral_fat ?? '--' }}</span>
            </div>
        </div>

        <div class="bg-slate-900 rounded-[40px] p-8 text-white mb-6 shadow-xl">
            <h3 class="text-xs font-bold text-blue-400 mb-8 uppercase tracking-widest text-center">Medidas de Perímetros (cm)</h3>
            <div class="grid grid-cols-2 gap-x-8 gap-y-8">
                <div class="text-center">
                    <span class="text-slate-500 text-[9px] uppercase font-black block mb-1">Cintura</span>
                    <span class="text-xl font-bold">{{ $evaluation->waist ?? '--' }}</span>
                </div>
                <div class="text-center border-l border-slate-800">
                    <span class="text-slate-500 text-[9px] uppercase font-black block mb-1">Abdômen</span>
                    <span class="text-xl font-bold">{{ $evaluation->abdomen ?? '--' }}</span>
                </div>
                <div class="text-center border-t border-slate-800 pt-6">
                    <span class="text-slate-500 text-[9px] uppercase font-black block mb-1">Braço D.</span>
                    <span class="text-xl font-bold">{{ $evaluation->right_arm ?? '--' }}</span>
                </div>
                <div class="text-center border-l border-t border-slate-800 pt-6">
                    <span class="text-slate-500 text-[9px] uppercase font-black block mb-1">Coxa D.</span>
                    <span class="text-xl font-bold">{{ $evaluation->right_thigh ?? '--' }}</span>
                </div>
                <div class="text-center border-t border-slate-800 pt-6">
                    <span class="text-slate-500 text-[9px] uppercase font-black block mb-1">Pant. D.</span>
                    <span class="text-xl font-bold">{{ $evaluation->right_calf ?? '--' }}</span>
                </div>
                <div class="text-center border-l border-t border-slate-800 pt-6">
                    <span class="text-slate-500 text-[9px] uppercase font-black block mb-1">Pant. E.</span>
                    <span class="text-xl font-bold">{{ $evaluation->left_calf ?? '--' }}</span>
                </div>
            </div>
        </div>

        <p class="text-center text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] opacity-50">
            Powered by BioSystem
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
                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { display: false, beginAtZero: false },
                    x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } }
                }
            }
        });
    </script>
</body>
</html>