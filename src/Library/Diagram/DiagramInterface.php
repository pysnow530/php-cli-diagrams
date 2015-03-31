<?php
/**
 * diagram interface
 *
 * @author pysnow530
 * @version $Id$
 * @copyright pysnow530, 30 March, 2015
 * @package default
 **/
namespace Library\Diagram;

interface DiagramInterface {

    public function __construct($width, $height, $withBorder);

    public function addData($tag, $data);

    public function clearData();

    public function generate();

    public function display();

    public function saveToFile($path, $tag);

}
