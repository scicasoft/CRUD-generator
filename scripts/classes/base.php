<?
/**
 * 10-06-09 16:35
 *
 * @author scicasoft
 */

class base {
    public $nom;
    public $prefixe_tables = '';
    public $nom_cle_tables = 'id';
    public $infos_cle_etrangere = array('position'=>'aucune');
    public $tables = array();

    public function __construct($infos){
        $this->nom = $infos['nom'];
        $this->prefixe_tables = $infos['prefixe_tables'];
    }

    public function ajouter_table($table){
        $this->tables[] = $table;
    }

    public function recuperation_auto(){
        $result = execute_req('SHOW TABLES');
        foreach ($result as $table) {
            $newtable = new table(array('nom'=>$table[0], 'nom_cle'=>$this->nom_cle_tables,'base'=>$this));
            $newtable->recuperation_auto();
            $this->ajouter_table($newtable);
        }

        $position = $this->infos_cle_etrangere['position'];
        $cle_chaine = $this->infos_cle_etrangere['chaine'];
        foreach ($this->tables as $table) {
            $i=-1;
            if ($position!='aucune') foreach ($table->_attributs as $att) {
                $i+=1;
                if ($position=='debut'){
                    if (substr($att->nom, 0, strlen($cle_chaine))==$cle_chaine){
                        $j=-1;
                        foreach ($this->tables as $table1) {
                            $j+=1;
                            if ($table1->nom==substr($att->nom,strlen($cle_chaine))) {
                                $table->_attributs[$i]->etrangere_table=$table1;
                                $this->tables[$j]->relations_n[] = array('nom'=>$table->nom, 'attribut'=>$att->nom);
                            }
                        }
                    }
                }else{
                    if (substr($att->nom, strlen($att->nom) - strlen($cle_chaine))==$cle_chaine){
                        $j=-1;
                        foreach ($this->tables as $table1) {
                            $j+=1;
                            if ($table1->nom==substr($att->nom,0,strlen($att->nom) - strlen($cle_chaine))) {
                                $table->_attributs[$i]->etrangere_table=$table1;
                                $this->tables[$j]->relations_n[] = array('nom'=>$table->nom, 'attribut'=>$att->nom);
                            }
                        }
                    }
                }
            }
        }
    }

    public function aucun_generer(){
        foreach ($this->tables as $table){
            $dossier = dirname(__FILE__)."/../../sortie/aucun/$this->nom";
            if (!is_dir($dossier)) {
                mkdir($dossier);
                $zip = new ZipArchive;
                if ($zip->open('../../packets/aucun.zip') === TRUE) {
                    $zip->extractTo($dossier);
                    $zip->close();
                }
            }
            $table->aucun_classe($dossier);
            $table->aucun_formulaire($dossier);
            $table->aucun_liste($dossier);
            $table->aucun_script($dossier);
        }
    }

    public function dojo_generer(){
        foreach ($this->tables as $table){
            $dossier = dirname(__FILE__)."/../../sortie/dojo/$this->nom";
            if (!is_dir($dossier)) mkdir($dossier);
            if (!is_dir($dossier."/controller")) mkdir($dossier."/controller");
            if (!is_dir($dossier."/forms")) mkdir($dossier."/forms");
            if (!is_dir($dossier."/modeles")) mkdir($dossier."/modeles");
            if (!is_dir($dossier."/views")) mkdir($dossier."/views");
            if (!is_dir($dossier."/views/$table->nom")) mkdir($dossier."/views/$table->nom");

            $table->dojo_controller($dossier."/controller");
            $table->dojo_modele($dossier."/modeles");
            $table->dojo_form($dossier."/forms");
            $table->dojo_list($dossier."/views/$table->nom");
            $table->dojo_index($dossier."/views/$table->nom");
            $table->dojo_edit($dossier."/views/$table->nom");
            $table->dojo_delete($dossier."/views/$table->nom");
        }
    }

    public function extjs_generer(){
        foreach ($this->tables as $table){
            $dossier = dirname(__FILE__)."/../../sortie/extjs/$this->nom";
            if (!is_dir($dossier)) mkdir($dossier);
            if (!is_dir($dossier."/controllers")) mkdir($dossier."/controllers");
            if (!is_dir($dossier."/models")) mkdir($dossier."/models");
            if (!is_dir($dossier."/views")) mkdir($dossier."/views");
            if (!is_dir($dossier."/views/".strtolower($table->getNomMajTableSansPrefixe())."-win")) mkdir($dossier."/views/".strtolower($table->getNomMajTableSansPrefixe()."-win"));

            $table->extjs_controller($dossier."/controllers");
            $table->extjs_modele($dossier."/models");
            $table->extjs_css($dossier."/views/".strtolower($table->getNomMajTableSansPrefixe())."-win");
            $table->extjs_js($dossier."/views/".strtolower($table->getNomMajTableSansPrefixe())."-win");
            $table->extjs_overridejs($dossier."/views/".strtolower($table->getNomMajTableSansPrefixe())."-win");
            $table->extjs_sql($dossier."/views/".strtolower($table->getNomMajTableSansPrefixe())."-win");

            $zip = new ZipArchive;
            if ($zip->open('../../packets/extjsimages.zip') === TRUE) {
                $zip->extractTo($dossier."/views/".strtolower($table->getNomMajTableSansPrefixe()));
                $zip->close();
            }
        }
    }
}
?>