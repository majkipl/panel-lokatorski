<?php

namespace App\Domains\User\Domain\Models;

use App\Domains\User\Domain\Events\AccountCreated;
use App\Domains\User\Domain\Events\AccountDeleted;
use App\Interfaces\Query\QueryBus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;
use Spatie\EventSourcing\Projections\Projection;

class Account extends Projection
{
    protected $table = 'accounts';

    protected $guarded = [];

    protected QueryBus $queryBus;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->queryBus = app(QueryBus::class);
    }

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

    public function remove()
    {
        event(new AccountDeleted($this->uuid));
    }

    /*
     * A helper method to quickly retrieve an account by uuid.
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
