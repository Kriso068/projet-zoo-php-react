<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <?php require_once('views/commons/menu.php'); ?>
    <div class="container">
        <h1 class="rounded border border-dark mt-2 p-2 text-center text-light bg-info"><?= $titre ?></h1>
        <?php if(!empty($_SESSION['alert'])) :?>
            <div class="alert <?= $_SESSION['alert']['type'] ;?>" role="alert">
                <?= $_SESSION['alert']['message'] ;?>
            </div>
        <?php
            unset($_SESSION['alert']);  
            endif ; 
        ?>
        <?= $content ?>

    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

