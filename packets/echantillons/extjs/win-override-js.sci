var action_url='http://nom projet/module/controlleur/';
var [[NOM_TABLE]] = Ext.data.Record.create
 ([
[[EXTJS_TETE]]
]);

[[EXTJS_COMBOS_FONCTIONS]]

 var store= new Ext.data.Store
 ({
     id:'store',
	 proxy: new Ext.data.HttpProxy({       // on vas utiliser une requette Http
     url: action_url+'list',  //url de l'action qui gère notre grille
     method: 'POST'       //on va utiliser la m&eacute;thode poste pour notre requette
 }),
	 sortInfo: {field: '[[EXTJS_SORT]]', direction: 'ASC'}
   ,
	 reader: new Ext.data.JsonReader
	 (
	 	{
	 		root: 'results',
	 		totalProperty: 'total',
	 		id: '[[ID]]'
	    }
	     ,
	     [
[[EXTJS_TETE_TYPE]]
		 ]
		,[[NOM_TABLE]]
	 )
	,
	remoteSort: true
});
store.setDefaultSort('[[EXTJS_SORT]]', 'ASC');
//
var nbLignePP=25;
store.load({params:{start: 0, limit: nbLignePP}});

Ext.override(QoDesk.[[NOM_TABLE_SANS_PRE]]Window, {
    createWindow : function(){
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('[[NOM_TABLE_SANS_PRE]]-win');
        if(!win){
        	//var sm = new Ext.grid.RowSelectionModel({singleSelect:true});
        	this.store = store;
        	var sm = new Ext.grid.CheckboxSelectionModel();
        	var grid = new Ext.grid.GridPanel({
				id:'grid_rows',
        		name:'grid_rows',
        		border:false,
				cm: new Ext.grid.ColumnModel([
					sm,
				//	new Ext.grid.RowNumberer(),
[[EXTJS_COL_TAILLE]]
				]),
				ds:store,
				shadow: false,
				shadowOffset: 0,
				sm: sm,
				loadMask: true,
                bbar: new Ext.PagingToolbar({
			    store: store,
			    displayInfo: true,
			    emptyMsg: "Aucun enregistrement",
			    displayMsg: 'Enregistrements de {0} - {1} of {2}',
			    prependButtons: true,
			    pageSize: nbLignePP
			   	}),
				tbar: [{
					disabled: this.app.isAllowedTo(this.moduleAdd, this.moduleId) ? false : true,
					text:this.moduleAddText,
					tooltip:this.moduleAddTooltip,
					iconCls:'demo-grid-add',
					handler: this.add_something,
					scope: this
					//handler:function(){winForm.show()}
					}, '-', {
                    disabled: this.app.isAllowedTo(this.moduleUp, this.moduleId) ? false : true,
					text:this.moduleUpText,
					tooltip:this.moduleUpTooltip,
					iconCls:'demo-grid-option',
					handler: this.modified_something,
					scope: this
					},'-',{
                    disabled: this.app.isAllowedTo(this.moduleDel, this.moduleId) ? false : true,
					text:this.moduleDelText,
					tooltip:this.moduleDelTooltip,
					iconCls:'demo-grid-remove',
					handler: this.delete_something,
					scope: this
				}],
				viewConfig: {
					forceFit:true,
				    enableRowBody:true,
                    showPreview:true
				}
			});
			// example of how to open another module on rowselect
			sm.on('rowselect',function(){
				var selections = Ext.getCmp("grid_rows").selModel.getSelections();
				var id_enregistrement_modif = selections[0].json.id;
				//alert(id_enregistrement_modif);
				//this.modified_something();
			}, this);

            win = desktop.createWindow({
                id: '[[NOM_TABLE_SANS_PRE]]-win',
                title:this.moduleWinTitle,
                width:740,
                height:480,
                iconCls: 'grid-icon',
                shim:false,
                animCollapse:false,
                constrainHeader:true,
				layout: 'fit',
                items: grid,
                taskbuttonTooltip: this.moduleBtnTool,
                tools: [
					{
						id: 'refresh',
						handler: function(){
//						grid.getEl().mask();
						store.reload();
//						grid.getEl().unmask();
						},
						scope: this
					}
				]
            });

             // begin: modify top toolbar
//	        var tb = grid.getTopToolbar();
//
//			// example of getting a reference to another module's launcher object
//	        var tabWin;// = this.app.getModule('demo-tabs');
//
//			if(tabWin){
//				var c = tabWin.launcher;
//				tb.add({
//					// example button to open another module
//					text: 'Open Tab Window',
//					handler: c.handler,
//					scope: c.scope,
//					iconCls: c.iconCls
//				});
//			}
        }
        win.show();
    }
	,
    add_something : function(){

		var desktop = this.app.getDesktop();
		var notifyWin = desktop.showNotification({
			html: 'Ajout d\'un enregistrement...'
			, title: 'Patientez svp'
		});
		var win = desktop.getWindow(this.moduleWindowID);

        if(!win){
         function submit_ajout_enregistrement()
         {
			var sb = Ext.getCmp('ajout_enregistrement_statusbar');		//on instancie la status bar en bas a gauche de la fenetre
			templateSubmit(sb,nouvel_enregistrement, ajout_enregistrement_finit, "Enregistrement r&eacute;ussi");
			//if(o && o.responseText && Ext.decode(o.responseText).success){
					saveComplete(this.moduleSaveMsg1, this.moduleSaveMsg2);
				//}else{
				//	saveComplete('Erreur', 'Erreur au niveau du serveur.');
				//}
		}

		function ajout_enregistrement_finit(){
		   nouvel_enregistrement.form.reset();
		   	win.close();
		   	store.load();
		}

        function saveComplete(title, msg){
			notifyWin.setIconClass('x-icon-done');
			notifyWin.setTitle(title);
			notifyWin.setMessage(msg);
			desktop.hideNotification(notifyWin);
		}

		Ext.form.Field.prototype.msgTarget = 'side';
		var nouvel_enregistrement = new Ext.FormPanel({
			id: 'nouvel_enregistrement',
            fileUpload: true,
			frame: true,
			autoWidth: true,
			autoHeight:true,
			labelWidth: 150,
			labelAlign: 'right',
			bodyCfg: {tag: 'center', cls: 'x-panel-body'},
			defaults: {width: 280, msgTarget: 'side'},
			bodyStyle: 'padding:5px 5px 0',
			items: [{
					anchor:'95%'
					},
[[EXTJS_ELEMENTS_FORM]]
               ]
			,
			buttons: [{
				xtype: 'button',
					text: 'Enregistrer',
					handler: submit_ajout_enregistrement
				},{
					xtype: 'button',
					text: 'Annuler',
					handler: function() {win.close();}
			}]
		});

		var nouvel_enregistrement_total = new Ext.Panel({
			autoWidth: true,
			autoHeight:true,
			items: nouvel_enregistrement,		//On met dans ce panel le panel de login
			bbar: new Ext.StatusBar({
				id: 'ajout_enregistrement_statusbar',
				defaultText: 'Pr&ecirc;t'
				,plugins:toto
			})
		});
		var toto= new Ext.ux.ValidationStatus({
			form:'nouvel_enregistrement'
			});


            win = desktop.createWindow({
                id: 'bogus-detail'+id,
                title: '[[NOM_TABLE_MAJ]] Window ',
                width:600,
		        autoHeight:true,
                iconCls: 'bogus-icon',
                shim:false,
                animCollapse:false,
                constrainHeader:true,
				modal: true,
		        resizable: false,
				//closeAction:'hide',
				plain: true,
				items: nouvel_enregistrement_total
            });
        }
      win.show();
	},
	modified_something : function(){
		var desktop = this.app.getDesktop();
		var win = desktop.getWindow(this.moduleWindowID);
        if(!win){
        	//Fonction appel&eacute;e en cliquant sur submit du formulaire

		function submit_modif_enregistrement() {
			var sb = Ext.getCmp('modif_enregistrement_statusbar');		//on instancie la status bar en bas a gauche de la fenetre
			templateSubmit(sb,modif_enregistrement, modif_enregistrement_finit, "Enregistrement r&eacute;ussit");
		}

		function modif_enregistrement_finit() {
			modif_enregistrement.form.reset();
			win.close();
			store.reload();
		}

				//Formulaire en lui meme
				var modif_enregistrement = new Ext.FormPanel({
					id: 'modif_enregistrement',
					frame: true,
                    fileUpload: true,
					autoWidth: true,
					autoHeight:true,
					labelWidth: 200,
					labelAlign: 'right',
					bodyCfg: {tag: 'center', cls: 'x-panel-body'},
					defaults: {width: 280, msgTarget: 'side'},
					bodyStyle: 'padding:5px 5px 0',

					items: [{
							anchor:'95%'
						},
[[EXTJS_ELEMENTS_FORM]]
                       ]
					,
					buttons: [{
						xtype: 'button',
							text: 'Enregistrer',
							handler: submit_modif_enregistrement
						},{
							xtype: 'button',
							text: 'Annuler',
							handler: function() {win.close();}
					}]
				});

				var modif_enregistrement_total = new Ext.Panel({
					autoWidth: true,
					autoHeight:true,
					items: modif_enregistrement,		//On met dans ce panel le panel de login
					bbar: new Ext.StatusBar({
						id: 'modif_enregistrement_statusbar',
						defaultText: 'Pr&ecirc;t'
						,plugins: new Ext.ux.ValidationStatus({form:'modif_enregistrement'})
					})
				});

					if(Ext.getCmp("grid_rows").selModel.getCount() == 1)
				    {
					modif_enregistrement.form.reset();
					var selections = Ext.getCmp("grid_rows").selModel.getSelections();
                    Ext.getCmp("[[ID]]").setValue(selections[0].json.[[ID]]);

[[EXTJS_RECUP_SELECTION]]
				    }
					else
					{
						Ext.MessageBox.alert(this.moduleModifMsgSelect1, this.moduleModifMsgSelect2);
						return;
				    }


            win = desktop.createWindow({
                id: 'bogus-detail'+id,
                title: '[[NOM_TABLE_SANS_PRE]] Window',
                width:600,
		        autoHeight:true,
                iconCls: 'bogus-icon',
                shim:false,
                loadMask: true,
                delay:10,
                animCollapse:false,
                constrainHeader:true,
				modal: true,
		        resizable: false,
				plain: true,
				items: modif_enregistrement_total
            });
        }
        win.show();
	},
	delete_something:function()
		{
		//supprimer_enregistrement();


			if(Ext.getCmp("grid_rows").selModel.getCount() > 0)
   		 	{
				Ext.MessageBox.confirm(this.moduleSupMsgConfirm1,this.moduleSupMsgConfirm2, deleteenregistrement);
    		}
			else
			{
				Ext.MessageBox.alert(this.moduleModifMsgSelect1, this.moduleModifMsgSelect2);
    		}
//}

function deleteenregistrement(btn)
{
    if(btn=='yes'){
		var selections = Ext.getCmp("grid_rows").selModel.getSelections();
		//choix=selections;
		//var id_enregistrement_supprimer = selections[0].json.[[ID]];
		//alert(selections.length());
		var data = [];
		var nb=Ext.getCmp("grid_rows").selModel.getCount();
		//alert(nb);
		for(i=0;i<nb;i++){
			data[i]= selections[i].json.[[ID]];
		}
		//data= selections;
		Ext.Ajax.request({
			waitMsg: 'Patientez svp...',
			url: action_url+'delete',
			method: 'POST',
			params: {
				task: "suppr_enregistrement",
				data: Ext.encode(data)
			},
			success: function(response){
				Ext.MessageBox.alert(this.moduleSupMsgSucces1, this.moduleSupMsgSucces2);
			   	store.reload();

			},
			failure: function(response){
				Ext.MessageBox.alert(this.moduleSupMsgEchec1,this.moduleSupMsgEchec2);
			}
		});
	}
  }
}
});

