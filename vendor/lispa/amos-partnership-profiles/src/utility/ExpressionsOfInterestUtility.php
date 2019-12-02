<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\utility
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\utility;

use lispa\amos\admin\AmosAdmin;
use lispa\amos\admin\interfaces\OrganizationsModuleInterface as AdminOrgInterface;
use lispa\amos\core\interfaces\OrganizationsModuleInterface as CoreOrgInterface;
use lispa\amos\partnershipprofiles\models\PartnershipProfiles;
use yii\base\BaseObject;

/**
 * Class ExpressionsOfInterestUtility
 * @package lispa\amos\partnershipprofiles\utility
 */
class ExpressionsOfInterestUtility extends BaseObject
{
    /**
     * Check if the logged user is the creator of one of the expressions of interest for a partnership profile.
     * @param PartnershipProfiles $partnershipProfile
     * @return bool
     */
    public static function isPartProfExprsOfIntCreator($partnershipProfile)
    {
        $notDraftExpressionsOfInterest = $partnershipProfile->notDraftExpressionsOfInterest;
        $isCreator = false;
        $loggedUserId = \Yii::$app->user->id;
        foreach ($notDraftExpressionsOfInterest as $expressionOfInterest) {
            if ($expressionOfInterest->created_by == $loggedUserId) {
                $isCreator = true;
            }
        }
        return $isCreator;
    }

    /**
     * Check if the logged user is the creator facilitator of one of the expressions of interest for a partnership profile.
     * @param PartnershipProfiles $partnershipProfile
     * @return bool
     */
    public static function isPartProfExprsOfIntCreatorFacilitator($partnershipProfile)
    {
        $notDraftExpressionsOfInterest = $partnershipProfile->notDraftExpressionsOfInterest;
        $isCreator = false;
        $loggedUserId = \Yii::$app->user->id;
        foreach ($notDraftExpressionsOfInterest as $expressionOfInterest) {
            if ($expressionOfInterest->createdUserProfile->facilitatore->user_id == $loggedUserId) {
                $isCreator = true;
            }
        }
        return $isCreator;
    }

    /**
     * @return array
     */
    public static function getReferenceCommunityOrOrganizationList()
    {
        $listData = [];
        $moduleCwh = \Yii::$app->getModule('cwh');
        if (!is_null($moduleCwh)) {
            /** @var \lispa\amos\cwh\AmosCwh $moduleCwh */
            /** @var AmosAdmin $moduleAdmin */
            $moduleAdmin = \Yii::$app->getModule('admin');
            $moduleOrganizations = \Yii::$app->getModule($moduleAdmin->getOrganizationModuleName());
            if (!is_null($moduleOrganizations) && (($moduleOrganizations instanceof AdminOrgInterface) || ($moduleOrganizations instanceof CoreOrgInterface))) {
                /** @var AdminOrgInterface|CoreOrgInterface $moduleOrganizations */
                $organizationsModelClassName = $moduleOrganizations->getOrganizationModelClass();
                $organizationsCwhConfigId = $organizationsModelClassName::getCwhConfigId();
                $query = \lispa\amos\cwh\utility\CwhUtil::getUserNetworkQuery($organizationsCwhConfigId, \Yii::$app->user->id, false);
                if (!is_null($query)) {
                    $tmpModels = $query->orderBy([$organizationsModelClassName::tableName() . '.name' => SORT_ASC])->all();
                    foreach ($tmpModels as $tmpModel) {
                        $id = $organizationsModelClassName::tableName() . '-' . $tmpModel->id;
                        $listData[$id] = $tmpModel->name;
                    }
                }
            }
            $moduleCommunity = \Yii::$app->getModule('community');
            if (!is_null($moduleCommunity)) {
                /** @var \lispa\amos\community\AmosCommunity $moduleCommunity */
                $communityCwhConfigId = \lispa\amos\community\models\Community::getCwhConfigId();
                $query = \lispa\amos\cwh\utility\CwhUtil::getUserNetworkQuery($communityCwhConfigId, \Yii::$app->user->id, true);
                if (!is_null($query)) {
                    $tmpModels = $query->orderBy([\lispa\amos\community\models\Community::tableName() . '.name' => SORT_ASC])->all();
                    foreach ($tmpModels as $tmpModel) {
                        $id = \lispa\amos\community\models\Community::tableName() . '-' . $tmpModel->id;
                        $listData[$id] = $tmpModel->name;
                    }
                }
            }
        }
        return $listData;
    }

    /**
     * @return bool
     */
    public static function viewCommunityOrOrganizationList()
    {
        return (count(self::getReferenceCommunityOrOrganizationList()) > 0);
    }

    /**
     * @return mixed|null
     */
    public static function getOnlyOneOrganization()
    {
    $moduleCwh = \Yii::$app->getModule('cwh');
    if (!is_null($moduleCwh)) {
        /** @var \lispa\amos\cwh\AmosCwh $moduleCwh */
        /** @var AmosAdmin $moduleAdmin */
        $moduleAdmin = \Yii::$app->getModule('admin');
        $moduleOrganizations = \Yii::$app->getModule($moduleAdmin->getOrganizationModuleName());
        if (!is_null($moduleOrganizations) && (($moduleOrganizations instanceof AdminOrgInterface) || ($moduleOrganizations instanceof CoreOrgInterface))) {
            /** @var AdminOrgInterface|CoreOrgInterface $moduleOrganizations */
            $organizationsModelClassName = $moduleOrganizations->getOrganizationModelClass();
            $organizationsCwhConfigId = $organizationsModelClassName::getCwhConfigId();
            $query = \lispa\amos\cwh\utility\CwhUtil::getUserNetworkQuery($organizationsCwhConfigId, \Yii::$app->user->id, false);
            if (!is_null($query)) {
                $tmpModel = $query->orderBy([$organizationsModelClassName::tableName() . '.name' => SORT_ASC])->one();
                    if($tmpModel) {
                        return $tmpModel;
                    }
                }
            }
        }
        return null;
    }
}
