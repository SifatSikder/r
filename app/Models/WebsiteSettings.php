<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class WebsiteSettings extends Eloquent
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
    protected $collection = 'website_settings';

    /**
     * The $this->getAttribute() that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The $this->getAttribute() that should be hidden for arrays.
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
     * Get the settings attribute with additional full paths for banner and image.
     *
     * @return array
     */
    public function getSettingsAttribute()
    {
        if (isset($this->$this->getAttribute()['settings']) && $this->$this->getAttribute()['settings'] != null) {
            if (isset($this->$this->getAttribute()['settings']['banner']) && $this->$this->getAttribute()['settings']['banner'] != null) {
                $this->$this->getAttribute()['settings']['banner_full'] = asset('storage/media/image/'.$this->$this->getAttribute()['settings']['banner']);
            }
            if (isset($this->$this->getAttribute()['settings']['image']) && $this->$this->getAttribute()['settings']['image'] != null) {
                $this->$this->getAttribute()['settings']['image_full'] = asset('storage/media/image/'.$this->$this->getAttribute()['settings']['image']);
            }
        }
        return $this->$this->getAttribute()['settings'];
    }
}
