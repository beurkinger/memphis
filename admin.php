<?php

//On inclut le hdébut du script.
require('./includes/head.php');

//Function d'affichage du formulaire.
function printForm($name)
{
    echo '
    <H1>Connexion</H1>
    <form action="admin.php" method="post">
        <input type="hidden" name="connect" value="connect"/>
        <p>
            <label for="name">Nom d\'utilisateur</label>
            <br/><input type="text" name="name" maxlength="255" value="'.$name.'" required/>
        </p>
        <p>
            <label for="password">Nom d\'utilisateur</label>
            <br/><input type="password" name="password" maxlength="255" required/>
        </p>
        <p>
            <input type="submit" name="button" value="Connexion"/>
        </p>
    </form>';
}

if (isset($_GET['disconnect']))
{
    session_destroy();
    $_SESSION = [];
}

if (!isset($_SESSION['rights']))
{
    if (isset($_POST['connect']))
    {
        $name = trim($_POST['name']);
        $password = trim($_POST['password']);
        if ($name !== '' && $password !== '')
        {
            if ($db->checkPassword($name, $password) === TRUE)
            {
                $_SESSION['rights'] = 'admin';
            }
            else
            {
                printForm($name);
            }
        }   
        else
        {
            printForm($name);
        }
    }
    else
    {
        $name='';
        printForm($name);
    }
}

if (isset($_SESSION['rights']) && $_SESSION['rights'] === 'admin')
{
    echo '<H1>Administration</H1>
    <p><a href="newCategory.php">Créer une nouvelle catégorie.</a></p>
    <p><a href="listCategories.php">Editer les catégories.</a></p>
    <p><a href="newArticle.php">Créer un nouvel article.</a></p>
    <p><a href="listArticles.php">Editer les articles et les commentaires.</a></p>
    <p><a href="editPassword.php">Modifier le mot de passe.</a></p>
    <p><a href="admin.php?disconnect">Se déconnecter.</a></p>
    ';
}

//On inclut la fin du script
require('./includes/foot.php');
?>