<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\organizzazioni\views\profilo
 * @category   CategoryName
 */

use lispa\amos\admin\AmosAdmin;
use lispa\amos\admin\models\UserProfile;
use lispa\amos\admin\widgets\UserCardWidget;
use lispa\amos\core\views\AmosGridView;
use lispa\amos\organizzazioni\Module;
use lispa\amos\organizzazioni\widgets\OrganizationsMembersWidget;
use kartik\alert\Alert;
use yii\data\ActiveDataProvider;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var lispa\amos\organizzazioni\models\Profilo $model
 * @var bool $isView
 */

/** @var UserProfile $emptyUserProfile */
$emptyUserProfile = AmosAdmin::instance()->createModel('UserProfile');
$statusLabel = Module::t('amosorganizzazioni', '#profilo_user_mm_status_label');

?>

<?php if ($model->isNewRecord): ?>
    <?= Alert::widget([
        'type' => Alert::TYPE_WARNING,
        'body' => Module::t('amosorganizzazioni', '#alert_invite_employees'),
        'closeButton' => false
    ]); ?>
<?php else: ?>
    <?php if ($isView): ?>
        <div class="col-xs-12">
            <?= AmosGridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getProfiloUserMms()
                ]),
                'columns' => [
                    [
                        'label' => $emptyUserProfile->getAttributeLabel('userProfileImage'),
                        'format' => 'raw',
                        'value' => function ($model) {
                            /** @var \lispa\amos\organizzazioni\models\ProfiloUserMm $model */
                            return UserCardWidget::widget(['model' => $model->user->userProfile]);
                        }
                    ],
                    'user.userProfile.surnameName',
                    'user.email',
                    'status' => [
                        'attribute' => 'status',
                        'label' => $statusLabel,
                        'headerOptions' => [
                            'id' => $statusLabel,
                        ],
                        'contentOptions' => [
                            'headers' => $statusLabel,
                        ],
                        'value' => function ($model) {
                            /** @var \lispa\amos\organizzazioni\models\ProfiloUserMm $model */
                            return Module::t('amosorganizzazioni', $model->status);
                        }
                    ],
                ]
            ]); ?>
        </div>
    <?php else: ?>
        <?= OrganizationsMembersWidget::widget([
            'model' => $model,
            'enableModal' => true,
            'targetUrlParams' => [
                'viewM2MWidgetGenericSearch' => true
            ],
        ]); ?>
    <?php endif; ?>
<?php endif; ?>
