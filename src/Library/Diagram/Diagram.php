<?php
/**
 * diagram base class
 *
 * @author pysnow530
 * @version $Id$
 * @copyright pysnow530, 30 March, 2015
 * @package default
 **/
namespace Library\Diagram;

use Library\Board;

class Diagram extends Board {

    protected $_datas;

    public function addData($tag, $data) {
        $this->_datas[$tag] = $data;
    }

    public function clearData() {
        $this->_datas = array();
    }

    public function __toString() {
        $this->clear();
        call_user_func_array(array($this, 'generate'), array());

        return parent::__toString();
    }

    protected function _getRealRange($ratio=0.1) {
        $min = null;
        $max = null;

        if (!count($this->_datas)) {
            throw new \Exception('No data to draw!');
        }

        foreach ($this->_datas as $datas_tag => $data) {
            $data_min = min(array_values($data));
            $data_max = max(array_values($data));

            if (is_null($min) || is_null($max)) {
                $min = $data_min;
                $max = $data_max;
            }

            $data_min < $min and $min = $data_min;
            $data_max > $max and $max = $data_max;
        }

        $range = $max - $min;
        $real_min = $min - $range * $ratio;
        $real_max = $max + $range * $ratio;

        return array($real_min, $real_max);
    }

    /**
     * draw scale
     * @param $realMin      int min value
     * @param $realMax      int max value
     * @param int $nrScale  how many scale to draw
     */
    protected function _drawScale($realMin, $realMax, $nrScale=3) {
        $nrScale < 2 and $nrScale = 2;
        $nrScale -= 2;

        $scale_point = $this->getPoint(1, 1);
        $this->drawText($scale_point, strval($realMin));
        for ($i = 1; $i <= $nrScale; $i++) {
            $scale_point->setY($i / ($nrScale + 1));
            $value = sprintf('%.2f', $realMin + $i / ($nrScale + 1) * ($realMax - $realMin));
            $this->drawText($scale_point, $value);
        }
        $scale_point->setY(1.0);
        $this->drawText($scale_point, strval($realMax));
    }

    protected function _getY($real, $real_min, $real_max) {
        $real_range = $real_max - $real_min;
        $y = ($real - $real_min) / $real_range;

        return $y;
    }

    protected function _drawLegend($fillChars) {
        $tags = array_keys($this->_datas);
        $legendWidth = max(array_map('strlen', $tags)) + 2;
        $legendHeight = count($this->_datas);
        $to_point = $this->getPoint(1.0, 1.0);
        $from_point = $this->getPoint(1.0, 1.0);
        $from_point->transP(-$legendWidth - 1, -$legendHeight - 1);
        $this->drawRectangle($from_point, $to_point);
        $legend_point = $this->getPoint($from_point->getX() + 1, $to_point->getY() - 1);
        for ($i = 0; $i < count($tags); $i++) {
            $legend = $fillChars[$i] . ' ' . $tags[$i];
            $this->drawText($legend_point, $legend);
            $legend_point->transY(-1);
        }
    }

}
