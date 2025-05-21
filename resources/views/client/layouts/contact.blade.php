@extends('client.layouts.app')

@section('title', 'Contact Us')

@section('content')

<section class="py-5">
    <div class="container">
        <h2 class="mb-5 text-center">Contact Us</h2>
        <div class="row g-4 justify-content-center">
            <!-- Contact Form -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100">
                    <form action="#" method="POST" novalidate>
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">Your Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" placeholder="Write your message here..." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-danger fw-bold px-4 disabled">Send Message</button>
                    </form>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="col-md-4">
                <div class="card shadow-sm p-4 h-100">
                    <h5 class="mb-4">Our Contact Details</h5>
                    <p class="mb-3"><i class="fas fa-map-marker-alt text-danger me-2"></i> Flower Street, Tirana, Albania</p>
                    <p class="mb-3"><i class="fas fa-envelope text-danger me-2"></i> contact@thebloomroom.al</p>
                    <p class="mb-3"><i class="fas fa-phone text-danger me-2"></i> +355 68 123 4567</p>

                    <h5 class="mt-5 mb-3">Follow Us</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-danger fs-4" aria-label="Facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-danger fs-4" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-danger fs-4" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ (leave unchanged) -->
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="text-center mb-3">Frequently Asked Questions</h4>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                How long does delivery take?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                We offer same-day delivery in Tirana if ordered before 2 PM. For other regions, delivery may take 1-2 days.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Can I customize a bouquet?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                Yes! Contact us directly or leave a note at checkout with your preferences, and we’ll do our best to create a custom bouquet.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Do you offer subscriptions?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                We do! Flower subscriptions can be weekly, bi-weekly, or monthly. Get in touch to learn more.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
