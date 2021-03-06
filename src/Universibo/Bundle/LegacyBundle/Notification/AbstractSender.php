<?php
namespace Universibo\Bundle\LegacyBundle\Notification;

use Universibo\Bundle\LegacyBundle\Entity\Notifica\NotificaItem;

/**
 * Base class for senders
 *
 * @author Davide Bellettini <davide.bellettini@gmail.com>
 */
abstract class AbstractSender implements SenderInterface
{
    public function send(NotificaItem $notification)
    {
        if (!$this->supports($notification)) {
            throw new \InvalidArgumentException('protocol not supported');
        }

        return $this->doSend($notification);
    }

    abstract protected function doSend(NotificaItem $notification);
}
