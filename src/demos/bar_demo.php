<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-2
 * Time: 下午10:19
 */
require_once (__DIR__ . '/requires.php');

$bar = new \Library\Diagram\Bar(78, 20, true);
$bar->addData('beijing', array(23, 43, 31, 84));
$bar->addData('shanghai', array(65, 31, 11, 41));
$bar->display();
