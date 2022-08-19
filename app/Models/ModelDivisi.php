<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelDivisi extends Model
{
   protected $table = 'db_divisi';
   protected $fillable = ['id_divisi','nama_divisi'];
   // protected $primaryKey = null;
   // public $incrementing = false;
   // public $keyType = 'string';
}