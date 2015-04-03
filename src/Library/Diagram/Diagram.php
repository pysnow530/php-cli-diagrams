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

use Library\Board;

class Diagram extends Board {

    protected $_datas;

    public function addData($tag, $data) {
        $this->_datas[$tag] = $data;
    }

    public function clearData() {
        $this->_datas = array();
    }

    public function __toString() {
        $this->generate();

        return parent::__toString();
    }

}
