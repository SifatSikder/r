<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Evaluation extends Eloquent
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
    protected $collection = 'evaluations';

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
     * Convert risk value to risk level.
     *
     * @param float $risk
     * @return string
     */
    public static function riskToLevel($risk)
    {
        // Logic to determine risk level based on provided thresholds
        if ($risk <= 0) {
            return 'No';
        } elseif ($risk > 0 && $risk <= 3.3) {
            return 'Low';
        } elseif ($risk > 3.3 && $risk <= 6.6) {
            return 'Limited';
        } elseif ($risk > 6.6 && $risk <= 9.9) {
            return 'High';
        } elseif ($risk > 9.9) {
            return 'Unacceptable';
        }
    }

    /**
     * Convert risk level to corresponding color.
     *
     * @param float $risk
     * @return string
     */
    public static function levelToColor($risk)
    {
        // Logic to determine color based on risk level
        if ($risk == 0) {
            return '#ffffff'; // white
        } elseif ($risk > 0 && $risk <= 3.3) {
            return '#198754'; // Green
        } elseif ($risk > 3.3 && $risk <= 6.6) {
            return '#777777'; // Gray
        } elseif ($risk > 6.6 && $risk <= 9.9) {
            return '#dc3545'; // Red
        } elseif ($risk > 9.9) {
            return '#A2232FFF'; // Extra Danger
        }
    }
}
