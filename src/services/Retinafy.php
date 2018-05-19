<?php
/**
 * Retinafy plugin for Craft CMS 3.x
 *
 * A direct remake of the Craft Retinafy plugin for Craft 2.0 by markgoodyear.
 *
 * @link      https://venveo.com
 * @copyright Copyright (c) 2018 Venveo
 */

namespace venveo\retinafy\services;

use craft\elements\Asset;
use craft\models\AssetTransform;
use venveo\retinafy\Retinafy as Plugin;

use Craft;
use craft\base\Component;

/**
 * Retinafy Service
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Venveo
 * @package   Retinafy
 * @since     1.0.0
 */
class Retinafy extends Component
{
    /** @var Plugin */
    protected $plugin;

    /** @var \venveo\retinafy\models\Settings  */
    protected $settings;

    // Public Methods
    // =========================================================================

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->plugin = Plugin::$plugin;
        $this->settings = $this->plugin->getSettings();
    }


    public function retinafy(Asset $image, $transformHandle)
    {
        // Not transform and not 2x file. Return image url.
        if ($transformHandle === null && !$this->is2xFile($image))
        {
            $markup = $image->getUrl(false);
        }
        // Transform and not forced and not 2x file. Return transform image url.
        if ($transformHandle !== null && !$this->settings->force && !$this->is2xFile($image))
        {
            $markup = $image->getUrl($transformHandle);
        }
        // Not transform and 2x file. Create 1x image.
        if ($transformHandle === null && $this->is2xFile($image))
        {
            $markup = $this->create1xImage($image);
        }
        // Transform and is forced or 2x file. Create 2x image.
        if (isset($transformHandle) && ($this->settings->force || $this->is2xFile($image)))
        {
            // Use AssetTransformsService (AssetTransformModel).
            $transform = \Craft::$app->assetTransforms->getTransformByHandle($transformHandle);
            $markup = $this->create2xImage($image, $transform);
        }
        echo $markup;
    }


    /**
     * Check if image has @2x suffix.
     *
     * @param Asset $image
     * @return bool
     */
    protected function is2xFile(Asset $image)
    {
        return preg_match('/' . $this->settings->suffix . '\\.\\w+$/', $image->filename) === 1;
    }

    /**
     * @param Asset $image
     * @return string
     */
    protected function create1xImage(Asset $image)
    {
        // Set transform params.
        $params = [
            'mode'  => 'fit',
            'width' => round($image->width / 2)
        ];
        // Markup for the image.
        $markup = $image->getUrl($params) . '" srcset="' .  $image->getUrl() . ' 2x';
        return $markup;
    }

    /**
     * @param Asset $image
     * @param AssetTransform $transform
     * @return null|string
     */
    protected function create2xImage(Asset $image, AssetTransform $transform)
    {
        // Grab sizes as int.
        $originalWidth   = (int) $image->getWidth(null);
        $transformWidth  = (int) $transform->width;
        $transformHeight = (int) $transform->height;
        // Set transform params, uses params set in Craft.
        $params = [
            'mode'     => $transform->mode,
            'width'    => $transformWidth * 2,
            'height'   => $transformHeight * 2,
            'quality'  => $transform->quality,
            'interlace' => $transform->interlace,
            'position' => $transform->position
        ];
        // Markup for the specified transform.
        $markup = $image->getUrl($transform->handle);
        // If original width is bigger than the 2x size for the specified transform, add the srcset.
        if ($originalWidth >= $transformWidth * 2)
        {
            $markup .= '" srcset="' . $image->getUrl($params) . ' 2x';
        }
        return $markup;
    }
}
