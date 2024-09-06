<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UVO Writers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #14a800;
            --secondary-color: #1f57c3;
            --text-color: #001e00;
            --bg-color: #ffffff;
            --light-bg: #f7f7f7;
            --border-color: #e4ebe4;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background-color: var(--bg-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo img {
            height: 40px;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-left: 25px;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            font-size: 0.95em;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .header-right button {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.95em;
            transition: all 0.3s ease;
        }

        .login-btn {
            background-color: transparent;
            color: var(--primary-color);
            margin-right: 10px;
            border: 1px solid var(--primary-color);
        }

        .signup-btn {
            background-color: var(--primary-color);
            color: white;
        }

        .login-btn:hover,
        .signup-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Hero Section Styles */
        .hero {
            background-color: var(--light-bg);
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.8em;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--text-color);
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 40px;
            color: var(--text-color);
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 50px;
        }

        .stat-item {
            text-align: center;
            background-color: var(--bg-color);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-item i {
            font-size: 2em;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stat-item p {
            font-size: 0.9em;
            font-weight: 600;
        }

        .why-choose h2 {
            font-size: 2em;
            color: var(--secondary-color);
            margin-top: 40px;
        }

        /* Features Section Styles */
        .features {
            padding: 80px 0;
            background-color: var(--bg-color);
        }

        .features-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .feature-item {
            background-color: var(--light-bg);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .feature-item h3 {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }

        .feature-item p {
            font-size: 0.95em;
            color: var(--text-color);
        }

        /* Order Process Styles */
        .order-process {
            background-color: var(--light-bg);
            padding: 80px 0;
            text-align: center;
        }

        .order-process h2 {
            font-size: 2.2em;
            margin-bottom: 50px;
            color: var(--secondary-color);
        }

        .steps {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 30px;
        }

        .step-item {
            flex-basis: calc(25% - 30px);
            text-align: center;
            background-color: var(--bg-color);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .step-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .step-item img,
        .step-item i {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .step-item p {
            font-size: 1em;
            font-weight: 500;
        }

        /* Testimonial Section Styles */
        .testimonial {
            background-color: var(--bg-color);
            padding: 80px 0;
            text-align: center;
        }

        .testimonial h2 {
            font-size: 2.2em;
            margin-bottom: 20px;
            color: var(--secondary-color);
        }

        .testimonial p {
            font-size: 1.1em;
            margin-bottom: 40px;
            color: var(--text-color);
        }

        /* Subscribe Section Styles */
        .subscribe {
            background-color: var(--primary-color);
            padding: 60px 0;
            text-align: center;
        }

        .subscribe-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .subscribe input[type="email"] {
            padding: 15px 20px;
            font-size: 1em;
            border: none;
            border-radius: 25px;
            width: 300px;
            outline: none;
        }

        .subscribe button {
            padding: 15px 30px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .subscribe button:hover {
            background-color: #1a4da8;
        }

        /* Footer Styles */
        footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
        }

        .footer-left img {
            height: 40px;
            margin-bottom: 20px;
        }

        .footer-left p,
        .footer-middle p,
        .footer-right p {
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .footer-middle h3,
        .footer-right h3 {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .footer-middle ul {
            list-style: none;
        }

        .footer-middle ul li {
            margin-bottom: 10px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icons i {
            font-size: 1.5em;
            color: white;
            transition: color 0.3s ease;
        }

        .social-icons i:hover {
            color: var(--primary-color);
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .header-container {
                flex-direction: column;
                align-items: flex-start;
            }

            nav ul {
                flex-direction: column;
                margin-top: 20px;
            }

            nav ul li {
                margin: 10px 0;
            }

            .header-right {
                margin-top: 20px;
            }

            .stats {
                flex-wrap: wrap;
            }

            .step-item {
                flex-basis: calc(50% - 30px);
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1000;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5);
            /* Black with opacity */
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        /* Modal Content */
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            transition: transform 0.3s ease, opacity 0.3s ease;
            transform: translateY(-50px);
            opacity: 0;
        }

        /* Modal Header */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
        }

        /* Modal Buttons */
        .modal-content button {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 15px 25px;
            margin: 10px 5px;
            border-radius: 25px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-content button:hover {
            background-color: #1a4da8;
        }
    </style>
</head>

<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="images/logo.png" alt="UVO Writers Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="#" class="nav-link">Our Services</a></li>
                    <li><a href="#" class="nav-link">How it Works</a></li>
                    <li><a href="#" class="nav-link">Top Writers</a></li>
                    <li><a href="#" class="nav-link">About Us</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <button class="login-btn">Log In</button>
                <button class="signup-btn">Sign Up</button>
            </div>
            <!-- Login Modal -->
            <div id="loginModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Log In</h2>
                    <button onclick="window.location.href='http://localhost:8000/writer/login';">Log In as
                        Writer</button>
                    <button onclick="window.location.href='http://localhost:8000/employer/login';">Log In as
                        Employer</button>
                </div>
            </div>

            <!-- Sign Up Modal -->
            <div id="signupModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Sign Up</h2>
                    <button onclick="window.location.href='http://localhost:8000/writer/register';">Sign Up as
                        Writer</button>
                    <button onclick="window.location.href='http://localhost:8000/employer/register';">Sign Up as
                        Employer</button>
                </div>
            </div>

        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Are you looking for a Skilled Academic Writer?</h1>
            <p>Look No Further—Your Solution Awaits!</p>
            <div class="stats">
                <div class="stat-item">
                    <i class="fas fa-shopping-cart"></i>
                    <p>1000+<br>Completed Orders</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-user-check"></i>
                    <p>250+<br>Qualified Writers</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-star"></i>
                    <p>4.9<br>Writers Ratings</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-briefcase"></i>
                    <p>500+<br>Employers</p>
                </div>
            </div>
            <div class="why-choose">
                <h2>Why choose UVOWriters.com?</h2>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container features-container">
            <div class="feature-item">
                <h3>Streamlined Process</h3>
                <p>Our user-friendly interface simplifies the task posting, bidding, and work management process, saving
                    you valuable time and effort.</p>
            </div>
            <div class="feature-item">
                <h3>Top-notch Writers</h3>
                <p>Gain access to a diverse network of skilled writers, each ready to produce exceptional academic
                    content tailored to your specific requirements.</p>
            </div>
            <div class="feature-item">
                <h3>Secure Transactions</h3>
                <p>Rest assured with our secure payment options, ensuring that your funds are managed safely and
                    reliably.</p>
            </div>
            <div class="feature-item">
                <h3>24/7 Support</h3>
                <p>Our client support and onboarding team are all to serve you best. You have unlimited access to the
                    team via phone, email, and live chat.</p>
            </div>
            <div class="feature-item">
                <h3>Satisfaction Guaranteed</h3>
                <p>We have the best writing orders management platform in terms of customer satisfaction.</p>
            </div>
        </div>
    </section>

    <section class="order-process">
        <div class="container">
            <h2>How to Place an Order</h2>
            <div class="steps">
                <div class="step-item">
                    <img src="create-order.png" alt="Create an Order">
                    <p>Create an Order</p>
                </div>
                <div class="step-item">
                    <i class="fas fa-pencil-alt"></i>
                    <p>Provide Order Instructions</p>
                </div>
                <div class="step-item">
                    <i class="fas fa-file-alt"></i>
                    <p>Receive Your Completed Paper</p>
                </div>
                <div class="step-item">
                    <i class="fas fa-star"></i>
                    <p>Rate Your Writer</p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonial">
        <div class="container">
            <h2>Customers Are Talking About Our Writing Service</h2>
            <p>Discover what customers are saying about our essay writing services.</p>
            <!-- You can add actual testimonials here -->
        </div>
    </section>

    <section class="subscribe">
        <div class="container subscribe-container">
            <input type="email" placeholder="Enter your email address">
            <button>Subscribe</button>
        </div>
    </section>

    <footer>
        <div class="container footer-container">
            <div class="footer-left">
                <img src="uvo-logo-white.png" alt="UVO Writers">
                <p>UVO Writers is the leading marketplace for academic writing opportunities.</p>
            </div>
            <div class="footer-middle">
                <h3>Our Services</h3>
                <ul>
                    <li>Dissertation Writing</li>
                    <li>Research Paper Writing</li>
                    <li>Term Paper Writing</li>
                    <li>College Essay Writing</li>
                    <li>Thesis Writing Service</li>
                </ul>
            </div>
            <div class="footer-right">
                <h3>Contact Us</h3>
                <p>Email: support@uvowriters.com</p>
                <p>Phone: 0768798766 | 0727797150</p>
                <div class="social-icons">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-linkedin"></i>
                    <i class="fab fa-instagram"></i>
                </div>
            </div>
        </div>
    </footer>
    <script>
        // Get the modals
        const loginModal = document.getElementById("loginModal");
        const signupModal = document.getElementById("signupModal");

        // Get the buttons that open the modals
        const loginBtn = document.querySelector(".login-btn");
        const signupBtn = document.querySelector(".signup-btn");

        // Get the <span> elements that close the modals
        const spanCloseLogin = loginModal.querySelector(".close");
        const spanCloseSignup = signupModal.querySelector(".close");

        // When the user clicks on the button, open the modal
        loginBtn.onclick = function() {
            loginModal.style.display = "block";
            setTimeout(() => {
                loginModal.style.opacity = "1";
                loginModal.querySelector(".modal-content").style.transform = "translateY(0)";
                loginModal.querySelector(".modal-content").style.opacity = "1";
            }, 10);
        }

        signupBtn.onclick = function() {
            signupModal.style.display = "block";
            setTimeout(() => {
                signupModal.style.opacity = "1";
                signupModal.querySelector(".modal-content").style.transform = "translateY(0)";
                signupModal.querySelector(".modal-content").style.opacity = "1";
            }, 10);
        }

        // When the user clicks on <span> (x), close the modal
        spanCloseLogin.onclick = function() {
            loginModal.style.opacity = "0";
            loginModal.querySelector(".modal-content").style.transform = "translateY(-50px)";
            loginModal.querySelector(".modal-content").style.opacity = "0";
            setTimeout(() => {
                loginModal.style.display = "none";
            }, 300);
        }

        spanCloseSignup.onclick = function() {
            signupModal.style.opacity = "0";
            signupModal.querySelector(".modal-content").style.transform = "translateY(-50px)";
            signupModal.querySelector(".modal-content").style.opacity = "0";
            setTimeout(() => {
                signupModal.style.display = "none";
            }, 300);
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == loginModal) {
                spanCloseLogin.click();
            }
            if (event.target == signupModal) {
                spanCloseSignup.click();
            }
        }
    </script>

    <script>
        const hamburger = document.querySelector(".hamburger");
        const nav = document.querySelector("nav");
        const headerRight = document.querySelector(".header-right");

        hamburger.addEventListener("click", () => {
            hamburger.classList.toggle("active");
            nav.classList.toggle("active");
            headerRight.classList.toggle("active");
        });
    </script>
</body>

</html>
