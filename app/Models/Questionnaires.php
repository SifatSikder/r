<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Questionnaires extends Eloquent
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
    protected $collection = 'questionnaires';

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
     * Static array defining question groups.
     *
     * @var array
     */
    public static $Groups = ['Software', 'Hardware', 'Ethical', 'Legal'];

    /**
     * Static array defining question types.
     *
     * @var array
     */
    public static $Types = ['Regular', 'Multiple_Answers'];

    /**
     * Get the corresponding answer representation for given marks.
     *
     * @param string $marks
     * @return string
     */
    public static function getMarksToAns($marks)
    {
        if ($marks == '-1') {
            return 'NA';
        } elseif ($marks == 0) {
            return 'Yes';
        } else {
            return 'No';
        }
    }
}
