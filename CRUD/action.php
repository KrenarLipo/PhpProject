<?php
//Database connection by using PHP PDO
$username = 'root';
$password = '';
$connection = new PDO( 'mysql:host=localhost;dbname=crud_connection', $username, $password ); // Create Object of PDO class by connecting to Mysql database

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM clients ORDER BY id DESC");
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $output .= '
   <table class="table table-bordered">
    <tr>
     <th width="10%">Name</th>
     <th width="10%">Surname</th>
     <th width="10%">Phone Number</th>
     <th width="10%">Email</th>
     <th width="10%">Operatori Pergjegjes</th>
     <th width="10%">Statusi</th>
     <th width="10%">Update</th>
     <th width="10%">Delete</th>
    </tr>
  ';
  if($statement->rowCount() > 0)
  {
   foreach($result as $row)
   {
    $output .= '
    <tr>
     <td>'.$row["name"].'</td>
     <td>'.$row["surname"].'</td>
     <td>'.$row["phone_number"].'</td>
     <td>'.$row["email"].'</td>
     <td>'.$row["operatori_pergjegjes"].'</td>
     <td>'.$row["statusi"].'</td>
     <td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button></td>
     <td><button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button></td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
    <tr>
     <td align="center">Client not Found</td>
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }

 //This code for Create new Records
 if($_POST["action"] == "Create New Client")
 {
  $statement = $connection->prepare("
   INSERT INTO clients (name, surname, phone_number, email, operatori_pergjegjes, statusi) 
   VALUES (:name, :surname, :phone_number, :email, :operatori_pergjegjes, :statusi)
  ");
  $result = $statement->execute(
   array(
    ':name' => $_POST["Name"],
    ':surname' => $_POST["Surname"],
    ':phone_number' => $_POST["Phone"],
    ':email' => $_POST["Email"],
    ':operatori_pergjegjes' => $_POST["Operatori"],
    ':statusi' => $_POST["Statusi"]
   )
  );
  if(!empty($result))
  {
   echo 'Client Inserted';
  }
 }

 //This Code is for fetch single customer data for display on Modal
 if($_POST["action"] == "Select")
 {
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM clients 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["name"] = $row["name"];
   $output["surname"] = $row["surname"];
   $output["phone_number"] = $row["phone_number"];
   $output["email"] = $row["email"];
   $output["operatori_pergjegjes"] = $row["operatori_pergjegjes"];
   $output["statusi"] = $row["statusi"];
  }
  echo json_encode($output);
 }

 if($_POST["action"] == "Update")
 {
  $statement = $connection->prepare(
   "UPDATE clients 
   SET name = :name, surname = :surname, phone_number = :phone_number, email = :email, 
   operatori_pergjegjes = :operatori_pergjegjes, statusi = :statusi 
   WHERE id = :id
   "
  );
  $result = $statement->execute(
   array(
    ':name' => $_POST["Name"],
    ':surname' => $_POST["Surname"],
    ':phone_number' => $_POST["Phone"],
    ':email' => $_POST["Email"],
    ':operatori_pergjegjes' => $_POST["Operatori"],
    ':statusi' => $_POST["Statusi"],
    ':id'   => $_POST["id"]
   )
  );
  if(!empty($result))
  {
   echo 'Client Updated';
  }
 }

 if($_POST["action"] == "Delete")
 {
  $statement = $connection->prepare(
   "DELETE FROM clients WHERE id = :id"
  );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
   )
  );
  if(!empty($result))
  {
   echo 'Client Deleted';
  }
 }

}

?>