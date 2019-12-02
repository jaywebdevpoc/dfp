<?php

namespace lispa\amos\projectmanagement\models\base;

use lispa\amos\community\models\Community;
use lispa\amos\community\models\CommunityInterface;
use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\core\record\Record;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class Projects
 *
 * This is the base-model class for table "projects".
 *
 * @property integer $id
 * @property string $name
 * @property string $summary
 * @property string $insights
 * @property string $start_date
 * @property string $finish_date
 * @property string $website
 * @property integer $community_id
 * @property integer $membership_type_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\projectmanagement\models\ProjectsActivities[] $projectsActivities
 * @property Community $community
 * @property \lispa\amos\projectmanagement\models\ProjectsActivitiesProjectsMm[] $projectsActivitiesProjectsMms
 * @property \lispa\amos\projectmanagement\models\ProjectsOrganizationMm[] $ProjectsOrganizationMms
 * @property \lispa\amos\projectmanagement\models\ProjectsJoinedOrganizationsMm[] $ProjectsJoinedOrganizationsMms
 * @property \lispa\amos\projectmanagement\models\ProjectsProjectsMeasureMm[] $projectsProjectsMeasureMms
 * @property \lispa\amos\projectmanagement\models\ProjectsProjectsStatesMm[] $projectsProjectsStatesMms
 * @property \lispa\amos\core\user\User[] $users
 * @property \lispa\amos\projectmanagement\models\ProjectsUserMm[] $projectsUserMms
 * @property string $communityRoleByUser
 * @property CommunityUserMm $communityUserMm
 *
 * @package lispa\amos\projectmanagement\models\base
 */
