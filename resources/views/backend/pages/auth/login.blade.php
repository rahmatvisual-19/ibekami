<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Dashboard-ibeka.id</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
   
  <link rel="stylesheet" href="{{asset('backend/css/loginPage/style.css')}}" /> 
</head>
<body>
  <!-- Login 13 - Bootstrap Brain Component -->

  @if (session()->has('loginError'))
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{session('loginError')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
  </div>
  </div>
  </div>
  </div>
  @endif

<br>
<br>

<div class="wrapper bg-white">
        <div class="h2 text-center"> <img src="{{ asset('images/logo/ibeka.png') }}" alt="Logo Ibeka" style="height: 100px;"></div>
        <div class="h4 text-muted text-center pt-2">
            Login Form
        </div>
        
        
       <form action="/login-ibeka99" method="POST">
            @csrf
            <div class="form-group py-2">
                <div class="input-field">
                    <span class="far fa-user p-2"></span>
                    <input type="text" name="username" id="username" placeholder="Username" required autofocus class="">
                </div>
            </div>
            <div class="form-group py-1 pb-2">
                <div class="input-field">
                    <span class="fas fa-lock p-2"></span>
                    <input type="password" name="password" id="password" placeholder="Enter your Password" required class="">
                    <button class="btn bg-white text-muted">
                       
                    </button>
                </div>
            </div>
            <div class="d-flex align-items-start">
                
                <div class="ml-auto">
                   
                </div>
            </div>
            <button class="btn btn-block text-center my-3">Log in</button>
           
        </form>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>