<?php
    session_start();
    if(!isset($_SESSION['logged'])) $_SESSION['logged'] = false;
    if(!isset($_REQUEST['scelta'])) $sc = null; else $sc = $_REQUEST['scelta'];

    // includo la libreria con funzioni necessarie all'interfaccia.
    require('../include/lib.php');
    // richiamo la funzione per la creazione della sezione iniziale delle pagine
    writeHeader();
	
    // arrivo alla pagina dopo aver inserito le credenziali
    // per eseguire un login come admin. (ci arrivo da un form).
    if($sc == "login"){
        $u = $_REQUEST['username'];
        $p = $_REQUEST['password'];
        $db = new mysqli($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
        $sql = "SELECT * FROM admin WHERE username = '$u' AND password ='".md5($p)."'";
        
        $resultSet = $db->query($sql);
        $db->close();

        if($resultSet->num_rows == 1){
            $record = $resultSet->fetch_assoc();
            $_SESSION['logged'] = true;
            $_SESSION['idAdmin'] = $record['id'];
            //$_SESSION['cognome'] = $record['cognome'];
            //$_SESSION['nome'] = $record['nome'];
        }
        // if($u == "admin" && $p=="admin"){
        //     $_SESSION['logged'] = true;
        // }
        // else{
        //     echo('<div class="alert alert-warning">Credenziali non valide</div>');
        // }
    }
    if($sc == "logout"){
        $_SESSION['logged'] = false;
        session_destroy();
    }

    if($_SESSION['logged'] == true){ // se sono loggato mostro il gestionale con menu.
        //echo('Admin: '.$_SESSION['idAdmin']." ".$_SESSION['cognome']." ".$_SESSION['nome']);
        writeMenu();
        // << your code start here >>
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
            echo('<div class="alert alert-success">Autenticazione avvenuta con successo.</div>');

        // << end of your code >>
    }
    else{
        // non sono loggato quindi mostro il form per eventuale login
        echo('
            <form action="index.php" method="post">
                <div class="mb-3">
                    <label for="inputUsername" class="form-label">Username:</label>
                    <input type="text" name="username" class="form-control form-control-sm" id="inputUsername" aria-describedby="descrizioneHelp">
                    <label for="inputPassword" class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control form-control-sm" id="inputPassword" aria-describedby="descrizioneHelp">
            </div>
                    <input type="hidden" name="scelta" value="login">
                    <button type="submit" class="btn btn-primary">Submit</button>
            </form>');
    }
    // richiamo la funzione per la creazione della sezione finale delle pagine.

    writeFooter();
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
?>