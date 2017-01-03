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

/* Usage
 <field name="wordlePresetPalette" type="themecolors" default="BED661,89E894,78D5E3,7AF5F5,34DDDD,93E2D5" label="Palette Presets"
description="Preset palette (Default is aqua)." class="btn-group">
    <option value="BED661,89E894,78D5E3,7AF5F5,34DDDD,93E2D5">Aqua</option>
    <option value="FFCC00,CCCCCC,666699">Yellow/Blue</option>
    <option value="87907D,AAB6A2,555555,666666">Grey</option>
    <option value="CC6600,FFFBD0,FF9900,C13100">Brown</option>
    <option value="595F23,829F53,A2B964,5F1E02,E15417,FCF141">Army</option>
    <option value="EF597B,FF6D31,73B66B,FFCB18,29A2C6">Pastel</option>
    <option value="FFFF66,FFCC00,FF9900,FF0000">Red</option>
    <option value="07093D,0C0F66,0B108C,0E4EAD,007BCC">Blue</option>
    <option value="F75DA9,F76964,BB82FF,FF7FD1,814E6F">Pink</option>
</field>
 */
class JFormFieldThemeColors extends JFormFieldRadio {

    protected $type = 'themecolors';


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
            $colors = explode(",", $value);

            $text = '<div class="graph" style="width: 50px;height: 50px;">';
            foreach($colors as $color) {
                $text .=  '<div
                                style="height: 32px;
                                background-color: #'.$color.';
                                width: 8px;
                                margin: 1px;
                                display: inline-block;
                                position: relative;
                                vertical-align: baseline;"></div>';
            }
            $text .=  '</div>';

            $text .= trim((string)$option);
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