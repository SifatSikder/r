<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Awareness extends Eloquent
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
    protected $collection = 'awareness';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $fillable = [
        'type',
        'category',
        'title',
        'slug',
        'description',
        'banner',
        'certificate'
    ];

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

    protected $appends = ['banner_full_path'];

    public function getBannerFullPathAttribute()
    {
        if(isset($this->attributes['banner']) && $this->attributes['banner'] != null) {
            return asset('/storage/media/image/' . $this->attributes['banner']);
        } else {
            return null;
        }
    }
}
