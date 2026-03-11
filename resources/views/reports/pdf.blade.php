<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Bioimpedância</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #2563eb; text-transform: uppercase; font-size: 24px; }
        
        .section-title { background: #f8fafc; padding: 8px; font-weight: bold; border-left: 4px solid #2563eb; margin: 20px 0 10px 0; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #f1f5f9; font-size: 12px; color: #64748b; }

        .result-box { width: 48%; display: inline-block; vertical-align: top; margin-bottom: 10px; }
        .value { font-size: 18px; font-weight: bold; color: #1e293b; }
        .diff { font-size: 11px; font-weight: bold; }
        .up { color: #e11d48; }
        .down { color: #10b981; }
    </style>
</head>
<body>

    <div class="header">
        <h1>BioSystem</h1>
        <p>Relatório de Composição Corporal • {{ $evaluation->evaluation_date->format('d/m/Y') }}</p>
    </div>

    <table style="border: none;">
        <tr>
            <td style="border: none; width: 50%;">
                <strong>Aluno:</strong> {{ $student->name }}<br>
                <strong>Idade:</strong> {{ \Carbon\Carbon::parse($student->birth_date)->age }} anos
            </td>
            <td style="border: none; width: 50%; text-align: right;">
                <strong>Altura:</strong> {{ $student->height }}m<br>
                <strong>Gênero:</strong> {{ $student->gender == 'M' ? 'Masculino' : 'Feminino' }}
            </td>
        </tr>
    </table>

    <div class="section-title">BIOIMPEDÂNCIA</div>
    
    <div class="result-box">
        <small>PESO TOTAL</small><br>
        <span class="value">{{ $evaluation->weight }} kg</span>
        @if($previous)
            <span class="diff {{ $evaluation->weight > $previous->weight ? 'up' : 'down' }}">
                ({{ $evaluation->weight > $previous->weight ? '+' : '' }}{{ number_format($evaluation->weight - $previous->weight, 1) }} kg)
            </span>
        @endif
    </div>

    <div class="result-box">
        <small>% GORDURA</small><br>
        <span class="value">{{ $evaluation->body_fat_pct }}%</span>
    </div>

    <div class="result-box">
        <small>MASSA MUSCULAR</small><br>
        <span class="value">{{ $evaluation->muscle_mass_pct }}%</span>
    </div>

    <div class="result-box">
        <small>GORDURA VISCERAL</small><br>
        <span class="value">{{ $evaluation->visceral_fat }}</span>
    </div>

    <div class="section-title">PERÍMETROS (MEDIDAS)</div>
    <table>
        <thead>
            <tr>
                <th>Cintura</th>
                <th>Abdômen</th>
                <th>Braço D.</th>
                <th>Coxa D.</th>
                <th>Quadril</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $evaluation->waist ?? '--' }} cm</td>
                <td>{{ $evaluation->abdomen ?? '--' }} cm</td>
                <td>{{ $evaluation->right_arm ?? '--' }} cm</td>
                <td>{{ $evaluation->right_thigh ?? '--' }} cm</td>
                <td>{{ $evaluation->hip ?? '--' }} cm</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: center; font-size: 10px; color: #94a3b8;">
        Este relatório é de uso informativo. Consulte sempre um profissional de saúde.<br>
        Gerado por <strong>BioSystem</strong>
    </div>

</body>
</html>