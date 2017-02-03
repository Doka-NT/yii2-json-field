<?php
/**
 * @author        Soshnikov Artem <213036@skobka.com>
 * @copyright (c) 28.01.17
 */

namespace skobka\jsonField\traits;

use app\components\behaviours\JsonField\JsonFieldBehaviour;
use skobka\jsonField\behaviors\JsonFieldBehavior;
use skobka\jsonField\exceptions\InvalidJsonFieldConfigException;
use yii\base\Component;

/**
 * Class JsonFieldTrait
 * @package app\components\behaviours\JsonField
 */
trait JsonFieldTrait
{
    /**
     * @inheritDoc
     */
    public function __get($name)
    {
        $this->checkBehaviorConfig();
        /* @var $this Component */
        $behavior = $this->getBehavior($name);
        if (!$behavior) {
            /** @noinspection PhpUndefinedClassInspection */
            return parent::__get($name);
        }

        if (!$behavior instanceof JsonFieldBehavior) {
            /** @noinspection PhpUndefinedClassInspection */
            return parent::__get($name);
        }

        return $this->{$behavior->dataField};
    }

    /**
     * @inheritDoc
     */
    public function __set($name, $value)
    {
        $this->checkBehaviorConfig();
        /* @var $this Component */
        $behavior = $this->getBehavior($name);
        if (!$behavior) {
            /** @noinspection PhpUndefinedClassInspection */
            return parent::__set($name, $value);
        }

        if (!$behavior instanceof JsonFieldBehavior) {
            /** @noinspection PhpUndefinedClassInspection */
            return parent::__set($name, $value);
        }

        $this->{$behavior->dataField} = $value;

        return null;
    }

    /**
     * Check that current class is instance of \yii\base\Component
     * @throws InvalidJsonFieldConfigException
     */
    private function checkBehaviorConfig()
    {
        if (!$this instanceof Component) {
            $message = 'The class uses behavior ' . JsonFieldBehaviour::class . ' must be instanceof ' . Component::class;
            throw new InvalidJsonFieldConfigException($message);
        }
    }
}
