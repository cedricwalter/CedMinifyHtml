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

class JFormFieldGooglefont extends JFormFieldRadio {

    protected $type = 'googlefont';

    protected function getOptions()
    {
        $family = $this->element['family'];

        $document = JFactory::getDocument();
        $document->addStyleSheet("//fonts.googleapis.com/css?family=Tangerine|Inconsolata|Shadows+Into+Light|Permanent+Marker|Shadows+Into+Light|Merienda+One|Audiowide");

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


            $text = '<span style="font-size: 24px; font-family: \''.$value.'\', serif;">'.$value.'</span> ';
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