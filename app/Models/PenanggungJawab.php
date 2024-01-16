<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenanggungJawab extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'penanggung_jawab';
    protected $guarded = [];

    public function purposes()
    {
        return $this->hasMany(Purposes::class, 'penanggung_jawab_id', 'id');
    }
}
