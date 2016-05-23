<?php

//On inclut le hdébut du script.
require('./includes/head.php');

//Si l'on peut récupérer un id de catégorie,
//On le place dans la variable currentCategory.
//Sinon, currentCategory est égal à 0, ce qui indique aux fonctions de la classe DB
//qu'il ne faut pas tenir compte de la catégorie.
if (isset($_GET['c']))
{
    $currentCategory = (int)$_GET['c'];
    echo '<h4>Articles de la catégorie <br/>"'.$db->getCategory($currentCategory)[0]['name'].'"</h4>';
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
    $firstArticleId = $db->nArticle($currentCategory, ($currentPage*ARTICLESPERPAGE)+1);
}
else
{
    $currentPage = 0;
    $firstArticleId = $db->nArticle($currentCategory,0);
}

//On récupère un tableau contenant les articles de la page
//Si celui-ci n'est pas vide, on affiche les articles et les numéros de page.
$articlesList = $db->getArticle($currentCategory, $firstArticleId, ARTICLESPERPAGE);
if (! empty($articlesList))
{
    foreach ($articlesList as $article)
    {
        echo '
            <article>
                <h1>'. $article['title']. '</h1>
                <time>'. date('d/m/Y',$article['date']).' ~ <a href="index.php?c='. $article['cat_id']. '">'. $db->getCategory($article['cat_id'])[0]['name']. '</a></time>
                <p>'. nl2br($article['body']). '</p>
            </article>
            <aside>
                <div class="pull-right"><a href=article.php?id='.$article['id'].'>Commenter</a></div>
                <div class="clearfix"></div>
            </aside>';
    }
    //On calcule un entier qui correspond au nombre total de pages,
    //égal au nombre total d'articles divisé par le nombre d'articles affichés par page.
    //Si ce nombre total de pages est supérieur à 1, on génère les liens vers les autres pages.
    if (($numberOfPages = ((int)$db->countArticles($currentCategory)/ARTICLESPERPAGE))>1)
    {
        echo'<div class ="pages">';       
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
        echo'</div>';       
    }
}
else
{
    echo '
    <h1>Aucun article à afficher :-(</h1>
    <p><a href="?">Retour à l\'accueil.</a></p>';
}

//On inclut la fin du script
require('./includes/foot.php');
?>