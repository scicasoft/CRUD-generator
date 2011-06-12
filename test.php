<?php
	require_once 'tete1.php';
	if (isset($_POST['txt']))
	{
		$texte=addslashes($_POST["txt"]);
		$titre=addslashes($_POST["titre"]);
		if ($_POST['maj']!="0")
		{
			mysql_connect(hote(), user(), password());
			mysql_select_db(base());
			mysql_query('UPDATE tuto SET titre="'.$titre.'", texte="'.$texte.'", publie="'.$_POST["option"].'", date_pub="'.time().'" where num="'.$_POST['maj'].'"') or die(mysql_error()) ;
			header('Location: mestutos.php');
		}
		else
		{
			mysql_connect(hote(), user(), password());
			mysql_select_db(base());
			mysql_query('INSERT INTO tuto VALUES("","'.$titre.'","'.$texte.'","'.$_SESSION["pseudo"].'","'.time().'",0,0,'.$_POST["option"].',"","'.time().'","0")') or die(mysql_error()) ;
			header('Location: ecriretuto.php');
		}
	}

	autorisation(2);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
   <head>
       <title>ESP - génie informatique</title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	   <link rel="stylesheet" media="screen" type="text/css" title="DUTINFO" href="style.css" />
	   <script language="javascript" type="text/javascript" src="bbcode/bbcode/bbcode.js"></script>
</head>
<body onload="initial();" ><div id="ech" style="display:none"></div>
<?php
	if (isset($_GET['info']))
	{
		mysql_connect(hote(), user(), password());
		mysql_select_db(base());
		$reponse = mysql_query('SELECT * FROM tuto WHERE num="'.$_GET['info'].'"') or die(mysql_error()) ;
		if ($donnees = mysql_fetch_array($reponse))
		{
			?>
			<script type="text/javascript">
  				<!--
  					document.getElementById('ech').innerHTML="<?php echo $donnees['texte'] ?>";
  				//-->
			</script>
			<?php
		}
	}
?>
<div id="wrap">

<div id="header">
<h1><a href="#"></a></h1>
</div>

<div id="menu">
<ul>
<li><a href="index.php">ACCUEIL</a></li>
<li><a href="tutos.php">TUTORIELS</a></li>
<li><a href="forum/index.php">FORUM</a></li>
<li><a href="livredor.php">LIVRE D'OR</a></li>
</ul>
</div>

<div id="content">
<?php
require_once 'menusecond.php';
?>

<!--------------------------------------------------------------------->
	<h2>Ecriture Tutoriel</h2>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<table width="600" border="0">
  <tr>
    <td width="338">
<select	size=1
		id="selfnt"
		style="background-color:#DDDDEE"
		onchange="FontChx(this);">
	<optgroup label="Police">
		<option>Arial</option>
		<option>Comic sans MS</option>
		<option>Courier</option>
		<option>Courier New</option>
		<option>Fixedsys</option>
		<option>Garamond</option>
		<option>Georgia</option>
		<option>Lucida Console</option>
		<option>MS Sans Serif</option>
		<option>MS Serif</option>
		<option>Time</option>
		<option>Verdana</option>
	</optgroup>
</select>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<select	size=1
		id="seltai"
		style="background-color:#DDDDEE"
		onchange="TailChx(this);">
	<optgroup label="Taille">
		<option>1</option>
		<option>2</option>
		<option>3</option>
		<option>4</option>
		<option>5</option>
		<option>6</option>
		<option>7</option>
	</optgroup>
</select>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<input	type="image"
			src="word/Bold.gif"
			title="Gras"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Italic.gif"
			title="Italique"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Underline.gif"
			title="Souligné"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/StrikeThrough.gif"
			title="Rayé"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/SubScript.gif"
			title="Indices"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/SuperScript.gif"
			title="Exposants"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/ForeColor.gif"
			title="Couleur des Caractères"
			onclick="CoulAff(this,document.getElementById('Saisie').style.color);"/>
<input	type="image"
			src="word/BackColor.gif"
			title="Couleur du Fond"
			onclick="CoulAff(this,document.getElementById('Saisie').style.backgroundColor);"/>
<input	type="image"
			src="word/JustifyLeft.gif"
			title="Justifié à Gauche"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/JustifyRight.gif"
			title="Justifié à Droite"
			onclick="btn1(this)";/>
