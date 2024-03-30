<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;



class Discipline extends Model
{
    protected $fillable = ['discipline_name'];
    protected $table = 'discipline';
    protected $primaryKey = 'id_discipline';
    public $timestamps = false;
}