<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">

<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 0;
        padding: 0; /* Remove default padding */
        background: url('{{ asset("images/Green.jpg") }}') no-repeat center center fixed;
        background-size: cover;
        display: flex; /* Use flexbox for vertical centering */
        flex-direction: column; /* Align items vertically */
        min-height: 100vh; /* Ensure full viewport height */
    }

    .black {
        color: white;
    }

    .header {
        background: none; /* Light green gradient */
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

    .content-wrapper {  /* Added wrapper for content */
        flex: 1; /* Allow content to take up available space */
        padding: 20px; /* Add padding to content area */
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

<div class="content-wrapper"> <div class="option-container">  @foreach ($packages as $package)
<a href="{{ route('frm', ['package_id' => $package->package_id]) }}"
    class="option" 
    style="background-image: url('{{ asset($package->image) }}');">
    
    <div class="option-text">{{ $package->package_name }}</div>
    
    <div class="description-text">
        {{ $package->description }} <br>
        <strong>₱{{ number_format($package->price, 2) }}</strong> | 
        Up to {{ $package->number_of_guests }} guests <br>
        <span style="color: red;">Extra Pax: ₱{{ number_format($package->extra_pax_price, 2) }} per person</span>
    </div>
</a>

    @endforeach
</div> </div> </body>
</html>