<?php

namespace LaraCar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBanner extends Model
{
    use HasFactory;

    protected $fillable = ['user', 'cover', 'views'];

    /** Relationships */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user');
    }
}
