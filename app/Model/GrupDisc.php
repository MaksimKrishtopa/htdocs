<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class GrupDisc extends Model
{
    protected $table = 'grup-disc';
    protected $primaryKey = 'Id_grup-disc';
    public $timestamps = false;

    protected $fillable = ['id_grup', 'id_discipline', 'hours', 'control_type'];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class, 'id_discipline');
    }

    public function group()
{
    return $this->belongsTo(Grupa::class, 'id_grup');
}

}
