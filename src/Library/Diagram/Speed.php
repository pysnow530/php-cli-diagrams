<?php
/**
 * Created by PhpStorm. speed base class
 * User: pysnow
 * Date: 15-4-5
 * Time: 下午1:08
 */

namespace Library\Diagram;


class Speed {

    // diagram driver
    protected $_driver;

    protected $_repeatTimes;

    protected $_testTimes;

    protected $_testFunctions;

    public function __construct($width=78, $height=20, $withBorder=true) {
        $this->_driver = new Bar($width, $height, $withBorder);
        $this->setRepeatTimes();
        $this->setTestTimes();
        $this->clearTestFunction();
        $this->clearData();
    }

    public function setDriver($class) {
        if (class_exists($class)) {
            $this->_driver = new $class($this->_driver->getWidth(), $this->_driver->getHeight(), $this->_driver->isWithBorder());
        } else {
            throw new \Exception('Unknown diagram driver: ' . $class);
        }
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
        if (is_callable(array($this->_driver, $func))) {
            call_user_func_array(array($this->_driver, $func), $args);
        }
    }

}