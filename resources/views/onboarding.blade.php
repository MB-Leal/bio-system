<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Inicial | Bio-System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-black text-blue-600 uppercase tracking-tighter">Bio<span class="text-slate-800">System</span></h1>
            <p class="text-slate-500 font-medium">Ficha de Inscrição Inicial</p>
        </div>

        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
            
            @if($errors->has('duplicate'))
                <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-700 text-sm">
                    {{ $errors->first('duplicate') }}
                </div>
            @endif

            <form action="{{ route('onboarding.store') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Nome Completo</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Nascimento</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Sexo</label>
                        <select name="gender" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Altura (ex: 1.75)</label>
                    <input type="number" step="0.01" name="height" value="{{ old('height') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Observações de Saúde (Opcional)</label>
                    <textarea name="health_notes" rows="3" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('health_notes') }}</textarea>
                </div>

                <button type="submit" 
                    class="w-full bg-slate-900 hover:bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all transform active:scale-95">
                    FINALIZAR MEU CADASTRO
                </button>
            </form>
        </div>
    </div>

</body>
</html>