<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-2
 * Time: 下午10:19
 */
require_once (__DIR__ . '/requires.php');

$board = new \Library\Board(78, 20, true);
$board->drawPoint(1, 1, 'o');
$board->drawRectangle(3, 4, 10, 14, '*');
$board->drawRectangle(43, 14, 50, 18, '-');
$board->drawLine(1, 6, 22, 6);
$board->drawText(30, 15, 'hello, world!');
print $board;