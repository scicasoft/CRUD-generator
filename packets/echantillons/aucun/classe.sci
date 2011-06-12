<?php
require_once 'root.php';

class [[NOM_TABLE]] extends MaClasse {
[[DECLARATION_ATTRIBUTS]]

    public function __construct() { }

    public static function count() {
        $req = 'SELECT count(*) as n FROM [[NOM_TABLE]]';
        $res = execute_req($req);
        foreach ($res as $r) {
            $taille = $r['n'];
        }
        return $taille;
    }
	public function ajout() {
		$req="INSERT INTO `[[NOM_TABLE]]` VALUES ([[AJOUT_VALUES]])";
		$this->execute_req($req);
	}

	public function modifier() {
		$req="UPDATE `[[NOM_TABLE]]` SET [[MODIFIER_SET]] WHERE `[[ID]]`='$this->id'";
		$this->execute_req($req);
	}

   public static function getAll($conditions = NULL) {
        $where='';
        $order='';
        $limit='';
        if ($conditions['where']) $where = " where ".$conditions['where'];
        if ($conditions['order']) $order = " order by ".$conditions['order'];
        if ($conditions['limit']) $limit = " limit ".$conditions['limit'];
        $req="SELECT * FROM `[[NOM_TABLE]]` $where $order $limit";
        $res = execute_req($req);
        $i=0;
        foreach ($res as $r) {
            $resultat[$i] = [[NOM_TABLE]]::tabto[[NOM_TABLE]]($r);
            $i+=1;
        }
        return $resultat;
    }

	public static function supprimer($id) {
		$req="DELETE FROM `[[NOM_TABLE]]` WHERE `[[ID]]`='$id'";
		execute_req($req);
	}

	public static function get($id) {
        $new = new [[NOM_TABLE]]();
        $req="SELECT * FROM `[[NOM_TABLE]]` WHERE `[[ID]]`='$id'";
        $res=execute_req($req);
        foreach ($res as $row) {
            $new = [[NOM_TABLE]]::tabto[[NOM_TABLE]]($row);
        }
        return $new;
    }


	public static function tabto[[NOM_TABLE]]($tab) {
		$[[NOM_TABLE]] = new [[NOM_TABLE]]();
[[TAB_TO]]
		return $[[NOM_TABLE]];
	}
    
	public static function recuperer_elements(){
        return [[NOM_TABLE]]::tabto[[NOM_TABLE]]($_POST);
    }

[[RELATION_N]]

[[RELATION_UN]]

}
?>