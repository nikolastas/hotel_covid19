<?php
include("credentials/credential.php");
if(isset($_POST['submit_new'])) {

    $sql = "INSERT INTO costumer(first_name,last_name,date_of_birth,certification_document_principle_of_issue,certification_document_type,certification_document_number) VALUES('{$_POST['first_name']}', '{$_POST['last_name']}','{$_POST['date_of_birth']}', '{$_POST['certification_document_principle_of_issue']}','{$_POST['certification_document_type']}','{$_POST['certification_document_number']}' )";

    $conn->query($sql);



    $sql= "INSERT INTO costumer_email(costumer_nfc_id, costumer_email) VALUES ((SELECT nfc_id FROM costumer WHERE certification_document_number= '{$_POST['certification_document_number']}' ),'{$_POST['email']}') ";
    $conn->query($sql);

    $sql= "INSERT INTO costumer_mobile(costumer_nfc_id, costumer_mobile) VALUES ((SELECT nfc_id FROM costumer WHERE certification_document_number= '{$_POST['certification_document_number']}' ),'{$_POST['mobile']}') ";
    $conn->query($sql);


}

?>

<!DOCTYPE html>
<html>
<?php include ('headandfoot/header.php');?>

<section class="container grey-text">
    <h4 class="center"> ADD A NEW COSTUMER</h4>

    <form method="post" class="input-field col s6" action="adder.php">
        <div>
        <p> First Name:
            <input type="text" name="first_name" size="40" required></p>
        <p> Last Name:
            <input type="text"  name="last_name" required></p>
        </div>
        <div>
        <p> date of birth:
            <input type="date" name="date_of_birth"></p>
        </div>
        <p>
        <label>certification document principle of issue</label>
        </p>
            <select class="browser-default grey-text  inline " name="certification_document_principle_of_issue">
            <option value="" disabled selected>certification document principle of issue</option>
            <option value="Greek Police">Greek Police</option>
            <option value="Europe Authority">Europe Authority</option>
            <option value="USA embassy">USA embassy</option>
            <option value="Other">Other</option>
        </select>
        <p><label>certification document principle of issue</label></p>
        <select class="browser-default grey-text  inline " name="certification_document_type">
            <option value="" disabled selected>certification document type</option>
            <option value="Greek Police">Passport</option>
            <option value="Europe Authority">ID</option>
            <option value="USA embassy">Driver licence</option>
            <option value="Other">Other</option>
        </select>
        <div class="input-field col s6">
            <p> certification_document_number:
                <input type="text" name="certification_document_number"></p>
        </div>
        <div>
            <p> email :
                <input type="text" name="email" class="input-field inline"></p>
        </div>
        <div>
            <p> mobile :
            <input type="tel" name="mobile" class="input-field inline" ></p>
        </div>


        <div>
            <p><input type="submit"  name="submit_new" value="submit new customer" class=" container btn brand z-depth-0"></p>
        </div>
    </form>
</section>
<?php include ('headandfoot/footer.php');?>
</html>