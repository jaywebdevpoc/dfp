<?php
use yii\bootstrap\Modal;
use lispa\amos\projectmanagement\Module;

Modal::begin([
    'header' => "<h2>$organizationName</h2>",
    'size' => Modal::SIZE_LARGE,
    'toggleButton' => [
        'label' => Module::t('amosproject_management', 'Activity'),
        'class' => 'btn btn-primary',
    ],
    'footer' => ''
]);

try {
    echo \lispa\amos\core\views\AmosGridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'start_date:date'
        ],
    ]);
} catch (Exception $e) {
}

Modal::end();