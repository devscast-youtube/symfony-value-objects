<?php

declare(strict_types=1);

namespace App\Bus;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class CommandBus
{
    use HandleTrait {
        HandleTrait::handle as messengerHandle;
    }

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    /**
     * @throws \Throwable
     */
    public function handle(object $message): mixed
    {
        try {
            return $this->messengerHandle($message);
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                /** @var \Throwable $e */
                $e = $e->getPrevious();
            }

            throw $e;
        }
    }
}
