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
 * This is the base-model class for table "risultati_protezione_innovazione_risultati_mm".
 *
 * @property integer $id
 * @property integer $risultati_id
 * @property integer $protezione_innovazione_risultati_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\risultati\models\ProtezioneInnovazioneRisultati $protezioneInnovazioneRisultati
 * @property \lispa\amos\risultati\models\Risultati $risultati
 */
class RisultatiProtezioneInnovazioneRisultatiMm extends \lispa\amos\core\record\Record
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'risultati_protezione_innovazione_risultati_mm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['risultati_id', 'protezione_innovazione_risultati_id'], 'required'],
            [['risultati_id', 'protezione_innovazione_risultati_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['protezione_innovazione_risultati_id'], 'exist', 'skipOnError' => true, 'targetClass' => \lispa\amos\risultati\models\ProtezioneInnovazioneRisultati::className(), 'targetAttribute' => ['protezione_innovazione_risultati_id' => 'id']],
            [['risultati_id'], 'exist', 'skipOnError' => true, 'targetClass' => \lispa\amos\risultati\models\Risultati::className(), 'targetAttribute' => ['risultati_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => AmosRisultati::t('amosrisultati', 'ID'),
            'risultati_id' => AmosRisultati::t('amosrisultati', 'Risultati ID'),
            'protezione_innovazione_risultati_id' => AmosRisultati::t('amosrisultati', 'Protezione Innovazione Risultati ID'),
            'created_at' => AmosRisultati::t('amosrisultati', 'Creato il'),
            'updated_at' => AmosRisultati::t('amosrisultati', 'Aggiornato il'),
            'deleted_at' => AmosRisultati::t('amosrisultati', 'Cancellato il'),
            'created_by' => AmosRisultati::t('amosrisultati', 'Creato da'),
            'updated_by' => AmosRisultati::t('amosrisultati', 'Aggiornato da'),
            'deleted_by' => AmosRisultati::t('amosrisultati', 'Cancellato da')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProtezioneInnovazioneRisultati()
    {
        return $this->hasOne(\lispa\amos\risultati\models\ProtezioneInnovazioneRisultati::className(), ['id' => 'protezione_innovazione_risultati_id'])->inverseOf('risultatiProtezioneInnovazioneRisultatiMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRisultati()
    {
        return $this->hasOne(\lispa\amos\risultati\models\Risultati::className(), ['id' => 'risultati_id'])->inverseOf('risultatiProtezioneInnovazioneRisultatiMms');
    }
}
