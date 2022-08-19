<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelFeedback extends Model
{
   protected $table = 'db_feedback'; 
   protected $fillable = ['id_feedback','id_ticket','feedback'];
   // protected $primaryKey = null;
   // public $incrementing = false;
   // public $keyType = 'string';
}