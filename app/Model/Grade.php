<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grade';
    protected $primaryKey = 'id_grade';
    public $timestamps = false;
}