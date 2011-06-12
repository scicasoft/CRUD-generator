<?php
require 'root.php';
include_once ROOT.'mesclasses/classeprincipale.php';
define("TITRE","Nouveau [[NOM_TABLE]]");
define("FOND_TITRE", ROOT.'images/icones/icon-48-user.png');
$sous_menu=array(
    1=>array('type'=>'annuler', 'chemin'=>ROOT."appl/[[NOM_TABLE]]/index.php"),
);
include_once ROOT.'appl/layouts/tete.php';

if (isset($_GET['modifier'])){
    $[[NOM_TABLE]]=[[NOM_TABLE]]::get($_GET['modifier']);
}
?>
<center>
    <form method='post' action='script.php?action=ajout_modif'>
		<table cellspacing="25px">
[[SIMPLE_CONTENU_FORM]]
		</table>
		<input type='submit' value='valider'>
	</form>
</center>
<?php
include_once ROOT.'appl/layouts/pied.php';
?>