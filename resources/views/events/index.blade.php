<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Cronograma de Aulas e Treinos') }}
            </h2>
            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-all shadow-sm">
                Agendar Nova Aula
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase font-black tracking-widest">
                                <th class="py-4 px-2">Data / Hora</th>
                                <th class="py-4 px-2">Grupo</th>
                                <th class="py-4 px-2">Título do Evento</th>
                                <th class="py-4 px-2">Status</th>
                                <th class="py-4 px-2 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($events as $event)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-2 text-sm font-bold text-slate-700">
                                    {{ $event->scheduled_at->format('d/m/Y') }}
                                    <span class="block text-[10px] text-slate-400 font-medium">{{ $event->scheduled_at->format('H:i') }}</span>
                                </td>
                                <td class="py-4 px-2">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold uppercase">
                                        {{ $event->group->name }}
                                    </span>
                                </td>
                                <td class="py-4 px-2 text-sm text-slate-600 font-medium">
                                    {{ $event->title }}
                                </td>
                                <td class="py-4 px-2">
                                    @if($event->status === 'scheduled')
                                        <span class="text-amber-500 font-bold text-xs italic">Agendado</span>
                                    @elseif($event->status === 'completed')
                                        <span class="text-emerald-500 font-bold text-xs uppercase tracking-tighter">✓ Realizado</span>
                                    @else
                                        <span class="text-rose-400 font-bold text-xs line-through">Cancelado</span>
                                    @endif
                                </td>
                                <td class="py-4 px-2 text-right">
                                    @if($event->status !== 'canceled')
                                        <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:text-blue-800 font-black text-xs uppercase tracking-widest">
                                            {{ $event->status === 'completed' ? 'Ver Chamada' : 'Fazer Chamada' }}
                                        </a>
                                    @else
                                        <span class="text-slate-300 text-xs font-bold uppercase">Indisponível</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-slate-400 italic">
                                    Nenhum evento agendado para esta semana.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>