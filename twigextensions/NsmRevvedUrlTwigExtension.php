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
            'nsm_rev_url' => new \Twig_Function_Method($this, 'revAssetUrl'),
            'nsm_rev_asset' => new \Twig_Function_Method($this, 'revAsset'),
            'nsm_rev_asset_url' => new \Twig_Function_Method($this, 'revAssetUrl'),
            'nsm_rev_imager_asset' => new \Twig_Function_Method($this, 'revImagerAsset'),
            'nsm_rev_imager_url' => new \Twig_Function_Method($this, 'revImagerUrl'),
        );
    }

    /**
     * @param AssetFileModel $asset
     * @param null $transform
     * @return mixed
     */
    public function revAssetUrl(AssetFileModel $asset, $transform = null)
    {
        $revvedUrl = $this->addTimeStamp(
            $asset->dateModified->getTimestamp(),
            $asset->getUrl($transform),
            $asset->getExtension()
        );

        return $revvedUrl;
    }

    /**
     * @param AssetFileModel $asset
     * @param $transform
     * @param null $transformDefaults
     * @param null $configOverrides
     * @return mixed
     */
    public function revImagerAsset(
        AssetFileModel $asset,
        $transform,
        $transformDefaults = null,
        $configOverrides = null
    ) {
        $images = craft()->imager->transformImage(
            $asset,
            $transform,
            $transformDefaults,
            $configOverrides
        );

        if(is_array($images)) {
            foreach($images as $image) {
                $image->url = $this->addTimeStamp(
                    $asset->dateModified->getTimestamp(),
                    $image->getUrl(),
                    $image->getExtension()
                );
            }
        } else {
            $images->url = $this->addTimeStamp(
                $asset->dateModified->getTimestamp(),
                $images->getUrl(),
                $images->getExtension()
            );
        }

        return $images;
    }

    /**
     * @param AssetFileModel $asset
     * @param $transform
     * @param null $transformDefaults
     * @param null $configOverrides
     * @return mixed
     */
    public function revImagerUrl(
        AssetFileModel $asset,
        $transform,
        $transformDefaults = null,
        $configOverrides = null
    ) {
        /** @var Imager_ImageModel $image */
        $image = craft()->imager->transformImage(
            $asset,
            $transform,
            $transformDefaults,
            $configOverrides
        );

        $revvedUrl = $this->addTimeStamp(
            $asset->dateModified->getTimestamp(),
            $image->getUrl(),
            $image->getExtension()
        );

        return $revvedUrl;
    }

    /**
     * @param $timestamp
     * @param $url
     * @param $extension
     * @return mixed
     */
    private function addTimeStamp($timestamp, $url, $extension)
    {
        return str_replace($extension, $timestamp.'.'.$extension, $url);
    }
}
