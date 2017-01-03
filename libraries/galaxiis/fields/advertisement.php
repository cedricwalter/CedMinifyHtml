<?php
/**
 * @package     Galaxiis
 * @subpackage  Galaxiis
 *
 * @copyright   Copyright (C) 2013-2016 galaxiis.com All rights reserved.
 * @license     The author and holder of the copyright of the software is Cédric Walter. The licensor and as such issuer of the license and bearer of the
 *              worldwide exclusive usage rights including the rights to reproduce, distribute and make the software available to the public
 *              in any form is Galaxiis.com
 *              see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class JFormFieldAdvertisement extends JFormFieldMedia
{

    protected $type = 'advertisement';

    protected $image;


    public function __get($name)
    {
        switch ($name) {
            case 'image':
                return $this->$name;
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'image':
                $this->$name = (string)$value;
                break;

            default:
                parent::__set($name, $value);
        }
    }

    public function setup(SimpleXMLElement $element, $value, $group = null)
    {
        $result = parent::setup($element, $value, $group);

        if ($result == true) {
            $this->image = (string)$this->element['image'];
        }

        return $result;
    }

    function getLabel()
    {
        $base = $this->element['base_path'];
        return  "<img src='".JUri::root().$base.$this->image."'><br />";
    }

    protected function getInput()
    {
        return "";
    }
}