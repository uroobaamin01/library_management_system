@extends('frontend.layouts.app')

@section('title', 'University Library - Explore & Discover Books')

@section('content')

<!-- 1. HERO SECTION -->
<section class="position-relative py-5 bg-dark text-white d-flex align-items-center" style="min-height: 85vh; background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.85)), url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;">
    <div class="container py-5" data-aos="fade-up">
        <div class="row justify-content-center text-center">
            <div class="col-lg-9">
                <span class="badge bg-success mb-3 px-3 py-2 rounded-pill fs-6"><i class="fa-solid fa-sparkles me-1"></i> Modern Digital Knowledge Hub</span>
                <h1 class="display-3 fw-bold mb-4">Empowering Minds Through Knowledge & Innovation</h1>
                <p class="lead mb-5 text-light opacity-75">Access thousands of books, research papers, digital journals, and academic literature from anywhere.</p>

                <!-- 2. QUICK SEARCH BAR -->
                <div class="card p-2 p-md-3 shadow-lg border-0 rounded-4 bg-white text-dark text-start mb-5">
                    <form action="{{ route('books.index') }}" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-0 shadow-none" placeholder="Search by Book Title, ISBN, or Author...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="category" class="form-select border-0 shadow-none border-start">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-accent w-100 py-2"><i class="fa-solid fa-search me-1"></i> Find Books</button>
                        </div>
                    </form>
                </div>

                <!-- 3. HERO STATISTICS -->
                <div class="row g-4 text-center">
                    <div class="col-6 col-md-3">
                        <h3 class="fw-bold mb-0 text-warning">{{ $stats['total_books'] ?? 0 }}+</h3>
                        <p class="small text-light opacity-75 mb-0">Total Books</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <h3 class="fw-bold mb-0 text-warning">{{ $stats['total_authors'] ?? 0 }}+</h3>
                        <p class="small text-light opacity-75 mb-0">Authors</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <h3 class="fw-bold mb-0 text-warning">{{ $stats['total_students'] ?? 0 }}+</h3>
                        <p class="small text-light opacity-75 mb-0">Active Students</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <h3 class="fw-bold mb-0 text-warning">{{ $stats['total_publishers'] ?? 0 }}+</h3>
                        <p class="small text-light opacity-75 mb-0">Publishers</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- 4. ABOUT LIBRARY SECTION -->
