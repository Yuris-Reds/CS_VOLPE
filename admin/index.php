<?php
    session_start();
    if(!isset($_SESSION['logged'])) $_SESSION['logged'] = false;
	//if(!isset($_SESSION['GuestLogged'])) $_SESSION['GuestLogged'] = false;
    if(!isset($_REQUEST['scelta'])) $sc = null; else $sc = $_REQUEST['scelta'];

    require('../include/lib.php');

    writeHeader();
	
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
        }
    }
    if($sc == "logout"){
        $_SESSION['logged'] = false;
        session_destroy();
    }
	
	if($sc == "guest"){
        $_SESSION['GuestLogged'] = true;
		writeMenu(0);
		require('../guest/campionatiGuest.php');
		echo('<div class="alert alert-success">Autenticazione come GUEST avvenuta con successo.</div>');
    }


    if($_SESSION['logged'] == true){ 
        writeMenu('a');
        echo('<div class="alert alert-success">Autenticazione avvenuta con successo.</div>');
    }
    else{
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
			
			<form action="../guest/campionatiGuest.php" method="get"  >
                    <button type="submit" class="btn btn-success" name="scelta" value="guest">Accedi come guest</button>
										
            </form>'
			);
    }

    writeFooter();
?>