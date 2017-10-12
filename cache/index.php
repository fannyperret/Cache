<?php require '../class/cache.php'; ?>

<?php define('ROOT', dirname(__FILE__));?>
<?php $Cache = new Cache(ROOT.'/tmp',2); ?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cache</title>
</head>
<body>

<h1>Cache</h1>
<p>Ici on apprend à créer un cache qui évite de générer son API à chaque fois. Ici j'ai un bout de code qui est super lent à générer, je vais alors utiliser un cache pour changer tout ça ! On peut d'ailleurs gérer notre Snipper Github :)</p>

<?php //un système de cache en utilisant les ob_start et ob_end qui permet de mettre en cache toute une partie de notre PHP
if($Cache->start('MonSuperCache')){
    sleep(1);
    $variable = 'Salut ça va';
    echo $variable;
    $variable = 'Salut ça va bien';
    echo $variable;
}
$Cache->end();
?>
<?php $Cache->inc(ROOT.'/test.php'); ?>

</body>
</html>

<?php $Cache->clear(); ?>