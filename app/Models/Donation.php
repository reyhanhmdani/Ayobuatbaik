<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $guarded = [];

    public function program()
    {
        return $this->belongsTo(ProgramDonasi::class, 'program_donasi_id');
    }

    public function setStatusPending()
    {
        $this->update(['status' => 'pending']);
    }
    public function setStatusSuccess()
    {
        $this->update(['status' => 'success']);
    }
    public function setStatusFailed()
    {
        $this->update(['status' => 'failed']);
    }
    public function setStatusExpired()
    {
        $this->update(['status' => 'expired']);
    }
}
