<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\myactivities\basic
 * @category   CategoryName
 */

namespace lispa\amos\myactivities\basic;

use lispa\amos\admin\models\UserProfile;

/**
 * Class UserProfileToValidate
 * @package lispa\amos\myactivities\basic
 */
class UserProfileToValidate extends UserProfile implements MyActivitiesModelsInterface
{
    private $searchStringToValidate = '';

    public function init()
    {
        parent::init();
        $this->searchStringToValidate = (!is_null($this->createdUserProfile) ? $this->createdUserProfile->getNomeCognome() : '');
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getSearchString()
    {
        return $this->searchStringToValidate;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getCreatorNameSurname()
    {
        return $this->searchStringToValidate;
    }

    /**
     * @return UserProfile
     */
    public function getWrappedObject()
    {
        return UserProfile::findOne($this->id);
    }
}
