<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP Foundation Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="container text-light" style="background: url('images/corridor.png') no-repeat center center fixed; background-size: cover;">
    <?php 
        include "connection.php"; 

        // Defined $result before using it in the loop
        $result = $connection->query("SELECT * FROM scp");
    ?>
    
    <div class="mt-3">
        <ul class="nav nav-pills">
            <?php foreach($result as $link): ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?link=<?php echo urlencode($link['subject']); ?>"><?php echo $link['subject']; ?></a>
            </li>
            <?php endforeach; ?>
            <li class="nav-item"><a class="nav-link text-white" href="update.php">Enter a New Record</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="index.php">Index Page</a></li>
        </ul>
    </div>
     
    <h1 class="my-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">SCP Foundation Secure Archives</h1>
    
    <div>
        <?php 
            // HANDLE DELETE FIRST (so it disappears from the list immediately)
            if(isset($_GET['delete']))
            {
                $deleteID = $_GET['delete'];
                $delete = $connection->prepare("delete from scp where id=?");
                $delete->bind_param("i", $deleteID);
                
                if($delete->execute())
                {
                    echo "<div class='alert alert-warning text-dark'>Record Deleted...</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger'>Error: {$delete->error}</div>";
                }
            }

            // HANDLE VIEW RECORD
            if(isset($_GET['link']))
            {
                $subject = $_GET['link'];
                $stmt = $connection->prepare("select * from scp where subject = ?");
                $stmt->bind_param("s", $subject);
                
                if($stmt->execute())
                {
                    $res = $stmt->get_result();
                    $array = $res->fetch_assoc();
                    
                    if($array) {
                        $update = "update.php?update=" . $array['id'];
                        $delete = "index.php?delete=" . $array['id'];
                        
                        echo "
                            <div class='p-3 border shadow rounded bg-dark bg-gradient bg-opacity-75 text-light' style='border-color: rgba(255,255,255,0.2) !important;'>
                                <h3>{$array['subject']}</h3>
                                <h4>{$array['class']}</h4>
                                <p class='text-center'><img class='img-fluid rounded' src='{$array['image']}' alt='{$array['subject']}' style='max-height: 400px;'></p>
                                <p><strong>Description:</strong><br>{$array['description']}</p>
                                <p><strong>Special Containment Procedures:</strong><br>{$array['containment']}</p>
                                <p class='text-center'>
                                    <a href='{$update}' class='btn btn-warning'>Update Record</a>
                                    <a href='{$delete}' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete Record</a>
                                </p>
                            </div>
                        ";
                    } else {
                        echo "<p class='alert alert-danger'>No record found</p>";
                    }
                }
            }
            else
            {
                echo "
                    <div class='p-3 border shadow rounded bg-dark bg-gradient bg-opacity-75 text-light' style='border-color: rgba(255,255,255,0.2) !important;'>
                        <h2>Welcome to the SCP Foundation Database</h2>
                        <p>Use the menu above to browse our SCP subjects.</p>
                    </div>
                ";
            }
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
