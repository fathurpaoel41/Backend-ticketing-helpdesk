<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTracking extends Model
{
   protected $table = 'db_tracking';
   protected $fillable = ['id_ticket','tanggal','status','deskripsi'];
   // protected $primaryKey = null;
   // public $incrementing = false;
   // public $keyType = 'string';
}