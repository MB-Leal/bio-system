<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Novo Aluno (Ficha Completa)') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ gender: 'F' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tighter flex items-center gap-2">
                        <span class="w-2 h-8 bg-blue-600 rounded-full"></span>
                        1. Dados Pessoais e Grupo
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-2">
                            <x-input-label for="name" :value="__('Nome Completo')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('E-mail')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                        </div>
                        <div>
                            <x-input-label for="phone" :value="__('WhatsApp')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" placeholder="(00) 00000-0000" />
                        </div>
                        <div>
                            <x-input-label for="birth_date" :value="__('Data de Nascimento')" />
                            <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date')" required />
                        </div>
                        <div>
                            <x-input-label for="gender" :value="__('Gênero')" />
                            <select name="gender" x-model="gender" class="mt-1 block w-full border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Feminino</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="height" :value="__('Altura Base (m)')" />
                            <x-text-input name="height" type="number" step="0.01" class="mt-1 block w-full" :value="old('height')" placeholder="Ex: 1.70" />
                        </div>
                        <div>
                            <x-input-label for="group_id" :value="__('Vincular ao Grupo')" />
                            <select name="group_id" class="mt-1 block w-full border-slate-200 rounded-2xl focus:ring-blue-500">
                                <option value="">Sem Grupo (Pendente)</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-