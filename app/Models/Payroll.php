<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['user_id', 'month', 'year', 'total_attendance', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
