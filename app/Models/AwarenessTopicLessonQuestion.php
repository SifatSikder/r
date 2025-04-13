<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AwarenessTopicLessonQuestion extends Eloquent
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
    protected $collection = 'awareness_topic_lesson_questions';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $fillable = [
        'awareness_id',
        'topic_id',
        'lesson_id',
        'question',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'answer',
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
