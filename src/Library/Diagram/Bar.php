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

    protected $_fillChar = '-=~!@#$%^&*()_+';

    public function generate() {
        // TODO: generate legend
        $tags = array_keys($this->_datas);
        $legendWidth = max(array_map('strlen', $tags)) + 2;
        $legendHeight = count($this->_datas);
        $ex = $this->_board->getWidth() - 1;
        $ey = $this->_board->getHeight() - 1;
        $sx = $ex - $legendWidth -1;
        $sy = $ey - $legendHeight - 1;
        $this->_board->drawRectangle($sx, $sy, $ex, $ey);
        for ($i = 0; $i < count($tags); $i++) {
            $legend = $this->_fillChar[$i] . ' ' . $tags[$i];
            $this->_board->drawText($sx + 1, $ey - 1 - $i, $legend);
        }

        // TODO: generate bar
        // TODO: generate tag
    }

}
