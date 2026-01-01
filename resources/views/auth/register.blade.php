<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ url('assets/img/tbdots-logo-1.png') }}">
    <title>404 - Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
        }

        h1 {
            font-size: 8rem;
            font-weight: bold;
            color: #009432;
            margin-bottom: 10px;
        }

        h3 {
            font-size: 1.75rem;
            margin-bottom: 15px;
            color: #333;
        }

        p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 30px;
        }

        .btn {
            padding: 12px 28px;
            font-size: 1rem;
            background-color: #009432;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background-color: #007A2A;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 5rem;
            }

            h3 {
                font-size: 1.3rem;
            }

            p {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h3>Oops! Page not found.</h3>

        <p>
            This page is no longer available. It may have been removed or relocated.
        </p>

        <a href="{{ url('login') }}" class="btn">Back to Login Page</a>
    </div>
</body>
</html>
