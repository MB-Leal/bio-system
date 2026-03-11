<x-app-layout>
    <x-slot name="header">
        Visão Geral
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total de Alunos</p>
            <h4 class="text-3xl font-black text-slate-800 mt-2">124</h4>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Aguardando Avaliação</p>
            <h4 class="text-3xl font-black text-blue-600 mt-2">08</h4>
            <p class="text-xs text-slate-400 mt-2">Cadastros feitos pelo link público</p>
        </div>
    </div>

    </x-app-layout>