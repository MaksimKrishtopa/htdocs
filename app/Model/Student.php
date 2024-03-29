<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id_student';
    public $timestamps = false;

    public function getGroupNumber()
    {
        // Получаем объект группы по идентификатору
        $group = Grupa::find($this->grupa);

        // Проверяем, найдена ли группа
        if ($group) {
            return $group->grup_number;
        }

        return 'Группа не найдена';
    }
}