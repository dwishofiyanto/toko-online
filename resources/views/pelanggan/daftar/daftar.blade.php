@extends('layout.apppelanggan')
@section('titile','DAFTAR')
@section('content')
<div class="page-wrapper">
			<div class="page-content">
				<!--start breadcrumb-->
				<section class="py-3 border-bottom d-none d-md-flex">
					<div class="container">
						<div class="page-breadcrumb d-flex align-items-center">
							<h3 class="breadcrumb-title pe-3">Sign Up</h3>
							<div class="ms-auto">
								<nav aria-label="breadcrumb">
									<ol class="breadcrumb mb-0 p-0">
										<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i> Home</a>
										</li>
										<li class="breadcrumb-item"><a href="javascript:;">Authentication</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">Sign Up</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</section>
				<!--end breadcrumb-->
				<!--start shop cart-->
				<section class="py-0 py-lg-5">
					<div class="container">
						<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
							<div class="row row-cols-1 row-cols-lg-1 row-cols-xl-2">
								<div class="col mx-auto">
									<div class="card mb-0">
										<div class="card-body">
											<div class="border p-4 rounded">
												<div class="text-center">
													<h3 class="">Sign Up</h3>
													<p>Already have an account? <a href="/pelanggan/login">Sign in here</a>
													</p>
												</div>
												<div class="d-grid">
													<a class="btn my-4 shadow-sm btn-light" href="javascript:;"> <span class="d-flex justify-content-center align-items-center">
									  <img class="me-2" src="{{ asset('assets/images/icons/search.svg')}}" width="16" alt="Image Description">
									  <span>Sign Up with Google</span>
														</span>
													</a> <a href="javascript:;" class="btn btn-light"><i class="bx bxl-facebook"></i>Sign Up with Facebook</a>
												</div>
												<div class="login-separater text-center mb-4"> <span>OR SIGN UP WITH EMAIL</span>
													<hr/>
												</div>
												<div class="form-body">

                                                <form class="row g-3 form-kategori"  method="post" action="#" >
													
                                                <!-- <form class="row g-3" action="/api/auth/daftar_pelanggan" method="post"  accept-charset="UTF-8"> -->
    @csrf
														<!-- <div class="col-sm-6">
															<label for="inputFirstName" class="form-label">First Name</label>
															<input type="email" class="form-control" id="inputFirstName" placeholder="Jhon">
														</div>
														<div class="col-sm-6">
															<label for="inputLastName" class="form-label">Last Name</label>
															<input type="email" class="form-control" id="inputLastName" placeholder="Deo">
														</div>-->
														<div class="col-12">
															<label for="inputEmailAddress" class="form-label">Nama</label>
															<input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan">
															<span class="text-danger error-text nama_pelanggan_error"></span>
														</div> 
                                                        <div class="col-12">
															<label for="inputEmailAddress" class="form-label">Email Address</label>
															<input type="email" class="form-control" name="email" id="email" placeholder="example@user.com">
															<span class="text-danger error-text email_error"></span>
														</div>
														<div class="col-12">
															<label for="inputChoosePassword" class="form-label">Password</label>
															<div class="input-group" id="show_hide_password">
																<input type="password" class="form-control border-end-0" name="password" id="password" value="12345678" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
																<span class="text-danger error-text password_error"></span>
															</div>
														</div>
														<!-- <div class="col-12">
															<label for="inputSelectCountry" class="form-label">Country</label>
															<select class="form-select" id="inputSelectCountry" aria-label="Default select example">
																<option selected>India</option>
																<option value="1">United Kingdom</option>
																<option value="2">America</option>
																<option value="3">Dubai</option>
															</select>
														</div> -->
														<div class="col-12">
															<div class="form-check form-switch">
																<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
																<label class="form-check-label" for="flexSwitchCheckChecked">I read and agree to Terms & Conditions</label>
															</div>
														</div>
														<div class="col-12">
															<div class="d-grid">
															
																<button id="tambah" class="btn btn-light"><i class='bx bx-user'></i>Sign up</button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end row-->
						</div>
					</div>
				</section>
				<!--end shop cart-->
			</div>
		</div>
@endsection

@push('js')
<script>
//     function setCookie(cname, cvalue, exdays) {
//   const d = new Date();
//   d.setTime(d.getTime() + (exdays*24*60*60*1000));
//   let expires = "expires="+ d.toUTCString();
//   document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
// }

// $(document).on("click","#tambah",function() {
	

  $('.form-kategori').submit(function(e)
        {
            e.preventDefault();
          
            // const token = localStorage.getItem('token');
            const frmdata = new FormData(this);
          
            $.ajax({
                url :'/api/auth/daftar_pelanggan',
                type : 'POST',
                data : frmdata,
                cache : false,
                contentType : false,
                processData : false,
               
                beforeSend: function()
          {
            $(document).find('span.error-text').text('');
          },
          success : function(data)
          {
			
            if(data.status == 0)
            {
              $.each(data.error, function(prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    });
         
            }
            else
            {
              alert(data.msg);
              window.location.href = '/pelanggan/login';
            }
          }
          });
         
        });


// });
    
   
    
       
</script>
@endpush