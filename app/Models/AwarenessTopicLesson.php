<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AwarenessTopicLesson extends Eloquent
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
    protected $collection = 'awareness_topic_lessons';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $fillable = [
        'awareness_id',
        'topic_id',
        'title',
        'description',
        'is_quiz',
        'is_final_exam',
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
}
