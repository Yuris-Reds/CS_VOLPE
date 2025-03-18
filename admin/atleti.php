<?php
    session_start();
    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

    if($_SESSION["logged"]){
        writeMenu('a');

        switch($sc){
            case "formNuoviAtleti": {
                echo("aggiungere form");
                break;
            }

            case "listaAtleti": {
                echo("aggiungere lista atleti");
                break;
            }
        }
    }

    writeFooter();
?>
