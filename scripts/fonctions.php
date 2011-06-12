<?
function execute_req($req){
    try{
        $conn = new PDO('mysql:host='.$_POST['d_host'].';dbname='.$_POST['d_name'], $_POST['d_user'], $_POST['d_userpass']);
        $exe = $conn->prepare($req);
        $exe->execute();
        return $exe;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function liste_table($attributs){
    $result1 = execute_req('SHOW TABLES');
    echo "<select id='table_$attributs' name='table_$attributs' class='table_relation' table='$attributs'>";
    $i=0;
    foreach ($result1 as $database1) {
        $i+=1;
        if ($i!=1){
            echo '<option value="'.$database1[0].'">'.$database1[0].'</option>';
        }
        else{
            echo '<option selected="selected" value="'.$database1[0].'">'.$database1[0].'</option>';
        }
    }
    echo '</select>';
}

function archiver($base, $chemin, $automatique, $serveur, $driver, $nbre_table=null, $nom_table=null){
    $time = time();
    $nom_archive = $chemin."/".$base.$time.".zip";
    $ini = "";
    $ini .= "SERVEUR = $serveur\n";
    $ini .= "DRIVER = $driver\n";
    $ini .= "BASE = $base\n";
    $ini .= "TIMESTAMP = $time\n";
    $ini .= "AUTOMATIQUE = $automatique\n";
    $ini .= "NBRE_DE_TABLE = $nbre_table\n";
    $ini .= "NOM_TABLE = $nom_table\n";
    $f = fopen("$chemin/$base/infos.ini","w");
    fwrite($f, $ini);
    fclose($f);
        
    copy(dirname(__FILE__)."/../packets/archive_vide.zip", $nom_archive);
    $zip = new ZipArchive;
    $zip->open($nom_archive);
    ajouter_dossier_dans_zip("$chemin/$base/", $zip);
    $zip->close();
    supprimer_dossier("$chemin/$base");
}

function ajouter_dossier_dans_zip($dir, $zipArchive, $zipdir = ''){
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            //Add the directory
            $zipArchive->addEmptyDir($dir);
            // Loop through all the files
            while (($file = readdir($dh)) !== false) {
                //If it's a folder, run the function again!
                if(!is_file($dir . $file)){
                    // Skip parent and root directories
                    if (($file !== ".") && ($file !== "..")){
                        ajouter_dossier_dans_zip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");
                    }
                }else{
                    // Add the files
                    $zipArchive->addFile($dir . $file, $zipdir . $file);
                }
            }
        }
    }
}

function supprimer_dossier($dossier) {
    $ouverture=@opendir($dossier);
    if (!$ouverture) return;
    while($fichier=readdir($ouverture)) {
        if ($fichier == '.' || $fichier == '..') continue;
        if (is_dir($dossier."/".$fichier)) {
            $r=supprimer_dossier($dossier."/".$fichier);
            if (!$r) return false;
        }
        else {
            $r=@unlink($dossier."/".$fichier);
            if (!$r) return false;
        }
    }
    closedir($ouverture);
    $r=@rmdir($dossier);
    if (!$r) return false;
    return true;
}
?>