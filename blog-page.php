<?php

    // --------------------
    // Database connection
    // --------------------
    // ✅ Connect to local XAMPP MySQL database
    $servername = "srv1445.hstgr.io";
    $username = "u450081634_rRd7c";
    $password = "4mh0ICUE0Z";
    $dbname = "u450081634_XudLt";  // your DB name
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
    
    // --------------------
    // Validate blog ID
    // --------------------
    if (!isset($_GET['slug'])) {
        die("Invalid blog slug");
    }

    $slug = $_GET['slug'];
    $sql = "SELECT * FROM wp_posts WHERE post_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $slug);;

    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        die("Blog not found!");
    }
    
    $blog = $result->fetch_assoc();
    $stmt->close();


?>
 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <title><?php echo htmlspecialchars($blog['post_title']); ?> | Canprosys Consultants Inc.</title>
    <meta name="description" content="<?php echo substr(strip_tags($blog['post_content']), 0, 150); ?>">
    <link rel="canonical" href="https://canprosys.com/blog-page.php?slug=<?php echo $slug; ?>" />

        <!-- CSS -->
    <link href="https://canprosys.com/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://canprosys.com/css/style.css">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/brands.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #1a4f8c;
            --secondary: #d35400;
            --accent: #2ecc71;
            --light: #f8f9fa;
            --dark: #2c3e50;
            --gray: #6c757d;
            --light-blue: #e8f4fd;
            --orange-light: #fef0e6;
            --border-light: 1px solid #e0e0e0;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 8px rgba(0,0,0,0.12);
            --shadow-lg: 0 8px 16px rgba(0,0,0,0.15);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: #ffffff;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px 20px;
        }

        /* Blog Hero Section */
        .blog-hero {
            padding: 160px 0 80px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary) 0%, #2c3e50 100%);
            color: white;
            text-align: center;
        }

        .blog-hero-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 22px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .blog-hero h1 {
            font-size: 48px;
            margin-bottom: 24px;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -1px;
            color: white;
        }
        
        .blog-meta {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin-bottom: 40px;
        }
        
        .blog-meta i {
            color: var(--secondary);
            margin-right: 8px;
        }
        
        /* Blog Content Section */
        .blog-content-section {
            padding: 80px 0;
            position: relative;
            background: var(--light);
        }
        
        .blog-content-wrapper {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 50px;
            box-shadow: var(--shadow-md);
        }
        
        .blog-featured-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 40px;
            box-shadow: var(--shadow-sm);
        }
        
        .blog-content {
            font-size: 18px;
            line-height: 1.8;
            color: var(--dark);
        }
        
        .blog-content h1,
        .blog-content h2,
        .blog-content h3,
        .blog-content h4 {
            color: var(--dark);
            margin: 30px 0 20px;
            font-weight: 600;
        }
        
        .blog-content h1 {
            font-size: 32px;
            border-bottom: 2px solid var(--light-blue);
            padding-bottom: 10px;
        }
        
        .blog-content h2 {
            font-size: 28px;
            color: var(--primary);
        }
        
        .blog-content h3 {
            font-size: 24px;
        }
        
        .blog-content p {
            margin-bottom: 20px;
            color: var(--gray);
        }
        
        .blog-content a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .blog-content a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
        
        .blog-content ul,
        .blog-content ol {
            margin: 20px 0;
            padding-left: 30px;
            color: var(--gray);
        }
        
        .blog-content li {
            margin-bottom: 10px;
        }
        
        .blog-content blockquote {
            border-left: 4px solid var(--primary);
            padding: 20px 20px 20px 30px;
            margin: 30px 0;
            font-style: italic;
            color: var(--gray);
            background: var(--light-blue);
            border-radius: 0 10px 10px 0;
            box-shadow: var(--shadow-sm);
        }
        
        .blog-content code {
            background: var(--light-blue);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: var(--primary);
        }
        
        .blog-content pre {
            background: var(--dark);
            color: white;
            padding: 20px;
            border-radius: 10px;
            overflow-x: auto;
            margin: 20px 0;
            box-shadow: var(--shadow-md);
        }
        
        .blog-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 40px 0;
            padding-top: 30px;
            border-top: var(--border-light);
        }
        
        .blog-tag {
            background: var(--light-blue);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .blog-tag:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Author Section */
        .blog-author {
            background: var(--light);
            padding: 30px;
            border-radius: 10px;
            margin: 50px 0;
            display: flex;
            align-items: center;
            gap: 20px;
            border-left: 4px solid var(--secondary);
        }
        
        .author-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        
        .author-info h4 {
            color: var(--dark);
            margin-bottom: 5px;
            font-size: 18px;
        }
        
        .author-info p {
            color: var(--gray);
            margin-bottom: 0;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary) 0%, #2c3e50 100%);
            color: white;
        }
        
        .cta-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .cta-section h2 {
            font-size: 42px;
            margin-bottom: 24px;
            color: white;
            font-weight: 700;
            line-height: 1.2;
        }
        
        .cta-section p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 40px;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .btn-primary {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 16px 38px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(211, 84, 0, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(211, 84, 0, 0.4);
            background: #e74c3c;
            color: white;
            text-decoration: none;
        }
        
      
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
        }
        
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            transform: translateY(-3px);
            background: var(--secondary);
            color: white;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            
            nav {
                position: fixed;
                top: 80px;
                left: 0;
                width: 100%;
                background: white;
                box-shadow: var(--shadow-md);
                transform: translateY(-100%);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s;
            }
            
            nav.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }
            
            nav ul {
                flex-direction: column;
                padding: 20px;
                gap: 15px;
            }
            
            .dropdown-content {
                position: static;
                box-shadow: none;
                opacity: 1;
                visibility: visible;
                transform: none;
                background: var(--light);
                margin-top: 10px;
                border-radius: 5px;
            }
            
            .blog-hero {
                padding: 140px 0 60px;
            }
            
            .blog-hero h1 {
                font-size: 36px;
            }
            
            .blog-meta {
                flex-direction: column;
                gap: 10px;
            }
            
            .blog-content-wrapper {
                padding: 30px 20px;
            }
            
            .blog-featured-image {
                height: 250px;
            }
            
            .blog-content {
                font-size: 16px;
            }
            
            .blog-author {
                flex-direction: column;
                text-align: center;
            }
            
            .cta-section h2 {
                font-size: 32px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
            
            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
            }
        }
        
        @media (max-width: 576px) {
            .blog-hero h1 {
                font-size: 32px;
            }
            
            .cta-section h2 {
                font-size: 28px;
            }
            
            .blog-content h1 {
                font-size: 28px;
            }
            
            .blog-content h2 {
                font-size: 24px;
            }
            
            .blog-content h3 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
        <?php
            $author_id = $blog['post_author'];
            $author_result = $conn->query("SELECT display_name FROM wp_users WHERE ID = $author_id");
            $author = ($author_result && $author_result->num_rows > 0)
                ? $author_result->fetch_assoc()['display_name']
                : "Unknown";

            $image_result = $conn->query("
                SELECT meta_value FROM wp_postmeta
                WHERE post_id = {$blog['ID']} AND meta_key = '_thumbnail_id' LIMIT 1
            ");
            $thumbnail_id = ($image_result && $image_result->num_rows > 0)
                ? $image_result->fetch_assoc()['meta_value']
                : 0;

            $img_url = '';
            if ($thumbnail_id) {
                $guid_result = $conn->query("SELECT guid FROM wp_posts WHERE ID = $thumbnail_id");
                $img_url = ($guid_result && $guid_result->num_rows > 0)
                    ? $guid_result->fetch_assoc()['guid']
                    : '';
            }
        ?>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <a href="/" style="text-decoration: none;">
                <div class="logo-container">
                    <div class="logo">
                        <img src="./assets/logo.jpg" alt="Canprosys" class="logo-img"
                            style="height: 100%; width: 100%;">
                    </div>
                    <div class="logo-text">Can<span>pro</span>sys</div>
                </div>
            </a>
            <div class="mobile-menu-btn">☰</div>
            <nav>
                <ul>
                    <li><a href="/" class="active">Home</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li class="dropdown">
                        <a href="#services">Services <i class="fas fa-chevron-down"></i></a>
                        <div class="dropdown-content">
                            <a href="tax-settlement-relief-program-with-cra.html">Tax Rectification/Relief program with
                                CRA
                            </a>
                            <!-- <a href="bookkeeping.html">Bookkeeping</a> -->
                            <a href="finance-and-accounting.html">Finance & Accounting Services</a>
                            <a href="financial-aid-service.html">Financial Aid and Government Grant Programs</a>
                            <a href="business-funding-help.html">Business Funding Help</a>
                            <a href="web-and-cyber-security.html">Web & Cyber Security</a>
                            <a href="networking-and-data-cabling.html">Networking Data Cabling</a>
                        </div>
                    </li>
                    <!-- <li><a href="blogs.html">Blogs</a></li> -->
                    <li><a href="index.html#testimonials">Testimonials</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Blog Hero Section -->
    <section class="blog-hero">
        <div class="container">
            <div class="blog-hero-badge">
                <i class="fas fa-newspaper"></i> Blog Post
            </div>
            <h1><?php echo htmlspecialchars($blog['post_title']); ?></h1>
            <div class="blog-meta">
                <span><i class="fas fa-calendar-alt"></i> <?php echo date("F j, Y", strtotime($blog['post_date'])); ?></span>
                <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($author); ?></span>
                <span><i class="fas fa-clock"></i> <?php echo reading_time($blog['post_content']); ?> min read</span>
            </div>
        </div>
    </section>

    <!-- Blog Content Section -->
    <section class="blog-content-section">
        <div class="container">
            <div class="blog-content-wrapper">
                <?php if ($img_url): ?>
                    <img src="<?php echo $img_url; ?>" class="blog-featured-image" alt="<?php echo htmlspecialchars($blog['post_title']); ?>">
                <?php else: ?>
                    <div class="blog-featured-image" style="background: var(--primary); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-alt" style="font-size: 72px; color: white;"></i>
                    </div>
                <?php endif; ?>
                
                <div class="blog-content">
                    <?php echo $blog['post_content']; ?>
                </div>
                
                <!-- Blog Tags -->
                <div class="blog-tags">
                    <strong style="color: var(--dark); margin-right: 15px;">Tags:</strong>
                    <?php
                    // Get tags for the post
                    $tags_result = $conn->query("
                        SELECT t.name 
                        FROM wp_terms t 
                        INNER JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id 
                        INNER JOIN wp_term_relationships tr ON tr.term_taxonomy_id = tt.term_taxonomy_id 
                        WHERE tr.object_id = {$blog['ID']} AND tt.taxonomy = 'post_tag'
                    ");
                    
                    if ($tags_result && $tags_result->num_rows > 0) {
                        while ($tag = $tags_result->fetch_assoc()) {
                            echo '<a href="#" class="blog-tag">' . htmlspecialchars($tag['name']) . '</a>';
                        }
                    }
                    ?>
                </div>

                <!-- Author Section -->
                <div class="blog-author">
                    <div class="author-avatar">
                        <?php echo strtoupper(substr($author, 0, 1)); ?>
                    </div>
                    <div class="author-info">
                        <h4><?php echo htmlspecialchars($author); ?></h4>
                        <p>Tax Expert at Canprosys Consultants Inc. Specializing in CRA negotiations and tax debt resolution.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call To Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Need Professional Tax Help?</h2>
                <p>Our team of tax experts and former CRA advisors can help you resolve tax issues, reduce penalties, and find financial relief.</p>
                <a href="contact.html" class="btn-primary">Book Consultation <i class="fas fa-calendar-check"></i></a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3 footer-links">
                    <h3>Canprosys Consultants Inc.</h3>
                    <p>Your trusted partner for tax settlement, bookkeeping, and accounting services across Canada.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/p/Canprosys-Consultants-Inc-100075878817251/"
                            target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <!-- <a href="#" target="_blank"><i class="fab fa-twitter"></i></a> -->
                        <!-- <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a> -->
                        <a href="https://www.instagram.com/canprosys_taxrectification/" target="_blank"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4 footer-links">
                    <h3>Services</h3>
                    <ul style="list-style: circle;">
                        <li><a href="tax-settlement-relief-program-with-cra.html">Tax Rectification/Relief program with
                                CRA</a></li>
                        <li><a href="finance-and-accounting.html">Finance & Accounting</a></li>
                        <li><a href="financial-aid-service.html">Financial Aid and Government Grant Programs</a></li>
                        <li><a href="business-funding-help.html">Business Funding Help</a></li>
                        <li><a href="networking-and-data-cabling.html">Data Networking & Cabling</a></li>
                        <li><a href="web-and-cyber-security.html">Web & Cyber Security Services</a></li>
                    </ul>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-3 footer-links">
                    <h3>Quick Links</h3>
                    <ul style="list-style: circle;">
                        <li><a href="/">Home</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="#process">Our Process</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <!-- <div class="col-md-3 footer-links">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Disclosure</a></li>
                    </ul>
                </div> -->
            </div>
            <div class="copyright">
                <p>&copy; 2025 Canprosys Consultants Inc. | All rights reserved. | <a href="privacy-policy.html"
                        style="text-decoration: none; color: #ccc;">Privacy Policy</a></p>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    
    <script>
        // Mobile Menu Toggle
        const menuBtn = document.querySelector('.mobile-menu-btn');
        const nav = document.querySelector('nav');

        menuBtn.addEventListener('click', () => {
            nav.classList.toggle('active');
        });

        // Close mobile menu when clicking on a link
        const navLinks = document.querySelectorAll('nav ul li a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('active');
            });
        });

        // Back to top button
        window.addEventListener('scroll', function () {
            const backToTop = document.querySelector('.back-to-top');
            
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        // Smooth scrolling for back to top
        document.querySelector('.back-to-top').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Sticky header
        window.addEventListener('scroll', function () {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            } else {
                header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                header.style.background = 'white';
            }
        });
    </script>
</body>
</html>

<?php
// Helper function to calculate reading time
function reading_time($content) {
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    return max(1, $reading_time); // Minimum 1 minute
}

$conn->close();
?>