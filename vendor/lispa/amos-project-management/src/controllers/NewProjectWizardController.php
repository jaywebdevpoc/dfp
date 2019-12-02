<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\controllers
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\controllers;

use lispa\amos\community\AmosCommunity;
use lispa\amos\community\exceptions\CommunityException;
use lispa\amos\community\models\Community;
use lispa\amos\community\models\CommunityType;
use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\projectmanagement\models\new_project_wizard\StepA;
use lispa\amos\projectmanagement\models\new_project_wizard\StepB;
use lispa\amos\projectmanagement\models\new_project_wizard\StepC;
use lispa\amos\projectmanagement\models\new_project_wizard\StepD;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsCustomSpendingVoices;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Class NewProjectWizardController
 * @package lispa\amos\projectmanagement\controllers
 */
class NewProjectWizardController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'wizard',
                            'annulla',
                            'finish',
                            'exit',
                            'from-community',
                            'index'
                        ],
                        'roles' => ['PARTNER_REFERENT', 'ADMIN']
                    ],
                ],
            ]
        ]);
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = '@vendor/lispa/amos-core/views/layouts/form';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'wizard' => [
                'class' => 'lispa\amos\wizflow\WizardPlayAction',
                'tmpStorePath' => Yii::getAlias('@common') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'wizflow_cv' . DIRECTORY_SEPARATOR . Yii::$app->user->id,
                'wizardManagerName' => 'wizflowManagerNewProject'
            ]
        ];
    }

    public function actionExit()
    {
        Yii::$app->wizflowManagerNewProject->destroy();

        $moduleCwh = Yii::$app->getModule('cwh');
        if (isset($moduleCwh) && !empty($moduleCwh->getCwhScope())) {
            $cwhScope = $moduleCwh->getCwhScope();
            if (isset($cwhScope['community'])) {
                return $this->redirect('/project_management/projects/index');
            }
        }
        return $this->redirect('/project_management/projects/own-projects');
    }

    public function actionFinish()
    {
        /** @var StepA $stepA  - choose if  you want  to create a new project community or using one that already exist */
        $stepA = null;
        /** @var StepB $stepB  - choose if you want the same users of the comunity you have chosen */
        $stepB = null;
        /** @var StepC $stepC  - chose the participants for the new community */
        $stepC = null;
        /** @var StepD $stepD  - finish */
        $stepD = null;

        // Populate models
        foreach (Yii::$app->wizflowManagerNewProject->getPath() as $step) {
            if ($step instanceof StepA) {
                $stepA = $step;
            } elseif ($step instanceof StepB) {
                $stepB = $step;
            } elseif ($step instanceof StepC) {
                $stepC = $step;
            } elseif ($step instanceof StepD) {
                $stepD = $step;
            }
        }

        /** @var AmosCommunity $module */
        $module = Yii::$app->getModule('community');

        // If not empty we maust to create new community
        if (!empty($stepC) && !empty($stepD)) {
            $title = $stepD->projectTitle;
            try {
                $communityId = $module->createCommunity($title,
                    CommunityType::COMMUNITY_TYPE_CLOSED,
                    Community::className(),
                    Community::ROLE_COMMUNITY_MANAGER,
                    ''
                );
            } catch (CommunityException $e) {
                Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', $e->getLine() . ' ' . basename($e->getFile()) . ': ' . $e->getMessage()));
            }

        } else {
            // create a sub-community with a progject based on the community selected on StepA
            $communityName = null;
            if (!empty($stepA)) {
                $community = Community::findOne($stepA->select);
                if (!empty($community)) {
                    $communityId = $module->createCommunity($stepD->projectTitle,
                        CommunityType::COMMUNITY_TYPE_CLOSED,
                        Community::className(),
                        Community::ROLE_COMMUNITY_MANAGER,
                        ''
                    );
                    $communityCreated = Community::findOne($communityId);
                    $communityCreated->parent_id = $stepA->select;
                    $communityCreated->save(false);
                }
            }
        }

        // case when you crate a new community, or you use a community tht already exist but you choose to not import all user of the community father
        if (!empty($stepC)) {
            if (!empty($communityId)) {
                try {
                    $listOfUsers = $stepC->users;
                    foreach ($listOfUsers as $userId) {
                        $module->createCommunityUser($communityId, CommunityUserMm::STATUS_ACTIVE, CommunityUserMm::ROLE_PARTICIPANT, $userId);
                    }
                } catch (CommunityException $e) {
                    Yii::$app->getSession()->addFlash('success', Module::t('amosproject_management', $e->getLine() . ' ' . basename($e->getFile()) . ': ' . $e->getMessage()));
                }
            } else {
                Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', 'ERROR: Community not found, users can\'t associate'));
            }
        }
        // case - when you chose to create a project based on a comunity that already exist, and you choose to import all the susers from it
        else if(!empty($stepB)){
            if (!empty($communityId)) {
                try {
                    $communitySelected = Community::findOne($stepA->select);
                    $listOfUsers = $communitySelected->getCommunityUsers()->select('user.id')->asArray()->column();
                    foreach ($listOfUsers as $userId) {
                        $module->createCommunityUser($communityId, CommunityUserMm::STATUS_ACTIVE, CommunityUserMm::ROLE_PARTICIPANT, $userId);
                    }
                } catch (CommunityException $e) {
                    Yii::$app->getSession()->addFlash('success', Module::t('amosproject_management', $e->getLine() . ' ' . basename($e->getFile()) . ': ' . $e->getMessage()));
                }
            } else {
                Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', 'ERROR: Community not found, users can\'t associate'));
            }
        }

        if (!empty($communityId) && !empty($stepD)) {
            $title = $stepD->projectTitle;
            $project = new Projects();
            $project->community_id = $communityId;
            $project->name = $title;
            $project->save(false);

            // Create a new generic spending cost on project creation
            $projectCustomCostItem = new ProjectsCustomSpendingVoices();
            $projectCustomCostItem->projects_id = $project->id;
            $projectCustomCostItem->name = Module::t('amosproject_management', 'General Costs');
            $projectCustomCostItem->save(false);

            Yii::$app->getSession()->addFlash('success', Module::t('amosproject_management', '#NEW_PROJECT_CREATION_SUCCESS_MESSAGE'));
            return $this->render('finish', ['model' => $project]);
//            return $this->redirect(['/project_management/projects/update', 'id' => $project->id]);
        } else {
            Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', 'ERROR: Community not found, project not created'));
        }
        $url = ['/project_management/new-project-wizard/from-community'];
        if (!empty($communityId)) {
            $url['id'] = $communityId;
        }
        return $this->redirect($url);
    }

    public function actionIndex()
    {
        return $this->redirect(['wizard', 'nav' => 'start']);
    }

    /**
     * @param null $id
     * @return \yii\web\Response
     */
    public function actionFromCommunity($id = null)
    {

        if ($id) {
            $wizflow['path'] = ['NewProjectWizardWorkflow/STEPA' => [
                'status' => 'NewProjectWizardWorkflow/STEPA',
                'select' => $id,
                'forceEvalutaModel' => 1
            ]
            ];
            $wizflow['current'] = [
                'status' => 'NewProjectWizardWorkflow/STEPB',
                'allCommunityUsersInProject' => 0
            ];

            Yii::$app->session->set(Yii::$app->wizflowManagerNewProject->skeyName, $wizflow);
            return $this->redirect(Yii::$app->urlManager->createUrl(['project_management/new-project-wizard/wizard', 'nav' => 'ritorno']));
        }


        return $this->redirect(Yii::$app->urlManager->createUrl(['project_management/new-project-wizard/wizard', 'nav' => 'start']));
    }
}
