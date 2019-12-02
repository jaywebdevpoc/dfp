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
 * Class ExpressionsOfInterestGrammar
 * @package lispa\amos\partnershipprofiles\i18n\grammar
 */
class ExpressionsOfInterestGrammar implements ModelGrammarInterface
{
    /**
     * @inheritdoc
     */
    public function getModelSingularLabel()
    {
        return Module::t('amospartnershipprofiles', '#expressions_of_interest_singular');
    }
    
    /**
     * @inheritdoc
     */
    public function getModelLabel()
    {
        return Module::t('amospartnershipprofiles', '#expressions_of_interest_plural');
    }
    
    /**
     * @inheritdoc
     */
    public function getArticleSingular()
    {
        return Module::t('amospartnershipprofiles', '#expressions_of_interest_article_singular');
    }
    
    /**
     * @inheritdoc
     */
    public function getArticlePlural()
    {
        return Module::t('amospartnershipprofiles', '#expressions_of_interest_article_plural');
    }
    
    /**
     * @inheritdoc
     */
    public function getIndefiniteArticle()
    {
        return Module::t('amospartnershipprofiles', '#expressions_of_interest_indefinite_article');
    }
}
