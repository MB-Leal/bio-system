<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Concluído | Bio-System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 antialiased text-slate-900">

    <div class="min-h-screen flex flex-col items-center justify-center p-4">

        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-slate-100 p-8 text-center">

            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-2xl font-black text-slate-800 mb-2">Cadastro Realizado!</h1>
            <p class="text-slate-500 mb-8">
                Obrigado por preencher seus dados iniciais. Agora, sua profissional já consegue visualizar seu perfil e agendar sua primeira avaliação física.
            </p>

            <div class="space-y-4">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-sm text-slate-600">
                    <p class="font-bold text-slate-800 mb-1">Próximos passos:</p>
                    <ul class="text-left list-disc list-inside space-y-1">
                        <li>Aguarde o contato da sua professora</li>
                        <li>Prepare-se para a pesagem inicial</li>
                        <li>Acompanhe sua evolução pelo link que você receberá</li>
                    </ul>
                </div>

                <a href="/cadastro" class="block w-full py-4 text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                    Voltar para o início
                </a>
            </div>
        </div>

        <p class="mt-8 text-slate-400 text-xs font-medium uppercase tracking-widest">
            Powered by BioSystem
        </p>
    </div>

</body>

</html>