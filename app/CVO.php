<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CVO extends Model
{
    protected $table = 'costos_variable_operacion';

    public function diesel()
    {
    	return $this->HasOne(Diesel::class, 'id', 'precio_diesel');
    }
}
