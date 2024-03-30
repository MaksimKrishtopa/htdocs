<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $primaryKey = 'id_student';
    public $timestamps = false;
    protected $fillable = ['surname', 'name', 'patronymic', 'gender', 'birthday','address', 'grupa'];

    public function getGroupNumber()
    {
       
        $group = Grupa::find($this->grupa);

    
        if ($group) {
            return $group->grup_number;
        }

        return 'Группа не найдена';
    }
}