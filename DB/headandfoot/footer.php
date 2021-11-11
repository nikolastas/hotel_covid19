<?php

include ('credentials/credential.php');

function delete($sql){

    if((mysqli_query($conn, $sql))){
        //success
        header('Location: index.php');
    }{
        //fail
        echo 'query error: '.mysqli_error($conn);
    }
}


if(isset($_POST['delete all'])){
$sql = "DROP TABLE have_service";
delete($sql);
$sql1 ="DROP TABLE service_charge";
    delete($sql1);
$sql2 =        "DROP TABLE service_takes_place";
delete($sql2);
$sql3 =        "DROP TABLE costumer_registered_to_services";
delete($sql3);
$sql4 =        "DROP TABLE no_registered_services";
delete($sql4);
$sql5 =      " DROP TABLE registered_services";
delete($sql5);
$sql6 =      "DROP TABLE services";
delete($sql6);
$sql7 =      "DROP TABLE have_access";
delete($sql7);
$sql8 =      "DROP TABLE visit";
delete($sql8);
$sql9 =      "DROP TABLE costumer";
delete($sql9);
$sql10 =      "DROP TABLE places";
delete($sql10);



}

?>
<footer class="section">
    <div class="center grey-text"> Andreas Evaggelatos</p> Nikolas Tasiopoulos</div>
    <form method="post"  class="center">
       <!--  <input type="submit" name="delete_all" value="delete_all" class="btn" > -->
    </form>
</footer>