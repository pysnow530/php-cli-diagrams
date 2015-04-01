<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-1
 * Time: 下午3:16
 */

namespace Library;


class Point {

    protected $_board_width;
    protected $_board_height;

    protected $_x;
    protected $_y;

    /**
     * @param $boardWidth  int
     * @param $boardHeight int
     * @param $x    float or int
     * @param $y    float or int
     */
    public function __construct($boardWidth, $boardHeight, $x=0, $y=0) {
        $this->_board_width = $boardWidth;
        $this->_board_height = $boardHeight;
        $this->_x = self::_toInnerP($x, $boardWidth);
        $this->_y = self::_toInnerP($y, $boardHeight);
    }

    /**
     * @return array
     */
    public function getP() {
        $x = $this->getX();
        $y = $this->getY();

        return array($x, $y);
    }

    /**
     * @return int
     */
    public function getX() {
        $x = self::_toBoardP($this->_x, $this->_board_width);

        return $x;
    }

    /**
     * @return int
     */
    public function getY() {
        $y = self::_toBoardP($this->_y, $this->_board_height);

        return $y;
    }

    /**
     * @param $deltaX
     * @param $deltaY
     * @return $this
     */
    public function transP($deltaX, $deltaY) {
        $this->transX($deltaX);
        $this->transY($deltaY);

        return $this;
    }

    public function transX($deltaX) {
        $deltaX = self::_toInnerP($deltaX, $this->_board_width);
        $this->_x += $deltaX;

        return $this;
    }

    /**
     * @param $deltaY
     * @return $this
     */
    public function transY($deltaY) {
        $deltaY = self::_toInnerP($deltaY, $this->_board_height);
        $this->_y += $deltaY;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString() {
        return 'Point(' . $this->getX() . ', ' . $this->getY() . ')';
    }

    /**
     * @param $p
     * @param $boardSide
     * @return float
     */
    private static function _toInnerP($p, $boardSide) {
        if (is_int($p)) {
            $p = floatval($p / $boardSide);
        }

        return $p;
    }

    /**
     * @param $p
     * @param $boardSide
     * @return int
     */
    private static function _toBoardP($p, $boardSide) {
        if (is_float($p)) {
            $p = intval($p * $boardSide);
        }

        return $p;
    }

}