<?php
    session_start();
    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

    if($_SESSION["logged"]){
        writeMenu();

        echo('
            <style>
                body {
                    background-color: #121212;
                    color: #e0e0e0;
                }
                .container {
                    background-color: #1e1e1e;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
                }
                .form-control, .form-select {
                    background-color: #2a2a2a;
                    color: white;
                    border: 1px solid #444;
                }
                .form-control::placeholder {
                    color: #bbb;
                }
                .btn-success {
                    background-color: #388e3c;
                    border-color: #388e3c;
                }
                .btn-primary {
                    background-color: #1976d2;
                    border-color: #1976d2;
                }
                .btn-danger {
                    background-color: #d32f2f;
                    border-color: #d32f2f;
                }
                .table-dark {
                    background-color: #1e1e1e;
                    color: #e0e0e0;
                }
                .blue-dot {
                    color: #00aaff;
                }
                .pink-dot {
                    color: #ff69b4;
                }
            </style>
        ');

        switch($sc){

            case "listaSquadra": {
                echo("aggiungere listaSquadra");
                break;
            }
        }
    }

    writeFooter();
?>
