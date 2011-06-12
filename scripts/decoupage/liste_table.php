<?
require_once '../fonctions.php';
if (isset ($_POST['d_host'])){
    $result = execute_req('SHOW TABLES');
    echo "<select id='tablename' name='tablename' size='10' style='width:100%'>";
    foreach ($result as $database) {
        echo "<option value='$database[0]'>$database[0]</option>";
    }
    echo "</select>";
}
?>