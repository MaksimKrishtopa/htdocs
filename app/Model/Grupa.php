<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Grupa extends Model
{
    protected $table = 'grupa';
    protected $primaryKey = 'id_grupa';
    public $timestamps = false;

    protected $fillable = ['grup_number', 'course', 'semester'];

    public static function find($id)
    {
        return static::where('id_grupa', $id)->first();
    }

}