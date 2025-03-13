<?php
    session_start();
    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

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


            case "listaCampionati": {
                $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
                $sql = "SELECT * FROM Campionati";
                $resultSet = $db->query($sql);

                echo('<h2 class="text-center mt-4">Lista dei Campionati</h2>
                <table class="table table-dark table-striped table-hover">
                    <caption>Lista dei Campionati</caption>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Genere</th>
                            <th>Anno</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                ');

                while ($record = $resultSet->fetch_assoc()) {
                    $iconaGenere = ($record['genere'] == 'M') 
                        ? '<span class="blue-dot">●</span>'  
                        : '<span class="pink-dot">●</span>'; 

                    echo('<tr>
                            <th scope="row">'.$record['id'].'</th>
                            <td>'.$record['nome'].' '.$iconaGenere.'</td>
                            <td>'.$record['genere'].'</td>
                            <td>'.$record['anno'].'</td>
                            <td>
                                <a href="campionati.php?scelta=vediCampionato&idCampionato='.$record['id'].'">
                                    <button type="button" class="btn btn-primary">Visualizza</button>
                                </a>
                                <a href="campionati.php?scelta=cancellaCampionato&idCampionato='.$record['id'].'">
                                    <button type="button" class="btn btn-danger">Cancella</button>
                                </a>
                            </td>
                        </tr>');  
                }

                echo('</tbody>
                </table>');
                $db->close();
                break;
            }
            
            case "vediCampionato": {
                $idC = $_REQUEST['idCampionato'];
                $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
                $sql = "SELECT id, nome FROM squadre s WHERE s.id_Campionato = '$idC'";
                $resultSet = $db->query($sql);



                
                echo('
                    <p class="h1" style="text-align: center; font-weight: bold">Serie A Enilive</p>
                    <table class="table table-striped table-hover ">
                    <caption>Lista delle squadre</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                        </tr>
                    </thead>
                    <tbody> 
                ');

// <p class="h1" style="text-align: center; font-weight: bold">'.$nome.'</p> --> trovare il modo (tramite query??) di far comparire il nome del campionato come titolo


                while($record = $resultSet->fetch_assoc()){
                    echo('<tr>
                            <th scope="row">'.$record['id'].'</th>
                            <td>'.$record['nome'].'</td>
                            <td>
                                <a href="atleti.php?scelta=vediAtleti&idSquadra='.$record['id'].'">
                                    <button type="button" class="btn btn-primary">Visualizza</button>
                                </a>
                            </td>
                            <td>
                                <a href="campionati.php?scelta=cancellaSquadra&idSquadra='.$record['id'].'">
                                    <button type="button" class="btn btn-primary">Cancella</button>
                                </a>
                            </td>
                        </tr>
                    ');  
                }
                echo('</tbody>
                </table>');
                $db->close();
                break;
            }
        }
    

    writeFooter();
?>
