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
    
    //On liste les catégories.
    $categoriesList = $db->getCategory(0);
    
    echo '<H1>Catégories</H1>
    ';
    
    if (!empty($categoriesList))
    {
        foreach ($categoriesList as $category)
        {
            echo '
            <div class="tableWrapper"><table>
            <tr>
                <td>
                    '. $category['name'].'
                </td>
            </tr>
            <tr>
                <td>
                    <form action="editCategory.php" method="post">
                    <input type="hidden" name="editCategory" value="editCategory"/>
                    <input type="hidden" name="id" value="'. $category['id']. '"/>
                    <input type="submit" name="button" value="Editer"/>
                    </form>';
            //S'il y a plus d'une catégorie, on affiche la possibilité de les supprimer.
            if (count($categoriesList) > 1)
            {
                echo '
                    <form action="deleteCategory.php" method="post" >
                    <input type="hidden" name="deleteCategory" value="deleteCategory"/>
                    <input type="hidden" name="id" value="'. $category['id']. '"/>
                    <input type="button" name="button" value="Supprimer" onclick="confirmSubmit(this.form, \'cette catégorie\')"/>
                    et envoyer les articles vers
                    <select name="newCatId">';
                    foreach ($categoriesList as $newCategory)
                    {
                        if ($newCategory['id'] !==  $category['id'])
                        {
                            echo '
                            <option value="'. $newCategory['id']. '">'. $newCategory['name']. '</option>';
                        }
                    }
                    echo'
                    </select>
                    </form>';
            }
            echo '
            </table></div>';    
        }
    }
    else
    {
        echo '<p>Aucune catégorie à afficher.</p>';
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