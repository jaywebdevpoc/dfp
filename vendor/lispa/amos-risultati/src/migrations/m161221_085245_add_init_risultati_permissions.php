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

use lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;

/**
 * Class m161221_085245_add_init_risultati_permissions
 */
class m161221_085245_add_init_risultati_permissions extends AmosMigrationPermissions
{
    /**
     * Use this function to map permissions, roles and associations between permissions and roles. If you don't need to
     * to add or remove any permissions or roles you have to delete this method.
     */
    protected function setAuthorizations()
    {
        $this->authorizations = array_merge(
            $this->setPluginRoles(),
            $this->setModelPermissions(),
            $this->setWidgetsPermissions()
        );
    }

    private function setPluginRoles()
    {
        return [
            [
                'name' => 'AMMINISTRATORE_RISULTATI',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Ruolo amministratore per il plugin risultati',
                'ruleName' => null,
                'parent' => ['ADMIN']
            ]
        ];
    }

    private function setModelPermissions()
    {
        return [

            // Permessi per il model Risultati
            [
                'name' => 'RISULTATI_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di creazione per il model Risultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'RISULTATI_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di lettura per il model Risultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'RISULTATI_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di modifica per il model Risultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'RISULTATI_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di cancellazione per il model Risultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],

            // Permessi per il model TecnologieRisultati
            [
                'name' => 'TECNOLOGIERISULTATI_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di creazione per il model TecnologieRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'TECNOLOGIERISULTATI_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di lettura per il model TecnologieRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'TECNOLOGIERISULTATI_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di modifica per il model TecnologieRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'TECNOLOGIERISULTATI_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di cancellazione per il model TecnologieRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],

            // Permessi per il model StadioSviluppoRisultati
            [
                'name' => 'STADIOSVILUPPORISULTATI_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di creazione per il model StadioSviluppoRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'STADIOSVILUPPORISULTATI_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di lettura per il model StadioSviluppoRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'STADIOSVILUPPORISULTATI_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di modifica per il model StadioSviluppoRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'STADIOSVILUPPORISULTATI_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di cancellazione per il model StadioSviluppoRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],

            // Permessi per il model ProtezioneInnovazioneRisultati
            [
                'name' => 'PROTEZIONEINNOVAZIONERISULTATI_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di creazione per il model ProtezioneInnovazioneRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'PROTEZIONEINNOVAZIONERISULTATI_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di lettura per il model ProtezioneInnovazioneRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'PROTEZIONEINNOVAZIONERISULTATI_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di modifica per il model ProtezioneInnovazioneRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'PROTEZIONEINNOVAZIONERISULTATI_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di cancellazione per il model ProtezioneInnovazioneRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],

            // Permessi per il model BisognoPerSviluppoRisultati
            [
                'name' => 'BISOGNOPERSVILUPPORISULTATI_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di creazione per il model BisognoPerSviluppoRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'BISOGNOPERSVILUPPORISULTATI_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di lettura per il model BisognoPerSviluppoRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'BISOGNOPERSVILUPPORISULTATI_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di modifica per il model BisognoPerSviluppoRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => 'BISOGNOPERSVILUPPORISULTATI_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di cancellazione per il model BisognoPerSviluppoRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ]
        ];
    }

    private function setWidgetsPermissions()
    {
        $prefixStr = 'Permesso per la dashboard per il widget ';
        return [
            [
                'name' => \lispa\amos\risultati\widgets\icons\WidgetIconRisultatiDashboard::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconRisultatiDashboard',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => \lispa\amos\risultati\widgets\icons\WidgetIconRisultati::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconRisultati',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => \lispa\amos\risultati\widgets\icons\WidgetIconStadioSviluppoRisultati::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconTipologiaCommunity',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => \lispa\amos\risultati\widgets\icons\WidgetIconTecnologieRisultati::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconCommunity',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => \lispa\amos\risultati\widgets\icons\WidgetIconBisognoPerSviluppoRisultati::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconMyCommunities',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ],
            [
                'name' => \lispa\amos\risultati\widgets\icons\WidgetIconProtezioneInnovazioneRisultati::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconCreatedByCommunities',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_RISULTATI']
            ]
        ];
    }
}
