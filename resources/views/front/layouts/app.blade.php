{{-- THIS IS PARENT LAYOUT --}}

<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>CareerVibe | Find Best Jobs</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style2.css') }}" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@500&display=swap" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<!-- Fav Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">
<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
		<div class="container">
			<a class="navbar-brand" href="index.html">CareerVibe</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
					</li>	
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{ route('jobs') }}">Find Jobs</a>
					</li>										
				</ul>				

				@if (!Auth::check())
					<a class="btn btn-outline-primary me-2" href="{{ route('account.login') }}" type="submit">Login</a>
				@else
					@if (Auth::user()->role == 'admin')
						<a class="btn btn-outline-primary me-2" href="{{ route('admin.dashboard') }}" type="submit">Admin</a>
					@endif
					<a class="btn btn-outline-primary me-2" href="{{ route('account.profile') }}" type="submit">Account</a>
				@endif
				
				<a class="btn btn-primary" href="{{ route('account.createJob') }}" type="submit">Post a Job</a>
			</div>
		</div>
	</nav>
</header>

@yield('main')

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="profilePicForm" name="profilePicForm" action="" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image"  name="image">
				<p class="text-danger" id="image-error" ></p>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mx-3">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            
        </form>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dark py-4 bg-2" style="background-color: #1a1a1a; color: #ffffff; font-family: Arial, sans-serif;">
	<div class="container">
	  <div class="row" style="display: flex; flex-wrap: wrap;">
		<!-- Company Info Section -->
		<div class="col-md-4" style="margin-bottom: 20px; flex: 1; min-width: 250px;">
		  <h5 style="font-weight: bold; border-bottom: 2px solid #ffffff; padding-bottom: 5px;">About Us</h5>
		  <p style="font-size: 14px; line-height: 1.8; margin-top: 10px;">XYZ Company is dedicated to providing top-notch services and products. We strive for excellence and customer satisfaction.</p>
		</div>
		
		<!-- Quick Links Section -->
		<div class="col-md-4" style="margin-bottom: 20px; flex: 1; min-width: 250px;">
		  <h5 style="font-weight: bold; border-bottom: 2px solid #ffffff; padding-bottom: 5px;">Quick Links</h5>
		  <ul style="list-style: none; padding: 0; margin-top: 10px;">
			<li style="margin-bottom: 8px;"><a href="#" style="text-decoration: none; color: #ffffff; font-size: 14px;">Home</a></li>
			<li style="margin-bottom: 8px;"><a href="#" style="text-decoration: none; color: #ffffff; font-size: 14px;">About Us</a></li>
			<li style="margin-bottom: 8px;"><a href="#" style="text-decoration: none; color: #ffffff; font-size: 14px;">Services</a></li>
			<li style="margin-bottom: 8px;"><a href="#" style="text-decoration: none; color: #ffffff; font-size: 14px;">Contact</a></li>
		  </ul>
		</div>
  
		<!-- Contact Section -->
		<div class="col-md-4" style="margin-bottom: 20px; flex: 1; min-width: 250px;">
		  <h5 style="font-weight: bold; border-bottom: 2px solid #ffffff; padding-bottom: 5px;">Contact Us</h5>
		  <p style="font-size: 14px; line-height: 1.8; margin-top: 10px;">
			<strong>Email:</strong> info@xyzcompany.com<br>
			<strong>Phone:</strong> +1 234 567 890<br>
			<strong>Address:</strong> 123 Business St., City, Country
		  </p>
		  <div style="margin-top: 10px;">
			<a href="#" style="text-decoration: none; color: #ffffff; margin-right: 15px; font-size: 18px;"><i class="fab fa-facebook"></i> Facebook</a>
			<a href="#" style="text-decoration: none; color: #ffffff; margin-right: 15px; font-size: 18px;"><i class="fab fa-twitter"></i> Twitter</a>
			<a href="#" style="text-decoration: none; color: #ffffff; font-size: 18px;"><i class="fab fa-instagram"></i> Instagram</a>
		  </div>
		</div>
	  </div>
  
	  <!-- Footer Bottom -->
	  <div class="text-center pt-3" style="border-top: 1px solid #ffffff; margin-top: 20px; padding-top: 15px;">
		<p class="fw-bold fs-6 mb-0">&copy; 2023 XYZ Company, All Rights Reserved</p>
	  </div>
	</div>
  </footer>
  
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script>
$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
});


//For submiting update/change profile pic form
$('#profilePicForm').submit(function(e){
	e.preventDefault();

	var formData = new FormData(this);

	$.ajax({
		url:'{{ route("account.updateProfilePic") }}',
		type:'post',
		data:formData,
		dataType:'json',
		contentType:false,
		processData:false,
		success: function(response) {
			if (response.status == false){
				var errors = response.errors;
				if (errors.image) {
					$("#image-error").html(errors.image)
				} 
			} else {
					window.location.href = '{{ url()->current() }}';
			}
		}
	});
});
</script>
@yield('customJs')
</body>
</html>