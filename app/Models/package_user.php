<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class package_user extends Model
{
    protected $table = 'package_user';
    protected $primaryKey = 'id';
    protected $fillable = ['FKUserId', 'FKPackageId'];
    public $timestamps = true;
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'FKUserId');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'FKPackageId');
    }
}
