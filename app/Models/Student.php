<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Student extends Model
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $table = 'students';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'name',
        'path',
        'rating'
    ];
}
