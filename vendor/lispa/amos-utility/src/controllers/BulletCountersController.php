<?php

/*
 SELECT * 
FROM amos_user_dashboards AS AUD
INNER JOIN amos_user_dashboards_widget_mm AS AUDWMM ON AUDWMM.amos_user_dashboards_id = AUD.id
INNER JOIN user_profile AS UP ON UP.user_id = AUD.user_id
INNER JOIN amos_widgets AS AW ON AW.id = AUDWMM.amos_widgets_id AND AW.type = 'ICON'
WHERE 
	UP.id = 2476;
    AND AUD.module = 'dashboard'
    AND AUDWMM.status = 1
    
 */
namespace lispa\amos\utility\controllers;

use lispa\amos\admin\models\UserProfile;
 use lispa\amos\core\user\User;
// use lispa\amos\myactivities\models\MyActivities;

//use lispa\amos\admin\widgets\icons\WidgetIconInactiveUserProfiles;
//use lispa\amos\admin\widgets\icons\WidgetIconUserProfile;
//
//use lispa\amos\chat\widgets\icons\WidgetIconChat;
//use lispa\amos\chat\widgets\icons\WidgetIconChatAssistance;
//
//use lispa\amos\community\widgets\icons\WidgetIconCommunity;
//use lispa\amos\community\widgets\icons\WidgetIconCommunityDashboard;
//

use lispa\amos\admin\models\search\UserProfileSearch;
use lispa\amos\dashboard\models\search\AmosUserDashboardsSearch;

use Exception;
use Yii;
use yii\console\Controller;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\helpers\Console;
use yii\log\Logger;

/**
 * 
 */
class BulletCountersController extends Controller
{

    /**
     *
     * @var type string
     */
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $amosUserDashboardsSearch = new AmosUserDashboardsSearch();
        $userProfileModel = new UserProfileSearch();
        
        /** @var ActiveQuery $query */
        $users = $userProfileModel
            ->find()
            ->select([User::tableName() . '.id', UserProfile::tableName() . '.user_id'])
            ->innerJoinWith(['user'], false)
            ->andWhere([
                UserProfile::tableName() . '.validato_almeno_una_volta' => UserProfile::STATUS_ACTIVE
            ])
            ->asArray()
            ->all()
        ;
//        pr ($users->createCommand()->getRawSql());       
//        \yii\helpers\VarDumper::dump([$users], 10, true); die();
//        $platformUsers = $userProfileModel->searchOnceValidatedUsers([]);
//        var_dump(count($platformUsers)); die();
        
        
        foreach($users as $user) {
            
            
            /** @var AmosUserDashboards $dashboard */
            $dashboard = $amosUserDashboardsSearch->current([
                'user_id' => $user['id'],
            ])->one();
            
            //recupera i widgets di questa dashboard
            $thisDashboardWidgets =  $dashboard->amosWidgetsSelectedIcon;
      
            foreach ($thisDashboardWidgets as $widget) {
                pr($widget['classname']);
            }
                
        }
        die();
        $widget = Yii::createObject('lispa\amos\admin\widgets\icons\WidgetIconMyProfile');
        
//        \yii\helpers\VarDumper::dump([
//            WidgetIconInactiveUserProfiles::className(),
//            WidgetIconUserProfile::className(),
//            
//            WidgetIconChat::className(),
//            WidgetIconChatAssistance::className(),
//            
//            WidgetIconCommunity::className(),
//            WidgetIconCommunityDashboard::className(),
//            
//            $widget->hasMethod('makeBulletCounter'),
//
//            
//        ], 10, true);
//        lispa\amos\admin\widgets\icons\WidgetIconInactiveUserProfiles

        $this->setUpLayout();
    }

    /**
     * 
     * @return type
     */
    public function actionIndex()
    {
        $userIds = $this->loadUsers();

        /**
         * Fill bulletCounter table with user_id, className (widget), counter
         */
        foreach ($userIds as $k => $user_id) {
        }

        return $this->render(
                'index',
                [
                    'userIds' => $userIds
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                        ],
                        'roles' => ['ADMIN']
                    ],
                ],
            ],
        ];
    }

    /**
     * @param null $layout
     * @return bool
     */
    public function setUpLayout($layout = null)
    {
        if ($layout === false) {
            $this->layout = false;
            return true;
        }

        $this->layout = (!empty($layout)) ? $layout : $this->layout;
        $module = \Yii::$app->getModule('layout');
        if (empty($module)) {
            if (strpos($this->layout, '@') === false) {
                $this->layout = '@vendor/lispa/amos-core/views/layouts/' . $this->layout;
            }

            return true;
        }

        return true;
    }

    /**
     * Find all users id and return them as an array
     *  
     * @return type
     */
    protected function loadUsers()
    {
        $userTable = User::tableName();
        $userProfileTable = UserProfile::tableName();
        
        $result = [];
        try {
            $query = new Query();
            $query
                ->select('user.id, user_profile.user_id')
                ->from($userProfileTable)
                ->innerJoin($userTable, $userProfileTable . '.user_id = ' . $userTable . '.id')
                ->andWhere([
                    $userProfileTable . '.deleted_at' => null,
                    $userProfileTable . '.attivo' => UserProfile::STATUS_ACTIVE,
                    $userProfileTable . '.status' => User::STATUS_ACTIVE
                ]);
            
            $result = $query->all();
        } catch (Exception $ex) {
            Yii::getLogger()->log($ex->getMessage(), Logger::LEVEL_ERROR);

            return $result;
        }

        return $result;
    }
    
    /**
     * Retrieve all counters for the current user
     */
    public static function getAllCounters() {
        $user_id = Yii::$app->getUser()->getId();
    }

}
