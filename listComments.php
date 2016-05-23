<?php

//On inclut le hdébut du script.
require('./includes/head.php');

if (isset($_SESSION['rights']) && $_SESSION['rights'] === 'admin')
{
    //Si l'on peut récupérer un champ listComments et qu'un article correspondant à l'id...
    if (isset($_POST['listComments']) && (! empty($article = $db->getArticle(0, (int)$_POST['articleId'], 1))))
    {
        //On affiche l'article.
        echo '<h1>Commentaires de l\'article #'. $article[0]['id'].' </br>"'. $article[0]['title']. '" </h1>';
        
        //Si des commentaires correspondent à l'id d'article, on les affiche.
        if (! empty($commentsList = $db->getComment((int)$_POST['articleId'])))
        {
            foreach ($commentsList as $comment)
            {
            echo '
            <div class="tableWrapper"><table>
            <tr>
                <td>
                   <label for="deleteComment">'. date('Y-m-d, H:m',$comment['date']). ' - '. htmlentities($comment['author']).' '.htmlentities($comment['mail']).' : </br>"<mark>'.substr(htmlentities($comment['body']), 0, 80). '</mark>..."</label>
                </td>
            </tr>
            <TR> 
                <td>
                    <form action="deleteComment.php" method="post" >
                        <input type="hidden" name="deleteComment" value="deleteComment"/>
                        <input type="hidden" name="id" value="'. $comment['id']. '"/>
                        <input type="button" name="button" value="Supprimer"  onclick="confirmSubmit(this.form, \'ce commentaire\')"/>
                    </form>
                </td>
            </tr>
            </table></div>';
            }
        } 
        else
        {
            echo '
            <p>Aucun commentaire à afficher.</p>
            <p><a href="admin.php">Retour à l\'accueil.</a></p>';
        }
    }
    //Sinon, retour à l'envoyeur.
    else
    {
        echo '
        <h1>Perdu ?</h1>
        <p><a href="admin.php">Retour à l\'accueil.</a></p>';
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