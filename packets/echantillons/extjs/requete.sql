#MOD_ID

INSERT INTO qo_modules VALUES ('#MOD_ID','scica','1.0','http://www.scicasoft.comze.com','description','demo','demo-[[NOM_TABLE_SANS_PRE_MIN]]',1,1);

INSERT INTO qo_modules_files VALUES ('#MOD_ID','[[NOM_TABLE_SANS_PRE_MIN]]/','[[NOM_TABLE_SANS_PRE_MIN]]-win.js',0,0,1,'QoDesk.[[NOM_TABLE_SANS_PRE]]Window');
INSERT INTO qo_modules_files VALUES ('#MOD_ID','[[NOM_TABLE_SANS_PRE_MIN]]/','[[NOM_TABLE_SANS_PRE_MIN]]-win-override.js',0,0,0,'');
INSERT INTO qo_modules_files VALUES ('#MOD_ID','[[NOM_TABLE_SANS_PRE_MIN]]/','[[NOM_TABLE_SANS_PRE_MIN]]-win.css',1,0,0,'');

INSERT INTO qo_modules_actions VALUES ('', '#MOD_ID', 'list', 'View [[NOM_TABLE_SANS_PRE_MIN]]');     #id1
INSERT INTO qo_modules_actions VALUES ('', '#MOD_ID', 'add', 'Add [[NOM_TABLE_SANS_PRE_MIN]]');       #id2
INSERT INTO qo_modules_actions VALUES ('', '#MOD_ID', 'delete', 'Delete [[NOM_TABLE_SANS_PRE_MIN]]'); #id3
INSERT INTO qo_modules_actions VALUES ('', '#MOD_ID', 'update', 'Edit [[NOM_TABLE_SANS_PRE_MIN]]');   #id4

INSERT INTO qo_privileges_has_module_actions VALUES ('','1','');    #id1
INSERT INTO qo_privileges_has_module_actions VALUES ('','1','');    #id2
INSERT INTO qo_privileges_has_module_actions VALUES ('','1','');    #id3
INSERT INTO qo_privileges_has_module_actions VALUES ('','1','');    #id4

INSERT INTO qo_members_has_module_launchers VALUES ('3','3','#MOD_ID','4','3','');

INSERT INTO qo_domains_has_modules VALUES ('','1','#MOD_ID');