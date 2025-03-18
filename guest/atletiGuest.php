<?php
    session_start();
    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

    writeMenu(0);

    switch($sc){
        case "vediAtleti": {
            $idS = $_REQUEST['idSquadra'];
            $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
            $sql = "SELECT nome FROM squadre s WHERE s.id = '$idS'";
            $resultSet = $db->query($sql);
            $record = $resultSet->fetch_assoc();
            echo('
                <p class="h1" style="text-align: center; font-weight: bold">'.$record['nome'].'</p>
                <table class="table table-dark table-striped table-hover ">
                    <caption>Lista degli atleti</caption>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Cognome</th>
                                <th scope="col">Data di Nascita</th>
                            </tr>
                        </thead>
                        <tbody> 
            ');
            $sql = "SELECT * FROM atleti a WHERE a.id_squadra = '$idS'";
            $resultSet = $db->query($sql);
            while($record = $resultSet->fetch_assoc()){
                echo('
                    <tr>
                        <th scope="row">'.$record['matricola'].'</th>
                        <td>'.$record['nome'].'</td>
                        <td>'.$record['cognome'].'</td>
                        <td>'.$record['dataNascita'].'</td>
                    </tr>
                ');  
            }
            $db->close();
            break;
        }
    }
    

    writeFooter();
?>
