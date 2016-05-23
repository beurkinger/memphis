<?php

//On inclut le hdébut du script.
require('./includes/head.php');

if (isset($_SESSION['rights']) && $_SESSION['rights'] === 'admin')
{
  //Si des données $_POST ont été envoyées avec un champ deleteComment et un id...
  if (isset($_POST['deleteComment']) && isset($_POST['id']))
  {
    $id = (int)$_POST['id'];
    $db->deleteComment($id);
    echo '<H1>Commentaire supprimé :-)</H1>';
    echo '<p><a href="admin.php">Retour à l\'accueil.</a></p>';
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