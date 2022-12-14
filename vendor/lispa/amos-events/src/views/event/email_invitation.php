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
 * @var string $urlYes
 * @var string $urlNo
 */
?>

<h2><?= $event->title ?></h2>
<p><?= $event->summary ?></p>

<p>Gentile <?= $user['name'], ' ', $user['surname'] ?>, sei stato invitato a questo evento, desideri partecipare?</p>

<a href="<?= $urlYes ?>">Si, parteciper√≤</a>



