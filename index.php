<?php
// Start the session
session_start();
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    
    <!--====== Title ======-->
    <title>DETS</title>
    
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/png">
        
    <!--====== Animate CSS ======-->
    <link rel="stylesheet" href="assets/css/animate.css">
        
    <!--====== Glide CSS ======-->
    <link rel="stylesheet" href="assets/css/tiny-slider.css">
        
    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="assets/css/LineIcons.2.0.css">
        
    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="assets/css/bootstrap-5.0.0-beta1.min.css">
    
    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="assets/css/default.css">
    
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
  /* Animation for the images */
  .animated-img {
    transition: transform 0.3s ease-in-out;
  }
  .animated-img:hover {
    transform: scale(1.1);
  }
</style>
    
</head>

<body>
    <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

    <!--====== PRELOADER PART START ======-->

    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== PRELOADER PART ENDS ======-->

    <!--====== HEADER PART START ======-->

    <section id="home" class="header_area">
        <div id="header_navbar" class="header_navbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="demo.php">
                                <img id="logo" src="assets/images/image_2024_03_20T05_11_02_796Z_1-removebg-preview.png" alt="Logo">
                            </a>
                            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class="page-scroll active" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#services">Features</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#pricing">Pricing</a>
                                    </li>
                                   
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#contact">Contact</a>
                                    </li>
                                    <li class="nav-item">
                                        <?php
                                        // Check if the user's email is set in the session
                                        if (isset($_SESSION['email'])) {
                                            // User is logged in, display Logout option
                                            echo '<a href="logout.php">Logout</a>';
                                        } else {
                                            // User is not logged in, display Login option
                                            echo '<a href="Login.php">Login</a>';
                                        }
                                        ?>
                                    </li>

                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav> <!-- navbar -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- header navbar -->

        <div class="header_hero">
            <div class="single_hero bg_cover d-flex align-items-center" style="background-image: url(assets/images/accessories-doing-business-office-table.jpg)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10">
                            <div class="hero_content text-center">
                            <h2 class="hero_title wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">Welcome To Daily <br>Expenses Tracker!</h2>

<p class="wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.5s">Welcome to the Daily Expenses Tracker,<br class="d-none d-xl-block">your go-to solution for managing and optimizing your daily spending effortlessly.</p>
<a href="SingUp.php" class="main-btn wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.8s">SingUp</a>

                            </div> <!-- hero content -->
                        </div>
                    </div> <!-- row -->
                </div> <!-- container -->
            </div> <!-- single hero -->
        </div> <!-- header hero -->
    </section>

    <!--====== HEADER PART ENDS ======-->
    
    <!--====== FEATURES PART START ======-->

    <section id="features" class="features_area pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                <div class="section_title text-center pb-25">
    <h4 class="title wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">Why Choose Us</h4>
    <p class="wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">Why settle for less? Choose us for the ultimate Daily Expenses Tracker that not only keeps tabs on your spending but also assists you in making informed decisions, setting goals, and achieving financial success.</p>
</div> <!-- section title -->

                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-7">
                <div class="single_features text-center mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">
    <i class="lni lni-invest-monitor"></i>
    <h4 class="features_title">Expenses Management</a></h4>
    <p>Simplify your financial life with our Expenses Management feature, ensuring clarity and control over your spending and make step towards savings.</p>
</div> <!-- single features -->

                </div>
                <div class="col-lg-4 col-md-7">
                <div class="single_features text-center mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">
    <i class="lni lni-wallet"></i>
    <h4 class="features_title">Income Management</a></h4>
    <p>Optimize your financial success with our Income Management tool, efficiently and seamlessly tracking and maximizing your earnings.</p>
</div> <!-- single features -->

                </div>
                <div class="col-lg-4 col-md-7">
                <div class="single_features text-center mt-60 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">
    <i class="lni lni-target-revenue"></i>
    <h4 class="features_title">Manage Budget</h4>
    <p>Effortlessly control your spending with our concise and user-friendly budget management feature.</p>
