<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $table = 'events';

    public $timestamps = false;

    protected $fillable = [
        'title', 'description', 'date_at', 'a_seats', 'age_start', 'age_end',
    ];

    public function users() {
        return $this->hasMany(UserEvent::class);
    }

}
