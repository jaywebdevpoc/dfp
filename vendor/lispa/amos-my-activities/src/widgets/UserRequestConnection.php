<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\myactivities\widgets
 * @category   CategoryName
 */

namespace lispa\amos\myactivities\widgets;

use lispa\amos\admin\models\UserProfile;
use lispa\amos\core\exceptions\AmosException;
use lispa\amos\core\interfaces\WorkflowModelInterface;
use lispa\amos\core\record\Record;
use lispa\amos\myactivities\AmosMyActivities;
use lispa\amos\myactivities\basic\MyActivitiesModelsInterface;
use lispa\amos\workflow\behaviors\WorkflowLogFunctionsBehavior;
use yii\base\Widget;

/**
 * Class UserRequestConnection
 * @package lispa\amos\myactivities\widgets
 */
class UserRequestConnection extends Widget
{
    /**
     * @var Record|MyActivitiesModelsInterface $model
     */
    public $model;

    /**
     * @var string $labelKey - label for activity title translation
     */
    public $labelKey;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!($this->model instanceof MyActivitiesModelsInterface)) {
            throw new AmosException(AmosMyActivities::t('amosmyactivities', 'UserRequestValidation: object not instance of MyActivitiesModelsInterface'));
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        /** @var WorkflowLogFunctionsBehavior|WorkflowModelInterface $model */
        $model = $this->model;
            $userId = $model->user_id;

            $userProfile = UserProfile::find()->andWhere(['user_id' => $userId])->one();
            if (!is_null($userProfile)) {
                return $this->render('user_request_connection', [
                    'userProfile' => $userProfile,
                    'model' => $this->model,
                    'requestTime' => $model->created_at,
                    'project' => $model->showcaseProject->title,
                    'labelKey' => $this->labelKey,

                ]);
            }
        else
        return '';
    }
}
