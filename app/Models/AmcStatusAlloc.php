<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmcStatusAlloc extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'amc_status_allocs';

    protected $dates = [
        'amc_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'asset_id',
        'school_id',
        'location_id',
        'sub_location_id',
        'product_status_id',
        'amc_date',
        'amc_remarks',
        'amc_status_id',
        // 'amc_multi_gallery',
        'amc_status_id',
        'video',
        'amc_agent',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


     public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }


     public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

     public function sublocation()
    {
        return $this->belongsTo(Location::class, 'sub_location_id');
    }

      public function status()
    {
        return $this->belongsTo(Status::class, 'product_status_id');
    }

     public function amcdate()
    {
        return $this->belongsTo(AmcStatus::class, 'amc_date');
    }


     public function AmcImageGallery()
    {
        return $this->hasMany(AmcgalleryImage::class, 'amcgallery_id');
    }

    public function asset()
{
    return $this->belongsTo(Allocation::class, 'asset_id');
}


     public function amcStatus()
    {
        return $this->belongsTo(AmcStatus::class, 'amc_status_id');
    }


}




    // public function getAmcDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setAmcDateAttribute($value)
    // {
    //     $this->attributes['amc_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }
