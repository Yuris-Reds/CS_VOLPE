<?php
    session_start();

    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;
    
    if($_SESSION["logged"]){
        writeMenu();

        switch($sc){
            case "formNuovoCampionato": {
                echo("formNuovoCampionato");
                break;
            }
            case "lista": {
                $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
                $sql = "SELECT * FROM campionati";
                $resultSet = $db->query($sql);

                echo('<table class="table table-striped table-hover ">
                    <caption>Lista dei Campionati</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                        </tr>
                    </thead>
                    <tbody>
                ');
                    while($record = $resultSet->fetch_assoc()){
                        echo('<tr>
                                <th scope="row">'.$record['id'].'</th>
                                <td>'.$record['nome'].'</td>
                                <td>
                                    <a href="campionati.php?scelta=vediCampionato&idCampionato='.$record['id'].'">
                                        <button type="button" class="btn btn-primary">Visualizza</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="campionati.php?scelta=cancellaCampionato&idCampionato='.$record['id'].'">
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
    }

    writeFooter();
?>