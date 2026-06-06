<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="container mt-4 text-light" style="background: url('images/corridor.png') no-repeat center center fixed; background-size: cover;">
    <?php
        // enable error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        include "connection.php";
        
        $row = [];
        
        // 1. FETCH DATA FOR UPDATING (GET REQUEST)
        if(isset($_GET['update']))
        {
            $id = $_GET['update'];
            $recordID = $connection->prepare("select * from scp where id = ?");
            
            if($recordID) {
                $recordID->bind_param("i", $id);
                $recordID->execute();
                $temp = $recordID->get_result();
                $row = $temp->fetch_assoc();
                echo "<div class='alert alert-success text-dark'>Record ready for updating.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error preparing record for updating</div>";
            }
        }
        
        // 2. HANDLE UPDATE (POST REQUEST)
        if(isset($_POST['update']))
        {
            $update = $connection->prepare("update scp set subject=?, class=?, description=?, containment=?, image=? where id=?");
            $update->bind_param("sssssi", $_POST['subject'], $_POST['class'], $_POST['description'], $_POST['containment'], $_POST['image'], $_POST['id']);
            
            if($update->execute()) {
                echo "<div class='alert alert-primary text-dark'>Record Updated Successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: {$update->error}</div>";
            }
        }
        
        // 3. HANDLE NEW INSERTION (POST REQUEST)
        if(isset($_POST['submit']))
        {
            $insert = $connection->prepare("insert into scp(subject, class, description, containment, image) values(?, ?, ?, ?, ?)");
            $insert->bind_param("sssss", $_POST['subject'], $_POST['class'], $_POST['description'], $_POST['containment'], $_POST['image']);
            
            if($insert->execute()) {
                echo "<div class='alert alert-success text-dark'>Record Added Successfully</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: {$insert->error}</div>";
            }
        }
    ?>

    <a href="index.php" class="btn btn-dark mb-3">Back to index page</a>
     
    <h1 style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);"><?php echo isset($_GET['update']) ? "Edit Record" : "Add a New Record"; ?></h1>
    
    <form method="post" action="" class="form-group" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.9);">
        <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>">
        
        <label class="form-label">Enter Subject Designation:</label>
        <input type="text" name="subject" value="<?php echo $row['subject'] ?? ''; ?>" placeholder="SCP-XXXX..." required class="form-control mb-3">
        
        <label class="form-label">Enter Object Class:</label>
        <input type="text" name="class" value="<?php echo $row['class'] ?? ''; ?>" placeholder="Object Class..." required class="form-control mb-3">
        
        <label class="form-label">Enter Description Details:</label>
        <textarea name="description" class="form-control mb-3" placeholder="Context Here..."><?php echo $row['description'] ?? ''; ?></textarea>
        
        <label class="form-label">Enter Special Containment Procedures:</label>
        <textarea name="containment" class="form-control mb-3" placeholder="Context Here..."><?php echo $row['containment'] ?? ''; ?></textarea>
        
        <label class="form-label">Enter Subject Image:</label>
        <input type="text" name="image" value="<?php echo $row['image'] ?? ''; ?>" placeholder="images/name-of-image.png..." required class="form-control mb-3">

        <br>
        <?php if(isset($_GET['update'])): ?>
            <input type="submit" name="update" value="Update Record" class="btn btn-primary">
        <?php else: ?>
            <input type="submit" name="submit" value="Save Record" class="btn btn-success">
        <?php endif; ?>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>