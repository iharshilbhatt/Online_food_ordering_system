<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Food Delivery Dashboard</title>
  <link rel="stylesheet" href="tailwind.min.css">
  <link rel="stylesheet" href="all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">

  <style>

.hero-bg {
  background: linear-gradient(to right, rgba(0, 123, 255, 0.7), rgba(0, 54, 98, 0.7)), url('your-background-image.jpg'); /* Gradient overlay with optional background image */
  background-size: cover;
  background-position: center;
  position: relative;
  height: 60vh; /* Adjusted height */
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
  padding: 2rem; /* Padding for better spacing */
  overflow: hidden; /* Ensure content stays within bounds */
  border-radius: 12px; /* Rounded corners */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Subtle shadow for depth */
}

.hero-bg .overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.6); /* Darker overlay for better text contrast */
  border-radius: 12px; /* Match overlay with rounded corners */
}

.hero-bg h2 {
  font-size: 2rem; /* Smaller font size */
  font-weight: 700;
  margin-bottom: 0.5rem; /* Reduced margin */
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Subtle text shadow */
}

.hero-bg p {
  font-size: 1rem; /* Smaller font size */
  margin-bottom: 1rem; /* Reduced margin */
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Subtle text shadow */
}

.btn-primary {
  background-color: #ff5722;
  color: #fff;
  padding: 0.5rem 1.25rem; /* Smaller padding */
  border-radius: 25px; /* Rounded button */
  text-decoration: none;
  display: inline-block;
  font-weight: bold;
  transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition for hover effects */
}

.btn-primary:hover {
  background-color: #e64a19;
  transform: scale(1.05); /* Slight scale effect on hover */
}

.btn-secondary {
  background-color: #009688;
  color: #fff;
  padding: 0.5rem 1.25rem; /* Smaller padding */
  border-radius: 25px; /* Rounded button */
  text-decoration: none;
  display: inline-block;
  font-weight: bold;
  transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition for hover effects */
}

.btn-secondary:hover {
  background-color: #00796b;
  transform: scale(1.05); /* Slight scale effect on hover */
}

    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 8px;
    }
    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
      background-color: #ff5722;
      color: #fff;
    }
    .btn-primary:hover {
      background-color: #e64a19;
    }
    .btn-secondary {
      background-color: #009688;
      color: #fff;
    }
    .btn-secondary:hover {
      background-color: #00796b;
    }
    .sticky-header {
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .search-bar {
      border-radius: 50px;
      padding: 0.5rem 1rem;
      border: 1px solid #ddd;
    }
    .quick-view-modal {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
    }
    .quick-view-content {
      background: #fff;
      padding: 2rem;
      border-radius: 8px;
      width: 80%;
      max-width: 800px;
    }
    .btn-toast {
      background-color: #4caf50;
      color: #fff;
      border-radius: 5px;
      padding: 0.5rem 1rem;
    }
    .btn-toast.error {
      background-color: #f44336;
    }
  
    
  </style>
</head>
<body class="font-poppins">

<?php
// Start the session
session_start();

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    include 'admindash.php';
    exit();
}

// Initialize the cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

include 'includes/conn.php';

// Check if the 'category' parameter is set
if (!isset($_GET['category'])) {
    // Fetch all products from the database
    $sql = "SELECT * FROM products WHERE status = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
} else {
    $category = $_GET['category'];

    // Fetch products based on the category from the database
    $sql = "SELECT * FROM products WHERE status = 1 AND category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $category);
    $stmt->execute();
}

