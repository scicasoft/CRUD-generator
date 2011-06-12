<?php
require 'root.php';
include_once ROOT.'mesclasses/classeprincipale.php';
if ($_GET['action']=='ajout_modif') {
    if (isset($_POST['id'])) {
        $cours = [[NOM_TABLE]]::recuperer_elements();
        $nbre_erreur=0;
[[SIMPLE_ERREUR_SCRIPT]]

        if ($nbre_erreur==0){
            if ($_POST['id']=="") {
                $[[NOM_TABLE]]->ajout();
            }
            else {
                $[[NOM_TABLE]]->modifier();
            }
            header("Location: ".ROOT."appl/[[NOM_TABLE]]/index.php");
        }
    }
}

if (isset ($_POST['type_form'])){
    if ($_POST['type_form']=='supprimer'){
        $choix=$_POST['choix'];
        foreach ($choix as $id) {
            [[NOM_TABLE]]::supprimer($id);
        }
        header("Location: ".ROOT."appl/[[NOM_TABLE]]/index.php");
    }
    if ($_POST['type_form']=='modifier'){
        $choix=$_POST['choix'];
        $id=$choix[0];
        header("Location: ".ROOT."appl/[[NOM_TABLE]]/nouveau.php?modifier=$id");
    }
}
?>