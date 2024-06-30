<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'information',
        'filename',
        'is_selling'
    ];

    public function owner() {
        return $this->belongsTo(Owner::class);
    }
}
