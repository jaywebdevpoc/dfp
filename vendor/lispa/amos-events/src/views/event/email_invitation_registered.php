<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\views\email
 * @category   CategoryName
 */

/**
 * @var \lispa\amos\events\models\Event $event
 * @var \lispa\amos\core\user\User $user
 * @var \lispa\amos\admin\models\UserProfile $profile
 * @var string $urlYes
 * @var string $urlNo
 */
?>

<h2><?= $event->title ?></h2>
<p><?= $event->summary ?></p>

<p>Gentile <?= $profile->getNomeCognome() ?>, sei stato invitato a questo evento, desideri partecipare?</p>

<a href="<?= $urlYes ?>">Si, mi iscrivo</a>
