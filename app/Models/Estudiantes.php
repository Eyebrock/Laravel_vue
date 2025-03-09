<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiantes extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'estudiantes';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
