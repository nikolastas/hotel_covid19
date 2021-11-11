<?php
include ('credentials/credential.php');

$sql = 'SELECT  first_name,last_name,date_of_birth,nfc_id FROM costumer ';
$result = mysqli_query($conn,$sql);
$costumers = mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);
mysqli_close($conn);

//echo $sql

?>
<!DOCTYPE html>
<html>
<?php include('headandfoot/header.php');?>
<h4 class="center grey-text"> Costumers</h4>
<div class="container">
    <div class="row">
        <?php foreach ($costumers as $client){ ?>
            <div class="col s6 md3">
                <div class="card z-depth-0">
                    <img src="pics/costumer.svg" class="costumer">
                    <div class="card-content center">
                        <h6>
                            <?php echo htmlspecialchars($client['first_name']);?>
                            <?php echo htmlspecialchars($client['last_name']);?>

                        </h6>
                        <div>
                            <?php echo htmlspecialchars($client['date_of_birth']);?>
                        </div>
                    </div>
                    <div class="card-action right-align">
                        <a class="brand-text" href="details.php?nfc_id=<?php echo $client['nfc_id'] ?>"> more info</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</section>
<?php include('headandfoot/footer.php');?>
</body>

</html>
