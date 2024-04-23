<?php 
require("includes/common.inc.php");
require("includes/conn.inc.php");
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Rechnungsdaten</title>
</head>
<body>
    <ul>
        <?php
        
        $sumPositionen = 0; 
        $sumUst = 0; 
        $sumAll = 0;
        $sumAllUst = 0;  
        $sql="SELECT 
        tbl_rechnungen.Rechnungsnummer,
        tbl_rechnungen.IDRechnung, 
        tbl_rechnungen.Rechnungsdatum, 
        tbl_versand_paket.Kosten,
        tbl_ustsaetze.UstSatz
        FROM tbl_rechnungen
        INNER JOIN tbl_versand_paket ON tbl_versand_paket.IDVersandPaket = tbl_rechnungen.FIDVersandPaket
        INNER JOIN tbl_ustsaetze On tbl_ustsaetze.IDUStSatz = tbl_versand_paket.FIDUStSatz
        ";
        ta($sql);
        $rechnungen = $conn->query($sql) or die ("Hier ist ein fehler: ".$conn->error);
        while($rechnung = $rechnungen->fetch_object()){
            echo('<li>Rechnung Nr.: '.$rechnung->Rechnungsnummer.'<br>Rechnungsdatum: '.$rechnung->Rechnungsdatum.'</li>');

            $sql = "SELECT 
            tbl_bestelldetails.*, 
            tbl_produkte.Produktbezeichnung, 
            tbl_produkte.Beschreibung, 
            tbl_produkte.PreisExkl,
            tbl_ustsaetze.UstSatz
            FROM tbl_bestelldetails
            INNER JOIN tbl_produkte ON tbl_produkte.IDProdukt = tbl_bestelldetails.FIDProdukt
            INNER JOIN tbl_ustsaetze ON tbl_ustsaetze.IDUStSatz = tbl_produkte.FIDUStSatz
            WHERE (
                FIDRechnung = $rechnung->IDRechnung 
            )
            ";
            echo('<ul>');
            $produkte = $conn->query($sql) or die ("Fehler: ".$conn->error.""); 
            while($produkt = $produkte->fetch_object()){
                $currentSumUst = $produkt->PreisExkl * ($produkt->UstSatz / 100); 
                $sumPositionen += $produkt->PreisExkl * $produkt->Anzahl; 
                $sumUst += $currentSumUst * $produkt->Anzahl; 
                echo('<li>'.$produkt->Produktbezeichnung.' | Ihr Preis: '.$produkt->PreisExkl * $produkt->Anzahl.' inkl.: '.$currentSumUst.'</li>');
            }
            $sumAll += $sumPositionen + $rechnung->Kosten; 
            $sumAllUst += $sumUst + $rechnung->Kosten * ($rechnung->UstSatz / 100);
            echo('</ul>');
            echo('Positionen: '.$sumPositionen.' inkl. USt: '.$sumUst.'<br>');
            echo('Versand: '.$rechnung->Kosten.' inkl USt: '.$rechnung->Kosten * ($rechnung->UstSatz / 100).'<br>');
            echo('Gesamt:'.$sumAll.' inkl USt: '.$sumAllUst.'');
            echo('<br><br><b>Ihre Adressdaten:</b><br>');
            
            $sql = "SELECT 
            tbl_kunden.*,
            tbl_staaten.Staat
            FROM tbl_kunden
            INNER JOIN tbl_staaten ON tbl_staaten.IDStaat = tbl_kunden.FIDStaat
            ";
            
            $adressen = $conn->query($sql) or die ("Fehler in der Query: ".$conn->error.""); 
            while($adresse = $adressen->fetch_object()){
                echo('<b>Rechnungsadresse:</b> <br>'.$adresse->Adresse.', '.$adresse->PLZ.' '.$adresse->Ort.'<br>'.$adresse->Staat.'<br><br>');
                echo('<b>Lieferadresse:</b> <br>'.$adresse->Adresse.', '.$adresse->PLZ.' '.$adresse->Ort.'<br>'.$adresse->Staat.'');
            }
        }
        ?>
    </ul>
</body>
</html>