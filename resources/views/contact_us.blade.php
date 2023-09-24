<!DOCTYPE html>
<html lang="ar">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Name</title>
  <!-- icon -->
  <link rel="shortcut icon" href="{{ asset('assets/demo/default/media/img/logo/favicon.ico')}}" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-rtl.css')}}" />
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/mdb.min.css')}}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/all.css')}}" />
  <!-- Custom style  -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/style.css')}}" />
  <!-- fonts  -->
  <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet" />

  <style>
    * {
      font-family: "Cairo", sans-serif;
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      outline: none;
    }

    body {
      overflow-x: hidden;
    }

    ::-webkit-scrollbar {
      width: 8px;
      background-color: transparent;
    }

    ::-webkit-scrollbar-track {
      -webkit-box-shadow: none;
      box-shadow: none;
    }

    ::-webkit-scrollbar-thumb {
      background-color: #1AB1A2;
      outline: none;
      border-radius: 20px !important;
    }

    a {
      text-decoration: none;
    }

    a:hover {
      text-decoration: none;
    }

    button:focus {
      outline: 0;
    }

    .form-control:focus {
      border: 1px solid #fff;
      -webkit-box-shadow: 0px 0px 6px 1px #9feff7;
      box-shadow: 0px 0px 6px 1px #9feff7;
      -webkit-transition: 0.3s ease;
      transition: 0.3s ease;
    }


    .logo img {
      width: 150px;
    }

    form {
      -webkit-box-shadow: 0px 5px 10px #00000030;
      box-shadow: 0px 5px 10px #00000030;
      background-color: #ffffff30;
      border-radius: 10px;
    }

    form label span {
      color: #e20f0f;
    }

    form .form-control {
      border: none;
      min-height: 44px;
      background-color: #f6f6f6;
      border-radius: 0;
    }
  </style>
</head>

<body>
  <div class="logo d-flex justify-content-center py-5">
    <a href="#">
      <img src="{{Storage::URL('uploads/'.setting()->header_logo)}}" />
    </a>
  </div>
  <!-- Default form register -->
  <div class="container mb-4">
    <form class="p-4" action="{{route('submit_contact_us')}}" method="post">
    @csrf
      <p class="h4 my-4 text-right font-weight-bold">تواصل معنا </p>
      
      @if(Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show " role="alert">
                                <p class="text-center">
                                  {{Session::get('success')}}
                                  </p>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                            @endif
                            
      <div class="form-row mb-3 px-lg-1">
        <div class="col-lg-6 p-1 ">
          <label> الإسم
            <span>*</span></label>
          <input type="text" class="form-control" name="name" required="" />
        </div>
        <div class="col-lg-6 p-1">
          <label>البريد الالكتروني<span>*</span></label>
          <input type="email" class="form-control" name="email" required=""/>
        </div>
        <div class="col-lg-6 p-1">
          <label>رقم الهاتف<span>*</span></label>
          <input type="text" class="form-control" name="phone" required=""/>
        </div>
        <div class="col-lg-12 p-1">
          <label>الموضوع <span>*</span></label>
          <input type="text" class="form-control" name="subject" required=""/>
        </div>
        <div class="col-lg-12 p-1 ">
          <label> أترك رسالتك <span>*</span></label>
          <textarea class="form-control" cols="30" rows="10" name="message" required=""></textarea>
        </div>
      </div>
      <div class=" text-center">
        <button class="btn btn-info my-4 " type="submit">
          إرسال
        </button>
      </div>
    </form>
  </div>
  <!-- Default form register -->
  <!--////////////////////////////////////////////////////////////////////////////////-->
  <!--////////////////////////////////////////////////////////////////////////////////-->
  <!--////////////////////////////////////////////////////////////////////////////////-->
  <!--/////////////////////////////JavaScript/////////////////////////////////////////-->
  <!--////////////////////////////////////////////////////////////////////////////////-->
  <!--////////////////////////////////////////////////////////////////////////////////-->
  <!--////////////////////////////////////////////////////////////////////////////////-->
  <script src="{{ asset('assets/front/js/jquery-3.4.1.min.js')}}"></script>
  <script src="{{ asset('assets/front/js/popper.min.js')}}"></script>
  <script src="{{ asset('assets/front/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('assets/front/js/mdb.min.js')}}"></script>
  <script src="{{ asset('assets/front/js/smooth-scroll.min.js')}}"></script>
  <script src="{{ asset('assets/front/js/fileupload.js')}}"></script>
  <script src="{{ asset('assets/front/js/Custom.js')}}"></script>
</body>

</html>