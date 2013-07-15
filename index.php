<?php
    require './Core/transit.php'
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Trans It</title>
    </head>
    <body>
        <h1>Internalisationer vos sites</h1>
        <?php $t = TransIt::getInstance();?>
        <p><?php echo $t->getSentences("bonjour", "FR", null);?></p>
    </body>
</html>
