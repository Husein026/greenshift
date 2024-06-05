<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Add this line

class Login extends Model implements Authenticatable

{
    use \Illuminate\Auth\Authenticatable;





    protected $table = 'login';
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'password', 'FKRoleId'];
    public $timestamps = true;
    use HasFactory;

    public function instructor()
    {
        return $this->hasOne(Instructors::class, 'FKLoginId', 'id');
    }

  public function user()
    {
        return $this->hasOne(User::class, 'FKLoginId', 'id');
    }


}
