<?php
// ✅ Enable debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Connect to local XAMPP MySQL database
$servername = "srv1017.hstgr.io";
$username = "u868210921_OWGYP";
$password = "pQTZ0sfkdM";
$dbname = "u868210921_RXjAJ"; // ⚠️ Change this to your actual DB name

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
    <title>Explore Our Blog Section | Learn, Apply & Grow with Insights</title>
    <meta name="description"
        content="Unlock expert articles on marketing, design & technology. Learn what works, apply it & see results. Browse AaravTech Services blogs now and grow smarter today.">
    <link rel="canonical" href="https://aaravtech.net/blogs.html" />

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
            --bs-bg-dark: #0B011C;
            --bs-light: #F6F6FA;
            --gradient-bg: linear-gradient(180deg, #05000D 0%, #0B011C 20%, #14072D 45%, #1E0E45 70%, #2C1C6E 100%);
            --accent: #8A2BE2;
            --accent-light: #9D4EDD;
            --gradient-primary: linear-gradient(135deg, #8A2BE2 0%, #6A0DAD 100%);
            --gradient-secondary: linear-gradient(135deg, #1E0E45 0%, #2C1C6E 100%);
            --gradient-card: linear-gradient(145deg, rgba(30, 14, 69, 0.8) 0%, rgba(43, 28, 110, 0.6) 100%);
            --gradient-text: linear-gradient(90deg, #8A2BE2, #9D4EDD, #B66DF0);
            --gradient-pricing: linear-gradient(135deg, rgba(138, 43, 226, 0.1) 0%, rgba(30, 14, 69, 0.2) 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: var(--gradient-bg);
            color: var(--bs-light);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background: linear-gradient(180deg, rgba(11, 1, 28, 0.95) 0%, rgba(11, 1, 28, 0.8) 100%);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(138, 43, 226, 0.2);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.4s ease;
        }
        
        .breadcrumb-item {
            font-size: .8rem;
        }
        
        .breadcrumb-item a {
            color: var(--accent-light);
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: var(--bs-light);
        }
        
        /* Hero Section */
        .hero {
            padding: 140px 0 80px;
            position: relative;
            overflow: hidden;
            background: 
                radial-gradient(circle at 20% 80%, rgba(138, 43, 226, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(30, 14, 69, 0.1) 0%, transparent 50%),
                var(--gradient-bg);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.2) 0%, rgba(106, 13, 173, 0.1) 100%);
            color: var(--accent);
            padding: 10px 22px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            border: 1px solid rgba(138, 43, 226, 0.3);
            backdrop-filter: blur(10px);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(138, 43, 226, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(138, 43, 226, 0); }
            100% { box-shadow: 0 0 0 0 rgba(138, 43, 226, 0); }
        }
        
        .hero h1 {
            font-size: 60px;
            margin-bottom: 24px;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1px;
        }
        
        .hero h1 .gradient-text {
            background: var(--gradient-text);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            background-size: 200% auto;
            animation: textShine 3s linear infinite;
        }
        
        @keyframes textShine {
            to {
                background-position: 200% center;
            }
        }
        
        .hero p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 40px;
            color: rgba(246, 246, 250, 0.8);
            font-weight: 400;
        }
        
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 16px 38px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(138, 43, 226, 0.4);
        }

        /* Blog Section */
        .blog-section {
            padding: 100px 0;
            position: relative;
            background: 
                radial-gradient(circle at 0% 0%, rgba(138, 43, 226, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(30, 14, 69, 0.1) 0%, transparent 50%),
                var(--gradient-bg);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 70px;
        }
        
        .section-title h2 {
            font-size: 48px;
            color: var(--bs-light);
            margin-bottom: 16px;
            font-weight: 700;
        }
        
        .section-title h2 .gradient-text {
            background: var(--gradient-text);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: textShine 3s linear infinite;
        }
        
        .section-title p {
            color: rgba(246, 246, 250, 0.7);
            max-width: 700px;
            margin: 0 auto;
            font-size: 18px;
            font-weight: 400;
        }
        
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .blog-card {
            background: var(--gradient-card);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
            z-index: 1;
            backdrop-filter: blur(10px);
            height: 100%;
        }
        
        .blog-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.4s;
            z-index: -1;
        }
        
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: transparent;
        }
        
        .blog-card:hover::before {
            opacity: 0.05;
        }
        
        .blog-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 20px 20px 0 0;
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
            color: rgba(246, 246, 250, 0.7);
        }
        
        .blog-meta i {
            color: var(--accent);
            margin-right: 5px;
        }
        
        .blog-title {
            font-size: 20px;
            margin-bottom: 15px;
            color: var(--bs-light);
            font-weight: 600;
            line-height: 1.4;
        }
        
        .blog-excerpt {
            color: rgba(246, 246, 250, 0.7);
            margin-bottom: 20px;
            font-size: 15px;
            line-height: 1.6;
        }
        
        .read-more {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .read-more:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);
            color: white;
        }

        /* CTA Section */
        .cta-section {
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
            background: 
                radial-gradient(circle at 30% 70%, rgba(138, 43, 226, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 70% 30%, rgba(30, 14, 69, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, rgba(11, 1, 28, 0.9) 0%, rgba(30, 14, 69, 0.7) 100%);
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
            color: var(--bs-light);
            font-weight: 700;
            line-height: 1.2;
        }
        
        .cta-section p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 40px;
            color: rgba(246, 246, 250, 0.8);
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

    <!-- ✅ Spinner -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- ✅ Header -->
    <div class="container-fluid header position-relative p-0">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light px-lg-5 py-3 py-lg-0">
            <a href="/" class="navbar-brand p-0">
                <img src="img/company_logo_white.svg" alt="" id="toggleImg" style="transition: all ease .8s;">
            </a>
            <button class="navbar-toggler navbar-toggler-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="/" class="nav-item nav-link" style="color:var(--bs-white)!important">Home</a>
                    <a href="about.html" class="nav-item nav-link" style="color:var(--bs-white)!important">About</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                            style="color:var(--bs-white)!important">Services</a>
                        <div class="dropdown-menu m-0">
                            <div class="submenu-wrapper">
                                <a href="#" class="dropdown-item submenu-parent">Digital Marketing</a>
                                <div class="submenu ">
                                    <a class="dropdown-item " href="seo-company-in-india.html">SEO</a>
                                    <a class="dropdown-item" href="social-media-optimization-services.html">SMO/SMM</a>
                                    <a class="dropdown-item" href="best-ppc-marketing-agency.html">PPC</a>
                                    <a class="dropdown-item" href="content-marketing-services.html">Content
                                        Marketing</a>
                                </div>
                            </div>
                            <div class="submenu-wrapper">
                                <a href="#" class="dropdown-item submenu-parent">Web Development</a>
                                <div class="submenu ">
                                    <a class="dropdown-item" href="custom-website-development-services.html">Custom
                                        Website Development</a>
                                    <a class="dropdown-item" href="ui-ux-design-services.html">UI/UX Design</a>
                                    <a class="dropdown-item" href="web-and-mobile-app-development.html">Web/Mobile App
                                        Development</a>
                                </div>
                            </div>
                            <div class="submenu-wrapper">
                                <a href="logo-design-services.html" class="dropdown-item">Logo Design</a>
                            </div>
                            <div class="submenu-wrapper">
                                <a href="#" class="dropdown-item submenu-parent">BPO</a>
                                <div class="submenu ">
                                    <a class="dropdown-item" href="back-office-support-services.html">Back Office
                                        Support</a>
                                    <a class="dropdown-item" href="call-centre-services.html">Call Centre Services</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="blogs.php" class="nav-item nav-link active"
                        style="color:var(--bs-white)!important">Blogs</a>
                    <a href="career.php" class="nav-item nav-link"
                        style="color:var(--bs-white)!important">Career</a>
                    <a href="contact.html" class="nav-item nav-link"
                        style="color:var(--bs-white)!important">Contact</a>
                </div>
                <a href="tel:" class="glass-btn nav-link-btn"
                    style="margin-right:2rem;font-size:.8rem;padding:.8rem 1.6rem">Let's Talk</a>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero">
            <div class="container hero-content">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                </ol>
                <div class="hero-badge">
                    <i class="fas fa-blog"></i> Latest Insights
                </div>
                <h1 style="color:var(--bs-white)" >Our<span class="gradient-text"> Blogs</span></h1>
                <p>A place where new ideas meet practical insights. Discover our blogs to keep you informed and inspired.</p>
                <div class="hero-buttons">
                    <button class="btn-primary">Explore Articles <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </section>
    </div>

    <!-- ✅ Blog Section -->
    <section class="blog-section">
        <div class="container">
            <div class="section-title">
                <h2>Insights & Ideas for Your <span class="gradient-text">Digital Journey</span></h2>
                <p>Unlock expert articles on marketing, design & technology. Learn what works, apply it & see results.</p>
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
                        ?>
                        <div class="blog-card">
                            <?php if ($img_url): ?>
                                <img src="<?php echo $img_url; ?>" class="blog-image"
                                    alt="<?php echo htmlspecialchars($row['post_title']); ?>">
                            <?php else: ?>
                                <div class="blog-image" style="background: var(--gradient-primary); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-newspaper" style="font-size: 48px; color: white;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="fas fa-calendar-alt"></i> <?php echo date("F j, Y", strtotime($row['post_date'])); ?></span>
                                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($author); ?></span>
                                </div>
                                <h3 class="blog-title"><?php echo htmlspecialchars($row['post_title']); ?></h3>
                                <p class="blog-excerpt"><?php echo substr(strip_tags($row['post_content']), 0, 120); ?>...</p>
                                <a href="https://aaravtech.net/blogs/<?php echo $row['post_name']; ?>" class="read-more">Read More</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p style="color: rgba(246, 246, 250, 0.7); font-size: 18px;">No blogs found. Check back soon for new articles!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Stay Updated With Our Latest Insights</h2>
                <p>Subscribe to our newsletter and never miss out on the latest trends, tips, and industry insights that can help grow your business.</p>
                <div class="hero-buttons">
                    <button class="btn-primary">Subscribe to Newsletter <i class="fas fa-envelope"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ Footer -->
    <footer>
        <div class="container-fluid">
            <div class="footer-content">
                <div class="footer-column">
                    <div class="footer-logo">
                        <div class="footer-logo-text">AaravTechServices</div>
                    </div>
                    <p>We provide cutting-edge technology solutions to help businesses thrive in the digital age. Our team of experts delivers innovative software and consulting services.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="index.html"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="about.html"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="blogs.php"><i class="fas fa-chevron-right"></i> Blogs</a></li>
                        <li><a href="career.php"><i class="fas fa-chevron-right"></i>Career</a></li>
                        <li><a href="contact.html"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Our Services</h3>
                    <ul class="footer-links">
                        <li><a href="custom-website-development-services.html"><i class="fas fa-chevron-right"></i> Web Development</a></li>
                        <li><a href="web-and-mobile-app-development.html"><i class="fas fa-chevron-right"></i> Mobile Apps</a></li>
                        <li><a href="graphic-designing.html"><i class="fas fa-chevron-right"></i>Graphic Designing</a></li>
                        <li><a href="digital-marketing.html"><i class="fas fa-chevron-right"></i> Digital Marketing</a></li>
                        <li><a href="ui-ux-design-services.html"><i class="fas fa-chevron-right"></i> UI/UX Design</a></li>
                        <li><a href="bpo.html"><i class="fas fa-chevron-right"></i>BPO Services</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul class="contact-info">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Kanpur Nagar, Uttar Pradesh, India</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+91 7318083502</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>support@aaravtech.net</span>
                        </li>
                    </ul>
                    
                    <h4 style="margin-top: 20px; margin-bottom: 10px;">Newsletter</h4>
                    <p style="font-size: 0.9rem;">Subscribe to our newsletter for the latest updates.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 AaravTech. All Rights Reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Sitemap</a>
                </div>
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
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>

<?php $conn->close(); ?>