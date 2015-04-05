<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-5
 * Time: 下午1:33
 */
require_once (__DIR__ . '/requires.php');

$bar = new \Library\Diagram\Scatter(78, 20, true);
$bar->addData('beijing', array(23, 43, 21, 84));
$bar->addData('shanghai', array(65, 31, 21, 41));
$bar->display();
