<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Purposes extends Model
{
    use HasFactory;
    protected $table = 'purposes';
    protected $guarded = [];

    public function document()
    {
        return $this->hasMany(Document::class, 'purpose_id', 'id');
    }

    public function responsible()
    {
        return $this->belongsTo(PenanggungJawab::class, 'penanggung_jawab_id');
    }
}
