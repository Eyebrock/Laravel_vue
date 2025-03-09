<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificaciones extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'certificaciones';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
