<?php
//Classe rassemblant les opérations sur la BDD.

  /////////////////////////////////////
 //Fonctions liées aux utilisateurs.//
/////////////////////////////////////

//createUser(nom, motdePasse)
//Crée un utilisateur.

//checkPassword(nom, motDePasse)
//Retourne true si l'utilisateur existe et que le mot de passe correspond.

//checktUser(nom, motDePasse)
//Retourne true si l'utilisateur existe et que le mot de passe correspond.

  /////////////////////////////////
 //Fonctions liées aux articles.//
/////////////////////////////////

//countArticles(idCategorie):
//Renvoie le nombre total d'articles.
//Si idCategorie  > 0, on compte à l'intérieur d'une catégorie.

//nArticle(idCategorie, n):
//Renvoie l'id du nème article en partant du plus récent.
//Si n=0, renvoie l'id de l'article le plus récent.
//Si idCategorie > 0, se limite à la catégorie désignée.

//getArticle(idCategorie, idPremierArticle, nombreArticles):
//Renvoie le ou les articles dans un tableau classé par date décroissante.
//Si idCategorie > 0, se limite à la catégorie désignée.

//newArticle(idCategorie, titre, CorpsDuTexte):
//Crée un nouvel article.

//updateArticle(id, idCatégorie, titre, CorpsDuTexte):
//Met à jour un article.

//deleteArticle(idArticle):
//Supprime un article et les commentaires qui lui sont liés.

  ///////////////////////////////////
 //Fonctions liées aux catégories.//
///////////////////////////////////

//getCategory(id):
//Renvoie id et le nom des catégories dans un tableau.
//Si pas d'id précisé, renvoie la liste de toutes les catégories, triées par nom ascendant.

//newCategory(name):
//Crée une nouvelle catégorie.

//updateCategory(id, name):
//Met à jour une catégorie.

//deleteCategory(id):
//Supprime une catégorie.

  /////////////////////////////////////
 //Fonctions liées aux commentaires.//
/////////////////////////////////////

//getComment(idArticle):
//Renvoie dans un tableau les commentaires associés à un article précis.
//Si idArticle = 0, renvoie la liste de tous les commentaires.

//newComment(name):
//Crée un nouveau commentaire.

//deleteComment(id):
//Supprime un commentaire.

class db
{
    //Variable qui contient l'objet PDO (les données de connexion).
    private $connection;

