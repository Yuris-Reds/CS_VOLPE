<?php
    session_start();
    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

    if($_SESSION["logged"]){
        writeMenu('a');

        switch($sc){
            case "formNuoviAtleti": {
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["squadra"], $_POST["nomeAtleta"], $_POST["cognomeAtleta"], $_POST["data"])) {

                    $squadra = $_POST["squadra"];
                    $nomeAtleta = $_POST["nomeAtleta"];                    
                    $cognomeAtleta = $_POST["cognomeAtleta"]; 
                    $dataNascita = $_POST["data"];                   

                    $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
                    $sql = "INSERT INTO Atleti(nome, cognome, dataNascita, id_squadra) VALUES ('$nomeAtleta', '$cognomeAtleta', '$dataNascita', '$squadra')";
                    if ($db->query($sql) == TRUE) {
                        echo '<div class="alert alert-success">Atleta aggiunto con successo!</div>';
                    } 
                    else {
                        echo '<div class="alert alert-danger">Errore: ' . $db->error . '</div>';
                    }
                    $db->close();
                }

                echo('
                    <h2 class="text-center">Aggiungi un nuovo atleta</h2>
                    <form action="atleti.php?scelta=formNuoviAtleti" method="post" class="container mt-3">
                        <div class="mb-3">
                            <label for="nomeAtleta" class="form-label">Nome Atleta:</label>
                            <input type="text" class="form-control" id="nomeAtleta" name="nomeAtleta" required>
                        </div>
                        <div class="mb-3">
                            <label for="cognomeAtleta" class="form-label">Cognome Atleta:</label>
                            <input type="text" class="form-control" id="cognomeAtleta" name="cognomeAtleta" required>
                        </div>
                        <div class="mb-3">
                            <label for="squadra" class="form-label">Squadra:</label>
                            <select class="form-select" id="squadra" name="squadra" required>
                ');
                $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
                $sql = "SELECT * FROM Squadre";
                $resultSet = $db->query($sql);
                $db->close();

                while($record = $resultSet->fetch_assoc()){
                    echo('<option value="'.$record['id'].'" selected>'.$record['nome'].'</option>');
                }
                echo('
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="data" class="form-label">Data di nascita:</label>
                            <input type="date" class="form-control" id="data" name="data" required>
                        </div>
                        <button type="submit" class="btn btn-success">Aggiungi Atleta</button>
                        <a href="atleti.php?scelta=vediTuttiAtleti" class="btn btn-secondary">Indietro</a>
                    </form>
                ');
                break;
            }

            case 'vediTuttiAtleti': {
                $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
                $sql = "SELECT * FROM Atleti";
                $resultSet = $db->query($sql);
                echo('
                    <p class="h1" style="text-align: center; font-weight: bold">Atleti</p>
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
    }

    writeFooter();
?>
