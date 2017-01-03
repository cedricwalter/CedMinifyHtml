<?php
/**
 * @package   TJ Minify HTML for Joomla! 3.0+
 * @type      Plugin (System)
 * @filename  tjminifyhtml.php
 * @folder    <root>/plugins/system/tjminifyhtml
 * @version   1.0.0
 * @author    ToolJoom
 * @website   http://www.tooljoom.com
 * @license   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @copyright (C) 2014 ToolJoom
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>
**/

defined('_JEXEC') or die;

class plgSystemCedminifyhtml extends JPlugin
{

	public function onAfterRender()
	{
		//Do not run in admin area and non HTML  (rss, json, error)
		$app = JFactory::getApplication();
		if ($app->isAdmin() || JFactory::getDocument()->getType() !== 'html')
		{
			return true;
		}

		$body = JFactory::getApplication()->getBody();
        $content = $this->minify($body);
        JFactory::getApplication()->setBody($content);
	}
	
    // Set PCRE recursion limit to sane value = STACKSIZE / 500
	// ini_set("pcre.recursion_limit", "524"); // 256KB stack. Win32 Apache
	//ini_set("pcre.recursion_limit", "16777");  // 8MB stack. *nix
	function minify($text) //
	{
        //credits to http://stackoverflow.com/questions/5312349/minifying-final-html-output-using-regular-expressions-with-codeigniter
		$text = preg_replace('%# Collapse whitespace everywhere but in blacklisted elements.
			(?>             # Match all whitespans other than single space.
			  [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
			| \s{2,}        # or two or more consecutive-any-whitespace.
			) # Note: The remaining regex consumes no text at all...
			(?=             # Ensure we are not in a blacklist tag.
			  [^<]*+        # Either zero or more non-"<" {normal*}
			  (?:           # Begin {(special normal*)*} construct
				<           # or a < starting a non-blacklist tag.
				(?!/?(?:textarea|pre|script)\b)
				[^<]*+      # more non-"<" {normal*}
			  )*+           # Finish "unrolling-the-loop"
			  (?:           # Begin alternation group.
				<           # Either a blacklist start tag.
				(?>'.$this->params->get('blacklist_tag','textarea|pre|script').')\b
			  | \z          # or end of file.
			  )             # End alternation group.
			)  # If we made it here, we are not in a blacklist tag.
			%Six', " ", $text);
//		if ($text === null) exit("PCRE Error! File too big.\n");
		return $text;
	}
	
	
}