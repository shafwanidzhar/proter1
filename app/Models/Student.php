<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['parent_id', 'name', 'class'];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function tuitionPayments()
    {
        return $this->hasMany(TuitionPayment::class);
    }
}
