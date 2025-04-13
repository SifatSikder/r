<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Blog extends Eloquent
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * The collection associated with the model.
     *
     * @var string
     */
    protected $collection = 'blog';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'banner_full_path'
    ];

    /**
     * Get the full path of the banner attribute.
     *
     * @return string|null
     */
    public function getBannerFullPathAttribute()
    {
        if (isset($this->attributes['banner']) && $this->attributes['banner'] != null) {
            return asset('storage/media/image/'.$this->attributes['banner']);
        }
        return null;
    }
}
