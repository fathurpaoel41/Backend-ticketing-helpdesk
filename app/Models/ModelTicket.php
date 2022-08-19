<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTicket extends Model
{
   protected $table = 'db_ticket'; 
   protected $fillable = ["id_ticket","tanggal_dibuat","tanggal_solved","id_user","kategori","problem_detail","assigned","status"];
   // protected $primaryKey = "id_ticket";
   // public $incrementing = false;
   // public $keyType = 'string';
}