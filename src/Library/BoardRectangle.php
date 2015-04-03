<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-3
 * Time: 下午9:49
 */

namespace Library;


class BoardRectangle {

    protected $_width;
    protected $_height;

    public function __construct($width, $height) {
        $this->_width = $width;
        $this->_height = $height;
    }

    public function getWidth() {
        return $this->_width;
    }

    public function getHeight() {
        return $this->_height;
    }

    public function getRect() {
        return array($this->getWidth(), $this->getHeight());
    }

}