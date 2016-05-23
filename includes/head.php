<?php
session_start();
require('./includes/constants.php');
require('./includes/db.php');

//Création d'un objet db / d'une nouvelle connexion à la BDD.
$db = new db(DNS, USER, PASSWORD);

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="favicon.ico">
    <link type="text/css" rel="stylesheet" href="./css/style.css"/>
    <script language="JavaScript" SRC="./js/jsFunctions.js"></script>
    <title>/\/\ = /\/\</title>
</head>

<body>

<div id="pagewrapper">
    
<div id="header">
<div id="rectangleshadow"></div>
<div id="rectangle"></div>
<div id="triangle"></div>
        
        <nav>     
            <ul>
                <li>
                    <a href="./index.php">Blog</a>
                </li>
                <li>
                    <a href="./about.php">À propos</a>
                </li>
                <li>
                    <a href="./cv.php">CV </a>
                </li>
            </ul>
            <h1><a href="./index.php">Tessier-Ashpool</a></h1>
        </nav>
        
    </div>
    
    <div id="content">
        
        <div id="main">