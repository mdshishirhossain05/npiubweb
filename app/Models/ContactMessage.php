<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';

    public const STATUS_READ = 'read';

    public const STATUS_HANDLED = 'handled';

    public const STATUS_SPAM = 'spam';

    protected $guarded = ['id'];

    protected $casts = [
        'read_at' => 'datetime',
        'handled_at' => 'datetime',
    ];

    public function scopeNotSpam($query)
    {
        return $query->where('status', '!=', self::STATUS_SPAM);
    }
}
