<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add a New Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="container text-light" style="background: url('images/corridor.png') no-repeat center center fixed; background-size: cover;">
     <?php
        include "connection.php"; 
        
        if(isset($_POST['submit']))
        {
            // Code a prepared statement to insert form contents through the SCP database table
            $insert = $connection->prepare(
                "insert into scp(subject, class, description, containment, image) values(?, ?, ?, ?, ?)"
            );
            $insert->bind_param("sssss", $_POST['subject'], $_POST['class'], $_POST['description'], $_POST['containment'], $_POST['image']);
            
            if($insert->execute())
            {
                echo "
                    <div class='alert alert-success text-dark'>Record Added Successfully</div>
                ";
            }
            else
            {
                echo "
                    <div class='alert alert-danger'>Error: {$insert->error}</div>
                ";
            }
        }
     ?>
     
     <div class="mt-3 mb-3">
         <a href="index.php" class="btn btn-dark text-white">Back to index page</a>
     </div>
     
    <h1 style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Add a New Record</h1>
    
    <div class="p-4 rounded shadow bg-dark bg-gradient bg-opacity-75 mb-5 mt-3">
        <form method="post" action="create.php" class="form-group">
            <label class="form-label">Enter Subject Designation:</label>
            <input type="text" name="subject" placeholder="SCP-XXXX..." required class="form-control mb-3">
            
            <label class="form-label">Enter Object Class:</label>
            <input type="text" name="class" placeholder="Object Class..." required class="form-control mb-3">
            
            <label class="form-label">Enter Description Details:</label>
            <textarea name="description" class="form-control mb-3" placeholder="Context Here..."></textarea>
            
            <label class="form-label">Enter Special Containment Procedures:</label>
            <textarea name="containment" class="form-control mb-3" placeholder="Context Here..."></textarea>
            
            <label class="form-label">Enter Subject Image:</label>
            <input type="text" name="image" placeholder="images/name-of-image.png..." required class="form-control mb-3">
            
            <br>
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>