<?php


namespace App\EventListener;

use App\Entity\Subscribe;
use App\Service\SendMail;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class NewSubscriber
{
    private $sendMail;

    public function __construct(SendMail $sendMail)
    {
        $this->sendMail = $sendMail;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Subscribe) {
            $this->sendMail->newsletter($entity->getEmail(), true);
        }
    }
}
