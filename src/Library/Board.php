<?php
/**
 * Created by PhpStorm.
 * User: pysnow530
 * Date: 3/30/15
 * Time: 11:21 AM
 */

namespace Library;

class Board {

    protected $_rectangle;
    protected $_withBorder;
    protected $_map;

    public function __construct($width=78, $height=20, $withBoard=true) {
        $this->_width = $width;
        $this->_height = $height;
        $this->_rectangle = new BoardRectangle($width, $height);
        $this->_withBorder = $withBoard;

        $this->clear();
    }

    public function getPoint($x=0, $y=0) {
        return new BoardPoint($this->_rectangle, $x, $y);
    }

    public function getWidth() {
        return $this->_rectangle->getWidth();
    }

    public function getHeight() {
        return $this->_rectangle->getHeight();
    }

    public function isWithBorder() {
        return $this->_withBorder;
    }

    /**
     * clear board(init board map)
     */
    public function clear() {
        $this->_map = array();
    }

    /**
     * draw point
     * @param $x
     * @param $y
     * @param $char     BoardPoint character
     */
    public function drawPoint(BoardPoint $point, $char='o') {
        self::_mapSet($point, $char);
    }

    public function drawLine($from_point, $to_point) {
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
    public function drawRectangle(BoardPoint $from_point, BoardPoint $to_point, $fillChar=null) {
        foreach ($from_point->to($to_point) as $point) {
            $top_bottom = in_array($point->getY(), array($from_point->getY(), $to_point->getY()));
            $left_right = in_array($point->getX(), array($from_point->getX(), $to_point->getX()));
            if ($top_bottom && $left_right) {
                $this->_mapSet($point, '+');
            } elseif ($top_bottom) {
                $this->_mapSet($point, '-');
            } elseif ($left_right) {
                $this->_mapSet($point, '|');
            } else {
                is_null($fillChar) or $this->_mapSet($point, $fillChar);
            }
        }
    }

    /**
     * @param $x
     * @param $y
     * @param $text
     */
    public function drawText(BoardPoint $point, $text) {
        $text_point = clone $point;

        for ($i = 0; $i < strlen($text); $i++) {
            $this->_mapSet($text_point, $text[$i]);
            $text_point->transX(1);
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
        $this->_withBorder and $string .= $head_tail;

        for ($y = $this->_height; $y > 0; $y--) {
            $this->_withBorder and $string .= '|';
            $stringPoint = new BoardPoint($this->_rectangle, 1, $y);
            for ($x = 1; $x <= $this->_width; $x++) {
                $string .= self::_mapGet($stringPoint);
                $stringPoint->transX(1);
            }
            $this->_withBorder and $string .= '|';
            $string .= PHP_EOL;
        }

        // display tail
        $this->_withBorder and $string .= $head_tail;

        return $string;
    }

    protected function _mapGet(BoardPoint $point) {
        list($x, $y) = $point->getP();

        if (isset($this->_map[$x][$y])) {
            return $this->_map[$x][$y];
        } else {
            return ' ';
        }
    }

    protected function _mapSet(BoardPoint $point, $char) {
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
        $sx = $this->_get_position($sx, $this->_rectangle->getWidth());
        $ex = $this->_get_position($ex, $this->_rectangle->getWidth());
        $sy = $this->_get_position($sy, $this->_rectangle->getHeight());
        $ey = $this->_get_position($ey, $this->_rectangle->getHeight());

        $sxp = min($sx, $ex);
        $exp = max($sx, $ex);
        $syp = min($sy, $ey);
        $eyp = max($sy, $ey);

        return array($sxp, $exp, $syp, $eyp);
    }

}
