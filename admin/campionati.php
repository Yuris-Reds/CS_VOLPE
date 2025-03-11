<?php
    session_start();

    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;
    
    if($_SESSION["logged"]){
        writeMenu();

        switch($sc){
            case "formNuovoCampionato": {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nomeCampionato"], $_POST["genereCampionato"], $_POST["annoCampionato"])) {
        $nomeCampionato = trim($_POST["nomeCampionato"]);
        $genereCampionato = $_POST["genereCampionato"]; // Ora può essere "M" o "F"
        $annoCampionato = trim($_POST["annoCampionato"]);

        if (!empty($nomeCampionato) && ($genereCampionato == "M" || $genereCampionato == "F") && preg_match('/^\d{4}-\d{4}$/', $annoCampionato)) {
            $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);

            if ($db->connect_error) {
                die("Connessione fallita: " . $db->connect_error);
            }

            // Controllo se il campionato esiste già
            $sqlCheck = "SELECT COUNT(*) as count FROM Campionati WHERE nome = '$nomeCampionato' AND genere = '$genereCampionato' AND anno = '$annoCampionato'";
            $resultCheck = $db->query($sqlCheck);
            $rowCheck = $resultCheck->fetch_assoc();

            if ($rowCheck["count"] > 0) {
                echo '<div class="alert alert-warning">Il campionato esiste già.</div>';
            } else {
                // Inserimento del nuovo campionato
                $sqlInsert = "INSERT INTO Campionati (nome, genere, anno) VALUES ('$nomeCampionato', '$genereCampionato', '$annoCampionato')";
                if ($db->query($sqlInsert) === TRUE) {
                    echo '<div class="alert alert-success">Campionato aggiunto con successo!</div>';
                } else {
                    echo '<div class="alert alert-danger">Errore nell\'inserimento del campionato: ' . $db->error . '</div>';
                }
            }
            $db->close();
        } else {
            echo '<div class="alert alert-danger">Dati inseriti non validi. Assicurati che l\'anno sia nel formato "2024-2025".</div>';
        }
    }

    // Form per aggiungere un nuovo campionato
    echo('
        <h2 class="text-center">Aggiungi un nuovo Campionato</h2>
        <form action="campionati.php?scelta=formNuovoCampionato" method="post" class="container mt-3">
            <div class="mb-3">
                <label for="nomeCampionato" class="form-label">Nome Campionato:</label>
                <input type="text" class="form-control" id="nomeCampionato" name="nomeCampionato" required>
            </div>
            <div class="mb-3">
                <label for="genereCampionato" class="form-label">Genere:</label>
                <select class="form-select" id="genereCampionato" name="genereCampionato" required>
                    <option value="M" selected>Maschile</option>
                    <option value="F">Femminile</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="annoCampionato" class="form-label">Anno (formato xxxx-yyyy):</label>
                <input type="text" class="form-control" id="annoCampionato" name="annoCampionato" pattern="^\d{4}-\d{4}$" maxlength="9" required>
            </div>
            <button type="submit" class="btn btn-success">Aggiungi Campionato</button>
            <a href="campionati.php?scelta=lista" class="btn btn-secondary">Indietro</a>
        </form>
    ');
    break;
}

case "lista": {
    $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
    $sql = "SELECT * FROM Campionati";
    $resultSet = $db->query($sql);

    echo('<table class="table table-striped table-hover">
        <caption>Lista dei Campionati</caption>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Genere</th>
            </tr>
        </thead>
        <tbody>
    ');
    
    while ($record = $resultSet->fetch_assoc()) {
        $color = ($record['genere'] == 'M') ? '#007bff' : '#ff69b4'; // Blu per M, Rosa per F
        $pallino = '<span style="display:inline-block; width:10px; height:10px; background-color:'.$color.'; border-radius:50%; margin-right:5px;"></span>';
        
        echo('<tr>
                <th scope="row">'.$record['id'].'</th>
                <td>'.$pallino.$record['nome'].'</td>
                <td>'.$record['genere'].'</td>
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