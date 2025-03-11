<?php
    session_start();
    require("../include/lib.php");

    writeHeader();
	
		

    if(isset($_REQUEST["scelta"])) $sc = $_REQUEST["scelta"]; else $sc = null;

    if($_SESSION["logged"]){
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
            case "formNuovoCampionato": {
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nomeCampionato"], $_POST["genereCampionato"], $_POST["annoCampionato"])) {
                    $nomeCampionato = trim($_POST["nomeCampionato"]);
                    $genereCampionato = $_POST["genereCampionato"];
                    $annoCampionato = trim($_POST["annoCampionato"]);

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
                            if ($db->query($sqlInsert) === TRUE) {
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
                        <a href="campionati.php?scelta=lista" class="btn btn-secondary">Indietro</a>
                    </form>
                ');
                break;
            }

            case "lista": {
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
        }
    }

    writeFooter();
		
		
?>
