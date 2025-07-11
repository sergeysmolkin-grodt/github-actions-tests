<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherVideo extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'video', 'image', 'date'];
}
