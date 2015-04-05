<?php
/**
 * bar diagram class
 *
 * @author pysnow530
 * @version $Id$
 * @copyright pysnow530, 31 March, 2015
 * @package default
 **/
namespace Library\Diagram;

use Library\BoardPoint;

class Bar extends Diagram implements DiagramInterface {

    protected static $_fillChars = '.*=~!@#$%^&()_+';

    public function generate() {
        // draw scale
        list($real_min, $real_max) = $this->_getRealRange();
        $this->_drawScale($real_min, $real_max);

        // draw bars
        $nr_datas = count($this->_datas);
        $nr_data = count(array_values($this->_datas)[0]);
        $nr_columns = $nr_data * ($nr_datas + 1) + 1;
        $bar_values = array_values($this->_datas);

        $bar_from_point = $this->getPoint();
        $bar_to_point = $this->getPoint();
        for ($i = 0; $i < $nr_columns; $i++) {
            $index_column = $i % ($nr_datas + 1);
            if ($index_column == 0) {
                continue;
            }
            $index_column--;
            $bar_from_point->setP($i / $nr_columns, 0);
            $value = $bar_values[$index_column][intval($i / ($nr_datas + 1))];
            $y = $this->_getY($value, $real_min, $real_max);
            $bar_to_point->setP(($i + 1) / $nr_columns, $y);
            $this->drawRectangle($bar_from_point, $bar_to_point, self::$_fillChars[$index_column]);
        }

        // draw legend
        $this->_drawLegend(self::$_fillChars);
    }

}
