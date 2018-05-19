<?php
/**
 * Retinafy plugin for Craft CMS 3.x
 *
 * A direct remake of the Craft Retinafy plugin for Craft 2.0 by markgoodyear.
 *
 * @link      https://venveo.com
 * @copyright Copyright (c) 2018 Venveo
 */

namespace venveo\retinafy\variables;

use craft\elements\Asset;
use venveo\retinafy\Retinafy as Plugin;

use Craft;

/**
 * Retinafy Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.retinafy }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Venveo
 * @package   Retinafy
 * @since     1.0.0
 */
class RetinafyVariable
{
    // Public Methods
    // =========================================================================

    public function image(Asset $image, $transformHandle = null)
    {
        Plugin::$plugin->retinafy->retinafy($image, $transformHandle);
    }
}
