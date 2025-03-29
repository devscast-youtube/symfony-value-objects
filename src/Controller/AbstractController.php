<?php

declare(strict_types=1);

namespace App\Controller;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;

/**
 * Class AbstractController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractController extends SymfonyController
{
    #[\Override]
    public static function getSubscribedServices(): array
    {
        $subscribedServices = parent::getSubscribedServices();

        $subscribedServices[] = CommandBus::class;
        $subscribedServices[] = QueryBus::class;

        return $subscribedServices;
    }

    protected function handleCommand(object $command): mixed
    {
        return $this->container->get(CommandBus::class)->handle($command);
    }

    protected function handleQuery(object $query): mixed
    {
        return $this->container->get(QueryBus::class)->handle($query);
    }
}
