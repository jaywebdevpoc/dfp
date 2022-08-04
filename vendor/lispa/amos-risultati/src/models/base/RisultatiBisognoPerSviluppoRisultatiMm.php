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
 * This is the base-model class for table "risultati_bisogno_per_sviluppo_risultati_mm".
 *
 * @property integer $id
 * @property integer $risultati_id
 * @property integer $bisogno_per_sviluppo_risultati_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\risultati\models\BisognoPerSviluppoRisultati $bisognoPerSviluppoRisultati
 * @property \lispa\amos\risultati\models\Risultati $risultati
 */
class RisultatiBisognoPerSviluppoRisultatiMm extends \lispa\amos\core\record\Record
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'risultati_bisogno_per_sviluppo_risultati_mm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['risultati_id', 'bisogno_per_sviluppo_risultati_id'], 'required'],
            [['risultati_id', 'bisogno_per_sviluppo_risultati_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['bisogno_per_sviluppo_risultati_id'], 'exist', 'skipOnError' => true, 'targetClass' => \lispa\amos\risultati\models\BisognoPerSviluppoRisultati::className(), 'targetAttribute' => ['bisogno_per_sviluppo_risultati_id' => 'id']],
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
            'bisogno_per_sviluppo_risultati_id' => AmosRisultati::t('amosrisultati', 'Bisogno Per Sviluppo Risultati ID'),
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
    public function getBisognoPerSviluppoRisultati()
    {
        return $this->hasOne(\lispa\amos\risultati\models\BisognoPerSviluppoRisultati::className(), ['id' => 'bisogno_per_sviluppo_risultati_id'])->inverseOf('risultatiBisognoPerSviluppoRisultatiMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRisultati()
    {
        return $this->hasOne(\lispa\amos\risultati\models\Risultati::className(), ['id' => 'risultati_id'])->inverseOf('risultatiBisognoPerSviluppoRisultatiMms');
    }
}
