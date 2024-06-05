<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = ['roleName'];
    public $timestamps = true;


    public function users()
    {
        return $this->hasMany(login::class, 'FKRoleId');
    }
}
