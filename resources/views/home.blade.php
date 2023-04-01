@extends('layouts.applanding')
@section('content')
      <!-- Masthead-->
      <header class="masthead bg-primary text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            <!-- Masthead Avatar Image-->
            <img class="masthead-avatar mb-5" src="{{asset('assets/img/logo.png')}}" alt="..." />
            <!-- Masthead Heading-->
            <h1 class="masthead-heading text-uppercase mb-0">Kelurahan Mojoroto</h1>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="masthead-subheading font-weight-light mb-0">KECAMATAN MOJOROTO KOTA KEDIRI</p>
            <p>JL. MOJOROTO GG IV TIMUR NO.43 - KODEPOS 64112</p>
        </div>
    </header>
    <!-- homelio Section-->
    <section class="page-section home" id="home">
        <div class="container">
            <!-- home Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">home</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- home Grid Items-->
            <!-- <div class="row justify-content-center"> -->
                <!-- Carousel -->
            <div id="demo" class="carousel slide" data-bs-ride="carousel">

                <!-- Indicators/dots -->
                <div class="carousel-indicators">
                <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                </div>

                <!-- The slideshow/carousel -->
                <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset ('assets/img/struktur.jpg')}}"alt="Struktur Organisasi" class="d-block" style="width:100%">
                    <div class="carousel-caption">
                    <h3>Struktur Organisasi</h3>
                    <p>Struktur organisasi kelurahan mojoroto</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{asset('assets/img/449592448.jpg')}}" alt="Tes Urine" class="d-block" style="width:100%">
                    <div class="carousel-caption">
                    <h3>Tes Urine</h3>
                    <p>Deklarasi Bersinar Menjadi Langkah Awal Kelurahan Mojoroto Menuju Bersih tes urine</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{asset('assets/img/bansos.jpg')}}" alt="Bansos" class="d-block" style="width:100%">
                    <div class="carousel-caption">
                    <h3>Bansos</h3>
                    <p>912 warga kelurahan mojoroto teruna bantuan sosial</p>
                    </div>
                </div>
                </div>

                <!-- Left and right controls/icons -->
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                </button>
            </div>
                <!-- home Item 1-->
                <!-- <div class="col-md-6 col-lg-4 mb-5">
                    <div class="home-item mx-auto" data-bs-toggle="modal" data-bs-target="#homeModal1">
                        <div class="home-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="home-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/home/cabin.png" alt="..." />
                    </div>
                </div> -->
                <!-- home Item 2-->
                <!-- <div class="col-md-6 col-lg-4 mb-5">
                    <div class="home-item mx-auto" data-bs-toggle="modal" data-bs-target="#homeModal2">
                        <div class="home-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="home-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/home/cake.png" alt="..." />
                    </div>
                </div> -->
                <!-- home Item 3-->
                <!-- <div class="col-md-6 col-lg-4 mb-5">
                    <div class="home-item mx-auto" data-bs-toggle="modal" data-bs-target="#homeModal3">
                        <div class="home-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="home-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/home/circus.png" alt="..." />
                    </div>
                </div> -->
                <!-- home Item 4-->
                <!-- <div class="col-md-6 col-lg-4 mb-5 mb-lg-0">
                    <div class="home-item mx-auto" data-bs-toggle="modal" data-bs-target="#homeModal4">
                        <div class="home-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="home-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/home/game.png" alt="..." />
                    </div>
                </div> -->
                <!-- home Item 5-->
                <!-- <div class="col-md-6 col-lg-4 mb-5 mb-md-0">
                    <div class="home-item mx-auto" data-bs-toggle="modal" data-bs-target="#homeModal5">
                        <div class="home-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="home-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/home/safe.png" alt="..." />
                    </div>
                </div> -->
                <!-- home Item 6-->
                <!-- <div class="col-md-6 col-lg-4">
                    <div class="home-item mx-auto" data-bs-toggle="modal" data-bs-target="#homeModal6">
                        <div class="home-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="home-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/home/submarine.png" alt="..." />
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    <!-- About Section-->
    <section class="page-section bg-primary text-white mb-0" id="about">
        <div class="container">
            <!-- About Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-white">Visi Misi</h2>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- About Section Content-->
            <div class="row">
                <div class="col-lg-4 ms-auto"><p class="lead">VISI</p>
                <p>"Mojoroto SIAP"</p>
                <p>(Sehat, inovatif, Agamis dan Peduli)</p>
                <p>"PENINGKATAN KUALITAS PELAYANAN MASYARAKAT SECARA PROFESIONAL, EFEKTIF DAN AKUTANBEL DEMI TERWUJUDNYA MASYARAKAT MOJOROTO YANG SEJAHTERA, BERKEADILAN, BERDAYA SAING DAN DAMAI SEJAHTERA"</p>
            </div>
                <div class="col-lg-4 me-auto"><p class="lead">MISI</p>
                <p>Misi dan Program Kelurahan Mojoroto</p>
                <p>    Misi 1 :</p>
                <p>    MEWUJUDKAN PEMERINTAHAN YANG PROFESIONAL, BERSIH, TRANSPARAN, AKUNTABEL DAN EFEKTIF;</p>
                <p>    Misi 2 :</p>
                <p>    PENINGKATAN SUMBER DAYA APARATUR KELURAHAN DAN PEMENUHAN SARANA PRASARANA PENUNJANG PELAYANAN DAN PENDIDIKAN;</p>
                <p>    Misi 3 :</p>
                <p>    PENINGKATAN PARTISIPASI DAN PENGUATAN LKK (LEMBAGA KEMASYARAKATAN KELURAHAN) SERTA PERAN AKTIF MASYARAKAT DALAM PELAKSANAAN KEGIATAN KELURAHAN, PEMBANGUNAN WILAYAH SERTA PENYELENGGARAAN KETENTRAMAN DAN KETERTIBAN UMUM.</p>
                </div>
            </div>
            <!-- About Section Button-->
            <!-- <div class="text-center mt-4">
                <a class="btn btn-xl btn-outline-light" href="https://startbootstrap.com/theme/freelancer/">
                    <i class="fas fa-download me-2"></i>
                    Free Download!
                </a>
            </div> -->
        </div>
    </section>
    <!-- Contact Section-->
    <!-- <section class="page-section" id="contact">
        <div class="container"> -->
            <!-- Contact Section Heading-->
            <!-- <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Formulir Komentar</h2> -->
            <!-- Icon Divider-->
            <!-- <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div> -->
            <!-- Contact Section Form-->
            <!-- <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7"> -->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * SB Forms Contact Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- This form is pre-integrated with SB Forms.-->
                    <!-- To make this form functional, sign up at-->
                    <!-- https://startbootstrap.com/solution/contact-forms-->
                    <!-- to get an API token!-->
                    <!-- <form id="contactForm" data-sb-form-api-token="API_TOKEN"> -->
                        <!-- Name input-->
                        <!-- <div class="form-floating mb-3"> -->
                            <!-- <input class="form-control" id="name" type="text" placeholder="Enter your name..." data-sb-validations="required" /> -->
                            <!-- <label for="name">Nama</label> -->
                            <!-- <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div> -->
                        <!-- </div> -->
                        <!-- Email address input-->
                        <!-- <div class="form-floating mb-3"> -->
                            <!-- <input class="form-control" id="phone" type="tel" placeholder="(123) 456-7890" data-sb-validations="required,email" /> -->
                            <!-- <label for="email">No. HP</label> -->
                            <!-- <div class="invalid-feedback" data-sb-feedback="email:required">phone number is required.</div> -->
                            <!-- <div class="invalid-feedback" data-sb-feedback="email:email">phone number is not valid.</div> -->
                        <!-- </div> -->
                        <!-- Phone number input-->
                        <!-- <div class="form-floating mb-3">
                            <input class="form-control" id="email" type="email" placeholder="name@example.com" data-sb-validations="required" />
                            <label for="phone">Alamat Email</label>
                            <div class="invalid-feedback" data-sb-feedback="phone:required">email is required.</div>
                        </div> -->
                        <!-- Message input-->
                        <!-- <div class="form-floating mb-3">
                            <textarea class="form-control" id="message" type="text" placeholder="Enter your message here..." style="height: 10rem" data-sb-validations="required"></textarea>
                            <label for="message">Komentar</label>
                            <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                        </div> -->
                        <!-- Submit success message-->
                        <!---->
                        <!-- This is what your users will see when the form-->
                        <!-- has successfully submitted-->
                        <!-- <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Form submission successful!</div>
                                To activate this form, sign up at
                                <br />
                                <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                            </div>
                        </div> -->
                        <!-- Submit error message-->
                        <!---->
                        <!-- This is what your users will see when there is-->
                        <!-- an error submitting the form-->
                        <!-- <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div> -->
                        <!-- Submit Button-->
                        <!-- <button class="btn btn-primary btn-xl disabled" id="submitButton" type="submit">Send</button> -->
                    <!-- </form>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Footer-->

    </section>
@endsection
