<?
require_once '../fonctions.php';
if (isset ($_POST['d_host'])){
    $result = execute_req('DESC '.$_POST['d_table']);
    echo "<select id='attributs' name='attributs' size='10' style='width:100%'>";
    foreach ($result as $database) {
        echo "<option value='$database[0]'>$database[0]</option>";
    }
    echo "</select>";
}
?>