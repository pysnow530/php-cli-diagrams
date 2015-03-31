<?php
require __DIR__ . '/../Board.php';
require __DIR__ . '/DiagramInterface.php';
require __DIR__ . '/Diagram.php';
require __DIR__ . '/Bar.php';

$bar = new \Library\Diagram\Bar(78, 20, true);
$bar->addData('beijing', array(23, 43, 31, 84));
$bar->addData('shanghai', array(65, 31, 11, 41));
$bar->display();