<input	type="image"
			src="word/JustifyCenter.gif"
			title="Centré"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/InsertOrderedList.gif"
			title="Liste numérotée"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/InsertUnorderedList.gif"
			title="Liste à puces"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Outdent.gif"
			title="décaler à Gauche"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Indent.gif"
			title="décaler à Droite"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Delete.gif"
			title="Effacer"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Undo.gif"
			title="Annule actions"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Redo.gif"
			title="refaire l'action"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/SelectAll.gif"
			name="imgSelectAll"
			id="imgSelectAll"
			title="tout sélectionner"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Unselect.gif"
			title="invalider la sélection"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/html.gif"
			title="voir le code HTML"
			onclick="Voir(this);"/>
<!--
<input	type="image"
			src="word/Transmettre.gif"
			title="Envoyer"
			onclick="maj();"/>
-->
<input	type="image"
			src="word/CreateLink.gif"
			title="Créer Lien"
			onclick="btn1(this,true,'http://');"/>
<input	type="image"
			src="word/InsertHorizontalRule.gif"
			title="Insérer un ligne horizontale"
			onclick="btn1(this);"/>
<!--
pour FF :
execCommand("createlink",false,"http://....")
-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div	style="display:none;"
	id="SiIe"/>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	réservé à Internet Explorer ?
	pas réussi à faire fonctionner avec Mozilla, par exemple
  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<input	type="image"
			src="word/Copy.gif"
			title="Copier"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Cut.gif"
			title="Couper"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Paste.gif"
			title="Coller"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/SaveAs.gif"
			title="Sauver"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/Print.gif"
			title="Imprimer"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/InsertInputFileUpload.gif"
			title="Fichier à charger"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/UnLink.gif"
			title="supprimer les Liens"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/InsertButton.gif"
			title="Bouton"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/InsertInputButton.gif"
			title="Input button"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/InsertInputReset.gif"
			title="bouton Reset"
			onclick="btn1(this);"/>
<input	type="image"
			src="word/InsertInputSubmit.gif"
			title="bouton Submit"
			onclick="btn1(this);" />
<input	type="image"
			src="word/InsertFieldset.gif"
			title="FieldSet"
			onclick="btn1(this);" />
<input	type="image"
			src="word/InsertIFrame.gif"
			title="IFrame"
			onclick="btn1(this);" />
<input	type="image"
			src="word/InsertImage.gif"
			title="Image"
			onclick="btn1(this,'false','');" />
<input	type="image"
			src="word/InsertInputText.gif"
			title="input text"
			onclick="btn1(this);" />
<input	type="image"
			src="word/InsertInputPassword.gif"
			title="input password"
			onclick="btn1(this);" />
<input	type="image"
			src="word/InsertParagraph.gif"
			title="Paragraphe"
			onclick="btn1(this);" />
<input	type="image"
			src="word/InsertInputHidden.gif"
			title="input hidden"
			onclick="btn1(this);" />
<input	type="image"
			src="word/InsertInputRadio.gif"
			title="input hidden"
			onclick="btn1(this);" />
<input	type="image"
			src="word/InsertTextArea.gif"
			title="TextArea"
			onclick="btn1(this);" />
<input	type="image"
			src="word/InsertSelectListbox.gif"
			title="Select multiple"
			onclick="btn1(this);" />
<input	type="image"
			src="word/InsertSelectDropdown.gif"
			title="Select unique"
			onclick="btn1(this);" />
</div><br/></td>
    <td width="310">&nbsp;</td>
  </tr>
</table>
<br/>
<!--------------------------------------------------------------------->
<!-- 	laisser les couleurs sont forme rgb=(r,g,b)
													########################################### -->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<form action="ecriretuto.php"
		method="post"
		name="frm"><!--	############################################
								#	mettre dans action le programme.php qui #
								#	recevra le texte, dans $_POST["txt"]    #
								############################################ -->
  <div align="center">Titre :
    <input name="titre" id="titre" type="text" size="35"/>
    <br/><br/>
	<input name="maj" type="text" value="0" id="maj" style="display:none"/>
	<?php
		if (isset($_GET['info']))
		{
			?>
				<script type="text/javascript">
					document.getElementById('maj').value="<?php echo $_GET['info'] ?>";
				</script>
			<?php
			mysql_connect(hote(), user(), password());
			mysql_select_db(base());
			$reponse = mysql_query('SELECT * FROM tuto WHERE num="'.$_GET['info'].'"') or die(mysql_error()) ;
			if ($donnees = mysql_fetch_array($reponse))
			{
				?>
				<script type="text/javascript">
  						document.getElementById('titre').value="<?php echo addslashes($donnees['titre']) ?>";
				</script>
				<?php
			}
		}
	?>
