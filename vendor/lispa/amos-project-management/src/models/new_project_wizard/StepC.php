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

use lispa\amos\admin\models\search\UserProfileSearch;
use lispa\amos\admin\models\UserProfile;
use yii\base\Model;
use lispa\amos\wizflow\WizflowModelInterface;
use yii\data\ActiveDataProvider;

class StepC extends Model implements WizflowModelInterface
{
    const WIZFLOW = 'NewProjectWizardWorkflow/STEPC';
    public $status;
    public $attrSelected;
    public $users;
    public $passStep;

    public function init()
    {
        $this->attrSelected = $this->users;
        $this->passStep = 'true';
        parent::init();
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['status', 'attrSelected', 'users', 'passStep'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [];
    }

    public function summary()
    {
        return 'C';
    }

    public function getAllProfilesDataProvider()
    {
        \Yii::$app->request->get();
        $nome = '';
        $cognome  ='';
        if(!empty(\Yii::$app->request->get('UserProfileSearch')['cognome'])) {
            $cognome = \Yii::$app->request->get('UserProfileSearch')['cognome'];
        }
        if(!empty(\Yii::$app->request->get('UserProfileSearch')['nome'])) {
            $nome = \Yii::$app->request->get('UserProfileSearch')['nome'];
        }


        $query = UserProfile::find()
            ->andWhere(['attivo' =>1 , 'validato_almeno_una_volta' => 1])
            ->andFilterWhere(['like', 'nome', $nome])
            ->andFilterWhere(['like', 'cognome', $cognome]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $dataProvider;
    }

}
