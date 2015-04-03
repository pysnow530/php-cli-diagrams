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
        $this->_x = self::_toBoardZ($x, $boardWidth);
        $this->_y = self::_toBoardZ($y, $boardHeight);
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
        return $this->_x;
    }

    /**
     * @return int
     */
    public function getY() {
        return $this->_y;
    }

    public function setP($x, $y) {
        $this->setX($x);
        $this->setY($y);

        return $this->getP();
    }

    public function setX($x) {
        $this->_x = self::_toBoardZ($x, $this->_board_width);

        return $this->getX();
    }

    public function setY($y) {
        $this->_y = self::_toBoardZ($y, $this->_board_height);

        return $this->getY();
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
        $deltaX = self::_toBoardZ($deltaX, $this->_board_width);
        $this->_x += $deltaX;

        return $this;
    }

    /**
     * @param $deltaY
     * @return $this
     */
    public function transY($deltaY) {
        $deltaY = self::_toBoardZ($deltaY, $this->_board_height);
        $this->_y += $deltaY;

        return $this;
    }

    public function to($point) {
        return new PointIterator($this, $point);
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
    private static function _toBoardZ($p, $boardSide) {
        if (is_float($p)) {
            $p = intval($p * $boardSide);
        }

        return $p;
    }

}