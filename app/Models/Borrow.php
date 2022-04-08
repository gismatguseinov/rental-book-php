<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $table = 'borrows';

    protected $fillable = [
        'reader_id',
        'book_id',
        'status',
        'request_managed_by',
        'request_processed_at',
        'deadline',
        'returned_at'
    ];

}
