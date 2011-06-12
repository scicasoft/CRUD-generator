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
        <form id="manuel" method='post' action='scripts/generation/manuel.php' name='infos' onsubmit='return envoi();'>
            <input type="hidden" id="etatgeneration" value="0">
            <div id="container">
                <div id="sitetitle">
                    <h1>G&eacute;n&eacute;rateur CRUD</h1>
                    <h2>pour ZEND Framework</h2>
                    <span id="logo"></span>
                    <a id="lien_page" href="archives.php">Gestion des archives</a>
                </div>
                <div id="content">
                    <div id="right">
                        <div id="infos_base">
                            <h2>Database</h2>
                            <table width="100%">
                                <tr>
                                    <td width="100px">Driver</td>
                                    <td>
                                        <select name="driver" id="driver" style="width:100%">
                                            <option value="mysql">mysql</option>
                                            <option value="mssql">mssql</option>
                                            <option value="oci">oci</option>
                                            <option value="pgsql">pgsql</option>
                                            <option value="sqlite">sqlite</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100px">Serveur</td>
                                    <td><input type="text" name="server" id="server" value="localhost" style="width:100%"/></td>
                                </tr>
                                <tr>
                                    <td width="100px">Utilisateur</td>
                                    <td><input type="text" name="username" id="username" value="root" style="width:100%"/></td>
                                </tr>
                                <tr>
                                    <td width="100px">Mot de Passe</td>
                                    <td><input type="password" name="userpass" id="userpass" style="width:100%"/></td>
                                </tr>
                            </table>
                            <br>
                            <center><input type="button" value="SE CONNECTER" id="se_connecter"></center>
                        </div>
                        <div id="infos_autres" style="display:none;">
                            <h2>Framework Ajax</h2>
                            <table>
                                <tr>
                                    <td><input type="radio" name="option" value="dojo" id="option1" checked /></td>
                                    <td><label for="option1">Dojo</label></td>
                                </tr>
                                <tr>
                                    <td width="50px"><input type="radio" name="option" value="extjs" id="option2" /></td>
                                    <td><label for="option2">Extjs</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="option" value="aucun" id="option3" /></td>
                                    <td><label for="option3">Aucun</label></td>
                                </tr>
                            </table>
                            <h2>Informations Supplementaires</h2>
                            <table>
                                <tr>
                                    <td>Prefixe Tables</td>
                                    <td width="110px"><input type="text" id="prefixe_table" name="prefixe_table" value="" style="width:100%" ></td>
                                </tr>
<!--                                <tr>
                                    <td>Afficher Identifiant des Tables dans le formulaire</td>
                                    <td> <input type="checkbox" id="afficher_id_table_dans_formulaire" name="prefixe_attribut_table"/> </td>
                                </tr>-->
                            </table>
                            <h2>Infos pour la G&eacute;n&eacute;ration Automatique</h2>
                            <table width="100%">
                                <tr>
                                    <td width="300px">Generer toutes les tables automatiquement</td>
                                    <td align="center"><input type="checkbox" id="auto" name="auto" class="activation"/></td>
                                </tr>
                            </table>
                            <div id="parametre_auto" style="display:none">
                                <table width="100%" cellspacing="10" style="border:1px solid gray">
                                    <tr>
                                        <td>Nom Base</td>
                                        <td id="base"></td>
                                    </tr>
                                    <tr>
                                        <td>Prefixe Attributs</td>
                                        <td>
                                            Nom de sa table <input type="checkbox" id="prefixe_attribut_table" name="prefixe_attribut_table" checked/>
                                            <input type="text" id="prefixe_attribut" name="prefixe_attribut" value="" style="width:100%; display:none" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Identifiants des Tables</td>
                                        <td><input type="text" id="identifiant_tables" name="identifiant_tables" value="id" style="width:100%" ></td>
                                    </tr>
                                    <tr>
                                        <td>Identifiants Externes</td>
                                        <td><input type="text" id="identifiant_externe" name="identifiant_externe" value="_id" style="width:100%" ></td>
                                    </tr>
                                    <tr>
                                        <td>Position pour les Identifiants externes</td>
                                        <td>
                                            <input type="radio" name="position" value="fin" id="position1" checked /><label for="position1">a la fin</label><br>
                                            <input type="radio" name="position" value="debut" id="position2" /><label for="position2">au debut</label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <table width="100%">
                                <tr>
                                    <td align="center"><input type="button" value="VALIDER" id="valider"></td>
                                    <td align="center"><input type="button" value="ANNULER" id="annuler"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="left" style="display:block">
                        <br>
                        <center id="loading"><!--loading . . .--></center>
                    </div>
                    <div id="footer">
                        <h2 class="hide">Site info</h2>
                        <span>innovation</span><br />
                        &copy; 2009 scicasoft
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>

