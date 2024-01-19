<?php

namespace Database\Seeders;

use App\Domains\Expense\Domain\Events\ExpenseAdded;
use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\User\Application\Queries\FindAccountUuidByUserId\FindAccountUuidByUserIdQuery;
use App\Interfaces\Query\QueryBus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(QueryBus $queryBus): void
    {
        $uuid_1 = $queryBus->ask(
            query: new FindAccountUuidByUserIdQuery(
                id: 1
            )
        );
        $uuid_2 = $queryBus->ask(
            query: new FindAccountUuidByUserIdQuery(
                id: 2
            )
        );
        $uuid_3 = $queryBus->ask(
            query: new FindAccountUuidByUserIdQuery(
                id: 3
            )
        );
        $uuid_4 = $queryBus->ask(
            query: new FindAccountUuidByUserIdQuery(
                id: 4
            )
        );
        $uuid_5 = $queryBus->ask(
            query: new FindAccountUuidByUserIdQuery(
                id: 5
            )
        );
        $uuid_6 = $queryBus->ask(
            query: new FindAccountUuidByUserIdQuery(
                id: 6
            )
        );

        $this->addedExpense(
            name: "INTERNET - GRUDZIEŃ 2019",
            amount: 54,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_2, $uuid_1],
            createdAt: "2020-01-20 18:51:57"
        );

        $this->addedExpense(
            name: "INTERNET - STYCZEŃ 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_2, $uuid_1],
            createdAt: "2020-01-20 18:52:35"
        );

        $this->addedExpense(
            name: "ŚWIETLÓWKI",
            amount: 74,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_2, $uuid_1],
            createdAt: "2020-01-20 18:53:02"
        );

        $this->addedPayment(
            amount: 93.50,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2020-02-03 13:40:01'
        );

        $this->addedPayment(
            amount: 93.50,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2020-02-03 13:45:09'
        );

        $this->addedExpense(
            name: "INTERNET - LUTY 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1, $uuid_4],
            createdAt: "2020-02-06 21:28:29"
        );

        $this->addedExpense(
            name: "ZAWIESZKA WC",
            amount: 10,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1, $uuid_4],
            createdAt: "2020-02-08 15:43:12"
        );

        $this->addedExpense(
            name: "PŁYN UNIWERSALNY AJAX",
            amount: 8,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1, $uuid_4],
            createdAt: "2020-02-08 15:43:49"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 6.5,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1, $uuid_4],
            createdAt: "2020-02-14 17:26:08"
        );

        $this->addedExpense(
            name: "PLYN DO NACZYN FAIRY",
            amount: 4,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1, $uuid_4],
            createdAt: "2020-02-14 17:26:35"
        );

        $this->addedExpense(
            name: "PLYN DO MYCIA OKIEN",
            amount: 6.5,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1, $uuid_4],
            createdAt: "2020-02-14 17:27:00"
        );

        $this->addedPayment(
            amount: 23.50,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2020-03-02 13:50:46'
        );

        $this->addedExpense(
            name: "INTERNET - MARZEC 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-03-02 13:52:51"
        );

        $this->addedExpense(
            name: "PŁYN DO PODŁÓG FELCE AZZURRA",
            amount: 8.5,
            accountUuid: $uuid_4,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-03-02 13:59:23"
        );

        $this->addedPayment(
            amount: 30.00,
            accountUuid: $uuid_4,
            eventClass: MoneyAdded::class,
            createdAt: '2020-03-03 13:36:18',
        );

        $this->addedExpense(
            name: "ZMYWAKI KUCHENNE",
            amount: 2,
            accountUuid: $uuid_4,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-03-04 12:46:07"
        );

        $this->addedPayment(
            amount: 53.50,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2020-03-08 00:06:54'
        );

        $this->addedPayment(
            amount: 25.00,
            accountUuid: $uuid_3,
            eventClass: MoneyAdded::class,
            createdAt: '2020-04-02 17:04:05'
        );

        $this->addedExpense(
            name: "INTERNET - KWIECIEŃ 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-04-02 17:04:40"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 8,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-04-02 17:05:28"
        );

        $this->addedExpense(
            name: "ZAWIESZKA WC",
            amount: 10,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-04-02 17:05:48"
        );

        $this->addedExpense(
            name: "SPRAY DO KABIN",
            amount: 6,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-04-02 17:10:37"
        );

        $this->addedPayment(
            amount: 41.63,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2020-04-02 17:12:00',
        );

        $this->addedPayment(
            amount: 20.00,
            accountUuid: $uuid_4,
            eventClass: MoneyAdded::class,
            createdAt: '2020-04-08 12:53:03',
        );

        $this->addedExpense(
            name: "PLYN DO NACZYN FAIRY",
            amount: 5,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-04-14 08:40:04"
        );

        $this->addedExpense(
            name: "ŚCIERKI",
            amount: 10,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-04-22 11:23:23"
        );

        $this->addedPayment(
            amount: 31.88,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2020-04-22 15:08:39',
        );

        $this->addedExpense(
            name: "INTERNET - MAJ 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-05-09 10:26:33"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 16,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-05-11 16:06:38"
        );

        $this->addedExpense(
            name: "ZAWIESZKA DO WC",
            amount: 8,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-05-11 16:08:18"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI X 2",
            amount: 6,
            accountUuid: $uuid_4,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-05-16 11:23:32"
        );

        $this->addedExpense(
            name: "PLYN DO MYCIA PIEKARNIKA",
            amount: 7,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-05-31 12:56:21"
        );

        $this->addedExpense(
            name: "INTERNET - CZERWIEC 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-06-02 08:14:34"
        );

        $this->addedExpense(
            name: "PŁYN DO NACZYŃ",
            amount: 7,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-06-02 08:14:46"
        );

        $this->addedPayment(
            amount: 98.50,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2020-06-02 08:19:38',
        );

        $this->addedPayment(
            amount: 40.00,
            accountUuid: $uuid_4,
            eventClass: MoneyAdded::class,
            createdAt: '2020-06-08 13:02:28',
        );

        $this->addedPayment(
            amount: 50.00,
            accountUuid: $uuid_3,
            eventClass: MoneyAdded::class,
            createdAt: '2020-06-12 13:51:06',
        );

        $this->addedExpense(
            name: "MYDŁO W PŁYNIE 2 SZT",
            amount: 7,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-06-14 15:34:21"
        );

        $this->addedExpense(
            name: "INTERNET - LIPIEC 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-07-07 09:02:41"
        );

        $this->addedExpense(
            name: "ZAWIESZKI DO KIBLA 4 SZT",
            amount: 20,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-07-08 16:11:55"
        );

        $this->addedExpense(
            name: "SPRAY DO KABIN",
            amount: 6,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-07-31 00:45:20"
        );

        $this->addedPayment(
            amount: 12.50,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2020-08-03 15:17:50',
        );

        $this->addedExpense(
            name: "INTERNET - SIERPIEŃ 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-08-03 15:19:17"
        );

        $this->addedExpense(
            name: "RĘCZNIKI KUCHENNE",
            amount: 10,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-08-22 13:34:56"
        );

        $this->addedExpense(
            name: "WORKI-2SZT",
            amount: 8,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-08-22 13:35:21"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 8,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_4, $uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-08-25 23:54:20"
        );

        $this->addedExpense(
            name: "INTERNET - WRZESIEŃ 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-09-02 11:14:57"
        );

        $this->addedPayment(
            amount: 40.00,
            accountUuid: $uuid_3,
            eventClass: MoneyAdded::class,
            createdAt: '2020-09-11 11:05:24',
        );

        $this->addedPayment(
            amount: 40.00,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2020-09-11 11:09:19',
        );

        $this->addedPayment(
            amount: 12.50,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2020-09-11 11:09:39',
        );

        $this->addedExpense(
            name: "PŁYN DO NACZYŃ",
            amount: 4.99,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-09-20 23:23:50"
        );

        $this->addedExpense(
            name: "PŁYN DO PODŁÓG AJAX",
            amount: 7.99,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-09-20 23:24:48"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 12.89,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-09-20 23:26:19"
        );

        $this->addedExpense(
            name: "SPRAY DO KABIN",
            amount: 6,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-10-07 22:26:23"
        );

        $this->addedExpense(
            name: "INTERNET - PAŹDZIERNIK 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-10-07 22:27:02"
        );

        $this->addedPayment(
            amount: 31.54,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2020-10-07 22:27:58',
        );

        $this->addedExpense(
            name: "WORKI-2SZT",
            amount: 8,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-10-26 21:43:40"
        );

        $this->addedExpense(
            name: "MYDŁO W PŁYNIE",
            amount: 5,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-10-26 21:43:58"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 12.89,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-10-28 21:12:55"
        );

        $this->addedExpense(
            name: "ZAWIESZKA WC",
            amount: 6.99,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-10-28 21:15:17"
        );

        $this->addedPayment(
            amount: 31.54,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2020-10-28 21:16:39',
        );

        $this->addedPayment(
            amount: 19.62,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2020-11-02 18:13:50',
        );

        $this->addedExpense(
            name: "INTERNET - LISTOPAD 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-11-02 18:14:29"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 8.74,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-11-16 13:06:57"
        );

        $this->addedExpense(
            name: "ZAWIESZKI DO WC",
            amount: 8,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-11-25 12:58:45"
        );

        $this->addedPayment(
            amount: 17.25,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2020-12-01 14:51:14',
        );

        $this->addedExpense(
            name: "INTERNET - GRUDZIEŃ 2020",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-12-01 14:52:28"
        );

        $this->addedPayment(
            amount: 17.25,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2020-12-01 14:54:27',
        );

        $this->addedExpense(
            name: "PAPIER 16R",
            amount: 15,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-12-02 21:46:52"
        );

        $this->addedExpense(
            name: "WORKI-2SZT",
            amount: 8,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2020-12-02 21:47:05"
        );

        $this->addedExpense(
            name: "INTERNET - STYCZEŃ 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-01-07 03:28:03"
        );

        $this->addedExpense(
            name: "PLYN DO MYCIA OKIEN",
            amount: 4,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-01-14 23:43:19"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 9,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-01-28 00:21:35"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 7,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-01-31 17:34:47"
        );

        $this->addedExpense(
            name: "GĄBKI DO ZMYWANIA",
            amount: 4,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-01-31 17:35:10"
        );

        $this->addedExpense(
            name: "ŚCIERKI",
            amount: 4,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-01-31 17:35:22"
        );

        $this->addedExpense(
            name: "PŁYN DO KABIN",
            amount: 6,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-01-31 17:35:37"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI",
            amount: 5,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-01-31 17:35:58"
        );

        $this->addedExpense(
            name: "INTERNET - LUTY 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-02-05 09:31:31"
        );

        $this->addedPayment(
            amount: 56.67,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2021-02-08 11:47:12',
        );

        $this->addedExpense(
            name: "ZAWIESZKI DO WC",
            amount: 13,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-02-16 00:11:10"
        );

        $this->addedExpense(
            name: "INTERNET - MARZEC 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-03-01 14:14:45"
        );

        $this->addedExpense(
            name: "PŁYN DO NACZYŃ",
            amount: 7,
            accountUuid: $uuid_3,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-03-01 14:25:29"
        );

        $this->addedPayment(
            amount: 150.00,
            accountUuid: $uuid_3,
            eventClass: MoneyAdded::class,
            createdAt: '2021-03-03 12:10:38',
        );

        $this->addedExpense(
            name: "MYDŁO W PŁYNIE",
            amount: 3,
            accountUuid: $uuid_2,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-03-04 10:43:04"
        );

        $this->addedPayment(
            amount: 11.33,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2021-03-04 15:11:24',
        );

        $this->addedPayment(
            amount: 11.33,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2021-03-04 15:11:48',
        );

        $this->addedPayment(
            amount: 150.00,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2021-03-04 15:12:01',
        );

        $this->addedPayment(
            amount: 159.95,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2021-03-04 15:13:25',
        );

        $this->addedExpense(
            name: "ZAWIESZKA WC DOMESTOS",
            amount: 8,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-03-20 11:03:45"
        );

        $this->addedExpense(
            name: "SPRAY DO CZYSZCZENIA ŁAZIENKI",
            amount: 5,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-03-20 11:05:24"
        );

        $this->addedExpense(
            name: "SPRAY DO CZYSZCZENIA KUCHNI",
            amount: 5,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-03-20 11:05:40"
        );

        $this->addedExpense(
            name: "SPRAY DO CZYSZCZENIA KABINY PRYSZNICOWEJ",
            amount: 5,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-03-20 11:06:14"
        );

        $this->addedExpense(
            name: "INTERNET - KWIECIEŃ 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-04-14 21:31:58"
        );

        $this->addedExpense(
            name: "PŁYN FAIRY",
            amount: 5.49,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-04-26 23:26:00"
        );

        $this->addedPayment(
            amount: 29.16,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2021-04-29 19:17:11',
        );

        $this->addedPayment(
            amount: 29.16,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2021-04-29 19:17:27',
        );

        $this->addedExpense(
            name: "ZMYWAKI",
            amount: 1.99,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-05-01 19:57:37"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI",
            amount: 3.49,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-05-01 19:57:59"
        );

        $this->addedExpense(
            name: "INTERNET - MAJ 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_2, $uuid_1],
            createdAt: "2021-05-01 19:58:23"
        );

        $this->addedExpense(
            name: "INTERNET - CZERWIEC 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_3, $uuid_1],
            createdAt: "2021-06-07 14:03:31"
        );

        $this->addedExpense(
            name: "INTERNET - LIPIEC 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1],
            createdAt: "2021-07-01 21:09:27"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI",
            amount: 3.5,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1],
            createdAt: "2021-07-07 17:16:16"
        );

        $this->addedPayment(
            amount: 62.50,
            accountUuid: $uuid_6,
            eventClass: MoneyAdded::class,
            createdAt: '2021-07-12 12:32:27',
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 9,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1],
            createdAt: "2021-07-20 23:18:52"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 12,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1],
            createdAt: "2021-07-20 23:19:07"
        );

        $this->addedPayment(
            amount: 62.50,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2021-07-22 06:48:18',
        );

        $this->addedExpense(
            name: "INTERNET - SIERPIEŃ 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1],
            createdAt: "2021-08-04 13:18:42"
        );

        $this->addedExpense(
            name: "INTERNET -  WRZESIEŃ 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1],
            createdAt: "2021-09-03 11:46:39"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 9.99,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1],
            createdAt: "2021-09-04 20:14:51"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI",
            amount: 3.49,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1],
            createdAt: "2021-09-04 20:15:27"
        );

        $this->addedExpense(
            name: "ZAWIESZKA WC",
            amount: 8.98,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1],
            createdAt: "2021-09-04 20:16:20"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 9.99,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1],
            createdAt: "2021-09-12 12:08:48"
        );

        $this->addedPayment(
            amount: 28.48,
            accountUuid: $uuid_6,
            eventClass: MoneyAdded::class,
            createdAt: '2021-09-13 11:27:37',
        );

        $this->addedPayment(
            amount: 28.48,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2021-09-13 11:27:53',
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 20,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1, $uuid_5],
            createdAt: "2021-10-01 21:10:07"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 9.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1, $uuid_5],
            createdAt: "2021-10-01 21:10:50"
        );

        $this->addedExpense(
            name: "MYDŁO",
            amount: 2.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_1, $uuid_5],
            createdAt: "2021-10-01 21:11:18"
        );

        $this->addedExpense(
            name: "INTERNET - PAŹDZIERNIK 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-10-01 16:31:23"
        );

        $this->addedExpense(
            name: "ŚCIERECZKI",
            amount: 4,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-10-13 22:54:11"
        );

        $this->addedExpense(
            name: "CIF",
            amount: 9,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-10-13 22:54:23"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI",
            amount: 6.98,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-10-24 13:32:30"
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 11.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-10-29 22:29:51"
        );

        $this->addedExpense(
            name: "INTERNET - LISTOPAD 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-11-03 00:39:52"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 12.99,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-11-04 07:01:43"
        );

        $this->addedExpense(
            name: "SPRAY DO CZYSZCZENIA KABINY PRYSZNICOWEJ",
            amount: 5.29,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-11-08 16:47:26"
        );

        $this->addedExpense(
            name: "SPRAY DO CZYSZCZENIA KUCHNI",
            amount: 5.29,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-11-08 16:47:49"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 20,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-11-13 18:52:38"
        );

        $this->addedExpense(
            name: "INTERNET - GRUDZIEŃ 2021",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-12-08 04:25:51"
        );

        $this->addedPayment(
            amount: 22.20,
            accountUuid: $uuid_6,
            eventClass: MoneyAdded::class,
            createdAt: '2021-12-13 12:45:25',
        );

        $this->addedExpense(
            name: "ZAWIESZKA WC DOMESTOS",
            amount: 13,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-12-17 23:13:15"
        );

        $this->addedPayment(
            amount: 22.20,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2021-12-17 23:14:06',
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 4,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-12-31 06:31:29"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 19,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2021-12-31 06:31:45"
        );

        $this->addedExpense(
            name: "PŁYN DO NACZYŃ",
            amount: 5,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-01-03 21:49:41"
        );

        $this->addedExpense(
            name: "INTERNET - STYCZEŃ 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-01-07 17:09:46"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI",
            amount: 6.6,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-01-09 14:13:39"
        );

        $this->addedExpense(
            name: "INTERNET - LUTY 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-02-06 11:03:53"
        );

        $this->addedExpense(
            name: "PŁYN DO SZYB",
            amount: 4,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-02-06 11:04:05"
        );

        $this->addedPayment(
            amount: 21.54,
            accountUuid: $uuid_2,
            eventClass: MoneyAdded::class,
            createdAt: '2022-02-06 11:05:45',
        );

        $this->addedPayment(
            amount: 21.50,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2022-02-06 11:06:12',
        );

        $this->addedPayment(
            amount: 43.64,
            accountUuid: $uuid_4,
            eventClass: MoneyAdded::class,
            createdAt: '2022-02-06 11:07:29',
        );

        $this->addedPayment(
            amount: 43.63,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2022-02-06 11:07:41',
        );

        $this->addedPayment(
            amount: 93.49,
            accountUuid: $uuid_3,
            eventClass: MoneyAdded::class,
            createdAt: '2022-02-06 11:08:21',
        );

        $this->addedPayment(
            amount: 93.45,
            accountUuid: $uuid_1,
            eventClass: MoneyAdded::class,
            createdAt: '2022-02-06 11:08:41',
        );

        $this->addedExpense(
            name: "SPRAY DO CZYSZCZENIA KABINY PRYSZNICOWEJ",
            amount: 5,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-02-17 23:49:40"
        );

        $this->addedExpense(
            name: "INTERNET - MARZEC 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-03-04 16:22:39"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 20,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-03-04 23:01:09"
        );

        $this->addedPayment(
            amount: 36.53,
            accountUuid: $uuid_6,
            eventClass: MoneyAdded::class,
            createdAt: '2022-03-12 17:43:16',
        );

        $this->addedPayment(
            amount: 36.53,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2022-03-12 17:43:36',
        );

        $this->addedExpense(
            name: "PAPIER DO PIECZENIA",
            amount: 7,
            accountUuid: $uuid_5,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-03-22 14:44:48"
        );

        $this->addedExpense(
            name: "GĄBKI",
            amount: 2,
            accountUuid: $uuid_5,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-03-22 14:46:05"
        );

        $this->addedExpense(
            name: "ŚCIERKA Z MIKROFIBRY",
            amount: 3,
            accountUuid: $uuid_5,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-03-22 14:46:20"
        );

        $this->addedExpense(
            name: "RĘCZNIK PAPIEROWY 120M",
            amount: 10,
            accountUuid: $uuid_5,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-03-22 14:48:05"
        );

        $this->addedPayment(
            amount: 100.00,
            accountUuid: $uuid_5,
            eventClass: MoneyAdded::class,
            createdAt: '2022-03-22 16:06:45',
        );

        $this->addedPayment(
            amount: 100.00,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2022-03-22 16:06:55',
        );

        $this->addedExpense(
            name: "INTERNET - KWIECIEŃ 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-04-06 18:25:32"
        );

        $this->addedExpense(
            name: "ŚWIETLÓWKA",
            amount: 17,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-04-13 22:33:59"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 18.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-04-14 14:39:57"
        );

        $this->addedExpense(
            name: "RĘCZNIK PAPIEROWY",
            amount: 9.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-04-14 14:40:09"
        );

        $this->addedPayment(
            amount: 13.35,
            accountUuid: $uuid_6,
            eventClass: MoneyAdded::class,
            createdAt: '2022-04-15 12:01:07',
        );

        $this->addedPayment(
            amount: 13.35,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2022-04-15 12:01:19',
        );

        $this->addedExpense(
            name: "INTERNET - MAJ 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-05-06 16:27:40"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 29.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-05-18 12:42:02"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI (TE CZERWONE)",
            amount: 9.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-05-18 12:42:27"
        );

        $this->addedExpense(
            name: "INTERNET - CZERWIEC 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-06-02 01:35:17"
        );

        $this->addedExpense(
            name: "MOPY",
            amount: 30,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-06-08 23:19:21"
        );

        $this->addedExpense(
            name: "MYDŁO W PŁYNIE",
            amount: 6.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-06-23 22:47:30"
        );

        $this->addedExpense(
            name: "KOSTKI DO TOALETY",
            amount: 9.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-06-23 22:47:51"
        );

        $this->addedExpense(
            name: "ODKAMIENIACZ",
            amount: 12.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-06-23 22:48:09"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI",
            amount: 5.18,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-06-28 06:42:17"
        );

        $this->addedExpense(
            name: "INTERNET - LIPIEC 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-07-05 01:01:02"
        );

        $this->addedExpense(
            name: "SPRAY DO CZYSZCZENIA KABINY PRYSZNICOWEJ",
            amount: 5.99,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-07-14 23:21:45"
        );

        $this->addedExpense(
            name: "SPRAY DO CZYSZCZENIA KUCHNI",
            amount: 5.99,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-07-15 18:46:25"
        );

        $this->addedExpense(
            name: "PŁYŃ DO PODŁOGI",
            amount: 5.99,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-07-15 18:46:45"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 25.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-07-25 22:51:20"
        );

        $this->addedExpense(
            name: "PŁYN DO NACZYŃ",
            amount: 9.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-07-25 22:51:37"
        );

        $this->addedExpense(
            name: "ODŚWIEŻACZ POWIETRZA",
            amount: 12.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-07-25 22:51:59"
        );

        $this->addedExpense(
            name: "DRUCIAKI",
            amount: 3.99,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-07-25 22:52:16"
        );

        $this->addedExpense(
            name: "INTERNET - SIERPIEŃ 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-08-09 00:12:01"
        );

        $this->addedExpense(
            name: "INTERNET - WRZESIEŃ 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-09-02 00:26:48"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 12,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-09-30 18:34:04"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI 120 L (DWIE PACZKI)",
            amount: 16,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-10-01 14:34:03"
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 18,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-10-01 23:04:50"
        );

        $this->addedExpense(
            name: "INTERNET - PAŹDZIERNIK 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-10-19 19:20:47"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 16.7,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-10-22 18:00:24"
        );

        $this->addedExpense(
            name: "INTERNET - LISTOPAD 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-11-05 14:27:07"
        );

        $this->addedExpense(
            name: "SZCZOTKA TOALETOWA",
            amount: 4,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-11-16 16:32:05"
        );

        $this->addedExpense(
            name: "GĄBKI DO SZOROWANIA",
            amount: 4,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-11-16 16:32:27"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI 120 L (DWIE PACZKI)",
            amount: 16,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-11-16 16:32:49"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 30,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-11-16 16:33:06"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 12,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-11-16 16:33:38"
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 15,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-12-01 23:31:42"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 20,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-12-01 23:31:48"
        );

        $this->addedExpense(
            name: "INTERNET - GRUDZIEŃ 2022",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2022-12-30 23:02:34"
        );

        $this->addedExpense(
            name: "INTERNET - STYCZEŃ 2023",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-01-01 22:35:44"
        );

        $this->addedExpense(
            name: "PŁYN DO PODŁÓG - PINK STUFF",
            amount: 20,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-01-03 18:31:30"
        );

        $this->addedPayment(
            amount: 250.00,
            accountUuid: $uuid_5,
            eventClass: MoneyAdded::class,
            createdAt: '2023-01-10 16:40:38',
        );

        $this->addedPayment(
            amount: 250.00,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2023-01-10 16:40:52',
        );

        $this->addedPayment(
            amount: 50.00,
            accountUuid: $uuid_5,
            eventClass: MoneyAdded::class,
            createdAt: '2023-01-11 20:28:11',
        );

        $this->addedPayment(
            amount: 50.00,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2023-01-11 20:28:22',
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 20,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-01-18 20:05:40"
        );

        $this->addedExpense(
            name: "KOSZ NA ŚMIECI DO ŁAZIENKI",
            amount: 20,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-01-18 20:05:56"
        );

        $this->addedExpense(
            name: "INTERNET - LUTY 2023",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-02-08 23:57:24"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI",
            amount: 4,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-02-17 17:29:19"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 10,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-03-01 23:08:29"
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 10,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-03-01 23:08:40"
        );

        $this->addedExpense(
            name: "KRET",
            amount: 13,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-03-08 20:59:26"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI",
            amount: 13,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-03-08 21:00:11"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 47,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-03-08 21:00:18"
        );

        $this->addedExpense(
            name: "INTERNET - MARZEC 2023",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-03-16 17:35:24"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY (BO PAPIERU NIGDY DOŚĆ, A BYŁA PROMOCJA)",
            amount: 30,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-03-24 10:03:26"
        );

        $this->addedExpense(
            name: "WORKI DO ODKURZACZA",
            amount: 36,
            accountUuid: $uuid_5,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-04-10 17:45:36"
        );

        $this->addedPayment(
            amount: 170.00,
            accountUuid: $uuid_5,
            eventClass: MoneyAdded::class,
            createdAt: '2023-04-10 17:58:53',
        );

        $this->addedExpense(
            name: "INTERNET - KWIECIEŃ 2023",
            amount: 59,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-04-10 18:00:22"
        );

        $this->addedExpense(
            name: "INTERNET - MAJ 2023",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-05-15 17:55:53"
        );

        $this->addedExpense(
            name: "PŁYN DO NACZYŃ",
            amount: 10,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-05-25 15:47:54"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 40,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-06-16 21:14:36"
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 14,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-06-16 21:14:50"
        );

        $this->addedExpense(
            name: "INTERNET - CZERWIEC 2023",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-06-23 12:57:21"
        );

        $this->addedExpense(
            name: "INTERNET - LIPIEC 2023",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-07-20 19:53:57"
        );

        $this->addedExpense(
            name: "INTERNET - SIERPIEŃ 2023",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-08-07 10:30:25"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI 120 L (DWIE PACZKI)",
            amount: 16,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-08-17 21:19:53"
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 30,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-08-17 21:20:01"
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 15,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-09-11 18:09:38"
        );

        $this->addedExpense(
            name: "PŁYN DO NACZYŃ",
            amount: 10,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-09-11 18:33:31"
        );

        $this->addedExpense(
            name: "GĄBKI DO SZOROWANIA",
            amount: 9,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-09-11 19:16:26"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 18,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-09-11 19:16:48"
        );

        $this->addedExpense(
            name: "WIADRO DO MOPA",
            amount: 25,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-09-11 19:17:40"
        );

        $this->addedExpense(
            name: "MOP",
            amount: 17,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-09-11 19:17:52"
        );

        $this->addedExpense(
            name: "SZMATA DO MOPA",
            amount: 10,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-09-11 19:18:04"
        );

        $this->addedExpense(
            name: "WIDELCE",
            amount: 12,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-09-11 21:56:51"
        );

        $this->addedExpense(
            name: "ŁYŻKI",
            amount: 6,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-09-11 21:56:57"
        );

        $this->addedExpense(
            name: "INTERNET - WRZESIEŃ 2023",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-09-11 23:28:11"
        );

        $this->addedPayment(
            amount: 205.00,
            accountUuid: $uuid_5,
            eventClass: MoneyAdded::class,
            createdAt: '2023-09-12 18:32:29',
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 28,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-10-08 19:05:24"
        );

        $this->addedExpense(
            name: "ZMIOTKA I SZUFELKA",
            amount: 12,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-10-25 22:51:55"
        );

        $this->addedExpense(
            name: "SZCZOTA DO MIOTŁY",
            amount: 14,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-10-25 22:52:30"
        );

        $this->addedExpense(
            name: "INTERNET - PAŹDZIERNIK 2023",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-11-02 13:39:58"
        );

        $this->addedExpense(
            name: "INTERNET - LISTOPAD 2023",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-11-02 13:40:09"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI 60 L (DWIE PACZKI)",
            amount: 6,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-11-20 12:26:08"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 13,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-11-20 14:33:45"
        );

        $this->addedExpense(
            name: "INTERNET - GRUDZIEŃ 2023",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-12-07 23:06:23"
        );

        $this->addedExpense(
            name: "GĄBKI",
            amount: 6.49,
            accountUuid: $uuid_5,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-12-30 11:04:42"
        );

        $this->addedExpense(
            name: "ŚCIERKI",
            amount: 3.99,
            accountUuid: $uuid_5,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-12-30 11:05:14"
        );

        $this->addedExpense(
            name: "RĘCZNIK PAPIEROWY",
            amount: 5.49,
            accountUuid: $uuid_5,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2023-12-30 11:05:51"
        );

        $this->addedExpense(
            name: "INTERNET - STYCZEŃ 2024",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-01-08 16:09:34"
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 30,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-01-16 21:54:50"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 14,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-01-17 11:35:52"
        );

        $this->addedExpense(
            name: "ZAWIESZKA WC X5",
            amount: 20,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-01-20 14:18:53"
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 8,
            accountUuid: $uuid_5,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-02-09 14:55:41"
        );

        $this->addedPayment(
            amount: 120.00,
            accountUuid: $uuid_5,
            eventClass: MoneyAdded::class,
            createdAt: '2024-02-09 16:49:59',
        );

        $this->addedExpense(
            name: "INTERNET - LUTY 2024",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-02-09 16:50:35"
        );

        $this->addedExpense(
            name: "WORKI NA ŚMIECI 60 L",
            amount: 8,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-02-17 14:00:09"
        );

        $this->addedPayment(
            amount: 120.00,
            accountUuid: $uuid_1,
            eventClass: MoneySubtracted::class,
            createdAt: '2024-02-17 14:00:53',
        );

        $this->addedExpense(
            name: "PAPIER TOALETOWY",
            amount: 45,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-02-20 16:52:15"
        );

        $this->addedExpense(
            name: "KOSTKI DO TOALETY",
            amount: 15,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-02-20 16:52:32"
        );

        $this->addedExpense(
            name: "PŁYN DO NACZYŃ",
            amount: 10,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-02-20 16:52:57"
        );

        $this->addedExpense(
            name: "GŁOWA OD MOPA",
            amount: 18.99,
            accountUuid: $uuid_5,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-03-02 18:43:47"
        );

        $this->addedExpense(
            name: "DOMESTOS",
            amount: 14,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-03-09 12:05:55"
        );

        $this->addedExpense(
            name: "INTERNET - MARZEC 2024",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-03-09 12:06:14"
        );

        $this->addedExpense(
            name: "PŁYN DO NACZYŃ",
            amount: 10,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-03-28 15:57:29"
        );

        $this->addedExpense(
            name: "RĘCZNIKI PAPIEROWE",
            amount: 15,
            accountUuid: $uuid_6,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-03-28 16:00:07"
        );

        $this->addedExpense(
            name: "INTERNET - KWIECIEŃ 2024",
            amount: 65.55,
            accountUuid: $uuid_1,
            eventClass: ExpenseAdded::class,
            participants: [$uuid_6, $uuid_5, $uuid_1],
            createdAt: "2024-04-10 09:53:14"
        );

    }

    public function addedExpense(string $name, float $amount, string $accountUuid, string $eventClass, array $participants, string $createdAt)
    {
        $storedEventId = DB::table('stored_events')->max('id') + 1;

        $eventProperties = json_encode([
            'name' => $name,
            'amount' => $amount,
            'accountUuid' => $accountUuid,
            'participants' => $participants,
        ]);

        $eventMetaData = json_encode([
            'created-at' => $createdAt,
            'stored-event-id' => $storedEventId
        ]);

        DB::table('stored_events')->insert([
            [
                'aggregate_uuid' => null,
                'aggregate_version' => null,
                'event_version' => 1,
                'event_class' => $eventClass,
                'event_properties' => $eventProperties,
                'meta_data' => $eventMetaData,
                'created_at' => $createdAt,
            ],
        ]);
    }

    /**
     * @param float $amount
     * @param string $accountUuid
     * @param string $eventClass
     * @param string $createdAt
     * @return void
     */
    public function addedPayment(float $amount, string $accountUuid, string $eventClass, string $createdAt): void
    {
        $date = Carbon::parse($createdAt);
        $storedEventId = DB::table('stored_events')->max('id') + 1;
        $eventProperties = '{"amount": ' . $amount . ', "accountUuid": "' . $accountUuid . '"}';
        $eventMetaData = '{"created-at": "' . $date . '", "stored-event-id": ' . $storedEventId . '}';

        DB::table('stored_events')->insert([
            [
                'aggregate_uuid' => null,
                'aggregate_version' => null,
                'event_version' => 1,
                'event_class' => $eventClass,
                'event_properties' => $eventProperties,
                'meta_data' => $eventMetaData,
                'created_at' => $date,
            ],
        ]);
    }
}
