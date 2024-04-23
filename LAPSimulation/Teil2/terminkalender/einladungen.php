<?php 
require("includes/conn.inc.php");
require("includes/common.inc.php"); 
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Einladungen</title>
</head>
<body>
    <h1>Navigation</h1>
    <nav>
        <ul>
            <li><a href="index.html">Zurück zur Startseite</a></li>
            <li><a href="termineJeUser.php">Hier geht es zu allen Terminen je User</a></li>
            <li><a href="alleTermine.php">Hier geht es zu allen Terminen</a></li>
        </ul>
    </nav>
    <h1>Einladungen</h1>
    <?php
    $sql="SELECT 
    tbl_termine.*
    FROM tbl_termine"; 

    $termine = $conn->query($sql) or die ("Fehler in der Query: ".$conn->error."");
    while($termin = $termine->fetch_object()){
        $sql="SELECT 
        tbl_termine_einladungen.*,
        tbl_termine.*,
        tbl_user.IDUser, 
        tbl_user.Nickname,
        tbl_kategorien.Farbcode, 
        tbl_staaten.Bezeichnung AS BezStaat
        FROM tbl_termine_einladungen
        INNER JOIN tbl_termine ON tbl_termine.IDTermin = tbl_termine_einladungen.FIDTermin
        INNER JOIN tbl_staaten ON tbl_staaten.IDStaat = tbl_termine.FIDStaat 
        INNER JOIN tbl_user ON tbl_user.IDUser = tbl_termine.FIDUser
        INNER JOIN tbl_kategorien ON tbl_kategorien.IDKategorie = tbl_termine.FIDKategorie
        WHERE(
            FIDTermin = $termin->IDTermin
        )
        ";
        $einladungen = $conn->query($sql) or die ("Fehler in der zeiten Query: ".$conn->error.""); 
        while($einladung = $einladungen->fetch_object()){
            echo('<div style="background-color: #'.$einladung->Farbcode.'">');
            echo('<b>'.$einladung->Nickname.'</b><br>von: '.date("d-m-Y H:i", strtotime($einladung->Beginn)).' Uhr bis: '.date("d-m-Y H:i", strtotime($einladung->Ende)).' Uhr<br>
            <b>'.$einladung->Bezeichnung.'</b><br>'.$einladung->PLZ.' '.$einladung->Ort.'<br>'.$einladung->BezStaat.''); 
            //Habe hier versucht den Einladestatus und die Eingeladenen Personen auszugeben. War hier von der Datenbank leicht verwirrt deswegen ist die Ausgabe falsch. 
            $sql="SELECT 
            tbl_termine_einladungen.*,
            tbl_user.Nickname, 
            tbl_user.IDUser,
            tbl_einladungsstati.Bezeichnung AS bezStatus 
            FROM tbl_termine_einladungen
            INNER JOIN tbl_user ON tbl_user.IDUser = tbl_termine_einladungen.FIDUser
            INNER JOIN tbl_einladungsstati ON tbl_einladungsstati.IDEinladungsstatus = tbl_termine_einladungen.FIDEinladungsstatus
            WHERE (
                    FIDUser = $einladung->IDUser
            )"; 
            $eingeladene = $conn->query($sql) or die ("Fehler in der dritten Schleife"); 
            while($eingeladener = $eingeladene->fetch_object()){
                echo('<br>eingeladen sind: <br>'.$eingeladener->Nickname.': '.$eingeladener->bezStatus.' <br>');
            }
            echo('</div><br>');
        }
    }
    ?>
</body>
</html>