<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriDonasi extends Model
{
    use HasFactory;

    protected $table = 'kategori_donasi';

    protected $fillable = [
        'name',
        'slug',
        'deskripsi',
    ];

    public function programDonasi()
    {
        return $this->hasMany(ProgramDonasi::class, 'kategori_id');
    }
}
