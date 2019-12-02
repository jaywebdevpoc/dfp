<?php
use lispa\amos\projectmanagement\Module;
/**
 * @var \lispa\amos\projectmanagement\models\ProjectsModifyRequest $model
 * @var \lispa\amos\projectmanagement\models\ProjectsModifyRequest $request
 */
?>
<div class="col-lg-12 col-sm-12">
        <?php

        $dp = new \lispa\amos\projectmanagement\models\ItemWorkPlanDataProvider([
            'projectId' => $model->projects_id,
            'pagination' => false,
            'taskInSelection' => $model->getProjectsAtModifyRequestTaskIds()
        ]);

        try {
            lispa\amos\core\views\grid\CheckboxColumn::className();
            $request = $model;
            echo \lispa\amos\core\views\AmosGridView::widget([
                'dataProvider' => $dp,
                'columns' => [
                    [
                        'class' => 'lispa\amos\core\views\grid\DataColumn',
                        'header' => 'Selezionati',
                        'value' => function ($model, $key, $index, $column) use ($request) {
                            if($model->className() == \lispa\amos\projectmanagement\models\ProjectsActivities::className()){
                                $stringId = yii\helpers\StringHelper::basename($model->className()) . $model->id;
                                $checked = false;
                                /** @var \lispa\amos\projectmanagement\models\ProjectsAtModifyRequestMm $mmItem */
                                foreach ($request->projectsAtModifyRequestMms as $mmItem) {
                                    if ($stringId == $mmItem->getStringIdForForm()) $checked = true;
                                }
                            }else{
                                $checked = true;
                            }
                            if ($checked){
                                return \lispa\amos\core\icons\AmosIcons::show('check', ['class' => 'success']);
                            }
                            return '';
                        },
                        'format' => 'html'

                    ],
                    [
                        'label' => Module::t('amosproject_management', 'Type item'),
                        //'value' => 'typeName',
                        'value' => function ($model) {
                            $retType = '';
                            if ($model instanceof \lispa\amos\projectmanagement\models\ProjectsTasks) {
                                $retType .= \lispa\amos\core\icons\AmosIcons::show('long-arrow-return');
                            }
                            $retType .= $model->typeName;
                            return $retType;
                        },
                        'format' => 'raw'
                    ],
                    'name',
                    [
                        'label' => Module::t('amosproject_management', 'Start Date'),
                        'value' => function ($model) {
                            if (is_null($model->startDate)){
                                return '';
                            }else {
                                return Yii::$app->formatter->asDate($model->startDate);
                            }
                        },
                    ],
                    [
                        'label' => Module::t('amosproject_management', 'End Date'),
                        'value' => function ($model) {
                            if (is_null($model->startDate)){
                                return '';
                            }else {
                                return Yii::$app->formatter->asDate($model->endDate);
                            }
                        },
                    ],
                ],
            ]);
        } catch (Exception $e) {
            pr($e->getMessage());
        }
        ?>
    </div>