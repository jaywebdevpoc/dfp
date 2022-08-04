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

use open20\amos\dashboard\models\AmosWidgets;
use Yii;
use \open20\amos\core\record\AmosRecordAudit;
use open20\amos\faq\AmosFaq;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "faq_amos_widgets_mm".
 *
 * @property integer $faq_id
 * @property string $amos_widgets_classname
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property AmosWidgets $amosWidgets
 * @property Faq $faq
 */
class FaqAmosWidgetMm extends AmosRecordAudit
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq_amos_widgets_mm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['faq_id', 'amos_widgets_classname'], 'required'],
            [['faq_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['amos_widgets_classname'], 'exist', 'skipOnError' => true, 'targetClass' => AmosWidgets::className(), 'targetAttribute' => ['amos_widgets_classname' => 'classname']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'faq_id' => AmosFaq::t('amosfaq', 'FAQ ID'),
            'amos_widgets_classname' => AmosFaq::t('amosfaq', 'Widget Classname'),
            'annualita_id' => AmosFaq::t('amosfaq', 'Annualita ID'),
            'created_at' => AmosFaq::t('amosfaq', 'Creato il'),
            'updated_at' => AmosFaq::t('amosfaq', 'Aggiornato il'),
            'deleted_at' => AmosFaq::t('amosfaq', 'Cancellato il'),
            'created_by' => AmosFaq::t('amosfaq', 'Creato da'),
            'updated_by' => AmosFaq::t('amosfaq', 'Aggiornato da'),
            'deleted_by' => AmosFaq::t('amosfaq', 'Cancellato da'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaq()
    {
        return $this->hasOne(Faq::className(), ['id' => 'faq_id'])->inverseOf('faqWidgets');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAmosWidget()
    {
        return $this->hasOne(AmosWidgets::className(), ['amos_widgets_classname' => 'classname']);
    }
}
