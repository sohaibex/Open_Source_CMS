<?php include '../../layout/header.php' ?>
<div class="account-pages my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-md-12 p-5  mx-auto">
                                <div class="mx-auto mb-3">
                                    <a href="/">
                                        <h3 class="d-inline align-middle ml-1 text-logo">CMS</h3>
                                    </a>
                                </div>

                                <h6 class="h5 mb-0 mt-4">Create your account</h6>
                                <br>

                                <form method="POST" action="" class="authentication-form">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">First Name</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                   <i class="fas fa-user"></i>
                                                </span>
                                                        </div>
                                                        <input type="text"
                                                               name="FirstName"
                                                               class="form-control "
                                                               id="FirstName" placeholder="Enter Your First Name "/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-control-label">Last Name</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                   <i class="fas fa-user"></i>
                                                </span>
                                                        </div>
                                                        <input type="text"
                                                               name="lastname"
                                                               class="form-control "
                                                               id="lastname" placeholder="Enter Your Last Name "/>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label class="form-control-label">Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                     <i class="fas fa-lock"></i>
                                                </span>
                                                        </div>
                                                        <input type="password"
                                                               name="password"
                                                               class="form-control"
                                                               id="password" placeholder="Enter your password"/>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Email Address</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                 <i class="fas fa-envelope"></i>
                                                </span>
                                                        </div>
                                                        <input type="email"
                                                               name="email"
                                                               class="form-control"
                                                               id="email" placeholder="Your Email"/>


                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-control-label">UserName</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                 <i class="fas fa-user"></i>
                                                </span>
                                                        </div>
                                                        <input type="text"
                                                               name="username"
                                                               class="form-control"
                                                               id="username" placeholder="Your Email"/>


                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label class="form-control-label">Re-Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                     <i class="fas fa-lock"></i>
                                                </span>
                                                        </div>
                                                        <input type="password"
                                                               name="confirm_password"
                                                               class="form-control "
                                                               id="confirm_password" placeholder="Confirm your password"/>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                    <div class="form-group mb-0 text-center d-flex justify-content-center mt-2">
                                        <button class="btn btn-primary btn-block d" style="width: 50%" type="submit">Sign Up</button>
                                    </div>
                                </form>
                            </div>



                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Already have account? <a href="/Open_Source_CMS/views/auth/login.php"
                                                                       class="text-primary font-weight-bold ml-1">Login</a>
                        </p>
                    </div>
                </div>


            </div>
        </div>

    </div>

</div>
