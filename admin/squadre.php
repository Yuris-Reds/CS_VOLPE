<?php
    session_start();
    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

    if($_SESSION["logged"]){
        writeMenu('a');

        switch($sc){
            case "formNuovaSquadra": {
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nomeSquadra"], $_POST["campionato"])) {
                    $nomeSquadra = $_POST["nomeSquadra"];
                    $campionato = $_POST["campionato"];

                    $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
                    $sql = "INSERT INTO Squadre(nome, id_campionato) VALUES ('$nomeSquadra', '$campionato')";
                    if ($db->query($sql) == TRUE) {
                        echo '<div class="alert alert-success">Squadra aggiunta con successo!</div>';
                    } 
                    else {
                        echo '<div class="alert alert-danger">Errore: ' . $db->error . '</div>';
                    }
                    $db->close();
                }

                echo('
                    <h2 class="text-center">Aggiungi una nuova squadra</h2>
                    <form action="squadre.php?scelta=formNuovaSquadra" method="post" class="container mt-3">
                        <div class="mb-3">
                            <label for="nomeSquadra" class="form-label">Nome Squadra:</label>
                            <input type="text" class="form-control" id="nomeSquadra" name="nomeSquadra" required>
                        </div>
                        <div class="mb-3">
                            <label for="campionato" class="form-label">Campionato:</label>
                            <select class="form-select" id="campionato" name="campionato" required>
                ');
                $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
                $sql = "SELECT * FROM campionati";
                $resultSet = $db->query($sql);
                $db->close();
                while($record = $resultSet->fetch_assoc()){
                    echo('<option value="'.$record['id'].'" selected>'.$record['nome'].'</option>');
                }
                echo('
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Aggiungi Squadra</button>
                        <a href="squadre.php?scelta=listaSquadre" class="btn btn-secondary">Indietro</a>
                    </form>
                ');
                break;
            }

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
                                    <a href="atleti.php?scelta=vediAtleti&idSquadra='.$record['id'].'">
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
    }

    writeFooter();
?>
