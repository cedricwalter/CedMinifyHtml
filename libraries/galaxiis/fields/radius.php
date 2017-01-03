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

jimport('joomla.form.formfield');


class JFormFieldRadius extends JFormField
{
    protected $type = 'Radius';

    public function getInput()
    {
        // Including fallback code for HTML5 non supported browsers.
        JHtml::_('jquery.framework');
        JHtml::_('script', 'system/html5fallback.js', false, true);

        $document = JFactory::getDocument();
        $script = JUri::root() . "/media/galaxiis/assets/js/angle-selector.js?v=1.3.1";
        $document->addScript($script);

        $this->value = (array)$this->value;

        return '
        <div id="' . $this->id . '3">0</div>
        <angle_selector id="' . $this->id . '" width="100" height="100" angle1="0" radius="25" handle_radius="5" />
                <script src="' . $script . '"></script>';
    }


}
