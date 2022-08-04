<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\faq
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

namespace open20\amos\faq\models\base;

use open20\amos\core\record\Record;
use open20\amos\dashboard\models\AmosWidgets;
use open20\amos\faq\AmosFaq;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "faq".
 *
 * @property integer $id
 * @property string $domanda
 * @property string $risposta
 * @property integer $order
 * @property string $rotte
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property integer $version
 * @property integer $faq_categories_id
 * @property integer $faq_stato_id
 *
 * @property \open20\amos\faq\models\FaqCategories $faqCategories
 * @property \open20\amos\faq\models\FaqStato $faqStato
 * @property \open20\amos\faq\models\FaqWidgets $faqWidgets
 */
class Faq extends Record
{
    public $listaWidget;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['domanda', 'risposta'], 'string'],
            [['order', 'created_by', 'updated_by', 'deleted_by', 'version', 'faq_categories_id', 'faq_stato_id'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'rotte', 'listaWidget'], 'safe'],
            [['faq_stato_id'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => AmosFaq::t('amosfaq', 'ID'),
            'domanda' => AmosFaq::t('amosfaq', 'Domanda'),
            'risposta' => AmosFaq::t('amosfaq', 'Risposta'),
            'order' => AmosFaq::t('amosfaq', 'Ordinamento'),
            'rotte' => AmosFaq::t('amosfaq', 'Rotte'),
            'created_at' => AmosFaq::t('amosfaq', 'Creato il'),
            'updated_at' => AmosFaq::t('amosfaq', 'Aggiornato il'),
            'deleted_at' => AmosFaq::t('amosfaq', 'Cancellato il'),
            'created_by' => AmosFaq::t('amosfaq', 'Creato da'),
            'updated_by' => AmosFaq::t('amosfaq', 'Aggiornato da'),
            'deleted_by' => AmosFaq::t('amosfaq', 'Cancellato da'),
            'version' => AmosFaq::t('amosfaq', 'Versione numero'),
            'faq_categories_id' => AmosFaq::t('amosfaq', 'Id Categoria'),
            'faq_stato_id' => AmosFaq::t('amosfaq', 'Id Stato'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaqCategories()
    {
        return $this->hasOne(\open20\amos\faq\models\FaqCategories::className(), ['id' => 'faq_categories_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaqStato()
    {
        return $this->hasOne(\open20\amos\faq\models\FaqStato::className(), ['id' => 'faq_stato_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaqWidgets()
    {
        return $this->hasOne(FaqAmosWidgetMm::className(), ['id' => 'faq_id']);
    }

    /**
     * @return $this
     */
    public function getAmosWidgets()
    {
        return $this->hasMany(AmosWidgets::className(), ['classname' => 'amos_widgets_classname'])
            ->viaTable('faq_amos_widgets_mm', ['faq_id' => 'id']);
    }

}
