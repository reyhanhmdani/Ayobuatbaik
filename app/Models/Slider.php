<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = ['judul', 'gambar', 'program_id', 'link', 'urutan', 'is_active', 'alt_text'];

    public function program()
    {
        return $this->belongsTo(ProgramDonasi::class, 'program_id');
    }
}
