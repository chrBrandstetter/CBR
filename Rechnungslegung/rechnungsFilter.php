<?php 
require("includes/common.inc.php");
require("includes/conn.inc.php");

function zeigeRechnung($filterInput){
    global $conn; 
    $sql="SELECT 
    tbl_rechnungen.Rechnungsnummer,
    tbl_rechnungen.IDRechnung, 
    tbl_rechnungen.Rechnungsdatum, 
    tbl_versand_paket.Kosten,
    tbl_kunden.Nachname, 
    tbl_ustsaetze.UstSatz
    FROM tbl_rechnungen
    INNER JOIN tbl_versand_paket ON tbl_versand_paket.IDVersandPaket = tbl_rechnungen.FIDVersandPaket
    INNER JOIN tbl_ustsaetze On tbl_ustsaetze.IDUStSatz = tbl_versand_paket.FIDUStSatz
    INNER JOIN tbl_kunden ON tbl_kunden.IDKunde = tbl_rechnungen.FIDKunde
    WHERE (
        tbl_kunden.Nachname LIKE '%".$filterInput."%' OR 
        tbl_rechnungen.Rechnungsnummer LIKE '%".$filterInput."%'
        )
        ";
    ta($sql);
    $rechnungen = $conn->query($sql) or die ("Hier ist ein fehler: ".$conn->error);
    while($rechnung = $rechnungen->fetch_object()){
        echo('<li>Rechnung Nr.: '.$rechnung->Rechnungsnummer.'<br>Rechnungsdatum: '.$rechnung->Rechnungsdatum.'<br>Nachname: '.$rechnung->Nachname.'</li>');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <label>Filtern nach Nachname:</label>
        <input type="text" name="NN">
        <label>Filtern nach Rechnungsnummer:</label>
        <input type="text" name="Rechnungsnummer">
        <input type="submit" value="FILTERN">
        
        <?php 
        ta($_POST);
        if(count($_POST) > 0 && $_POST["NN"] != ""){
            zeigeRechnung($_POST["NN"]);
        }
        if(count($_POST) > 0 && $_POST["Rechnungsnummer"] != ""){
            zeigeRechnung($_POST["Rechnungsnummer"]);
        }
        if(count($_POST) > 0 && $_POST["NN"] == "" && $_POST["Rechnungsnummer"]=="" ){
            echo('<br>Bitte geben Sie ein Suchkriterium ein'); 
        }
        ?>
    </form>
</body>
</html>