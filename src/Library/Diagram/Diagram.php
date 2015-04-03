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
use Library\BoardPoint;

class Diagram extends Board {

    protected $_datas;

    public function addData($tag, $data) {
        $this->_datas[$tag] = $data;
    }

    public function clearData() {
        $this->_datas = array();
    }

    public function __toString() {
        $this->generate();

        return parent::__toString();
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
