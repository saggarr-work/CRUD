<!-- ====================DATABASE CONNECTION====================== -->
<?php
// INSERT INTO `notes` (`slno`, `title`, `description`, `tstamp`) VALUES (NULL, 'fruits', 'please buy some apple and orange ', current_timestamp());
    $insert = false;
    $update = false;
    $delete = false;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "crud";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if(!$conn){
        die("Sorry we failed to connect: ". mysqli_connect_error());
    }

    if(isset($_GET['delete'])){
        $slno = $_GET['delete'];
        $delete = true;
        $sql = "DELETE FROM `notes` WHERE `slno` = $slno";
        $result = mysqli_query($conn, $sql);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['slnoEdit'])){
            //update the record
            $slno = $_POST["slnoEdit"];
            $title = $_POST["titleEdit"];
            $description = $_POST["descriptionEdit"];
    
            //sql query to be executed
            $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`slno` = $slno";
            $result = mysqli_query($conn, $sql);

            if($result){
                $update = true;
            }
            else{
                echo "Note Was Not Updated!";
            }
        }
        else{
            $title = $_POST["title"];
            $description = $_POST["description"];
    
            //sql query to be executed
            $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
            $result = mysqli_query($conn, $sql);
    
            if($result){
                // echo "the record has been inserted successfuly";
                $insert = true;
            }
            else{
                echo "record doesnot inserted successfully. error code: " . mysqli_error($conn);
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- =============================MODAL START======================= -->
    <!-- Button trigger editmodal -->

    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
    Edit Modal
    </button> -->

    <!-- editmodal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit This Note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">   
                    <form action="/CRUD/index.php" method="post">
                        <div class="container my-3">
                            <input type="hidden" name="slnoEdit" id="slnoEdit">
                            <!-- <h3>Add a Note</h3> -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Note Title</label>
                                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Note Description</label>
                                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                            </div>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- =====================================MODAL END======================== -->


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD with PHP</title>
    
    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

    <!-- datatable link for css -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <!-- datatable link for js -->
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- datatable function call -->
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
</head>
<body>
    
    <!-- ==========================NAVBAR START============================= -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/CRUD">PHP CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- ===============================NAVBAR END============================ -->

    <!-- ===================ALERT START=================== -->
    <?php
        if($insert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your note has been inserted successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }

        if($update){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your note has been updated successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }

        if($delete){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your note has been deleted successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    ?>
    <!-- =======================ALERT END=================== -->



    <!-- ================================FORM START============================== -->
    <div class="container my-3">
        <form action="/CRUD/index.php" method="post">
            <h3>Add a Note</h3>
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>
    <!-- =================================FORM END================================ -->



    <!-- =====================================TABLE START============================= -->
    <div class="container my-4">
        <table class="table" id="myTable" >
            <thead>
                <tr>
                <th scope="col">S.No</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM `notes`";
                    $result = mysqli_query($conn, $sql);
                    $slno = 0;
                    while($row = mysqli_fetch_assoc($result)){
                        $slno = $slno + 1;
                        echo "<tr>
                            <th scope='row'>".$slno."</th>
                            <td>".$row['title']."</td>
                            <td>".$row['description']."</td>
                            <td><button class='edit btn btn-sm btn-primary' id=".$row['slno'].">Edit</button> <button class='delete btn btn-sm btn-danger' id=d".$row['slno'].">Delete</button></td>
                            </tr>";
                    }
                    
                    
                ?>
            </tbody>
        </table>
    </div>
    <!-- =======================================TABLE END================================ -->




<!-- bootstrap link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<!-- javascript code for open modal while click on edit button -->
<script>
    //for update
    let edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
            console.log("edit ", );
            tr = e.target.parentNode.parentNode;
            title =  tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);
            titleEdit.value = title;
            descriptionEdit.value = description;
            slnoEdit.value = e.target.id;
            console.log(e.target.id);
            $('#editModal').modal('toggle');
        });
    });


    //for delete
    let deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
        element.addEventListener("click",(e)=>{
            console.log("edit ", );
            slno = e.target.id.substr(1,);
            if(confirm("Do You Want to Delete this Note?")){
                console.log("yes");
                window.location = `/CRUD/index.php?delete=${slno}`;
            }
            else{
                console.log("no");
            }
        });
    });
</script>
</body>
</html>