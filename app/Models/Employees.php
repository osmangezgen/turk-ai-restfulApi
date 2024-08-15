<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $table = 'employees';
    public $timestamps = false;

    protected $fillable = ['company_id', 'first_name', 'last_name', 'email', 'phone'];

    protected $hidden = ['id'];

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
}