    //Création d'une connexion à la BDD quand un objet db est créé.
    public function __construct($dns, $user, $password)
    {
        //Tentative de connexion à la BDD/création d'un objet PDO.
        try
        {
            $this->connection = new PDO($dns, $user, $password);
            //Modification du mode de gestion des erreurs de PDO.
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        // Si échec de la connexion, affichage d'une erreur et arrêt du script.
        catch (PDOException $exception)
        {
            echo 'Connection à la BDD impossible : '. $exception->getMessage(). '. ';
            exit ('Arrêt du script.');
        }
    }
    
     //Crée un utilisateur.
    public function createUser($name, $password)
    {
        try
        {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $request = $this->connection->prepare('INSERT INTO users SET name = :name, password = :password');
            $request->bindParam(':name', $name);
            $request->bindParam(':password', $password);
            $request->execute();
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'A2 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }  
    }
    
    //Retourne true si l'utilisateur existe et que le mot de passe correspond.
    public function checkPassword($name, $password)
    {
        try
        {
            $request = $this->connection->prepare('SELECT name, password FROM users WHERE BINARY name = :name');
            $request->bindParam(':name', $name);
            $request->execute();
            $results = $request->fetchAll(PDO::FETCH_ASSOC);
            //Si un utilisateur est associé au nom fourni
            if (count($results) === 1)
            {
                //Si le password correspond
                if (password_verify($password, $results[0]['password']))
                {
                    return TRUE;
                }
                else
                {
                return FALSE;
                }
            }
            else
            {
                return FALSE;
            }
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'A2 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }  
    }
    
    //Met le mot de passe utilisateur à jour.
    public function updatePassword($name, $newPassword)
    {
        try
        {
            $request = $this->connection->prepare('UPDATE users SET password = :newPassword WHERE BINARY name = :name');
            $request->bindParam(':name', $name);
            $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $request->bindParam(':newPassword', $newPassword);
            $request->execute();
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'A2 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }  
    }

    //Compte les articles et renvoie le total.
    public function countArticles($cat_id)
    {
        try
        {
            //Si cat_id = 0, on ne tient pas compte de la catégorie dans la requête.
            if ($cat_id === 0)
            {
                $request = $this->connection->query('SELECT COUNT(*) FROM articles');              
            }
            else
            {
                $request = $this->connection->prepare('SELECT COUNT(*) FROM articles WHERE cat_id = :cat_id');
                $request->bindParam(':cat_id', $cat_id);
                $request->execute();
            }
            //On associe la première colonne du résultat à la variable $cnt, on récupère sa valeur et on renvoie le tout.
            $request->bindColumn(1, $cnt);
            $request->fetch(PDO::FETCH_BOUND);
            return $cnt;
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'A1 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }        
    }
    
    //Renvoie dans une variable l'id du nème article en partant du plus récent.
    //Si n=0, renvoie l'id du dernier article.
    public function nArticle($cat_id, $n)
    {
        try
        {
            //Si cat_id = 0, on ne tient pas compte de la catégorie dans la requête.
            if ($cat_id === 0)
            {
                //Si le paramètre $id = 0, on renvoie l'id le plus grand.
                if ($n === 0)
                {
                    $request = $this->connection->query('SELECT id FROM articles WHERE date=(SELECT MAX(date) FROM articles)');
                }
                //Sinon, on renvoie l'id de l'article situé à une distance n du plus récent.
                else
                {
                    //On soustrait -1 à n car LIMIT compte à partir de 0.
                    $n--;
                    $request = $this->connection->query('SELECT id FROM articles ORDER BY date DESC LIMIT '.$n.',1');
                }
            }    
            else
            {
                //Si le paramètre $id = 0, on renvoie l'id le plus grand dans une catégorie précise.
                if ($n === 0)
                {
                    $request = $this->connection->prepare('SELECT id FROM articles WHERE date=(SELECT MAX(date) FROM articles WHERE cat_id = :cat_id)');
                    $request->bindParam(':cat_id', $cat_id);
                }
                //Sinon, on renvoie l'id de l'article situé à une distance n du plus récent.
                else
                {
                    //On soustrait -1 à n car LIMIT compte à partir de 0.
                    $n--;
                    $request = $this->connection->prepare('SELECT id FROM articles WHERE cat_id = :cat_id ORDER BY date DESC LIMIT '.$n.',1');
                    $request->bindParam(':cat_id', $cat_id);
                }   
            }
            //La première colonne du résultat est associé à $id et renvoyé.
            $request->execute();
            $request->bindColumn(1, $id);
            $request->fetch(PDO::FETCH_BOUND);
            return $id;
        }
            // Si échec de l'exécution, affichage d'une erreur.
            catch (PDOException $exception)
            {
                echo 'A2 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
            }    
    }
    
    //Renvoie un ou plusieurs articles dans un tableau.
    public function getArticle($cat_id, $id, $numberOfArticles)
    {
        try
        {
            //Si id_cat=0, on ne tient pas compte de la catégorie dans la requête.
            if ($cat_id === 0)
            {
                if ($numberOfArticles === 1)
                {
                    $request = $this->connection->prepare('SELECT id, cat_id, title, body, UNIX_TIMESTAMP(date) AS date FROM articles WHERE id = :id');    
                }
                else
                {
                    $request = $this->connection->prepare('SELECT id, cat_id, title, body, UNIX_TIMESTAMP(date) AS date FROM articles WHERE date <= (SELECT date FROM articles WHERE id=:id) ORDER BY date DESC LIMIT '.$numberOfArticles);    
                }  
            }
            else
            {
                if ($numberOfArticles === 1)
                {
                    $request = $this->connection->prepare('SELECT id, cat_id, title, body, UNIX_TIMESTAMP(date) AS date FROM articles WHERE cat_id = :cat_id AND id = :id');   
                }
                else
                {
                    $request = $this->connection->prepare('SELECT id, cat_id, title, body, UNIX_TIMESTAMP(date) AS date FROM articles WHERE cat_id = :cat_id AND date <= (SELECT date FROM articles WHERE id=:id) ORDER BY date DESC LIMIT '.$numberOfArticles);
                }
                $request->bindParam(':cat_id', $cat_id);
            }
            $request->bindParam(':id', $id);  
            $request->execute();
            return $request->fetchAll(PDO::FETCH_ASSOC);
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'A3 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }
    }
    
    //Enregistre un nouvel article.
    public function newArticle($cat_id, $title, $body)
    {
        try
        {
            $request = $this->connection->prepare('INSERT INTO articles SET cat_id=:cat_id, title=:title, body=:body, date=NOW()');
            $request->bindParam(':cat_id', $cat_id);
            $request->bindParam(':title', $title);
            $request->bindParam(':body', $body);
            $request->execute();
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'A4 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }
    }

    //Met à jour un article.
    public function updateArticle($id, $cat_id, $title, $body, $date)
    {  
        try
        {
            $request = $this->connection->prepare('UPDATE articles SET cat_id=:cat_id, title=:title, body=:body, date=:date WHERE id=:id');
            $request->bindParam(':id', $id);
            $request->bindParam(':cat_id', $cat_id);
            $request->bindParam(':title', $title);
            $request->bindParam(':body', $body);
            $request->bindParam(':date', $date);
            $request->execute();
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'A5 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }  
    }
    
    //Supprime un article et les commentaires qui lui sont liés.
    public function deleteArticle($id)
    {  
        try
        {
            $request = $this->connection->prepare('DELETE FROM articles WHERE id=:id');
            $request->bindParam(':id', $id);
            $request->execute();
            $request->closeCursor();
            $request = $this->connection->prepare('DELETE FROM comments WHERE article_id=:id');
            $request->bindParam(':id', $id);
            $request->execute();
            
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'A6 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }  
    }
    
    //Renvoie une ou toutes les catégories dans un tableau.
    //Si id = 0, renvoie toutes les catégories.
    public function getCategory($id)
    {  
        try
        {
            if ($id === 0)
            {
            $request = $this->connection->prepare('SELECT id, name FROM categories ORDER BY name ASC'); 
            }
        else
            {
            $request = $this->connection->prepare('SELECT id, name FROM categories WHERE id = :id');
            $request->bindParam(':id', $id); 
            }
        $request->execute();    
        return $request->fetchAll(PDO::FETCH_ASSOC);    
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'L1 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }  
    }
    
    //Enregistre une nouvelle catégorie
    public function newCategory($name)
    {
        try
        {
            $request = $this->connection->prepare('INSERT INTO categories SET name=:name');
            $request->bindParam(':name', $name);
            $request->execute();
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'L2 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }
    }
    
    //Met à jour une catégorie.
    public function updateCategory($id, $name)
    {  
        try
        {
            $request = $this->connection->prepare('UPDATE categories SET name=:name WHERE id=:id');
            $request->bindParam(':id', $id);
            $request->bindParam(':name', $name);
            $request->execute();
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'L3 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }  
    }
    
    //Supprime une catégorie et déplace les articles qu'elle contenait vers une autre catégorie.
    public function deleteCategory($id, $new_cat_id)
    {
        if (! empty($id) && (! empty($new_cat_id)) && $id !== $new_cat_id)
        {
            try
            {
                $request = $this->connection->prepare('DELETE FROM categories WHERE id=:id');
                $request->bindParam(':id', $id);
                $request->execute();
                $request->closeCursor();
                $request = $this->connection->prepare('UPDATE articles SET cat_id=:new_cat_id WHERE cat_id=:id');
                $request->bindParam(':id', $id);
                $request->bindParam(':new_cat_id', $new_cat_id);
                $request->execute();
            }
            // Si échec de l'exécution, affichage d'une erreur.
            catch (PDOException $exception)
            {
                echo 'L4 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
            }
        }

    }
    
    //Renvoie les commentaires liés à un article précis dans un tableau.
    public function getComment($article_id)
    {
        try
        {
    
            $request = $this->connection->prepare('SELECT id, article_id, author, body, UNIX_TIMESTAMP(date) AS date, website, mail FROM comments WHERE article_id =:article_id ORDER BY id DESC');    
            $request->bindParam(':article_id', $article_id);
            $request->execute();
            return $request->fetchAll(PDO::FETCH_ASSOC);
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'C1 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }
    }
    
    //Enregistre un nouveu commentaire.
    public function newComment($article_id, $author, $body, $website, $mail)
    {
        try
        {
            $request = $this->connection->prepare('INSERT INTO comments SET article_id=:article_id, author=:author, body=:body, website=:website, mail=:mail, date=NOW()');
            $request->bindParam(':article_id', $article_id);
            $request->bindParam(':author', $author);
            $request->bindParam(':body', $body);
            $request->bindParam(':website', $website);
            $request->bindParam(':mail', $mail);
            $request->execute();
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'C2 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }
    }    
        
    //Supprime un commentaire.
    public function deleteComment($id)
    {  
        try
        {
            $request = $this->connection->prepare('DELETE FROM comments WHERE id=:id');
            $request->bindParam(':id', $id);
            $request->execute();
        }
        // Si échec de l'exécution, affichage d'une erreur.
        catch (PDOException $exception)
        {
            echo 'C3 Problème dans l\'exécution de la requête : '. $exception->getMessage(). '. ';
        }  
    }
}
?>