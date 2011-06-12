<?
require_once '../fonctions.php';
require_once '../classes/attribut.php';
require_once '../classes/table.php';
require_once '../classes/base.php';
$tab_liste_type = array("text", "hidden", "checkbox", "password", "radio", "textarea", "date", "time", "file");

$thisbase = new base(array('nom'=>$_POST['d_name'],'prefixe_tables'=>''));
$newtable = new table(array('nom'=>$_POST['d_table'], 'nom_cle'=>'', 'base'=>$thisbase));
$newtable->recuperation_auto();
?>
    <?
    foreach ($newtable->_attributs as $attribut) {?>
    <div id='att_<?= $attribut->nom ?>' class="params_att" style='display:none; border:1px solid'>
        <table width='100%'>
            <tr><td align='right' colspan='2'><input name='id_$attributs' type="image" src="images/fermer.png" width="20px"><hr></td></tr>
            <tr><td>Nom de l'attribut</td><td align='center'> <b><?= $attribut->nom ?></b></td></tr>
            <tr>
                <td width='35%'>Type</td>
                <td>
                    <select id='type_<?= $attribut->nom ?>' name='type_<?= $attribut->nom ?>'>
                        <?
                        foreach ($tab_liste_type as $i) {
                            if ($attribut->nature!=$i){
                                echo "<option value='$i'>$i</option>";
                            }
                            else{
                                echo "<option value='$i' selected='selected'>$i</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr><td>Libelles pour une liste (separe pas virgule) </td><td> <input id='radio_<?= $attribut->nom ?>' name='radio_<?= $attribut->nom ?>' type="text"/></td></tr>
            <tr><td>valeurs pour liste (separe pas virgule) </td><td> <input id='radio_val_<?= $attribut->nom ?>' name='radio_val_<?= $attribut->nom ?>' type="text"/></td></tr>
            <tr><td>Size </td><td> <input size="3" id='size_<?= $attribut->nom ?>' name='size_<?= $attribut->nom ?>' type="text" value="<?= $attribut->taille ?>"/></td></tr>

            <!--<tr><td>Listes </td><td> <input id='liste_<?= $attribut->nom ?>' name='liste_<?= $attribut->nom ?>' type="text" /></td></tr>-->

            <tr><td>Label </td><td> <input id='label_<?= $attribut->nom ?>' name='label_<?= $attribut->nom ?>' type="text" value="<?= $attribut->label ?>"/></td></tr>

            <tr><td>Required </td><td> <input id='require_<?= $attribut->nom ?>' name='require_<?= $attribut->nom ?>' type="checkbox" checked value='ON'/></td></tr>

            <tr><td>Afficher dans la liste </td><td> <input id='afficher_<?= $attribut->nom ?>' name='afficher_<?= $attribut->nom ?>' type="checkbox" checked value='ON'/></td></tr>

            <tr><td>email </td><td> <input id='email_<?= $attribut->nom ?>' name='email_<?= $attribut->nom ?>' type="checkbox" value='ON' /></td></tr>
        </table>

        <div align="center">RELATION : <input type="checkbox" id="est_relation_<?= $attribut->nom ?>" class="est_relation" name="relations_<?= $attribut->nom ?>" value="ON" att='<?= $attribut->nom ?>'/></div>
        <div id='relations_<?= $attribut->nom ?>' style="display:none">
            <table border="1" width="100%" cellspacing="0">
                <tr>
                    <td align="center" width="33%">Table</td>
                    <td align="center">Attribut</td>
                    <td align="center" width="33%">Attribut à afficher</td>
                </tr>
                <tr>
                    <td align="center"><? liste_table($attribut->nom)?></td>
                    <td align="center" id="rel_att_table_<?= $attribut->nom ?>"></td>
                    <td align="center" id="rel_aff_table_<?= $attribut->nom ?>"></td>
                </tr>
            </table>
        </div>
    </div>
    <?
}
?>