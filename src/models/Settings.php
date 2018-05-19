<?php
/**
 * Retinafy plugin for Craft CMS 3.x
 *
 * A direct remake of the Craft Retinafy plugin for Craft 2.0 by markgoodyear.
 *
 * @link      https://venveo.com
 * @copyright Copyright (c) 2018 Venveo
 */

namespace venveo\retinafy\models;

use venveo\retinafy\Retinafy;

use Craft;
use craft\base\Model;

/**
 * Retinafy Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Venveo
 * @package   Retinafy
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $force = true;
    public $suffix = '@2x';


    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['force', 'boolean'],
            ['suffix', 'default', 'value' => '@2x']
        ];
    }
}
