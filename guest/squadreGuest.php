<?php
    session_start();
    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

    writeMenu(0);

    switch($sc){
        case "listaSquadra": {
            $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
            $sql = "SELECT * FROM squadre";
            $resultSet = $db->query($sql);
            
            echo('
                <table class="table table-dark table-striped table-hover ">
                    <caption>Lista delle squadre</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Campionato</th>
                            <th scope="col">Azioni</th>
                        </tr>
                    </thead>
                    <tbody> 
                    ');
                    while($record = $resultSet->fetch_assoc()){
                        echo('
                            <tr>
                                <th scope="row">'.$record['id'].'</th>
                                <td>'.$record['nome'].'</td>
                                <td>'.$record['id_campionato'].'</td>
                                <td>
                                    <a href="atletiGuest.php?scelta=vediAtleti&idSquadra='.$record['id'].'">
                                        <button type="button" class="btn btn-primary">Visualizza</button>
                                    </a>
                                </td>
                            </tr>
                            ');
                        }
                        echo('
                    </tbody>
                ');  
            $db->close();
            break;
        }
    }

    writeFooter();
?>
