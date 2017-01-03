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

defined('JPATH_PLATFORM') or die;

class JFormFieldCedImage extends JFormField
{

	protected $type = 'CedImage';
    protected $source = '';

	protected function getInput()
	{
		$image = $this->element['source'];
		return '<img src="'.JUri::root().$image.'">' ;
	}
}