<section id="about" class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=800&q=80" alt="Students Reading" class="img-fluid rounded-4 shadow-sm">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="text-uppercase text-success fw-bold small">About Our Library</span>
                <h2 class="fw-bold my-3">A State-of-the-Art Learning Hub for Academic Excellence</h2>
                <p class="text-muted">Our university library is designed to facilitate research, collaborative learning, and solitary study. With extensive physical cataloging and digital integrations, students can easily search, borrow, and track their literature lifecycle.</p>
                <div class="row g-3 mt-2">
                    <div class="col-6 d-flex align-items-center">
                        <i class="fa-solid fa-circle-check text-success fa-lg me-2"></i>
                        <span class="fw-semibold">Automated Borrowing</span>
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <i class="fa-solid fa-circle-check text-success fa-lg me-2"></i>
                        <span class="fw-semibold">Silent Reading Rooms</span>
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <i class="fa-solid fa-circle-check text-success fa-lg me-2"></i>
                        <span class="fw-semibold">Digital Archives Access</span>
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <i class="fa-solid fa-circle-check text-success fa-lg me-2"></i>
                        <span class="fw-semibold">24/7 Portal Tracking</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. BOOK CATEGORIES SECTION -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase text-success fw-bold small">Explore Catalog</span>
                <h2 class="fw-bold mb-0">Popular Categories</h2>
            </div>
            <a href="{{ route('books.index') }}" class="btn btn-outline-dark btn-sm">View All Categories <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-md-3 col-sm-6" data-aos="zoom-in">
                    <div class="card card-custom p-4 bg-white text-center">
                        <div class="bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-circle mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-bookmark fa-xl"></i>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $category->name }}</h5>
                        <span class="text-muted small">{{ $category->books_count ?? 0 }} Books Available</span>
                        <a href="{{ route('books.index', ['category' => $category->id]) }}" class="stretched-link"></a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-4">No categories created in Admin Panel yet.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- 6. FEATURED BOOKS SECTION -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="text-uppercase text-success fw-bold small">Curated Collection</span>
            <h2 class="fw-bold">Featured Books</h2>
        </div>
        <div class="row g-4">
            @forelse($featuredBooks as $book)
                <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up">
                    <div class="card card-custom h-100 bg-white border">
                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=400&q=80' }}" class="card-img-top" style="height: 240px; object-fit: cover;" alt="{{ $book->title }}">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-info-subtle text-info border mb-2 w-auto me-auto small">{{ $book->category->name ?? 'General' }}</span>
                            <h6 class="fw-bold mb-1">{{ Str::limit($book->title, 40) }}</h6>
                            <p class="text-muted small mb-3">By {{ $book->author->name ?? 'Unknown Author' }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">No featured books marked in catalog.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- 7. OUR SERVICES SECTION -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="text-uppercase text-success fw-bold small">What We Offer</span>
            <h2 class="fw-bold">Library Services</h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card card-custom p-4 bg-white h-100">
                    <i class="fa-solid fa-book-journal-whills text-primary fa-3x mb-3"></i>
                    <h5 class="fw-bold">Physical Borrowing</h5>
                    <p class="text-muted small mb-0">Request books online and collect physical copies directly from the librarian counter.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4 bg-white h-100">
                    <i class="fa-solid fa-laptop-code text-success fa-3x mb-3"></i>
                    <h5 class="fw-bold">Digital Research Lab</h5>
                    <p class="text-muted small mb-0">High-speed terminal computers allocated for research, electronic journals, and online databases.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4 bg-white h-100">
                    <i class="fa-solid fa-user-clock text-warning fa-3x mb-3"></i>
                    <h5 class="fw-bold">Book Holds & Reservations</h5>
                    <p class="text-muted small mb-0">Reserve checked-out books in advance and get notified automatically when they are available.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. HOW BORROWING WORKS -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="text-uppercase text-success fw-bold small">Simple Steps</span>
            <h2 class="fw-bold">How Borrowing Works</h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="p-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-weight: 700;">1</div>
                    <h6 class="fw-bold">Search Catalog</h6>
                    <p class="text-muted small">Find your required books using our smart search filters.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-weight: 700;">2</div>
                    <h6 class="fw-bold">Submit Request</h6>
                    <p class="text-muted small">Log in as a student and click Request Book from the detail page.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-weight: 700;">3</div>
                    <h6 class="fw-bold">Librarian Approval</h6>
                    <p class="text-muted small">Librarian reviews and issues the physical book copy.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; font-weight: 700;">4</div>
                    <h6 class="fw-bold">Track & Return</h6>
                    <p class="text-muted small">Monitor due dates inside your Student Dashboard to avoid fines.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 9. LIBRARY RULES SECTION -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="text-uppercase text-success fw-bold small">Guidelines</span>
                <h2 class="fw-bold mb-4">Library Conduct & Rules</h2>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start gap-3">
                        <i class="fa-solid fa-volume-xmark text-danger fa-xl mt-2"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Maintain Strict Silence</h6>
                            <p class="text-muted small mb-0">Quiet environments must be respected in all reading halls and study cubicles.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <i class="fa-solid fa-id-card text-primary fa-xl mt-2"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Carry Student ID</h6>
                            <p class="text-muted small mb-0">Student ID cards are mandatory for entry and issuing physical copies.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <i class="fa-solid fa-clock-rotate-left text-warning fa-xl mt-2"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Timely Returns</h6>
                            <p class="text-muted small mb-0">Overdue books incur a daily fine managed automatically by the Librarian desk.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-4 shadow-sm" alt="Library Interior">
            </div>
        </div>
    </div>
</section>

<!-- 10. FAQS SECTION -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="text-uppercase text-success fw-bold small">Got Questions?</span>
            <h2 class="fw-bold">Frequently Asked Questions</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush" id="faqAccordion">
                    <div class="accordion-item border rounded-3 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How many books can I request at one time?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small">
                                Active students are eligible to hold up to 3 books concurrently based on librarian policy settings.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border rounded-3 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                How do I check my overdue fines?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small">
                                Log into your Student Dashboard and navigate to the Fines tab to review all dynamic fines logged by the Librarian.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection