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
 * This is the base-model class for table "risultati".
 *
 * @property integer $id
 * @property string $stato
 * @property string $titolo_dellinnovazione
 * @property string $sommario
 * @property string $e_una_innovazione_prevalenteme
 * @property string $coerenza_ads_tag
 * @property string $referente
 * @property string $sito_web_per_approfondimento_p
 * @property string $cosa_ce_oggi_che_prima_non_cer
 * @property string $e_importante_sapere_anche_ques
 * @property string $qual_e_attualmente_il_mercato_
 * @property string $ce_un_mercato_geografico_di_ri
 * @property string $in_che_modo_il_lavoro_in_partn
 * @property string $qual_e_laziendaorganismo_di_ri
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\risultati\models\RisultatiBisognoPerSviluppoRisultatiMm[] $risultatiBisognoPerSviluppoRisultatiMms
 * @property \lispa\amos\risultati\models\RisultatiProtezioneInnovazioneRisultatiMm[] $risultatiProtezioneInnovazioneRisultatiMms
 * @property \lispa\amos\risultati\models\RisultatiStadioSviluppoRisultatiMm[] $risultatiStadioSviluppoRisultatiMms
 * @property \lispa\amos\risultati\models\RisultatiTecnologieRisultatiMm[] $risultatiTecnologieRisultatiMms
 * @property \lispa\amos\risultati\models\RisultatiInnovazionePrevalente $innovazionePrevalentementeDi
 * @property \lispa\amos\core\user\User $referenteUser
 * @property string $referenteNomeCognome
 * @property \lispa\amos\risultati\models\RisultatiInnovazionePrevalente $organizzazione
 */
class Risultati extends \lispa\amos\core\record\Record
{
    /**
     * @var array Attributo di relazione
     */
    public $attrTecnologieRisultatiMm;

    /**
     * @var array Attributo di relazione
     */
    public $attrStadioSviluppoRisultatiMm;

    /**
     * @var array Attributo di relazione
     */
    public $attrProtezioneInnovazioneRisultatiMm;

