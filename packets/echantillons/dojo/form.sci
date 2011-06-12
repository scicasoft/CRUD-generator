<?php
class Forms_[[NOM_TABLE_MAJ]] extends Zend_Dojo_Form {

    //	protected $_standardElementDecorator = array(
    //        'ViewHelper',
    //         array('decorator' => array('td' => 'HtmlTag'), 'options' => array('tag' => 'td')),
    //        array('Label', array('tag' => 'td')),
    //        array('decorator' => array('tr' => 'HtmlTag'), 'options' => array('tag' => 'tr')),
    //   );

    public function init() {
        Zend_Dojo::enableForm($this);
        foreach ($this->getSubForms() as $subForm) {
            Zend_Dojo::enableForm($subForm);
        }
        $this->setMethod("POST");

[[DOJO_FORM_RELATION]]

[[DOJO_FORM_CHAMPS]]

        $submitButton =new Zend_Dojo_Form_Element_SubmitButton("Valider");
        $submitButton->setValue("valider");
        $this->addElement($submitButton);

        $this->setElementDecorators(array(
         'DijitElement',
         'Errors',
                array(array('data'=>'HtmlTag'),array('tag'=>'td')),
                array('Label',array('tag'=>'td','class'=>'dijitCalendarMonthLabel')),
                array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
            ));
        $this->setDecorators(array(
                                    'FormElements',
                array(array('data'=>'HtmlTag'),
                    array('tag'=>'table','cellspacing'=>'4')),
                                    'DijitForm'
            ));
    }
}