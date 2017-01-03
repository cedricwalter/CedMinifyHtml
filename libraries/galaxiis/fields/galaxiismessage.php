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

defined('_JEXEC') or die;

class JFormFieldGalaxiisMessage extends JFormField {

    protected $type = 'galaxiismessage';

    protected function getInput() {
    	
    	$label = $this->element['label'] ? (string) $this->element['label'] : '';
    	$message = $this->element['message'] ? (string) $this->element['message'] : '';
    	
    	switch ($message) {
    		case 'space':
    			$style = 'border: 1px solid #BBBBBB; background-color: #F1F1F1; ';
    			$text_title = JText::_($label);
    			$text_message = '';
    			break;
    		case 'info':
    			$style = 'border: 1px solid #8bda8b; background-color: #cbfbcb; ';
    			$text_title = JText::_('JBINFORMATION').': ';
    			$text_message = JText::_($label);
    			break;
    		case 'note':
    			$html = array();

       			$html[] = '<div class="alert alert-info">';
				$html[] = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
				$html[] = '<strong>'.JText::_('JFIELD_NOTE_DESC').': </strong>';
				$html[] = JText::_($label);
				$html[] = '</div>';
				echo implode('', $html);
				return;
    			break;
    		case 'version':
				$html = array();
       			$html[] = '<div class="alert alert-block">';
				$html[] = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
				$html[] = '<strong>'.JText::_('JVERSION').': </strong>';
				$html[] = $this->element['extension_name'].' '. $this->element['version'];
				$html[] = '</div>';
				echo implode('', $html);
				return;
    			break;
    		default:
    			$style = 'border: 1px solid #BBBBBB; background-color: #F1F1F1; ';
    			$text_title = '';
    			$text_message = JText::_($label);
    			break;
    	}
    	
        $html = array();

        $html[] = '<div style="clear:left;"></div>';
		$html[] = '<div style="'.$style.'max-width: 500px; margin: 5px 0; padding: 5px 10px; border-radius: 5px; font-size:12px;">';
		$html[] = '<strong style="color:#303030;">';
		$html[] = $text_title;
		$html[] = '</strong>';
		$html[] = $text_message;
		$html[] = '</div>';
		
		return implode('', $html);
    }

    protected function getLabel() {}

}
