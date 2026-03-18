<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>बालगंगा ई लाइब्रेरी </title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">


    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Arsha
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Updated: Feb 22 2025 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    <style>
        .alert.fade {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }
    </style>


</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="#" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="assets/img/logo.png" alt="Logo">
                <h1 class="sitename">बालगंगा महाविद्यालय</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#portfolio">Portfolio</a></li>
                    <li><a href="#team">Team</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    {{-- <li><a href="blog.html">Blog</a></li> --}}
                    {{-- <li class="dropdown"><a href="#"><span>Dropdown</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Dropdown 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                        class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="#">Deep Dropdown 1</a></li>
                                    <li><a href="#">Deep Dropdown 2</a></li>
                                    <li><a href="#">Deep Dropdown 3</a></li>
                                    <li><a href="#">Deep Dropdown 4</a></li>
                                    <li><a href="#">Deep Dropdown 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Dropdown 2</a></li>
                            <li><a href="#">Dropdown 3</a></li>
                            <li><a href="#">Dropdown 4</a></li>
                        </ul>
                    </li> --}}
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="{{ route('login') }}">Login</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center"
                        data-aos="zoom-out">
                        <h1>बालगंगा ई-लाइब्रेरी</h1>
                        <p>Read Anywhere, Anytime – Your Library in the Cloud.</p>
                        <div class="d-flex">
                            <a href="#about" class="btn-get-started">Get Started</a>
                            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                                class="glightbox btn-watch-video d-flex align-items-center"><i
                                    class="bi bi-play-circle"></i><span>Watch Video</span></a>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                        <img src="assets/img/hero.jpg" class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- Clients Section -->
        {{-- <section id="clients" class="clients section light-background">

            <div class="container" data-aos="zoom-in">

                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 5,
                  "spaceBetween": 120
                },
                "1200": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide"><img src="assets/img/clients/client1.png" class="img-fluid"
                                alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client2.png" class="img-fluid"
                                alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client3.png" class="img-fluid"
                                alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client4.png" class="img-fluid"
                                alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client5.png" class="img-fluid"
                                alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client6.png" class="img-fluid"
                                alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clientsclient7.png" class="img-fluid"
                                alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client8.png" class="img-fluid"
                                alt=""></div>
                    </div>
                </div>

            </div>

        </section> --}}
        <!-- /Clients Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>About Us</h2>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            सामाजिक, आर्थिक एवं शैक्षणिक विकास हेतु बालगंगा महाविद्यालय की स्थापना क्षेत्रीय बुद्धिजीविओ
                            एवं समाजसेवियों द्वारा 5 अगस्त 1991 को सेंदुल गाँव में की गयी, जिसका उद्घाटन हेमवती नंदन
                            बहुगुणा गढ़वाल विश्वविद्यालय के तत्कालीन कुलपति प्रो एस पी नौटियाल जी के कर कमलों द्वारा हुआ।
                            बालगंगा महाविद्यालय की मातृ संस्था बालगंगा शिक्षा प्रसार समिति है जो विगत 6 दशकों से क्षेत्र
                            में शिक्षा के प्रचार - प्रसार में संलग्न है। संस्था की स्थापना प्रशिद्ध समाजसेवी एवं विद्वान
                            स्व डॉ वाचस्पति मैठाणी द्वारा की गयी। महाविद्यालय के उद्घाटन के पश्चात् महाविद्यालय में
                            स्नातक स्तर पर शिक्षण कार्य अनवरत रूप से चल रहा है एवं सैकड़ों छात्र - छात्राएं उच्च शिक्षा
                            सुविधा का लाभ ले रहे हैं।
                        </p>
                        {{-- <ul>
                            <li><i class="bi bi-check2-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Duis aute irure dolor in reprehenderit in
                                    voluptate velit.</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea
                                    commodo</span></li>
                        </ul> --}}
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <p>महाविद्यालय में सुसज्जित एवं सुविकसित पुस्तकालय एवं वाचनालय है। पुस्तकालय में सन्दर्भ ग्रंथो
                            के साथ प्रयाप्त पाठ्य पुस्तकें हैं। वर्तमान में पुस्तकालय में 19000 से अधिक पुस्तकें उपलब्ध
                            हैं। वाचनालय में आधा दर्जन से ज्यादा समाचार पत्रों के साथ विभिन्न प्रकार की प्रतियोगित
                            परीक्षाओं की पत्रिकाएं व जर्नल्स उपलब्ध हैं। इस पुस्तकालय एवं वाचनालय को केंद्रीय पुस्तकालय
                            के साथ-साथ सार्वजानिक पुस्तकालय का भी स्वरुप प्रदान किया जाय क्योकि किसी बह शिक्षण संसथान का
                            पुस्तकालय उस संस्था का प्राण होता है। </p>
                        <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                    </div>

                </div>

            </div>

        </section><!-- /About Section -->

        <!-- Why Us Section -->
        <section id="why-us" class="section why-us light-background" data-builder="section">

            <div class="container-fluid">

                <div class="row gy-4">

                    <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">

                        <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
                            <h3><span>Where Learning Never Stops – On Campus and Online.</span><strong>Empowering
                                    Education Through Accessible Library Services.</strong></h3>
                            <p>
                                We are dedicated to supporting academic excellence through a seamless blend of
                                traditional and digital resources. Our library provides students and faculty with access
                                to a wide range of physical books and cutting-edge e-resources—anytime, anywhere.
                                Whether you're on campus or learning remotely, our innovative platform ensures
                                uninterrupted access to the knowledge you need.
                            </p>
                        </div>

                        <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">

                            <div class="faq-item faq-active">

                                <h3><span>01</span>How does the library support student learning and research?</h3>
                                <div class="faq-content">
                                    <p>Our library is a hub of academic resources, offering students access to
                                        textbooks, reference materials, journals, and digital databases. Whether you're
                                        preparing for exams or conducting research, our resources are curated to support
                                        every stage of your academic journey.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3><span>02</span> What resources are available in the e-library?
                                </h3>
                                <div class="faq-content">
                                    <p>The e-library provides 24/7 access to e-books, academic journals, research
                                        papers, and multimedia learning tools. With user-friendly search features and
                                        remote access, students and faculty can explore a wealth of knowledge anytime,
                                        from anywhere.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3><span>03</span>How do students access and use the library services?</h3>
                                <div class="faq-content">
                                    <p>Students can explore resources through our web portal using their college
                                        credentials. Physical books can be borrowed from the on-campus library, while
                                        digital materials can be accessed online. Our support team is always available
                                        to assist with queries, research help, and technology use.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>

                    </div>

                    <div class="col-lg-5 order-1 order-lg-2 why-us-img">
                        <img src="assets/img/frontPage1.jpg" class="img-fluid" alt="" data-aos="zoom-in"
                            data-aos-delay="100">
                    </div>
                </div>

            </div>

        </section><!-- /Why Us Section -->

        <!-- Skills Section -->
        <section id="skills" class="skills section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row">

                    <div class="col-lg-6 d-flex align-items-center">
                        <img src="assets/img/frontPage2.jpg" class="img-fluid" alt="">
                    </div>

                    <div class="col-lg-6 pt-4 pt-lg-0 content">

                        <h3>Empowering Learning Through Seamless Access to Knowledge</h3>
                        <p class="fst-italic">
                            At our College Library, we blend traditional resources with modern digital tools to support
                            academic success and lifelong learning. With a commitment to accessibility, innovation, and
                            student support, we provide a rich environment for study, research, and discovery—on campus
                            and online.
                        </p>

                        <div class="skills-content skills-animation">

                            <div class="progress">
                                <span class="skill"><span>Physical Library Resources – Textbooks, Reference Materials,
                                        Journals</span> <i class="val">100%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div><!-- End Skills Item -->

                            <div class="progress">
                                <span class="skill"><span>E-Library Services – E-books, Online Journals,
                                        Databases</span> <i class="val">95%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="95"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div><!-- End Skills Item -->

                            <div class="progress">
                                <span class="skill"><span>Student Support & Research Assistance – Helpdesk, Workshops,
                                        Tutorials</span> <i class="val">75%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="75"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div><!-- End Skills Item -->

                            <div class="progress">
                                <span class="skill"><span>Reading Spaces & Facilities – Quiet Zones, Group Study,
                                        Wi-Fi Access</span> <i class="val">80%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="80"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div><!-- End Skills Item -->

                        </div>

                    </div>
                </div>

            </div>

        </section><!-- /Skills Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Library Services</h2>
                <p>Delivering accessible, technology-enhanced learning resources to support academic excellence—on
                    campus and beyond.</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative text-center">
                            <div class="icon"><i class="bi bi-collection-fill"></i></div>
                            <h4><a href="" class="stretched-link">Physical & Digital Resource Access</a></h4>
                            <p>From printed textbooks and reference materials to e-books and academic databases, we
                                offer a vast collection to meet diverse learning and research needs.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative text-center">
                            <div class="icon"><i class="bi bi-bluetooth"></i></i></div>
                            <h4><a href="" class="stretched-link">E-Library Platform & Remote Access</a></h4>
                            <p>Our digital library portal provides 24/7 access to a wide range of online resources,
                                allowing students and faculty to study, explore, and research from anywhere.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative text-center">
                            <div class="icon"><i class="bi bi-mortarboard-fill"></i></div>
                            <h4><a href="" class="stretched-link">Research Support & Academic Assistance</a>
                            </h4>
                            <p>Librarians and support staff offer personalized help with research strategies, citation
                                tools, information literacy, and more to enhance academic performance.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative text-center">
                            <div class="icon"><i class="bi bi-house-up-fill"></i></div>
                            <h4><a href="" class="stretched-link">Study Spaces & Learning Facilities</a></h4>
                            <p>Comfortable reading areas, group study rooms, and high-speed internet ensure an ideal
                                environment for focused study and collaboration.</p>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Work Process Section -->
        <section id="work-process" class="work-process section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Work Process</h2>
                <p>A thoughtful, student-centered approach designed to deliver accessible, effective, and modern library
                    services.
                </p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-5">

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="steps-item">
                            <div class="steps-image">
                                <img src="assets/img/steps/steps-1.webp" alt="Step 1" class="img-fluid"
                                    loading="lazy">
                            </div>
                            <div class="steps-content">
                                <div class="steps-number">01</div>
                                <h3>Needs Assessment &amp; Resource Planning</h3>
                                <p>We begin by understanding student, faculty, and curriculum needs to ensure the
                                    library offers relevant, up-to-date resources in both physical and digital formats.
                                </p>
                                <div class="steps-features">
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Curriculum Alignment</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Resource Gap Analysis</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Feedback from Faculty & Students</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Steps Item -->
                    </div>

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="steps-item">
                            <div class="steps-image">
                                <img src="assets/img/steps/steps-2.webp" alt="Step 2" class="img-fluid"
                                    loading="lazy">
                            </div>
                            <div class="steps-content">
                                <div class="steps-number">02</div>
                                <h3>Content Curation &amp; System Setup</h3>
                                <p>Our team curates diverse academic resources and integrates them into a user-friendly
                                    digital platform, ensuring smooth access and a rich learning experience.</p>
                                <div class="steps-features">
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Book & Journal Selection</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>E-Resource Integration</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Platform Configuration</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Steps Item -->
                    </div>

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="steps-item">
                            <div class="steps-image">
                                <img src="assets/img/steps/steps-3.webp" alt="Step 3" class="img-fluid"
                                    loading="lazy">
                            </div>
                            <div class="steps-content">
                                <div class="steps-number">03</div>
                                <h3> Delivery, Access &amp; Support</h3>
                                <p>We ensure seamless access to library services through well-maintained physical
                                    spaces, reliable digital platforms, and ongoing user support and training.</p>
                                <div class="steps-features">
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Online & On-Campus Access</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>User Training & Workshops</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Continuous Support & Feedback Loop</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Steps Item -->
                    </div>

                </div>

            </div>

        </section><!-- /Work Process Section -->

        <!-- Call To Action Section -->
        <section id="call-to-action" class="call-to-action section dark-background">

            <img src="assets/img/bg/bg-8.webp" alt="">

            <div class="container">

                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-xl-9 text-center text-xl-start">
                        <h3>Call To Action</h3>
                        <p>Unlock the full potential of learning with easy access to powerful library resources—anytime,
                            anywhere. Whether you're a student, faculty member, or researcher, our library is here to
                            support your academic journey every step of the way.</p>
                    </div>
                    <div class="col-xl-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="#contact">Call To Action</a>
                    </div>
                </div>

            </div>

        </section><!-- /Call To Action Section -->

        <!-- Portfolio Section -->
        <section id="portfolio" class="portfolio section">

            <!-- Section Title -->
            <div class="container my-5">
                <div class="section-title text-center mb-4" data-aos="fade-up">
                    <h2 class="fw-bold">📚 Our Journey Since 1991</h2>
                    <p class="text-muted">
                        Pioneering accessible learning for over three decades.
                        Showcasing our commitment to academic excellence through modern, student-centric library
                        solutions—both physical and digital.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6" data-aos="fade-up">
                        <div class="p-4 border rounded-3 shadow-sm h-100">
                            <h5 class="fw-semibold">📘 Physical Library Development</h5>
                            <p>Robust collections of textbooks, journals, and reference materials curated over decades
                                to support all academic departments.</p>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="p-4 border rounded-3 shadow-sm h-100">
                            <h5 class="fw-semibold">🌐 E-Library & Digital Resources</h5>
                            <p>Integrated digital platforms providing access to e-books, academic journals, and research
                                databases—available 24/7.</p>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="p-4 border rounded-3 shadow-sm h-100">
                            <h5 class="fw-semibold">📡 Smart Learning Environments</h5>
                            <p>Implementation of technology-enhanced reading zones, Wi-Fi-enabled study spaces, and
                                digital catalog systems for an enriched learning experience.</p>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="p-4 border rounded-3 shadow-sm h-100">
                            <h5 class="fw-semibold">🔍 Research & Information Support</h5>
                            <p>Personalized support services including citation tools, research guidance, and academic
                                literacy programs.</p>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="p-4 border rounded-3 shadow-sm h-100">
                            <h5 class="fw-semibold">🎓 User Training & Digital Literacy</h5>
                            <p>Regular workshops and training sessions to help students and faculty make the most of
                                digital tools and research platforms.</p>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="p-4 border rounded-3 shadow-sm h-100">
                            <h5 class="fw-semibold">🤝 Community & Academic Engagement</h5>
                            <p>Hosting book fairs, reading clubs, and knowledge-sharing events that promote a culture of
                                learning and collaboration.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Section Title -->

            <div class="container">

                <div class="isotope-layout" data-default-filter="*" data-layout="masonry"
                    data-sort="original-order">

                    <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-app">Digital Services</li>
                        <li data-filter=".filter-product">Resources</li>
                        <li data-filter=".filter-branding">Library Tools & Facilities</li>
                    </ul><!-- End Portfolio Filters -->

                    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                            <img src="assets/img/portfolio/portfolio-1.jpeg" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Digital Library</h4>
                                <p>Access Knowledge Anytime, Anywhere — Your Digital Library Awaits.</p>
                                <a href="assets/img/portfolio/portfolio-1.jpeg" title="App 1"
                                    data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                            <img src="assets/img/portfolio/portfolio-2.jpeg" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Facilities</h4>
                                <p>Smart Tools for Seamless Learning and Resource Management.</p>
                                <a href="assets/img/portfolio/portfolio-2.jpeg" title="Product 1"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                            <img src="assets/img/portfolio/portfolio-3.jpeg" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>e-Library </h4>
                                <p>E-Library: Bridging Knowledge Through Digital Access.</p>
                                <a href="assets/img/portfolio/portfolio-3.jpeg" title="Branding 1"
                                    data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                            <img src="assets/img/portfolio/portfolio-4.jpeg" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Library Resources</h4>
                                <p>Empowering Learning with Knowledge-Rich Content.</p>
                                <a href="assets/img/portfolio/portfolio-4.jpeg" title="App 2"
                                    data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                            <img src="assets/img/portfolio/portfolio-5.jpeg" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Library Collection</h4>
                                <p>Curated Knowledge for Every Curious Mind.</p>
                                <a href="assets/img/portfolio/portfolio-5.jpeg" title="Product 2"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                            <img src="assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Quiet with Assistance</h4>
                                <p>Well-organized space with helpful staff and excellent resources that support our work</p>
                                <a href="assets/img/portfolio/portfolio-5.jpeg" title="Product 2"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                            <img src="assets/img/portfolio/portfolio-portrait-3.jpeg" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Online Library</h4>
                                <p>Your Gateway to Knowledge, Anytime, Anywhere.</p>
                                <a href="assets/img/portfolio/portfolio-6.jpeg" title="Branding 2"
                                    data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                            <img src="assets/img/portfolio/portfolio-7.jpeg" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Library Tools</h4>
                                <p>Library tools simplify access and management of resources for better learning.</p>
                                <a href="assets/img/portfolio/portfolio-7.jpeg" title="App 3"
                                    data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                            <img src="assets/img/portfolio/portfolio-8.jpeg" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Library Management</h4>
                                <p>Streamlining Access, Organization, and Efficiency.</p>
                                <a href="assets/img/portfolio/portfolio-8.jpeg" title="Product 3"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                            <img src="assets/img/portfolio/portfolio-9.jpeg" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Digital Library</h4>
                                <p>Unlocking Knowledge Through Seamless Online Access.</p>
                                <a href="assets/img/portfolio/portfolio-9.jpeg" title="Branding 2"
                                    data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                            <img src="assets/img/portfolio/portfolio-10.jpeg" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Library Infrastructure</h4>
                                <p>Built to Support Learning, Research, and Innovation.</p>
                                <a href="assets/img/portfolio/portfolio-10.jpeg" title="Branding 2"
                                    data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                        class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>

                        <!-- End Portfolio Item -->

                    </div><!-- End Portfolio Container -->

                </div>

            </div>

        </section><!-- /Portfolio Section -->

        <!-- Team Section -->
        <section id="team" class="team section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Our Team</h2>
                <p>Meet the people behind our library’s success — a passionate team of librarians, educators, digital resource managers, and support staff committed to academic excellence. Together, we ensure seamless access to knowledge, foster a culture of learning, and support every student and faculty member in their educational journey.
                </p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="assets/img/person/principal.jpg" class="img-fluid"
                                    alt=""></div>
                            <div class="member-info">
                                <h4>Dr VC Uniyal</h4>
                                <span>Principal</span>
                                <p>Our Principal leads with vision and dedication, inspiring academic excellence and holistic growth.</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="assets/img/person/rekha.jpg" class="img-fluid"
                                    alt=""></div>
                            <div class="member-info">
                                <h4>Dr Rekha Bahuguna</h4>
                                <span>Asst. Professor</span>
                                <p>An Assistant Professor of Sociology fosters critical thinking and social awareness through engaging teaching and research in the study of society.</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="assets/img/person/farswan.jpg" class="img-fluid"
                                    alt=""></div>
                            <div class="member-info">
                                <h4>Dr JS Farswan</h4>
                                <span>Asst Professor</span>
                                <p>An Assistant Professor cultivates critical insight and social understanding through impactful teaching and scholarly research.</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="assets/img/person/hmj.jpg" class="img-fluid"
                                    alt=""></div>
                            <div class="member-info">
                                <h4>Mr HM Joshi</h4>
                                <span> Asst Librarian</span>
                                <p><span>Manages information resources, supports research, and facilitates seamless access to knowledge for the academic community.</span></p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="assets/img/person/dinesh.jpg" class="img-fluid"
                                    alt=""></div>
                            <div class="member-info">
                                <h4>Mr DP Maithani</h4>
                                <span> Senior Assistant</span>
                                <p><span>Ensuring Smooth Library Operations and Exceptional Support.</span></p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="assets/img/person/rama.jpg" class="img-fluid"
                                    alt=""></div>
                            <div class="member-info">
                                <h4>Mrs Rama Bahuguna</h4>
                                <span> Library Clerk</span>
                                <p><span>Keeping Library Resources Organized and Accessible.</span></p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- /Team Section -->

        <!-- Pricing Section -->
        <section id="pricing" class="pricing section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Library Fees</h2>
                <p>Transparent and affordable fees designed to support your academic needs and resource access</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                        <div class="pricing-item text-center">
                            <h3>Membership & Access</h3>
                            <h4><sup>starts @ ₹</sup>500</h4>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Annual membership for students and faculty</span></li>
                                <li><i class="bi bi-check"></i> <span>Access to physical and digital collections</span></li>
                                <li><i class="bi bi-check"></i> <span>Borrowing privileges and renewal options</span></li>
                                <li><i class="bi bi-check"></i> <span>On-campus and remote access to e-resources</span></li>
                                <li><i class="bi bi-check"></i> <span>Ongoing support and maintenance</span></li>
                            </ul>
                            <a href="#contact" class="buy-btn">Contact Now</a>
                        </div>
                    </div><!-- End Pricing Item -->

                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="pricing-item featured text-center">
                            <h3>Digital Resource Access</h3>
                            <h4><sup>starts @ ₹</sup>300</h4>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Access to e-books, journals, and databases</span></li>
                                <li><i class="bi bi-check"></i> <span>24/7 availability via online library portal</span></li>
                                <li><i class="bi bi-check"></i> <span>User-friendly search and download options</span></li>
                                <li><i class="bi bi-check"></i> <span>Regular updates to digital content</span>                                </li>
                                <li><i class="bi bi-check"></i> <span>Continuous assessment and feedback</span></li>
                            </ul>
                            <a href="#contact" class="buy-btn">Subscribe Now</a>
                        </div>
                    </div><!-- End Pricing Item -->

                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="300">
                        <div class="pricing-item text-center">
                            <h3>Printing & Photocopying</h3>
                            <h4><sup>starts @ ₹</sup>100</h4>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Affordable printing and photocopy services</span></li>
                                <li><i class="bi bi-check"></i> <span>High-quality printouts of study materials</span></li>
                                <li><i class="bi bi-check"></i> <span>Convenient payment options at the library counter</span>                                </li>
                                <li><i class="bi bi-check"></i> <span>Quick turnaround time for bulk orders</span></li>
                                <li><i class="bi bi-check"></i> <span>Support for academic and research needs</span>
                                </li>
                            </ul>
                            <a href="#contact" class="buy-btn">Pay Now</a>
                        </div>
                    </div><!-- End Pricing Item -->

                </div>

            </div>

        </section><!-- /Pricing Section -->

        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Testimonials</h2>
                <p>What our students, faculty, and visitors say about their experience with our library services.</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              }
            }
          </script>
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="assets/img/person/sunil.jpg" class="testimonial-img" alt="">
                                <h3>Dr. Sunil Rawan</h3>
                                <h4>Asst. Professor, Maths</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>Since joining the college in 2019, I have witnessed the library's vital role in supporting our academic community and nurturing a culture of knowledge.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="assets/img/person/shilpi.jpg" class="testimonial-img" alt="">
                                <h3>Shilpi</h3>
                                <h4>Student, Balganga Degree College, Sendul</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>The library has played a vital role in my academic success. It offers a wide range of resources—both physical and digital—that have supported my studies throughout my time here. The peaceful environment and dedicated staff make it an ideal place to focus, learn, and grow.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="assets/img/person/amisha.jpg" class="testimonial-img" alt="">
                                <h3>Amisha Dodiyal</h3>
                                <h4>Student, Balganga Degree College, Sendul</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>I’m truly thankful for our college library. It’s more than just a place to read—it's where I’ve developed strong study habits, explored new topics, and found the support I needed academically. It’s a cornerstone of my college experience.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="assets/img/person/girish.jpg" class="testimonial-img" alt="">
                                <h3>Girish Chandra Nautiyal</h3>
                                <h4>Asst. Geography</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>As a member of the Geography faculty, I greatly appreciate the college library's extensive and well-curated collection of geographic resources. From atlases, maps, and scholarly journals to digital databases and research publications, the library provides invaluable support for both teaching and research. The quiet environment, helpful staff, and access to interdisciplinary materials make it an essential academic hub for both faculty and students. It truly enhances the overall academic experience and promotes a culture of knowledge and exploration.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="assets/img/person/mukesh.jpg" class="testimonial-img" alt="">
                                <h3>Dr. Mukesh Naithani</h3>
                                <h4>Asst. Professor, Geography</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>The college library is a vital academic asset, especially for Geography. Its resources—ranging from topographic maps to global studies journals—support both faculty research and student learning. I commend the library for fostering an environment that encourages academic inquiry and excellence.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>

        </section><!-- /Testimonials Section -->

        <!-- Faq 2 Section -->
        <section id="faq-2" class="faq-2 section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Frequently Asked Questions</h2>
                <p>Clear answers to help you make the most of our library services and resources.</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-10">

                        <div class="faq-container">

                            <div class="faq-item faq-active" data-aos="fade-up" data-aos-delay="200">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>What resources are available in the library?</h3>
                                <div class="faq-content">
                                    <p>Our library offers a rich collection of physical books, academic journals, digital databases, e-books, newspapers, and research tools accessible both on-site and online.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Who can access the e-library?</h3>
                                <div class="faq-content">
                                    <p>All enrolled students, faculty, and staff members with valid credentials can access the e-library from anywhere, at any time.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>How do I borrow or renew a book?</h3>
                                <div class="faq-content">
                                    <p>You can borrow books by visiting the library or using your online account. Renewals can also be done online unless the book is reserved by another user.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Is there a late fee for overdue books?</h3>
                                <div class="faq-content">
                                    <p> Yes, a nominal late fee is charged per day for overdue items. Details are available at the circulation desk or on our library portal.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Can I request books or suggest new resources?</h3>
                                <div class="faq-content">
                                    <p>Absolutely. Students and faculty can submit book requests or suggest new materials through the library website or suggestion box.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>How do I get help with research or finding materials?</h3>
                                <div class="faq-content">
                                    <p>Our librarians and research assistants are available during working hours to guide you in locating, accessing, and citing academic materials.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->  

                        </div>

                    </div>

                </div>

            </div>

        </section><!-- /Faq 2 Section -->

        <!-- Subscribe Section -->
        <section id="subscribe" class="subscribe section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4 justify-content-between align-items-center">
                    <div class="col-lg-6">
                        <div class="cta-content" data-aos="fade-up" data-aos-delay="200">
                            <h2>Stay Updated</h2>
                            <p>Subscribe to our newsletter for the latest insights, updates, and exclusive offerings
                                delivered straight to your inbox.</p>
                            <form action="#contact" method="get" class="php-email-form cta-form"
                                data-aos="fade-up" data-aos-delay="300">
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" placeholder="Email address..."
                                        aria-label="Email address" aria-describedby="button-subscribe">
                                    <button class="btn btn-primary" type="submit"
                                        id="button-subscribe">Subscribe</button>
                                </div>
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cta-image" data-aos="zoom-out" data-aos-delay="200">
                            <img src="assets/img/cta/cta-1.webp" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Subscribe Section -->

        <!-- Recent Blog Postst Section -->
        {{-- <section id="recent-blog-postst" class="recent-blog-postst section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Recent Blog Posts</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-5">

                    <div class="col-xl-4 col-md-6">
                        <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

                            <div class="post-img position-relative overflow-hidden">
                                <img src="assets/img/blog/blog-post-1.webp" class="img-fluid" alt="">
                                <span class="post-date">December 12</span>
                            </div>

                            <div class="post-content d-flex flex-column">

                                <h3 class="post-title">Eum ad dolor et. Autem aut fugiat debitis</h3>

                                <div class="meta d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person"></i> <span class="ps-2">Julia Parker</span>
                                    </div>
                                    <span class="px-3 text-black-50">/</span>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-folder2"></i> <span class="ps-2">Politics</span>
                                    </div>
                                </div>

                                <hr>

                                <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i
                                        class="bi bi-arrow-right"></i></a>

                            </div>

                        </div>
                    </div><!-- End post item -->

                    <div class="col-xl-4 col-md-6">
                        <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="200">

                            <div class="post-img position-relative overflow-hidden">
                                <img src="assets/img/blog/blog-post-2.webp" class="img-fluid" alt="">
                                <span class="post-date">July 17</span>
                            </div>

                            <div class="post-content d-flex flex-column">

                                <h3 class="post-title">Et repellendus molestiae qui est sed omnis</h3>

                                <div class="meta d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person"></i> <span class="ps-2">Mario Douglas</span>
                                    </div>
                                    <span class="px-3 text-black-50">/</span>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-folder2"></i> <span class="ps-2">Sports</span>
                                    </div>
                                </div>

                                <hr>

                                <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i
                                        class="bi bi-arrow-right"></i></a>

                            </div>

                        </div>
                    </div><!-- End post item -->

                    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="post-item position-relative h-100">

                            <div class="post-img position-relative overflow-hidden">
                                <img src="assets/img/blog/blog-post-3.webp" class="img-fluid" alt="">
                                <span class="post-date">September 05</span>
                            </div>

                            <div class="post-content d-flex flex-column">

                                <h3 class="post-title">Quia assumenda est et veritati tirana ploder</h3>

                                <div class="meta d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person"></i> <span class="ps-2">Lisa Hunter</span>
                                    </div>
                                    <span class="px-3 text-black-50">/</span>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-folder2"></i> <span class="ps-2">Economics</span>
                                    </div>
                                </div>

                                <hr>

                                <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i
                                        class="bi bi-arrow-right"></i></a>

                            </div>

                        </div>
                    </div><!-- End post item -->

                </div>

            </div>

        </section> --}}
        <!-- /Recent Blog Postst Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Balganga Post Graduate College Sendul P.O. : Silyara (Kemar) Distt : Tehri Garhwal Uttarakhand-249155</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-5">

                        <div class="info-wrap">
                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h3>Address</h3>
                                    <p>Balganga Post Graduate College, Ghansali, Tehri Garhwal, Uttarakhand-249155</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                <i class="bi bi-telephone flex-shrink-0"></i>
                                <div>
                                    <h3>Call Us</h3>
                                    <p>9690122495</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h3>Email Us</h3>
                                    <p>balgangaelib@yahoo.com</p>
                                </div>
                            </div><!-- End Info Item -->

                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d55042.94031510379!2d78.621789!3d30.430892!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMzDCsDI1JzUxLjIiTiA3OMKwMzgnMjQuOSJF!5e0!3m2!1sen!2sin!4v1748534204272!5m2!1sen!2sin"
                                frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        </div>
                    </div>


                    @if (session('success'))
                        <div id="success-alert" class="d-flex justify-content-center mt-3">
                            <div class="alert alert-success alert-dismissible fade show shadow w-100 text-center"
                                role="alert" style="max-width: 600px;">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif


                    <div class="col-lg-7">
                        <form action="{{ route('frontend.contacts.store') }}" method="POST" class="php-email-form"
                            data-aos="fade-up" data-aos-delay="200">
                            @csrf
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <label for="name-field" class="pb-2">Your Name</label>
                                    <input type="text" name="name" id="name-field" class="form-control"
                                        required="">
                                </div>

                                <div class="col-md-6">
                                    <label for="email-field" class="pb-2">Your Email</label>
                                    <input type="email" class="form-control" name="email" id="email-field"
                                        required="">
                                </div>

                                <div class="col-md-6">
                                    <label for="phone-field" class="pb-2">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone-field"
                                        required="" maxlength="10" pattern="\d{10}" inputmode="numeric"
                                        title="Enter a 10-digit phone number">

                                </div>

                                <div class="col-md-6">
                                    <label for="subject-field" class="pb-2">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject-field"
                                        required="">
                                </div>

                                <div class="col-md-12">
                                    <label for="message-field" class="pb-2">Message</label>
                                    <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>

                                    <button type="submit">Send Message</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->

    </main>

    <footer id="footer" class="footer">

        <!-- Offices Section -->
        {{-- <section class="py-5" id="offices">
            <div class="container" data-aos="fade-up">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Our Offices</h2>
                    <p class="text-muted">Reach out to any of our offices around the globe</p>
                </div>

                <div class="row g-4">
                    <!-- Corporate Office -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">Corporate Office</h5>
                                <p class="mb-1"><strong>Address 1:</strong> Gitanjali, Doon University, Dehradun,
                                    Uttarakhand-248121</p>
                                <p class="mb-1"><strong>Phone:</strong> +917820013579</p>
                                <p><strong>Email:</strong> <a href="https://itmedium.in">itmedium@yahoo.com</a></p>


                                <p class="mb-1"><strong>Address 2:</strong> 31-NSM Near Clock Tower, Dehradun,
                                    Uttarakhand, India-248001</p>
                                <p class="mb-1"><strong>Phone:</strong> +917820013579</p>
                                <p><strong>Email:</strong> <a href="https://itmedium.in">itmedium@yahoo.com</a></p>


                            </div>
                        </div>
                    </div>

                    <!-- Branch Office -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">Branch Office</h5>
                                <p class="mb-1"><strong>Address 1:</strong> 16-A Chakrata Road Opp RGM Plaza,
                                    Dehradun,
                                    UK-248001</p>
                                <p class="mb-1"><strong>Phone:</strong> +917820013579</p>
                                <p><strong>Email:</strong> <a href="https://itmedium.in">itmedium@yahoo.com</a></p>

                                <p class="mb-1"><strong>Address 2:</strong> 3-Gurukrupa CHS, PNo-2/3, Sukapur,
                                    Panvel, Navi Mumbai-410206</p>
                                <p class="mb-1"><strong>Phone:</strong> +919324131163</p>
                                <p><strong>Email:</strong> <a href="https://itmedium.in">itmedium@yahoo.com</a></p>
                            </div>
                        </div>
                    </div>

                    <!-- Executive Office -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">Executive Office</h5>
                                <p class="mb-1"><strong>Address 1:</strong> 3-Gurukrupa CHS, PNo-2/3, Sukapur,
                                    Panvel, Navi Mumbai-410206</p>
                                <p class="mb-1"><strong>Phone:</strong> +919324131163</p>
                                <p><strong>Email:</strong> <a href="https://itmedium.in">itmedium@yahoo.com</a></p>

                                <p class="mb-1"><strong>Address 2:</strong> Avantika Sector-3 Rohini New Delhi-110011
                                </p>
                                <p class="mb-1"><strong>Phone:</strong> +91965446912</p>
                                <p><strong>Email:</strong> <a href="https://itmedium.in">itmedium@yahoo.com</a></p>
                            </div>
                        </div>
                    </div>

                    <!-- Consulting Office -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">Consulting Office</h5>
                                <p class="mb-1"><strong>Address:</strong> Spon Lane Smethwick Birmingham UK-B661AB
                                </p>
                                <p class="mb-1"><strong>Phone:</strong> +44 7733 726 303</p>
                                <p><strong>Email:</strong> <a href="http://itmedium.in">itmedium@yahoo.com</a></p>

                                <p class="mb-1"><strong>Address:</strong> 36 Mary Huse Grove Lower Hutt Wellington
                                    Newzealand 5045</p>
                                <p class="mb-1"><strong>Phone:</strong> +64 210 486 661</p>
                                <p><strong>Email:</strong> <a href="http://itmedium.in">itmedium@yahoo.com</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}


        <!-- Office Locations Section -->



        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="#" class="d-flex align-items-center">
                        <span class="sitename">बालगंगा ई -पुस्तकालय</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Sendul, PO-Silyara</p>
                        <p>Ghansali, Distt-Tehri Garhwal, Uttarakhand</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+91 1234567890</span></p>
                        <p><strong>Email:</strong> <span>balgangaelib@yahoo.com</span></p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#home">Home</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#about">About us</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#services">Services</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#services">Physical & Digital Resource Access</a>
                        </li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#services">E-Library Platform & Remote Access</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#services">Research Support & Academic Assistance</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#services">Study Spaces & Learning Facilities</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h4>Follow Us</h4>
                    <p>Stay connected and explore more of what we do. Follow us for updates, insights, and innovations..
                    </p>
                    <div class="social-links d-flex">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">बालगंगा ई -पुस्तकालय</strong> <span>All Rights
                    Reserved</span>
            </p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://itmedium.in/">ITMedium Pvt. Ltd.</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alertContainer = document.getElementById("success-alert");

            if (alertContainer) {
                setTimeout(() => {
                    const alertBox = alertContainer.querySelector('.alert');

                    // Use Bootstrap's fade class to transition
                    alertBox.classList.remove('show');
                    alertBox.classList.add('fade');

                    // Hide alert and reset form after fade-out
                    setTimeout(() => {
                        alertContainer.remove(); // Remove the whole alert
                        const form = document.querySelector(".php-email-form");
                        if (form) form.reset();
                    }, 500); // Match Bootstrap fade duration
                }, 5000); // Show for 5 seconds
            }
        });
    </script>




</body>

</html>
