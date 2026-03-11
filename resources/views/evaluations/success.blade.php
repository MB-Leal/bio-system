<div class="text-center p-10 bg-white rounded-3xl shadow-xl border border-emerald-100">
    <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>
    <h2 class="text-2xl font-black text-slate-800">Avaliação Salva!</h2>
    <p class="text-slate-500 mb-8">Os dados foram registrados e o relatório está disponível.</p>

    <div class="flex flex-col gap-4">
        <a href="{{ $whatsappUrl }}" target="_blank" class="w-full bg-green-500 text-white font-bold py-4 rounded-2xl flex items-center justify-center gap-2 hover:bg-green-600 transition-all">
            Enviar por WhatsApp
        </a>
        <a href="{{ route('students.index') }}" class="text-slate-400 font-bold py-2 hover:text-slate-600">
            Voltar para lista de alunos
        </a>
        <a href="{{ route('evaluations.pdf', $evaluation) }}"
            class="inline-flex items-center px-4 py-2 bg-slate-800 text-white rounded-xl font-bold text-sm hover:bg-slate-700 transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Baixar Relatório em PDF
        </a>
    </div>
</div>