// Fetch the results
$result = $stmt->get_result();
$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Handle "Add to Cart" request
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        $_SESSION['cart'][$productId] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'image' => $product['picture_url'] ?: 'default-image.jpg'
        ];
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle "Remove from Cart" request
if (isset($_POST['remove_from_cart'])) {
    $productId = $_POST['product_id'];
    unset($_SESSION['cart'][$productId]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle "Checkout" request
if (isset($_POST['checkout'])) {
    $orderId = uniqid('ORD_'); // Generate a unique order ID
    $totalPrice = 0;
    $productsList = [];

    foreach ($_SESSION['cart'] as $itemId => $item) {
        $totalPrice += $item['price'] * $item['quantity'];
        $productsList[] = $itemId . ',' . $item['quantity'];
    }

    $productsString = implode(',', $productsList);

    // Insert order into the database
    $sql = "INSERT INTO orders (order_id, user_id, products, total_price, fulfilled) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $fulfilled = NULL;
    $stmt->bind_param("sisss", $orderId, $_SESSION['user_id'], $productsString, $totalPrice, $fulfilled);
    $stmt->execute();

    // Clear the cart
    unset($_SESSION['cart']);

    header("Location: order_confirmation.php?order_id=" . $orderId);
    exit();
}
?>

<!-- Header -->
<header class="sticky-header bg-light-orange shadow-md z-50 py-4">
  <div class="flex items-center justify-between px-4 md:px-16">
    <!-- Logo -->
    <a href="index.php" class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
      <img src="https://www.svgrepo.com/show/477681/delivery.svg" alt="Food Delivery Logo" class="h-10"> <!-- Replace with your logo -->
      <span>Food Delivery</span>
    </a>

    <!-- Navigation and Actions -->
    <div class="flex items-center space-x-4">
      <!-- Search Bar -->
      <div class="relative flex items-center">
        <input 
          type="text" 
          placeholder="Search..." 
          class="search-bar border-gray-300 rounded-full px-4 py-2 w-full focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition duration-300 ease-in-out text-gray-700 placeholder-gray-400"
          aria-label="Search"
        />
        <button 
          type="button" 
          class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-200" 
          aria-label="Search Button"
        >
          <i class="fa fa-search"></i>
        </button>
      </div>

      <?php if ($isLoggedIn): ?>
        <a href="logout.php" class="text-gray-600 text-xl hover:text-teal-500 transition duration-300 ease-in-out" aria-label="Logout">
          <i class="fa fa-sign-out-alt"></i>
          <span class="ml-2">Logout</span>
        </a>
      <?php else: ?>
        <a href="login.php" class="text-gray-600 text-xl hover:text-teal-500 transition duration-300 ease-in-out" aria-label="Login">
          <i class="fa fa-sign-in-alt"></i>
          <span class="ml-2">Login</span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</header>

<style>
  .bg-light-orange {
    background-color:  #FF6347; /* Slightly darker light orange background color */
  }
</style>


      <!-- Hamburger Menu for Mobile -->
      <button id="open-menu" class="fa fa-bars cursor-pointer text-gray-600 text-2xl lg:hidden" aria-label="Open Menu"></button>
    </div>
  </div>
</header>

<!-- Sidebar Menu -->
<div id="menu" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-75 transform -translate-x-full transition-transform duration-300 ease-in-out">
  <div class="flex flex-col h-full bg-white w-64 lg:w-1/4 p-4">
    <button id="close-menu" class="text-gray-600 text-2xl ml-auto">
      <i class="fa fa-times"></i>
    </button>
    <div class="mt-8">
      <h2 class="text-lg font-bold text-gray-800">Categories</h2>
      <ul class="mt-4">
        <li><a href="?category=pasta" class="text-gray-600 hover:text-gray-800">Pasta</a></li>
        <li><a href="?category=soup" class="text-gray-600 hover:text-gray-800">Soup</a></li>
        <li><a href="?category=fries" class="text-gray-600 hover:text-gray-800">Fries</a></li>
        <li><a href="?category=drink" class="text-gray-600 hover:text-gray-800">Drinks</a></li>
      </ul>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 md:px-16 py-8">
 <!-- Hero Section -->
<div class="hero-bg h-80 flex items-center justify-center relative text-center text-white">
  <div class="absolute inset-0 bg-black opacity-50"></div>
  <div class="relative z-10 px-6 md:px-12 py-8">
    <h2 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">Delicious Food Delivered Fast!</h2>
    <p class="text-lg md:text-xl mb-6">Explore our menu and order your favorite dishes now. Fresh and hot, delivered right to your doorstep.</p>
    <a href="#products" class="btn-primary px-6 py-3 rounded-lg text-white font-bold hover:bg-orange-600 transition duration-300">Order Now</a>
  </div>
</div>



  <!-- Categories Section -->
  <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-5 mt-6 md:mt-12">
    <div onclick="window.location.href = '?'" class="border rounded-full p-2 flex flex-col items-center shadow-xl cursor-pointer transition-colors duration-700 ease-in-out">
      <div class="border rounded-full p-2 bg-white">
        <img class="h-12 w-12 p-2" src="https://www.svgrepo.com/show/133841/food.svg" alt="Pizza">
      </div>
      <p class="mt-3 mb-10 font-bold text-xs">ALL</p>
    </div>
    <div onclick="window.location.href = '?category=pizza'" class="border rounded-full p-2 flex flex-col items-center shadow-xl cursor-pointer transition-colors duration-700 ease-in-out">
      <div class="border rounded-full p-2 bg-white">
        <img class="h-12 w-12" src="https://www.svgrepo.com/show/93202/pizza.svg" alt="Pizza">
      </div>
      <p class="mt-3 mb-10 font-bold text-xs">Pizza</p>
    </div>
    <div onclick="window.location.href = '?category=pasta'" class="border rounded-full p-2 flex flex-col items-center shadow-xl cursor-pointer transition-colors duration-700 ease-in-out">
      <div class="border rounded-full p-2 bg-white">
        <img class="h-12 w-12" src="https://www.svgrepo.com/show/267135/spaghetti-pasta.svg" alt="Pizza">
      </div>
      <p class="mt-3 mb-10 font-bold text-xs">Pasta</p>
    </div>
    <div onclick="window.location.href = '?category=soup'" class="border rounded-full p-2 flex flex-col items-center shadow-xl cursor-pointer transition-colors duration-700 ease-in-out">
      <div class="border rounded-full p-2 bg-white">
        <img class="h-12 w-12" src="https://www.svgrepo.com/show/53312/soup.svg" alt="Pizza">
      </div>
      <p class="mt-3 mb-10 font-bold text-xs">Soup</p>
    </div>
    <div onclick="window.location.href = '?category=fries'" class="border rounded-full p-2 flex flex-col items-center shadow-xl cursor-pointer transition-colors duration-700 ease-in-out">
      <div class="border rounded-full p-2 bg-white">
        <img class="h-12 w-12" src="https://www.svgrepo.com/show/17518/french-fries.svg" alt="Pizza">
      </div>
      <p class="mt-3 mb-10 font-bold text-xs">Fries</p>
    </div>
    <div onclick="window.location.href = '?category=drink'" class="border rounded-full p-2 flex flex-col items-center shadow-xl cursor-pointer transition-colors duration-700 ease-in-out">
      <div class="border rounded-full p-2 bg-white">
        <img class="h-12 w-12" src="https://www.svgrepo.com/show/38245/soft-drink.svg" alt="Pizza">
      </div>
      <p class="mt-3 mb-10 font-bold text-xs">Drinks</p>
    </div>
  </div>


  <!-- Products Section -->
  <div id="products" class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($products as $product): ?>
      <div class="card flex flex-col bg-white rounded-lg shadow-lg p-4">
        <div class="h-40 bg-cover bg-center rounded-lg" style="background-image: url('<?php echo htmlspecialchars($product['picture_url'] ?: 'default-image.jpg'); ?>');"></div>
        <div class="mt-4 flex flex-col justify-between flex-grow">
          <p class="font-medium text-lg text-gray-800"><?php echo htmlspecialchars($product['name']); ?></p>
          <p class="text-sm text-gray-600 mt-2 mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
          <div class="flex justify-between items-center mt-2">
            <span class="text-teal-600 font-bold text-xl">₹ <?php echo htmlspecialchars($product['price']); ?></span>
            <?php if ($isLoggedIn): ?>
              <form method="POST" action="">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                <input type="number" name="quantity" min="1" value="1" class="border rounded px-2 py-1 w-20">
                <button type="submit" name="add_to_cart" class="btn-secondary mt-4 px-4 py-2 rounded-lg font-bold text-white">Add to Cart</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Cart Sidebar -->
<!-- Cart Sidebar -->
<?php if ($isLoggedIn): ?>
  <div class="cart-sidebar bg-white shadow-lg border-l border-gray-300 lg:w-96 xl:w-1/3 2xl:w-1/4 h-full lg:h-auto p-6 flex flex-col">
    <div class="flex items-center justify-between mb-6">
      <i class="fa fa-user text-gray-800 text-4xl"></i>
      <div class="bg-yellow-400 px-4 py-2 rounded-full text-xs font-bold text-black">
        <?php echo count($_SESSION['cart']); ?>
      </div>
    </div>
    <div class="mb-6">
      <p class="text-3xl font-bold text-gray-900">My Order 😎</p>
    </div>
    <div class="bg-gradient-to-r from-purple-800 via-purple-600 to-purple-400 rounded-lg p-6 text-white mb-6">
      <p class="text-sm font-semibold">Location:</p>
      <div class="flex justify-between items-center mt-2">
        <p class="text-sm">Marwadi University - RAJ-MOR Road - 360001</p>
        <p class="text-yellow-300 cursor-pointer font-semibold hover:underline">Edit</p>
      </div>
    </div>

    <!-- Cart Items Section -->
    <?php if (!empty($_SESSION['cart'])): ?>
      <div class="flex-1 overflow-y-auto">
        <?php $totalPrice = 0; ?>
        <?php foreach ($_SESSION['cart'] as $itemId => $item): ?>
          <?php $totalPrice += $item['price'] * $item['quantity']; ?>
          <div class="cart-item flex items-center mb-4 p-4 bg-gray-50 border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="h-32 w-32 object-cover rounded-lg border border-gray-300">
            <div class="flex-grow ml-4">
              <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($item['name']); ?></p>
              <p class="text-sm text-gray-600">₹ <?php echo htmlspecialchars($item['price']); ?> x <?php echo htmlspecialchars($item['quantity']); ?></p>
            </div>
            <div class="text-gray-700 text-lg font-semibold ml-4">
              ₹ <?php echo number_format($item['price'] * $item['quantity'], 2); ?>
            </div>
            <form method="POST" action="" class="ml-4 flex items-center">
              <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($itemId); ?>">
              <button type="submit" name="remove_from_cart" class="text-red-500 hover:text-red-700 transition-colors text-sm font-semibold">
                <i class="fa fa-trash"></i> Remove
              </button>
            </form>
          </div>
        <?php endforeach; ?>

        <div class="mt-6 pt-4 border-t border-gray-200">
          <div class="flex justify-between items-center text-xl font-semibold text-gray-900">
            <span>Total:</span>
            <span>₹ <?php echo number_format($totalPrice, 2); ?></span>
          </div>
          <form method="POST" action="" class="mt-4">
            <button type="submit" name="checkout" class="w-full py-3 px-4 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors">
              Checkout <i class="ml-3 fa fa-arrow-right"></i>
            </button>
          </form>
        </div>
      </div>
    <?php else: ?>
      <p class="empty-cart text-center text-gray-600 m-10 h-full">Your cart is empty.</p>
    <?php endif; ?>
  </div>
<?php endif; ?>


<!-- Quick View Modal -->
<div class="quick-view-modal" id="quick-view-modal">
  <div class="quick-view-content">
    <button class="text-gray-600 text-2xl float-right" id="close-quick-view">
      <i class="fa fa-times"></i>
    </button>
    <div id="quick-view-details">
      <!-- Content will be dynamically loaded here -->
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#open-menu').click(function() {
      $('#menu').addClass('translate-x-0');
    });
    $('#close-menu').click(function() {
      $('#menu').removeClass('translate-x-0');
    });
    $('#close-quick-view').click(function() {
      $('#quick-view-modal').hide();
    });
    $('.card').click(function() {
      var productId = $(this).data('id');
      $.ajax({
        url: 'get_product_details.php',
        method: 'POST',
        data: { id: productId },
        success: function(response) {
          $('#quick-view-details').html(response);
          $('#quick-view-modal').show();
        }
      });
    });
  });
</script>

</body>
</html>


