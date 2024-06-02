<?php

use Dompdf\Dompdf;
use Dompdf\Options;

require_once 'include/dompdf/autoload.inc.php';
require "verif_session.php";


ob_start();
require_once 'cv_pdf_genere.php';
$html = ob_get_contents();
ob_end_clean();





$options = new Options();
$options->set('defaultFont','Arial');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');
$dompdf->render();



$dossier = 'fichiers/';
$fichier = $_SESSION['nom'].'_'.$_SESSION['prenom'].'_CV.pdf';
$cheminComplet = $dossier . $fichier;



$pdfContent = $dompdf->output();

file_put_contents($cheminComplet, $pdfContent);

$sql_new_cv = "UPDATE `utilisateur` SET `cv` = '".$cheminComplet."' WHERE `utilisateur`.`identifiant_utilisateur` = ".$_SESSION['identifiant_utilisateur'];

mysqli_query($conn, $sql_new_cv);
