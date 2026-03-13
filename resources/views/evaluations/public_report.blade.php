<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Evolução | {{ $evaluation->student->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 antialiased font-sans">

    <div class="max-w-4xl mx-auto py-10 px-4">
        
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 mb-8 text-center">
            <x-application-logo class="w-20 h-20 mx-auto mb-4" />
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Relatório de Evolução Física</h1>
            <p class="text-slate-500 font-medium">Aluno(a): {{ $evaluation->student->name }}</p>
            <div class="mt-4 inline-block px-4 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold uppercase">
                Avaliação realizada em {{ $evaluation->evaluation_date->format('d/m/Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-slate-900 p-6 rounded-[32px] text-white text-center shadow-xl">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Peso Atual</span>
                <div class="text-3xl font-black mt-1">{{ $evaluation->weight }}<span class="text-sm font-normal text-slate-400">kg</span></div>
            </div>
            <div class="bg-white p-6 rounded-[32px] text-center border border-slate-100 shadow-sm">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">% Gordura</span>
                <div class="text-3xl font-black text-rose-500 mt-1">{{ $evaluation->body_fat_pct }}%</div>
            </div>
            <div class="bg-white p-6 rounded-[32px] text-center border border-slate-100 shadow-sm">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Massa Muscular</span>
                <div class="text-3xl font-black text-emerald-500 mt-1">{{ $evaluation->muscle_mass_pct }}%</div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-8 text-center">Medidas de Fita (Perímetros)</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-8">
                @php
                    $perimetros = [
                        'Busto' => $evaluation->bust, 'Cintura' => $evaluation->waist, 
                        'Abdômen' => $evaluation->abdomen, 'Quadril' => $evaluation->hip,
                        'Braço D.' => $evaluation->right_arm, 'Braço E.' => $evaluation->left_arm,
                        'Coxa D.' => $evaluation->right_thigh, 'Coxa E.' => $evaluation->left_thigh,
                        'Pant. D.' => $evaluation->right_calf, 'Pant. E.' => $evaluation->left_calf
                    ];
                @endphp
                @foreach($perimetros as $label => $valor)
                <div class="text-center border-b border-slate-50 pb-2">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">{{ $label }}</span>
                    <span class="text-lg font-black text-slate-700">{{ $valor ?? '--' }} <span class="text-[10px] font-normal">cm</span></span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Powered by</p>
            <x-application-logo class="w-12 h-12 mx-auto grayscale opacity-50" />
            <p class="text-[10px] text-slate-400 mt-4">Este é um documento digital. Os dados aqui contidos são de uso exclusivo para acompanhamento físico.</p>
        </div>

    </div>

</body>
</html>