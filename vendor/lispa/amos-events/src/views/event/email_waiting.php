<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\views\email
 * @category   CategoryName
 */

use lispa\amos\events\AmosEvents;

/**
 * @var \lispa\amos\events\models\Event $event
 * @var \lispa\amos\core\user\User $user
 * @var \lispa\amos\admin\models\UserProfile $profile
 */

$message = AmosEvents::t('amosevents', 'Gentile {name_surname}', ['name_surname' => $profile->getNomeCognome()]) . ', ' .
    AmosEvents::t('amosevents', 'il numero massimo di posti disponibili è stato superato') . '.';

?>

<h2><?= $event->title ?></h2>
<p><?= $event->summary ?></p>

<p><?= $message ?></p>
