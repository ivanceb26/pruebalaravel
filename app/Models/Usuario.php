<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Usuario extends Model
{
    protected $table = 'usuario';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'cedula' => 'bigint',
		'telefono' => 'bigint',
	];


	protected $fillable = [
		'nombres',
		'apellidos',
		'cedula',
		'correo',
		'telefono',
	];
}
