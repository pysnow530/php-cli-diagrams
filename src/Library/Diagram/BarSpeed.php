<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-1
 * Time: 下午1:19
 */

namespace Library\Diagram;

class BarSpeed extends Speed {

    protected $_repeatTimes;

    protected $_testTimes;

    protected $_testFunctions;

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

}