    /**
     * @var array Attributo di relazione
     */
    public $attrBisognoPerSviluppoRisultatiMm;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'risultati';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stato', 'titolo_dellinnovazione', 'sommario', 'e_una_innovazione_prevalenteme', 'referente', 'cosa_ce_oggi_che_prima_non_cer', 'qual_e_attualmente_il_mercato_', 'ce_un_mercato_geografico_di_ri', 'in_che_modo_il_lavoro_in_partn'], 'required'],
            [['sommario', 'cosa_ce_oggi_che_prima_non_cer', 'e_importante_sapere_anche_ques', 'qual_e_attualmente_il_mercato_', 'ce_un_mercato_geografico_di_ri', 'in_che_modo_il_lavoro_in_partn'], 'string'],
            [['coerenza_ads_tag', 'referente', 'qual_e_laziendaorganismo_di_ri'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['stato', 'titolo_dellinnovazione', 'e_una_innovazione_prevalenteme', 'sito_web_per_approfondimento_p'], 'string', 'max' => 255],

            [['attrTecnologieRisultatiMm'], 'safe'],
            [['attrTecnologieRisultatiMm'], 'required'],

            [['attrStadioSviluppoRisultatiMm'], 'safe'],
            [['attrStadioSviluppoRisultatiMm'], 'required'],

            [['attrProtezioneInnovazioneRisultatiMm'], 'safe'],
            [['attrProtezioneInnovazioneRisultatiMm'], 'required'],

            [['attrBisognoPerSviluppoRisultatiMm'], 'safe'],
            [['attrBisognoPerSviluppoRisultatiMm'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => AmosRisultati::t('amosrisultati', 'ID'),
            'stato' => AmosRisultati::t('amosrisultati', 'Stato'),
            'titolo_dellinnovazione' => AmosRisultati::t('amosrisultati', 'Titolo dell’innovazione'),
            'sommario' => AmosRisultati::t('amosrisultati', 'Sommario'),
            'e_una_innovazione_prevalenteme' => AmosRisultati::t('amosrisultati', 'E’ una innovazione prevalentemente di'),
            'coerenza_ads_tag' => AmosRisultati::t('amosrisultati', 'Coerenza ADS (TAG)'),
            'referente' => AmosRisultati::t('amosrisultati', 'Referente'),
            'sito_web_per_approfondimento_p' => AmosRisultati::t('amosrisultati', 'Sito web per approfondimento progetto'),
            'cosa_ce_oggi_che_prima_non_cer' => AmosRisultati::t('amosrisultati', 'Cosa c’è oggi che prima non c’era'),
            'e_importante_sapere_anche_ques' => AmosRisultati::t('amosrisultati', 'E’ importante sapere anche questo…'),
            'qual_e_attualmente_il_mercato_' => AmosRisultati::t('amosrisultati', 'Qual è attualmente il mercato di riferimento?'),
            'ce_un_mercato_geografico_di_ri' => AmosRisultati::t('amosrisultati', 'C’è un mercato geografico di riferimento spec'),
            'in_che_modo_il_lavoro_in_partn' => AmosRisultati::t('amosrisultati', 'In che modo il lavoro in partnership ha reso'),
            'qual_e_laziendaorganismo_di_ri' => AmosRisultati::t('amosrisultati', 'Qual è l’azienda/organismo di ricerca titolar'),
            'created_at' => AmosRisultati::t('amosrisultati', 'Creato il'),
            'updated_at' => AmosRisultati::t('amosrisultati', 'Aggiornato il'),
            'deleted_at' => AmosRisultati::t('amosrisultati', 'Cancellato il'),
            'created_by' => AmosRisultati::t('amosrisultati', 'Creato da'),
            'updated_by' => AmosRisultati::t('amosrisultati', 'Aggiornato da'),
            'deleted_by' => AmosRisultati::t('amosrisultati', 'Cancellato da'),


            'tecnologieRisultati' => AmosRisultati::t('amosrisultati', 'Le tecnologie utilizzate per raggiungere il r'),
            'attrTecnologieRisultatiMm' => AmosRisultati::t('amosrisultati', 'Le tecnologie utilizzate per raggiungere il r'),

            'stadioSviluppoRisultati' => AmosRisultati::t('amosrisultati', 'Stadio attuale di sviluppo dell’innovazione'),
            'attrStadioSviluppoRisultatiMm' => AmosRisultati::t('amosrisultati', 'Stadio attuale di sviluppo dell’innovazione'),

            'protezioneInnovazioneRisultati' => AmosRisultati::t('amosrisultati', 'La componente innovativa è protetta attravers'),
            'attrProtezioneInnovazioneRisultatiMm' => AmosRisultati::t('amosrisultati', 'La componente innovativa è protetta attravers'),

            'bisognoPerSviluppoRisultati' => AmosRisultati::t('amosrisultati', 'Di cosa avrebbe bisogno l’innovazione ai fini'),
            'attrBisognoPerSviluppoRisultatiMm' => AmosRisultati::t('amosrisultati', 'Di cosa avrebbe bisogno l’innovazione ai fini'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRisultatiBisognoPerSviluppoRisultatiMms()
    {
        return $this->hasMany(\lispa\amos\risultati\models\RisultatiBisognoPerSviluppoRisultatiMm::className(), ['risultati_id' => 'id'])->inverseOf('risultati');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRisultatiProtezioneInnovazioneRisultatiMms()
    {
        return $this->hasMany(\lispa\amos\risultati\models\RisultatiProtezioneInnovazioneRisultatiMm::className(), ['risultati_id' => 'id'])->inverseOf('risultati');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRisultatiStadioSviluppoRisultatiMms()
    {
        return $this->hasMany(\lispa\amos\risultati\models\RisultatiStadioSviluppoRisultatiMm::className(), ['risultati_id' => 'id'])->inverseOf('risultati');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRisultatiTecnologieRisultatiMms()
    {
        return $this->hasMany(\lispa\amos\risultati\models\RisultatiTecnologieRisultatiMm::className(), ['risultati_id' => 'id'])->inverseOf('risultati');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTecnologieRisultati()
    {
        return $this->hasOne(\lispa\amos\risultati\models\TecnologieRisultati::className(), ['id' => 'tecnologie_risultati_id'])->via('risultatiTecnologieRisultatiMms');
    }

    public function getAttrTecnologieRisultatiMm()
    {
        $ritorno = "";
        $ritorno .= '' . $this->tecnologieRisultati->denominazione;

        return $ritorno;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStadioSviluppoRisultati()
    {
        return $this->hasOne(\lispa\amos\risultati\models\StadioSviluppoRisultati::className(), ['id' => 'stadio_sviluppo_risultati_id'])->via('risultatiStadioSviluppoRisultatiMms');
    }

    public function getAttrStadioSviluppoRisultatiMm()
    {
        $ritorno = "";
        $ritorno .= '' . $this->stadioSviluppoRisultati->denominazione;

        return $ritorno;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProtezioneInnovazioneRisultati()
    {
        return $this->hasOne(\lispa\amos\risultati\models\ProtezioneInnovazioneRisultati::className(), ['id' => 'protezione_innovazione_risultati_id'])->via('risultatiProtezioneInnovazioneRisultatiMms');
    }

    public function getAttrProtezioneInnovazioneRisultatiMm()
    {
        $ritorno = "";
        $ritorno .= '' . $this->protezioneInnovazioneRisultati->denominazione;

        return $ritorno;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBisognoPerSviluppoRisultati()
    {
        return $this->hasOne(\lispa\amos\risultati\models\BisognoPerSviluppoRisultati::className(), ['id' => 'bisogno_per_sviluppo_risultati_id'])->via('risultatiBisognoPerSviluppoRisultatiMms');
    }

    public function getAttrBisognoPerSviluppoRisultatiMm()
    {
        $ritorno = "";
        $ritorno .= '' . $this->bisognoPerSviluppoRisultati->denominazione;

        return $ritorno;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInnovazionePrevalentementeDi()
    {
        return $this->hasOne(\lispa\amos\risultati\models\RisultatiInnovazionePrevalente::className(), ['id' => 'e_una_innovazione_prevalenteme']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenteUser()
    {
        return $this->hasOne(\lispa\amos\core\user\User::className(), ['id' => 'referente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenteNomeCognome()
    {
        return $this->referenteUser->getProfile()->nomeCognome;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizzazione()
    {
        return $this->hasOne(\lispa\amos\organizzazioni\models\Aziende::className(), ['id' => 'qual_e_laziendaorganismo_di_ri']);
    }
}
