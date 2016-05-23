<?php

//On inclut le hdébut du script.
require('./includes/head.php');

if (isset($_SESSION['rights']) && $_SESSION['rights'] === 'admin')
{
    //Si l'on peut récupérer un id de catégorie,
    //on le place dans la variable currentCategory.
    //Sinon, category est égal à 0, ce qui indique aux fonctions de la classe DB
    //qu'il ne faut pas tenir compte de la catégorie.
    if (isset($_GET['c']))
    {
        $currentCategory = (int)$_GET['c'];
    }
    else
    {
        $currentCategory = 0;
    }
    
    //Si l'on peut récupérer un numero de page et que celui-ci est supérieur à 0,
    //on le place dans la variable currentPage et on demande l'id du premier article de la page en cours.
    //Sinon, on déclare que le numéro de page est égal à 0, et on demande l'id du dernier article posté.
    if (isset($_GET['p']) && (int)$_GET['p'] > 0)
    {
        $currentPage = (int)$_GET['p'];
        $firstArticleId = $db->nArticle($currentCategory, $currentPage*ARTICLESPERPAGE+1);
    }
    else
    {
        $currentPage = 0;
        $firstArticleId = $db->nArticle($currentCategory,0);
    }
    
    //On liste les catégories.
    $categoriesList = $db->getCategory(0);
    
    echo '<H1>Liste des articles</H1>
    <div class="tableWrapper"><table>
        <tr>
            <td>
                Trier par catégories : <a href="listArticles.php?c=0">Toutes </a> '; 
                foreach ($categoriesList as $category)
                {
                    if ((int)$category['id'] === $currentCategory)
                    {
                        echo '/ '.$category['name']. ' ';
                    }
                    else
                    {
                        echo '
                        / <a href="listArticles.php?c='. $category['id']. '">'. $category['name']. '</a> ';  
                    }
                }
                echo '
            </td>
        </tr>
    </table></div>';
    
    //On récupère un tableau contenant les articles de la page
    //Si celui-ci n'est pas vide, on affiche les articles et les numéros de page.
    if (! empty($articlesList = $db->getArticle($currentCategory, $firstArticleId, ARTICLESPERPAGE)))
    {
        foreach ($articlesList as $article)
        {
            echo '
            <div class="tableWrapper"><table>
                <tr>
                    <td>
                    # '. $article['id'].' - '. date('Y-m-d',$article['date']). ' - "<mark>'. $article['title']. '</mark>"
                    </td>
                </tr>
            <tr>
                <td>
                    <form action="editArticle.php" method="post" >
                    <input type="hidden" name="editArticle" value="editArticle"/>
                    <input type="hidden" name="id" value="'. $article['id']. '"/>
                    <input type="submit" name="button" value="Editer" />
                    </form>
                    <form action="listComments.php" method="post" >
                    <input type="hidden" name="listComments" value="listComments"/>
                    <input type="hidden" name="articleId" value="'. $article['id']. '"/>
                    <input type="submit" name="button" value="Supprimer des commentaires" />
                    </form>
                    <form action="deleteArticle.php" method="post" >
                    <input type="hidden" name="deleteArticle" value="deleteArticle"/>
                    <input type="hidden" name="id" value="'. $article['id']. '"/>
                    <input type="button" name="button" value="Supprimer"  onclick="confirmSubmit(this.form, \'cet article\')"/>
                    </form>
                </td>
            </tr>
        </table></div>';
        }
        
        //On calcule un entier qui correspond au nombre total de pages,
        //égal au nombre total d'articles divisé par le nombre d'articles affichés par page.
        //Si ce nombre total de pages est supérieur à 1, on génère les liens vers les autres pages.
        if (($numberOfPages = ((int)$db->countArticles($currentCategory)/ARTICLESPERPAGE)) > 1)
        {
            echo '
            <div class="tableWrapper"><table>
            <tr>
                <td>';
                    for ($i=0; $i<$numberOfPages; $i++)
                    {
                        if ($i === $currentPage)
                        {
                            echo $i. ' ';
                        }
                        else
                        {
                            echo '<a href="?p='. $i. ($currentCategory !== 0 ? '&c='. $currentCategory : ''). '">'. $i. '</a> '; 
                    
                        }
                    }
            echo '
                </td>
            </tr>
            </table></div>
            ';
        }
    }
    else
    {
        echo '<p>Aucun article à afficher :-(</p>';
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