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

    public function __construct($width=80, $height=24, $withBoard=false) {
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
     * @param $char     point character
     */
    public function drawPoint($x, $y, $char='o') {
        self::_set($x, $y, $char);
    }

    public function drawLine($sx, $sy, $ex, $ey) {
        list($sxp, $exp, $syp, $eyp) = $this->_correctRect($sx, $sy, $ex, $ey);

        if ($sxp != $exp && $syp != $eyp) {
            throw new \Exception('cannot draw slash line!');
        }

        if ($sxp == $exp) {
            for ($y = $syp; $y <= $eyp; $y++) {
                $this->_set($sxp, $y, in_array($this->_get($sxp, $y), array('+', '-')) ? '+' : '|');
            }
        } elseif ($syp == $eyp) {
            for ($x = $sxp; $x <= $exp; $x++) {
                $this->_set($x, $syp, in_array($this->_get($x, $syp), array('+', '|')) ? '+' : '-');
            }
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
                if ($vertical && $horizontal) {
                    $this->_set($x, $y, '+');
                } elseif ($vertical) {
                    $this->_set($x, $y, '|');
                } elseif ($horizontal) {
                    $this->_set($x, $y, '-');
                } elseif (!is_null($fillChar)) {
                    $this->_set($x, $y, $fillChar);
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
        $x = self::_get_position($x, $this->_width);
        $y = self::_get_position($y, $this->_height);

        for ($i = 0; $i < strlen($text); $i++, $x++) {
            $this->_set($x, $y, $text[$i]);
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

        for ($y = $this->_height - 1; $y >= 0; $y--) {
            $this->_withBoard and $string .= '|';
            for ($x = 0; $x < $this->_width; $x++) {
                $string .= self::_get($x, $y);
            }
            $this->_withBoard and $string .= '|';
            $string .= PHP_EOL;
        }

        // display tail
        $this->_withBoard and $string .= $head_tail;

        return $string;
    }

    protected function _get($x, $y) {
        $x = self::_get_position($x, $this->_width);
        $y = self::_get_position($y, $this->_height);

        if (0 <= $x && $x < $this->_width &&
            0 <= $y && $y < $this->_height) {
            return substr($this->_map[$x][$y], 0, 1);
        } else {
            return null;
        }
    }

    protected function _set($x, $y, $char) {
        $x = self::_get_position($x, $this->_width);
        $y = self::_get_position($y, $this->_height);

        if (0 <= $x && $x < $this->_width &&
            0 <= $y && $y < $this->_height) {
            $this->_map[$x][$y] = $char;
        }
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
