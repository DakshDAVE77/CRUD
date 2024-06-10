<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Custom styles */
    .form-container {
      max-width: 500px;
      margin: 0 auto;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2 class="text-center mb-4">Edit Product</h2>
  <div class="form-container">
    <form action="#" method="POST">
      <?php
      include('connect.php');

      // Check if product ID is provided
      if(isset($_GET['id'])) {
          $one_id = $_GET['id'];

          // Fetch product details from the database
          $sql = "SELECT * FROM one WHERE id = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $one_id);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
      ?>
      <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
      <div class="form-group">
        <label for="product_name">Product Name:</label>
        <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $row['product_name']; ?>">
      </div>
      <div class="form-group">
        <label for="category">Category:</label>
        <input type="text" class="form-control" id="category" name="category" value="<?php echo $row['category']; ?>">
      </div>
      <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>">
      </div>
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description"><?php echo $row['description']; ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary" name="update">Update</button>
      <a href="first_form.php" class="btn btn-secondary">Cancel</a>
      <?php
          } else {
              echo "<div class='alert alert-danger'>Product not found.</div>";
          }

          $stmt->close();
      } else {
          echo "<div class='alert alert-danger'>Product ID not provided.</div>";
      }

      if(isset($_POST['update'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        
        // Update product details in the database
        $sql_update = "UPDATE one SET product_name='$product_name', category='$category', price='$price', description='$description' WHERE id='$product_id'";
        
        if ($conn->query($sql_update) === TRUE) {
            echo "Product details updated successfully.";
            header("Location: first_form.php");
            exit();
        } else {
            echo "Error updating product details: " . $conn->error;
        }
    }
    

      $conn->close();
      ?>
    </form>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
