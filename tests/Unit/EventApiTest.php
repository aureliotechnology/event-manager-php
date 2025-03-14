<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa a rota de health-check.
     */
    public function test_health_check()
    {
        $response = $this->getJson('/api/health-check');
        $response->assertStatus(200)
                 ->assertJson(['status' => 'ok']);
    }

    /**
     * Testa a listagem de eventos.
     */
    public function test_index_events()
    {
        // Cria 3 eventos utilizando a factory
        Event::factory()->count(3)->create();

        $response = $this->getJson('/api/events');
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /**
     * Testa a criação de um evento.
     */
    public function test_create_event()
    {
        $payload = [
            'name'                     => 'Evento de Teste',
            'description'              => 'Descrição do evento de teste',
            'address'                  => 'Rua Exemplo, 123',
            'mapUrl'                   => 'https://maps.google.com/?q=Rua+Exemplo',
            'date'                     => now()->addDays(5)->toDateTimeString(),
            'modality'                 => 'presencial',
            'cancellationPolicy'       => 'Política de cancelamento de teste',
            'participantEditionPolicy' => 'Política de edição de participantes de teste',
            'ticketType'               => 'Normal',
            'ticketPrice'              => 100.50,
            'ticketQuantity'           => 50,
        ];

        $response = $this->postJson('/api/events', $payload);
        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Evento de Teste']);

        $this->assertDatabaseHas('events', ['name' => 'Evento de Teste']);
    }

    /**
     * Testa a visualização de um evento.
     */
    public function test_show_event()
    {
        $event = Event::factory()->create();

        $response = $this->getJson("/api/events/{$event->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $event->id]);
    }

    /**
     * Testa a atualização de um evento.
     */
    public function test_update_event()
    {
        $event = Event::factory()->create([
            'name' => 'Evento Original'
        ]);

        $payload = [
            'name' => 'Evento Atualizado'
        ];

        $response = $this->putJson("/api/events/{$event->id}", $payload);
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Evento Atualizado']);

        $this->assertDatabaseHas('events', ['id' => $event->id, 'name' => 'Evento Atualizado']);
    }

    /**
     * Testa a exclusão de um evento.
     */
    public function test_delete_event()
    {
        $event = Event::factory()->create();

        $response = $this->deleteJson("/api/events/{$event->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Evento removido com sucesso.']);

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}
