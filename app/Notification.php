<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class Notification extends Model
{
    use Rememberable;

    public $rememberCacheTag = 'notifications';
    public $rememberFor = 3600;

    /**
     * Assignable notification values
     *
     * @var array
     */
    protected $fillable = [
        'for_author',
        'from_user',
        'post_id',
        'type'
    ];

    /**
     * The related objects that should be included
     *
     * @var array
     */
    protected $with = [
        'for',
        'from',
        'post'
    ];

    public function for() {
        return $this->belongsTo('App\User', 'for_author');
    }

    public function from() {
        return $this->belongsTo('App\User', 'from_user');
    }

    public function post() {
        return $this->belongsTo('App\Post', 'post_id');
    }
}
