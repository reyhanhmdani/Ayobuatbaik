<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramDonasi extends Model
{
    use HasFactory;

    protected $table = 'program_donasi';

    protected $fillable = ['title', 'slug', 'penggalang_id', 'kategori_id', 'target_amount', 'collected_amount', 'start_date', 'end_date', 'gambar', 'deskripsi', 'status', 'short_description', 'verified', 'featured'];

    public function penggalang()
    {
        return $this->belongsTo(PenggalangDana::class, 'penggalang_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriDonasi::class, 'kategori_id');
    }

    public function sliders()
    {
        return $this->hasMany(Slider::class, 'program_id');
    }
}
