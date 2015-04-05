<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-1
 * Time: 下午1:19
 */

namespace Library\Diagram;

class BarSpeed {

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

    public function run() {
        foreach ($this->_testFunctions as $test_function) {
            $data_tag = substr(strval($test_function), 0, 6);
            $data = array();
            for ($i = 0; $i < $this->_testTimes; $i++) {
                $start_time = microtime(true);
                for ($j = 0; $j < $this->_repeatTimes; $j++) {
                    call_user_func($test_function);
                }
                $end_time = microtime(true);
                $data[] = $end_time - $start_time;
            }
            $this->addData($data_tag, $data);
        }
    }

    public function __call($func, $args) {
        if (is_callable(array($this->_bar, $func))) {
            call_user_func_array(array($this->_bar, $func), $args);
        }
    }

}