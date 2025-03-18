<?php
    session_start();
    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

    if($_SESSION["logged"]){
        writeMenu('a');

        switch($sc){
            case "formNuovaSquadra": {
                echo("aggiungere form");
                break;
            }

            case "listaSquadra": {
                echo("aggiungere listaSquadra");
                break;
            }
        }
    }

    writeFooter();
?>
