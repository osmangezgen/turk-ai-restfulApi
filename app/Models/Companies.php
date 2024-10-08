<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $table = 'companies';
    public $timestamps = false;

    protected $fillable = ['name', 'email', 'logo', 'website'];

    protected $hidden = ['id'];

    public function employees()
    {
        return $this->hasMany(Employees::class, 'company_id');
    }

}
