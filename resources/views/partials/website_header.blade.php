<html>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .buttonload {
        background-color: #04AA6D; /* Green background */
        border: none; /* Remove borders */
        color: white; /* White text */
        padding: 12px 24px; /* Some padding */
        font-size: 16px; /* Set a font-size */
        }

        /* Add a right margin to each icon */
        .fa {
        margin-left: -12px;
        margin-right: 8px;
        }
       
        </style>