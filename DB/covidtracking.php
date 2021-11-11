<?php
include ('credentials/credential.php');

if(isset($_GET['nfc_id'])) {
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
    $nfc_id = mysqli_real_escape_string($conn, $_GET['nfc_id']);
    $sql = "SELECT * FROM erwthma10 where nfc_id=$nfc_id";
    $result = mysqli_query($conn,$sql);
    $costumer_tracking = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);
    mysqli_close($conn);

}
?>



<!DOCTYPE html>
<html>
<?php include('headandfoot/header.php');?>
<div class="container center">
<h4 class=" center"> <?php echo htmlspecialchars($costumer['first_name']);?>
    <?php echo htmlspecialchars($costumer['last_name']);?>
    </h4>
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

<h3>Covid tracking :</h3>
<table class="highlight">
    <tr>
        <th>First Name: </th>
        <th>Last Name: </th>
        <th>Place name: </th>
        <th>Start Time: </th>
        <th>End Time: </th>
        <th>Start Time (Covid): </th>
        <th>End Time (Covid): </th>

    </tr>

    <?php foreach ($costumer_tracking as $covid){ ?>
        <tr >
            <th><?php echo htmlspecialchars($covid['first_name']);?></th>
            <th><?php echo htmlspecialchars($covid['last_name']);?></th>
            <th><?php echo htmlspecialchars($covid['name']);?></th>
            <th><?php echo htmlspecialchars($covid['non_covid_start_time']);?></th>
            <th><?php echo htmlspecialchars($covid['non_covid_end_time']);?></th>
            <th><?php echo htmlspecialchars($covid['start_time']);?></th>
            <th><?php echo htmlspecialchars($covid['end_time']);?></th>

        </tr>
    <?php } ?>
</table>
</div>

<?php include('headandfoot/footer.php');?>
</html>