</div> <!-- single features -->

                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== FEATURES PART ENDS ======-->
    
    <!--====== ABOUT PART START ======-->

    <section id="about" class="pt-130">
        <div class="about_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about_content pt-120 pb-130">
                            <div class="section_title pb">
                                <h4 class="title wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">About Our Web<br> Application</h4>
                                <p class="wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">Daily Expenses Tracker System that revolutionizes financial management.
                                     With a robust suite of features including expenses management, income tracking, budget allocation, report generation, category customization,
                                      and insightful charts highlighting recurring expenses, our platform is designed to empower users in their journey towards financial well-being.</p>
                                <p class="wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.6s">We are committed to providing a seamless and intuitive experience, allowing you to effortlessly monitor, analyze, and optimize your finances.
                                     Our dedication to innovation extends to personalized notifications, ensuring you stay informed and in control.
                                      Welcome to a platform where financial empowerment meets technological excellence, delivering a holistic solution for individuals seeking a smarter, more efficient approach to managing their money</p>
                            </div> <!-- section title -->
                            
                        </div> <!-- about content -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
            
            <div class="about_image bg_cover wow fadeInLeft" data-wow-duration="1.3s" data-wow-delay="0.2s"
                style="background-image: url(assets/images/close-up-information-sign-white-wall_1048944-1693995.jpg)">
                <div class="image_content">
                    <h4 class="experience"><span>Easy</span>Expenses Management!</h4>
                </div>
            </div> <!-- about image -->
        </div>
    </section>

    <!--====== ABOUT PART ENDS ======-->
    
    <!--====== FEATURES PART START ======-->

    <section id="services" class="features_area pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center pb-25">
                        <h4 class="title wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">Our Features</h4>
                        <p class="wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">Effortlessly manage your daily finances with our comprehensive expenses tracker website, 
                            offering a seamless experience with features such as real-time notifications, intuitive report generation, and efficient management of both expenses and income.</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single_features text-center mt-60 wow fadeInUp" data-wow-duration="1.3s"
                        data-wow-delay="0.2s">
                        <i class="lni lni-credit-cards"></i>
                        <h4 class="features_title">Manage Expenses</h4>
                        <p>Take control of your budget with our intuitive expense management feature.</p>
                    </div> <!-- single features -->
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_features text-center mt-60 wow fadeInUp" data-wow-duration="1.3s"
                        data-wow-delay="0.3s">
                        <i class="lni lni-rupee"></i>
                        <h4 class="features_title">Manage Income</h4>
                        <p>Optimize your income and managing your income streams with our effective income management feature.</p>
                    </div> <!-- single features -->
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_features text-center mt-60 wow fadeInUp" data-wow-duration="1.3s"
                        data-wow-delay="0.4s">
                        <i class="lni lni-target-revenue"></i>
                        <h4 class="features_title">Manage Budget</h4>
                        <p>Effortlessly control your spending with our concise and user-friendly budget management feature.</p>
                    </div> <!-- single features -->
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_features text-center mt-60 wow fadeInUp" data-wow-duration="1.3s"
                        data-wow-delay="0.2s">
                        <i class="lni lni-popup"></i>
                        <h4 class="features_title">Notifications</h4>
                        <p> Our notification frature,ensuring you never miss a beat in your daily expense.</p>
                    </div> <!-- single features -->
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_features text-center mt-60 wow fadeInUp" data-wow-duration="1.3s"
                        data-wow-delay="0.3s">
                        <i class="lni lni-printer"></i>
                        <h4 class="features_title">Report Generation</h4>
                        <p>report generation feature,providing a comprehensive overview of your financial activities.</p>
                    </div> <!-- single features -->
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_features text-center mt-60 wow fadeInUp" data-wow-duration="1.3s"
                        data-wow-delay="0.4s">
                        <i class="lni lni-protection"></i>
                        <h4 class="features_title">System Security</h4>
                        <p>Experience peace of mind with our strong security protocols, keeping your financial data safe and secure.</p>
                    </div> <!-- single features -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== FEATURES PART ENDS ======-->
    
    
    
    <!--====== PRICING PART START ======-->

    <section id="pricing" class="pricing_area pt-120 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center pb-25">
                        <h4 class="title wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">Pricing Plans</h4>
                        <p class="wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">Unlock a tailored financial experience with our versatile packages – 
                            Choose between our free option for essential features or elevate your financial journey with the premium Plus package,
                             offering exclusive benefits and enhanced functionalities.</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-8 col-sm-10">
                <div class="single_pricing text-center mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">
    <h4 class="pricing_title">Basic Plane</h4>
    <span class="price">Free</span>
    <ul class="pricing_list">
        <li>Here, Free Basic Plane</li>
        <li>Get started for free expense manage</li>
        <li>Access basic expense tools</li>
        <li>Start your journey with our Basic Plan today</li>
    </ul>
    <a href="pricing.php" class="mian-btn">Know More</a>
