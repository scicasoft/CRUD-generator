<?
/**
 * 10-06-09 16:22
 *
 * @author scicasoft
 */

class attribut {
    public $nom ;
    public $type ;
    public $typeprog;
    public $table;
    public $nature;
    public $nature_form_extjs;
    public $primaire = false;
    public $etrangere_table = NULL;
    public $taille = NULL;
    public $label = '';
    public $est_email = false;
    public $obligatoire = true;
    public $default = '';
    public $liste = NULL;
    public $auto_inc = false;
    public $afficher_sur_liste = true;
    public $liste_pour_radio = array();
    public $valeur_pour_radio = array();

    private $TABTYPE = array( 'VARCHAR' =>    array('type' => 'text',     'size' => NULL, 'nature' => 'string'),
                           'CHAR' =>       array('type' => 'text',     'size' => 1,    'nature' => 'string'),
                           'TINYINT' =>    array('type' => 'text',     'size' => 4,    'nature' => 'int'),
                           'SMALLINT' =>   array('type' => 'text',     'size' => 6,    'nature' => 'int'),
                           'MEDIUMINT' =>  array('type' => 'text',     'size' => 9,    'nature' => 'int'),
                           'INT' =>        array('type' => 'text',     'size' => 11,   'nature' => 'int'),
                           'BIGINT' =>     array('type' => 'text',     'size' => 20,   'nature' => 'int'),
                           'TIMESTAMP' =>  array('type' => 'text',     'size' => 20,   'nature' => 'int'),
                           'YEAR' =>       array('type' => 'text',     'size' => 4,    'nature' => 'int'),
                           'FLOAT' =>      array('type' => 'text',     'size' => NULL, 'nature' => 'float'),
                           'DOUBLE' =>     array('type' => 'text',     'size' => NULL, 'nature' => 'float'),
                           'DECIMAL' =>    array('type' => 'text',     'size' => NULL, 'nature' => 'float'),
                           'DATE' =>       array('type' => 'date',     'size' => 10,   'nature' => 'date'),
                           'DATETIME' =>   array('type' => 'datetime', 'size' => 19,   'nature' => 'datetime'),
                           'TEXT' =>       array('type' => 'textarea', 'size' => NULL, 'nature' => 'string'),
                           'TINYTEXT' =>   array('type' => 'textarea', 'size' => NULL, 'nature' => 'string'),
                           'MEDIUMTEXT' => array('type' => 'textarea', 'size' => NULL, 'nature' => 'string'),
                           'LONGTEXT' =>   array('type' => 'textarea', 'size' => NULL, 'nature' => 'string'),
                           'TIME' =>       array('type' => 'time',     'size' => 8,    'nature' => 'time'),
                           'ENUM' =>       array('type' => 'select',   'size' => NULL, 'nature' => 'string'),
                           'BOOL' =>       array('type' => 'checkbox', 'size' => NULL, 'nature' => 'boolean'),
    );

    public function __construct($infos){
        $this->table = $infos['table'];
        $this->nom = $infos['nom'];
        $this->type = $infos['type'];
        if (isset($infos['primaire'])) ($this->primaire = $infos['primaire']);
        if (isset($infos['etrangere'])) ($this->etrangere_table = $infos['etrangere']);
        (isset($infos['taille'])) ? ($this->taille = $infos['taille']) : ($this->_calculer_taille());
        if (isset($infos['obligatoire'])) ($this->obligatoire = $infos['obligatoire']);
        if (isset($infos['auto_inc'])) ($this->auto_inc = $infos['auto_inc']);
    }

    private function _calculer_taille(){
        $pos1 = strpos($this->type, '(');
        $taille = strlen($this->type);
        ($pos1!==false) ? ($type = substr($this->type, 0, $pos1)) : ($type = substr($this->type, 0));
        $this->type= strtoupper($type);
        $this->taille = $this->TABTYPE[$this->type]['size'];
        if ($this->nature!="file") $this->nature = $this->TABTYPE[$this->type]['type'];
        $this->typeprog = $this->TABTYPE[$this->type]['nature'];
        $this->nature_form_extjs = $this->nature;
        if ($this->nature=='text') $this->nature_form_extjs = 'textfield';
        if ($this->nature=='date' || $this->nature=='datetime') $this->nature_form_extjs = 'datefield';
        if ($this->nature=='file') $this->nature_form_extjs = 'fileuploadfield';
    }
}
?>