<textarea
	name="txt"
	id="txt"
	style="	font-family:Verdana;
				display:none;
				font-size:12px;
				border-color:#000000;
				border:1px inset gray;
				overflow:auto;
				position:absolute;
				top:80;
				width:600px;
				height:800px;
				color:#400040;
				background-color:#C0C0C0;"></textarea>

  </div>

  <iframe	style="	font-family:Verdana;
						font-size:12px;
                        display:none;
						border:1px solid #000000;
						overflow:auto;
						top:80;
						width:600px;
						height:800px;
						color:rgb(64,0,64);
						background-color:#CCCCCC;"
			name="Saisie"
			id="Saisie"
			></iframe>
<table width="200" border="0" align="center">
  <tr>
    <td>
		<label>
  	    	<input type="radio" name="option" value="0" checked="checked"/>
  	    	enregistrer sans publier		</label>
  	  	<br />
  	  	<label>
  	    	<input type="radio" name="option" value="1" />
  	    	publier		</label>
  	  	<br />	</td>
  </tr>
  <tr>
    <td>
		<div align="center">
		  <input name="valider" type="submit" onclick="ma();"/>
        </div></td>
  </tr>
</table>
</form>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<div	id="CoulMnu"
			name="CoulMnu"
			style="	font-family:Verdana;
						font-size:12px;
						font-weight:bold;
						display:none;
						position:absolute;
						border:1px solid #000000;
						z-index:2;
						left:0;
						top:150px;
						background-color:#FFFFFF;" />
		<table	style="float:left"
					id="Coul" name="Coul">
			<tr><script type="text/javascript">
				var col=-1;pas=63;
				for ( var r=0; r<=255; r+=pas )
				{	for ( var g=0; g<=255; g+=pas )
					{	for ( var b=0; b<=255; b+=pas )
						{	col++;
							if ( col%25==0 )
							{	document.write("</tr><tr style='height:24px;'>");	}
							document.write("<td><button style='width:14px;cursor:crosshair;border:0;background-color:"+
									"rgb("+r+","+g+","+b+");'"+
									" onclick='choix(this);' onmouseover='survol(this);' >&nbsp;</button></td>");
						}
					}
				}
			</script></tr>
		</table>
		<table>
			<tr>	<td style="text-align:right;">Survol</td>
					<td>	<input type="text" id="sur" size=2 /></td>
					<th>	<label id="CoulQui"></label></th></tr>
			<tr>	<td style="text-align:right;">Choix</td>
					<td>	<input type="text" style="background-Color:#FFFFFF" id="chx" size=2 /></td>
					<th>	<button onclick="CoulVal();">Valider</button>
							&nbsp;&nbsp;<button onclick="document.getElementById('CoulMnu').style.display='none';" >
														Abandonner</button></th></tr>
			<tr>	<td></td></tr>
			<tr>	<td style="text-align:right;">Rouge</td>
					<td>	<input type="text" style="color:#FFFFFF" id="rr" size=3
										onkeyup="gid('rrchgt').scrollLeft=this.value;
													modCoul();" /></td>
					<td>	<div 	id="rrchgt" onscroll="modCoul();"
									style="FONT-SIZE:1px;Overflow-X:scroll;WIDTH:300px;HEIGHT:20px">
								<DIV  style="WIDTH:555px">&nbsp;</DIV></div></td></tr>
			<tr>	<td style="text-align:right;">Vert</td>
					<td>	<input type="text" style="color:#FFFFFF" id="gg" size=3
										onkeyup="gid('ggchgt').scrollLeft=this.value;
													modCoul();" /></td>
					<td>	<div 	id="ggchgt" onscroll="modCoul();"
									style="FONT-SIZE:1px;Overflow-X:scroll;WIDTH:300px;HEIGHT:20px">
								<DIV  style="WIDTH:555px">&nbsp;</DIV></div></td></tr>
			<tr>	<td style="text-align:right;">Bleu</td>
					<td>	<input type="text" style="color:#FFFFFF" id="bb" size=3
										onkeyup="gid('bbchgt').scrollLeft=this.value;
													modCoul();" /></td>
					<td>	<div 	id="bbchgt" onscroll="modCoul();"
									style="FONT-SIZE:1px;Overflow-X:scroll;WIDTH:300px;HEIGHT:20px">
								<DIV  style="WIDTH:555px">&nbsp;</DIV></div></td></tr>
		</table>
</div>
<!--------------------------------------------------------------------->
<?php
	require_once 'foot.php';
?>
<!--------------------------------------------------------------------->
