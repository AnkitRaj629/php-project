<?php
// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Buy books', 'Go buy books from store and delete this task once done', current_timestamp());
    //connect to the database
    $servername="localhost";
    $username="root";
    $password="";
    $database="notes";

$conn=mysqli_connect($servername,$username,$password,$database);
$insert=false;
$update=false;
$delete=false;
if(!$conn){
    die("Sorry we failed to connect: ".mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno=$_GET['delete'];
  $delete=true;

  $sql="DELETE FROM `notes` WHERE `sno`=$sno";
$result=mysqli_query($conn,$sql);
}
if($_SERVER['REQUEST_METHOD']=='POST')
{
  if(isset($_POST['snoEdit'])){
   //update the records
    $sno=$_POST['snoEdit'];
   $title=$_POST["titleEdit"];
   $discription=$_POST['descriptionEdit'];
   $sql="UPDATE `notes` SET `title` ='$title' , `description` = '$discription' WHERE `notes`.`sno` = $sno ";
   $result=mysqli_query($conn,$sql);
   if($result){
    
    $update=true;
  }
  else{
    echo "Record has been not inserted successfully because of this error-->".mysqli_error($conn);
  }
  
  }
  else{
  $title=$_POST["title"];
  $discription=$_POST['description'];
  $sql="INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, '$title', '$discription', current_timestamp())";
  $result=mysqli_query($conn,$sql);

  if($result){
    // echo "Records have been inserted successfully ";
    $insert=true;
  }
  else{
    echo "Record has been not inserted successfully because of this error-->".mysqli_error($conn);
  }
}
}
    ?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    

  <title>iNotes-Notes taking makes easy</title>

</head>

<body>
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit modal
</button> -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Notes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/crud/index.php" method="post">
      <div class="modal-body">


        <input type="hidden" name="snoEdit" id="snoEdit">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Note Dispription</label>
        <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
      </div>
   
      
      
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="Submit" class="btn btn-primary">Save changes</button>
    </div>
  </form>
    </div>
  </div>
</div>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact us</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Sucess</strong> You record has been inserted successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Sucess</strong> You record has been updated successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
}
  ?>
  <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Sucess</strong> You record has been deleted successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <div class="container my-3">
    <h2>Add a Note</h2>
    <form action="/crud/index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Note Dispription</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.no</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
  <?php
      $sql="SELECT * FROM `notes`";
      $result=mysqli_query($conn,$sql);
      $sno=0;
      while($row=mysqli_fetch_assoc($result))
      {
        $sno=$sno+1;
        echo "
        <tr>
        <th scope='row'>".$sno."</th>
        <td>".$row['title']."</td>
        <td>".$row['description']."</td>
        <td><button class='edit btn btn-sm btn-primary' id =".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id =d".$row['sno'].">Delete</button></td>
        </tr>";
      }
      
  ?>
      </tbody>
    </table>
  </div>
  <hr>
  <script>
      let table = new DataTable('#myTable');
    </script>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

    <script>
   edit = document.getElementsByClassName('edit');
    Array.from(edit).forEach((element)=>{
      element.addEventListener("click",(e)=>{
        console.log("edit ",);
        tr=e.target.parentNode.parentNode;
        title=tr.getElementsByTagName('td')[0].innerText;
        description=tr.getElementsByTagName('td')[1].innerText;
        console.log(title,description);
        titleEdit.value=title;
        descriptionEdit.value=description;
        snoEdit.value=e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
      element.addEventListener("click",(e)=>{
        console.log("Delete ",);
        
        sno=e.target.id.substr(1,);

        if(confirm("Are You Sure you want to delete!")){
          console.log("Yes");
          window.location=`/crud/index.php?delete=${sno}`
        }
        else{
          console.log("NO");
        }
      })
    })
  </script>

</body>

</html>