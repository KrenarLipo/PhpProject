<?php
session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);
?>  

<!DOCTYPE html>
<html>
 <head>
  <title>Call Center</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
   body
   {
    margin:0;
    padding:0;
    background-color:#f1f1f1;
   }
   .box
   {
    width:1270px;
    padding:20px;
    background-color:#fff;
    border:1px solid #ccc;
    border-radius:5px;
    margin-top:100px;
   }
  </style>
 </head>
 <body>
  <div class="container box">
   <h1 align="center">Clients Table</h1>
   <br />
   <div align="right">
    <button type="button" id="modal_button" class="btn btn-info">Create New Client</button>
    <!-- It will show Modal for Create new Records !-->
   </div>
   <br />
   <div id="result" class="table-responsive"> <!-- Data will load under this tag!-->

   </div>
  </div>
 </body>
</html>

<!-- This is Client Modal. It will be use for Create new clients and Update Existing clients!-->
<div id="clientModal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Create New Client</h4>
   </div>
   <div class="modal-body">
    <label>Enter Name</label>
    <input type="text" name="name" id="name" class="form-control" />
    <br />
    <label>Enter Surname</label>
    <input type="text" name="surname" id="surname" class="form-control" />
    <br />
    <label>Enter Phone Number</label>
    <input type="text" name="phone_number" id="phone_number" class="form-control" />
    <br />
    <label>Enter E-mail</label>
    <input type="text" name="email" id="email" class="form-control" />
    <br />
    <label>Enter Operatori Pergjegjes</label>
    <input type="text" name="operatori_pergjegjes" id="operatori_pergjegjes" class="form-control" />
    <br />
    <label>Enter Statusi</label>
    <input type="text" name="statusi" id="statusi" class="form-control" />
    <br />
   </div>
   <div class="modal-footer">
    <input type="hidden" name="client_id" id="client_id" />
    <input type="submit" name="action" id="action" class="btn btn-success" />
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>

<script>
$(document).ready(function(){
 fetchUser(); //This function will load all data on web page when page load
 function fetchUser() // This function will fetch data from table and display under <div id="result">
 {
  var action = "Load";
  $.ajax({
   url : "action.php", //Request send to "action.php page"
   method:"POST", //Using of Post method for send data
   data:{action:action}, //action variable data has been send to server
   success:function(data){
    $('#result').html(data); //It will display data under div tag with id result
   }
  });
 }

 //This JQuery code will Reset value of Modal item when modal will load for create new records
 $('#modal_button').click(function(){
  $('#clientModal').modal('show'); //It will load modal on web page
  $('#name').val(''); //This will clear Modal first name textbox
  $('#surname').val(''); //This will clear Modal last name textbox
  $('#phone_number').val('');
  $('#email').val('');
  $('#operatori_pergjegjes').val('');
  $('#statusi').val('');
  $('.modal-title').text("Create New Client"); //It will change Modal title to Create new Records
  $('#action').val('Create New Client'); //This will reset Button value ot Create
 });

 //This JQuery code is for Click on Modal action button for Create new records or Update existing records. This code will use for both Create and Update of data through modal
 $('#action').click(function(){
  var Name = $('#name').val(); //Get the value of first name textbox.
  var Surname = $('#surname').val(); //Get the value of last name textbox
  var Phone = $('#phone_number').val();
  var Email = $('#email').val();
  var Operatori = $('#operatori_pergjegjes').val();
  var Statusi = $('#statusi').val();
  var id = $('#client_id').val();  //Get the value of hidden field customer id
  var action = $('#action').val();  //Get the value of Modal Action button and stored into action variable
  if(Name != '' && Surname != '' && Phone !='' && Email !='' && Operatori
   !='' && Statusi !='' && action !='') //This condition will check both variable has some value
  {
   $.ajax({
    url : "action.php",    //Request send to "action.php page"
    method:"POST",     //Using of Post method for send data
    data:{Name:Name, Surname:Surname, Phone:Phone, Email:Email, Operatori:Operatori, Statusi:Statusi,
    id:id, action:action}, //Send data to server
    success:function(data){
     alert(data);    //It will pop up which data it was received from server side
     $('#clientModal').modal('hide'); //It will hide Customer Modal from webpage.
     fetchUser();    // Fetch User function has been called and it will load data under divison tag with id result
    }
   });
  }
  else
  {
   alert("Both Fields are Required"); //If both or any one of the variable has no value them it will display this message
  }
 });

 //This JQuery code is for Update customer data. If we have click on any customer row update button then this code will execute
 $(document).on('click', '.update', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  var action = "Select";   //We have define action variable value is equal to select
  $.ajax({
   url:"action.php",   //Request send to "action.php page"
   method:"POST",    //Using of Post method for send data
   data:{id:id, action:action},//Send data to server
   dataType:"json",   //Here we have define json data type, so server will send data in json format.
   success:function(data){
    $('#clientModal').modal('show');   //It will display modal on webpage
    $('.modal-title').text("Update"); //This code will change this class text to Update records
    $('#action').val("Update");     //This code will change Button value to Update
    $('#client_id').val(id);     //It will define value of id variable to this customer id hidden field
    $('#name').val(data.name);  //It will assign value to modal first name texbox
    $('#surname').val(data.surname);  //It will assign value of modal last name textbox
    $('#phone_number').val(data.phone_number);
    $('#email').val(data.email);
    $('#operatori_pergjegjes').val(data.operatori_pergjegjes);
    $('#statusi').val(data.statusi);
   }
  });
 });

 //This JQuery code is for Delete customer data. If we have click on any customer row delete button then this code will execute
 $(document).on('click', '.delete', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  if(confirm("Are you sure you want to remove this client?")) //Confim Box if OK then
  {
   var action = "Delete"; //Define action variable value Delete
   $.ajax({
    url:"action.php",    //Request send to "action.php page"
    method:"POST",     //Using of Post method for send data
    data:{id:id, action:action}, //Data send to server from ajax method
    success:function(data)
    {
     fetchUser();    // fetchUser() function has been called and it will load data under divison tag with id result
     alert(data);    //It will pop up which data it was received from server side
    }
   })
  }
  else  //Confim Box if cancel then 
  {
   return false; //No action will perform
  }
 });
});
</script>