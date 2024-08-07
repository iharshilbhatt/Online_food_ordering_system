<?php


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == 0) {
    header('Location: index.php');
    exit();
}

include 'includes/conn.php';

// Fetch latest 3 products
$sql = "SELECT * FROM products ORDER BY id DESC LIMIT 3";
$latestProducts = $conn->query($sql);

// Fetch all orders with product details
$sql = "SELECT * FROM orders ORDER BY id DESC";
$orders = $conn->query($sql);    

// Handle product addition
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $product_id = bin2hex(random_bytes(6));
    $price = $_POST['price'];
    $picture_url = $_POST['picture_url'];

    $sql = "INSERT INTO products (product_id, name, description, category, price, picture_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $product_id, $name, $description, $category, $price, $picture_url); 
    $stmt->execute();

    header('Location: admindash.php');
    exit();
}

// Handle order status update
if (isset($_POST['update_order_status'])) {
    $orderId = $_POST['order_id'];
    $sql = "UPDATE orders SET fulfilled = 1 WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $orderId);
    $stmt->execute();

    header('Location: admindash.php');
    exit();
}

// Handle product edit
if (isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $picture_url = $_POST['picture_url'];

    $sql = "UPDATE products SET name = ?, description = ?, category = ?, price = ?, picture_url = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdsi", $name, $description, $category, $price, $picture_url, $id);
    $stmt->execute();

    header('Location: admindash.php');
    exit();
}

?>



<!-- Sidebar Menu -->
<div id="menu" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-75 transform -translate-x-full transition-transform duration-300 ease-in-out">
  <div class="flex flex-col h-full bg-white w-64 lg:w-1/4 p-4">
    <button id="close-menu" class="text-gray-600 text-2xl ml-auto">
      <i class="fa fa-times"></i>
    </button>
    <h6 class="font-bold text-lg mb-4">Menu</h6>
    <ul class="space-y-4">
      <li><a href="admindash.php" class="text-gray-800 hover:text-teal-600">Dashboard</a></li>
      <li><a href="logout.php" class="text-gray-800 hover:text-teal-600">Logout</a></li>
    </ul>
  </div>
</div>


<div class="flex flex-col md:flex-row min-h-screen" id="dribbleShot">
  <!-- Main Content Area -->
  <div class="main flex-grow border-b md:border-r border-gray-200">
    <div class="flex items-center px-4 md:px-16 py-8" style="background-color: rgb(254,146,88,255);">
      <button id="open-menu" class="fa fa-bars cursor-pointer text-gray-600 lg:hidden text-2xl"></button>
      <h6 class="font-bold text-lg mx-4 md:mx-10">Food Delivery Dashboard</h6>
    </div>

    <div class="px-4 md:px-16 py-8">
    <!-- Banner Section -->
    <div class="mt-8 bg-orange-100 rounded-lg p-6 flex flex-col md:flex-row items-center">
      <div class="hidden md:block md:w-1/3">
        <img src="https://image.freepik.com/free-vector/vector-cartoon-illustration-traditional-set-fast-food-meal_1441-331.jpg" alt="fooood" class="rounded-lg">
      </div>
      <div class="md:w-2/3 flex flex-col justify-center items-center text-center">
        <h3 class="tracking-wide text-orange-600 text-lg">₹0 delivery for 30 days! 🎉</h3>
        <p class="text-sm text-gray-500 mt-2">₹0 delivery fee for orders over ₹200 for 30 days</p>
        <a class="mt-4 font-medium text-orange-500 hover:underline" href="">Learn More <i class="ml-2 fa fa-arrow-right"></i></a>
      </div>
    </div>

    <!-- Products Widget -->
      <h3 class="text-lg font-bold mb-4">Latest Products</h3>
      <button class="mt-4 px-4 py-2 rounded bg-green-500 hover:bg-green-600 text-white font-bold">Add Product</button>

      <div class="mt-8 grid grid-cols-1 md:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        <?php while ($product = $latestProducts->fetch_assoc()): ?>
        <form class="bg-white rounded-lg shadow-lg p-6" data-id="<?php echo $product['id']; ?>" method="POST" action="">
          <div class="h-40 rounded-lg overflow-hidden bg-cover bg-center" style="background-image: url('<?php echo $product['picture_url']; ?>');"></div>
          <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
          <div class="mt-4">
            <label for="name_<?php echo $product['id']; ?>" class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" id="name_<?php echo $product['id']; ?>" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($product['name']); ?>" required>
          </div>
          <div class="mt-2">
            <label for="description_<?php echo $product['id']; ?>" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description_<?php echo $product['id']; ?>" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required><?php echo htmlspecialchars($product['description']); ?></textarea>
          </div>
          <div class="mt-4">
            <label for="category_<?php echo $product['id']; ?>" class="block text-sm font-medium text-gray-700">category</label>
            <input type="text" id="category_<?php echo $product['id']; ?>" name="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($product['category']); ?>" required>
          </div>
          <div class="mt-2">
            <label for="price_<?php echo $product['id']; ?>" class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" id="price_<?php echo $product['id']; ?>" name="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($product['price']); ?>" required>
          </div>
          <div class="mt-2">
            <label for="picture_url_<?php echo $product['id']; ?>" class="block text-sm font-medium text-gray-700">Picture URL</label>
            <input type="url" id="picture_url_<?php echo $product['id']; ?>" name="picture_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($product['picture_url']); ?>" required>
          </div>
          <div class="mt-4 flex justify-end">
            <button type="submit" name="edit_product" class="px-4 py-2 rounded bg-yellow-400 hover:bg-yellow-500 text-white font-bold">Save Changes</button>
          </div>
        </form>
        <?php endwhile; ?>
      </div>

  </div>
  </div>

    <div class="bg-gray-100 sidebar flex flex-col p-6">
    <!-- Orders Widget -->
    <div class="mt-8">
      <h3 class="text-lg font-bold mb-4">Current Orders</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-lg h-40 overflow-y-auto">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b">Order ID</th>
              <th class="py-2 px-4 border-b">User ID</th>
              <th class="py-2 px-4 border-b">Products</th>
              <th class="py-2 px-4 border-b">Total Price</th>
              <th class="py-2 px-4 border-b">Status</th>
              <th class="py-2 px-4 border-b">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($order = $orders->fetch_assoc()): ?>
            <tr>
              <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($order['order_id']); ?></td>
              <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($order['user_id']); ?></td>
              <td class="py-2 px-4 border-b">
                <div class="flex flex-wrap lg:grid lg:grid-cols-1 lg:gap-4 gap-4 justify-center w-full p-2 max-h-52 overflow-y-auto">

                  <?php
                    // Parse and display product details
                    $products = [];
                    $productStrings = explode(',', $order['products']);
                    for ($i = 0; $i < count($productStrings); $i += 2) {
                        $productId = $productStrings[$i];
                        $quantity = $productStrings[$i + 1];
                        
                        $sql = "SELECT * FROM products WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $productId);
                        $stmt->execute();
                        $product = $stmt->get_result()->fetch_assoc();
                        
                        if ($product) {
                            $product['quantity'] = $quantity;
                            $products[] = $product;
                        }
                    }

                    foreach ($products as $product): ?>
                  <div class="flex items-center mb-2 lg:mb-0 lg:flex-col lg:items-start">
                    <img src="<?php echo htmlspecialchars($product['picture_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="h-16 w-16 object-cover rounded mr-4 lg:mr-0">
                    <div>
                      <div class="font-bold"><?php echo htmlspecialchars($product['name']); ?></div>
                      <div>Qty: <?php echo htmlspecialchars($product['quantity']); ?></div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </td>
              <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($order['total_price']); ?></td>
              <td class="py-2 px-4 border-b"><?php echo $order['fulfilled'] ? 'Fulfilled' : 'Pending'; ?></td>
              <td class="py-2 px-4 border-b">
                <?php if (!$order['fulfilled']): ?>
                <form method="POST" action="">
                  <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                  <button type="submit" name="update_order_status" class="px-4 py-2 rounded bg-green-500 hover:bg-green-600 text-white font-bold">Mark as Fulfilled</button>
                </form>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
    </div>
