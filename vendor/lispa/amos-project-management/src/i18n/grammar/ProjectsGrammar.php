<?php

namespace lispa\amos\projectmanagement\i18n\grammar;

use lispa\amos\core\interfaces\ModelGrammarInterface;
use lispa\amos\projectmanagement\Module;

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    piattaforma-openinnovation
 * @category   CategoryName
 */
class ProjectsGrammar implements ModelGrammarInterface
{

    /**
     * @return string The singular model name in translation label
     */
    public function getModelSingularLabel()
    {
        return Module::t('amosproject_management', '#project');
    }

    /**
     * @return string The model name in translation label
     */
    public function getModelLabel()
    {
        return Module::t('amosproject_management', '#projects');
    }

    /**
     * @return mixed
     */
    public function getArticleSingular()
    {
        return Module::t('amosproject_management', '#article_singular');
    }

    /**
     * @return mixed
     */
    public function getArticlePlural()
    {
        return Module::t('amosproject_management', '#article_plural');
    }

    /**
     * @return string
     */
    public function getIndefiniteArticle()
    {
        return Module::t('amosproject_management', '#article_indefinite');
    }
}