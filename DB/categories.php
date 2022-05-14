<?php
include ('credentials/credential.php');
// GROUP BY SINCE MYSQL8.0.13 HAS BEEN REMOVED SO WE ARE USING ORDER BY 
$sql = "SELECT SUM(amount) AS sum_amount,get_service.service_id, services.service_description FROM get_service,services WHERE services.service_id=get_service.service_id GROUP BY service_id ORDER BY sum_amount ASC";
$result = mysqli_query($conn,$sql);
$service_sales = mysqli_fetch_all($result,MYSQLI_ASSOC);

mysqli_free_result($result);
?>


<!DOCTYPE html>
<html>
<?php include('headandfoot/header.php');?>
<div class="container center">
<h4>Sales per category:</h4>
    <table class="highlight">
        <tr>
            <th>Service ID: </th>
            <th>Name: </th>
            <th>Amount: </th>

        </tr>

        <?php foreach ($service_sales as $service){ ?>
            <tr >
                <th><?php echo htmlspecialchars($service['service_id']);?></th>
                <th><?php echo htmlspecialchars($service['service_description']);?></th>
                <th><?php echo htmlspecialchars($service['sum_amount']);?></th>

            </tr>
        <?php } ?>
    </table>
</div>
<?php include('headandfoot/footer.php');?>
</html>