</div> <!-- single pricing -->

                </div>
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single_pricing text-center mt-30 active wow fadeInUp" data-wow-duration="1.3s"
                        data-wow-delay="0.3s">
                        <h4 class="pricing_title">Premium Plane</h4>
                        <span class="price">₹100</span>
                        <ul class="pricing_list">
                            <li>Upgrade to our Premium Plan</li>
                            <li>Gain access to exclusive tools</li>
                            <li>Unlock premium features</li>
                            <li>Elevate your financial management</li>
                        </ul>
                        <a href="pricing.php" class="mian-btn">know more</a>
                    </div> <!-- single pricing -->
                </div>
               
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== PRICING PART ENDS ======-->
    
    
    
    
    
    <!--====== CONTACT PART START ======-->

    <section id="contact" class="contact_area bg_cover pt-120 pb-130"
        style="background-image: url(assets/images/young-asian-woman-worried-need-help-stress-home-accounting-debt-bills-bank-papers-expenses-payments-feeling-desperate-bad-financial-situation-top-view_164138-726.jpg)">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                <div class="section_title section_title_2 text-center pb-25">
    <h4 class="title wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">Contact Us</h4>
    <p class="wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">Have questions or need assistance? Reach out to us easily through our Contact Us page – we're here to help!</p>
</div>

                </div>
            </div>
            <form id="contact-form" action="send_email1.php" method="post" class="wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="single_form">
                            <input type="text" placeholder="Name" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single_form">
                            <input type="email" placeholder="Email" name="email" id="email" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single_form">
                            <input type="text" placeholder="Phone Number" name="number" id="number" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single_form">
                            <input type="text" placeholder="Subject" name="subject" id="subject" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single_form">
                            <textarea placeholder="Message" name="message" id="message" required></textarea>
                        </div>
                    </div>
                    <p class="form-message"></p>
                    <div class="col-lg-12">
                        <div class="single_form text-center">
                            <button class="main-btn" type="submit">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>


    <!--====== CONTACT PART ENDS ======-->
    
    <!--====== FOOTER PART START ======-->

    <footer id="footer" class="footer_area">
        <div class="container">
            <div class="footer_wrapper text-center d-lg-flex align-items-center justify-content-between">
                <p class="credit">Designed and Developed by <a href="https://uideck.com" rel="nofollow">Priya & Sakshi</a></p>
                <div class="footer_social pt-15">
                    <ul>
                        <li><a href="#0"><i class="lni lni-facebook-original"></i></a></li>
                        <li><a href="#0"><i class="lni lni-twitter-original"></i></a></li>
                        <li><a href="#0"><i class="lni lni-instagram-original"></i></a></li>
                        <li><a href="#0"><i class="lni lni-linkedin-original"></i></a></li>
                    </ul>
                </div> <!-- footer social -->
            </div> <!-- footer wrapper -->
        </div> <!-- container -->
    </footer>

    <!--====== FOOTER PART ENDS ======-->
    
   
    <!-- ... (your existing JavaScript and HTML code) ... -->
    
    <!--====== BACK TOP TOP PART START ======-->

    <a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>

    <!--====== BACK TOP TOP PART ENDS ======-->

    
    <!--====== Bootstrap js ======-->
    <script src="assets/js/bootstrap.bundle-5.0.0-beta1.min.js"></script>
    
    <!--====== glide js ======-->
    <script src="assets/js/tiny-slider.js"></script>
    
    <!--====== wow js ======-->
    <script src="assets/js/wow.min.js"></script>
    
    <!--====== Main js ======-->
    <script src="assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

    <script>
    new WOW().init();
</script>
    
</body>

</html>