class Projects extends Record implements CommunityInterface
{
    /**
     * @var array Attributo di relazione
     */
    public $attrProjectsStatesMm;
    /**
     * @var array Attributo di relazione
     */
    public $attrOrganizationMm;
    /**
     * @var array Attributo di relazione
     */
    public $attrJoinedOrganizationsMm;
    /**
     * @var array Attributo di relazione
     */
    public $attrProjectsMeasureMm;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['insights'], 'string'],
            [['start_date', 'finish_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['community_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['summary'], 'string', 'max' => 250],
            [['website'], 'string', 'max' => 255],

            [['attrProjectsStatesMm'], 'safe'],

            [['attrOrganizationMm'], 'safe'],

            [['attrJoinedOrganizationsMm'], 'safe'],

            [['attrProjectsMeasureMm'], 'safe'],
        ];
    }

    public $organizationModelClass;

    public function init()
    {
        parent::init();

        /** @var Module $organizationModule */
        $organizationModule = Module::instance()->getModuleOrganization();
        $this->organizationModelClass = $organizationModule->getOrganizationModelClass();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'name' => Module::t('amosproject_management', 'Title'),
            'summary' => Module::t('amosproject_management', 'Summary'),
            'insights' => Module::t('amosproject_management', '#project_insights'),
            'logo' => Module::t('amosproject_management', 'Logo'),
            'start_date' => Module::t('amosproject_management', 'Start Date'),
            'finish_date' => Module::t('amosproject_management', 'Finish Date'),
            'website' => Module::t('amosproject_management', 'Website'),
            'created_at' => Module::t('amosproject_management', 'Creato il'),
            'updated_at' => Module::t('amosproject_management', 'Aggiornato il'),
            'deleted_at' => Module::t('amosproject_management', 'Cancellato il'),
            'created_by' => Module::t('amosproject_management', 'Creato da'),
            'updated_by' => Module::t('amosproject_management', 'Aggiornato da'),
            'deleted_by' => Module::t('amosproject_management', 'Cancellato da'),

            'projectsStates' => Module::t('amosproject_management', 'Progress Status'),
            'attrProjectsStatesMm' => Module::t('amosproject_management', 'Progress Status'),

            'organization' => Module::t('amosproject_management', 'Leader Organization'),
            'attrOrganizationMm' => Module::t('amosproject_management', 'Leader Organization'),

            'joinedOrganizations' => Module::t('amosproject_management', 'Joined Organizations'),
            'attrJoinedOrganizationsMm' => Module::t('amosproject_management', 'Joined Organizations'),

            'projectsMeasure' => Module::t('amosproject_management', '#project_measure'),
            'attrProjectsMeasureMm' => Module::t('amosproject_management', '#project_measure'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsActivitiesProjectsMms()
    {
        $query = $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsActivitiesProjectsMm::className(), ['projects_id' => 'id'])->inverseOf('projects');
        $query->orderBy(\lispa\amos\projectmanagement\models\ProjectsActivitiesProjectsMm::tableName() . '.projects_activities_id ASC');
        return $query;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsOrganizationMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsOrganizationMm::className(), ['projects_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsJoinedOrganizationsMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsJoinedOrganizationsMm::className(), ['projects_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProjectsMeasureMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsProjectsMeasureMm::className(), ['projects_id' => 'id'])->inverseOf('projects');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProjectsStatesMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsProjectsStatesMm::className(), ['projects_id' => 'id'])->inverseOf('projects');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsStates()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsStates::className(), ['id' => 'projects_states_id'])->via('projectsProjectsStatesMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['id' => 'community_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunityUserMm()
    {
        return $this->hasOne(CommunityUserMm::className(), ['community_id' => 'community_id']);
    }

    /**
     * @return string
     */
    public function getAttrProjectsStatesMm()
    {
        $ritorno = "";
        $ritorno .= '' . (!is_null($this->projectsStates) ? $this->projectsStates->name : '');

        return $ritorno;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne($this->organizationModelClass, ['id' => 'organization_id'])->via('projectsOrganizationMms');
    }

    /**
     * @return string
     */
    public function getattrOrganizationMm()
    {
        $ritorno = "";
        $ritorno .= '' . $this->organization ? $this->organization->nameField : '';

        return $ritorno;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJoinedOrganizations()
    {
        return $this->hasMany($this->organizationModelClass, ['id' => 'organization_id'])->via('projectsJoinedOrganizationsMms');
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getattrJoinedOrganizationsMm($separator = ' ')
    {
        $ritorno = "";
        $ind = 0;
        foreach ((array)$this->joinedOrganizations as $str) {
            $ritorno .= (($ind == 0) ? '' : ', ') . $str['denominazione'];
            $ind++;
        }
        return $ritorno;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsMeasure()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsMeasure::className(), ['id' => 'projects_measure_id'])->via('projectsProjectsMeasureMms');
    }

    /**
     * @inheritdoc
     */
    public function getCommunityId()
    {
        return $this->community_id;
    }

    /**
     * @inheritdoc
     */
    public function setCommunityId($communityId)
    {
        $this->community_id = $communityId;
    }

    public function getAttrProjectsMeasureMm()
    {
        $ritorno = "";
        $ritorno .= '' . (!is_null($this->projectsMeasure) ? $this->projectsMeasure->name : '');

        return $ritorno;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsActivities()
    {
        $query = $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsActivities::className(), ['id' => 'projects_activities_id'])->via('projectsActivitiesProjectsMms');
        $query->orderBy(\lispa\amos\projectmanagement\models\ProjectsActivities::tableName() . '.id ASC');
        return $query;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProgressDetectionPeriods()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::className(), ['id' => 'projects_id']);
    }

//    public function getProjectUsers()
//    {
//        $usersQuery = User::find();
//        $usersQuery->innerJoin($this->organizationModelClass, "{Aziende::::tableName()} ");
//        $usersQuery->innerJoin($this->organizationModelClass, "{Aziende::::tableName()} ");
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsSpendingVoices()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsCustomSpendingVoices::className(), ['projects_id' => 'id'])->orderBy(['spending_voice_parent_id' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultProjectsSpendingVoices()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsSpendingVoices::className(), ['projects_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }


    /* @return \yii\db\ActiveQuery
     *
     */
    public function getUsers()
    {
        return $this->hasMany(\lispa\amos\core\user\User::className(), ['id' => 'user_id'])->via('projectsUserMms');
    }

    /** Roles assigned to users
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsUserMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsUserMm::className(), ['projects_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }

    /** Roles assigned to users
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsModifyRequestMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsModifyRequest::className(), ['projects_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunityUserMms()
    {
        return $this->hasMany(\lispa\amos\community\models\CommunityUserMm::className(), ['community_id' => 'community_id'])->inverseOf('community')
            ->from([\lispa\amos\community\models\CommunityUserMm::tableName() => \lispa\amos\community\models\CommunityUserMm::tableName()])
            ->innerJoin(\lispa\amos\core\user\User::tableName() . ' usr1', \lispa\amos\community\models\CommunityUserMm::tableName() . '.user_id = usr1.id and usr1.deleted_at IS NULL')
            ->innerJoin('user_profile', 'usr1.id = user_profile.user_id')
            ->andWhere(['user_profile.attivo' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantsOrganizations()
    {
        $cwh = \Yii::$app->getModule("cwh");
        $community = \Yii::$app->getModule("community");
        $className = \lispa\amos\projectmanagement\Module::getModuleOrganization()->getOrganizationModelClass();
        $idOrganizations = [];
        if (isset($community) && isset($cwh)) {
            $communitySearch = \lispa\amos\community\models\search\CommunitySearch::findOne($this->community_id);
            $participantsDataProvider = $communitySearch->searchParticipants([]);
            $participants = $participantsDataProvider->models;
            foreach ($participants as $participant) {
                /** @var  $dataProviderOrgsanizations ActiveDataProvider */
                $organizations = \lispa\amos\cwh\utility\CwhUtil::getUserNetworkQuery($className::getCwhConfigId(), $participant->user->id, false)->all();
                foreach ($organizations as $organization) {
                    $idOrganizations [] = $organization->id;
                }
            }
        }
        return $className::find()->andWhere(['id' => $idOrganizations]);
    }

    /**
     * @return array
     */
    public function getCommunityRoleByUser()
    {
        $userId = Yii::$app->user->id;
        $communityUsersQuery = $this->community->getCommunityUserMms();
        $communityUsersQuery->andWhere(['user_profile.user_id' => $userId]);

        $projectRoles = [
            'PROJECT_MANAGER' => Module::t('amosproject_management', 'Project Manager'),
            'PARTNER_REFERENT' => Module::t('amosproject_management', 'Partner Referent'),
            'PARTICIPANT' => Module::t('amosproject_management', 'Participant'),
            'COMMUNITY_MANAGER' => Module::t('amosproject_management', 'Project Manager'),
            'READER' => Module::t('amosproject_management', 'Reader'),
        ];
        $communityUser = $communityUsersQuery->one();
        if (is_null($communityUser)) {
            return [];
        }
        return [$communityUser->role, $projectRoles[$communityUser->role]];
    }
}
