<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package lispa\amos\projectmanagement\models\base
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\models\base;

use lispa\amos\projectmanagement\Module;

/**
 * Class MembershipType
 * This is the base-model class for table "membership_type".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Projects[] $projects
 *
 * @package lispa\amos\projectmanagement\models\base
 */
class MembershipType extends \lispa\amos\core\record\Record
{
    const TYPE_OPEN = 1;
    const TYPE_ON_INVITATION = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '_membership_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('amosproject_management', 'ID'),
            'title' => Module::t('amosproject_management', 'Title')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Projects::className(), ['membership_type_id' => 'id']);
    }
}
