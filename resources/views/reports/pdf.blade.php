<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório BioSystem - {{ $student->name }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #2563eb; text-transform: uppercase; font-size: 24px; }
        .section-title { background: #f8fafc; padding: 8px; font-weight: bold; border-left: 4px solid #2563eb; margin: 25px 0 10px 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 12px; }
        th { background-color: #f1f5f9; color: #64748b; text-transform: uppercase; }
        .result-grid { margin-bottom: 10px; }
        .result-box { width: 30%; display: inline-block; vertical-align: top; margin-bottom: 15px; padding: 10px; background: #fff; }
        .label { font-size: 10px; color: #64748b; font-weight: bold; text-transform: uppercase; }
        .value { font-size: 18px; font-weight: bold; color: #1e293b; display: block; }
        .diff { font-size: 10px; font-weight: bold; }
        .up { color: #e11d48; } /* Vermelho para aumento de peso/gordura */
        .down { color: #10b981; } /* Verde para redução */
    </style>
</head>
<body>

    <div class="header">
        <h1>BioSystem</h1>
        <p>Relatório de Composição Corporal • {{ $evaluation->evaluation_date->format('d/m/Y') }}</p>
    </div>

    <table style="border: none; margin-bottom: 30px;">
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

    <div class="section-title">BIOIMPEDÂNCIA (COMPOSIÇÃO CORPORAL)</div>
    
    <div class="result-grid">
        <div class="result-box">
            <span class="label">Peso Total</span>
            <span class="value">{{ $evaluation->weight }} kg</span>
            @if($previous)
                <span class="diff {{ $evaluation->weight > $previous->weight ? 'up' : 'down' }}">
                    ({{ $evaluation->weight > $previous->weight ? '+' : '' }}{{ number_format($evaluation->weight - $previous->weight, 1) }} kg)
                </span>
            @endif
        </div>

        <div class="result-box">
            <span class="label">% Gordura Corporal</span>
            <span class="value">{{ $evaluation->body_fat_pct }}%</span>
            @if($previous)
                <span class="diff {{ $evaluation->body_fat_pct > $previous->body_fat_pct ? 'up' : 'down' }}">
                    ({{ $evaluation->body_fat_pct > $previous->body_fat_pct ? '+' : '' }}{{ number_format($evaluation->body_fat_pct - $previous->body_fat_pct, 1) }}%)
                </span>
            @endif
        </div>

        <div class="result-box">
            <span class="label">Massa Muscular</span>
            <span class="value">{{ $evaluation->muscle_mass_pct }}%</span>
        </div>

        <div class="result-box" style="margin-top: 10px;">
            <span class="label">Gordura Visceral</span>
            <span class="value">{{ $evaluation->visceral_fat ?? '--' }}</span>
        </div>

        <div class="result-box" style="margin-top: 10px;">
            <span class="label">IMC</span>
            <span class="value">{{ number_format($evaluation->weight / ($student->height * $student->height), 1) }}</span>
        </div>
    </div>

    <div class="section-title">PERÍMETROS E MEDIDAS (CM)</div>
    <table>
        <thead>
            <tr>
                <th>Cintura</th>
                <th>Abdômen</th>
                <th>Quadril</th>
                <th>Braço D.</th>
                <th>Coxa D.</th>
                <th>Pant. D.</th>
                <th>Pant. E.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $evaluation->waist ?? '--' }}</td>
                <td>{{ $evaluation->abdomen ?? '--' }}</td>
                <td>{{ $evaluation->hip ?? '--' }}</td>
                <td>{{ $evaluation->right_arm ?? '--' }}</td>
                <td>{{ $evaluation->right_thigh ?? '--' }}</td>
                <td>{{ $evaluation->right_calf ?? '--' }}</td>
                <td>{{ $evaluation->left_calf ?? '--' }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 60px; text-align: center; border-top: 1px solid #eee; pt: 20px;">
        <p style="font-size: 10px; color: #94a3b8;">
            Este documento é um relatório técnico de acompanhamento físico gerado pelo sistema <strong>BioSystem</strong>.<br>
            Consulte sempre um profissional de educação física ou nutricionista para interpretação dos dados.
        </p>
    </div>

</body>
</html>