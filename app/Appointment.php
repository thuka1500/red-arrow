<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    const SENT      = 'SENT';
    const ACCEPTED  = 'ACCEPTED';
    const REJECTED  = 'REJECTED';
    const COMPLETED = 'COMPLETED';
    const TIMED_OUT = 'TIMED_OUT';
    const BETRAYED  = 'BETRAYED';

    protected $fillable = [
        'hospital_id', 'donor_id', 'status', 'donor_review'
    ];

    public function donor()
    {
        return $this->belongsTo('App\Donor');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
}
