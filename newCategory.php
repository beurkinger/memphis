
<?php

//On inclut le hdébut du script.
require('./includes/head.php');

//Function d'affichage du formulaire.
function printForm()
{
    echo '
    <H1>Nouvelle Catégorie</H1>
    <form action="newCategory.php" method="post">
        <input type="hidden" name="newCategory" value="newCategory"/>
        <p>
            <label for="name">Nom de la nouvelle catégorie</label>
            <br/><input type="text" name="name" maxlength="255" required/>
        </p>
        <p>
            <input type="submit" name="button" value="GO"/>
        </p>
    </form>';
}

if (isset($_SESSION['rights']) && $_SESSION['rights'] === 'admin')
{
    //Si des données $_POST ont été envoyées avec un champ newCategory et un champ name rempli,
    //on créé la nouvelle catégorie.
    if (isset($_POST['newCategory']) && trim($_POST['name']) !== '')
    {
        $name = trim($_POST['name']);
        $db->newCategory($name);
        echo '<H1>Nouvelle catégorie enregistrée :-)</H1>';
        echo '<p><a href="admin.php">Retour à l\'accueil.</a></p>';
    }
    //Sinon, on affiche le formulaire.
    else
    {
        printForm();
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