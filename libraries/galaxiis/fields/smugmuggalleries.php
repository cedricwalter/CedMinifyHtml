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

JFormHelper::loadFieldClass('list');
require JPATH_LIBRARIES. '/cedsmugmug\vendor\autoload.php';

//require_once JPATH_LIBRARIES. '/cedsmugmug\vendor\lildude\phpsmug\lib\phpSmug\Client.php';

//JLoader::registerNamespace('Guzzle', JPATH_LIBRARIES.'/vendor/guzzle/guzzle/src/');
//JLoader::registerNamespace('Guzzle', JPATH_LIBRARIES.'/vendor/guzzle/guzzle/src/');
//

/**
 * Supports an HTML select list of image
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldSmugmugGalleries extends JFormFieldList
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  11.1
     */
    protected $type = 'smugmuggalleries';

    /**
     * Method to get the list of files for the field options.
     * Specify the target directory with a directory attribute
     * Attributes allow an exclude mask and stripping of extensions from file name.
     * Default attribute may optionally be set to null (no file) or -1 (use a default).
     *
     * @return  array  The field option objects.
     *
     * @since   11.1
     */

    protected function getLabel()
    {
        $cparams = JComponentHelper::getParams('com_cedsmugmug');

        $notAuthorized =  $cparams->get('token') == "";
        if ($notAuthorized) {
            $client = $this->getClient();

            // Step 1: Get a request token using an optional callback URL back to ourselves
            $callback = "https://localhost/dev/administrator/index.php?option=com_cedsmugmug&view=callback&id=1&Itemid=108";
            $request_token = $client->getRequestToken($callback);

            $app =& JFactory::getApplication();

            $oauth_token_secret = $request_token['oauth_token_secret'];
            $app->setUserState("cedsmugmug_oauth_token_secret", $oauth_token_secret);
            $oauth_token = $request_token['oauth_token'];
            $app->setUserState("cedsmugmug_oauth_token", $oauth_token);

     //            $request_token['oauth_token'],

            return '<p>Click <a href="'.$client->getAuthorizeURL().'"><strong>HERE</strong></a> to Authorize This Demo.</p>';
        }

        return "authorized";
    }


    protected function getClient()
    {
        $smugmug_options = [
            'AppName' => 'CedSmugmug/1.0 for (http://app.com)',
            'OAuthSecret' => '1dbc6fe499abf897405948be390cdefa',
            '_verbosity' => 2, # Reduce verbosity to reduce the amount of data in the response and to make using it easier. default is 2
            'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ) # so that it doesn't attempt to perform the ssl verification... Obviously on the live server it won't be an issue given that the live server will have a correct certificate (assumedly)

        ];

        $apiKey = "2BIzXuustXcrE87qXeOJLgXpIYYp7IFd";
        $username = "cedricwalter";

        $client = new phpSmug\Client($apiKey, $smugmug_options);

        return $client;
    }



    protected function getOptions()
    {


        $cparams = JComponentHelper::getParams('com_cedsmugmug');







        $options = array();

//        $albums = $client->get("user/$username!albums");

        $options[] = JHtml::_('select.option', "any", "any");

        if (!$this->hideNone) {
            $options[] = JHtml::_('select.option', '-1', JText::alt('JOPTION_DO_NOT_USE', preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)));
        }

        if (!$this->hideDefault) {
            $options[] = JHtml::_('select.option', '', JText::alt('JOPTION_USE_DEFAULT', preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)));
        }


        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }


}