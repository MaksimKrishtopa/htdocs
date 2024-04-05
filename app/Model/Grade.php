<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grade';
    protected $primaryKey = 'id_grade';
    public $timestamps = false;
    protected $fillable = ['id_student', 'Id_grup-disc', 'grades'];

    
    public function student()
    {
        return $this->belongsTo(Student::class, 'id_student', 'id_student');
    }

    public function grupDisc()
    {
        return $this->belongsTo(GrupDisc::class, 'Id_grup-disc', 'Id_grup-disc');
    }
}
