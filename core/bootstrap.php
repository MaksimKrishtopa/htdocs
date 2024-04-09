<?php
use Settings\Settings;
use Src\Route;
//Путь до директории с конфигурационными файлами
const DIR_CONFIG = '/../config';

//Подключение автозагрузчика composer
require_once __DIR__ . '/../vendor/autoload.php';

//Функция, возвращающая массив всех настроек приложения
function getConfigs(string $path = DIR_CONFIG): array
{
   $settings = [];
   foreach (scandir(__DIR__ . $path) as $file) {
       $name = explode('.', $file)[0];
       if (!empty($name)) {
           $settings[$name] = include __DIR__ . "$path/$file";
       }
   }
   return $settings;
}


require_once __DIR__ . '/../routes/web.php';
$app = new Src\Application(new Settings(getConfigs()));

$settings = new Settings(getConfigs());

// Создаем экземпляр класса Route, передавая ему экземпляр класса Settings в конструктор
$route = Route::single($settings);


//Функция возвращает глобальный экземпляр приложения
function app() {
   global $app;
   return $app;
}

return $app;
