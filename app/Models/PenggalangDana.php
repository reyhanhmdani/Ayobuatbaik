<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggalangDana extends Model
{
    use HasFactory;

    protected $table = 'penggalang_dana';

    protected $fillable = [
        'nama',
        'tipe',
        'kontak',
        'foto',
    ];

    public function programDonasi()
    {
        return $this->hasMany(ProgramDonasi::class, 'penggalang_id');
    }
}
