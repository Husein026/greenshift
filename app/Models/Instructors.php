<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\login;
use SoftDeletes;



class Instructors extends Model
{



    protected $dates = ['deleted_at'];
    protected $table = 'instructors';
    protected $primaryKey = 'id';
    protected $fillable = ['FKLoginId','firstname', 'insertion', 'lastname'];
    public $timestamps = true;
    use HasFactory;

    public function login()
    {
        return $this->belongsTo(Login::class, 'FKLoginId', 'id');
    }

    public function agenda()
    {
        return $this->hasOne(Agenda::class, 'FKInstructorId', 'id');
    }
}
