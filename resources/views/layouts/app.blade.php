<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sudoku</title>

    @livewireStyles
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            margin: 0;
            padding: 0;
        }

        .sudoku {
            margin: 50px auto;
            height: 450px;
            width: 450px;
            border: 2px solid black;
            box-sizing: border-box;
            border-collapse: collapse;
        }


        .sudoku td {
            width: 30px;
            height: 30px;
            text-align: center;
            border: 1px solid black;
        }

        /* Add thicker borders around each 3x3 subgrid */
        .sudoku td:nth-child(3n+1):not(:first-child) {
            border-left: 3px solid black;
        }

        .sudoku td:nth-child(3n+3) {
            border-right: 3px solid black;
        }

        .sudoku tr:nth-child(3n+1):not(:first-child) td {
            border-top: 3px solid black;
        }

        .sudoku tr:nth-child(3n+3) td {
            border-bottom: 3px solid black;
        }

        .sudoku input {
            width: 100%;
            height: 100%;
            border: none;
            box-sizing: border-box;
            font-size: 20px;
            text-align: center;
            background-color: #ffffff;
        }

        .success-message {
            display: flex;
            justify-content: center;
            color: rgb(84, 164, 5);
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .options {
            display: flex;
            justify-content: space-between;
            margin: auto;
            width: 200px;
        }

        .sudoku .error {
            background-color: #ff7979;
        }

    </style>
</head>

<body>
    {{ $slot }}
    @livewireScripts
</body>

</html>
