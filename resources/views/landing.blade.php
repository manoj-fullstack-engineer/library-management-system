@extends('layouts.app')

@section('content')

<!-- Home Section -->
<section id="home" class="py-5 bg-primary text-white text-center">
    <div class="container">
        <h1 class="display-4">Welcome to Our Corporate Website</h1>
        <p class="lead">We deliver high-end digital solutions for businesses and startups.</p>
        <a href="#about" class="btn btn-light mt-3">Learn More</a>
    </div>
</section>

<!-- About Section Start -->
<section id="about" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="{{ asset('images/about.jpg') }}" alt="About Us" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2>About ITMedium</h2>
                <p>We are a team of experienced developers and consultants offering innovative solutions in software, web, mobile, and education sectors. Our mission is to empower businesses through technology.</p>
                <a href="#services" class="btn btn-outline-primary mt-3">Our Services</a>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Services Section Start -->
<section id="services" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-5">Our Services</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Software Development</h5>
                        <p class="card-text">Custom software to streamline your operations and accelerate growth.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Web Solutions</h5>
                        <p class="card-text">Modern, scalable websites to create your digital presence.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Mobile Apps</h5>
                        <p class="card-text">Android & iOS mobile apps with a focus on performance and UI/UX.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Domain & Hosting</h5>
                        <p class="card-text">Reliable domain registration and hosting services for your brand.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Digital Marketing</h5>
                        <p class="card-text">SEO, social media, and PPC strategies to boost your visibility online.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Educational Services</h5>
                        <p class="card-text">Trainings and workshops in IT, business, and professional skills.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Hybrid Consultancy</h5>
                        <p class="card-text">Blended consultancy services to meet your tech and business needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Portfolio Section Start -->
<section id="portfolio" class="py-5">
    <div class="container text-center">
        <h2 class="mb-5">Our Portfolio</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <img src="{{ asset('images/portfolio1.jpg') }}" class="img-fluid rounded shadow-sm" alt="Portfolio 1">
            </div>
            <div class="col-md-4">
                <img src="{{ asset('images/portfolio2.jpg') }}" class="img-fluid rounded shadow-sm" alt="Portfolio 2">
            </div>
            <div class="col-md-4">
                <img src="{{ asset('images/portfolio3.jpg') }}" class="img-fluid rounded shadow-sm" alt="Portfolio 3">
            </div>
        </div>
    </div>
</section>
<!-- Portfolio Section End -->

<!-- Testimonials Section Start -->
<section id="testimonials" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-5">What Our Clients Say</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <blockquote class="blockquote">
                    <p class="mb-0">"Fantastic service! ITMedium helped grow our business beyond expectations."</p>
                    <footer class="blockquote-footer">John Doe, CEO</footer>
                </blockquote>
            </div>
            <div class="col-md-6">
                <blockquote class="blockquote">
                    <p class="mb-0">"Professional, creative and highly responsive team. Highly recommended."</p>
                    <footer class="blockquote-footer">Jane Smith, CTO</footer>
                </blockquote>
            </div>
        </div>
    </div>
</section>
<!-- Testimonials Section End -->


<!-- Blog Section Start -->
<section id="blog" class="py-5">
    <div class="container text-center">
        <h2 class="mb-5">Latest Blog Posts</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/blog1.jpg') }}" class="card-img-top" alt="Blog 1">
                    <div class="card-body">
                        <h5 class="card-title">Top Trends in Software Development</h5>
                        <p class="card-text">Stay updated with the latest software industry trends in 2025 and beyond.</p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/blog2.jpg') }}" class="card-img-top" alt="Blog 2">
                    <div class="card-body">
                        <h5 class="card-title">Boost Your Website SEO</h5>
                        <p class="card-text">Simple yet powerful techniques to improve your website's Google ranking.</p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/blog3.jpg') }}" class="card-img-top" alt="Blog 3">
                    <div class="card-body">
                        <h5 class="card-title">Mobile App Development Secrets</h5>
                        <p class="card-text">Key strategies behind successful mobile app launches and monetization.</p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->

<!-- Contact Section Start -->
<section id="contact" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Contact Us</h2>
            <p>Have a question? We're just one message away!</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" id="mobile" pattern="\d*" maxlength="15" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea name="message" class="form-control" id="message" rows="4" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->


@endsection
