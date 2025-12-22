<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitabMaqolah extends Model
{
    use HasFactory;

    protected $table = "kitab_maqolah";

    protected $fillable = ["chapter_id", "nomor_maqolah", "judul", "konten", "urutan"];

    /**
     * Relasi ke chapter
     */
    public function chapter()
    {
        return $this->belongsTo(KitabChapter::class, "chapter_id");
    }

    /**
     * Get maqolah sebelumnya
     */
    public function getPreviousAttribute()
    {
        return self::where("chapter_id", $this->chapter_id)->where("urutan", "<", $this->urutan)->orderBy("urutan", "desc")->first();
    }

    /**
     * Get maqolah selanjutnya
     */
    public function getNextAttribute()
    {
        return self::where("chapter_id", $this->chapter_id)->where("urutan", ">", $this->urutan)->orderBy("urutan", "asc")->first();
    }
}
