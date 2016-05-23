<?php

//On inclut le hdébut du script.
require('./includes/head.php');

//Function d'affichage du formulaire.
function printForm($db, $id, $catId, $title, $body, $date)
{
    $catList = $db->getCategory(0);
    echo '
    <H1>Editer Article</H1>
    <form action="editArticle.php" method="post">
            <input type="hidden" name="updateArticle" value="updateArticle"/>
            <input type="hidden" name="id" value="'. $id. '"/>
            <p>
                <label for="title">Titre</label>
                <br/><input type="text" name="title" value="'. htmlentities($title). '" maxlength="255" required />
            </p>
            <p>
                <label for="date">Date (format aaaa-mm-jj hh:mm)</label>
                <br/><input type="text" name="date" value="'. htmlentities($date). '" maxlength="19" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}" required />
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
        <label for="body">Texte</label>
    <br/><textarea name="body" style="height: 200px; height: 200px; resize: none;"  required />'. htmlentities($body). '</textarea>
    </p>
    <p>
    <input type="submit" name="button" value="GO"/>
    </p>
    </form>';
}

if (isset($_SESSION['rights']) && $_SESSION['rights'] === 'admin')
{
    ////Si des données $_POST ont été envoyées avec un champ updateArticle, on les récupère.
    if (isset($_POST['updateArticle']))
    {
        $id = (int)$_POST['id'];    
        $catId = (int)$_POST['catId'];
        $title = trim($_POST['title']);
        $body = trim($_POST['body']);
        $date = trim($_POST['date']);
        //Si tous les champs sont bien remplis, on traite la mise à jour de l'article.
        if ($id !=='' && $catId !== '' && $title !== '' && $body !== '' && $date !== '' && preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}/',$date))
        {
            //$body = nl2br($body);
            $db->updateArticle($id, $catId, $title, $body, $date);
            echo '<H1>Article édité :-)</H1>';
            echo '<p><a href="admin.php">Retour à l\'accueil.</a></p>';        
        }
        else
        {
            //Sinon, on réaffiche le formulaire avec les champs déjà complétés.
            printForm($db, $id, $catId, $title, $body, $date);
        }
    }
    //Sinon, si l'on a reçu un champ editArticle et qu'un article correspond à l'id,
    //on récupère l'article et on le place dans le formulaire.
    elseif (isset($_POST['editArticle']) && (! empty($articleList = $db->getArticle(0, (int)$_POST['id'], 1))))
    {
        foreach ($articleList as $article)
        {
            $id = (int)$article['id'];    
            $catId = (int)$article['cat_id'];
            $title = $article['title'];
            $body = $article['body'];
            $date = date('Y-m-d H:i:s',$article['date']);
        }
        printForm($db, $id, $catId, $title, $body, $date);
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