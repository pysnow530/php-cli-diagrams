<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-1
 * Time: 下午1:19
 */

namespace Library\Diagram;

class Tester {

    protected $_bar;

    protected $_countTimes;

    protected $_testTimes;

    protected $_testFunctions;

    protected $_datas;

    public function __construct($_countTimes=1000, $_testTimes=4) {
        $this->_bar = new Bar(78, 20, true);
        $this->_countTimes = $_countTimes;
        $this->_testTimes = $_testTimes;
        $this->_testFunctions = array();
        $this->_datas = array();
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
                for ($j = 0; $j < $this->_countTimes; $j++) {
                    call_user_func($test_function);
                }
                $end_time = microtime(true);
                $data[] = $end_time - $start_time;
            }
            $this->_bar->addData($data_tag, $data);
        }
    }

    public function display() {
        $this->_bar->display();
    }

    public function saveToFile($path, $tag=null) {
        $this->_bar->saveToFile($path, $tag);
    }

}