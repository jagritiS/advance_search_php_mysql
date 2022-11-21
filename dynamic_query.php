<!DOCTYPE html>
<html>
<body>

<h2>Dynamic Query Example</h2>
<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  width: 50%;
  margin-left:100px;
  background-color: #f2f2f2;
  padding: 20px;
}
#person_table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 70%;
  margin-left:100px;
}

#person_table td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}
#person_table tr:nth-child(even){background-color: #f2f2f2;}

#person_table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
<div>
<form enctype="multipart/form-data"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method='POST'>
  <label for="id">ID</label><br>
  <input type="text" id="id" name="id" ><br>

  <label for="name">First name:</label><br>
  <input type="text" id="name" name="name" ><br>

  <label for="age">Age</label><br>
  <input type="text" id="age" name="age" ><br><br>

   <label for="gender">Gender</label><br>
   <select name="gender">
        <option name="0">Choose Gender</option>
        <option name="M">M</option>
        <option name="F">F</option>
    </select>
  <input type="submit" value="Submit" name="submit_button">
</form>
</div>
<hr>

<?php

 if(array_key_exists('submit_button', $_POST)) {
 echo "check 1";

           $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
           $id = $_POST['id'];
           $name = $_POST['name'];
           $age = $_POST['age'];

         showResult($gender,$id,$name,$age);
 }
 function showResult($gender,$id,$name,$age)
 {

          $dbhost = 'localhost';
          $dbuser = 'root';
          $dbpass = '';
          $dbname = 'test_table';

          $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

          if(! $conn ) {
             die('Could not connect: ' . mysqli_error($conn));
          }

         $condition = "";
         $sql = "select * from person where 1";

         if($gender!=0){

                $condition = " and gender='$gender'";
         }


         if($id){

            $condition .=" and id=$id";
         }if($name){
          $condition .=" and  name='$name'";
         }
         if($age){
        $condition .=" and  age=$age";
       }

         else{}
         $sql1  = $sql.$condition;

         $result = $conn->query($sql1);
         if(mysqli_num_rows($result) >0)
          {
           $table = '

            <table id="person_table">
            <thead>
                    <tr>
                             <th>ID</th>
                             <th>Name</th>
                             <th>Age</th>
                             <th>Gender</th>
                    </tr>
            </thead>
             <tbody>
           ';
           while($row = mysqli_fetch_array($result))
           {
            $table .= '
             <tr>
                  <td>'.$row["id"].'</td>
                   <td>'.$row["name"].'</td>
                   <td>'.$row["age"].'</td>
                   <td>'.$row["gender"].'</td>
              </tr>
            ';
           }
           $table .= '</tbody></table>';
           echo $table;
          }
 }
?>

</body>
</html>
