<?php
// define variables and set to empty values

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "elegantapartments";



try {
  $conn = new PDO("mysql:host=$servername;port=3307;dbname=$db_name", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $firstname = $lastname = $email = $suggestion = "";

      $firstname = test_input($_POST["firstname"]);
      $lastname = test_input($_POST["lastname"]);
      $email = test_input($_POST["email"]);
      $suggestion = test_input($_POST["suggestion"]);

      $nRows = $conn->query("SELECT * FROM users WHERE email='$email'")->fetchColumn();

      if ( $nRows > 0) {
        echo "Sorry... username already taken"; 	
      }
      else{
        $stmt = $conn->prepare("INSERT INTO feedback (firstname, lastname, email, suggestion) 
        VALUES(?, ?,?,?)");
        
        $stmt->bindParam(1, $firstname, PDO::PARAM_STR); // "is" means that $id is bound as an integer and $label as a string
        $stmt->bindParam(2, $lastname, PDO::PARAM_STR); // "is" means that $id is bound as an integer and $label as a string
        $stmt->bindParam(3, $email, PDO::PARAM_STR); // "is" means that $id is bound as an integer and $label as a string
        $stmt->bindParam(4, $suggestion, PDO::PARAM_STR); // "is" means that $id is bound as an integer and $label as a string
        $stmt->execute();
        echo "User registered succesfully";
        header("Location: http://localhost/suggestion_submitted.html");
      }
        
      
      

      
  
      
     
    }
    
    
    
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>