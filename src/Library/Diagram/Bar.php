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

class Bar extends Diagram implements DiagramInterface {

    protected static $_fillChar = '.*=~!@#$%^&()_+';

    public function generate() {
        // generate bars
        $nr_datas = count($this->_datas);
        $nr_data = count(array_values($this->_datas)[0]);
        $nr_columns = $nr_data * (count($this->_datas) + 1) + 1;
        $column_width = intval($this->getWidth() / $nr_columns);

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
            $this->drawPoint($i * $column_width, 0);
            $sx = $i * $column_width;
            $sy = -1;
            $ex = $sx + $column_width;
            $ey = (array_values($bar_values[$index])[intval($i / ($nr_datas + 1))] - $real_min) / $real_height;
            $this->drawRectangle($sx, $sy, $ex, $ey, self::$_fillChar[$index]);
            $this->drawText($sx, $ey, strval($bar_values[$index][intval($i / ($nr_datas + 1))]));
            $this->drawText($sx, 0, strval(array_keys($bar_values[$index])[intval($i / ($nr_datas + 1))]));
        }

        // generate legend
        $tags = array_keys($this->_datas);
        $legendWidth = max(array_map('strlen', $tags)) + 2;
        $legendHeight = count($this->_datas);
        $ex = $this->getWidth() - 1;
        $ey = $this->getHeight() - 1;
        $sx = $ex - $legendWidth -1;
        $sy = $ey - $legendHeight - 1;
        $this->drawRectangle($sx, $sy, $ex, $ey);
        for ($i = 0; $i < count($tags); $i++) {
            $legend = self::$_fillChar[$i] . ' ' . $tags[$i];
            $this->drawText($sx + 1, $ey - 1 - $i, $legend);
        }

        // generate scale
        $this->drawText(0, 0, strval($real_min));
        $this->drawText(0, 0.5, strval(($real_min + $real_max) / 2));
        $this->drawText(0, 1.0, strval($real_max));
    }

}
