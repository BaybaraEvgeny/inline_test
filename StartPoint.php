<?php

// Импорт и инициализация объектов
require 'PDOAdapter.php';
require 'MyLogger.php';

$logger = new MyLogger('log_file.txt');

// Конфигурация бд
$dsn = 'mysql:host=localhost;dbname=inline';
$adapter = new PDOAdapter($dsn, 'root', '', $logger);

// Создание и заполнение таблицы из файла db_test.sql
//$db_test = file_get_contents('db_test.sql');
//$adapter->execute('execute', $db_test);

// 1) Определить максимальный возраст
$max_age = $adapter->execute('selectOne', "
    SELECT MAX(age) AS max FROM person
");
if(gettype($max_age) == 'object') {
    $max_age = $max_age->max;
} else {
    $logger->error('PDO error');
}

// 2) Найти любую персону, у которой mother_id не задан и возраст меньше максимального
$find_person_id = $adapter->execute('selectOne', "
    SELECT id FROM person
    WHERE mother_id IS NULL AND age < ? LIMIT 1
", [$max_age]);
if(gettype($find_person_id) == 'object') {
    $find_person_id = $find_person_id->id;
} else {
    $logger->error('PDO error');
}

//3) Изменение возраста персоны на максимальный. Раскомментировать чтобы изменить
//changeAge($adapter, $max_age, $find_person_id);

//4) Получить список персон максимального возраста
// Надеюсь по возрастанию имелось в виду ASC здесь
$persons_list = $adapter->execute('selectAll', "
SELECT lastname, firstname, age FROM person
WHERE age = (SELECT MAX(age) FROM person)
ORDER BY lastname, firstname
");
if(gettype($persons_list) != 'array') {
    $logger->error('PDO error');
}

//Сама веб страница
require 'WebPage.php';


function changeAge($adapter, $max_age, $find_person_id)
{
    $adapter->execute('execute', "
        UPDATE person SET age = ?
        WHERE id = ?
", [$max_age, $find_person_id]);
}
