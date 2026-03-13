<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Chamada:') }} {{ $event->title }}
                </h2>
                <p class="text-sm text-gray-500">{{ $event->group->name }} • {{ $event->scheduled_at->format('d/m/Y H:i') }}</p>
            </div>

            @if($event->status !== 'canceled')
            <form action="{{ route('events.cancel', $event) }}" method="POST">
                @csrf @method('PATCH')
                <x-danger-button onclick="return confirm('Cancelar esta aula?')" class="rounded-2xl">
                    Cancelar Aula
                </x-danger-button>
            </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($event->status === 'canceled')
            <div class="bg-red-50 p-10 rounded-[40px] border border-red-100 text-center">
                <h3 class="text-red-600 font-black uppercase italic">Esta aula foi cancelada</h3>
            </div>
            @else
            <form action="{{ route('events.attendance.update', $event) }}" method="POST">
                @csrf
                <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-[10px] uppercase font-black text-slate-400">
                            <tr>
                                <th class="p-6">Aluno</th>
                                <th class="p-6 text-center">Presença</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($event->group->students as $student)
                            @php
                            $record = $event->attendances->where('student_id', $student->id)->first();
                            $status = $record ? ($record->is_present ? '1' : '0') : '1';
                            @endphp
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-6 font-bold text-slate-700">{{ $student->name }}</td>
                                <td class="p-6">
                                    <div class="flex justify-center gap-4" x-data="{ p: '{{ $status }}' }">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="presence[{{ $student->id }}]" value="1" x-model="p" class="hidden">
                                            <div :class="p == '1' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'bg-slate-100 text-slate-400'"
                                                class="px-5 py-2 rounded-2xl text-[10px] font-black uppercase transition-all">Presente</div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="presence[{{ $student->id }}]" value="0" x-model="p" class="hidden">
                                            <div :class="p == '0' ? 'bg-rose-500 text-white shadow-lg shadow-rose-100' : 'bg-slate-100 text-slate-400'"
                                                class="px-5 py-2 rounded-2xl text-[10px] font-black uppercase transition-all">Ausente</div>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-8 flex justify-center">
                    <x-primary-button class="h-16 px-12 rounded-3xl shadow-xl shadow-blue-100 text-lg">Finalizar Chamada</x-primary-button>
                </div>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>