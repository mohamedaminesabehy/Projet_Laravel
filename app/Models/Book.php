<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'book';

    protected $fillable = [
        'title',
        'author',
        'category',
        'isbn',
        'price',
        'stock',
        'description',
        'cover_image',
        'status',
    ];
}
