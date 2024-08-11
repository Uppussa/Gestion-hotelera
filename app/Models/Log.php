<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id', 'fc_log', 'action_log', 'tipo_log', 'ip_log', 'table_log', 'from_log', 'user_id', 'created_at', 'updated_at'
    ];

    protected $dates = [
        'fc_log',
    ];
}
