<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-5
 * Time: 下午4:44
 */
require (__DIR__ . '/requires.php');

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

$tester = new \Library\Diagram\ScatterSpeed();
$tester->setDriver('\Library\Diagram\Scatter');
$tester->addTestFunction('join_echo');
$tester->addTestFunction('comma_echo');
$tester->run();
$tester->display();
// $tester->saveToFile('join_comma_diagram.txt', 'join and comma');
