<?php
/**
 * Retinafy plugin for Craft CMS 3.x
 *
 * A direct remake of the Craft Retinafy plugin for Craft 2.0 by markgoodyear.
 *
 * @link      https://venveo.com
 * @copyright Copyright (c) 2018 Venveo
 */

namespace venveo\retinafy\twigextensions;

use craft\elements\Asset;
use venveo\retinafy\Retinafy as Plugin;

class RetinafyTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'Retinafy';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('retinafy', [$this, 'retinafy']),
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('retinafy', [$this, 'retinafy']),
        ];
    }

    public function retinafy(Asset $image, $transformHandle = null)
    {
        Plugin::$plugin->retinafy->retinafy($image, $transformHandle);
    }
}
