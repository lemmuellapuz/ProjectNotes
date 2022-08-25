<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'qr_code',
        'title',
        'content',
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }
}
