<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * O nome do model associado à factory.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define o estado padrão do model.
     *
     * @return array
     */
    public function definition()
    {
        $modalities = ['presencial', 'online', 'hibrido'];
        $ticketTypes = ['VIP', 'Normal', 'Premium'];

        return [
            // O campo "id" será gerado automaticamente pelo método boot do model (UUID)
            'name'                     => $this->faker->sentence(3),
            'description'              => $this->faker->paragraph,
            'address'                  => $this->faker->address,
            'mapUrl'                   => 'https://maps.google.com/?q=' . urlencode($this->faker->address),
            'date'                     => $this->faker->dateTimeBetween('now', '+1 year'),
            'modality'                 => $this->faker->randomElement($modalities),
            'cancellationPolicy'       => $this->faker->paragraph,
            'participantEditionPolicy' => $this->faker->paragraph,
            'ticketType'               => $this->faker->randomElement($ticketTypes),
            'ticketPrice'              => $this->faker->randomFloat(2, 10, 500),
            'ticketQuantity'           => $this->faker->numberBetween(50, 500),
        ];
    }
}
