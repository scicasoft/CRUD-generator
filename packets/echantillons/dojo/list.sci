<br>
<?php $action_url = BASE_URL;  ?>
<form action="#" method='POST' id='adminForm' name='adminForm' >
    <link href="/css/toolbar.css" rel="stylesheet" type="text/css" />

    <link href="/css/2siForm.css" rel="stylesheet" type="text/css">
    <!----------DEBUT TOOLBAR -------------->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="1" colspan="2" bgcolor="#000000"></td>
        </tr>
        <tr>
            <td width="66%" class="grosTitre"><div align="left"> Liste [[NOM_TABLE]] </div></td>
            <td width="34%"><table border="0" align="right" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="65" align="right"><div class="menuItem"><a href="#" onClick="history.back();"><img src="/images/toolbar/icon-32-cancel.png" width="" height="" border="0" /> <br />
                        <span class="menuLibelle">Annuler</span></a></div></td>
                        <td height="65" align="right"><div class="menuItem"><a href="<?php echo $action_url.'edit';?>"><img src="/images/toolbar/icon-32-new.png" alt="Ajouter" width="" height="" border="0" title="Ajouter"/> <br />
                        <span class="menuLibelle">Nouveau</span></a></div></td>
                        <td height="65" align="right"><div class="menuItem"><a href="#"
                                                                                       onclick="javascript:if(document.adminForm.boxchecked.value <=0)
                                                                                           alert('Veuillez sélectionner l\'élément à [ Modifier ] S.V.P !!!')
                                                                                           else if (document.adminForm.boxchecked.value > 1)
                                                                                               alert('Vous ne pouvez [ Modfier ] qu\'un seul élément S.V.P !!!')
                                                                                           else  submitbutton2si('adminForm','<?php echo $action_url.'edit';?>');">
                                    <img src="/images/toolbar/icon-32-edit.png" width="" height="" border="0" /> <br />
                        <span class="menuLibelle">Modifier</span></a></div></td>
                        <td height="65" align="right"><div class="menuItem"><a href="#"
                                                                                       onclick="javascript:if(document.adminForm.boxchecked.value <=0)
                                                                                           alert('Veuillez sélectionner l\'élément à [ Supprimer ] S.V.P !!!')
                                                                                           else submitbutton2si('adminForm', '<?php echo $action_url.'delete';?>');">
                                    <img src="/images/toolbar/icon-32-trash.png" width="" height="" border="0" /> <br />
                        <span class="menuLibelle">Supprimer</span></a></div></td>
                    </tr>
            </table></td>
        </tr>
        <tr>
            <td height="1" colspan="2" bgcolor="#000000"></td>
        </tr>
    </table>
    <br>
    <?php echo $this->rows ?>
    <br>
    <table width="100%" border="1" cellspacing="0" class="cooltable">
        <tr>
            <th class="cooltablehdr"><input name="cbAll" type="checkbox" class="checkbox" style="background-color: #ffffff; border:0" title="S&eacute;lectionner ou D&eacute;selectionner tout" onclick="javascript:cbAll_onclick2si('adminForm');" /></>			<th class="cooltablehdr">num</th>
[[DOJO_ENTETE_LIST]]
        </tr>

        <?php
        $i = 0;
        foreach ($this->rows as $row):
        $i++;
        if (($i%2)==0) { $bgColor = "class=\"cooltablealt\""; } else { $bgColor = "class=\"cooltablerow\""; }
        ?>
        <tr <?= $bgColor; ?>>
            <td><input name="checkbox[]" type="checkbox" class="checkbox" onclick="javascript:isChecked2si('adminForm',<?=$i?>);" value="<?=$row['num']?>" id="checkbox<?=$row['num']?>" language="javascript" /></td>			<td><?=$row['num']?></td>
[[DOJO_CORPS_LIST]]
        </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <input type="hidden" name="cible" value="dar_membre" id="cible" />
    <input type="hidden" name="action"   value="" id="action" />
    <input type="hidden" name="nbligne" value='<?php echo $i; ?>'> <!----------OBSOLETE -------------->
    <input type="hidden" name="nbre" value='<?php echo $i; ?>'>    <!----------OBSOLETE -------------->
    <input type="hidden" name="boxchecked"   value="0" id="boxchecked" />
</form>