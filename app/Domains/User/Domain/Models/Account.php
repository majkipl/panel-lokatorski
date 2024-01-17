<?php

namespace App\Domains\User\Domain\Models;

use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Domains\User\Domain\Events\AccountDeleted;
use App\Interfaces\Query\QueryBus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;
use Spatie\EventSourcing\Projections\Projection;

class Account extends Projection
{
    /**
     * @var string
     */
    protected $table = 'accounts';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var QueryBus|Application|\Illuminate\Foundation\Application|mixed
     */
    protected QueryBus $queryBus;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->queryBus = app(QueryBus::class);
    }

    /**
     * @param array $attributes
     * @return Account
     */
    public static function createWithAttributes(array $attributes): Account
    {
        /*
         * Let's generate a uuid.
         */
        $attributes['uuid'] = (string) Uuid::uuid4();

        /*
         * The account will be created inside this event using the generated uuid.
         */
        event(new AccountCreated($attributes));

        /*
         * The uuid will be used the retrieve the created account.
         */
        return static::uuid($attributes['uuid']);
    }

    /**
     * @param float $amount
     * @return void
     */
    public function addMoney(float $amount): void
    {
        event(
            new MoneyAdded(
                accountUuid: $this->uuid,
                amount: $amount
            )
        );
    }

    /**
     * @param float $amount
     * @return void
     */
    public function subtractMoney(float $amount): void
    {
        event(
            new MoneySubtracted(
                accountUuid: $this->uuid,
                amount: $amount
            )
        );
    }

    /**
     * @return void
     */
    public function remove()
    {
        event(new AccountDeleted($this->uuid));
    }

    /**
     * @param string $uuid
     * @return Account|null
     */
    public static function uuid(string $uuid): ?Account
    {
        return static::where('uuid', $uuid)->first();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
