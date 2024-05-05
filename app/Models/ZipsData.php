<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipsData extends Model
{
    use HasFactory;

    protected $fillable  = [
        "user_id",
        "name",
        "folder_id",
        "img_1",
        "img_2",
        "img_3",
        "img_4",
        "img_5",
    ];

}
