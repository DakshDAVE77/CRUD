<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Management</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .hidden {
      display: none;
    }
    .modal-dialog {
      margin: 0 auto;
      top: 20%;
      transform: translateY(-50%);
    }
    .modal-content {
      border: 1px solid #ced4da; /* Add border similar to table */
      border-radius: 0; /* Remove border radius */
    }
    #addProductModal .modal-body {
      padding: 20px; /* Add padding similar to table cells */
    }
    #addProductModal iframe {
      width: 200%;
      height: 100%;
      border: none;
    }
  </style>

</head>
<body>
<div class="container mt-5">
  <h2 class="text-center mb-4">Product Management</h2>
  <!-- Button trigger modal -->
  <button id="addProductBtn" class="btn btn-success" data-toggle="modal" data-target="#addProductModal">Add New Product</button>

  <!-- ADD Modal -->
  <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- Add this code after the "Add New Product" modal -->

        <div class="modal-body" id="addProductModalBody">
          <!-- Content from first_form.php will be loaded here -->
          <form id="crudForm" method="post" action="#" onsubmit="return validateForm()">
            <div class="form-group">
              <label for="product_name">Product Name</label>
              <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" >
            </div>
            <div>
              <span></span>
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" >
            </div>
            <div class="form-group">
              <label for="price">Price</label>
              <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" >
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" placeholder="Enter Description" ></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="create" class="btn btn-primary">Create</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="editProductModalBody">
        <form id="editForm" method="post" action="#" onsubmit="return validateEditForm()">
          <div class="form-group">
            <label for="edit_product_name">Product Name</label>
            <input type="text" class="form-control" id="edit_product_name" name="product_name" placeholder="Enter Product Name">
          </div>
          <div class="form-group">
            <label for="edit_category">Category</label>
            <input type="text" class="form-control" id="edit_category" name="category" placeholder="Enter Category">
          </div>
          <div class="form-group">
            <label for="edit_price">Price</label>
            <input type="text" class="form-control" id="edit_price" name="price" placeholder="Enter Price">
          </div>
          <div class="form-group">
            <label for="edit_description">Description</label>
            <textarea class="form-control" id="edit_description" name="description" placeholder="Enter Description"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
  </div>
     </form>
    </div>
  </div>
</div>

  <table id="productTable" class="table">
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
// Include the connection file
include('connect.php');

// Insertion of new product
if(isset($_POST['create'])) {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    // Insert data into database
    $sql = "INSERT INTO one (product_name, category, price, description) VALUES ('$product_name', '$category', '$price', '$description')";
    
    if(mysqli_query($conn, $sql)) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Deletion of product
// if(isset($_GET['delete'])) {
//     $id = $_GET['delete'];    

//     // Delete product from the database
//     $sql_delete = "DELETE FROM one WHERE id=$id";
    
//     if(mysqli_query($conn, $sql_delete)) {
//         echo "Record deleted successfully";
//     } else {
//         echo "Error deleting record: " . mysqli_error($conn);
//     }
// }

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
          echo "<a onclick='openEditModal(".$row['id'].")' class='btn btn-primary btn-sm mr-2'>Edit</a>";
          // echo "<a href='?delete=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>";
          echo "</td>";
          echo "</tr>";
      }
  } else {
      echo "<tr><td colspan='6'>No products found</td></tr>";
  }
              
    //editing 
    if(isset($_POST['productId'])) {
      $productId = $_POST['productId'];                                                                                                                                                                                               
      // Fetch product details from the database
      $sql_select = "SELECT * FROM one WHERE id = $productId";
      $result = $conn->query($sql_select);
      if ($result->num_rows > 0) {
          $product = $result->fetch_assoc();
          echo json_encode($product);
      } else {
          echo "Product not found";
      }
    }else {
      error_log('ProductId not received');
    }                
  //update                  
    if(isset($_POST['update'])) {
      $productId = $_POST['product_id'];
      $product_name = $_POST['product_name'];
      $category = $_POST['category'];
      $price = $_POST['price'];
      $description = $_POST['description'];
      
      // Update data in the database
      $sql_update = "UPDATE one SET product_name='$product_name', category='$category', price='$price', description='$description' WHERE id=$productId";
      
      if(mysqli_query($conn, $sql_update)) {
          echo "Data updated successfully";
      } else {
          echo "Error updating data: " . mysqli_error($conn);
      }
    
    $conn->close();
}                
                ?>
            </tbody>
        </table>
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>

      function openEditModal(productId) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: { productId: productId },
            success: function(response) {
              console.log('Success:', response);
                $('#editProductModal #edit_product_name').val(response.product_name); 
                $('#editProductModal #edit_category').val(response.category);
                $('#editProductModal #edit_price').val(response.price);
                $('#editProductModal #edit_description').val(response.description);
                $('#editProductModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error occurred while fetching product details.');
            }
        });
      }
// Form submission for updating
// $('#editForm').submit(function(event) {
//     event.preventDefault(); 
//     // $.ajax({
//     //     type: 'POST',
//     //     url: 'first_form.php', // Correct URL for update script
//     //     data: $(this).serialize(), // Serialize form data
//     //     success: function(response) {
//     //         console.log(response); // Log response for debugging
//     //         // Handle success or show confirmation
//     //     },
//     //     error: function(xhr, status, error) {
//     //         console.error(xhr.responseText);
//     //         alert('Error occurred while updating product details.');
//     //     }
//     // });
// });


      function validateForm() {
        
        var productName = document.getElementById("product_name").value;
        var category = document.getElementById("category").value;
        var price = document.getElementById("price").value;
        var description = document.getElementById("description").value;
        
        if (productName == "" || category == "" || price == "text" || description == "") {
          alert("Please fill in all the required fields.");
          return false;
        }
        if(productName == ""){
          return $message = "Please Enter Name";
        }
      }
      
    </script>
</body>
</html>