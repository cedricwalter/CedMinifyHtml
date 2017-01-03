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

//namespace Galaxiis\Joomla\Content\Fields\Cloud;

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldExternalLink extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'ExternalLink';

	protected function getInput()
	{
		$text = $this->element['text'];
		$url = $this->element['url'];
		$link = $this->element['link'];
		
		return "<div>$text <a href=\"$url\" target='_new'>$link</a></div>";
	}

}
