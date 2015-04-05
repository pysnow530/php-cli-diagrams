<?php
/**
 * Created by PhpStorm. speed base class
 * User: pysnow
 * Date: 15-4-5
 * Time: 下午1:08
 */

namespace Library\Diagram;


class Speed {

    protected $_bar;

    protected $_repeatTimes;

    protected $_testTimes;

    protected $_testFunctions;

    public function __construct($width=78, $height=20, $withBorder=true) {
        $this->_bar = new Bar($width, $height, $withBorder);
        $this->setRepeatTimes();
        $this->setTestTimes();
        $this->clearTestFunction();
        $this->clearData();
    }

    public function setRepeatTimes($repeatTimes=1000) {
        $this->_repeatTimes = $repeatTimes;
    }

    public function setTestTimes($testTimes=4) {
        $this->_testTimes = $testTimes;
    }

    public function clearTestFunction() {
        $this->_testFunctions = array();
    }

    public function addTestFunction($function) {
        if (!is_callable($function)) {
            throw new \Exception($function . ' is not callable!');
        } else {
            $this->_testFunctions[] = $function;
        }
    }

    public function __call($func, $args) {
        if (is_callable(array($this->_bar, $func))) {
            call_user_func_array(array($this->_bar, $func), $args);
        }
    }

}