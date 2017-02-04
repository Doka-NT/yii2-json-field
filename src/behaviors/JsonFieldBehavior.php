<?php
/**
 * @author        Soshnikov Artem <213036@skobka.com>
 * @copyright (c) 28.01.17
 */
namespace skobka\jsonField\behaviors;

use skobka\jsonField\exceptions\InvalidJsonFieldConfigException;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\BaseArrayHelper;

/**
 * Behavior to serialize/deserialize json data in field
 * @package app\components\behaviours
 */
class JsonFieldBehavior extends Behavior
{
    /**
     * @var string
     */
    public $dataField;

    /**
     * @inheritDoc
     */
    public function events()
    {
        return BaseArrayHelper::merge(parent::events(), [
            ActiveRecord::EVENT_BEFORE_INSERT => 'serializeField',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'serializeField',
            ActiveRecord::EVENT_AFTER_FIND => 'deserializeField',
            ActiveRecord::EVENT_AFTER_INSERT => 'deserializeField',
            ActiveRecord::EVENT_AFTER_UPDATE => 'deserializeField',
        ]);
    }

    /**
     * Serialize data in field to JSON string
     */
    public function serializeField()
    {
        $this->checkConfiguration();
        $value = $this->owner->{$this->dataField};
        $json = json_encode($value);

        $this->owner->{$this->dataField} = $json;
    }

    /**
     * Deserialize data in field from JSON string
     */
    public function deserializeField()
    {
        $this->checkConfiguration();
        $json = $this->owner->{$this->dataField};
        if (!is_string($json)) {
            return;
        }
        $value = json_decode($json);

        $this->owner->{$this->dataField} = $value;
    }

    /**
     * Check object configuration
     * @throws InvalidJsonFieldConfigException
     */
    private function checkConfiguration()
    {
        if (!$this->dataField) {
            throw new InvalidJsonFieldConfigException(sprintf('Property %s::dataField must be specified', static::class));
        }
    }
}
