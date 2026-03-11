<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Chamada:') }} {{ $event->title }}
                </h2>
                <p class="text-sm text-gray-500">
                    {{ $event->group->name }} • {{ $event->scheduled_at->format('d/m/Y \à\s H:i') }}
                </p>
            </div>

            @if($event->status !== 'canceled')
                <form action="{{ route('events.cancel', $event) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <x-danger-button onclick="return confirm('Tens a certeza que desejas cancelar esta aula? As faltas não serão contabilizadas no ranking.')">
                        {{ __('Cancelar Aula') }}
                    </x-danger-button>
                </form>
            @else
                <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-bold text-xs uppercase">
                    Evento Cancelado
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if($event->status === 'canceled')
                <div class="bg-white p-8 rounded-lg shadow text-center">
                    <p class="text-gray-600 italic">Esta aula foi cancelada e o registo de presença está desativado.</p>
                    <a href="{{ route('events.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Voltar à lista</a>
                </div>
            @else
                <form action="{{ route('events.attendance.update', $event) }}" method="POST">
                    @csrf
                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 italic">
                                Lista de Presença
                            </h3>

                            <div class="divide-y divide-gray-100">
                                @foreach($event->group->students as $student)
                                    @php
                                        // Verifica se já existe presença gravada para este aluno neste evento
                                        $attendance = $event->attendances->where('student_id', $student->id)->first();
                                        $isPresent = $attendance ? $attendance->is_present : false;
                                    @endphp

                                    <div class="py-4 flex items-center justify-between hover:bg-gray-50 transition-colors px-2 rounded-lg">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800">{{ $student->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $student->email }}</span>
                                        </div>

                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="hidden" name="presence[{{ $student->id }}]" value="0">
                                            <input type="checkbox" 
                                                   name="presence[{{ $student->id }}]" 
                                                   value="1" 
                                                   class="sr-only peer"
                                                   {{ $isPresent ? 'checked' : '' }}>
                                            
                                            <div class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ms-3 text-sm font-bold text-gray-700 peer-checked:text-blue-600">
                                                {{ $isPresent ? 'Presente' : 'Ausente' }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 flex items-center justify-end border-t border-gray-100">
                            <x-primary-button class="w-full md:w-auto justify-center">
                                {{ __('Guardar Presenças') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>