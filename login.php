<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Ordering System</title>
    <link rel="stylesheet" href="tailwind.min.css">
    <link rel="stylesheet" href="all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
        }
        .btn-primary {
            background: linear-gradient(to right, #4f9a94, #00796b);
            color: white;
            font-weight: bold;
            border-radius: 8px;
            padding: 12px 24px;
            text-align: center;
            display: inline-block;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #00796b, #004d40);
        }
        .alert-error {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fef2f2;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 12px;
        }
        .input-focus:focus {
            border-color: #4f9a94;
            outline: none;
            box-shadow: 0 0 0 2px rgba(79, 195, 147, 0.3);
        }
        .sidebar {
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 16px;
            border-radius: 8px;
            position: fixed;
            width: 75%;
            max-width: 300px;
            top: 0;
            right: 0;
            height: 100%;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        .sidebar.open {
            transform: translateX(0);
        }
        .sidebar-button {
            position: fixed;
            top: 16px;
            right: 16px;
            z-index: 1000;
            background: #00796b;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease;
        }
        .sidebar-button:hover {
            background: #004d40;
        }
        .card {
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 16px;
            margin: 16px;
        }
        .header-title {
            font-size: 24px;
            margin-bottom: 16px;
        }
        .login-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        @media (min-width: 768px) {
            .header-title {
                font-size: 36px;
                margin-bottom: 24px;
            }
            .sidebar {
                transform: translateX(0);
                position: relative;
                width: 100%;
                max-width: none;
                height: auto;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Menu -->
    <div id="menu" class="sidebar">
        <button id="close-menu" class="text-gray-600 text-3xl">
            <i class="fa fa-times"></i>
        </button>
        <h6 class="font-bold text-lg mb-4 text-gray-800">Menu</h6>
        <ul class="space-y-4">
            <li><a href="index.php" class="text-gray-800 hover:text-teal-600">Home</a></li>
            <li><a href="login.php" class="text-gray-800 hover:text-teal-600">Login</a></li>
        </ul>
    </div>

    <!-- Sidebar Button -->
    <div id="sidebar-button" class="sidebar-button">
        <i class="fa fa-bars"></i>
    </div>

    <!-- Main Content Area -->
    <div class="flex flex-col items-center justify-center min-h-screen p-4">
        <div class="card flex flex-col md:flex-row items-center">
            <div class="hidden md:block w-full md:w-1/2">
                <img src="https://image.freepik.com/free-vector/vector-cartoon-illustration-traditional-set-fast-food-meal_1441-331.jpg" alt="Food" class="login-image">
            </div>
            <div class="w-full md:w-1/2">
                <form class="bg-white shadow-md rounded-lg px-6 py-8" action="authenticate.php" method="POST">
                    <h2 class="header-title text-center">Login / Register</h2>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="mobile">
                            Mobile Number
                        </label>
                        <input class="shadow-sm border rounded w-full py-3 px-4 text-gray-700 input-focus" id="mobile" name="mobile" type="tel" pattern="\d{10}" maxlength="10" minlength="10" placeholder="Mobile Number" required aria-labelledby="mobile">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                            Password
                        </label>
                        <input class="shadow-sm border rounded w-full py-3 px-4 text-gray-700 mb-3 input-focus" id="password" name="password" type="password" placeholder="Password" required aria-labelledby="password">
                    </div>
                    <?php if (isset($_GET['error'])) {?>
                        <div class="alert-error">
                            <?php echo $_GET['error'] === 'incorrect_password' ? 'Invalid Username/Password.' : 'Error creating user.'; ?>
                        </div>
                    <?php }?>
                    <div class="flex items-center justify-center">
                        <button class="btn-primary" type="submit">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript for sidebar toggle
        document.getElementById('sidebar-button').addEventListener('click', function() {
            document.getElementById('menu').classList.toggle('open');
        });

        document.getElementById('close-menu').addEventListener('click', function() {
            document.getElementById('menu').classList.remove('open');
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js"></script>
</body>
</html>
