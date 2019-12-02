<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\admin\rules
 * @category   CategoryName
 */

namespace lispa\amos\admin\rules;

use lispa\amos\admin\AmosAdmin;
use lispa\amos\community\AmosCommunity;
use lispa\amos\admin\models\UserProfile;
use lispa\amos\cwh\AmosCwh;

use Yii;
use yii\rbac\Rule;

/**
 * Class ValidatedBasicUserRule
 * @package lispa\amos\admin\rules
 */
class ValidatedBasicUserRule extends Rule
{
    /**
     * @inheritdoc
     */
    public $name = 'validatedBasicUser';
    
    /**
     * @inheritdoc
     */
    public function execute($loggedUserId, $item, $params)
    {
        /** @var UserProfile $loggedUser */
        $loggedUser = \Yii::$app->getUser()->identity->profile;
        $adminModule =\Yii::$app->getModule('admin');
        $communityModule =\Yii::$app->getModule('communty');
        $cwhModule =\Yii::$app->getModule('cwh');
        $scope = $cwhModule->getCwhScope();
        
        if (($adminModule->createContentInMyOwnCommunityOnly === true) && (isset($scope['community']) && !(empty($communityModule)))) {
            if (isset($scope['community']) && !(empty($communityModule))) {
                $myOwnCommunities = $communityModule->getCommunitiesByUserId(Yii::$app->getUser()->getId(), true);
                
                return (in_array($scope['community'], $myOwnCommunities));
            }
            
            return false;
        }
        
        return ($loggedUser->validato_almeno_una_volta == true);
    }
}
