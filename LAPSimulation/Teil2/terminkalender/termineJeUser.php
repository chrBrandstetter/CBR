<?php 
require("includes/common.inc.php");
require("includes/conn.inc.php"); 
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Termine je User</title>
</head>
<body>
    <h1>Navigation</h1>
    <nav>
        <ul>
            <li><a href="index.html">Zurück zur Startseite</a></li>
            <li><a href="alleTermine.php">Hier geht es zu allen Terminen</a></li>
            <li><a href="einladungen.php">Hier geht es zu den Einladungen</a></li>
        </ul>
    </nav>
    <h1>Termine je User</h1>
    <ul>
        <?php 
        $sql = "SELECT
        tbl_user.Emailadresse,
        tbl_user.IDUser, 
        tbl_user.Nickname,
        tbl_user.Vorname, 
        tbl_user.Notiz
        FROM tbl_user
        ORDER BY Nickname ASC"; 

        $allUser = $conn->query($sql) or die ("Fehler in der SQL Query: ".$conn->error.""); 
        while($user = $allUser->fetch_object()){
            echo('<li>'.$user->Nickname.' <a href="mailto:'.$user->Emailadresse.'">('.$user->Emailadresse.')</a><br>'.$user->Vorname.'<br>'.$user->Notiz.'</li>'); 

            $sql = "SELECT 
            tbl_termine.*, 
            tbl_kategorien.Farbcode,
            tbl_staaten.Bezeichnung AS BezStaat
            FROM tbl_termine
            INNER JOIN tbl_staaten ON tbl_staaten.IDStaat = tbl_termine.FIDStaat
            INNER JOIN tbl_kategorien ON tbl_kategorien.IDKategorie = tbl_termine.FIDKategorie
            WHERE (
                tbl_termine.FIDUser = $user->IDUser
            )
            ORDER BY Beginn ASC"; 

            $termine = $conn->query($sql) or die ("Fehler im zweiten SQL Statement: ".$conn->error."");
            while($termin = $termine->fetch_object()){
                echo('<div style="background-color: #'.$termin->Farbcode.'">');
                echo('von: '.date("d-m-Y H:i", strtotime($termin->Beginn)).' Uhr bis: '.date("d-m-Y H:i", strtotime($termin->Ende)).' Uhr<br>
                <b>'.$termin->Bezeichnung.'</b><br>'.$termin->PLZ.' '.$termin->Ort.'<br>'.$termin->BezStaat.''); 
                echo('</div><br>'); 
            } 
        }
        ?>
    </ul>
</body>
</html>