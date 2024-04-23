<?php 
require("includes/common.inc.php"); 
require("includes/conn.inc.php"); 
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Alle Termine</title>
</head>
<body>
    <h1>Navigation</h1>
        <nav>
            <ul>
                <li><a href="index.html">Zurück zur Startseite</a></li>
                <li><a href="termineJeUser.php">Hier geht es zu allen Terminen je User</a></li>
                <li><a href="einladungen.php">Hier geht es zu den Einladungen</a></li>
            </ul>
        </nav>
    <h1>Alle Termine</h1>
    <form method="post">
        <label for="dropDownList">Terminekategorie:</label>
        <select name="kategorien">
            <option value="Privat">Privat</option>
            <option value="Arbeit">Arbeit</option>
            <option value="Urlaub">Urlaub</option>
            <option value="Wifi">Wifi</option>
            <option value="Uni">Uni</option>
            <option value="Training">Training</option>
        </select>
        <label for="terminbezeichnung">Terminbezeichnung:</label>
        <input type="text" name="terminbezeichnung">
        <label for="NicknameOdMail">Nickname/Emailadresse:</label>
        <input type="text" name="NicknameOdMail">
        <label for="datum">Datum:</label>
        <label for="datumVon">von</label>
        <input type="date" name="datumVon">
        <label for="datumBis">bis</label>
        <input type="date" name="datumBis">
        <input type="submit" value="Filtern">
    </form>
    <?php 
    ta($_POST); 

    $where = ""; 
    //konnte hier die doppeldbenennung der Bezeichnungen nicht lösen
    //mit dem AS Statement scheint es nicht zu funktionieren
    if(count($_POST)>0){
        $arr = [];
        if($_POST["kategorien"] != ""){
            $arr[] = "tbl_kategorien.BezKategorie = '".$_POST["kategorien"]."'"; 
        }
        if($_POST["terminbezeichnung"] != ""){
            $arr[] = "Bezeichnung LIKE '%".$_POST["terminbezeichnung"]."%'"; 
        }
        if($_POST["NicknameOdMail"] != ""){
            $arr[] = "Emailadresse = '".$_POST["NicknameOdMail"]."' OR Nickname = '".$_POST["NicknameOdMail"]."' "; 
        }
        if($_POST["datumVon"] != ""){
            $arr[] = "Beginn = '".$_POST["datumVon"]."'"; 
        }
        if($_POST["datumBis"] != ""){
            $arr[] = "Ende = '".$_POST["datumVon"]."'"; 
        }
        if(count($arr)>0){
            $where = "WHERE (
                ".implode("AND ", $arr)."
            )"; 
        }
        ta($arr);
    }

    $sql="SELECT
    tbl_termine.*, 
    tbl_user.Nickname, 
    tbl_user.Emailadresse, 
    tbl_kategorien.Bezeichnung AS BezKategorie, 
    tbl_kategorien.Farbcode,
    tbl_staaten.Bezeichnung AS BezStaat
    FROM tbl_termine
    INNER JOIN tbl_user ON tbl_user.IDUser = tbl_termine.FIDUser
    INNER JOIN tbl_kategorien ON tbl_kategorien.IDKategorie = tbl_termine.FIDKategorie
    INNER JOIN tbl_staaten ON tbl_staaten.IDStaat = tbl_termine.FIDStaat
    ".$where."
    ";
    ta($sql); 
    $termine = $conn->query($sql) or die ("Fehler im SQL Statement: ".$conn->error."");
    while($termin = $termine->fetch_object()){
        echo('<div style="background-color: #'.$termin->Farbcode.'">');
        echo('<b>'.$termin->Nickname.'</b><br>von: '.date("d-m-Y H:i", strtotime($termin->Beginn)).' Uhr bis: '.date("d-m-Y H:i", strtotime($termin->Ende)).' Uhr<br>
        <b>'.$termin->Bezeichnung.'</b><br>'.$termin->PLZ.' '.$termin->Ort.'<br>'.$termin->BezStaat.''); 
        echo('</div><br>'); 
    } 
    ?>
</body>
</html>