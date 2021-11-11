<?php
include ('credentials/credential.php');



if (isset($_POST['submit_use'])) {
    if( isset($_POST['costumer_age']) and $_POST['costumer_age']!="all_ages") {
        $costumer_age= mysqli_real_escape_string($conn,$_POST['costumer_age']);
        if ($costumer_age=='opt1'){

            $costumer_age="DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 20 YEAR)>=date_of_birth AND date_of_birth>=DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 40 YEAR)";
        }
        elseif ($costumer_age=='opt2'){

            $costumer_age="DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 41 YEAR)>=date_of_birth AND date_of_birth>=DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 60 YEAR)";
        }
        else{
            $costumer_age="DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 61 YEAR)>=date_of_birth ";
        }

    }
    else{
        $costumer_age="1";
    }
    if( isset($_POST['range_of_query']) and $_POST['range_of_query']!="the last year") {
        $range_of_query= mysqli_real_escape_string($conn,$_POST['range_of_query']);
        $range_of_query="datetime_used>=DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 MONTH)";
        $range_of_query1="start_time>=DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 MONTH)";

    }
    else{
        $range_of_query="datetime_used>=DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 YEAR)";
        $range_of_query1="start_time>=DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 YEAR)";
    }
    $sql = 'SELECT COUNT(start_time) AS num_of_visits ,place_id,name FROM erwthma9,costumer WHERE '.$range_of_query1.' AND erwthma9.nfc_id=costumer.nfc_id AND '.$costumer_age.' GROUP BY place_id ORDER BY num_of_visits DESC LIMIT 5';
    $result = mysqli_query($conn,$sql);

    $visits = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);
    $sql = 'SELECT COUNT(datetime_used) AS num_of_uses ,service_id,service_description FROM erwthma7,costumer WHERE '.$range_of_query.' AND erwthma7.nfc_id=costumer.nfc_id AND '.$costumer_age.'  GROUP BY service_id ORDER BY num_of_uses DESC ';
    $result = mysqli_query($conn,$sql);

    $uses = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);

    $sql = 'SELECT COUNT(DISTINCT erwthma7.nfc_id) AS num_of_users ,service_id,service_description FROM erwthma7,costumer WHERE '.$range_of_query.' AND erwthma7.nfc_id=costumer.nfc_id AND '.$costumer_age.' GROUP BY service_id ORDER BY num_of_users DESC ';
    $result = mysqli_query($conn,$sql);

    $users = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);
}
else{
    $sql = 'SELECT COUNT(start_time) AS num_of_visits ,place_id,name FROM erwthma9 WHERE start_time>=DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 YEAR) GROUP BY place_id ORDER BY num_of_visits DESC LIMIT 5';
    $result = mysqli_query($conn,$sql);

    $visits = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);
    $sql = 'SELECT COUNT(datetime_used) AS num_of_uses ,service_id,service_description FROM erwthma7 WHERE datetime_used>=DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 YEAR) GROUP BY service_id ORDER BY num_of_uses DESC ';
    $result = mysqli_query($conn,$sql);

    $uses = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);
    $sql = 'SELECT COUNT(DISTINCT nfc_id) AS num_of_users ,service_id,service_description FROM erwthma7 WHERE datetime_used>=DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 YEAR) GROUP BY service_id ORDER BY num_of_users DESC ';
    $result = mysqli_query($conn,$sql);

    $users = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);

}


?>



    <!DOCTYPE html>
    <html>
<?php include('headandfoot/header.php');?>
<section>
    <div class="costumers-views container center">
        <div  class="col-sm-3 same-line ">
            <form method="POST"  >

                <div>select age of customers: </div>
                <select class="browser-default grey-text  inline " name="costumer_age">
                    <option value="all_ages" default>All ages selected</option>

                    <option value="opt1">20-40</option>
                    <option value="opt2">41-60</option>
                    <option value="opt3">61+</option>

                </select>
                <p>Select the time period: </p>
                <select class="browser-default grey-text  inline " name="range_of_query">
                    <option value="the last year" default>The last year</option>

                    <option value="opt1">The last month</option>


                </select>
                <p>
                    <input type="submit"  name="submit_use" value="search" class=" container btn brand z-depth-0">
                </p>

            </form>
        </div>
        <table class="collection container center">
            <tr>
                <th> <h5>Οι πιο πολυσύχναστοι χώροι </h5></></th>

            </tr>
                <tr>
                <th>Place id:</th>
                <th>Place Name: </th>
                    <th> Number of visits: </th>
                </tr>
                <?php foreach ($visits as $visit){ ?>
                    <tr>
                <th> <?php echo htmlspecialchars($visit['place_id']);?> </th>
                    <th> <?php echo htmlspecialchars($visit['name']);?> </th>
                    <th> <?php echo htmlspecialchars($visit['num_of_visits']);?> </th>
            </tr>
                <?php } ?>
            <tr>
                <th> <h5>Οι συχνότερα χρησιμοποιούμενα υπηρεσίες</h5></></th>


            </tr>
            <tr>
                <th>Service id:</th>
                <th>Service Name: </th>
                <th> Number of uses: </th>
            </tr>
            <?php foreach ($uses as $use){ ?>
                <tr>
                    <th> <?php echo htmlspecialchars($use['service_id']);?> </th>
                    <th> <?php echo htmlspecialchars($use['service_description']);?> </th>
                    <th> <?php echo htmlspecialchars($use['num_of_uses']);?> </th>
                </tr>
            <?php } ?>
            <tr>

                <th> <h5>Οι υπηρεσίες που χρησιμοποιούνται από τους περισσότερους πελάτες</h5></></th>


            </tr>
            <tr>
                <th>Service id:</th>
                <th>Service Name: </th>
                <th> Number of users : </th>
            </tr>
            <?php foreach ($users as $user){ ?>
                <tr>
                    <th> <?php echo htmlspecialchars($user['service_id']);?> </th>
                    <th> <?php echo htmlspecialchars($user['service_description']);?> </th>
                    <th> <?php echo htmlspecialchars($user['num_of_users']);?> </th>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php include('headandfoot/footer.php');?>
</html>
