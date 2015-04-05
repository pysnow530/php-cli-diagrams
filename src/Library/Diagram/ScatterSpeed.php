<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-5
 * Time: 下午4:43
 */

namespace Library\Diagram;

class ScatterSpeed extends Speed {

    protected $_repeatTimes;

    protected $_testTimes;

    protected $_testFunctions;

    public function run() {
        $this->setTestTimes(40);
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

}