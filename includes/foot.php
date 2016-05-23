    </div>    
    
        <nav id="menu">

                <?php
                //S'il existe des catégories, on en affiche la liste.
                $categoriesList = $db->getCategory(0);
                if (! empty($categoriesList))
                {
                        echo '
                        <h1>Catégories</h1>
                        <ul>';
                        foreach ($categoriesList as $category)
                        {
                                echo '
                                <li><a href="index.php?c='. $category['id']. '">'. $category['name']. '</a></li>';  
                        }
                        echo '
                        </ul>';
                }
                else
                {
                        echo '
                        <h1>Catégories</h1>
                        <ul>
                                <li>
                                        <a href="#">Vide</a>
                                </li>
                        </ul>';
                }
                ?>
                <h1>Contact</h1>
                <ul>
                        <li><a href="mailto:tgoehringer@gmail.com">Mail</a></li>
                        <li><a href="http://www.colourlovers.com/lover/beurkinger">Colourlovers</a></li>
                        <li><a href="https://github.com/beurkinger">Github</a></li> 
                </ul>
                 <h1>Projets</h1>
                <ul>
                        <li><a href="./Yahoo/">Yahoo RSS Reader</a></li>
                </ul>
        </nav>
    
</div>

</div>

<div id="footer">© Copyright  <?php echo date('Y') ; ?> - Thibault Goehringer</div>

</body>

<?php
//Destruction de la connexion à la BDD.
unset($db);
?>