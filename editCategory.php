<?php

//On inclut le hdébut du script.
require('./includes/head.php');

//Function d'affichage du formulaire.
function printForm($id, $name)
{
    echo '
    <H1>Editer la Catégorie</H1>
    <form action="editCategory.php" method="post">
    <fieldset>
        <input type="hidden" name="updateCategory" value="updateCategory"/>
        <input type="hidden" name="id" value="'. $id. '"/>
        <p>
          <label for="name">Nom</label>
          <br/><input type="text" name="name" value="'. htmlentities($name). '" maxlength="255" required />
        </p>
        <p>
          <input type="submit" name="button" value="GO"/>
        </p>
     </fieldset>
    </form>';
}

if (isset($_SESSION['rights']) && $_SESSION['rights'] === 'admin')
{
  ////Si des données $_POST ont été envoyées avec un champ updateCategory, on les récupère.
  if (isset($_POST['updateCategory']))
  {
      $id = (int)$_POST['id'];    
      $name = trim($_POST['name']);
      //Si tous les champs sont bien remplis, on traite la mise à jour de la catégorie.
      if ($id !=='' && $name !== '')
      {
          $db->updateCategory($id, $name);
          echo '<H1>Catégorie éditée :-)</H1>';
          echo '<p><a href="admin.php">Retour à l\'accueil.</a></p>';        
      }
      else
      {
          //Sinon, on réaffiche le formulaire avec les champs déjà complétés.
          printForm($id, $name);
      }
  }
  //Sinon, si l'on a reçu un champ editCategory et qu'une catégorie correspond à l'id,
  //on récupère la catégorie et on le place dans le formulaire.
  elseif (isset($_POST['editCategory']) && (! empty($categoriesList = $db->getCategory((int)$_POST['id']))))
  {
      foreach ($categoriesList as $category)
      {
          $id = (int)$category['id'];    
          $name = $category['name'];
      }
      printForm($id, $name);
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