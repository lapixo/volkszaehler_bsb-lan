<?php
$uuidDrehzahlKesselpumpe = '67fcfac0-50eb-11eb-8e56-6f5b7928bbb7';
$uuidKesseltemperatur = 'a7d437f0-50eb-11eb-a75b-e3fc496a0075';
$uuidKesselsollwert = '';
$uuidKesselschaltpunkt = '';
$uuidKesselruecklauftemperaturIst = 'c1a454a0-50eb-11eb-b605-6f3b0849b596';
$uuidBrennermodulation = 'ac563c00-50ee-11eb-935b-57defbcf6be1';
$uuidGeblaesedrehzahl = '';
$uuidWasserdruck = 'f09dfee0-50ee-11eb-8586-5b6efbf8888d';
$uuidAussentemperatur = '83103160-51a1-11eb-927d-6b541f75fb16';

$uuidIstTemperatur ='a869ea90-54ea-11eb-953f-37be69845d45';

$uuidIstTemperatur ='a869ea90-54ea-11eb-953f-37be69845d45';
$uuidSollTemperatur ='40c37d40-54eb-11eb-b9d6-e30ec995e83e';
$uuidWarmwasser ='0b5ff770-55fd-11eb-a36f-17b99ceb0b99';

$urlVZBase = 'http://localhost/middleware.php/data/';
$urlBSBLan = 'http://192.168.1.132/h7zTag615Gafha9/JQ=710,8308,8310,8311,8312,8314,8323,8326,8327,8700,8740,8741,8830';


$laufZeit = 60; // Sekunden die das Script laufen soll
$resolution = 30; // Wieviel Sekunden soll zwischen jeder Abfrage mindestens gewartet werden


$j = 1;

function curl_file_get_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) return $contents;
    else return FALSE;
} // function curl_get_file_contents

function getTimestamp()
{
    $seconds = microtime(true); // false = int, true = float
    return round(($seconds * 1000));
}

$gesamtStart = getTimestamp();

while ((getTimestamp() - $gesamtStart) < ($laufZeit * 1000)) {
    $minTimestamp = getTimestamp();
    $maxTimestamp = $minTimestamp;
    $t = getTimestamp();

    $timestamp = round($minTimestamp + (($maxTimestamp - $minTimestamp) / 2));

    $BSBStatus = file_get_contents($urlBSBLan);
    $jsongoStatus = json_decode($BSBStatus);
    //var_dump($jsongoStatus);

    $DrehzahlKesselpumpe = $jsongoStatus->{'8308'}->value;
    $Kesseltemperatur = $jsongoStatus->{'8310'}->value;
    $Kesselsollwert = $jsongoStatus->{'8311'}->value;
    $Kesselschaltpunkt = $jsongoStatus->{'8312'}->value;
    $KesselruecklauftemperaturIst = $jsongoStatus->{'8314'}->value;
    $Brennermodulation = $jsongoStatus->{'8326'}->value;
    $Geblaesedrehzahl = $jsongoStatus->{'8323'}->value;
    $Wasserdruck = $jsongoStatus->{'8327'}->value;
    $Aussentemperatur = $jsongoStatus->{'8700'}->value;

    $IstTemperatur = $jsongoStatus->{'8740'}->value;
    $SollTemperatur = $jsongoStatus->{'710'}->value;

    $WWTemperatur = $jsongoStatus->{'8830'}->value;

    if ($Brennermodulation == '---')
        $Brennermodulation = 0;

    if ($DrehzahlKesselpumpe == '---')
        $DrehzahlKesselpumpe = 0;

    $linkDV = $urlVZBase . $uuidDrehzahlKesselpumpe . '.json?operation=add&value=' . $DrehzahlKesselpumpe . '&ts=' . $timestamp;
    $dummy = curl_file_get_contents($linkDV);

    $linkDV = $urlVZBase . $uuidKesseltemperatur . '.json?operation=add&value=' . $Kesseltemperatur . '&ts=' . $timestamp;
    $dummy = curl_file_get_contents($linkDV);

    $linkDV = $urlVZBase . $uuidKesselruecklauftemperaturIst . '.json?operation=add&value=' . $KesselruecklauftemperaturIst . '&ts=' . $timestamp;
    $dummy = curl_file_get_contents($linkDV);

    $linkDV = $urlVZBase . $uuidBrennermodulation . '.json?operation=add&value=' . $Brennermodulation . '&ts=' . $timestamp;
    $dummy = curl_file_get_contents($linkDV);

    $linkDV = $urlVZBase . $uuidWasserdruck . '.json?operation=add&value=' . $Wasserdruck . '&ts=' . $timestamp;
    $dummy = curl_file_get_contents($linkDV);

    $linkDV = $urlVZBase . $uuidAussentemperatur . '.json?operation=add&value=' . $Aussentemperatur . '&ts=' . $timestamp;
    $dummy = curl_file_get_contents($linkDV);

    $linkDV = $urlVZBase . $uuidIstTemperatur . '.json?operation=add&value=' . $IstTemperatur . '&ts=' . $timestamp;
    $dummy = curl_file_get_contents($linkDV);

    $linkDV = $urlVZBase . $uuidSollTemperatur . '.json?operation=add&value=' . $SollTemperatur . '&ts=' . $timestamp;
    $dummy = curl_file_get_contents($linkDV);

    $linkDV = $urlVZBase . $uuidWarmwasser . '.json?operation=add&value=' . $WWTemperatur . '&ts=' . $timestamp;
    $dummy = curl_file_get_contents($linkDV);

    echo "DrehzahlKesselpumpe $DrehzahlKesselpumpe \n";
    echo "Kesseltemperatur $Kesseltemperatur \n";
    echo "Kesselsollwert $Kesselsollwert \n";
    echo "Kesselschaltpunkt $Kesselschaltpunkt \n";
    echo "KesselruecklauftemperaturIst $KesselruecklauftemperaturIst \n";
    echo "Brennermodulation $Brennermodulation \n";
    echo "Geblaesedrehzahl $Geblaesedrehzahl \n";
    echo "Wasserdruck $Wasserdruck \n";
    echo "Aussentemperatur $Aussentemperatur \n";
    echo "SollTemperatur $SollTemperatur \n";
    echo "IstTemperatur $IstTemperatur \n";
    echo "WWTemperatur $WWTemperatur \n";
    echo "\n";
    echo "Dauer um Werte zu holen: " . (getTimestamp() - $t) . " Millisekunden\n";

    echo "Timestamp $timestamp $minTimestamp $maxTimestamp\n";

    sleep($resolution);
} // if ok




echo "Gesamtlaufzeit: " . (getTimestamp() - $gesamtStart) . " Millisekunden\n";


?>
