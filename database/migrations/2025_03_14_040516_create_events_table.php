<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            // Coluna 'id' como UUID e chave primária
            $table->uuid('id')->primary();

            // Propriedades do evento
            $table->string('name');
            $table->text('description');
            $table->string('address');
            $table->string('mapUrl');
            $table->dateTime('date');
            $table->string('modality'); // Caso tenha enum no PHP, armazene como string ou ajuste conforme necessário
            $table->text('cancellationPolicy');
            $table->text('participantEditionPolicy');
            $table->string('ticketType');
            $table->decimal('ticketPrice', 8, 2);
            $table->integer('ticketQuantity');

            // Cria as colunas created_at e updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverte as migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
