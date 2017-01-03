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

JFormHelper::loadFieldClass('radio');

class JFormFieldScaling extends JFormFieldRadio {

    protected $type = 'scaling';


    protected function getOptions()
    {
        $options = array();

        foreach ($this->element->children() as $option)
        {
            // Only add <option /> elements.
            if ($option->getName() != 'option')
            {
                continue;
            }

            $disabled = (string) $option['disabled'];
            $disabled = ($disabled == 'true' || $disabled == 'disabled' || $disabled == '1');

            // Create a new option object based on the <option /> element.
            $value = (string)$option['value'];


            $alt = trim((string)$option);

            $base = $this->element['base_path'];

            $text = '<img src="'.JUri::root().$base.$value.'.jpg" title="'.$alt.'">';
            $tmp = JHtml::_(
                'select.option', $value, $text, 'value', 'text',
                $disabled
            );

            // Set some option attributes.
            $tmp->class = (string) $option['class'];

            // Set some JavaScript option attributes.
            $tmp->onclick = (string) $option['onclick'];
            $tmp->onchange = (string) $option['onchange'];

            // Add the option object to the result set.
            $options[] = $tmp;
        }

        reset($options);

        return $options;
    }


} 