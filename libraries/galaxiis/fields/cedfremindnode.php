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

class JFormFieldCedFremindNode extends JFormFieldRadio
{

    protected $type = 'cedfremindnode';

    protected $itemsPerLine = 8;

    protected function getInput()
    {
        $html = array();

        // Initialize some field attributes.
        $class = !empty($this->class) ? ' class="radio ' . $this->class . '"' : ' class="radio"';
        $required = $this->required ? ' required aria-required="true"' : '';
        $autofocus = $this->autofocus ? ' autofocus' : '';
        $disabled = $this->disabled ? ' disabled' : '';
        $readonly = $this->readonly;

        // Start the radio field output.
        $html[] = '<fieldset id="' . $this->id . '"' . $class . $required . $autofocus . $disabled . ' >';

        // Get the field options.
        $options = $this->getOptions();

        // Build the radio field output.
        $newoptions = array_chunk($options, $this->itemsPerLine, true);

        foreach ($newoptions as $j => $newoption) {
            $html[] = '<div style="float: left;">';

            foreach ($newoption as $i => $option) {
                // Initialize some option attributes.
                $checked = ((string)$option->value == (string)$this->value) ? ' checked="checked"' : '';
                $class = !empty($option->class) ? ' class="' . $option->class . '"' : '';

                $disabled = !empty($option->disable) || ($readonly && !$checked);

                $disabled = $disabled ? ' disabled' : '';

                // Initialize some JavaScript option attributes.
                $onclick = !empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';
                $onchange = !empty($option->onchange) ? ' onchange="' . $option->onchange . '"' : '';

                $html[] = '<input type="radio" id="' . $this->id . $i . '" name="' . $this->name . '" value="'
                    . htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . $class . $required . $onclick
                    . $onchange . $disabled . ' />';

                $html[] = '<label for="' . $this->id . $i . '"' . $class . ' >'
                    . JText::alt($option->text, preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)) . '</label>';

                $required = '';
            }

            $html[] = '</div><div style="clear: both;"></div>';
        }

        // End the radio field output.
        $html[] = '</fieldset>';

        return implode($html);
    }

    protected function getOptions()
    {
        $options = array();

        foreach ($this->element->children() as $option) {
            // Only add <option /> elements.
            if ($option->getName() != 'option') {
                continue;
            }

            $disabled = (string)$option['disabled'];
            $disabled = ($disabled == 'true' || $disabled == 'disabled' || $disabled == '1');

            // Create a new option object based on the <option /> element.
            $value = (string)$option['value'];

            $text = '<img src="' . JUri::root() . '/media/com_cedfreemind/icons/' . $value . '.png">';
            $text .= trim((string)$option);
            $tmp = JHtml::_(
                'select.option', $value, $text, 'value', 'text',
                $disabled
            );

            // Set some option attributes.
            $tmp->class = (string)$option['class'];

            // Set some JavaScript option attributes.
            $tmp->onclick = (string)$option['onclick'];
            $tmp->onchange = (string)$option['onchange'];

            // Add the option object to the result set.
            $options[] = $tmp;
        }

        reset($options);

        return $options;
    }

} 