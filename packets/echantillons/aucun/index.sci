<?php
require 'root.php';
include_once ROOT.'mesclasses/classeprincipale.php';
define("TITRE","Liste [[NOM_TABLE]]");
define("FOND_TITRE", ROOT.'images/icones/icon-48-user.png');
$sous_menu=array(
    1=>array('type'=>'nouveau', 'chemin'=>ROOT."appl/[[NOM_TABLE]]/nouveau.php"),
    2=>array('type'=>'modifier', 'chemin'=>"#"),
    3=>array('type'=>'supprimer', 'chemin'=>"#"),
);
$[[NOM_TABLE]]s=[[NOM_TABLE]]::getAll();

include_once ROOT.'appl/layouts/tete.php';
?>
<form action="script.php" method="post" name="liste">
<center>
<table width="100%" class="adminlist" cellspacing="1" id="liste">
    <thead>
        <tr>
            <th width="5" class="title">#</th>
            <th width="5" class="title"><input type="checkbox" id="cb" name="toggle" value="" onclick="checkAll(<?= [[NOM_TABLE]]::count() ?>, 'cb');" /></th>
[[SIMPLE_ENTETE_LISTE]]
        </tr>
    </thead>
    <tbody>
    <? $i=0 ?>
    <? if ([[NOM_TABLE]]::count()!=0) foreach($[[NOM_TABLE]]s as $[[NOM_TABLE]]){ ?>
    <? $i+=1 ?>
    <tr class="row0">
        <td><?= $i ?></td>
        <td><input type="checkbox" id="cb<?= $i - 1 ?>" name="choix[]" value="<?= $[[NOM_TABLE]]->[[ID]] ?>" onclick='decoche(this)' /></td>
[[SIMPLE_CONTENU_LISTE]]
    </tr>
    <? } ?>
    </tboby>
</table>
<input type="hidden" id="nb_cb" name="nb_cb" value="0">
<input type="hidden" id="type_form" name="type_form" value="">
</center>
</form>
<?php
include_once ROOT.'appl/layouts/pied.php';
?>