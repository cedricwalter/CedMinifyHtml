<?php
/**
 * @package     CedMinifyHtml
 * @subpackage  com_cedminifyhtml
 *
 * @copyright   Copyright (C) 2013-2016 galaxiis.com All rights reserved.
 * @license     The author and holder of the copyright of the software is Cédric Walter. The licensor and as such issuer of the license and bearer of the
 *              worldwide exclusive usage rights including the rights to reproduce, distribute and make the software available to the public
 *              in any form is Galaxiis.com
 *              see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


//require_once JPATH_LIBRARIES . '/joomla/form/fields/media.php';

class JFormFieldOrientation extends JFormFieldMedia
{

    protected $type = 'orientation';

    protected $orientation;
    protected $device;


    public function __get($name)
    {
        switch ($name) {
            case 'orientation':
            case 'device':
                return $this->$name;
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'orientation':
            case 'device':
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
            $this->orientation = (string)$this->element['orientation'];
            $this->device = (string)$this->element['device'];
        }

        return $result;
    }

    function getLabel()
    {
        $orientation = "portrait";
        if ($this->orientation == 'landscape') {
            $orientation = 'landscape';
        }

        $device = "iphone";
        if ($this->device == 'ipad') {
            $device = 'ipad';
        }

        $base = $this->element['base_path'];

        return  "<img src='".JUri::root()."media/plg_system_add2home/$device-$orientation-64x64.png'>" . parent::getLabel();
    }

} 