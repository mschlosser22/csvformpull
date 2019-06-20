<?php
/**
 * CSV Form Pull plugin for Craft CMS 3.x
 *
 * Plugin to pull csv reports from form DB
 *
 * @link      https://github.com/mschlosser22
 * @copyright Copyright (c) 2019 Mike Schlosser
 */

namespace mschlosser22\csvformpull\models;

use mschlosser22\csvformpull\CsvFormPull;

use Craft;
use craft\base\Model;

/**
 * CsvFormPullModel Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Mike Schlosser
 * @package   CsvFormPull
 * @since     1.0.0
 */
class CsvFormPullModel extends Model
{
    public static function tableName()
    {
        return 'freeform_submissions';
    }
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    public $someAttribute = 'Some Default';

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
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ];
    }
}
