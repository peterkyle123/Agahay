<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-image: url('https://scontent.fmnl9-2.fna.fbcdn.net/v/t1.6435-9/135855556_102349538492192_97676168925477488_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=cc71e4&_nc_eui2=AeFKPsokWu49ytK2BMAcNHFNotSZ1BVPJRyi1JnUFU8lHI8GvxDBokWQOXGLaM88MIWZV6ftfqFnKHM4XapkOPsZ&_nc_ohc=699Kle-B-WoQ7kNvgHdQNv7&_nc_zt=23&_nc_ht=scontent.fmnl9-2.fna&_nc_gid=Az1p49EcV-TQ46x2fZPxEV5&oh=00_AYD3EteIL80sj8fzmIfhTI7CeBCgc606N8WYwhfzad-cug&oe=67CA56B5'); /* Set your background image URL here */
            background-size: cover; /* Make the image cover the entire page */
            background-position: center; /* Center the image */
            background-attachment: fixed; /* Ensure the background stays fixed on scroll */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh; /* Full height of the screen */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 24px;
            max-width: 400px;
            width: 100%;
            margin: auto;
            text-align: center;
            position: relative;
            z-index: 2; /* Ensure form container is above the background */
        }

        .form-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .input-field {
            margin-bottom: 16px;
            padding: 12px 20px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            font-size: 1rem;
            color: #333;
            box-sizing: border-box; /* Ensures padding is included within width */
        }

        .input-field:focus {
            outline: none;
            border-color: #4caf50; /* Focused border color */
        }

        .login-btn {
            background-color: #4caf50;
            color: white;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .login-btn:hover {
            background-color: #388e3c; /* Darker shade on hover */
        }

        .checkbox-label {
            color: #555;
            font-size: 0.875rem;
        }

        .forgot-password {
            font-size: 0.875rem;
            color: #4caf50;
            text-decoration: none;
            margin-top: 10px;
            display: block;
            text-align: center;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <main>
        <div class="form-container">
            <h1 class="form-title">Welcome Back</h1>

            <form action="{{ route('dashboard') }}" method="POST"> <!-- Replace nextpage.html with your desired page -->
                <input class="input-field" type="email" placeholder="Email" required />
                <input class="input-field" type="password" placeholder="Password" required />

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input id="remember-me" type="checkbox" class="mr-2" />
                        <label for="remember-me" class="checkbox-label">Remember me</label>
                    </div>
                    <button class="login-btn" type="submit">Log In</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
