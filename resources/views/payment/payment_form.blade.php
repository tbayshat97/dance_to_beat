<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dance 2 Beat - Checkout Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css'>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Tajawal:300,400,500,700");
        body {
            background-color: #f2f2f2;
            font-family: "Tajawal", sans-serif;
            font-weight: bold
        }

        .payment {
            margin: 0 auto;
            padding: 15px;
        }
    </style>
</head>

<body>
    <div class="payment">
        <div class="row d-flex align-items-center">
            <div class="col-md-12 text-center">
                <div class="brand-logo" style="padding: 30px;">
                    <img src="{{ asset('frontend/images/logo.svg') }}" class="main-logo" width="150" alt="Dance 2 Beat">
                </div>
            </div>
        </div>
        <hr>
        <div class="payment-method">
            <h3>Payment Information</h3>
        </div>
        <hr>
        <script>
            jQuery.loadScript = function (url, callback) {
                jQuery.ajax({
                    url: url,
                    dataType: 'script',
                    success: callback,
                    async: true,
                    cache: true,
                });
            }

            var url_string = window.location.href;
            var url = new URL(url_string);
            var checkoutId = url.searchParams.get('checkoutId');

            if (typeof checkoutId != null) $.loadScript(`https://test.oppwa.com/v1/paymentWidgets.js?checkoutId=${checkoutId}`, function () {});
        </script>

        <form action="{{ route('payment-result') }}" class="paymentWidgets" data-brands="VISA MASTER">
            <input type="hidden" name="checkoutId" value="{{ Request::get('checkoutId') ?? '' }}" id="type">
            <input type="hidden" name="type" value="{{ Request::get('type') ?? '' }}" id="type">
            <input type="hidden" name="id" value="{{ Request::get('id') ?? '' }}" id="type">
        </form>

        <script>
            var wpwlOptions = {
                style: "plain",
                showCVVHint: true,
                brandDetection: true,
                locale: "en",
                onReady: function () {
                    $(".wpwl-group-cardNumber").after($(".wpwl-group-brand").detach());
                    $(".wpwl-group-cvv").after($(".wpwl-group-cardHolder").detach());
                    $(".wpwl-group-billing").css('display', 'none');
                    var visa = $(".wpwl-brand:first").clone().removeAttr("class").attr("class", "wpwl-brand-card wpwl-brand-custom wpwl-brand-VISA")
                    var master = $(visa).clone().removeClass("wpwl-brand-VISA").addClass("wpwl-brand-MASTER");
                    $(".wpwl-brand:first").after($(master)).after($(visa));
                },
                onChangeBrand: function (e) {
                    $(".wpwl-brand-custom").css("opacity", "0.3");
                    $(".wpwl-brand-" + e).css("opacity", "1");
                }
            }
        </script>
    </div>
</body>
</html>
