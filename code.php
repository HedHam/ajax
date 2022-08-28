<?php
	include_once('connection.php');

	$database = new Connection();
	$db = $database->open();

    $stmt = $db->prepare("SELECT * FROM members");
    $stmt->execute();
    $output = $stmt->fetchall();

    $result = array();
    foreach ($output as $key => $element) {
      $result[$element['address']][] = $element;
      // print_r($result);
      // echo '<br>'; 
   }
   // print_r($result);

    foreach ($result as $res => $value) {
      // $adress = $res[0]['address'];
      echo '<pre>';
      print_r($value);
      echo '<pre>';

      $out = fopen('file' . $res . '.csv', 'w');
      $fields = array('ID', 'FIRST NAME', 'LAST NAME', 'address');
      fputcsv($out, $fields, ";"); 
         foreach ($value as $values) {
            $lineData = array($values['id'], $values['firstname'], $values['lastname'], $values['address']);
            fputcsv($out, $lineData, ";");

         }
         fclose($out);



   
 if (!defined('olMailItem')) define("olMailItem",0);

 $objApp = new COM("Outlook.Application");

 $myItem = $objApp->CreateItem(olMailItem);

 $myItem->To= "";

 // $myItem->SentOnBehalfOfName = 'hedi.hamani@gmail.fr';

 $myItem->Subject="This is a test " . $res;

 $myItem->Body="This is a Body Section now.....!";

 $myItem->attachments->Add('C:\wamp64\www\Portail_Ajax\file' . $res . '.csv');

 $myItem->Display();

 // $myItem->Send();
 }

?>