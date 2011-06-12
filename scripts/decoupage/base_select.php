<?
require_once '../fonctions.php';
if (isset ($_POST['d_host'])){
    $result = execute_req('SHOW DATABASES');
    echo "<select name='nom_base' id='nom_base' style='width:100%'>";
    foreach ($result as $database) {
        echo "<option value='$database[0]'>$database[0]</option>";
    }
    echo "</select>";
}
?>