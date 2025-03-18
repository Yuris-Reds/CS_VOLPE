<?php

$DBHOST = "localhost";
$DBUSER = "root";
$DBPASSWORD = "root"; //!
$DBNAME = "cs_volpe";

function writeHeader(){
	
    echo('
        <!DOCTYPE HTML>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Gestionale Campionati</title>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                    <style>
                        body, caption{
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
                </head>
                <body>
                    <div class="container-fluid">
    ');
    return;
}

function writeFooter(){
    echo('
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
                </body>
            </html>');
    return;
}

function writeMenu($x){
    echo('
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img src="../IT-CONI.png" width="30px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                CAMPIONATI
                            </a>
                            <ul class="dropdown-menu">
                            ');
                            if($x == 'a'){
                                echo('<li><a class="dropdown-item" href="campionati.php?scelta=formNuovoCampionato">Nuovo campionato</a></li>');
                            }
                                echo('
                                <li><a class="dropdown-item" href="campionati.php?scelta=listaCampionati">Visualizza</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                SQUADRE
                            </a>
                            <ul class="dropdown-menu">
                            ');
                            if($x == 'a'){
                                echo('<li><a class="dropdown-item" href="squadre.php?scelta=formNuovaSquadra">Nuova squadra</a></li>');
                            }
                                echo('
                                <li><a class="dropdown-item" href="squadre.php?scelta=listaSquadra">Visualizza</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                ATLETI
                            </a>
                            <ul class="dropdown-menu">
                            ');
                            if($x == 'a'){
                                echo('<li><a class="dropdown-item" href="atleti.php?scelta=formNuoviAtleti">Nuovo/a atleta</a></li>');
                            }
                            echo('
                                <li><a class="dropdown-item" href="atleti.php?scelta=listaAtleti">Visualizza</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                ');
                if($x == 'a'){
                    echo('<a class="navbar-brand" href="index.php?scelta=logout">Esci</a>');
                }
                else{
                    echo('<a class="navbar-brand" href="../admin/index.php?scelta=logout">Esci</a>');
                }
                echo('
            </div>
        </nav>    
    ');

    return;
}
?>