<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $table = 'discipline';
    protected $primaryKey = 'id_discipline';
    public $timestamps = false;
}