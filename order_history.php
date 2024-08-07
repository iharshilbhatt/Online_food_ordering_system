<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders - Online Ordering System</title>
  <link rel="stylesheet" href="tailwind.min.css">
  <link rel="stylesheet" href="all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,800&display=swap">
</head>

<body class="font-poppins bg-gray-100 items-center justify-center">
  <?php session_start(); ?>
  <!-- Sidebar Menu -->
  <div id="menu" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-75 transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full bg-white w-64 lg:w-1/4 p-4">
      <button id="close-menu" class="text-gray-600 text-2xl ml-auto">
        <i class="fa fa-times"></i>
      </button>
      <h6 class="font-bold text-lg mb-4">Menu</h6>
      <ul class="space-y-4">
        <li><a href="index" class="text-gray-800 hover:text-teal-600">Home</a></li>
        <?php if (isset($_SESSION['user_id'])) {
        ?>
        <li><a href="order_history" class="text-gray-800 hover:text-teal-600">orders</a></li>
        <li><a href="logout" class="text-gray-800 hover:text-teal-600">logout</a></li>
        <?php
      } else{?>
        <li><a href="login" class="text-gray-800 hover:text-teal-600">Login</a></li>
        <?php }?>
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
        <div class="md:w-full flex flex-col justify-center items-center ">
          <?php

include 'includes/conn.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p class='text-red-600'>You need to be logged in to view your order history.</p>";
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch orders from the database
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

          <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl w-full mx-4 mt-8">
            <h1 class="text-2xl font-bold mb-4">Order History</h1>

            <?php if (empty($orders)): ?>
            <p class="text-gray-600 pb-8">You have no orders yet.</p>
            <?php else: ?>
            <?php foreach ($orders as $order): ?>
            <?php
      // Parse product details
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
      ?>

            <div class="mb-6 border-b border-gray-200 pb-4">
              <h2 class="text-xl font-semibold mb-2">Order #<?php echo htmlspecialchars($order['order_id']); ?></h2>
              <p class="text-gray-600 mb-2">Total Price: ₹ <?php echo number_format($order['total_price'], 2); ?></p>
              <p class="text-gray-600 mb-4">Status: <?php echo htmlspecialchars($order['fulfilled']) ? 'Completed' : 'Pending'; ?></p>

              <div class="mb-4">
                <h3 class="font-medium mb-2">Products:</h3>
                <?php foreach ($products as $product): ?>
                <div class="flex justify-between items-center mb-4">
                  <div class="flex items-center">
                    <img src="<?php echo htmlspecialchars($product['picture_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-16 h-16 object-cover rounded-lg mr-4">
                    <div>
                      <p class="font-medium"><?php echo htmlspecialchars($product['name']); ?></p>
                      <p class="text-sm">₹ <?php echo htmlspecialchars($product['price']); ?> x <?php echo htmlspecialchars($product['quantity']); ?></p>
                    </div>
                  </div>
                  <p class="text-lg font-bold">₹ <?php echo number_format($product['price'] * $product['quantity'], 2); ?></p>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

            <a href="index.php" class="bg-yellow-400 px-6 py-3 rounded-lg text-white font-bold hover:bg-yellow-500 transition duration-300">Go to Home Page</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <script>
    // JavaScript for menu toggle
    document.getElementById('open-menu').addEventListener('click', function() {
      document.getElementById('menu').classList.remove('-translate-x-full');
    });
    document.getElementById('close-menu').addEventListener('click', function() {
      document.getElementById('menu').classList.add('-translate-x-full');
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js"></script>
</body>

</html>