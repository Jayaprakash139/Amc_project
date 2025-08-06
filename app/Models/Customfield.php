<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customfield extends Model
{
    use HasFactory;
    protected $fillable = [
        'allot_id',
       'name',
       'text_number',
         'created_at',
         'updated_at',
         'deleted_at',
     ];
}
