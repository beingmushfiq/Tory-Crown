<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'source', 'user_id', 'ip_address', 'metadata', 'synced_to_fb'];

    protected $casts = [
        'metadata' => 'array',
        'synced_to_fb' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
