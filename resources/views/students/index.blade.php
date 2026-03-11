<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gerenciamento de Alunos') }}
            </h2>
            <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                Novo Aluno
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-4 px-2 text-sm font-bold text-gray-600">ALUNO</th>
                                <th class="py-4 px-2 text-sm font-bold text-gray-600">STATUS / GRUPO</th>
                                <th class="py-4 px-2 text-sm font-bold text-gray-600">CADASTRO</th>
                                <th class="py-4 px-2 text-sm font-bold text-gray-600 text-right">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-2">
                                    <div class="font-bold text-gray-800">{{ $student->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $student->email }}</div>
                                </td>
                                <td class="py-4 px-2">
                                    @if($student->group)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                            {{ $student->group->name }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">
                                            AGUARDANDO GRUPO
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-2 text-sm text-gray-600">
                                    {{ $student->created_at->format('d/m/Y') }}
                                </td>
                                <td class="py-4 px-2 text-right">
                                    <button class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase mr-3">Avaliar</button>
                                    <button class="text-gray-400 hover:text-gray-600 font-bold text-xs uppercase">Editar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>