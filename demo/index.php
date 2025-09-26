<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body{
            display:grid;
            place-items:center;
            height: 100vh;
            margin:0;
            font-family: sans-serif;
        }
    </style>
</head>
<body>
    <?php $llibres = [
            "Memorias del subsuelo de Fyódor Dostoevsky",
            "El extranjero de Albert Camus",
            "Metamorfosis de Franz Kafka",
            "Crimen y castigo de Fyódor Dostoevsky",
            "La peste de Albert Camus"
    ]?>

    <ul>
     <?= $llibres[1]?>
    </ul>

</body>
</html>