<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelModel extends Model
{
    use HasFactory;
    
    protected $table = 'channels';
    
    protected $fillable = [
        'name',
        'number', 
        'description',
        'email',
        'contact_number',
        'logo_path'
    ];
}
