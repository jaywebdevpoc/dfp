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
 * This is the base-model class for table "bisogno_per_sviluppo_risultati".
 *
 * @property integer $id
 * @property string $denominazione
 * @property string $descrizione
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\risultati\models\RisultatiBisognoPerSviluppoRisultatiMm[] $risultatiBisognoPerSviluppoRisultatiMms
 */
class BisognoPerSviluppoRisultati extends \lispa\amos\core\record\Record
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bisogno_per_sviluppo_risultati';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['denominazione'], 'required'],
            [['descrizione'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['denominazione'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => AmosRisultati::t('amosrisultati', 'ID'),
            'denominazione' => AmosRisultati::t('amosrisultati', 'Denominazione'),
            'descrizione' => AmosRisultati::t('amosrisultati', 'Descrizione'),
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
    public function getRisultatiBisognoPerSviluppoRisultatiMms()
    {
        return $this->hasMany(\lispa\amos\risultati\models\RisultatiBisognoPerSviluppoRisultatiMm::className(), ['bisogno_per_sviluppo_risultati_id' => 'id'])->inverseOf('bisognoPerSviluppoRisultati');
    }
}
