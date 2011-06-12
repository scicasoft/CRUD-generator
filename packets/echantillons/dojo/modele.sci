<?php
class [[NOM_TABLE_MAJ]] extends Base[[NOM_TABLE_MAJ]]
{
    public function getRow($ID, $table){
        $resultat = Doctrine_Query::create()
        ->from($table.' b')
        ->where('num=?',$ID)
        ->execute();
        return  $resultat;
    }

    //Recuperer un ligne
    public function getRow2($ID,$table){
        $q = Doctrine::getTable($table)->createQuery('b')
        ->where('b.num = ?',$ID );
        return $q->fetchOne();
    }

    //Recuperer toutes les lignes de la table
    public function getAll($table){
        $resultat = Doctrine_Query::create()
        ->from($table.' b')
        ->execute();
        return $resultat;
    }

[[DOJO_GET_ALL_M]]

    //Supprimer une ou plusieur lignes
    public function getDelete($checkbox,$table){
        if(!empty($checkbox))
        {
            foreach($checkbox as $value)
            {
                $q = Doctrine_Query::create()
                ->delete($table.' b')
                ->where('b.num=?',$value)
                ->execute();
            }
        }
    }
}