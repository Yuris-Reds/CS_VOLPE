<?php
    session_start();
    if(!isset($_SESSION['logged'])) $_SESSION['logged'] = false;
    if(!isset($_REQUEST['scelta'])) $sc = null; else $sc = $_REQUEST['scelta'];
	
	if(!isset($_SESSION['logged'])) $_SESSION['logged'] = false;
    if(!isset($_REQUEST['scelta'])) $sc = null; else $sc = $_REQUEST['scelta'];
	
	if(!isset($_SESSION['GuestLogged'])) $_SESSION['GuestLogged'] = false;
    if(!isset($_REQUEST['scelta'])) $sc = null; else $sc = $_REQUEST['scelta'];

    // includo la libreria con funzioni necessarie all'interfaccia.
    require('../include/lib.php');
    // richiamo la funzione per la creazione della sezione iniziale delle pagine
    writeHeader();
	
    // arrivo alla pagina dopo aver inserito le credenziali
    // per eseguire un login come admin. (ci arrivo da un form).
	
	if($sc == "guest"){
        $_SESSION['GuestLogged'] = true;
		writeMenu();
		require('../guest/campionatiGuest.php');
		echo('<div class="alert alert-success">Autenticazione come GUEST avvenuta con successo.</div>');
    }


    if($_SESSION['logged'] == true){ // se sono loggato mostro il gestionale con menu.
        //echo('Admin: '.$_SESSION['idAdmin']." ".$_SESSION['cognome']." ".$_SESSION['nome']);
        writeMenu();
        // << your code start here >>
		
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
					<br /><br />
					
            </form>
			
			<form action="../guest/indexGuest.php" method="get"  >
                    <button type="submit" class="btn btn-success" name="scelta" value="guest">Accedi come guest</button>
										
            </form>'
			);
    }
    // richiamo la funzione per la creazione della sezione finale delle pagine.

    writeFooter();
?>