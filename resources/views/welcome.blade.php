<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UVO Writers</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    :root {
        --primary-color: #ff7b2b;
        --secondary-color: #4169e1;
        /* Royal Blue */
        --text-color: #333;
        --bg-color: #f5f5f5;
        --white: #fff;
        --black: #000;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-color);
        line-height: 1.6;
    }

    .header-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-left img {
        height: 50px;
    }

    nav ul {
        list-style: none;
        display: flex;
    }

    nav ul li {
        margin: 0 15px;
    }

    .nav-link {
        text-decoration: none;
        color: var(--black);
        font-weight: bold;
        font-size: 1.1em;
        padding: 10px 15px;
        background-color: var(--primary-color);
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .nav-link:hover {
        background-color: darken(var(--primary-color), 10%);
    }

    .header-right {
        display: flex;
        align-items: center;
    }

    .login-btn,
    .signup-btn {
        padding: 10px 20px;
        margin-left: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        font-size: 1em;
        transition: all 0.3s ease;
    }

    .login-btn {
        background-color: var(--white);
        color: var(--black);
        border: 2px solid var(--secondary-color);
    }

    .signup-btn {
        background-color: var(--secondary-color);
        color: var(--white);
    }

    .login-btn:hover,
    .signup-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .hamburger {
        display: none;
        cursor: pointer;
    }

    .hamburger span {
        display: block;
        width: 25px;
        height: 3px;
        background-color: var(--black);
        margin: 5px 0;
        transition: all 0.3s ease;
    }

    @media screen and (max-width: 768px) {
        nav ul {
            display: none;
        }

        .header-right {
            display: none;
        }

        .hamburger {
            display: block;
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }

        .hamburger.active span:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        nav.active ul {
            display: flex;
            flex-direction: column;
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            background-color: var(--white);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav.active ul li {
            margin: 10px 0;
        }

        .header-right.active {
            display: flex;
            flex-direction: column;
            position: absolute;
            top: 200px;
            left: 0;
            right: 0;
            background-color: var(--white);
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header-right.active button {
            margin: 10px 0;
            width: 100%;
        }
    }

    header {
        background-color: #fff;
        padding: 10px 0;
        border-bottom: 2px solid #eee;
    }

    .header-container {
        width: 90%;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-left img {
        height: 50px;
    }

    nav ul {
        list-style: none;
        display: flex;
    }

    nav ul li {
        margin: 0 15px;
    }

    nav ul li a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
        font-size: 1.1em;
    }

    .header-right {
        display: flex;
        align-items: center;
    }



    .hero {
        text-align: center;
        padding: 50px 20px;
        background-color: #fff;
    }

    .hero-content {
        max-width: 1200px;
        margin: 0 auto;
    }

    .hero h1 {
        font-size: 2.8em;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .hero p {
        font-size: 1.4em;
        margin-bottom: 40px;
    }

    .stats {
        display: flex;
        justify-content: space-around;
        margin-bottom: 30px;
    }

    .stat-item {
        text-align: center;
        font-size: 1.2em;
    }

    .stat-item i {
        font-size: 2.5em;
        color: #ff7b2b;
        margin-bottom: 10px;
    }

    .why-choose h2 {
        font-size: 2em;
        background-color: #9a86fd;
        color: #fff;
        display: inline-block;
        padding: 10px 20px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .features {
        background-color: #f5f5f5;
        padding: 40px 0;
    }

    .features-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .feature-item {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        width: 48%;
        margin-bottom: 20px;
    }

    .feature-item h3 {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: #ff7b2b;
    }

    .feature-item p {
        font-size: 1.1em;
    }

    .order-process {
        background-color: #fff;
        padding: 40px 0;
        text-align: center;
    }

    .order-process h2 {
        font-size: 2.5em;
        margin-bottom: 30px;
        color: #333;
    }

    .steps {
        display: flex;
        justify-content: space-around;
        max-width: 1200px;
        margin: 0 auto;
        flex-wrap: wrap;
    }

    .step-item {
        text-align: center;
        width: 20%;
        margin-bottom: 20px;
    }

    .step-item img,
    .step-item i {
        font-size: 3em;
        color: #ff7b2b;
        margin-bottom: 10px;
    }

    .step-item p {
        font-size: 1.2em;
    }

    .testimonial {
        background-color: #f5f5f5;
        padding: 40px 20px;
        text-align: center;
    }

    .testimonial h2 {
        font-size: 2.5em;
        margin-bottom: 20px;
    }

    .testimonial p {
        font-size: 1.3em;
        margin-bottom: 40px;
    }

    .subscribe {
        background-color: #ff7b2b;
        padding: 20px 0;
        text-align: center;
        color: #fff;
    }

    .subscribe-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
    }

    .subscribe input[type="email"] {
        padding: 10px 20px;
        font-size: 1em;
        border: none;
        border-radius: 5px 0 0 5px;
        width: 300px;
    }

    .subscribe button {
        padding: 10px 20px;
        background-color: #333;
        color: #fff;
        border: none;
        font-size: 1.1em;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }

    footer {
        background-color: #333;
        color: #fff;
        padding: 40px 0;
        text-align: center;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .footer-left img {
        height: 50px;
        margin-bottom: 20px;
    }

    .footer-middle,
    .footer-right {
        text-align: left;
    }

    .footer-middle ul {
        list-style: none;
    }

    .footer-middle ul li {
        margin-bottom: 10px;
        font-size: 1.1em;
    }

    .footer-right .social-icons i {
        margin: 0 10px;
        font-size: 1.5em;
        color: #ff7b2b;
    }

    .footer-right p {
        margin-bottom: 20px;
        font-size: 1.1em;
    }
</style>

<body>
    <header>
        <div class="header-container">
            <div class="header-left">
                <img src="images/logo.png" alt="UVO Writers Logo" style="height: 100px; width: auto" />
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
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Are you looking for a Skilled Academic Writer?</h1>
            <p>Look No Further—Your Solution Awaits!</p>
            <div class="stats">
                <div class="stat-item">
                    <i class="fas fa-shopping-cart"></i>
                    <p>
                        1000+ <br />
                        Completed Orders
                    </p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-user-check"></i>
                    <p>
                        250+ <br />
                        Qualified Writers
                    </p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-star"></i>
                    <p>
                        4.9 <br />
                        Writers Ratings
                    </p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-briefcase"></i>
                    <p>
                        500+ <br />
                        Employers
                    </p>
                </div>
            </div>
            <div class="why-choose">
                <h2>Why choose UVOWriters.com?</h2>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="features-container">
            <div class="feature-item">
                <h3>Streamlined Process</h3>
                <p>
                    Our user-friendly interface simplifies the task posting, bidding,
                    and work management process, saving you valuable time and effort.
                </p>
            </div>
            <div class="feature-item">
                <h3>Top-notch Writers</h3>
                <p>
                    Gain access to a diverse network of skilled writers, each ready to
                    produce exceptional academic content tailored to your specific
                    requirements.
                </p>
            </div>
            <div class="feature-item">
                <h3>Secure Transactions</h3>
                <p>
                    Rest assured with our secure payment options, ensuring that your
                    funds are managed safely and reliably.
                </p>
            </div>
            <div class="feature-item">
                <h3>24/7 Support</h3>
                <p>
                    Our client support and onboarding team are all to serve you best.
                    You have unlimited access to the team via phone, email, and live
                    chat.
                </p>
            </div>
            <div class="feature-item">
                <h3>Satisfaction Guaranteed</h3>
                <p>
                    We have the best writing orders management platform in terms of
                    customer satisfaction.
                </p>
            </div>
        </div>
    </section>

    <section class="order-process">
        <h2>How to Place an Order</h2>
        <div class="steps">
            <div class="step-item">
                <img src="create-order.png" alt="Create an Order" />
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
    </section>

    <section class="testimonial">
        <h2>Customers Are Talking About Our Writing Service</h2>
        <p>
            Discover what customers are saying about our essay writing services.
        </p>
    </section>

    <section class="subscribe">
        <div class="subscribe-container">
            <input type="email" placeholder="Email Address" />
            <button>Subscribe</button>
        </div>
    </section>

    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <img src="uvo-logo.png" alt="UVO Writers" />
                <p>
                    UVO Writers is the leading marketplace for academic writing
                    opportunities.
                </p>
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
