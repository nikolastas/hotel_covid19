<?php
include ('credentials/credential.php');
//check GET request id param

if(isset($_GET['nfc_id'])){
$nfc_id = mysqli_real_escape_string($conn, $_GET['nfc_id']);
$sql = "SELECT * FROM costumer where nfc_id=$nfc_id";
$result = mysqli_query($conn,$sql);
$costumer = mysqli_fetch_assoc($result);
mysqli_free_result($result);
$sql = "SELECT costumer_email FROM costumer_email where costumer_nfc_id=$nfc_id";
$result = mysqli_query($conn,$sql);
$costumer_email = mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);
    $sql = "SELECT costumer_mobile FROM costumer_mobile where costumer_nfc_id=$nfc_id";
    $result = mysqli_query($conn,$sql);
    $costumer_mobile = mysqli_fetch_all($result,MYSQLI_ASSOC);
    mysqli_free_result($result);
    $sql = "SELECT * FROM erwthma9 where nfc_id=($nfc_id) ORDER BY start_time ASC";
    $result = mysqli_query($conn,$sql);
    $costumer_visits = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);
mysqli_close($conn);


}
if(isset($_POST['delete'])){
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['costumer_id_to_delete']);
    $sql = "DELETE FROM costumer WHERE nfc_id=$id_to_delete";
    if(mysqli_query($conn, $sql)){
        //success
        header('Location: index.php');
    }{
        //fail
    echo 'query error: '.mysqli_error($conn);
    }
}


?>


<!DOCTYPE html>
<html>

<?php include('headandfoot/header.php');?>
<div class="container center">
    <?php if($costumer): ?>
    <h4 class=" center"> <?php echo htmlspecialchars($costumer['first_name']);?>
        <?php echo htmlspecialchars($costumer['last_name']);?>
        <a class="brand btn" href="covidtracking.php?nfc_id=<?php echo $costumer['nfc_id'] ?>"> Covid Tracking</a></h4>
    <p> Birthday: <?php echo date($costumer['date_of_birth']);?></p>
    <?php foreach ($costumer_email as $email){ ?>
        <p>email: <?php echo htmlspecialchars($email['costumer_email']); ?></p>
    <?php } ?>
    <?php foreach ($costumer_mobile as $mobile) { ?>
    <p>mobile : <?php echo  html_entity_decode($mobile['costumer_mobile']);?></p>
    <?php } ?>
        <p>certification document type : <?php echo htmlspecialchars($costumer['certification_document_type']);?></p>
        <p>certification document principle of issue : <?php echo htmlspecialchars($costumer['certification_document_principle_of_issue']);?></p>

    <p>certification document number : <?php echo htmlspecialchars($costumer['certification_document_number']);?></p>

    <h3>Customer Visits :</h3>
        <table class="highlight">
            <tr>
                <th>Place id: </th>
                <th>Name: </th>
                <th>Start Time: </th>
                <th>End Time: </th>
            </tr>

            <?php foreach ($costumer_visits as $visit){ ?>
            <tr >
                <th><?php echo htmlspecialchars($visit['place_id']);?></th>
                <th><?php echo htmlspecialchars($visit['name']);?></th>
                <th><?php echo htmlspecialchars($visit['start_time']);?></th>
                <th><?php echo htmlspecialchars($visit['end_time']);?></th>

            </tr>
                <?php } ?>
        </table>


        <form action="details.php" method="post">
        <input type="hidden" name="costumer_id_to_delete" value="<?php echo $costumer['nfc_id']?>">
        <input type="submit" name="delete" value="delete" class="btn brand">
    </form>

    <?php else: ?>
    <h5>ERROR 404 !</h5>
    <?php endif;?>
</div>

<?php include('headandfoot/footer.php');?>
</html>
