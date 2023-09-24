<!DOCTYPE html>
<html lang="ar">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>TruckTrip</title>
    <!-- icon -->
    <link rel="icon" href="{{asset("/terms")}}/img/logo.png" type="image/x-icon" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset("/terms")}}/css/bootstrap-rtl.css" />
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="{{asset("/terms")}}/css/mdb.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("/terms")}}/css/all.css" />
    <!-- swiper -->
    <link rel="stylesheet" href="{{asset("/terms")}}/css/swiper.css" />
    <!-- animate -->
    <link rel="stylesheet" href="{{asset("/terms")}}/css/aos.css" />
    <link rel="stylesheet" href="{{asset("/terms")}}/css/datatables2.min.css" />
    <!-- Custom style  -->
    <link rel="stylesheet" href="{{asset("/terms")}}/css/style.css" />
    <!-- fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet" />
    <style>
        .container {
            background-color: rgb(255, 255, 255);
            padding: 60px;
            border-radius: 30px;
        }
        h5 {
            font-weight: bold;
            margin-bottom: 30px;
        }
    </style>
</head>

<body style="background-image: url({{asset("/terms")}}/img/pattern.jpg);
    background-attachment: fixed;
    background-size: cover;">
<!--////////////////////////////////////////////////////////////////////////////////-->
<!--/////////////////////////////   nav-bar   /////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->

<div class="logo">
    <div class="image py-5">
        <img src="  <?=(setting())? url('storage/').'/'.setting()->header_logo:asset("/terms")."/img/google-play.svg"?>" alt="">
    </div>

</div>



<div class="terms">
    <div class="container w-lg-75 z-depth-2">
        {{--<div class="links">
            <h3> عن <span> أكتفاء  </span></h3>
            <ul class="padl-15">
                <li><a href="#1">عن التطبيق </a></li>
            </ul>
        </div>--}}

        <div class="heading-para">
            <h3> شروط و احكام  <span> TruckTrip  </span></h3>
            <p class="1">
                {{(setting())? setting()->ar_termis_condition:"--"}}
            </p>
        </div>
    </div>
</div>
<!--////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->
<!--/////////////////////////////JavaScript/////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->
<script src="{{asset("/terms")}}/js/jquery-3.4.1.min.js"></script>
<script src="{{asset("/terms")}}/js/popper.min.js"></script>
<script src="{{asset("/terms")}}/js/bootstrap.min.js"></script>
<script src="{{asset("/terms")}}/js/mdb.min.js"></script>
<script src="{{asset("/terms")}}/js/smooth-scroll.min.js"></script>
<script src="{{asset("/terms")}}/js/swiper.js"></script>
<script src="{{asset("/terms")}}/js/aos.js"></script>
<script src="{{asset("/terms")}}/js/datatables2.min.js"></script>
<script src="{{asset("/terms")}}/js/Custom.js"></script>
</body>

</html>
