<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\Module;

/**
 * @var lispa\amos\projectmanagement\models\Projects $model
 * @var \yii\data\ActiveDataProvider $participantsDataProvider
 */

?>

<div>
    <div class="intestazione-box">
        <?php Html::tag('h3',
            \lispa\amos\projectmanagement\Module::tHtml('amosproject_management', 'Participants')) ?>
    </div>

    <?php
    if (!empty($model->community_id)) {
        try {
            echo \lispa\amos\core\views\AmosGridView::widget([
                'dataProvider' => $participantsDataProvider,
                'columns' => [
                    'user.userProfile.cognome',
                    'user.userProfile.nome',
                    [
                        'attribute' => 'role',
                        'value' => function($model){
                            return Module::t('amosproject_management', $model->role);
                        }
                    ]
                ],
            ]);
        } catch (Exception $e) {
            pr($e->getMessage(),'ERROR');
        }
    } else {
        echo Module::tHtml('amosproject_management', 'Community not exist');
    }
    ?>
</div>