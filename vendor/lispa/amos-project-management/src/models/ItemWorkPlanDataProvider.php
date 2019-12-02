<?php

namespace lispa\amos\projectmanagement\models;

use yii\data\BaseDataProvider;

class ItemWorkPlanDataProvider extends BaseDataProvider
{

    /**
     * @var integer id of the project to inspect
     */
    public $projectId;

    /**
     * @var bool $checkOwner - set to true if you need to select activities/tasks owned by the logged user (responsible for the tasks)
     */
    public $checkOwner = false;

    /**
     * @var array $taskInSelection - if $taskInSelection is not empty, add task to data provider if is an element of the array.
     */
    public $taskInSelection = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        $models = [];
        $pagination = $this->getPagination();
        if ($pagination === false) {
            if (!empty($this->projectId)) {
                $listOfItems = Projects::getItemsWorkPlanArray($this->projectId, $this->checkOwner, $this->taskInSelection);
                foreach ($listOfItems as $item) {
                    $class = $item['class'];
                    $id = $item['id'];
                    $obj = $class::findOne($id);
                    $models[] = $obj;
                }
            }
        }
        return $models;
    }

    /**
     * @inheritdoc
     */
    protected function prepareKeys($models)
    {
        return array_keys($models);
    }

    /**
     * @inheritdoc
     */
    protected function prepareTotalCount()
    {
        $count = count($this->models);
        return $count;
    }
}