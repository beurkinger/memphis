<?php

//On inclut le début du script.
require('./includes/head.php');

//Function d'affichage du formulaire.
function printForm($articleId, $author, $body, $website, $mail)
{
    echo '
    <h2 id="comment">Commenter cet article</h2>
    <form action="Article.php?id='.$articleId .'#comment" method="post">
            <input type="hidden" name="newComment" value="newComment"/>
            <input type="hidden" name="articleId" value="'.$articleId.'"/>
            <p>
                <label for="title">Nom*</label>
                <br/><input type="text" name="author" value="'. htmlentities($author). '" maxlength="255" required/>
            </p>
            <p>
                <label for="title">Mail de contact</label>
                <br/><input type="email" name="mail" value="'. htmlentities($mail). '" maxlength="255"></input>
            </p>
            <p>
                <label for="title">Site (http://...)</label>
                <br/><input type="url" name="website" value="'. htmlentities($website). '" maxlength="255"></input>
            </p>
            <p>
            <label for="body">Commentaire*</label>
            <br/><textarea name="body" required>'. htmlentities($body). '</textarea>
            </p>
            <p>
            <input type="submit" name="button" value="GO"/>
            </p>
    </form>';
}

//Si l'on peut récupérer un id d'article et que celui-ci correspond à un article,
//on l'affiche.
if (isset($_GET['id']) && (! empty($article = $db->getArticle(0, (int)$_GET['id'], 1))))
{
    echo '
            <article>
                <h1>'. $article[0]['title']. '</h1>
                <time>'. date('d/m/Y',$article[0]['date']).' ~ <a href="index.php?c='. $article[0]['cat_id']. '">'. $db->getCategory($article[0]['cat_id'])[0]['name']. '</a></time>
                <p>'. nl2br($article[0]['body']). '</p>
            </article>';
    
    //On récupère un tableau contenant les commentaires liés à l'article,
    //et on l'affiche s'il n'est pas vide.
    if (! empty($commentsList = $db->getComment((int)$_GET['id'])))
    {
        echo '
        <h2>Commentaires</h2>';
        foreach ($commentsList as $comment)
        {
            echo '
            <h3>'. (($comment['website'] !== '') ? '<a href ="'.htmlentities($comment['website']).'">'. htmlentities($comment['author']). '</a>' : htmlentities($comment['author'])).', le '. date('Y-m-d',$comment['date']). '</h3>
            <p class="comment">'. nl2br(htmlentities($comment['body'])). '</p>';
        }        
    } 
    
    //Si des données $_POST ont été envoyées avec un champ newArticle, on les récupère.
    if (isset($_POST['newComment']))
    {
        $articleId = (int)$_POST['articleId'];
        $author = trim($_POST['author']);
        $body = trim($_POST['body']);
        $website = trim($_POST['website']);
        $mail = trim($_POST['mail']);
        //Si l'auteur et le corps du texte sont bien remplis, on traite le nouvel article.
        if ($author !== '' && $body !== '')
        {
            $author = $author;
            $body = $body;
            $website = $_POST['website'];
            $mail = $_POST['mail'];
            $db->newComment($articleId,$author,$body,$website, $mail);
            echo '
                <h2 id="comment">Commentaire enregistré :-)</H2>
                <p>Cliquez <a href="Article.php?id='.$articleId .'">içi</a> pour l\'afficher.</p>';
        }
        //Sinon, on réaffiche le formulaire avec les champs déjà complétés.
        else
        {
            printForm($articleId, $author, $body, $website, $mail);
        }
    }
    //Sinon, on affiche le formulaire avec des champs vides.
    else
    {
        $articleId = $article[0]['id'];
        $author = '';
        $body = '';
        $website ='';
        $mail = '';
        printForm($articleId, $author, $body, $website, $mail);
    }
}
else
{
    echo '
    <h1>Aucun article à afficher :-(</h1>
    <p><a href="index.php">Retour à l\'accueil.</a></p>';
}
  
//On inclut la fin du script
require('./includes/foot.php');
?>