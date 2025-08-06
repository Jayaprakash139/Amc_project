<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmcgalleryImage extends Model
{
    use HasFactory;

    protected $table = 'amcgallery_images';

    protected $fillable = [
        'amcgallery_id',
        'image',
        'created_at',
        'updated_at',
    ];

    public function amcgallery()
    {
        return $this->belongsTo(AmcStatusAlloc::class, 'amcgallery_id');
    }
}
