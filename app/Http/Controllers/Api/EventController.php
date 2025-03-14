<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Exibe uma listagem de todos os eventos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    /**
     * Armazena um novo evento no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validação dos dados enviados
        $data = $request->validate([
            'name'                     => 'required|string|max:255',
            'description'              => 'required|string',
            'address'                  => 'required|string|max:255',
            'mapUrl'                   => 'required|url',
            'date'                     => 'required|date',
            'modality'                 => 'required|string|max:100', // ajuste se for um enum
            'cancellationPolicy'       => 'required|string',
            'participantEditionPolicy' => 'required|string',
            'ticketType'               => 'required|string|max:100',
            'ticketPrice'              => 'required|numeric|min:0',
            'ticketQuantity'           => 'required|integer|min:0',
        ]);

        $event = Event::create($data);

        return response()->json($event, 201);
    }

    /**
     * Exibe os detalhes de um evento específico.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Event $event)
    {
        return response()->json($event);
    }

    /**
     * Atualiza os dados de um evento existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Event $event)
    {
        // Validação dos dados enviados (campo "sometimes" para atualizar somente se estiver presente)
        $data = $request->validate([
            'name'                     => 'sometimes|required|string|max:255',
            'description'              => 'sometimes|required|string',
            'address'                  => 'sometimes|required|string|max:255',
            'mapUrl'                   => 'sometimes|required|url',
            'date'                     => 'sometimes|required|date',
            'modality'                 => 'sometimes|required|string|max:100',
            'cancellationPolicy'       => 'sometimes|required|string',
            'participantEditionPolicy' => 'sometimes|required|string',
            'ticketType'               => 'sometimes|required|string|max:100',
            'ticketPrice'              => 'sometimes|required|numeric|min:0',
            'ticketQuantity'           => 'sometimes|required|integer|min:0',
        ]);

        $event->update($data);

        return response()->json($event);
    }

    /**
     * Remove o evento do banco de dados.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['message' => 'Evento removido com sucesso.']);
    }
}
