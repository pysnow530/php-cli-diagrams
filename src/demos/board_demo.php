<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-2
 * Time: 下午10:19
 */
require_once (__DIR__ . '/requires.php');

$board = new \Library\Board(78, 20, true);
$board->drawPoint($board->getPoint(1, 1), 'o');
$board->drawRectangle($board->getPoint(3, 4), $board->getPoint(10, 14), '.');
$board->drawRectangle($board->getPoint(43, 14), $board->getPoint(50, 18), 'x');
$board->drawLine($board->getPoint(1, 6), $board->getPoint(22, 6));
$board->drawText($board->getPoint(30, 15), 'hello, world!');
print $board;