<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Management Popup</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      border: 1px solid #ccc;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      z-index: 9999;
    }
    .overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9998;
    }
    .hidden {
      display: none;
    }
  </style>
</head>
<body>

<button onclick="openPopup()">Open Product Management</button>

<div id="popup" class="popup">
  <div class="container mt-5">
    <h2 class="text-center mb-4">Product Management</h2>
    <a href="#" class="btn btn-success">Add New Product</a> <!-- Updated link -->
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Product Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include('connect.php');

        // Check if product ID is provided for deletion
        if(isset($_GET['id'])) {
            $one_id = $_GET['id'];
            
            // Include the connection file
            include('connect.php');

            // Delete the product from the database
            $sql_delete = "DELETE FROM one WHERE id = ?";
            $stmt = $conn->prepare($sql_delete);
            $stmt->bind_param("i", $one_id);
            
            if ($stmt->execute()) {
                // Output success message
                echo "<div id='deleteMessage' class='alert alert-success'>Product deleted successfully.</div>";
            } else {
                // Output error message
                echo "<div id='deleteMessage' class='alert alert-danger'>Error deleting product: " . $conn->error . "</div>";
            }
            
            $stmt->close();
        }

        // Fetch data from the database
        $sql_select = "SELECT * FROM one";
        $result = $conn->query($sql_select);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['product_name'] . "</td>";
            echo "<td>" . $row['category'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>";
            echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm mr-2'>Edit</a>";
            echo "<a href='?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>"; // Directly perform deletion in the same file
            echo "</td>";
            echo "</tr>";
          }
          
        } else {
          echo "<tr><td colspan='6'>No products found</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</div>

<div id="overlay" class="overlay" onclick="closePopup()"></div>

<!-- Bootstrap JS and dependencies -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  function openPopup() {
    document.getElementById('popup').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
  }

  function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
  }

  // Hide the deletion message after 2 seconds
  setTimeout(function() {
    document.getElementById('deleteMessage').classList.add('hidden');
  }, 2000);
</script>

</body>
</html>
