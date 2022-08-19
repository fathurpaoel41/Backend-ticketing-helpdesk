<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelRejected extends Model
{
   protected $table = 'db_rejected'; 
   protected $fillable = ["id_rejected","id_ticket","reason"];
//    protected $primaryKey = null;
//    public $incrementing = false;
//    public $keyType = 'string';
}