<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    protected $table = 'lesson_package';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'hours', 'price'];
    public $timestamps = true; 
    use HasFactory;
}
