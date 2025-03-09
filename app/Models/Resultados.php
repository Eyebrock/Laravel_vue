<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultados extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'resultados';
    protected $primaryKey = 'id_resultado';
    public $timestamps = false;

}
