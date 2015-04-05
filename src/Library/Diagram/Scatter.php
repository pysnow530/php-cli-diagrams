<?php
/**
 * Created by PhpStorm.
 * User: pysnow
 * Date: 15-4-5
 * Time: 下午1:25
 */

namespace Library\Diagram;


class Scatter extends Diagram implements DiagramInterface {

    protected static $_fillChars = '.o*@#+-';

    public function generate() {
        list($real_min, $real_max) = $this->_getRealRange();
        $this->_drawScale($real_min, $real_max);

        // draw scatter
        $nr_data = count(array_values($this->_datas)[0]);
        $nr_columns = $nr_data + 1;
        $bar_values = array_values($this->_datas);

        $scatter_point = $this->getPoint();
        foreach ($bar_values as $i => $bar_value) {
            for ($j = 1; $j < $nr_columns; $j++) {
                $y = $this->_getY($bar_value[$j - 1], $real_min, $real_max);
                $scatter_point->setP($j / $nr_columns, $y);
                $char = $this->_mapGet($scatter_point);
                $this->drawPoint($scatter_point, $char == ' ' ? self::$_fillChars[$i] : '?');
            }
        }

        $this->_drawLegend(self::$_fillChars);
    }

}