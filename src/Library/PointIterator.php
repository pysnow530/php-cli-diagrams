<?php
/**
 * Created by PhpStorm.
 * User: pysnow530
 * Date: 4/3/15
 * Time: 1:41 PM
 */

namespace Library;


class PointIterator implements \Iterator {

    protected $_from_point;
    protected $_to_point;

    protected $_current_point;

    protected $_key;

    public function __construct($from_point, $to_point) {
        $this->_from_point = $from_point;
        $this->_to_point = $to_point;
        self::standardizeTwoPoint($from_point, $to_point);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        // DONE: Implement current() method.
        return $this->_current_point;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        // DONE: Implement next() method.
        if ($this->_current_point->getX() == $this->_to_point->getX()) {
            $this->_current_point->setX($this->_from_point->getX());
            $this->_current_point->transY(1);
        } else {
            $this->_current_point->transX(1);
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        // DONE: Implement key() method.
        return $this->_key;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        // DONE: Implement valid() method.
        return $this->_current_point->getY() <= $this->_to_point->getY();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        // DONE: Implement rewind() method.
        $this->_current_point = $this->_from_point;
        $this->_key = 0;
    }

    protected static function standardizeTwoPoint(&$point1, &$point2) {
        $sx = min($point1->getX(), $point2->getX());
        $sy = min($point1->getY(), $point2->getY());
        $ex = max($point1->getX(), $point2->getX());
        $ey = max($point1->getY(), $point2->getY());

        $point1->setP($sx, $sy);
        $point2->setP($ex, $ey);

        return array($point1, $point2);
    }

}