<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\GeneralJournal;

class ExpenseObserver
{
    public function created(Expense $expense): void
    {
        GeneralJournal::create([
            'date' => $expense->date,
            'description' => $expense->description,
            'debit' => $expense->amount,
            'credit' => 0,
            'category' => 'Expense',
            'reference_id' => $expense->id,
            'reference_type' => Expense::class,
        ]);
    }
}
