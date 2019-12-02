<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\discussioni\views\discussioni-topic
 * @category   CategoryName
 */

use lispa\amos\admin\widgets\UserCardWidget;
use lispa\amos\attachments\components\AttachmentsTableWithPreview;
use lispa\amos\core\forms\ContextMenuWidget;
use lispa\amos\core\forms\ItemAndCardHeaderWidget;
use lispa\amos\core\forms\PublishedByWidget;
use lispa\amos\core\forms\ShowUserTagsWidget;
use lispa\amos\core\forms\Tabs;
use lispa\amos\core\helpers\Html;
use lispa\amos\discussioni\AmosDiscussioni;
use lispa\amos\core\views\toolbars\StatsToolbar;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\attachments\components\AttachmentsList;
use lispa\amos\core\forms\InteractionMenuWidget;
use \lispa\amos\discussioni\models\DiscussioniTopic;

/**
 * @var yii\web\View $this
 * @var lispa\amos\discussioni\models\DiscussioniTopic $model
 * @var yii\widgets\ActiveForm $form
 */

$this->title = $model->titolo;

?>

<div class="discussioni-topic-view col-xs-12 nop">
    <div class="clearfix"></div>
    <div class="col-xs-12">
        <div class="header col-xs-12 nop">
            <?php
            $url = '/img/img_default.jpg';
            if (!is_null($model->discussionsTopicImage)) {
                $url = $model->discussionsTopicImage->getWebUrl('original', false, true);
                ?>
                <?= Html::img($url, [
                    'class' => 'img-responsive',
                    'alt' => AmosDiscussioni::t('amosdiscussioni', 'Immagine della discussione')
                ]); ?>
                <?php
            }
            ?>
            <div class="title col-xs-12">
                <h2 class="title-text"><?= $model->titolo ?></h2>
            </div>
        </div>
        <div class="text-content col-xs-12 nop">
            <?= $model->testo ?>
        </div>
        <div class="col-xs-12 text-center">
            <hr>
            <?= Html::a(
                AmosDiscussioni::t('amosdiscussioni', 'Contribuisci'),
                ['partecipa', 'id' => $model->id, '#' => 'comments_contribute'],
                [
                    'class' => 'btn btn-navigation-primary',
                    'title' => AmosDiscussioni::t('amosdiscussioni', 'commenta')
                ]
            ) ?>
        </div>

    </div>

</div>
