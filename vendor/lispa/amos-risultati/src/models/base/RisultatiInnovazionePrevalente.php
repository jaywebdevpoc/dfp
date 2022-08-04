<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\risultati
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

namespace lispa\amos\risultati\models\base;

use lispa\amos\risultati\AmosRisultati;

/**
 * This is the base-model class for table "risultati_innovazione_prevalente".
 *
 * @property string $id
 * @property string $nome
 * @property integer $ordinal
 *
 * @property \lispa\amos\risultati\models\Risultati[] $risultatis
 */
class RisultatiInnovazionePrevalente extends \lispa\amos\core\record\Record
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'risultati_innovazione_prevalente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nome', 'ordinal'], 'required'],
            [['ordinal'], 'integer'],
            [['id', 'nome'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => AmosRisultati::t('amosrisultati', 'ID'),
            'nome' => AmosRisultati::t('amosrisultati', 'Nome'),
            'ordinal' => AmosRisultati::t('amosrisultati', 'Ordinal'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRisultatis()
    {
        return $this->hasMany(\lispa\amos\risultati\models\Risultati::className(), ['e_una_innovazione_prevalenteme' => 'id']);
    }
}
