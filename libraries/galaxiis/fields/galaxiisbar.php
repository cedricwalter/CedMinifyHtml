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

jimport('joomla.form.formfield');

class JFormFieldGalaxiisBar extends JFormField
{

	protected $type = 'galaxiisbar';

	public function getLabel()
	{
		return;
	}

	protected function getInput()
	{
		$shortId = $this->element['shortId'];

		$html  = '';
		$style = 'style="margin: 0 5px;"';
		$html .= '<a class="btn btn-info" href="https://www.galaxiis.com/'.$shortId.'-showcase/" target="_blank" ' . $style . '><span class="icon-home"></span> ' . JText::_('JSITE') . '</a>';
		$html .= '<a class="btn btn-success" href="https://www.galaxiis.com/'.$shortId.'-download-club/" target="_blank" ' . $style . '><span class="icon-download"></span> ' . JText::_('Premium') . '</a>';
		$html .= '<a class="btn btn-success" href="https://www.galaxiis.com/tickets" target="_blank" ' . $style . '><span class="icon-support"></span> ' . JText::_('Tickets') . '</a>';

		$html .= '<a class="btn btn-primary" href="https://www.galaxiis.com/'.$shortId.'-demo/" target="_blank" ' . $style . '><span class="icon-eye"></span> ' . JText::_('Demo') . '</a>';
		$html .= '<a class="btn btn-primary" href="https://www.galaxiis.com/'.$shortId.'-jed/" target="_blank" ' . $style . '><span class="icon-joomla"></span> ' . JText::_('Vote') . '</a>';


		$html .= '<a class="btn btn-primary" href="https://www.galaxiis.com/'.$shortId.'-doc/" target="_blank" ' . $style . '><span class="icon-help"></span> ' . JText::_('Help') . '</a>';
		$html .= '<a class="btn btn-primary" href="https://www.galaxiis.com/forums" target="_blank" ' . $style . '><span class="icon-mail"></span> ' . JText::_('Forums') . '</a>';

		return $html;
	}
}