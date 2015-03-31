<?php
require __DIR__ . '/Board.php';

$board = new \Library\Board(78, 20, true);
$board->drawPoint(1, 2, 'o');
$board->drawRectangle(3, 4, 10, 14);
$board->drawLine(1, 6, 22, 6);
$board->drawText(30, 15, 'hello, world!');
print $board;
$board->saveToFile('diagram.txt', 'demo diagram');