//Fonction template utilis&eacute; pour valider un formulaire.
function templateSubmit(sb, formulaire, fonctionOK, messageAffiche){

	if (formulaire.form.isValid()) {					//si le formulaire dans login est valide

		sb.showBusy('Traitement en cours');				//on y affiche un message de chargement
		formulaire.getEl().mask();						//on applique un masque gris sur la fenetre nomm&eacute;e login (contenant le formulaire)
		//
		//obj = Ext.util.JSON.decode(action.response.responseText);		//L'objet JSON vas rechercher dans lire le r&eacute;sultat du POST et le d&eacute;coder

		//var message = obj.errors.reason;

		formulaire.form.submit({						//similaire à la m&eacute;thode post

			url: action_url+'add',				//URL de la page sur laquelle on effectue la m&eacute;thode post
			method: 'POST',
			reset: false,						//pour ne pas reseter les formulaires en cas d'echec
				//Si une erreure est survenue lors du POST
			failure: function(result, action) {
				//S'il s'agit d'une phrase g&eacute;n&eacute;rale on l'affiche		(errors = type d'action ; reason : nom de l'action, on peut nommer cela comme on veut dans le formulaire post)
					//Sinon on affiche le message d'erreur
				//if (message == undefined) message = obj.errors[0].msg;		//si le message n'inclue pas un ID pr&eacute;cis d'un champ de notre formulaire, on affiche simplement un message d'erreur g&eacute;n&eacute;ral dans notre status bar, et non a droite du champ concern&eacute;

				sb.setStatus({					//On modifie le texte de notre status bar
					text:'',
					iconCls:'',
					clear: true
				});
			},
				//S'il n'y a pas eu d'erreur dans notre POST...

			success: function(result, action) {
				sb.setStatus({
					text:messageAffiche,
					iconCls:'x-status-busy ',
					clear: true
				});

				//msgbox affichant le message de connexion, puis redirige l'enregistrement s'il clique sur ok

				Ext.MessageBox.show({
		           msg: 'Enregistrement des donn&eacute;es en cours, patientez svp...',
		           progressText: 'Enregistrement...',
		           width:400,
		           height:400,
		           wait:true,
		           waitConfig: {interval:200},
		           icon:'ext-mb-download'
				});
				setTimeout(function(){
            //This simulates a long-running operation like a database save or XHR call.
            //In real code, this would be in a callback function.
          		  Ext.MessageBox.hide();
           			 //Ext.example.msg('Done', 'Your fake data was saved!');
          		  if(Ext.getCmp("grid_rows").selModel.getCount() > 0)
		   		 	{
			 			Ext.MessageBox.alert(messageAffiche,'L\'enregistrement a ete modifi&eacute;e avec succes!',fonctionOK); 		}
					else
					{
						 Ext.MessageBox.alert(messageAffiche,'L\'enregistement a &eacute;t&eacute; ajout&eacute;e avec succes!',fonctionOK);
		    		}

        		}, 2000);
			}
		});

		formulaire.getEl().unmask();

					//on enlève le masque de notre formulaire
	} else {		//Si le formulaire n'est pas valide, on change la phrase dans notre status bar
		sb.setStatus({
			text:'Erreur : Formulaire non valide.',
			iconCls:'',
			clear: true
		});
	}
}
function cellDateRender(val)
{
    var dt =new Date(val);
    return dt.format('d/m/Y');
}