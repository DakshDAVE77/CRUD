<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD Operations with Bootstrap and PHP</title>
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

<?php
include('connect.php');

if(isset($_POST['create'])) {
  $product_name = $_POST['product_name'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $description = $_POST['description'];

  // Insert data into database
  $sql = "INSERT INTO one (product_name, category, price, description) VALUES ('$product_name', '$category', '$price', '$description')";

  if(mysqli_query($conn, $sql)) {
    // Data inserted successfully, redirect to first_form.php
    header("Location: first_form.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
mysqli_close($conn);
?>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header">
          <h3 class="text-center">CRUD Form</h3>
        </div>
        <div class="card-body">
          <!-- Form -->
          <form id="crudForm" method="post" action="#">
            <div class="form-group">
              <label for="product_name">Product Name</label>
              <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name">
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category">
            </div>
            <div class="form-group">
              <label for="price">Price</label>
              <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price">
            </div>
            <div class="form-group">
              <label for="description">Category</label>
              <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description">
            </div>
            <button type="submit" class="btn btn-primary" name="create">Create</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>