<?php

namespace App\Domains\User\Domain\Models;

use App\Domains\Balance\Domain\Models\Balance;
use App\Domains\Billing\Domain\Models\Billing;
use App\Domains\Expense\Domain\Events\ExpenseAdded;
use App\Domains\Expense\Domain\Events\ExpenseCanceled;
use App\Domains\Expense\Domain\Models\Expense;
use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\Payment\Domain\Models\Payment;
use App\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus\FindAccountsUuidByUserRoleAndStatusQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Domains\User\Domain\Events\AccountDeleted;
use App\Interfaces\Query\QueryBus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;
use Spatie\EventSourcing\Projections\Projection;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class Account extends Projection
{
    use HasFactory;

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
        $attributes['uuid'] = $attributes['uuid'] ?? (string) Uuid::uuid4();
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
     * @param string $name
     * @param float $amount
     * @return void
     */
    public function addExpense(string $name, float $amount): void
    {
        $participants = $this->queryBus->ask(
            query: new FindAccountsUuidByUserRoleAndStatusQuery(
                status: UserStatus::ACTIVE->value,
                role: [UserRole::ADMIN->value, UserRole::USER->value]
            )
        );

        event(
            new ExpenseAdded(
                accountUuid: $this->uuid,
                name: $name,
                amount: $amount,
                participants: $participants
            )
        );
    }

    /**
     * @param int $eventId
     * @return void
     */
    public function cancelExpense(int $eventId): void
    {
        $eventCanceled = EloquentStoredEvent::find($eventId)->toStoredEvent();

        event(
            new ExpenseCanceled(
                accountUuid: $this->uuid,
                name: '[CANCELED] ' . $eventCanceled->event->name,
                amount: $eventCanceled->event->amount,
                eventId: $eventId,
                participants: $eventCanceled->event->participants
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

    /**
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @return HasMany
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * @return HasMany
     */
    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    /**
     * @return HasMany
     */
    public function balances(): HasMany
    {
        return $this->hasMany(Balance::class);
    }
}