</div>


<!-- Add Product Modal -->
<div id="addProductModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
  <div class="bg-white rounded-lg p-6 w-full max-w-md">
    <h3 class="text-lg font-bold mb-4">Add Product</h3>
    <form method="POST" action="">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
        <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
      </div>
      <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
      </div>
      <div class="mb-4">
        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
        <input type="text" name="category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
      </div>
      <div class="mb-4">
        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
        <input type="number" name="price" id="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
      </div>
      <div class="mb-4">
        <label for="picture_url" class="block text-sm font-medium text-gray-700">Picture URL</label>
        <input type="url" name="picture_url" id="picture_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
      </div>
      <div class="flex justify-end">
        <button type="button" id="closeAddProductModal" class="mr-4 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
        <button type="submit" name="add_product" class="px-4 py-2 rounded bg-yellow-400 hover:bg-yellow-500 text-white font-bold">Add Product</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
  <div class="bg-white rounded-lg p-6 w-full max-w-md">
    <h3 class="text-lg font-bold mb-4">Edit Product</h3>
    <form method="POST" action="">
      <input type="hidden" name="id" id="edit_id">
      <div class="mb-4">
        <label for="edit_name" class="block text-sm font-medium text-gray-700">Product Name</label>
        <input type="text" name="name" id="edit_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
      </div>
      <div class="mb-4">
        <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" id="edit_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
      </div>
      <div class="mb-4">
        <label for="edit_category" class="block text-sm font-medium text-gray-700">Category</label>
        <input type="text" name="edit_category" id="edit_category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
      </div>
      <div class="mb-4">
        <label for="edit_price" class="block text-sm font-medium text-gray-700">Price</label>
        <input type="number" name="price" id="edit_price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
      </div>
      <div class="mb-4">
        <label for="edit_picture_url" class="block text-sm font-medium text-gray-700">Picture URL</label>
        <input type="url" name="picture_url" id="edit_picture_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
      </div>
      <div class="flex justify-end">
        <button type="button" id="closeEditProductModal" class="mr-4 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
        <button type="submit" name="edit_product" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $('#open-menu').click(function() {
      $('#menu').removeClass('-translate-x-full').addClass('translate-x-0');
    });
    $('#close-menu').click(function() {
      $('#menu').removeClass('translate-x-0').addClass('-translate-x-full');
    });
    $('.bg-yellow-400').click(function() {
      // Populate edit product modal with product details
      const card = $(this).closest('.bg-white');
      $('#edit_id').val(card.data('id'));
      $('#edit_name').val(card.find('.font-medium').text());
      $('#edit_description').val(card.find('.text-gray-600').text());
      $('#edit_category').val(card.find('.font-medium').text());
      $('#edit_price').val(card.find('.text-teal-600').text().replace('₹ ', ''));
      $('#edit_picture_url').val(card.find('style').css('background-image').replace('url("', '').replace('")', ''));
      $('#editProductModal').removeClass('hidden');
    });
    $('#closeAddProductModal').click(function() {
      $('#addProductModal').addClass('hidden');
    });
    $('#closeEditProductModal').click(function() {
      $('#editProductModal').addClass('hidden');
    });
    $('.bg-green-500').click(function() {
      $('#addProductModal').removeClass('hidden');
    });
  });
</script>

</body>

</html>