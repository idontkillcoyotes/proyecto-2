<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function bodyItem()
    {
        return $this->hasOne('App\BodyItem');
    }

    public function headItem()
    {
        return $this->hasOne('App\HeadItem');
    }

    public function upperBodyItem()
    {
        return $this->hasOne('App\UpperBodyItem');
    }

    public function lowerBodyItem()
    {
        return $this->hasOne('App\LowerBodyItem');
    }

    public function extraItem()
    {
        return $this->hasOne('App\ExtraItem');
    }
}