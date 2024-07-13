<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Oinia</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('qrcode/css/bootstrap.min.css') }}">

    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('qrcode/css/style.css') }}">
    <!-- Responsive-->
    <link rel="stylesheet" href=" {{ asset('qrcode/css/responsive.css') }}">
    <!-- fevicon -->
    <link rel="icon" href="{{ asset('qrcode/images/fevicon.png') }} " type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{ asset('qrcode/css/jquery.mCustomScrollbar.min.css') }}">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
</head>

<body>
    <!--header section start -->
    <div class="header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="logo"><a href="index.html"><img src="{{ asset('qrcode/images/logo.png') }}"></a></div>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('qrcode/languges.html') }}">Languges</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('qrcode/services.html') }}">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('qrcode/events.html') }}">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('qrcode/contact.html') }}">Contact Us</a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <div class="login_text"><a href="#">Login</a></div>
                        <div class="search_icon"><a href="#"><img
                                    src="{{ asset('qrcode/images/search-icon.png') }}"></a></div>
                    </form>
                </div>
            </nav>
        </div>
        <!--banner section start -->
        <div class="banner_section layout_padding">
            <div class="container">
                <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <p class="banner_text">Language School</p>
                            <h1 class="banner_taital">Any <br>language you wants</h1>
                            <div class="read_bt"><a href="#">Read More</a></div>
                        </div>
                        <div class="carousel-item">
                            <p class="banner_text">Language School</p>
                            <h1 class="banner_taital">Any <br>language you wants</h1>
                            <div class="read_bt"><a href="#">Read More</a></div>
                        </div>
                        <div class="carousel-item">
                            <p class="banner_text">Language School</p>
                            <h1 class="banner_taital">Any <br>language you wants</h1>
                            <div class="read_bt"><a href="#">Read More</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--banner section end -->
    </div>
    <div class="container">
        <div class="play_icon"><a href="#"><img src="{{ asset('qrcode/images/play-icon.png') }}"></a></div>
    </div>
    <!--header section end -->
    <!--language  section start -->
    <div class="language_section layout_padding">
        <div class="container">
            <h1 class="language_taital">Start Now</h1>
            <h1 class="language_taital_1">Learn a new language </h1>
            <div class="language_section_2 layout_padding">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="box_main">
                            <div class="icon_1"><img src="{{ asset('qrcode/images/icon-1.png') }}"></div>
                            <h6 class="heavy_text">An Easy <br>Study Approach</h6>
                        </div>
                        <div class="readmore_bt"><a href="#">Read More</a></div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="box_main active">
                            <div class="icon_1"><img src="{{ asset('qrcode/images/icon-2.png') }}"></div>
                            <h6 class="heavy_text">Free <br>Teaching Materials</h6>
                        </div>
                        <div class="readmore_bt active"><a href="#">Read More</a></div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="box_main">
                            <div class="icon_1"><img src="{{ asset('qrcode/images/icon-3.png') }}"></div>
                            <h6 class="heavy_text">A Free <br>Mobile Application</h6>
                        </div>
                        <div class="readmore_bt"><a href="#">Read More</a></div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="box_main">
                            <div class="icon_1"><img src="{{ asset('qrcode/images/icon-4.png') }}"></div>
                            <h6 class="heavy_text">An <br>Accredited School</h6>
                        </div>
                        <div class="readmore_bt"><a href="#">Read More</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--language  section end -->
    <!--services section start -->
    <div class="services_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="language_taital">High Quality</h1>
                    <h1 class="language_taital_1">Let's Start Your Education!</h1>
                    <p class="services_text">It is a long established fact that a reader will be distracted by the
                        readable </p>
                    <div class="appoinment_bt"><a href="#">Make Appoinment</a></div>
                </div>
                <div class="col-md-6">
                    <div class="image_1"><img src="{{ asset('qrcode/images/img-1.png') }}"></div>
                    <div class="image_2"><img src="{{ asset('qrcode/images/img-2.png') }}"></div>
                </div>
            </div>
        </div>
    </div>
    <!--services section end -->
    <!--gallery section start -->
    <div class="gallery_section layout_padding">
        <div class="container">
            <h1 class="gallery_taital">Our All Language Videos</h1>
            <p class="gallery_text">It is a long established fact that a reader will be distracted by the readable </p>
            <div class="gallery_section_2 layout_padding">
                <div id="main_slider" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="image_3">
                                        <div class="play_icon_2"><a href="#"><img
                                                    src="{{ asset('qrcode/images/play-icon-2.png') }}"></a>
                                        </div>
                                        <h6 class="language_text">Language chinese</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="image_4">
                                        <div class="play_icon_2"><a href="#"><img
                                                    src="{{ asset('qrcode/images/play-icon-2.png') }}"></a>
                                        </div>
                                        <h6 class="language_text">Language chinese</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="image_5">
                                        <div class="play_icon_2"><a href="#"><img
                                                    src="{{ asset('qrcode/images/play-icon-2.png') }}"></a>
                                        </div>
                                        <h6 class="language_text">Language chinese</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="image_3">
                                        <div class="play_icon_2"><a href="#"><img
                                                    src="{{ asset('qrcode/images/play-icon-2.png') }}"></a>
                                        </div>
                                        <h6 class="language_text">Language chinese</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="image_4">
                                        <div class="play_icon_2"><a href="#"><img
                                                    src="{{ asset('qrcode/images/play-icon-2.png') }}"></a>
                                        </div>
                                        <h6 class="language_text">Language chinese</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="image_5">
                                        <div class="play_icon_2"><a href="#"><img
                                                    src="{{ asset('qrcode/images/play-icon-2.png') }}"></a>
                                        </div>
                                        <h6 class="language_text">Language chinese</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="image_3">
                                        <div class="play_icon_2"><a href="#"><img
                                                    src="{{ asset('qrcode/images/play-icon-2.png') }}"></a>
                                        </div>
                                        <h6 class="language_text">Language chinese</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="image_4">
                                        <div class="play_icon_2"><a href="#"><img
                                                    src="{{ asset('qrcode/images/play-icon-2.png') }}"></a>
                                        </div>
                                        <h6 class="language_text">Language chinese</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="image_5">
                                        <div class="play_icon_2"><a href="#"><img
                                                    src="{{ asset('qrcode/images/play-icon-2.png') }}"></a>
                                        </div>
                                        <h6 class="language_text">Language chinese</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--gallery section end -->
    <!--about section start -->
    <div class="about_section layout_padding">
        <div class="container">
            <h1 class="about_taital">About</h1>
            <div class="about_section_2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="image_6">
                            <div class="play_icon_3"><a href="#"><img
                                        src="{{ asset('qrcode/images/play-icon-2.png') }}"></a></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h1 class="about_taital_1">Best Tranning Language School</h1>
                        <p class="about_text">It is a long established fact that a reader will be distracted by the
                            readable content of a pageIt is a long established fact that a reader will be distracted by
                            the readable content of a page</p>
                        <div class="appoinment_bt"><a href="#">Read More</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--about section end -->
    <!--courses section start -->
    <div class="courses_section layout_padding">
        <div class="container">
            <h1 class="courses_taital">Featured Courses</h1>
            <p class="courses_text">It is a long established fact that a reader will be distracted by the readable c
            </p>
            <div class="courses_section_2">
                <div class="flag_main">
                    <div class="flag_text"><img src="{{ asset('qrcode/images/flag-1.png') }}"><span
                            class="padding_left_15">Chinese</span>
                    </div>
                    <hr class="border_bg">
                    <h6 class="learn_text active">Language start learn</h6>
                </div>
                <div class="flag_main">
                    <div class="flag_text"><img src="{{ asset('qrcode/images/flag-2.png') }}"><span
                            class="padding_left_15">English</span>
                    </div>
                    <hr class="border_bg">
                    <h6 class="learn_text">Language start learn</h6>
                </div>
                <div class="flag_main">
                    <div class="flag_text"><img src="{{ asset('qrcode/images/flag-3.png') }}"><span
                            class="padding_left_15">French</span>
                    </div>
                    <hr class="border_bg">
                    <h6 class="learn_text">Language start learn</h6>
                </div>
                <div class="flag_main">
                    <div class="flag_text"><img src="{{ asset('qrcode/images/flag-4.png') }}"><span
                            class="padding_left_15">German</span>
                    </div>
                    <hr class="border_bg">
                    <h6 class="learn_text">Language start learn</h6>
                </div>
                <div class="flag_main">
                    <div class="flag_text"><img src="{{ asset('qrcode/images/flag-5.png') }}"><span
                            class="padding_left_15">Japanese</span>
                    </div>
                    <hr class="border_bg">
                    <h6 class="learn_text">Language start learn</h6>
                </div>
                <div class="flag_main">
                    <div class="flag_text"><img src="{{ asset('qrcode/images/flag-6.png') }}"><span
                            class="padding_left_15">Spanish</span>
                    </div>
                    <hr class="border_bg">
                    <h6 class="learn_text">Language start learn</h6>
                </div>
            </div>
        </div>
    </div>
    <!--courses section end -->
    <!--events section start -->
    <div class="events_section layout_padding">
        <div class="container">
            <h1 class="events_taital">Events</h1>
            <p class="events_text">It is a long established fact that a reader will be distracted by the readable c</p>
            <div class="events_section_2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="images_main">
                            <img src="images/img-7.png" class="image_7">
                        </div>
                        <p class="lorem_text">It is a long established fact that a reader will be distracted by the
                            readable content of a </p>
                        <div class="time_section">
                            <div class="live_text">Live event</div>
                            <div class="date_text">04 Nov 2023</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="images_main">
                            <img src="images/img-8.png" class="image_7">
                        </div>
                        <p class="lorem_text">It is a long established fact that a reader will be distracted by the
                            readable content of a </p>
                        <div class="time_section">
                            <div class="live_text">Live event</div>
                            <div class="date_text">04 Nov 2023</div>
                        </div>
                    </div>
                </div>
                <div class="read_bt"><a href="#">Read More</a></div>
            </div>
        </div>
    </div>
    <!--events section end -->
    <!--students section start -->
    <div class="students_section layout_padding">
        <div class="container">
            <h1 class="courses_taital">What Says Our Students</h1>
            <p class="courses_text">It is a long established fact that a reader will be distracted by the readable c
            </p>
            <div class="students_section_2 layout_padding">
                <div class="client_main">
                    <div class="client_left">
                        <div class="image_9"><img src="{{ asset('qrcode/images/img-9.png') }}"></div>
                    </div>
                    <div class="client_right">
                        <h1 class="name_text">Michal Mona</h1>
                        <p class="client_text">It is a long established fact that a reader will be distracted by the
                            readable cIt is a long established fact that a reader will be distracted by the readable c
                        </p>
                        <div class="quote_icon"><img src="{{ asset('qrcode/images/quote-icon.png') }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--students section end -->
    <!--newsletter section start -->
    <div class="container">
        <div class="newsletter_section layout_padding">
            <h1 class="newsletter_taital">Subscribe Our Newsletter</h1>
            <div class="mail_main">
                <input type="text" class="email_text" placeholder="Enter Your email " name="Enter Your email ">
                <div class="left_arrow"><a href="#"><img src="{{ asset('qrcode/images/left-arrow.png') }}"></a></div>
            </div>
        </div>
    </div>
    <!--newsletter section end -->
    <!--footer section start -->
    <div class="footer_section">
        <div class="container">
            <h1 class="touch_text">Get In Touch</h1>
            <div class="email_box">
                <div class="input_main">
                    <form action="/action_page.php">
                        <div class="form-group">
                            <input type="text" class="email-bt" placeholder="Name" name="Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="email-bt" placeholder="Phone" name="Phone">
                        </div>
                        <div class="form-group">
                            <input type="text" class="email-bt" placeholder="Email" name="Email">
                        </div>
                        <div class="form-group">
                            <textarea class="massage-bt" placeholder="Massage" rows="5" id="comment"
                                name="Massage"></textarea>
                        </div>
                    </form>
                    <div class="send_bt"><a href="#">SEND</a></div>
                </div>
            </div>
            <div class="call_main">
                <div class="call_text"><img src="{{ asset('qrcode/images/call-icon.png') }}"><span
                        class="padding_left_15">Call Now +01
                        123467890</span></div>
                <div class="call_text"><img src="{{ asset('qrcode/images/mail-icon.png') }}"><span
                        class="padding_left_15">demo@gmail.com</span></div>
            </div>
            <div class="social_icon">
                <ul>
                    <li><a href="#"><img src="{{ asset('qrcode/images/fb-icon.png') }}"></a></li>
                    <li><a href="#"><img src="{{ asset('qrcode/images/twitter-icon.png') }}"></a></li>
                    <li><a href="#"><img src="{{ asset('qrcode/images/linkedin-icon.png') }}"></a></li>
                    <li><a href="#"><img src="{{ asset('qrcode/images/images/instagram-icon.png') }}"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--footer section end -->
    <!--copyright section start -->
    <div class="copyright_section">
        <div class="container">
            <p class="copyright_text"> 2023 All Rights Reserved. Design by <a href="html.design">Free Html
                    Templates</a></p>
        </div>
    </div>
    <!--copyright section end -->
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <!-- sidebar -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <!-- javascript -->
    <script src="js/owl.carousel.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</body>

</html>