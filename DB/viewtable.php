<?php
require_once "credential.php";
$stmt = $pdo->query("SELECT nfc_id,name from costumer");
echo '<table border="1">'."\n";
echo("<tr><td>");
    echo("Name");
    echo("</td><td>");
    echo("nfc_id");
    echo("</td></tr>");
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
    
    
    
    echo"<tr><td>"; // td allagh colum | tr allagh row

    echo($row['name']);
    echo("</td><td>");
    echo($row['nfc_id']);
    echo("</td><td>");

    echo('<form method="post"> <input type="hidden" ');
    echo('name="Delete_nfc_id" value="'.$row['nfc_id'].'">'."\n");
    echo('<input type="submit" value="Delete" name="Delete">');
    echo("\n</form>\n");
    echo("</tr>\n");
}
echo("</table>");
//require_once "selector.php";
?>