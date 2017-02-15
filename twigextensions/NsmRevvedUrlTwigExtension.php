<?php
/**
 * NSM Revved URL plugin for Craft CMS
 *
 * NSM Revved URL Twig Extension
 *
 * --snip--
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators, global variables, and
 * functions. You can even extend the parser itself with node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 * --snip--
 *
 * @author    Leevi Graham
 * @copyright Copyright (c) 2017 Leevi Graham
 * @link      http://newism.com.au
 * @package   NsmRevvedUrl
 * @since     1.0.0
 */

namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class NsmRevvedUrlTwigExtension extends \Twig_Extension
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'NsmRevvedUrl';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ 'something' | someFilter }}
     *
     * @return array
     */
    public function getFilters()
    {
        return array();
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     *      {% set this = someFunction('something') %}
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'nsm_rev_url' => new \Twig_Function_Method($this, 'revUrl'),
        );
    }

    /**
     * @param AssetFileModel $asset
     * @param $transform
     * @return mixed
     */
    public function revUrl(AssetFileModel $asset, $transform = null)
    {
        return str_replace(
            $asset->getExtension(),
            $asset->dateModified->getTimestamp().'.'.$asset->getExtension(),
            $asset->getUrl($transform)
        );
    }
}
