<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $guarded = [];

    // Tambahkan properti untuk menangani tanggal
    protected $casts = [
        'amount' => 'integer',
        'status_change_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(ProgramDonasi::class, 'program_donasi_id');
    }

    public function setStatusPending()
    {
        $this->attributes['status'] = 'pending';
        $this->attributes['status_change_at'] = now(); // Update timestamp
        $this->save();
    }
    public function setStatusSuccess()
    {
        $this->attributes['status'] = 'success';
        $this->attributes['status_change_at'] = now(); // Update timestamp
        $this->save();
    }
    public function setStatusFailed()
    {
        $this->attributes['status'] = 'failed';
        $this->attributes['status_change_at'] = now(); // Update timestamp
        $this->save();
    }
    public function setStatusExpired()
    {
        $this->attributes['status'] = 'expired';
        $this->attributes['status_change_at'] = now(); // Update timestamp
        $this->save();
    }
}
