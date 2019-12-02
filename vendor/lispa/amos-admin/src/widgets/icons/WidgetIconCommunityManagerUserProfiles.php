<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\admin\widgets\icons
 * @category   CategoryName
 */

namespace lispa\amos\admin\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\widget\WidgetAbstract;
use lispa\amos\admin\AmosAdmin;
use lispa\amos\admin\models\UserProfile;
use lispa\amos\admin\models\search\UserProfileSearch;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconCommunityManagerUserProfiles
 * @package lispa\amos\admin\widgets\icons
 */
class WidgetIconCommunityManagerUserProfiles extends WidgetIcon
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $paramsClassSpan = [
            'bk-backgroundIcon',
            'color-darkGrey'
        ];

        $this->setLabel(AmosAdmin::tHtml('amosadmin', 'Community Managers'));
        $this->setDescription(AmosAdmin::t('amosadmin', 'List of community manager users'));

        if (!empty(Yii::$app->params['dashboardEngine']) && Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('user');
            $paramsClassSpan = [];
        } else {
            $this->setIcon('users');
        }

        $this->setUrl(['/admin/user-profile/community-manager-users']);
        $this->setCode('COMMUNITY_MANAGER_USERS');
        $this->setModuleName('admin');
        $this->setNamespace(__CLASS__);

        $this->setClassSpan(
            ArrayHelper::merge(
                $this->getClassSpan(),
                $paramsClassSpan
            )
        );

        $params = [];
        $query = new UserProfileSearch();
        $dataProvvider = $query->searchCommunityManagerUsers($params);

        $this->setBulletCount(
            $this->makeBulletCounter(
                Yii::$app->getUser()->getId(),
                UserProfile::className(),
                $dataProvvider->query
            )
        );

    }

}
