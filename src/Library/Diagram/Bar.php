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
        // generate bars
        $nr_datas = count($this->_datas);
        if ($nr_datas == 0) {
            throw \Exception('No data to draw!');
        }
        $nr_data = count(array_values($this->_datas)[0]);
        $nr_columns = $nr_data * ($nr_datas + 1) + 1;
        $column_width = $this->_rectangle->getWidth() / $nr_columns;

        $bar_values = array_values($this->_datas);

        // get min max
        $min = $max = $bar_values[0][0];
        foreach ($bar_values as $data_tag => $bar_value) {
            foreach ($bar_value as $bar_tag => $value) {
                $value < $min and $min = $value;
                $value > $max and $max = $value;
            }
        }
        $gap_ratio = 0.2;
        $real_min = $min - ($max - $min) * $gap_ratio;
        $real_max = $max + ($max - $min) * $gap_ratio;
        $real_height = $real_max - $real_min;

        for ($i = 0; $i < $nr_columns; $i++) {
            $index = $i % ($nr_datas + 1);
            if ($index == 0) {
                continue;
            }
            $index--;
            $sx = $i * $column_width;
            $sy = 0;
            $ex = $sx + $column_width;
            $ey = (array_values($bar_values[$index])[intval($i / ($nr_datas + 1))] - $real_min) / $real_height;
            $this->drawRectangle(new BoardPoint($this->_rectangle, $sx, $sy), new BoardPoint($this->_rectangle, $ex, $ey), self::$_fillChars[$index]);
            $this->drawText(new BoardPoint($this->_rectangle, $sx, $ey), strval($bar_values[$index][intval($i / ($nr_datas + 1))]));
            $this->drawText(new BoardPoint($this->_rectangle, $sx, 0), strval(array_keys($bar_values[$index])[intval($i / ($nr_datas + 1))]));
        }

        // generate legend
        $this->_drawLegend(self::$_fillChars);

        // generate scale
        $this->drawText($this->getPoint(1, 1), strval($real_min));
        $this->drawText($this->getPoint(0, 0.5), strval(($real_min + $real_max) / 2));
        $this->drawText($this->getPoint(0, 1.0), strval($real_max));
    }

}
