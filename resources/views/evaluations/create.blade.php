<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nova Avaliação: {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('students.evaluations.store', $student) }}" method="POST" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @csrf
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <h3 class="text-blue-600 font-bold uppercase text-xs tracking-widest mb-6">1. Dados da Balança (Bioimpedância)</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <x-input-label for="evaluation_date" value="Data da Pesagem" />
                        <x-text-input type="date" name="evaluation_date" class="w-full" required value="{{ date('Y-m-d') }}" />
                    </div>
                    <div>
                        <x-input-label for="weight" value="Peso Total (kg)" />
                        <x-text-input type="number" step="0.1" name="weight" class="w-full" required />
                    </div>
                    <div>
                        <x-input-label for="body_fat_pct" value="% Gordura" />
                        <x-text-input type="number" step="0.1" name="body_fat_pct" class="w-full" required />
                    </div>
                    <div>
                        <x-input-label for="muscle_mass_pct" value="% Massa Muscular" />
                        <x-text-input type="number" step="0.1" name="muscle_mass_pct" class="w-full" required />
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-gray-400 font-bold uppercase text-xs tracking-widest mb-6">2. Medidas de Fita (cm)</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    <div>
                        <x-input-label value="Cintura" />
                        <x-text-input type="number" step="0.1" name="waist" class="w-full" />
                    </div>
                    <div>
                        <x-input-label value="Abdômen" />
                        <x-text-input type="number" step="0.1" name="abdomen" class="w-full" />
                    </div>
                    <div>
                        <x-input-label value="Braço D." />
                        <x-text-input type="number" step="0.1" name="right_arm" class="w-full" />
                    </div>
                    <div>
                        <x-input-label value="Coxa D." />
                        <x-text-input type="number" step="0.1" name="right_thigh" class="w-full" />
                    </div>
                    <div>
                        <x-input-label value="Quadril" />
                        <x-text-input type="number" step="0.1" name="hip" class="w-full" />
                    </div>
                </div>
            </div>

            <x-primary-button class="w-full justify-center h-14 text-lg">
                Salvar Avaliação e Gerar Relatório
            </x-primary-button>
        </form>
    </div>
</x-app-layout>