<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\models\new_project_wizard
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\models\new_project_wizard;

use lispa\amos\community\models\Community;
use lispa\amos\projectmanagement\events\NewProjectWizardEvents;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use raoul2000\workflow\base\SimpleWorkflowBehavior;
use yii\base\Model;
use lispa\amos\wizflow\WizflowModelInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 *
 * Class StepA
 * @package lispa\amos\projectmanagement\models\new_project_wizard
 */
class StepA extends Model implements WizflowModelInterface
{
    const WIZFLOW = 'NewProjectWizardWorkflow/STEPA';
    public $status;
    public $select;
    public $forceEvalutaModel;

    public function init()
    {
        $this->on(SimpleWorkflowBehavior::EVENT_BEFORE_CHANGE_STATUS, [new NewProjectWizardEvents(), 'checkStepA'], $this);
        parent::init();
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['status', 'forceEvalutaModel', 'select'], 'safe'],
//            [['select'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'select' => Module::t('amosproject_management', '#NEW_PROJECT_SELECT_COMMUNITY_LABEL')
        ];
    }

    public function summary()
    {
        return 'A';
    }

    public function getCommunityPartecipans($userId = null)
    {
        if (empty($userId)){
            $userId = \Yii::$app->user->id;
        }
        /** @var ActiveQuery $query */
        $query = Community::find();
        $query->joinWith('communityUsers',false);
        $query->andWhere(['user.id' => $userId]);
        $communityArray = $query->all();
        $communityArrayResult = $communityArray;
        /** @var Community $community */
        foreach ($communityArray as $key => $community){
            if (!ProjectManagementUtility::loggedUsedIsCommunityManager($community->id)){
                ArrayHelper::remove($communityArrayResult,$key);
            }
        }
        return ArrayHelper::merge(ArrayHelper::map($communityArrayResult,'id','name'), [
            // 0 => Module::t('amosproject_management','#NEW_PROJECT_CREATE_NEW_COMMUNITY_CHOISE')
        ]);
    }

}
