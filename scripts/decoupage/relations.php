<? require_once '../fonctions.php'; ?>
<select id="<?php echo $_POST['prefixe']."-".$_POST['d_attr'] ?>" name="<?php echo $_POST['prefixe'].$_POST['d_attr'] ?>" >
    <?php
    $result = execute_req('DESC '.$_POST['d_table']);
    $i=0;
    foreach ($result as $database) {
        $i+=1;
        if ($i!=1){
            echo '<option value="'.$database[0].'">'.$database[0].'</option>';
        }
        else{
            echo '<option selected="selected" value="'.$database[0].'">'.$database[0].'</option>';
        }
    }
    ?>
</select>