<?
$_POST['d_driver']=$_POST['driver'];
$_POST['d_host']=$_POST['server'];
$_POST['d_name']=$_POST['basename'];
$_POST['d_user']=$_POST['username'];
$_POST['d_userpass']=$_POST['userpass'];
$option = $_POST['option'];
require_once '../fonctions.php';
require_once '../classes/attribut.php';
require_once '../classes/table.php';
require_once '../classes/base.php';
$tab_liste_type = array("text", "hidden", "checkbox", "password", "radio", "textarea", "date", "time", "file");

$base = new base(array('nom'=>$_POST['basename'],'prefixe_tables'=>$_POST['prefixe_table']));
$newtable = new table(array('nom'=>$_POST['tablename'], 'nom_cle'=>'', 'base'=>$base));
$newtable->recuperation_auto();

for ($i = 0 ; $i < count($newtable->_attributs) ; $i++) {
    $newtable->_attributs[$i]->nature=$_POST['type_'.$newtable->_attributs[$i]->nom];
    if ($newtable->_attributs[$i]->nature=='time') $newtable->_attributs[$i]->nature_form_extjs = 'timefield';
    if ($newtable->_attributs[$i]->nature=='file') $newtable->_attributs[$i]->nature_form_extjs = 'fileuploadfield';
    if ($newtable->_attributs[$i]->nature=='radio') {
        $newtable->_attributs[$i]->nature_form_extjs = 'radio';
        $newtable->_attributs[$i]->liste_pour_radio = explode(',', $_POST['radio_'.$newtable->_attributs[$i]->nom]);
        $newtable->_attributs[$i]->valeur_pour_radio = explode(',', $_POST['radio_val_'.$newtable->_attributs[$i]->nom]);
    }
    $newtable->_attributs[$i]->taille=$_POST['size_'.$newtable->_attributs[$i]->nom];
    $newtable->_attributs[$i]->label=$_POST['label_'.$newtable->_attributs[$i]->nom];
    if ($_POST['afficher_'.$newtable->_attributs[$i]->nom]=='') $newtable->_attributs[$i]->afficher_sur_liste=false;
    if ($_POST['relations_'.$newtable->_attributs[$i]->nom]!='') {
        $table = new table(array('nom'=>$_POST['table_'.$newtable->_attributs[$i]->nom], 'nom_cle'=>'', 'base'=>$base));
        $table->recuperation_auto();
        $newtable->_attributs[$i]->etrangere_table=$table;
    }
}

$base->ajouter_table($newtable);

if ($option == 'aucun') {
    $base->aucun_generer();
    archiver($base->nom, dirname(__FILE__)."/../../sortie/aucun", false, $_POST['d_host'], $_POST['d_driver'],null ,$newtable->nom);
}
if ($option == 'dojo') {
    $base->dojo_generer();
    archiver($base->nom, dirname(__FILE__)."/../../sortie/dojo", false, $_POST['d_host'], $_POST['d_driver'],null ,$newtable->nom);
}
if ($option == 'extjs') {
    $base->extjs_generer();
    archiver($base->nom, dirname(__FILE__)."/../../sortie/extjs", false, $_POST['d_host'], $_POST['d_driver'],null ,$newtable->nom);
}

header("Location: ../../archives.php");
?>