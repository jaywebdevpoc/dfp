<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\views\expressions-of-interest\email
 * @category   CategoryName
 */

/**
 * @var \lispa\amos\partnershipprofiles\models\base\PartnershipProfiles $partnershipProfile
 * @var integer[] $listOfArchived
 * @var integer[] $errorIds
 * @var string $dateStartScript
 */

?>
<div style="border:1px solid #cccccc;padding:10px;margin-bottom: 10px;background-color: #ffffff;">

    <div>
        <div style="margin-top: 20px;color:#000000;margin-left: 10px;">
            <h2 style="font-size:1.5em;line-height: 1;"><?= \lispa\amos\partnershipprofiles\Module::t('amospartnershipprofiles', 'List of partnership profiles filed at') . ' ' . $dateStartScript ?></h2>
        </div>
    </div>

    <div style="box-sizing:border-box;font-size:13px;font-weight:normal;color:#000000;">
        <table border="1" width="100%">
            <tr>
                <th>
                    <?= \lispa\amos\partnershipprofiles\Module::t('amospartnershipprofiles', 'Title') ?>
                </th>
                <th>
                    <?= \lispa\amos\partnershipprofiles\Module::t('amospartnershipprofiles', 'Name Surname') ?>
                </th>
                <th>
                    <?= \lispa\amos\partnershipprofiles\Module::t('amospartnershipprofiles', 'Expiry date') ?>
                </th>
                <th>
                    <?= \lispa\amos\partnershipprofiles\Module::t('amospartnershipprofiles', 'Created at') ?>
                </th>
            </tr>
            <?php
            foreach ($listOfArchived as $id):
                $partnershipProfile = \lispa\amos\partnershipprofiles\models\PartnershipProfiles::findOne($id);
                ?>
                <tr>
                    <td>
                        <?= \yii\helpers\StringHelper::truncate($partnershipProfile->title, 50, '...'); ?>
                    </td>
                    <td>
                        <?= $partnershipProfile->createdUserProfile->getNomeCognome(); ?>
                    </td>
                    <td>
                        <?= Yii::$app->formatter->asDate($partnershipProfile->calculateExpiryDate()); ?>
                    </td>
                    <td>
                        <?= Yii::$app->formatter->asDatetime($partnershipProfile->created_at); ?>
                    </td>
                </tr>
            <?php
            endforeach;
            ?>
        </table>
    </div>

    <?php
    if (count($errorIds) > 0):
        ?>
        <div>
            <div style="margin-top: 20px;color:#000000;margin-left: 10px;">
                <h2 style="font-size:1.5em;line-height: 1;"><?= \lispa\amos\partnershipprofiles\Module::t('amospartnershipprofiles', 'Items not stored for error occurred') . ' ' . $dateStartScript ?></h2>
            </div>
        </div>

        <div style="box-sizing:border-box;font-size:13px;font-weight:normal;color:#000000;">
            <table border="1" width="100%">
                <tr>
                    <th>
                        <?= \lispa\amos\partnershipprofiles\Module::t('amospartnershipprofiles', 'Title') ?>
                    </th>
                    <th>
                        <?= \lispa\amos\partnershipprofiles\Module::t('amospartnershipprofiles', 'Name Surname') ?>
                    </th>
                    <th>
                        <?= \lispa\amos\partnershipprofiles\Module::t('amospartnershipprofiles', 'Expiry date') ?>
                    </th>
                    <th>
                        <?= \lispa\amos\partnershipprofiles\Module::t('amospartnershipprofiles', 'Created at') ?>
                    </th>
                </tr>
                <?php
                foreach ($errorIds as $id):
                    $partnershipProfile = \lispa\amos\partnershipprofiles\models\PartnershipProfiles::findOne($id);
                    ?>
                    <tr>
                        <td>
                            <?= \yii\helpers\StringHelper::truncate($partnershipProfile->title, 50, '...'); ?>
                        </td>
                        <td>
                            <?= $partnershipProfile->createdUserProfile->getNomeCognome(); ?>
                        </td>
                        <td>
                            <?= Yii::$app->formatter->asDate($partnershipProfile->calculateExpiryDate()); ?>
                        </td>
                        <td>
                            <?= Yii::$app->formatter->asDatetime($partnershipProfile->created_at); ?>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </table>
        </div>
    <?php
    endif;
    ?>
</div>