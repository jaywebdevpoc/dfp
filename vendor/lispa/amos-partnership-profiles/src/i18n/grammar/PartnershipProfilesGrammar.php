<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\i18n\grammar
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\i18n\grammar;

use lispa\amos\core\interfaces\ModelGrammarInterface;
use lispa\amos\partnershipprofiles\Module;

/**
 * Class PartnershipProfilesGrammar
 * @package lispa\amos\partnershipprofiles\i18n\grammar
 */
class PartnershipProfilesGrammar implements ModelGrammarInterface
{
    /**
     * @inheritdoc
     */
    public function getModelSingularLabel()
    {
        return Module::t('amospartnershipprofiles', '#partnership_profiles_singular');
    }
    
    /**
     * @inheritdoc
     */
    public function getModelLabel()
    {
        return Module::t('amospartnershipprofiles', '#partnership_profiles_plural');
    }
    
    /**
     * @inheritdoc
     */
    public function getArticleSingular()
    {
        return Module::t('amospartnershipprofiles', '#partnership_profiles_article_singular');
    }
    
    /**
     * @inheritdoc
     */
    public function getArticlePlural()
    {
        return Module::t('amospartnershipprofiles', '#partnership_profiles_article_plural');
    }
    
    /**
     * @inheritdoc
     */
    public function getIndefiniteArticle()
    {
        return Module::t('amospartnershipprofiles', '#partnership_profiles_indefinite_article');
    }
}
