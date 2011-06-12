<?php
  class [[NOM_TABLE_MAJ]]Controller extends Zend_Controller_Action {
    public function init()
    {
        $controller    = $this->getRequest()->getParam('controller');
        $defaultAction = $this->getFrontController()->getDefaultAction();
        $this->_helper->viewRenderer->setNoRender(false);
    }
    public function indexAction()
    {
        $this->_forward('list');
    }
    public function getLien()
    {
        return BASE_URL.'[[NOM_TABLE_MAJ]]/';
    }
    public function editAction()
    {
//        global $conn ;//variable blobal de doctrine connection
        $rows = new [[NOM_TABLE_MAJ]]();//instanciation d'un objet de la classe Eleves'
        $checkbox=$this->_request->getPost('checkbox');//Recuperation du champs cocher pour une modif
        $form = new Forms_[[NOM_TABLE_MAJ]]();//Intanciation du Formulaire
//        $form->setDecorators(array(
//                'FormElements',
//                array('HtmlTag', array('tag' => 'table')),
//                'Form'
//            ));
//        $form->setElementDecorators(array(
//        'ViewHelper',
//        'Errors',
//                array('decorator' => array('td' => 'HtmlTag'), 'options' => array('tag' => 'td')),
//                array('Label', array('tag' => 'td')),
//                array('decorator' => array('tr' => 'HtmlTag'), 'options' => array('tag' => 'tr')),
//            ));
        //Modification
        if(!empty($checkbox)){
            $objetrows=$rows->getRow2($checkbox[0],'[[NOM_TABLE_MAJ]]');//Recuperation de la ligne a modifier sous forme d'objet par la methode getRow2()dans [[NOM_TABLE_MAJ]] '
            $form ->setDefaults($objetrows->toArray());//remplissage des du formulaire par les valeurs de l'objet recuperer'
        }
        else
        {
            //Validation du formulaire par $_POST
            if ($this->getRequest()->isPost() && $form->isValid($_POST))
            {
//                $conn->beginTransaction();//Creation d'une transaction
                if($form->getValue('ID')>0){//verifie si ID>0 pour la modif
                    $rows->assignIdentifier($form->getValue('ID'));//Renseigner l'id' par la methode assignIdentifier() pour faire la modif
                }
                $rows->fromArray($form->getValues(true));//Recuperation des valeurs des champs du formulaire poster
                $rows->save();//methode d'insertion ou de modification'
//                $conn->commit();//methode d'insertion complete grace a la transaction creer en haut
                $this->_redirect($this->getLien().'list');//Redirection vers la liste
            }
        }
        $this->view->form = $form; //Rendu du formulaire
    }
    //Suppression
    public function deleteAction()
    {
        $checkbox=$this->_request->getPost('checkbox');
        //Instanciation d'un objet de la classe [[NOM_TABLE_MAJ]]'
        $rows = new [[NOM_TABLE_MAJ]]();
        //Suppression de la ligne concerner par la methode getDelete dans la classe [[NOM_TABLE_MAJ]]
        $rows->getDelete($checkbox,'[[NOM_TABLE_MAJ]]');
        /*$rows->ID = $checkbox[0] ;
        $rows->delete();*/
        //Redirection
        $this->_redirect($this->getLien().'list');
    }
    //Liste des enregistrements
    public function listAction()
    {
        //Recuperer toutes les ligne de la tables
        $rows = new [[NOM_TABLE_MAJ]]();
        //Recuperation de toutes les lignes de la table par la methode getAll() dans [[NOM_TABLE_MAJ]]
        $resrows=$rows->getAll('[[NOM_TABLE_MAJ]]');
        // Gestion de la pagination
        $paginator = Zend_Paginator::factory($resrows->toArray());
        $paginator->setItemCountPerPage(10);//  =nombre de ligne afficher par page
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page'));
        $this->view->rows = $paginator;
    }
}
?>