<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\base
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\base;

/**
 * Class PartnershipProfilesModules
 * @package lispa\amos\partnershipprofiles\base
 */
class PartnershipProfilesModules
{
    const PART_PROF_MODULE_NAME = 'partnershipprofiles';
    const PART_PROF_ADMIN_MODULE_NAME = 'partnershipprofilesadmin';
    const EXPR_OF_INT_MODULE_NAME = 'expressionsofinterest';
    const EXPR_OF_INT_ADMIN_MODULE_NAME = 'expressionsofinterestadmin';
    const PART_PROF_EXPR_OF_INT_MODULE_NAME = 'partnerprofexprofint';

    public static function getAllModuleNames()
    {
        return [
            self::PART_PROF_MODULE_NAME,
            self::PART_PROF_ADMIN_MODULE_NAME,
            self::EXPR_OF_INT_MODULE_NAME,
            self::EXPR_OF_INT_ADMIN_MODULE_NAME,
            self::PART_PROF_EXPR_OF_INT_MODULE_NAME
        ];
    }
}
