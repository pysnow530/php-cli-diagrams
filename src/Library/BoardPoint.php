<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-1
 * Time: 下午3:16
 */

namespace Library;


class BoardPoint {

    protected $_rectangle;

    protected $_x;
    protected $_y;

    /**
     * @param $boardWidth  int
     * @param $boardHeight int
     * @param $x    float or int
     * @param $y    float or int
     */
    public function __construct(BoardRectangle $rectangle, $x=0, $y=0) {
        $this->_rectangle = $rectangle;
        $this->_x = self::_toBoardZ($x, $rectangle->getWidth());
        $this->_y = self::_toBoardZ($y, $rectangle->getHeight());
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
        $this->_x = self::_toBoardZ($x, $this->_rectangle->getWidth());

        return $this->getX();
    }

    public function setY($y) {
        $this->_y = self::_toBoardZ($y, $this->_rectangle->getHeight());

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
        $deltaX = self::_toBoardZ($deltaX, $this->_rectangle->getWidth());
        $this->_x += $deltaX;

        return $this;
    }

    /**
     * @param $deltaY
     * @return $this
     */
    public function transY($deltaY) {
        $deltaY = self::_toBoardZ($deltaY, $this->_rectangle->getHeight());
        $this->_y += $deltaY;

        return $this;
    }

    public function to($point) {
        return new BoardPointIterator($this, $point);
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
     * @return int
     */
    private static function _toBoardZ($p, $boardSide) {
        if (is_float($p)) {
            $p = intval($p * $boardSide);
        }

        return $p;
    }

}