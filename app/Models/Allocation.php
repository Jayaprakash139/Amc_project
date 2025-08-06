<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Allocation extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, HasFactory;

    public $table = 'allocations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'school_id',
        'sublocation_id',
        'aaset_category_id',
        'asset_name',
        'asset_code',
        'description',

        'location_id',

        'amc_status_id',
   
        'status_id',
        'remark',
        'created_at',
        'custody_id',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
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
        return $this->belongsTo(Location::class, 'sublocation_id');
    }

    public function aaset_category()
    {
        return $this->belongsTo(Category::class, 'aaset_category_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function custody()
    {
        return $this->belongsTo(Employee::class, 'custody_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    public function customFields()
{
    return $this->hasMany(Customfield::class, 'allot_id','unique_id');
}

public function amcStatus()
{
    return $this->belongsTo(AmcStatus::class, 'amc_status_id');
}


}
