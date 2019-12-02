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
 * @var \lispa\amos\core\user\User $user Main user
 * @var \lispa\amos\admin\models\UserProfile $profile Main user profile
 * @var array $partner partner data
 * @var string $urlYes
 * @var string $urlNo
 */
?>

<h2><?= $event->title ?></h2>
<p><?= $event->summary ?></p>

<p>Gentile <?= $partner['name'], ' ', $partner['surname'] ?>, sei stato invitato come accompagnatore di <?= $profile->getNomeCognome() ?>, per partecipare a questo evento, desideri partecipare?</p>

<a href="<?= $urlYes ?>">Si, parteciperò</a>


