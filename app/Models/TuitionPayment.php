<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionPayment extends Model
{
    protected $fillable = ['student_id', 'amount', 'month', 'year', 'status', 'proof_image'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
