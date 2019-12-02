<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\sondaggi\models
 * @category   CategoryName
 */

namespace lispa\amos\sondaggi\models;
use lispa\amos\attachments\behaviors\FileBehavior;
use yii\helpers\ArrayHelper;

/**
 * Class SondaggiRisposte
 * This is the model class for table "sondaggi_risposte".
 * @package lispa\amos\sondaggi\models
 */
class SondaggiRisposte extends \lispa\amos\sondaggi\models\base\SondaggiRisposte
{

    public $attachment;
    public $attachment_multiple;

    /**
     * @inheritdoc
     */
    public function representingColumn()
    {
        return [
            'risposta_libera'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        $i = 1;
        if($this->sondaggi_domande_id == 11){
            $i = 0;
        }
        return ArrayHelper::merge(parent::rules(), [
            //[['regola_pubblicazione', 'destinatari', 'validatori'], 'safe'],
            [['domanda_'.$this->sondaggi_domande_id], 'file', 'maxFiles' => 0],
        ]);
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),
            [
                'fileBehavior' => [
                    'class' => FileBehavior::className()
                ],
            ]);
    }
}
