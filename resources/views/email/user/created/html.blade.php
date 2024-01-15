<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Legnicka 55b/5 - {{ __('A new user has been registered') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 50px 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table.billling tr td {
            text-align: right;
        }

        table.billling tr td.highlight {
            background-color: #f2f2f2;
            text-align: left;
        }

        th, td {
            padding: 8px;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }

        th.name,
        td.name {
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .highlight {
            font-weight: bold;
        }

        tr.canceled td {
            text-decoration: line-through;
        }

        @media screen and (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            table.expense thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            table.expense tr {
                margin: 0 0 1rem 0;
                padding: 0 0 1rem 0;
                border-bottom: 2px solid #000;
            }

            table.expense tr:last-child {
                border-bottom: 0;
            }

            table.expense td {
                border: none;
                border-bottom: 0;
                position: relative;
                padding: 0 0 0 50%;
            }

            table.expense td.name {
                text-align: right;
            }

            table.expense td:before {
                position: absolute;
                top: 0;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
            }

            table.expense td:nth-of-type(1):before {
                content: "Wydatek";
            }

            table.expense td:nth-of-type(2):before {
                content: "Kwota";
            }

            table.expense td:nth-of-type(3):before {
                content: "Data";
            }

            table.expense td:nth-of-type(4):before {
                content: "Osoba";
            }
        }
    </style>
</head>
<body>
    <h2>Legnicka 55b/5 - {{ __('A new user has been registered') }}</h2>

    <p><strong>{{ ucfirst(__('firstname')) }}: </strong> {{ $user->firstname }}</p>
    <p><strong>{{ ucfirst(__('lastname')) }}: </strong> {{ $user->lastname }}</p>
    <p><strong>E-mail: </strong> {{ $user->email }}</p>
</body>
</html>

