<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>generateur CRUD</title>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <link type="text/css" rel="stylesheet" href="stylesheets/design.css" media="screen,projection" />
        <script type="text/javascript" src="javascripts/prototype.js"></script>
        <script type="text/javascript" src="javascripts/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="javascripts/fonctions.js"></script>
    </head>
    <body>
        <div id="load"></div>
        <div id="container">
            <div id="sitetitle">
                <h1>G&eacute;n&eacute;rateur CRUD</h1>
                <h2>pour ZEND Framework</h2>
                <span id="logo"></span>
                <a id="lien_page" href="index.php">Nouvelle Generation</a>
            </div>
            <div id="content">
                <div id="right">
                    <h4 class="lien" info="tout">Afficher tout</h4>
                    <h4 class="lien" info="dojo">Liste pour dojo</h4>
                    <h4 class="lien" info="extjs">Liste pour extjs</h4>
                    <h4 class="lien" info="aucun">Liste de generations simples</h4>
                </div>
                <div id="left" style="display:block">
                    <? $liste_type = array("dojo","extjs","aucun"); $j=0;?>
                    <? $liste_titre = array("Liste des CRUD genere pour PHP5-dojo","Liste des CRUD genere pour PHP5-extjs","Liste des CRUD genere pour PHP5 sans bibliotheque Ajax")?>
                    <? for ($i = 0 ; $i < 3 ; $i++) { ?>
                    <div id="<?= $liste_type[$i] ?>" class="informations">
                        <br>
                        <h3><?= $liste_titre[$i] ?></h3>
                        <table id="liste_archives" width="100%" border="1" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>serveur</td>
                                    <td>driver</td>
                                    <td>base</td>
                                    <td>generation auto</td>
                                    <td>nombre de tables</td>
                                    <td>nom table generee</td>
                                    <td>date</td>
                                    <td width="80px" colspan="2"></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $type = $liste_type[$i];
                                $chemin = dirname(__FILE__)."/sortie/$type/";
                                $dossier=@opendir($chemin);
                                while($fichier=readdir($dossier)){
                                    $j+=1;
                                    if ($fichier!='.' && $fichier!='..'){
                                        $zip = zip_open($chemin.$fichier);
                                        while ($ini=zip_read($zip)){
                                            $nom = zip_entry_name($ini);
                                            if ($nom == "infos.ini"){
                                                $test = zip_entry_read($ini);
                                                $f = fopen($chemin."infos.ini","w");
                                                fwrite($f, $test);
                                                fclose($f);
                                                $infos = parse_ini_file($chemin."infos.ini");
                                                unlink($chemin."infos.ini");
                                            }
                                        }
                                        ?>
                                <tr id="<?= $j ?>">
                                    <td><?= $infos['SERVEUR'] ?></td>
                                    <td><?= $infos['DRIVER'] ?></td>
                                    <td><?= $infos['BASE'] ?></td>
                                    <td align="center"><?= ($infos['AUTOMATIQUE']==0) ? "NON" : "OUI" ?></td>
                                    <td align="center"><?= ($infos['NBRE_DE_TABLE']=='') ? 1 : $infos['NBRE_DE_TABLE'] ?></td>
                                    <td><?= $infos['NOM_TABLE'] ?></td>
                                    <td align="center"><?= date("d-m-Y G-i-s", $infos['TIMESTAMP']) ?></td>
                                    <td align="center"><a href="sortie/<?= $type ?>/<?= $fichier ?>"><img src="images/zip.gif" width="30px"></a></td>
                                    <td align="center"><a class="delete" href="#" lien="<?= $chemin.$fichier ?>" iden="<?= $j ?>"><img src="images/delete.png"></a></td>
                                </tr>
                                <?
                            }
                        }
                        ?>
                            </tbody>
                        </table>
                    </div>
                    <? } ?>
                </div>
                <div id="footer">
                    <h2 class="hide">Site info</h2>
                    <span>innovation</span><br />
                    &copy; 2009 scicasoft
                </div>
            </div>
        </div>
    </body>
</html>

