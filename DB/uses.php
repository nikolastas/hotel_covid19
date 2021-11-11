<?php
include ('credentials/credential.php');


$sql = "SELECT * FROM services ";
$result = mysqli_query($conn,$sql);
$all_name_of_service = mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);

if (isset($_POST['submit_use'])) {



    if( isset($_POST['service_id']) and $_POST['service_id']!="all_services_selected") {
        $service= mysqli_real_escape_string($conn,$_POST['service_id']);
        $service="service_id='$service'";
    }
    else{
        $service="1";
    }
    if( isset($_POST['start_datetime_used']) and $_POST['start_datetime_used']!="" ) {
        $start_datetime_used = mysqli_real_escape_string($conn, $_POST['start_datetime_used']);
        $start_datetime_used = "'$start_datetime_used'<= DATE(datetime_used)";
    }
    else{
        $start_datetime_used="1";
    }
    if( isset($_POST['end_datetime_used']) and $_POST['end_datetime_used']!="" ) {
        $end_datetime_used = mysqli_real_escape_string($conn, $_POST['end_datetime_used']);
        $end_datetime_used = "DATE(datetime_used)<='$end_datetime_used'";
    }
    else{
        $end_datetime_used="1";
    }

    if( isset($_POST['min_cost_of_service']) and $_POST['min_cost_of_service']!=""  ) {
        $min_cost_of_service = mysqli_real_escape_string($conn, $_POST['min_cost_of_service']);
        $min_cost_of_service = "'$min_cost_of_service'<= amount";
    }
    else{
        $min_cost_of_service="1";
    }
    if( isset($_POST['max_cost_of_service']) and $_POST['max_cost_of_service']!="" ) {
        $max_cost_of_service = mysqli_real_escape_string($conn, $_POST['max_cost_of_service']);
        $max_cost_of_service = "amount<='$max_cost_of_service'";

    }
    else{
        $max_cost_of_service="1";
    }




    $sql = "SELECT  * FROM erwthma7 WHERE ".$max_cost_of_service." AND ".$min_cost_of_service." AND ".$start_datetime_used." AND ".$end_datetime_used." AND ".$service." ORDER BY  service_id ASC" ;

    $result = mysqli_query($conn,$sql);

    $get_service = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);







}
else {
    $sql = 'SELECT  * FROM erwthma7 ORDER BY  service_id ASC ';
    $result = mysqli_query($conn,$sql);

    $get_service = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);

}




mysqli_close($conn);

?>




<!DOCTYPE>
<html>
<?php include('headandfoot/header.php');?>

<section>
    <div class="costumers-views container center">
        <div  class="col-sm-3 same-line ">
        <form method="POST"  >

            <div>select the name of service</div>
            <select class="browser-default grey-text  inline " name="service_id">
                <option value="all_services_selected" default>All services selected</option>
                <?php foreach ($all_name_of_service as $service){?>
                <option value="<?php echo html_entity_decode($service['service_id']);?>">
                     <?php echo html_entity_decode($service['service_description']);?>
                </option>
                <?php }?>
            </select>
            <div class="same-line ">
                <label>Minimum Cost:</label>
                    <input type="number" name="min_cost_of_service">
                <label>Max cost:</label>
                    <input type="number" name="max_cost_of_service">

            </div>

            <div class="same-line">
                <label>Start date:</label>
                <input type="date" name="start_datetime_used" >


                <label>End date:</label>
                <input type="date" name="end_datetime_used" >
            </div>

                    <p>
                <input type="submit"  name="submit_use" value="search" class=" container btn brand z-depth-0">
                    </p>

        </form>
        </div>

        <?php $prev=0;$x=0; ?>
        <ul class="collection with-header myul">
        <?php foreach ($get_service as $uses){ ?>

                <?php if($prev!==$uses['service_description']){  ?> <!--diaforetiko service -->
                <?php if($x==1){ ?> <!--ektos apo 1h fora -->
                    </table>
                    <?php } $x=1;?>
                <li class="collection-header"><h4><?php echo htmlspecialchars($uses['service_description']); ?></h4></li>
                <table class="container center">
                    <tr>
                        <th><li class="collection-item center "><h5>Name: </h5></li></th>
                        <th><li class="collection-item center "><h5>Amount: </h5></li></th>
                        <th><li class="collection-item center "><h5>Date and Time used: </h5></li></th>
                    </tr>
                <?php $prev=$uses['service_description']; } ?>

                    <tr>
                        <th><li class="collection-item center "><?php echo htmlspecialchars($uses['first_name'])." ".htmlspecialchars($uses['last_name']); ?></li></th>
                        <th><li class="collection-item center "><?php echo htmlspecialchars($uses['amount'] );?> </li></th>
                        <th><li class="collection-item center "><?php echo htmlspecialchars($uses['datetime_used'] );?> </li></th>
                    </tr>



            </ul>




        <?php }?>
        </table>


    </div>
</section>


<?php include('headandfoot/footer.php');?>
</html>
