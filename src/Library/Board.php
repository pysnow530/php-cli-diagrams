<?php
/**
 * Created by PhpStorm.
 * User: pysnow530
 * Date: 3/30/15
 * Time: 11:21 AM
 */

namespace Library;

class Board {

    protected $_width;
    protected $_height;
    protected $_withBoard;
    protected $_map;

    public function __construct($width=78, $height=20, $withBoard=true) {
        $this->_width = $width;
        $this->_height = $height;
        $this->_withBoard = $withBoard;

        $this->clear();
    }

    public function getWidth() {
        return $this->_width;
    }

    public function getHeight() {
        return $this->_height;
    }

    /**
     * clear board(init board map)
     */
    public function clear() {
        $this->_map = array();

        for ($x = 0; $x < $this->_width; $x++) {
            for ($y = 0; $y < $this->_height; $y++) {
                $this->_map[$x][$y] = ' ';
            }
        }
    }

    /**
     * draw point
     * @param $x
     * @param $y
     * @param $char     BoardPoint character
     */
    public function drawPoint($x, $y, $char='o') {
        $point = new BoardPoint($this->_width, $this->_height, $x, $y);
        self::_mapSet($point, $char);
    }

    public function drawLine($sx, $sy, $ex, $ey) {
        $from_point = new BoardPoint($this->_width, $this->_height, $sx, $sy);
        $to_point = new BoardPoint($this->_width, $this->_height, $ex, $ey);

        if ($from_point->getX() == $to_point->getX()) {
            foreach ($from_point->to($to_point) as $point) {
                $this->_mapSet($point, '|');
            }
        } elseif ($from_point->getY() == $to_point->getY()) {
            foreach ($from_point->to($to_point) as $point) {
                $this->_mapSet($point, '-');
            }
        } else {
            throw new \Exception('Cannot draw slash line!');
        }
    }

    /**
     * @param $sx
     * @param $sy
     * @param $ex
     * @param $ey
     * @param null $fillChar
     */
    public function drawRectangle($sx, $sy, $ex, $ey, $fillChar=null) {
        list($sxp, $exp, $syp, $eyp) = $this->_correctRect($sx, $sy, $ex, $ey);

        for ($x = $sxp; $x <= $exp; $x++) {
            for ($y = $syp; $y <= $eyp; $y++) {
                $vertical = in_array($x, array($sxp, $exp));
                $horizontal = in_array($y, array($syp, $eyp));
                $rectPoint = new BoardPoint($this->_width, $this->_height, $x, $y);
                if ($vertical && $horizontal) {
                    $this->_mapSet($rectPoint, '+');
                } elseif ($vertical) {
                    $this->_mapSet($rectPoint, '|');
                } elseif ($horizontal) {
                    $this->_mapSet($rectPoint, '-');
                } elseif (!is_null($fillChar)) {
                    $this->_mapSet($rectPoint, $fillChar);
                }
            }
        }
    }

    /**
     * @param $x
     * @param $y
     * @param $text
     */
    public function drawText($x, $y, $text) {
        $textPoint = new BoardPoint($this->_width, $this->_height, $x, $y);

        for ($i = 0; $i < strlen($text); $i++) {
            $this->_mapSet($textPoint, $text[$i]);
            $textPoint->transX(1);
        }
    }

    /**
     * display board
     */
    public function display() {
        print $this->__toString();
    }

    /**
     * save to file
     * @param $path
     * @param $tag
     */
    public function saveToFile($path, $tag=null) {
        $string = $tag ? $tag . PHP_EOL : '';
        $string .= $this->__toString();

        return file_put_contents($path, $string);
    }

    public function __toString() {
        $string = '';
        $head_tail = '+' . str_repeat('-', $this->_width) . '+' . PHP_EOL;

        // display head
        $this->_withBoard and $string .= $head_tail;

        for ($y = $this->_height; $y > 0; $y--) {
            $this->_withBoard and $string .= '|';
            $stringPoint = new BoardPoint($this->_width, $this->_height, 1, $y);
            for ($x = 1; $x <= $this->_width; $x++) {
                $string .= self::_mapGet($stringPoint);
                $stringPoint->transX(1);
            }
            $this->_withBoard and $string .= '|';
            $string .= PHP_EOL;
        }

        // display tail
        $this->_withBoard and $string .= $head_tail;

        return $string;
    }

    protected function _mapGet($point) {
        list($x, $y) = $point->getP();

        if (isset($this->_map[$x][$y])) {
            return $this->_map[$x][$y];
        } else {
            return ' ';
        }
    }

    protected function _mapSet($point, $char) {
        list($x, $y) = $point->getP();

        $this->_map[$x][$y] = $char;
    }

    public static function _get_position($p, $side)
    {
        if (is_float($p)) {
            if ($p <= 1.0) {
                $p = intval($p * $side);
                return $p == $side ? $side - 1 : $p;
            } else {
                return intval($p);
            }
        } elseif (is_int($p)) {
            return $p;
        }
    }

    /**
     * @param $sx
     * @param $sy
     * @param $ex
     * @param $ey
     * @return array
     */
    protected function _correctRect($sx, $sy, $ex, $ey)
    {
        $sx = $this->_get_position($sx, $this->_width);
        $ex = $this->_get_position($ex, $this->_width);
        $sy = $this->_get_position($sy, $this->_height);
        $ey = $this->_get_position($ey, $this->_height);

        $sxp = min($sx, $ex);
        $exp = max($sx, $ex);
        $syp = min($sy, $ey);
        $eyp = max($sy, $ey);

        return array($sxp, $exp, $syp, $eyp);
    }

}
