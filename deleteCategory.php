<?php

//On inclut le hdébut du script.
require('./includes/head.php');

if (isset($_SESSION['rights']) && $_SESSION['rights'] === 'admin')
{
    //Si des données $_POST ont été envoyées avec un champ deleteCategory, 
    //ainsi que des id nouveaux et anciens différents l'un de l'autre...
    if (isset($_POST['deleteCategory']) && isset($_POST['id']) && isset($_POST['newCatId']) && (($id = (int)$_POST['id']) !== ($newCatId = (int)$_POST['newCatId'])))
    {
        $db->deleteCategory($id, $newCatId);
        echo '<H1>Catégorie supprimée :-)</H1>';
        echo '<p><a href="admin.php">Retour à l\'accueil.</a></p>';
    }
    //Sinon, retour à l'envoyeur.
    else
    {
        echo '<H1>Perdu ?</H1>';
        echo '<p><a href="admin.php">Retour à l\'accueil.</a></p>'; 
    }
}
else
{
    echo '<h1>Utilisateur non connecté.</h1>';
    echo '<p><a href="admin.php">Retour à l\'accueil.</a></p>';
}


//On inclut la fin du script
require('./includes/foot.php');
?>