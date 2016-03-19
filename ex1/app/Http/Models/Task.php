<?php namespace App\Http\Models;

use Carbon\Carbon;


/**
 * @property int uuid
 * @property string $content
 * @property int $type
 * @property int $sort_order
 * @property int $done
 * @property Carbon $date_created
 */
class Task extends Model
{
    const TYPE_SHOPPING = 'shopping';
    const TYPE_WORK = 'work';
    const MAX_SORT_ORDER = '2147483647';

    protected $table = 'tasks';
    protected $primaryKey = 'uuid';

    protected $casts = [
        'done' => 'boolean'
    ];
    protected $dates = ['date_created'];
//    public $timestamps = true;

    /**
     * @return array
     */

    public static function types_names()
    {
        return [self::TYPE_SHOPPING, self::TYPE_WORK];
    }

}