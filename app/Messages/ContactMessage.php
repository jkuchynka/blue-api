<?php

namespace App\Messages;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'email',
        'message',
        'name',
        'subject'
    ];
}
