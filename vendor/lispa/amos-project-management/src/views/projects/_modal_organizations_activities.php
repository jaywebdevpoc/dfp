<?php

use yii\bootstrap\Modal;
use lispa\amos\projectmanagement\Module;

/**
 * @var \yii\data\ActiveDataProvider $dataProviderActivities
 * @var \yii\data\ActiveDataProvider $dataProviderTasks
 * @var string $organizationName
 */

Modal::begin([
    'header' => "<h2>$organizationName</h2>",
    'size' => Modal::SIZE_LARGE,
    'toggleButton' => [
        'label' => Module::t('amosproject_management', 'WP and Activities'),
        'class' => 'btn btn-primary',
    ],
    'footer' => ''
]);
?>
    <div>
        <h3><?= Module::t('amosproject_management', 'Work packages') ?></h3>
        <?php
        //pr($dataProviderActivities->query->createCommand()->rawSql);
        try {
            echo \lispa\amos\core\views\AmosGridView::widget([
                'dataProvider' => $dataProviderActivities,
                'columns' => [
                    'name',
                    [
                        'label' => Module::t('amosproject_management', 'Reference User'),
                        'attribute' => 'user.userProfile.nomecognome',
                    ]
                ],
            ]);
        } catch (Exception $e) {
            pr($e->getMessage(), 'ERROR');
        }
        ?>
    </div>
    <div>
        <h3><?= Module::t('amosproject_management', 'Tasks') ?></h3>
        <?php
        try {
            echo \lispa\amos\core\views\AmosGridView::widget([
                'dataProvider' => $dataProviderTasks,
                'columns' => [
                    'name',
                    [
                        'label' => Module::t('amosproject_management', 'Reference Activity'),
                        'attribute' => 'user.userProfile.nomecognome',
                    ]
                ],
            ]);
        } catch (Exception $e) {
            pr($e->getMessage(), 'ERROR');
        }
        ?>
    </div>
<?php
Modal::end();
?>