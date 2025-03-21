<?php
    session_start();
    require("../include/lib.php");

    writeHeader();

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

    if($_SESSION["logged"]){
        writeMenu('a');

        switch($sc){
            case "formNuovoCampionato": {
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nomeCampionato"], $_POST["genereCampionato"], $_POST["annoCampionato"])) {
                    $nomeCampionato = $_POST["nomeCampionato"];
                    $genereCampionato = $_POST["genereCampionato"];
                    $annoCampionato = $_POST["annoCampionato"];

                    if (!empty($nomeCampionato) && ($genereCampionato == "M" || $genereCampionato == "F") && preg_match('/^\d{4}-\d{4}$/', $annoCampionato)) {
                        $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);

                        if ($db->connect_error) {
                            die("Connessione fallita: " . $db->connect_error);
                        }

                        $sqlCheck = "SELECT COUNT(*) as count FROM Campionati WHERE nome = '$nomeCampionato' AND genere = '$genereCampionato' AND anno = '$annoCampionato'";
                        $resultCheck = $db->query($sqlCheck);
                        $rowCheck = $resultCheck->fetch_assoc();

                        if ($rowCheck["count"] > 0) {
                            echo '<div class="alert alert-warning">Il campionato esiste già.</div>';
                        } else {
                            $sqlInsert = "INSERT INTO Campionati (nome, genere, anno) VALUES ('$nomeCampionato', '$genereCampionato', '$annoCampionato')";
                            if ($db->query($sqlInsert) == TRUE) {
                                echo '<div class="alert alert-success">Campionato aggiunto con successo!</div>';
                            } else {
                                echo '<div class="alert alert-danger">Errore: ' . $db->error . '</div>';
                            }
                        }
                        $db->close();
                    } else {
                        echo '<div class="alert alert-danger">Dati non validi. Assicurati che l\'anno sia nel formato "2024-2025".</div>';
                    }
                }

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
                        <a href="campionati.php?scelta=listaCampionati" class="btn btn-secondary">Indietro</a>
                    </form>
                ');
                break;
            }

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
            case "cancellaCampionato": {
                $idC = $_REQUEST['idCampionato'];
                $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
                $sql = "UPDATE squadre SET id_campionato = null WHERE id_campionato = '$idC'"; 
                $db->query($sql);
                $sql = "DELETE FROM campionati WHERE campionati.id = '$idC'";
                $db->query($sql);
                if($db->query($sql)){
                    echo('<div class="alert alert-success">Campionato eliminato con successo.</div>');
                }
                else{
                    echo('<div class="alert alert-warning">Errore in fase di eliminazione.</div>');
                }
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
                                <a href="atleti.php?scelta=vediAtleti&idSquadra='.$record['id'].'">
                                    <button type="button" class="btn btn-primary">Visualizza</button>
                                </a>
                                <a href="campionati.php?scelta=cancellaSquadra&idSquadra='.$record['id'].'">
                                    <button type="button" class="btn btn-danger">Cancella</button>
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
            case "cancellaSquadra": {
                $idS = $_REQUEST['idSquadra'];
                $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
                $sql = "UPDATE allenatori SET id_squadra = null WHERE id_squadra = '$idS'";
                $db->query($sql);
                $sql = "UPDATE atleti SET id_squadra = null WHERE id_squadra = '$idS'";
                $db->query($sql);
                $sql = "DELETE FROM squadre WHERE squadre.id = '$idS'";
                $resultSet = $db->query($sql);
                if($db->query($sql)){
                    echo('<div class="alert alert-success">Squadra eliminata con successo.</div>');
                }
                else{
                    echo('<div class="alert alert-warning">Errore in fase di eliminazione.</div>');
                }
                break;
            }
        }
    }

    writeFooter();
?>
