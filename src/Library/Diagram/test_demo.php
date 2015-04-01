<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-1
 * Time: 下午1:49
 */
require_once __DIR__ . '/../Point.php';
require_once __DIR__ . '/../Board.php';
require_once __DIR__ . '/DiagramInterface.php';
require_once __DIR__ . '/Diagram.php';
require_once __DIR__ . '/Bar.php';
require_once __DIR__ . '/Tester.php';

function get_shuffle_str() {
    return str_shuffle('hello, world!');
}

function join_echo() {
    $str1 = get_shuffle_str();
    $str2 = get_shuffle_str();
    echo $str1 . $str2 . PHP_EOL;
}

function comma_echo() {
    $str1 = get_shuffle_str();
    $str2 = get_shuffle_str();
    echo $str1, $str2, PHP_EOL;
}

$tester = new \Library\Diagram\Tester();
$tester->addTestFunction('join_echo');
$tester->addTestFunction('comma_echo');
$tester->run();
$tester->display();
$tester->saveToFile('join_comma_diagram.txt', 'join and comma');