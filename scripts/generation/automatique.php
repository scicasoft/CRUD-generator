<?
require_once '../fonctions.php';
require_once '../classes/attribut.php';
require_once '../classes/table.php';
require_once '../classes/base.php';

$prefixe_table = $_POST['d_prefixe_table'];
$id_tables = $_POST['d_id_tables'];
$id_externe = $_POST['d_id_externe'];
$position_id_externe = $_POST['d_id_externe_position'];
$option = $_POST['option'];

$infos_id_externe = array('position'=>$position_id_externe ,'chaine'=>$id_externe);

$base = new base(array('nom'=>$_POST['d_name'],'prefixe_tables'=>$prefixe_table));
$base->infos_cle_etrangere = $infos_id_externe;
$base->nom_cle_tables = $id_tables;
$base->recuperation_auto();

if ($option == 'aucun') {
    $base->aucun_generer();
    archiver($base->nom, dirname(__FILE__)."/../../sortie/aucun", true, $_POST['d_host'], $_POST['d_driver'], $nbre_table=count($base->tables));
}
if ($option == 'dojo') {
    $base->dojo_generer();
    archiver($base->nom, dirname(__FILE__)."/../../sortie/dojo", true, $_POST['d_host'], $_POST['d_driver'], $nbre_table=count($base->tables));
}
if ($option == 'extjs') {
    $base->extjs_generer();
    archiver($base->nom, dirname(__FILE__)."/../../sortie/extjs", true, $_POST['d_host'], $_POST['d_driver'], $nbre_table=count($base->tables));
}
?>