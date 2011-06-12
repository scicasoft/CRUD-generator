/* This code defines the module and will be loaded at start up.
 *
 * When the user selects to open this module, the override code will
 * be loaded to provide the functionality.
 *
 * Allows for 'Module on Demand'.
 */

QoDesk.[[NOM_TABLE_SANS_PRE]]Window = Ext.extend(Ext.app.Module, {
	moduleType : 'demo',
    moduleId : 'demo-[[NOM_TABLE_SANS_PRE_MIN]]',
    moduleAdd: 'add',
    moduleAddText: 'Ajouter',
    moduleDel: 'delete',
    moduleDelText: 'Supprimer',
    moduleUp: 'update',
    moduleUpText: 'Modifier',
    moduleBtnTool: '<b>[[NOM_TABLE_SANS_PRE]]</b><br />les [[NOM_TABLE_SANS_PRE]]s',
    moduleSaveMsg1: 'Termin&eacute;',
    moduleSaveMsg2: 'Enregistrement complet.',
    moduleModifMsgSelect1: 'Erreur',
    moduleModifMsgSelect2: 'Vous devez selectionner un enregistrement',
    moduleSupMsgConfirm1: 'Confirmation',
    moduleSupMsgConfirm2: 'Etes-vous sur de vouloir supprimer cet enregistrement ?',
    moduleSupMsgSucces1: 'Suppression effectu&eacute;e',
    moduleSupMsgSucces2: 'Demande supprim&eacute;e avec succ&egrave;s',
    moduleSupMsgEchec1: 'Erreur',
    moduleSupMsgEchec2: 'Un probl&egrave;me a eu lieu lors de la connexion à la BDD.',
    moduleAddTooltip: 'Ajouter un nouveau enregistrement',
    moduleUpTooltip: 'Modifier un enregistrement',
    moduleDelTooltip: 'Supprimer un enregistrement',
    moduleWinTitle: 'Liste des [[NOM_TABLE_SANS_PRE]]s',//a changer
    menuPath : 'StartMenu',
	launcher : {
        iconCls: '[[NOM_TABLE_SANS_PRE]]-icon',
        shortcutIconCls: 'demo-[[NOM_TABLE_SANS_PRE]]-shortcut',
        text: '[[NOM_TABLE_SANS_PRE]]s',
        tooltip: '<b>Liste des [[NOM_TABLE_SANS_PRE]]s</b><br />L\'ensemble des [[NOM_TABLE_SANS_PRE]]s'
    }
});