<?php

//On inclut le hdébut du script.
require('./includes/head.php');

//Function d'affichage du formulaire.
function printForm($db, $catId, $title, $body)
{
    $catList = $db->getCategory(0);
    echo '
    <h1>Nouvel Article</h1>
    <form action="newArticle.php" method="post">
            <input type="hidden" name="newArticle" value="newArticle"/>
            <p>
                <label for="title">Titre*</label>
                <br/><input type="text" name="title" value="'. htmlentities($title). '" maxlength="255" required/>
            </p>
            <p>
                <label for="catId">Catégorie</label>
                <br/><select name="catId">';
    foreach($catList as $cat)
    {
        echo '
        <option value = "'.(int)$cat['id'].'" '. ((int)$cat['id'] === $catId ? 'selected="selected"' : '' ).'>'.htmlentities($cat['name']).'</option>';
    }
    echo'
       </select>
    </p>
    <p>
        <label for="body" required>Texte*</label>
        <br/><textarea name="body" style="height: 200px; height: 200px; resize: none;" >'. htmlentities($body). '</textarea>
    </p>
    <p>
        <input type="submit" name="button" value="GO"/>
    </p>
    </form>';
}

if (isset($_SESSION['rights']) && $_SESSION['rights'] === 'admin')
{
    //Si des données $_POST ont été envoyées avec un champ newArticle, on les récupère.
    if (isset($_POST['newArticle']))
    {
        $catId = (int)$_POST['catId'];
        $title = trim($_POST['title']);
        $body = trim($_POST['body']);
        //Si le titre et le corps du texte sont bien remplis, on traite le nouvel article.
        if ($title !== '' && $body !== '')
        {
            //$body = nl2br($body);
            $db->newArticle($catId, $title, $body);
            echo '<h1>Nouvel article enregistré :-)</h1>';
            echo '<p><a href="admin.php">Retour à l\'accueil.</a></p>';
        }
        //Sinon, on réaffiche le formulaire avec les champs déjà complétés.
        else
        {
            printForm($db, $catId, $title, $body);
        }
    }
    //Sinon, on affiche le formulaire avec des champs vides.
    else
    {
        $catId = "";
        $title = "";
        $body = "";
        printForm($db, $catId, $title, $body);
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