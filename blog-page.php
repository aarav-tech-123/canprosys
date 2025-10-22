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
<title><?php echo htmlspecialchars($blog['post_title']); ?> | AaravTech Blog</title>
<meta name="description" content="<?php echo substr(strip_tags($blog['post_content']), 0, 150); ?>">
<link rel="canonical" href="https://aaravtech.net/blog-page.php?id=<?php echo $blog_id; ?>" />
 
    <!-- CSS -->
<link href="https://aaravtech.net/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://aaravtech.net/css/style.css">
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
        --bs-bg-light: #FFFFFF;
        --bs-dark: #1A1A2E;
        --bs-text-primary: #2D3748;
        --bs-text-secondary: #4A5568;
        --bs-text-muted: #718096;
        --accent: #8A2BE2;
        --accent-light: #9D4EDD;
        --accent-lighter: #E9D8FD;
        --gradient-bg: linear-gradient(180deg, #05000D 0%, #0B011C 20%, #14072D 45%, #1E0E45 70%, #2C1C6E 100%);
        --gradient-primary: linear-gradient(135deg, #8A2BE2 0%, #6A0DAD 100%);
        --gradient-light: linear-gradient(135deg, #F7FAFC 0%, #EDF2F7 100%);
        --gradient-card: linear-gradient(145deg, #FFFFFF 0%, #F7FAFC 100%);
        --gradient-text: linear-gradient(90deg, #8A2BE2, #9D4EDD, #B66DF0);
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --border-light: 1px solid #E2E8F0;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }
    
    body {
        background: var(--bs-bg-light);
        color: var(--bs-text-primary);
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
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-bottom: var(--border-light);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        transition: all 0.4s ease;
        box-shadow: var(--shadow-sm);
    }
    
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
    }
    
    .logo {
        display: flex;
        align-items: center;
        font-weight: 800;
        font-size: 28px;
        color: var(--bs-dark);
        text-decoration: none;
        letter-spacing: -0.5px;
    }
    
    .logo span {
        background: var(--gradient-text);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
    }
    
    nav ul {
        display: flex;
        list-style: none;
    }
    
    nav ul li {
        margin-left: 32px;
    }
    
    nav ul li a {
        text-decoration: none;
        color: var(--bs-text-primary);
        font-weight: 500;
        transition: all 0.3s;
        position: relative;
        padding: 8px 0;
        font-size: 16px;
    }
    
    nav ul li a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gradient-text);
        transition: width 0.3s ease;
    }
    
    nav ul li a:hover::after,
    nav ul li a.active::after {
        width: 100%;
    }
    
    nav ul li a:hover,
    nav ul li a.active {
        color: var(--accent);
    }
    
    .cta-button {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }
    
    .cta-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .cta-button:hover::before {
        left: 100%;
    }
    
    .cta-button:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    /* Blog Hero Section */
    .blog-hero {
        padding: 180px 0 80px;
        position: relative;
        overflow: hidden;
        background: 
            radial-gradient(circle at 20% 80%, rgba(138, 43, 226, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(30, 14, 69, 0.1) 0%, transparent 50%),
            var(--gradient-bg);
        text-align: center;
        border-bottom: var(--border-light);
    }

    .blog-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 20px 20px 0 0;
    }

    .blog-hero-badge {
        display: inline-flex;
        align-items: center;
        background: var(--accent-lighter);
        color: var(--accent);
        padding: 10px 22px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 24px;
        border: 1px solid rgba(138, 43, 226, 0.2);
        box-shadow: var(--shadow-sm);
    }
    
    .blog-hero h1 {
        font-size: 48px;
        margin-bottom: 24px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -1px;
        color: var(--bs-light);
    }
    
    .blog-hero h1 .gradient-text {
        background: var(--gradient-text);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
        background-size: 200% auto;
        animation: textShine 3s linear infinite;
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
        
    
    @keyframes textShine {
        to {
            background-position: 200% center;
        }
    }
    
    .blog-meta {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        color: var(--bs-text-muted);
        font-size: 16px;
        margin-bottom: 40px;
    }
    
    .blog-meta i {
        color: var(--accent);
        margin-right: 8px;
    }
    
    /* Blog Content Section */
    .blog-content-section {
        position: relative;
        background: var(--bs-bg-light);
    }
    
    .blog-content-wrapper {
        max-width: 900px;
        margin: 0 auto;
        background: var(--gradient-card);
        border-radius: 20px;
        padding: 50px;
        transition: transform 0.3s ease;
    }
    
    /* .blog-content-wrapper:hover {
        transform: translateY(-5px);
    } */
    
    .blog-featured-image {
        width: 100%;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: var(--shadow-md);
    }
    
    .blog-content {
        font-size: 18px;
        line-height: 1.8;
        color: var(--bs-text-primary);
    }
    
    .blog-content h1,
    .blog-content h2,
    .blog-content h3,
    .blog-content h4 {
        color: var(--bs-dark);
        margin: 30px 0 20px;
        font-weight: 600;
    }
    
    .blog-content h1 {
        font-size: 32px;
        border-bottom: 2px solid var(--accent-lighter);
        padding-bottom: 10px;
    }
    
    .blog-content h2 {
        font-size: 28px;
    }
    
    .blog-content h3 {
        font-size: 24px;
    }
    
    .blog-content p {
        margin-bottom: 20px;
        color: var(--bs-text-secondary);
    }
    
    .blog-content a {
        color: var(--accent);
        text-decoration: none;
        transition: all 0.3s;
        font-weight: 500;
    }
    
    .blog-content a:hover {
        color: var(--accent-light);
        text-decoration: underline;
    }
    
    .blog-content ul,
    .blog-content ol {
        margin: 20px 0;
        padding-left: 30px;
        color: var(--bs-text-secondary);
    }
    
    .blog-content li {
        margin-bottom: 10px;
    }
    
    .blog-content blockquote {
        border-left: 4px solid var(--accent);
        padding: 20px 20px 20px 30px;
        margin: 30px 0;
        font-style: italic;
        color: var(--bs-text-secondary);
        background: var(--accent-lighter);
        border-radius: 0 10px 10px 0;
        box-shadow: var(--shadow-sm);
    }
    
    .blog-content code {
        background: var(--accent-lighter);
        padding: 2px 6px;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        color: var(--accent);
    }
    
    .blog-content pre {
        background: var(--bs-dark);
        color: white;
        padding: 20px;
        border-radius: 10px;
        overflow-x: auto;
        margin: 20px 0;
        box-shadow: var(--shadow-md);
    }
    
    /* CTA Section */
    .cta-section {
        padding: 80px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
        background: var(--gradient-light);
        border-top: var(--border-light);
    }
    
    .cta-content {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    
    .cta-section h2 {
        font-size: 36px;
        margin-bottom: 20px;
        color: var(--bs-dark);
        font-weight: 700;
        line-height: 1.2;
    }
    
    .cta-section p {
        font-size: 18px;
        max-width: 600px;
        margin: 0 auto 30px;
        color: var(--bs-text-secondary);
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
        box-shadow: var(--shadow-md);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        position: relative;
        overflow: hidden;
        text-decoration: none;
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
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
        text-decoration: none;
    }
    
    
    
    /* Back to Top Button */
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: var(--gradient-primary);
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
    }
    
    .back-to-top:hover {
        transform: translateY(-3px);
        color: white;
    }
    
    /* Responsive Design */
    @media (max-width: 1100px) {
        .blog-hero h1 {
            font-size: 42px;
        }
        
        .cta-section h2 {
            font-size: 32px;
        }
    }
    
    @media (max-width: 768px) {
        .header-container {
            flex-direction: column;
            padding: 15px 0;
        }
        
        nav ul {
            margin: 20px 0 15px;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        nav ul li {
            margin: 8px 12px;
        }
        
        .blog-hero {
            padding: 150px 0 60px;
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
        
        .cta-section h2 {
            font-size: 28px;
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
            font-size: 24px;
        }
        
        .blog-content {
            font-size: 16px;
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
    <!-- Header -->
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
        <div class="container-fluid header position-relative p-0">
            <nav class="navbar navbar-expand-lg fixed-top navbar-light px-lg-5 py-3 py-lg-0">
                <a href="https://aaravtech.net/" class="navbar-brand p-0">
                    <img src="https://aaravtech.net/img/company_logo_white.svg" alt="" id="toggleImg" style="transition: all ease .8s;" >
                </a>
                <button class="navbar-toggler navbar-toggler-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="https://aaravtech.net/" class="nav-item nav-link " style="color:var(--bs-white) !important" >Home</a>
                        <a href="https://aaravtech.net/about.html" class="nav-item nav-link navlink-white" style="color:var(--bs-white) !important" >About</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="color:var(--bs-white) !important" >Services</a>
                            <div class="dropdown-menu m-0">
                                <div class="submenu-wrapper">
                                    <a href="#" class="dropdown-item submenu-parent">Digital Marketing</a>
                                    <div class="submenu ">
                                        <a class="dropdown-item " href="https://aaravtech.net/seo-company-in-india.html">SEO</a>
                                        <a class="dropdown-item" href="https://aaravtech.net/social-media-optimization-services.html">SMO/SMM</a>
                                        <a class="dropdown-item" href="https://aaravtech.net/best-ppc-marketing-agency.html">PPC</a>
                                        <a class="dropdown-item" href="https://aaravtech.net/content-marketing-services.html">Content Marketing</a>
                                    </div>
                                </div>
                                <div class="submenu-wrapper">
                                    <a href="#" class="dropdown-item submenu-parent">Web Development</a>
                                    <div class="submenu ">
                                        <a class="dropdown-item" href="https://aaravtech.net/custom-website-development-services.html">Custom Website Development</a>
                                        <a class="dropdown-item" href="https://aaravtech.net/ui-ux-design-services.html">UI/UX Design</a>
                                        <a class="dropdown-item" href="https://aaravtech.net/web-and-mobile-app-development.html">Web/Mobile App Development</a>
                                    </div>
                                </div>
                                <div class="submenu-wrapper">
                                    <a href="https://aaravtech.net/logo-design-services.html" class="dropdown-item">Logo Design</a>
                                </div>
                                <div class="submenu-wrapper">
                                    <a href="#" class="dropdown-item submenu-parent">BPO</a>
                                    <div class="submenu ">
                                        <a class="dropdown-item" href="https://aaravtech.net/back-office-support-services.html">Back Office Support</a>
                                        <a class="dropdown-item" href="https://aaravtech.net/call-centre-services.html">Call Centre Services</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="https://aaravtech.net/blogs.php" class="nav-item nav-link " style="color:var(--bs-white) !important" >Blogs</a>
                        <a href="https://aaravtech.net/career.php" class="nav-item nav-link" style="color:var(--bs-white) !important" >Career</a>
                        <a href="https://aaravtech.net/contact.html" class="nav-item nav-link" style="color:var(--bs-white) !important" >Contact</a>
                    </div>
                    <a href="tel:" class="glass-btn nav-link-btn" style="margin-right: 2rem; font-size: .8rem; padding:.8rem 1.6rem">Let's Talk</a>            </div>
            </nav>
            <!-- Blog Hero Section -->

            <section class="blog-hero">
                <div class="container">
                    <div class="hero-badge">
                        <i class="fas fa-newspaper"></i> Blos Post
                    </div>
                    <h1><?php echo htmlspecialchars($blog['post_title']); ?></h1>
                    <div class="blog-meta">
                        <span><i class="fas fa-calendar-alt"></i> <?php echo date("F j, Y", strtotime($blog['post_date'])); ?></span>
                        <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($author); ?></span>
                    </div>
                </div>
            </section>
        </div>

        <!-- Blog Content Section -->
        <section class="blog-content-section">
            <div class="container">
                <?php if ($img_url): ?>
                    <img src="<?php echo $img_url; ?>" class="blog-image"
                    alt="<?php echo htmlspecialchars($row['post_title']); ?>">
                <?php else: ?>
                <div class="blog-content-wrapper">
                        <div class="blog-image" style="background: var(--gradient-primary); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-newspaper" style="font-size: 48px; color: white;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="blog-content">
                        <?php echo $blog['post_content']; ?>
                    </div>
                    
                    <!-- Blog Tags -->
                    <!-- <div class="blog-tags mt-5 pt-4 border-top">
                        <strong class="text-dark me-3">Tags:</strong>
                        <span class="badge bg-light text-dark border me-2">Digital Marketing</span>
                        <span class="badge bg-light text-dark border me-2">SEO</span>
                        <span class="badge bg-light text-dark border me-2">Web Development</span>
                    </div> -->
                </div>
            </div>
        </section>

 
    <!-- Call To Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to boost your business growth?</h2>
                <p>Contact us today to get your digital strategy started and take your business to the next level with our expert services.</p>
                <a href="https://aaravtech.net/contact.html" class="btn-primary">Get Started <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>
 
    <!-- Footer -->
    <footer>
        <div class="footer-shape">
        </div>
        
        <div class="container-fluid footer-container" style="padding: 0 2rem;">
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
                        <li><a href="https://aaravtech.net/index.html"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="https://aaravtech.net/about.html"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="https://aaravtech.net/blogs.php"><i class="fas fa-chevron-right"></i> Blogs</a></li>
                        <li><a href="https://aaravtech.net/career.php"><i class="fas fa-chevron-right"></i>Career</a></li>
                        <li><a href="https://aaravtech.net/contact.html"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Our Services</h3>
                    <ul class="footer-links">
                        <li><a href="https://aaravtech.net/custom-website-development-services.html"><i class="fas fa-chevron-right"></i> Web Development</a></li>
                        <li><a href="https://aaravtech.net/web-and-mobile-app-development.html"><i class="fas fa-chevron-right"></i> Mobile Apps</a></li>
                        <li><a href="https://aaravtech.net/graphic-designing.html"><i class="fas fa-chevron-right"></i>Graphic Designing</a></li>
                        <li><a href="https://aaravtech.net/digital-marketing.html"><i class="fas fa-chevron-right"></i> Digital Marketing</a></li>
                        <li><a href="https://aaravtech.net/ui-ux-design-services.html"><i class="fas fa-chevron-right"></i> UI/UX Design</a></li>
                        <li><a href="https://aaravtech.net/bpo.html"><i class="fas fa-chevron-right"></i>BPO Services</a></li>
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
    <script src="https://aaravtech.net/js/main.js"></script>
    
    <script>
        window.addEventListener('scroll', function () {
            const backToTop = document.querySelector('.back-to-top');
            
            if (window.scrollY > 50) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        });
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
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
    </script>
</body>
</html>
<?php
    $conn->close();
?>