<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelCategory extends Model
{
   protected $table = 'db_kategori'; 
   protected $fillable = ["id_kategori","nama_kategori"];
   // protected $primaryKey = null;
   // public $incrementing = false;
   // public $keyType = 'string';
}