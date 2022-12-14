<?php

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\views\AmosGridView;
use lispa\amos\core\views\DataProviderView;
use lispa\amos\dashboard\AmosDashboard;
use yii\helpers\Html;

/* * @var \lispa\amos\dashboard\models\AmosUserDashboards $currentDashboard * */
/* * @var \lispa\amos\dashboard\models\AmosWidgets $widgetIconSelectable * */
/* * @var \lispa\amos\dashboard\models\AmosWidgets $widgetGraphicSelectable * */
/* * @var array $widgetSelected * */

/* * @var \yii\web\View $this * */
AmosIcons::map($this);

$this->title = AmosDashboard::t('amosdashboard', 'Configurazione dashboard: ').$model->name;


$this->params['breadcrumbs'][]  = $this->title;
$this->params['widgetSelected'] = $widgetSelected;

\lispa\amos\dashboard\assets\DashboardFullsizeAsset::register($this);
?>
<div class="dashboard-default-index dashboard-manager">

    <?php $form     = ActiveForm::begin(); ?>

    <input type="hidden" id="saveDashboardUrl" value="<?= Yii::$app->urlManager->createUrl(['dashboard/manager/save-dashboard-order']); ?>"/>

    <div class="col-xs-12">
        <h2><?= AmosDashboard::tHtml('amosdashboard', 'Plugins'); ?></h2>
    </div>

    <div class="plugin-list dashboard-content">
        <?=
        DataProviderView::widget([
            'dataProvider' => $providerIcon,
            'currentView' => $currentView,
            'gridView' => [
                'summary' => false,
                'columns' => [
                    [
                        'class' => 'lispa\amos\core\views\grid\CheckboxColumn',
                        'name' => 'amosWidgetsIds[]',
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                            return [
                                'id' => \yii\helpers\StringHelper::basename($model['classname']),
                                'value' => $model['id'],
                                'checked' => in_array($model['id'], $this->params['widgetSelected'])
                            ];
                        }
                    ],
                    [
                        'label' => 'Icona',
                        'contentOptions' => ['class' => 'icona'],
                        'format' => 'html',
                        'value' => function ($model) {
                            $object          = \Yii::createObject($model['classname']);
                            if($object->isVisible()) {
                                $object->setUrl('');
                                $backgroundColor = Yii::createObject($model['classname'])->getClassSpan();
                                if (!$backgroundColor) {
                                    $backgroundColor = [1 => 'color-base'];
                                }

                                if (!$backgroundColor[1]) {
                                    $backgroundColor = [1 => 'bk-backgroundIcon'];
                                }

                                if (!$backgroundColor[2]) {
                                    $backgroundColor = [2 => 'color-base'];
                                }
                                return '<p class="' . $backgroundColor[1] . ' ' . $backgroundColor[2] . '">' . AmosIcons::show(Yii::createObject($model['classname'])->getIcon(),
                                        '', 'dash') . '</p>';
                            }
                        }
                    ],
                    [
                        'label' => 'Nome',
                        'format' => 'html',
                        'attribute' => 'classname',
                        'value' => function ($model) {
                            $object = \Yii::createObject($model['classname']);
                            return $object->getLabel();
                        }
                    ],
                    [
                        'label' => 'Descrizione',
                        'value' => function ($model) {
                            $object = \Yii::createObject($model['classname']);
                            return $object->getDescription();
                        }
                    ],
//TODO - colonna per ragruppamento in base al plugin
//                    [
//                        //'class'=>'kartik\grid\DataColumn',
//                        'attribute' => 'module',
//                        'label' => 'Plugin',
//                        'format' => 'html',
//                        //'group' => true,
//                        'value' => function ($model){
//                            return \yii\helpers\Inflector::camel2words($model->module);
//                        }
//                    ],
                ],
            ],
            'iconView' => [
                'itemView' => '_icon',
                'itemOptions' => [
                    'class' => 'col-xs-12 col-sm-3 col-md-4 col-lg-2 flex-column-item'
                ],
            ],
        ]);
        ?>

        <div class="col-xs-12">
            <h2><?= AmosDashboard::tHtml('amosdashboard', 'Widget'); ?></h2>
        </div>

        <?=
        AmosGridView::widget([
            'dataProvider' => $providerGraphic,
            'summary' => false,
            'columns' => [
                [
                    'attribute' => 'module',
                    'label' => 'Plugin',
                ],
                [
                    'class' => 'lispa\amos\core\views\grid\CheckboxColumn',
                    'name' => 'amosWidgetsIds[]',
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return [
                            'id' => \yii\helpers\StringHelper::basename($model['classname']),
                            'value' => $model['id'],
                            'checked' => in_array($model['id'], $this->params['widgetSelected'])
                        ];
                    }
                ],
                [
                    'label' => 'Icona',
                    'contentOptions' => ['class' => 'icona'],
                    'format' => 'html',
                    'value' => function ($model) {
                        $backgrounColor = 'color-border-mediumBase';
                        return '<p class="'.$backgrounColor.'">'.AmosIcons::show('view-web').'</p>';
                    }
                ],
                [
                    'label' => 'Nome',
                    'format' => 'html',
                    'attribute' => 'classname',
                    'value' => function ($model) {
                        $object = \Yii::createObject($model['classname']);
                        return $object->getLabel();
                    }
                ],
                [
                    'label' => 'Descrizione',
                    'value' => function ($model) {
                        $object = \Yii::createObject($model['classname']);
                        return $object->getDescription();
                    }
                ],
            ]
        ]);
        ?>

        <div class="col-xs-12 m-b-15">
            <div class="form-actions pull-right">
                <?=
                Html::submitButton(
                    AmosDashboard::t('amosdashboard', 'Salva'), [
                    'class' => 'btn btn-success'
                ]);
                ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>




