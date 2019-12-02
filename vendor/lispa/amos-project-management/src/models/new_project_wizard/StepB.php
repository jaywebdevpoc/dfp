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

use lispa\amos\admin\models\UserProfile;
use lispa\amos\community\AmosCommunity;
use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\projectmanagement\events\NewProjectWizardEvents;
use raoul2000\workflow\base\SimpleWorkflowBehavior;
use yii\base\Model;
use lispa\amos\wizflow\WizflowModelInterface;
use lispa\amos\projectmanagement\Module;
use Yii;
use lispa\amos\community\models\Community;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class StepB extends Model implements WizflowModelInterface
{
    const WIZFLOW = 'NewProjectWizardWorkflow/STEPB';
    public $status;
    public $allCommunityUsersInProject;


    public function init()
    {
        $this->on(SimpleWorkflowBehavior::EVENT_BEFORE_CHANGE_STATUS, [new NewProjectWizardEvents(), 'checkStepB'], $this);
        parent::init();
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['status', 'allCommunityUsersInProject'], 'safe'],
            [['allCommunityUsersInProject'], 'required', 'message' => Module::t('amosproject_management', '#confirm_cannot_be_empty')],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'allCommunityUsersInProject' => Module::t('amosproject_management', '#NEW_PROJECT_ALL_COMMUNITY_USER_IN_PROJECT_LABEL'),
        ];
    }

    public function summary()
    {
        return 'B';
    }

    public function getAnswers()
    {
        return [
            1 => Module::t('amosproject_management', '#NEW_PROJECT_NO_LABEL'),
            0 => Module::t('amosproject_management', '#NEW_PROJECT_YES_LABEL'),
        ];
    }

    public function getCommunityUsersDataProvider()
    {
        $community = $this->getCommunityStepA();
        if (!empty($community)) {
            /** @var ActiveQuery $query */
            $query = UserProfile::find();
            $query->andWhere(['user_id' => ArrayHelper::map($community->communityUsers, 'id', 'id')]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            return $dataProvider;
        }
        return new ActiveDataProvider([
            'query' => UserProfile::find()->andWhere(['user_id' => 0])
        ]);
    }

    public function getCommunityStepA()
    {
        $path = Yii::$app->wizflowManagerNewProject->getPath();
        foreach ($path as $item) {
            if ($item instanceof StepA) {
                $community = Community::findOne($item->select);
                if (!empty($community)) {
                    return $community;
                }
            }
        }
        return null;
    }

}
