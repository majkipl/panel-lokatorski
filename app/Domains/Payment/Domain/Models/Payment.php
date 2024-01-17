<?php

namespace App\Domains\Payment\Domain\Models;

use App\Domains\User\Domain\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /**
     * @var string
     */
    protected $table = 'payments';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_uuid', 'uuid');
    }

    /**
     * @return array|string[]
     */
    public function getGuarded(): array
    {
        return $this->guarded;
    }
}
