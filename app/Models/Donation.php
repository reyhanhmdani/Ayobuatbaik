<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    // Tambahkan properti untuk menangani tanggal
    protected $casts = [
        'amount' => 'integer',
        'status_change_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'deleted_at' => 'datetime', 
    ];

    public function program()
    {
        return $this->belongsTo(ProgramDonasi::class, 'program_donasi_id');
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
        $this->attributes['status_change_at'] = now();
        $this->save();
    }
    public function setStatusUnpaid()
    {
        $this->setStatus('unpaid');
    }
    public function setStatusPending()
    {
        $this->setStatus('pending');
    }
    public function setStatusSuccess()
    {
        $this->setStatus('success');
    }
    public function setStatusFailed()
    {
        $this->setStatus('failed');
    }
    public function setStatusExpired()
    {
        $this->setStatus('expired');
    }

    // helper
    public function getDonorInitialAttribute()
    {
        // Ambil karakter pertama dari nama donatur
        if (!empty($this->donor_name)) {
            // Ambil huruf pertama dan ubah ke huruf kapital
            return strtoupper(substr($this->donor_name, 0, 1));
        }
        return 'D'; // Default inisial jika nama kosong
    }
}
