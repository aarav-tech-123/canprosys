<?php
// ✅ Enable debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Connect to local XAMPP MySQL database
$servername = "localhost";
$username = "u450081634_rRd7c";
$password = "4mh0ICUE0Z";
$dbname = "u450081634_XudLt"; // ⚠️ Change this to your actual DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Fetch published blog posts
$sql = "SELECT ID, post_title, post_content, post_date, post_author,post_name
        FROM wp_posts
        WHERE post_type='post' AND post_status='publish'
        ORDER BY post_date DESC";
$result = $conn->query($sql);

if ($result === false) {
    die("❌ SQL Error: " . $conn->error);
}

// // Create an array to store data
// $data = [];

// if ($result && $result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $data[] = $row;
//     }
// }

// // Convert to JSON
// $jsonData = json_encode($data);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <title>Tax & Financial Insights Blog | Canprosys Consultants Inc.</title>
    <meta name="description"
        content="Expert tax advice, financial insights, and CRA updates from Canprosys Consultants Inc. Stay informed with our professional tax and accounting blog.">
    <link rel="canonical" href="https://canprosys.com/blogs.php" />

    <!-- ✅ Styles & Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
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
            padding:15px 20px;
        }

        /* Header Styles */
       
        
        /* Hero Section */
        .hero {
            padding: 140px 0 80px;
            position: relative;
            overflow: hidden;
            background: 
                linear-gradient(135deg, var(--primary) 0%, #2c3e50 100%);
            color: white;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            p{
                text-align:center;
            }
        }
        
        .hero-badge {
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
        
        .hero h1 {
            font-size: 60px;
            margin-bottom: 24px;
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -1px;
            color: var(--bs-light);
        }
        
        .hero h1 .highlight {
            color: var(--secondary);
        }
        
        .hero p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 40px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 400;
        }
        
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
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
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(211, 84, 0, 0.4);
            background: #e74c3c;
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 16px 38px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
        }
        
        .btn-outline:hover {
            background: white;
            color: var(--primary);
        }

        /* Blog Section */
        .blog-section {
            padding: 100px 0;
            position: relative;
            background: var(--light);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 70px;
        }
        
        .section-title h2 {
            font-size: 48px;
            color: var(--dark);
            margin-bottom: 16px;
            font-weight: 700;
            text-align:center;
        }
        
        .section-title h2 .highlight {
            color: var(--primary);
        }
        
        .section-title p {
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
            font-size: 18px;
            font-weight: 400;
            text-align:center;
        }
        
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .blog-card {
            background: white;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
            z-index: 1;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }
        
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .blog-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }
        
        .blog-content {
            padding: 30px;
        }
        
        .blog-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 14px;
            color: var(--gray);
        }
        
        .blog-meta i {
            color: var(--primary);
            margin-right: 5px;
        }
        
        .blog-title {
            font-size: 20px;
            margin-bottom: 15px;
            color: var(--dark);
            font-weight: 600;
            line-height: 1.4;
        }
        
        .blog-excerpt {
            color: var(--gray);
            margin-bottom: 20px;
            font-size: 15px;
            line-height: 1.6;
        }
        
        .read-more {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .read-more:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(26, 79, 140, 0.2);
        }
        
        .category-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--secondary);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 2;
        }

        /* CTA Section */
        .cta-section {
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
            background: 
                linear-gradient(135deg, var(--primary) 0%, #2c3e50 100%);
            color: white;
        }
        
        .cta-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .cta-section h2 {
            font-size: 48px;
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
        
        .newsletter-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
            gap: 10px;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
        }
        
        .newsletter-form button {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .newsletter-form button:hover {
            background: #e74c3c;
        }

        
        /* Responsive Design */
        @media (max-width: 1100px) {
            .hero h1 {
                font-size: 50px;
            }
            
            .section-title h2 {
                font-size: 42px;
            }
            
            .cta-section h2 {
                font-size: 42px;
            }
        }

        
        @media (max-width: 768px) {
            .hero {
                padding: 120px 0 60px;
            }
            
            .hero h1 {
                font-size: 40px;
            }
            
            .hero p {
                font-size: 18px;
            }
            
            .section-title h2 {
                font-size: 36px;
            }
            
            .cta-section h2 {
                font-size: 36px;
            }
            
            .blog-grid {
                grid-template-columns: 1fr;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }
        
        @media (max-width: 576px) {
            .hero h1 {
                font-size: 36px;
            }
            
            .section-title h2 {
                font-size: 32px;
            }
            
            .cta-section h2 {
                font-size: 32px;
            }
        }
    </style>
    <!-- ✅ Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MSPXHW6R');
    </script>
</head>

<body>
    <!-- ✅ Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSPXHW6R" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>



    <!-- ✅ Header -->
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
                    <li><a href="/" >Home</a></li>
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
                    <li><a href="blogs.php" class="active">Blogs</a></li>
                    <li><a href="index.html#testimonials">Testimonials</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>

     <!-- Hero Section -->
        <section class="hero">
            <div class="container hero-content" >
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                </ol>
                <div class="hero-badge">
                    <i class="fas fa-blog"></i> Tax & Financial Insights
                </div>
                <h1>Canprosys <span class="highlight">Blog</span></h1>
                <p>Expert tax advice, financial insights, and CRA updates to help you navigate Canada's complex tax landscape.</p>
                <div class="hero-buttons">
                    <a href="contact.html" class="btn-outline">Book Consultation <i class="fas fa-calendar-check"></i></a>
                </div>
            </div>
        </section>

    <!-- ✅ Blog Section -->
    <section class="blog-section">
        <div class="container">
            <div class="section-title">
                <h2>Tax & Financial <span class="highlight">Insights</span></h2>
                <p>Stay informed with expert articles on tax obligations, CRA procedures, financial planning, and more.</p>
            </div>
            
            <div class="blog-grid">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        $author_id = $row['post_author'];
                        $author_result = $conn->query("SELECT display_name FROM wp_users WHERE ID = $author_id");
                        $author = ($author_result && $author_result->num_rows > 0)
                            ? $author_result->fetch_assoc()['display_name']
                            : "Unknown";

                        $image_result = $conn->query("
                            SELECT meta_value FROM wp_postmeta
                            WHERE post_id = {$row['ID']} AND meta_key = '_thumbnail_id' LIMIT 1
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
                        
                        // Determine category based on content
                        $content = strtolower($row['post_content']);
                        $category = "Tax Tips";
                        if (strpos($content, 'cra') !== false || strpos($content, 'revenue') !== false) {
                            $category = "CRA Updates";
                        } elseif (strpos($content, 'debt') !== false) {
                            $category = "Debt Relief";
                        } elseif (strpos($content, 'financial') !== false || strpos($content, 'accounting') !== false) {
                            $category = "Financial Planning";
                        }
                        ?>
                        <div class="blog-card">
                            <div class="category-tag"><?php echo $category; ?></div>
                            <?php if ($img_url): ?>
                                <img src="<?php echo $img_url; ?>" class="blog-image"
                                    alt="<?php echo htmlspecialchars($row['post_title']); ?>">
                            <?php else: ?>
                                <div class="blog-image" style="background: var(--primary); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-file-alt" style="font-size: 48px; color: white;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="fas fa-calendar-alt"></i> <?php echo date("F j, Y", strtotime($row['post_date'])); ?></span>
                                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($author); ?></span>
                                </div>
                                <h3 class="blog-title"><?php echo htmlspecialchars($row['post_title']); ?></h3>
                                <p class="blog-excerpt"><?php echo substr(strip_tags($row['post_content']), 0, 120); ?>...</p>
                                <a href="https://canprosys.com/blogs/<?php echo $row['post_name']; ?>" class="read-more">Read More</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p style="color: var(--gray); font-size: 18px;">No blogs found. Check back soon for new articles!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Need Help With Your Tax Obligations?</h2>
                <p>Our team of tax experts and former CRA advisors can help you resolve tax issues, reduce penalties, and find financial relief.</p>
                <div class="hero-buttons">
                    <button class="btn-primary">Book Consultation <i class="fas fa-calendar-check"></i></button>
                    <button class="btn-outline">Call Us Now <i class="fas fa-phone"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ Footer -->
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

    <!-- ✅ Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="js/main.js"></script>
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

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
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

<?php $conn->close(); ?>