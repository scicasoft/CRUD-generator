<?
/**
 * 10-06-09 16:35
 *
 * @author scicasoft
 */

class table {
    public $afficher_id_dans_formulaire = false;
    public $base;
    public $nom;
    public $attribut_a_afficher = NULL;
    public $prefixe_attributs = '';
    private $nom_cle = 'id';
    public $_attributs = array();
    public $relations_n = array();
    private $_nombre_cle = 0;
    private $_auto_increment = NULL;
    private $modification = array(  "[[ID]]"                    =>'',
                                    "[[NOM_TABLE]]"             =>'',
                                    "[[DECLARATION_ATTRIBUTS]]" =>'',
                                    "[[AJOUT_VALUES]]"          =>'',
                                    "[[MODIFIER_SET]]"          =>'',
                                    "[[TAB_TO]]"                =>'',
                                    "[[RELATION_N]]"            =>'',
                                    "[[RELATION_UN]]"           =>'',
                                    "[[SIMPLE_ENTETE_LISTE]]"   =>'',
                                    "[[SIMPLE_CONTENU_LISTE]]"  =>'',
                                    "[[SIMPLE_CONTENU_FORM]]"   =>'',
                                    "[[NOM_TABLE_MAJ]]"         =>'',
                                    "[[DOJO_GET_ALL_M]]"        =>'',
                                    "[[DOJO_FORM_CHAMPS]]"      =>'',
                                    "[[DOJO_FORM_RELATION]]"    =>'',
                                    "[[DOJO_ENTETE_LIST]]"      =>'',
                                    "[[DOJO_CORPS_LIST]]"       =>'',
                                    "[[EXTJS_SORT]]"            =>'',
                                    "[[EXTJS_TETE]]"            =>'',
                                    "[[EXTJS_TETE_TYPE]]"       =>'',
                                    "[[EXTJS_COL_TAILLE]]"      =>'',
                                    "[[EXTJS_ELEMENTS_FORM]]"   =>'',
                                    "[[EXTJS_RECUP_SELECTION]]" =>'',
                                    "[[NOM_TABLE_SANS_PRE]]"    =>'',
                                    "[[NOM_TABLE_SANS_PRE_MIN]]"=>'',
                                    "[[EXTJS_RECUP_FORMULAIRE]]"=>'',
                                    "[[EXTJS_COMBOS]]"          =>'',
                                    "[[EXTJS_COMBOS_FONCTIONS]]"=>''
    );

    public function __construct($infos){
        $this->nom = $infos['nom'];
        $this->base = $infos['base'];
        if (isset($infos['nom_cle'])) ($this->nom_cle=$infos['nom_cle']);
        if ($_POST['afficher_id_table_dans_formulaire']!='') $newtable->afficher_id_dans_formulaire=true;
    }

    public function ajouter_attribut($attribut){
        $this->_attributs[] = $attribut;
        if ($attribut->primaire) $this->_nombre_cle+=1;
        if ($this->attribut_a_afficher==NULL && !$attribut->primaire) $this->attribut_a_afficher = $attribut;
    }

    public function ajouter_attribut_autoincrement($attribut){
        $this->ajouter_attribut($attribut);
        $this->_auto_increment = $attribut;
    }

    public function attributs_primaires(){
        $at_pr = array();
        if ($this->_nombre_cle!=0) foreach ($this->_attributs as $primaire) {
            if ($primaire->primaire) ($at_pr[] = $primaire);
        }
        return $at_pr;
    }

    public function recuperation_auto(){
        $result = execute_req("DESC $this->nom");
        foreach ($result as $attribut) {
            $att_nom=$attribut[0];
            $att_type=$attribut[1];
            $att_obligatoire=(($attribut[2]=='NO') ? (true) : (false));
            $att_primaire = (($attribut[3]=='PRI') ? (true) : (false));
            $att_default=$attribut[4];
            $att_auto_inc=(($attribut[5]=='') ? (false) : (true));
            if (!$att_auto_inc && $att_primaire) ($this->afficher_id_dans_formulaire=true);
            if ($att_primaire) ($this->nom_cle=$att_nom);

            $newatt = new attribut(array('table'=>$this, 'nom'=>$att_nom, 'type'=>$att_type, 'primaire'=>$att_primaire, 'obligatoire'=>$att_obligatoire, 'auto_inc'=>$att_auto_inc));
            $newatt->label=$att_nom;
            $this->ajouter_attribut($newatt);
        }
    }

