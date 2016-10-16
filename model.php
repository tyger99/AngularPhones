<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


 
$data = json_decode(file_get_contents('php://input'), true);//we get the json content from angular js

$conn = new mysqli("localhost", "root", "POTATO!", "phone");//db settings may be included in a separated  file...


 
if ( isSet( $data["op"] ) ) {
    if ( $data["op"]=="add" ) {
        //INSERT INTO, ID field is auto-icnrement!
        $nom = $data["nom"];
        $tlf = $data["telefon"];
        $res = $conn->query("INSERT into list(name,phone) values('".$nom."','".$tlf."')");

        }
 
    if ( $data["op"]=="delete" ) {//Delete from where name = .... In real scenario you should use the row ID
        $nom = $data["nom"];
        $res = $conn->query("DELETE from list where name='".$nom."'");
        
    }
}


//SHOW ALL PHONES by default in a very simple way
 
$result = $conn->query("SELECT name, phone FROM list");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    
    $outp .= '{"nom":"'   . $rs["name"]        . '",'; //manually json encode for better understanding!
    $outp .= '"phone":"'. $rs["phone"]     . '"}';
}
$outp ='{"names":['.$outp.']}';
$conn->close();
echo $outp;//we simple echo this to send it to the angular js controller 



?>