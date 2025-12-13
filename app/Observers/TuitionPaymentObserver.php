<?php

namespace App\Observers;

use App\Models\TuitionPayment;
use App\Models\GeneralJournal;

class TuitionPaymentObserver
{
    public function created(TuitionPayment $tuitionPayment): void
    {
        if ($tuitionPayment->status === 'billed' && $tuitionPayment->user) {
            \Filament\Notifications\Notification::make()
                ->title('Tagihan SPP Baru')
                ->body('Tagihan SPP Bulan ' . $tuitionPayment->month . ' ' . $tuitionPayment->year . ' sebesar Rp ' . number_format($tuitionPayment->amount, 0, ',', '.'))
                ->actions([
                    \Filament\Notifications\Actions\Action::make('bayar')
                        ->button()
                        ->url(url('/portal/tuition-payments')),
                ])
                ->sendToDatabase($tuitionPayment->user);

            // Notification to Admin (Bill Sent)
            $admins = \App\Models\User::where('role', 'admin')->get();
            \Filament\Notifications\Notification::make()
                ->title('Tagihan Terkirim')
                ->body('Pembayaran sebesar Rp ' . number_format($tuitionPayment->amount, 0, ',', '.') . ' telah terkirim kepada ' . $tuitionPayment->user->name)
                ->success()
                ->sendToDatabase($admins);
        }
    }

    public function updated(TuitionPayment $tuitionPayment): void
    {
        if ($tuitionPayment->isDirty('status') && $tuitionPayment->status === 'verified') {
            GeneralJournal::create([
                'date' => now(),
                'description' => 'Tuition Payment from ' . ($tuitionPayment->student->name ?? 'Student') . ' (' . $tuitionPayment->month . ' ' . $tuitionPayment->year . ')',
                'debit' => 0,
                'credit' => $tuitionPayment->amount,
                'category' => 'Income',
                'reference_id' => $tuitionPayment->id,
                'reference_type' => TuitionPayment::class,
            ]);

            if ($tuitionPayment->user) {
                \Filament\Notifications\Notification::make()
                    ->title('Pembayaran Diterima')
                    ->body('Pembayaran SPP Anda telah diverifikasi.')
                    ->success()
                    ->sendToDatabase($tuitionPayment->user);
            }
        } elseif ($tuitionPayment->isDirty('status') && $tuitionPayment->status === 'rejected') {
            if ($tuitionPayment->user) {
                \Filament\Notifications\Notification::make()
                    ->title('Pembayaran Ditolak')
                    ->body('Pembayaran SPP Anda ditolak. Silakan cek kembali bukti pembayaran.')
                    ->danger()
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('perbaiki')
                            ->button()
                            ->url(url('/portal/tuition-payments/' . $tuitionPayment->id . '/edit')),
                    ])
                    ->sendToDatabase($tuitionPayment->user);
            }
        }
    }
}
