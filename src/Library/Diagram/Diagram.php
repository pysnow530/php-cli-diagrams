<?php
/**
 * diagram base class
 *
 * @author pysnow530
 * @version $Id$
 * @copyright pysnow530, 30 March, 2015
 * @package default
 **/
namespace Library\Diagram;

class Diagram {

    protected $_board;

    protected $_datas;

    public function __construct($width=78, $height=20, $withBorder=false) {
        $this->_board = new \Library\Board($width, $height, $withBorder);

        $this->_datas = array();
    }

    public function addData($tag, $data) {
        $this->_datas[$tag] = $data;
    }

    public function clearData() {
        $this->_datas = array();
    }

    public function display() {
        echo $this->__toString();
    }

    public function saveToFile($path, $tag=null) {
        $this->generate();
        $this->_board->saveToFile($path, $tag);
    }

    public function __toString() {
        $this->generate();
        return $this->_board->__toString();
    }

}
