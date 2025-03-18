<?php
    session_start();
    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

        writeMenu(0);

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
                                <a href="campionatiGuest.php?scelta=vediCampionato&idCampionato='.$record['id'].'">
                                    <button type="button" class="btn btn-primary">Visualizza</button>
                                </a>
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
                $sql = "SELECT nome FROM campionati c WHERE c.id = '$idC'";
                $resultSet = $db->query($sql);
                $record = $resultSet->fetch_assoc();
                echo('
                    <p class="h1" style="text-align: center; font-weight: bold">'.$record['nome'].'</p>
                    <table class="table table-dark table-striped table-hover ">
                        <caption>Lista delle squadre</caption>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Azioni</th>
                                </tr>
                            </thead>
                            <tbody> 
                ');
                $sql = "SELECT id, nome FROM squadre s WHERE s.id_Campionato = '$idC'";
                $resultSet = $db->query($sql);
                while($record = $resultSet->fetch_assoc()){
                    echo('<tr>
                            <th scope="row">'.$record['id'].'</th>
                            <td>'.$record['nome'].'</td>
                            <td>
                                <a href="atletiGuest.php?scelta=vediAtleti&idSquadra='.$record['id'].'">
                                    <button type="button" class="btn btn-primary">Visualizza</button>
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
