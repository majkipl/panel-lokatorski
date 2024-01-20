<?php

namespace App\Domains\Billing\Domain\Models;

use App\Domains\User\Domain\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Billing extends Model
{
    /**
     * @var string
     */
    protected $table = 'billings';

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
}
