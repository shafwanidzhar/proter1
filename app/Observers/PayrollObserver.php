<?php

namespace App\Observers;

use App\Models\Payroll;
use App\Models\GeneralJournal;

class PayrollObserver
{
    public function created(Payroll $payroll): void
    {
        GeneralJournal::create([
            'date' => now(),
            'description' => 'Payroll for ' . ($payroll->user->name ?? 'Staff') . ' (' . $payroll->month . ' ' . $payroll->year . ')',
            'debit' => $payroll->amount,
            'credit' => 0,
            'category' => 'Expense',
            'reference_id' => $payroll->id,
            'reference_type' => Payroll::class,
        ]);
    }
}
