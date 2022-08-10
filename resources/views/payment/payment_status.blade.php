<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dance 2 Beat - Checkout Payment Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css'>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Tajawal:300,400,500,700");

        body {
            padding-top: 3em;
            padding-bottom: 3em;
            background-color: #f2f2f2;
            font-family: "Tajawal", sans-serif;
        }
    </style>
</head>

<body>
    <div id="master-wrap">
        <div id="logo-box">
            <div class="animated fast fadeInUp">
                <img src="{{ asset('frontend/images/logo.svg') }}" class="main-logo" width="150" alt="Dance 2 Beat">
            </div>
            <br>
            <br>
            <div class="animated fast fadeInUp">
                <div class="icon"></div>
                <h1>Please Wait ...</h1>
            </div>
            <br>

            <div class="notice animated fadeInUp">
                <p class="lead"><b>Your payment is being processed</b></p>
            </div>

            <div class="footer animated slow fadeInUp">
                <p class="copyright">&copy; Dance2beat</p>
            </div>
        </div>
        <!-- /#logo-box -->
    </div>
    <script>
        document.querySelector("body").onload = function () {
            setTimeout(function () { window.ReactNativeWebView.postMessage(@json($data)); }, 0);
        }

    </script>
</body>
<style>
    #master-wrap {
        margin: auto;
        width: 100%;
        padding: 10px;
    }

    #timer {
        font-size: 16px;
        font-size: 1rem;
    }

    .copyright {
        font-size: 14px;
        font-size: 0.875rem;
        text-align: center;
    }


    /* Animation */

    .animated {
        -webkit-animation-duration: 1.2s;
        -moz-animation-duration: 1.2s;
        -ms-animation-duration: 1.2s;
        -o-animation-duration: 1.2s;
        animation-duration: 1.2s;
        -webkit-transform: translate3d(0, 0, 0);
        -webkit-backface-visibility: hidden;
    }

    .animated.fast {
        -webkit-animation-duration: 800ms;
        -moz-animation-duration: 800ms;
        -ms-animation-duration: 800ms;
        -o-animation-duration: 800ms;
        animation-duration: 800ms;
    }

    .animated.slow {
        -webkit-animation-duration: 1.4s;
        -moz-animation-duration: 1.4s;
        -ms-animation-duration: 1.4s;
        -o-animation-duration: 1.4s;
        animation-duration: 1.4s;
    }

    @-webkit-keyframes fadeInUp {
        0% {
            opacity: 0;
            -webkit-transform: translateY(20px);
        }

        100% {
            opacity: 1;
            -webkit-transform: translateY(0);
        }
    }

    @-moz-keyframes fadeInUp {
        0% {
            opacity: 0;
            -moz-transform: translateY(20px);
        }

        100% {
            opacity: 1;
            -moz-transform: translateY(0);
        }
    }

    @-o-keyframes fadeInUp {
        0% {
            opacity: 0;
            -o-transform: translateY(20px);
        }

        100% {
            opacity: 1;
            -o-transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fadeInUp {
        -webkit-animation-name: fadeInUp;
        -moz-animation-name: fadeInUp;
        -o-animation-name: fadeInUp;
        animation-name: fadeInUp;
    }


    /* Layout: center box */

    #logo-box {
        text-align: center;
        padding: 30px;
    }

    h1 {
        font-size: 30px;
        margin: 0 auto;
    }


    /* Desktop only */

    @media (min-width: 481px) {
        #logo-box {
            position: absolute;
            text-align: center;
            left: 50%;
            top: 48%;
            width: 400px;
            margin-left: -230px;
            height: 440px;
            margin-top: -250px;
            font-size: 20px;

        }

        h1 {
            font-size: 36px;
        }
    }

    .icon {
        background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA4NDEuOSAxMTkwLjYiPjxwYXRoIGQ9Ik01NzMuMiAzNzMuNmwtMTguOS0xOC45TDM5Ni41IDUxNGwtODItODJMMjk3LjIgNDUxbDk5LjQgOTkuM0w1NzMuMiAzNzMuNnpNNzA1LjcgNDU1LjdWMTgyLjdIMTM3Ljh2MjcyLjlMOC40IDUwOS4zdjQ5OC41aDgyNS4xVjUwOS4zTDcwNS43IDQ1NS43ek03OTQuMSA1MjAuM2wtODguMyA1NS4ydi05MS41TDc5NC4xIDUyMC4zek02ODAuNCAyMDkuNnYzODMuM0w0MjEuNyA3NTMuOCAxNjMgNTkyLjlWMjA5LjZINjgwLjR6TTEzNy44IDU3NS42bC04OC40LTU1LjIgODguMy0zNi4zTDEzNy44IDU3NS42IDEzNy44IDU3NS42ek0zNS4zIDk4Mi41VjU0MC45bDM4Ni41IDI0NC41IDM4Ni40LTI0M3Y0NDEuN0gzNS4zVjk4Mi41ek0xMy40IDk5OC42bDQwOC40LTIxMi4yTTQyMi42IDc4Ni41TDgzMSA5OTguNyIgc3R5bGU9InN0cm9rZS13aWR0aDoyMDtzdHJva2U6IzAwMCIvPjwvc3ZnPg==) no-repeat center center;
        height: 128px;
        margin: auto;
        width: 90px;
    }
</style>
</html>
