<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        background: url('{{ asset("images/Green.jpg") }}') no-repeat center center fixed;
        background-size: cover;
    }

    .black {
        color: white;
    }

    .header {
        background-color: transparent;
        color: white;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: none;
    }

    .header h1 {
        font-size: 24px;
        margin-left: 20px;
    }

    .home-btn {
        background-color: white;
        color: #2e7d32;
        padding: 8px 16px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 8px;
        text-decoration: none;
        margin-right: 20px;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
        transition: background 0.3s ease;
    }

    .home-btn:hover {
        background-color: #e0e0e0;
    }

    .option-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 40px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .option {
        width: 400px;
        height: 400px;
        color: white;
        border-radius: 15px;
        cursor: pointer;
        transition: 0.3s;
        text-align: center;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding-bottom: 20px;
        background-size: cover;
        background-position: center;
        text-decoration: none;
        overflow: hidden;
    }

    .option:hover {
        transform: scale(1.05);
    }

    .option img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 15px 15px 0 0;
    }

    .option-text {
        padding: 20px;
        font-size: 24px;
        font-weight: bold;
        background: rgba(0, 0, 0, 0.6);
    }

    .description-text {
        padding: 20px;
        font-size: 14px;
        font-weight: normal;
        text-align: justify;
        background: rgba(0, 0, 0, 0.6);
    }
</style>

<header class="header">
    <a href="/" class="home-btn">Back</a>
</header>

<div class="option-container">
    @foreach ($packages as $package)
    <a href="{{ route('frm', ['package_id' => $package->package_id]) }}"
 
           class="option" 
           style="background-image: url('{{ asset($package->image) }}');">
            <div class="option-text">{{ $package->package_name }}</div>
            <div class="description-text">
                {{ $package->description }} <br>
                <strong>₱{{ number_format($package->price, 2) }}</strong> | 
                {{ $package->number_of_days }} days | 
                Up to {{ $package->number_of_guests }} guests
            </div>
        </a>
    @endforeach
</div>





</body>
</html>
