<?php

namespace App\Domains\User\Application\Projectors;

use App\Domains\User\Application\Commands\SaveAccount\SaveAccountCommand;
use App\Domains\User\Application\Commands\UpdateBalanceByUserId\UpdateBalanceByUserIdCommand;
use App\Domains\User\Application\Queries\IsThereAccountByUserId\IsThereAccountByUserIdQuery;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AccountBalanceProjector extends Projector
{
    /**
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(protected CommandBus $commandBus, protected QueryBus $queryBus)
    {
    }

    /**
     * @param AccountCreated $event
     * @return void
     */
    public function onAccountCreated(AccountCreated $event): void
    {
        $isExist = $this->queryBus->ask(
            query: new IsThereAccountByUserIdQuery(
                id: $event->accountAttributes['user_id']
            )
        );
        if (!$isExist) {
            $this->commandBus->dispatch(
                command: new SaveAccountCommand(
                    attributes: $event->accountAttributes
                )
            );
        } else {
            $this->commandBus->dispatch(
                command: new UpdateBalanceByUserIdCommand(
                    id: $event->accountAttributes['user_id'],
                    balance: 0
                )
            );
        }
    }
}
