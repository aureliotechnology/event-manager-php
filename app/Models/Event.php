<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    /**
     * Nome da tabela (opcional, caso o nome siga a convenção "events")
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * Tipo da chave primária.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Desabilita o auto incremento da chave primária.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Atributos que podem ser atribuídos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'address',
        'mapUrl',
        'date',
        'modality',
        'cancellationPolicy',
        'participantEditionPolicy',
        'ticketType',
        'ticketPrice',
        'ticketQuantity',
    ];

    /**
     * Casting dos atributos para os tipos desejados.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
        'ticketPrice' => 'float',
        'ticketQuantity' => 'integer',
    ];

    /**
     * Método boot para gerar automaticamente o UUID no momento da criação.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Se o id não estiver definido, gera um UUID (v4)
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