    public static function nom_capitalize($chaine){
        $table = str_replace("_", " ", $chaine);
        $table = ucwords(strtolower($table));
        $table = str_replace(" ", "", $table);
        return $table;
    }

    public function getNomMajTable(){
        return table::nom_capitalize($this->nom);;
    }

    public function getNomMajTableSansPrefixe(){
        $nom = $this->getNomMajTable();
        $nom_sans_pre = $nom;
        $taille_prefixe = strlen(table::nom_capitalize($this->base->prefixe_tables));
        if (substr(strtoupper($nom), 0, $taille_prefixe)==strtoupper(table::nom_capitalize($this->base->prefixe_tables))) {
            $nom_sans_pre = substr($nom, $taille_prefixe);
        }
        return $nom_sans_pre;
    }

    public function chargement(){
        $this->modification['[[ID]]'] = $this->nom_cle;
        $this->modification['[[NOM_TABLE]]'] = $this->nom;
        $this->modification['[[NOM_TABLE_MAJ]]'] = $this->getNomMajTable();
        $this->modification['[[NOM_TABLE_SANS_PRE]]'] = ucwords($this->getNomMajTableSansPrefixe());
        $this->modification['[[NOM_TABLE_SANS_PRE_MIN]]'] = strtolower($this->getNomMajTableSansPrefixe());

        $code='';
        $code1='';
        $code2='';
        $relation = array();
        foreach ($this->_attributs as $att) {
            if ($att->etrangere_table!=NULL){
                $code2="function combo{$att->etrangere_table->getNomMajTable()}(){
    var combo{$att->etrangere_table->getNomMajTable()} = new Ext.data.Store({
        id : 'combo{$att->etrangere_table->getNomMajTable()}',
        proxy : new Ext.data.HttpProxy({
            url : action_url+'combo{$att->etrangere_table->getNomMajTable()}',
            method : 'POST'

        }),
        reader : new Ext.data.JsonReader({
            root : 'results',
            id : 'id'
        }, [{
            name : '{$att->etrangere_table->_nom_cle}',
            type : '{$att->etrangere_table->typeprog}',
            mapping : '{$att->etrangere_table->_nom_cle}'
        }, {
            name : '{$att->etrangere_table->attribut_a_afficher->nom}',
            type : '{$att->etrangere_table->attribut_a_afficher->typeprog}',
            mapping : '{$att->etrangere_table->attribut_a_afficher->nom}'
        }
        ]),

        sortInfo : {
            field : '{$att->etrangere_table->attribut_a_afficher->nom}',
            direction : \"ASC\"
        }

    });
    combo{$att->etrangere_table->getNomMajTable()}.load();

    var newCombo = new Ext.form.ComboBox({
        store : combo{$att->etrangere_table->getNomMajTable()},
        id: '{$this->_attributs->nom}',
        typeAhead : true,
        name: '{$this->_attributs->nom}',
        triggerAction : 'all',
        mode : 'remote',
        displayField : '{$att->etrangere_table->attribut_a_afficher->nom}',
        fieldLabel :'{$this->_attributs->label}',
        valueField : '{$att->etrangere_table->_nom_cle}',
        listClass : 'x-combo-list-small'
    });
    return newCombo;
}\n\n";
                $code1="    public function combo".strtolower($att->etrangere_table->getNomMajTable())."Action() {
        \$this->_helper->layout->disableLayout ();
        \$this->_helper->removeHelper ( 'viewRenderer' );
        \$selectCombo=new {$att->etrangere_table->getNomMajTable()}();
        \$resrows=\$selectCombo->getCombo('{$att->etrangere_table->getNomMajTable()}');
        \$resrowscount=\$selectCombo->getNbRows('{$att->etrangere_table->getNomMajTable()}');
        \$nbdata = array();
        \$nbdata=\$resrowscount->toArray();
        \$data = array();
        \$data['results'] = \$resrows->toArray();
        \$data['total'] = \$nbdata[0]['total'];
        \$resultat = Zend_Json :: encode(\$data);
        \$this->getResponse ()->clearBody ();
        \$this->getResponse ()->setHeader ( 'Content-Type', 'text/x-json' );
        \$this->getResponse ()->setBody (\$resultat );
    }\n\n";
                $relation[]=$att;
            }
            $code .= "\t\t\$$this->nom->$att->nom=\$tab['$att->nom'];\n";
        }
        $this->modification['[[TAB_TO]]'] = $code;
        $this->modification['[[EXTJS_COMBOS]]'] = $code1;
        $this->modification['[[EXTJS_COMBOS_FONCTIONS]]'] = $code2;

        $code='';
        foreach ($this->_attributs as $att) {
            $code .= "'\$this->$att->nom', ";
        }
        $code = substr($code, 0, strlen($code)-2);
        $this->modification['[[AJOUT_VALUES]]'] = $code;

        $code='';
        foreach ($this->_attributs as $attribut) {
            $code .= "\tpublic \$$attribut->nom;\n";
        }
        $this->modification['[[DECLARATION_ATTRIBUTS]]'] = $code;

        $code='';
        if (count($this->relations_n)!=0) foreach ($this->relations_n as $table){
            $code .= "\tpublic function {$table['nom']}s(){\n\t\treturn ".$table['nom']."::getAll(array('where'=>'".$table['attribut']."='.\$this->$this->nom_cle));\n\t}\n\n";
        }
        $this->modification['[[RELATION_N]]'] = $code;

        $code='';
        foreach ($this->_attributs as $att) {$code .= "`$att->nom`='\$this->$att->nom', ";}
        $code = substr($code, 0, strlen($code)-2);
        $this->modification['[[MODIFIER_SET]]'] = $code;

        $code='';
        if (count($relation) != 0) foreach ($relation as $rel){
            $code .= "\n\tpublic function ".$rel->etrangere_table->nom."() {\n\t\treturn ".$rel->etrangere_table->nom."::get(\$this->$rel->nom);\n\t}\n";
        }
        $this->modification['[[RELATION_UN]]'] = $code;

        $code1='';
        $code2='';
        $code3='';
        $code4='';
        foreach ($this->_attributs as $attribut) {
            if ($attribut->nom != $this->nom_cle){
                $code1 .= "\t\t\t<th class=\"title\">$attribut->label</th>\n";
                $code2 .= "\t\t<td><?= \$$this->nom->$attribut->nom ?></td>\n";
                $code3 .= "            <th class=\"cooltablehdr\">$attribut->nom</th>\n";
                $code4 .= "            <td><?=\$row['$attribut->nom']?></td>\n";
            }
        }

        $this->modification['[[SIMPLE_ENTETE_LISTE]]'] = $code1;
        $this->modification['[[SIMPLE_CONTENU_LISTE]]'] = $code2;
        $this->modification['[[DOJO_ENTETE_LIST]]'] = $code3;
        $this->modification['[[DOJO_CORPS_LIST]]'] = $code4;

        $code = '';
        foreach ($this->_attributs as $att) {
            $a=$att->nom;
            $code .= "\t\t\t<tr>\n";

            if ($a=="id"){
                $code .= "\t\t\t\t<td colspan='2'><input type='hidden' name='$a' id='$a' value=\"<?= \$$this->nom->$a ?>\"></td>\n";
            }
            else{
                $code .= "\t\t\t\t<td>$att->nom</td>\n";
                switch ($att->nature) {
                    case "password":
                        $code .= "\t\t\t\t<td><input type='password' name='$a' id='$a' value=\"<?= \$$this->nom->$a ?>\"></td>\n";
                        break;
                    case "textarea":
                        $code .= "\t\t\t\t<td><textarea name='$a' id='$a'><?= \$$this->nom->$a ?></textarea></td>\n";
                        break;
                    default:
                        $code .= "\t\t\t\t<td><input type='text' name='$a' id='$a' value=\"<?= \$$this->nom->$a ?>\"></td>\n";
                        break;
                }
            }
            $code .= "\t\t\t</tr>\n";
        }
        $this->modification['[[SIMPLE_CONTENU_FORM]]'] = $code;

        $code='';
        foreach ($this->_attributs as $att) {
            if ($att->obligatoire){
                if ($att->nom!=$this->nom_cle){
                    $code .= "\t\tif (\$$this->nom->$att->nom==''){\$nbre_erreur+=1; echo '$att->nom requis(e)<br>';}\n";
                }
            }
        }
        $this->modification['[[SIMPLE_ERREUR_SCRIPT]]'] = $code;

        $code='';
        $code1='';
        if (count($relation) != 0) {
            $table=$relation[0]->etrangere_table;
            $code="    public function getAllM(\$table){
        \$resultat = Doctrine_Query::create()
        //->select('u.*, p.*')
        ->from(\$table.' b')
        ->leftJoin('b.$table->nom p')
        ->execute();
        return \$resultat;
    }";
            $code1 = "    \$relationModel = new ".$this->nom_capitalize($table->nom)."();
        \$relationlist=\$relationModel->getAllM('".$this->nom_capitalize($table->nom)."');
       // print_r(\$relationlist);exit;
        \$tabrelation=array();

        foreach (\$relationlist as \$relation) {
            \$tabrelation[\$relation->$table->nom_cle] = \$relation->{$table->attribut_a_afficher->nom};
        }\n\n";
        }
        $this->modification['[[DOJO_GET_ALL_M]]'] = $code;
        $this->modification['[[DOJO_FORM_RELATION]]'] = $code1;

        $form='';
        foreach ($this->_attributs as $attribut) {
            $a=$attribut->nom;
            $require="false";
            if ($attribut->obligatoire){
                $require="true";
            }
            if (!$attribut->primaire){
                switch ($attribut->nature) {
                    case "text":
                        if ($attribut->est_email){
                            $form .= "
                \${$a} = new Zend_Dojo_Form_Element_TextBox('{$a}');
                \${$a}->setLabel(\"$attribut->label :\");
                \${$a}->setRequired($require);
                //\${$a}->addFilter(new Zend_Filter_StripSlashes());
                \$this->addElement(\${$a});\n\n";
                        }
                        else{
                            $form .= "
                \$this->addElement('ValidationTextBox', '{$a}', array(
                'label'      => '$attribut->label :',
                'required'      => $require,
                'validators'     => array('EmailAddress'),
                'filters'         => array('StringToLower'),
                'regExp'        => '^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$',
                'promptMessage'    => 'email@...',
                'invalidMessage'=> 'Veuillez saisir une adresse email valide svp!'
                ));\n\n";
                        }
                        break;

                    case "password":
                        $form .= "
                \${$a} = new Zend_Dojo_Form_Element_PasswordTextBox('{$a}');
                \${$a}->setLabel(\"$attribut->label :\");
                \${$a}->setRequired($require);
                //\${$a}->addFilter(new Zend_Filter_StripSlashes());
            \$this->addElement(\${$a});\n\n";
                        break;

                    case "textarea":
                        $form .= "
                        \$this ->addElement(
                'Textarea',
                '$a',
                array(
                    'label'    => '$attribut->label :',
                    'required' => $require,
                    'style'    => 'width: 200px;height:50px',
                )
            );\n\n";
                        break;

                    case "date":
                        $form .= "
            \${$a}= new Zend_Dojo_Form_Element_DateTextBox('{$a}');
            \${$a}->setLabel(\"$attribut->label: \");
            \$this->addElement(\${$a});\n\n";
                        break;

                    default:
                        $form .= "
                \${$a} = new Zend_Dojo_Form_Element_TextBox('{$a}');
                \${$a}->setLabel(\"$attribut->label :\");
                \${$a}->setRequired($require);
                //\${$a}->addFilter(new Zend_Filter_StripSlashes());
                \$this->addElement(\${$a});\n\n";
                        break;
                }
            }
        }
        $this->modification['[[DOJO_FORM_CHAMPS]]'] = $form;

        $this->modification['[[EXTJS_SORT]]'] = $this->attribut_a_afficher->nom;

        $code1='';
        $code2='';
        $code3='';
        $code4='';
        $code5='';
        $code6='';
        $code7='';
        foreach ($this->_attributs as $attribut) {
            if ($attribut->nature_form_extjs=='fileuploadfield') {
                $code2 .= "         if( !empty(\$_FILES['$attribut->nom'])) {
                \$file_temp = \$_FILES['$attribut->nom']['tmp_name'];
                \$file= \$_FILES['$attribut->nom']['name'];
                move_uploaded_file(\$file_temp,\$_SERVER['DOCUMENT_ROOT'].'documents/'.\$file);
                \$rows->$attribut->nom= \$file;
            }\n\n";
            }
            if (!$attribut->primaire){
                if ($attribut->afficher_sur_liste){
                    $type = ($attribut->typeprog=='time') ? ('string') : ($attribut->typeprog);
                    $code3 .= "	    {name : '$attribut->nom',
        type : '$type'
        },\n";
                    $code4 .= "			{name: '$attribut->nom', type: '$type',mapping: '$attribut->nom'},\n";
                    $code5 .= "					{header: \"$attribut->label\", width: 70, sortable: true, dataIndex: '$attribut->nom'},\n";
                    $code7 .= "                    Ext.getCmp(\"$attribut->nom\").setValue(selections[0].json.$attribut->nom);\n";
                }
            }
            if ($this->afficher_id_dans_formulaire || !$attribut->primaire){
                if ($attribut->etrangere_table==NULL){
                    if ($attribut->nature_form_extjs=='datefield') {
                        $code1 .= "            \$rows->$attribut->nom=Ssi_Mainfile::DateToMysql(stripslashes(\$this->_request->getPost('$attribut->nom')));\n";
                    }
                    else {
                        $code1 .= "            \$rows->$attribut->nom=stripslashes(\$this->_request->getPost('$attribut->nom'));\n";
                    }
                }
                else {
                    $code1 .= "            \$rows->$attribut->nom=stripslashes(\$this->_request->getPost('$attribut->nom'));\n";
                }
            }
        }
        $code3 = substr($code3, 0, strlen($code3)-2)."\n";
        $code4 = substr($code4, 0, strlen($code4)-2)."\n";
        $code5 = substr($code5, 0, strlen($code5)-2)."\n";
        $this->modification['[[EXTJS_TETE]]'] = $code3;
        $this->modification['[[EXTJS_TETE_TYPE]]'] = $code4;
        $this->modification['[[EXTJS_COL_TAILLE]]'] = $code5;
        $this->modification['[[EXTJS_RECUP_SELECTION]]'] = $code7;
        $this->modification['[[EXTJS_RECUP_FORMULAIRE]]'] = $code1.$code2;

        //FORMULAIRE EXTJS

        $code1='';
        $code2='';
        $relation = array();
        foreach ($this->_attributs as $att) {
            if ($att->etrangere_table!=NULL){
                $code1 .= "    public function combo".strtolower($att->etrangere_table->getNomMajTable())."Action() {
        \$this->_helper->layout->disableLayout ();
        \$this->_helper->removeHelper ( 'viewRenderer' );
        \$selectCombo=new {$att->etrangere_table->getNomMajTable()}();
        \$resrows=\$selectCombo->getCombo('{$att->etrangere_table->getNomMajTable()}');
        \$resrowscount=\$selectCombo->getNbRows('{$att->etrangere_table->getNomMajTable()}');
        \$nbdata = array();
        \$nbdata=\$resrowscount->toArray();
        \$data = array();
        \$data['results'] = \$resrows->toArray();
        \$data['total'] = \$nbdata[0]['total'];
        \$resultat = Zend_Json :: encode(\$data);
        \$this->getResponse ()->clearBody ();
        \$this->getResponse ()->setHeader ( 'Content-Type', 'text/x-json' );
        \$this->getResponse ()->setBody (\$resultat );
    }\n\n";

                $code2 .= "function combo{$att->etrangere_table->getNomMajTable()}(){
    var combo{$att->etrangere_table->getNomMajTable()} = new Ext.data.Store({
        id : 'combo".strtolower($att->etrangere_table->getNomMajTable())."',
        proxy : new Ext.data.HttpProxy({
            url : action_url+'combo".strtolower($att->etrangere_table->getNomMajTable())."',
            method : 'POST'

        }),
        reader : new Ext.data.JsonReader({
            root : 'results',
            id : 'id'
        }, [{
            name : '{$att->etrangere_table->nom_cle}',
            type : 'string',
            mapping : '{$att->etrangere_table->nom_cle}'
        }, {
            name : '{$att->etrangere_table->attribut_a_afficher->nom}',
            type : '{$att->etrangere_table->attribut_a_afficher->typeprog}',
            mapping : '{$att->etrangere_table->attribut_a_afficher->nom}'
        }
        ]),

        sortInfo : {
            field : '{$att->etrangere_table->attribut_a_afficher->nom}',
            direction : \"ASC\"
        }

    });
    combo{$att->etrangere_table->getNomMajTable()}.load();

    var newCombo = new Ext.form.ComboBox({
        store : combo{$att->etrangere_table->getNomMajTable()},
        id: '{$att->nom}',
        typeAhead : true,
        name: '{$att->nom}',
        triggerAction : 'all',
        mode : 'remote',
        displayField : '{$att->etrangere_table->attribut_a_afficher->nom}',
        fieldLabel :'{$att->etrangere_table->nom_cle}',
        valueField : '{$att->etrangere_table->nom_cle}',
        listClass : 'x-combo-list-small'
    });
    return newCombo;
}\n\n";
            }
        }
        $this->modification['[[EXTJS_COMBOS]]'] = $code1;
        $this->modification['[[EXTJS_COMBOS_FONCTIONS]]'] = $code2;

        ///////////////////////////////////////////////////////////////////////////////////////////

        $code='';
        foreach ($this->_attributs as $attribut) {
            if(!$this->afficher_id_dans_formulaire && $attribut->primaire){
                $code .= "					{
                    xtype: 'textfield',
                    id: '$this->nom_cle',
                    name: '$this->nom_cle',
                    inputType: 'hidden',
                    allowBlank: true,
                    blankText:'Veuillez entrer le code de l\'enregistrement!'
                },\n";
            }
            else {
                if ($attribut->etrangere_table!=NULL){
                    $code .= "combo{$attribut->etrangere_table->getNomMajTable()}(),\n";
                }
                else {
                    switch ($attribut->nature_form_extjs) {
                        case 'datefield':
                            $code .= "					{
                    xtype: '$attribut->nature_form_extjs',
                    fieldLabel: '$attribut->label',
                    id: '$attribut->nom',
                    name: '$attribut->nom',
                    allowBlank: false,
                    format: 'd/m/Y',
                    blankText:'Veuillez entrer $attribut->label'},\n";
                            break;

                        case 'timefield':
                            $code .= "					{
                    xtype: 'timefield',
                    fieldLabel: '$attribut->label',
                    id: '$attribut->nom',
                    name: '$attribut->nom',
                    allowBlank: false,
                    format: 'g:i:s',
                    blankText:'Veuillez entrer $attribut->label'},\n";
                            break;

                        case 'fileuploadfield':
                            $code .= "                {
                    xtype: '$attribut->nature_form_extjs',
                    id: 'form-file',
                    emptyText: 'Veuillez entrer Fichier',
                    fieldLabel: '$attribut->label',
                    name: '$attribut->nom',
                    buttonCfg: {
                        text: '',
                        iconCls: 'upload-icon' //usuing icon on  browse button.
                    }
                },\n";
                            break;

                        case 'radio':
                            for ($i = 0 ; $i < min(array(count($attribut->valeur_pour_radio),count($attribut->liste_pour_radio))) ; $i++) {
                                if ($i==0){
                                    $code .= "          {
                    xtype: 'radio',
                    checked: true,
                    fieldLabel: '$attribut->label',
                    boxLabel: '{$attribut->liste_pour_radio[$i]}',
                    name: '$attribut->nom',
                    inputValue: '{$attribut->valeur_pour_radio[$i]}'
                },\n";
                                }
                                else {
                                    $code .= "          {
                    xtype: 'radio',
                    fieldLabel: '',
                    labelSeparator: '',
                    boxLabel: '{$attribut->liste_pour_radio[$i]}',
                    name: '$attribut->nom',
                    inputValue: '{$attribut->valeur_pour_radio[$i]}'
                },\n";
                                }
                            }
                            break;

                            default:
                                $code .= "					{
                    xtype: '$attribut->nature_form_extjs',
                    fieldLabel: '$attribut->label',
                    id: '$attribut->nom',
                    name: '$attribut->nom',
                    allowBlank: false,
                    blankText:'Veuillez entrer $attribut->label'},\n";
                                break;
                    }
                }
            }
        }
        $code = substr($code, 0, strlen($code)-2)."\n";
        $this->modification['[[EXTJS_ELEMENTS_FORM]]'] = $code;
    }

    private function recuperer_contenu_fichier($chemin,$f_sortie){
        $this->chargement();
        $f = fopen($chemin,"r");
        $contenu = '';
        while(!feof($f))
        {
            $contenu .= fgets($f);
        }
        fclose($f);
        foreach ($this->modification as $cle => $c) {
            $contenu = str_replace($cle, $c, $contenu);
        }

        $f = fopen($f_sortie,"w");
        fwrite($f, $contenu);
        fclose($f);
    }

    public function aucun_classe($dossier){
        $ROOT = "$dossier/mesclasses/";
        $this->recuperer_contenu_fichier("../../packets/echantillons/aucun/classe.sci",$ROOT.$this->nom."_classe.php");
        //echo "classe $this->nom genere :)\t dans le fichier {$ROOT}{$this->nom}_classe.php<br>";
    }

    public function aucun_formulaire($dossier){
        $ROOT = "$dossier/appl/";
        if (!is_dir($ROOT.$this->nom)) mkdir($ROOT.$this->nom);
        $this->recuperer_contenu_fichier("../../packets/echantillons/aucun/nouveau.sci",$ROOT.$this->nom."/nouveau.php");
        //echo "formulaire $this->nom genere :)\t dans le fichier {$ROOT}$this->nom/nouveau.php<br>";

        $f_root=$ROOT."$this->nom/root.php";
        $f = fopen($f_root,"w");
        fwrite($f, "<?php
session_start();
define (\"ROOT\",\"../../\");
require_once ROOT.'scripts/fonctions.php';
?>");
        fclose($f);
    }

    public function aucun_liste($dossier){
        $ROOT = "$dossier/appl/";
        if (!is_dir($ROOT.$this->nom)) mkdir($ROOT.$this->nom);
        $this->recuperer_contenu_fichier("../../packets/echantillons/aucun/index.sci",$ROOT.$this->nom."/index.php");

        //echo "liste $this->nom genere :)\t dans le fichier {$ROOT}$this->nom/index.php<br>";
    }

    public function aucun_script($dossier){
        $ROOT = "$dossier/appl/";
        if (!is_dir($ROOT.$this->nom)) mkdir($ROOT.$this->nom);
        $this->recuperer_contenu_fichier("../../packets/echantillons/aucun/script.sci",$ROOT.$this->nom."/script.php");
        //echo "script $this->nom genere :)\t dans le fichier {$ROOT}$this->nom/script.php<br>";
    }

    public function dojo_controller($dossier){
        $ROOT = "$dossier/";
        $nom = table::nom_capitalize($this->nom);
        $this->recuperer_contenu_fichier("../../packets/echantillons/dojo/controlleur.sci","{$ROOT}{$nom}Controller.php");
        //echo "controlleur $this->nom genere :)\t dans le fichier {$ROOT}{$nom}Controller.php<br>";
    }

    public function dojo_modele($dossier){
        $ROOT = "$dossier/";
        $nom = table::nom_capitalize($this->nom);
        $this->recuperer_contenu_fichier("../../packets/echantillons/dojo/modele.sci","{$ROOT}{$nom}.php");
        //echo "modele $this->nom genere :)\t dans le fichier {$ROOT}{$nom}.php<br>";
    }

    public function dojo_form($dossier){
        $ROOT = "$dossier/";
        $nom = table::nom_capitalize($this->nom);
        $this->recuperer_contenu_fichier("../../packets/echantillons/dojo/form.sci","{$ROOT}{$nom}.php");
        //echo "formulaire $this->nom genere :)\t dans le fichier {$ROOT}{$nom}.php<br>";
    }

    public function dojo_list($dossier){
        $ROOT = "$dossier/";
        $this->recuperer_contenu_fichier("../../packets/echantillons/dojo/list.sci","{$ROOT}list.phtml");
        //echo "liste $this->nom genere :)\t dans le fichier {$ROOT}list.php<br>";
    }

    public function dojo_edit($dossier){
        $ROOT = "$dossier/";
        $this->recuperer_contenu_fichier("../../packets/echantillons/dojo/edit.sci","{$ROOT}edit.phtml");
        //echo "edit $this->nom genere :)\t dans le fichier {$ROOT}edit.php<br>";
    }

    public function dojo_index($dossier){
        $ROOT = "$dossier/";
        $this->recuperer_contenu_fichier("../../packets/echantillons/dojo/index.sci","{$ROOT}index.phtml");
        //echo "index $this->nom genere :)\t dans le fichier {$ROOT}index.php<br>";
    }

    public function dojo_delete($dossier){
        $ROOT = "$dossier/";
        $this->recuperer_contenu_fichier("../../packets/echantillons/dojo/delete.sci","{$ROOT}delete.phtml");
        //echo "delete $this->nom genere :)\t dans le fichier {$ROOT}delete.php<br>";
    }

    public function extjs_controller($dossier){
        $ROOT = "$dossier/";
        $nom = table::nom_capitalize($this->nom);
        $this->recuperer_contenu_fichier("../../packets/echantillons/extjs/controlleur.sci","{$ROOT}{$nom}Controller.php");
        //echo "controlleur $this->nom genere :)\t dans le fichier {$ROOT}{$nom}Controller.php<br>";
    }

    public function extjs_modele($dossier){
        $ROOT = "$dossier/";
        $nom = table::nom_capitalize($this->nom);
        $this->recuperer_contenu_fichier("../../packets/echantillons/extjs/modele.sci","{$ROOT}{$nom}.php");
        //echo "modele $this->nom genere :)\t dans le fichier {$ROOT}{$nom}.php<br>";
    }

    public function extjs_css($dossier){
        $ROOT = "$dossier/";
        $nom = strtolower($this->getNomMajTableSansPrefixe());
        $this->recuperer_contenu_fichier("../../packets/echantillons/extjs/win-css.sci","{$ROOT}{$nom}-win.css");
        //echo "css $this->nom genere :)\t dans le fichier {$ROOT}{$this->nom}-win.css<br>";
    }

    public function extjs_js($dossier){
        $ROOT = "$dossier/";
        $nom = strtolower($this->getNomMajTableSansPrefixe());
        $this->recuperer_contenu_fichier("../../packets/echantillons/extjs/win-js.sci","{$ROOT}{$nom}-win.js");
        //echo "win.js $this->nom genere :)\t dans le fichier {$ROOT}{$this->nom}-win.js<br>";
    }

    public function extjs_overridejs($dossier){
        $ROOT = "$dossier/";
        $nom = strtolower($this->getNomMajTableSansPrefixe());
        $this->recuperer_contenu_fichier("../../packets/echantillons/extjs/win-override-js.sci","{$ROOT}{$nom}-win-override.js");
        //echo "win-override.js $this->nom genere :)\t dans le fichier {$ROOT}{$this->nom}-win.css<br>";
    }

    public function extjs_sql($dossier){
        $ROOT = "$dossier/";
        $nom = strtolower($this->getNomMajTableSansPrefixe());
        $this->recuperer_contenu_fichier("../../packets/echantillons/extjs/requete.sql","{$ROOT}{$nom}.sql");
    }
}
?>