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
use lispa\amos\projectmanagement\Module;
use yii\base\Model;
use lispa\amos\wizflow\WizflowModelInterface;
use Yii;

class StepD extends Model implements WizflowModelInterface
{
    const WIZFLOW = 'NewProjectWizardWorkflow/STEPD';
    public $status;
    public $projectTitle;


    public function init()
    {
        parent::init();
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['status', 'projectTitle'], 'safe'],
            [['projectTitle'], 'string', 'max' => 100],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'projectTitle' => Module::t('amosproject_management', 'Project Title'),
        ];
    }

    public function summary()
    {
        return 'D';
    }

    public function communityName()
    {
        $path = Yii::$app->wizflowManagerNewProject->getPath();
        foreach ($path as $item) {
            if ($item instanceof StepA) {
                $community = Community::findOne($item->select);
                if (!empty($community)) {
                    return $community->name;
                }
            }
        }
        return '';
    }

}
