<?php

?><?php

//On inclut le hdébut du script.
require('./includes/head.php');

//Function d'affichage du formulaire.
function printForm()
{
    echo '
    <H1>Editer la Catégorie</H1>
    <form action="editPassword.php" method="post">
    <fieldset>
        <input type="hidden" name="updatePassword" value="updatePassword"/>
            <input type="hidden" name="name" value="admin"/>
        <p>
          <label for="paswword">Mot de passe actuel</label>
          <br/><input type="password" name="password" maxlength="255" required />
        </p>
        <p>
            <label for="newPassword">Nouveau mot de passe</label>
            <br/><input type="password" name="newPassword" maxlength="255" required />
        </p>
        <p>
            <label for="newPassword2">Confirmation du mot de passe</label>
            <br/><input type="password" name="newPassword2" maxlength="255" required />
        </p>
        <p>
            <input type="submit" name="button" value="GO"/>
        </p>
     </fieldset>
    </form>';
}

if (isset($_SESSION['rights']) && $_SESSION['rights'] === 'admin')
{
    ////Si des données $_POST ont été envoyées avec un champ updatePassword, on les récupère.
    if (isset($_POST['updatePassword']))
    { 
        $name = trim($_POST['name']);
        $password = trim($_POST['password']);
        $newPassword = trim($_POST['newPassword']);
        $newPassword2 = trim($_POST['newPassword2']);
        //Si tous les champs sont bien remplis, que newPassword = newPassword2, et que le password correspond,
        //on traite la mise à jour du mot de passe
        if ($name !== '' && $password !=='' && $newPassword !=='' && $newPassword2 !=='' && $newPassword === $newPassword2 && $db->checkPassword($name, $password))
        {
            $db->updatePassword($name, $newPassword);
            echo '<H1>Mot de passe mis à jour :-)</H1>';
            echo '<p><a href="admin.php">Retour à l\'accueil.</a></p>';   
        }
        else
        {
            //Sinon, on réaffiche le formulaire.
            printForm();
        }
    }
    //Sinon, on affiche le formulaire.
    else
    {
        printForm();
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