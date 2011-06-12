<?
require_once '../fonctions.php';
if (isset ($_POST['d_host'])){
    $result = execute_req('SHOW DATABASES');
    echo "<select name='basename' id='basename' size='10' style='width:100%'>";
    foreach ($result as $database) {
        echo "<option value='$database[0]'>$database[0]</option>";
    }
    echo "</select>";
}
?>