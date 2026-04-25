<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Lista todos os eventos (aulas/treinos)
     */
    public function index()
    {
        $events = Event::with('group')
            ->where('user_id', Auth::id())
            ->orderBy('scheduled_at', 'desc')
            ->paginate(15);

        return view('events.index', compact('events'));
    }

    /**
     * Exibe o formulário de criação (Aulas/Treinos)
     */
    public function create()
    {
        $groups = Auth::user()->groups;
        return view('events.create', compact('groups'));
    }

    /**
     * Salva o novo evento no banco
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'title' => 'required|string|max:100',
            'scheduled_at' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $event = Auth::user()->events()->create($validated);

        return redirect()->route('events.index')->with('success', 'Evento agendado com sucesso!');
    }

    /**
     * Tela de Chamada (Lista de alunos do grupo)
     */
    public function show(Event $event)
    {
        // Carrega os alunos do grupo do evento e as presenças já marcadas
        $event->load(['group.students', 'attendances']);

        return view('events.show', compact('event'));
    }

    /**
     * Registra a frequência dos alunos
     */
    public function updateAttendance(Request $request, Event $event)
    {
        if ($event->status === 'canceled') {
            return back()->with('error', 'Não é possível marcar presença num evento cancelado.');
        }

        // Pegamos o array de presenças enviado pelo formulário
        $presences = $request->input('presence', []); // [student_id => 1, student_id => 0]

        foreach ($presences as $studentId => $isPresent) {
            Attendance::updateOrCreate(
                ['event_id' => $event->id, 'student_id' => $studentId],
                ['is_present' => (bool)$isPresent]
            );
        }

        $event->update(['status' => 'completed']);

        return redirect()->route('events.index')->with('success', 'Chamada realizada com sucesso!');
    }

    /**
     * Cancela o evento (não conta para frequência)
     */
    public function cancel(Event $event)
    {
        // Atualiza o status para cancelado
        $event->update([
            'status' => 'canceled'
        ]);

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->route('events.show', $event)
            ->with('success', 'Aula cancelada com sucesso.');
    }
}
