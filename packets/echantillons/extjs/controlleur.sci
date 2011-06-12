<?php

class [[NOM_TABLE_SANS_PRE]]Controller extends Zend_Controller_Action
{

    // public $url = BASE_URL.'[[NOM_TABLE]]/';

    public function init(){
        // Récupération des variables utiles
        $controller    = $this->getRequest()->getParam('controller');
        $defaultAction = $this->getFrontController()->getDefaultAction();

        // par défaut un appel à render() annule le rendu automatique
        // restauration du rendu via le helper viewRenderer.
        // (cette action rend une vue)
        $this->_helper->viewRenderer->setNoRender(false);
    }

    public function indexAction(){
        $this->_forward('list');
    }

    public function getLien(){
        return BASE_URL.'[[NOM_TABLE]]/';
    }
    //Ajout et Modification

    //Suppression
    public function deleteAction(){
        //Recuperation du champs cocher et poster
        $this->_helper->layout->disableLayout ();
        $this->_helper->removeHelper ( 'viewRenderer' );

        $checkbox=$this->_request->getPost('data');


        //Instanciation d'un objet de la classe [[NOM_TABLE_MAJ]]'
        $rows = new [[NOM_TABLE_MAJ]]();
        //Suppression de la ligne concerner par la methode getDelete dans la classe [[NOM_TABLE_MAJ]]
        if(!empty($checkbox)){
            $checkbox=MscCombo::decodejpson($checkbox);
            $rows->getDelete($checkbox,'[[NOM_TABLE_MAJ]]');
        }
    }

    //Liste des enregistrements
    public function listAction(){
        $this->_helper->layout->disableLayout ();
        $this->_helper->removeHelper ( 'viewRenderer' );
        //$offset = if((isset($this->_request->getPost('start'))) ? $this->_request->getPost('start') : 0;
        $offset=$this->_request->getPost('start');
        if(empty($offset))$offset=0;
        $limit=$this->_request->getPost('limit');
        if(empty($limit))$limit=25;
        $sort=$this->_request->getPost('sort');
        if(empty($sort))$sort='[[EXTJS_SORT]]';
        $dir=$this->_request->getPost('dir');
        if(empty($dir))$dir='ASC';
        //echo 'limit='.$limit.'dir='.$dir.'sort='.$sort.'star='.$offset;exit;

        //Recuperer toutes les ligne de la tables
        $rows = new [[NOM_TABLE_MAJ]]();
        //Recuperation de toutes les lignes de la table par la methode getAll() dans [[NOM_TABLE_MAJ]]
        $resrows=$rows->getAll('[[NOM_TABLE_MAJ]]',$limit,$dir,$sort,$offset);
        $resrowscount=$rows->getNbRows('[[NOM_TABLE_MAJ]]');
        $nbdata = array();
        $nbdata=$resrowscount->toArray();

        $data = array();
        $data['results'] = $resrows->toArray();
        $data['total'] = $nbdata[0]['total'];

        $resultat = Zend_Json :: encode($data);
        //print_r($resultat);exit;
        $this->getResponse ()->clearBody ();
        $this->getResponse ()->setHeader ( 'Content-Type', 'text/x-json' );
        $this->getResponse ()->setBody ($resultat );
    }

[[EXTJS_COMBOS]]

    public function addAction(){
        $this->_helper->layout->disableLayout ();
        $this->_helper->removeHelper ( 'viewRenderer' );

        //global $conn ;//variable blobal de doctrine connection

        $rows = new [[NOM_TABLE_MAJ]]();        //instanciation d'un objet de la classe [[NOM_TABLE_MAJ]]'
        if ($this->getRequest()->isPost()) 		//S'il s'agit du POST du formulaire de prise de contact
        {
            if($this->_request->getPost('[[ID]]')!='')			//S'il s'agit du POST du formulaire de prise de contact
            {
                $rows->assignIdentifier($this->_request->getPost('[[ID]]'));
            }
[[EXTJS_RECUP_FORMULAIRE]]

            $rows->save();
        }
    }
}