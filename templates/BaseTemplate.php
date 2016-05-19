<?php

namespace TRS\RestResponse\templates;

use yii\base\Model;
use TRS\RestResponse\interfaces\TemplateInterface;

abstract class BaseTemplate implements TemplateInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $result = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    protected abstract function prepareResult();

    /**
     * @return array
     */
    public function getAsArray()
    {
        $this->prepareResult();

        return $this->result;
    }
}