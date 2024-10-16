<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Auth::user()->name }} Writers Dashboard</title>
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #28a745;
            --light-green: #d4edda;
            --white: #FFFFFF;
            --dark-gray: #333333;
            --deep-orange: #FF5722;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-green);
            color: var(--dark-gray);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--white);
            color: var(--dark-gray);
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1001;
            /* Ensure sidebar is above other elements */
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            color: var(--green);
        }

        .logo img {
            width: 40px;
            height: auto;
            margin-right: 0.5rem;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--dark-gray);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .nav-links {
            list-style: none;
            padding-left: 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--dark-gray);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-link:hover {
            background-color: var(--green);
            color: var(--white);
        }

        .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
            color: var(--green);
            transition: color 0.3s ease;
        }

        .nav-link:hover i {
            color: var(--white);
        }

        .main-content {
            margin-left: 250px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        .top-bar {
            background-color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 1000;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: var(--light-green);
            border-radius: 2rem;
            padding: 0.5rem 1rem;
            flex: 1;
            max-width: 300px;
        }

        .middle-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            /* Increased gap between items */
            flex: 2;
        }

        .action-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.7rem;
            /* Reduced the font size of the text */
            color: var(--dark-gray);
            position: relative;
        }

        .action-item .icon {
            font-size: 0.9rem;
            /* Reduced icon size */
            color: var(--green);
            margin-bottom: 0.2rem;
            /* Reduced space below the icon */
        }

        .action-item .value {
            font-size: 0.7rem;
            /* Smaller font for values */
            font-weight: 500;
            margin-bottom: 0.1rem;
            /* Reduced space below the value */
            display: flex;
            align-items: center;
        }

        .action-item .label {
            font-size: 0.6rem;
            /* Smaller font for labels */
            color: var(--dark-gray);
        }

        .search-bar input {
            border: none;
            background: none;
            margin-left: 0.5rem;
            font-size: 0.9rem;
            color: var(--dark-gray);
            outline: none;
        }

        .middle-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            /* Increased gap between items */
            flex: 2;
        }

        .action-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.7rem;
            /* Reduced the font size of the text */
            color: var(--dark-gray);
            position: relative;
        }

        .action-item .icon {
            font-size: 0.9rem;
            /* Reduced icon size */
            color: var(--green);
            margin-bottom: 0.2rem;
            /* Reduced space below the icon */
        }

        .action-item .value {
            font-size: 0.7rem;
            /* Smaller font for values */
            font-weight: 500;
            margin-bottom: 0.1rem;
            /* Reduced space below the value */
            display: flex;
            align-items: center;
        }

        .action-item .label {
            font-size: 0.6rem;
            /* Smaller font for labels */
            color: var(--dark-gray);
        }


        .toggle-balance {
            margin-left: 0.5rem;
            cursor: pointer;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-actions a {
            color: var(--green);
            text-decoration: none;
            font-size: 1.3rem;
            transition: color 0.3s ease;
        }

        .user-actions a:hover {
            color: var(--deep-orange);
        }

        .content {
            padding: 2rem;
            margin-top: 4.5rem;
            flex-grow: 1;
        }

        .dashboard-card {
            background-color: var(--white);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card h2 {
            color: var(--green);
            margin-bottom: 0.5rem;
            font-size: 2rem;
            font-weight: 600;
            /* Semibold */
        }

        .dashboard-card p {
            font-size: 1rem;
            font-weight: 400;
            /* Regular */
        }

        .footer {
            background-color: var(--green);
            color: var(--white);
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            position: relative;
            /* Ensure footer is at the bottom */
        }

        .rating-stars {
            display: inline-block;
            color: gold;
            font-size: 0.9rem;
        }

        @media (max-width: 1200px) {
            .top-bar {
                left: 0;
                margin-left: 250px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: auto;
                padding: 1rem;
                z-index: 1000;
                transform: translateY(100%);
            }

            .sidebar.active {
                transform: translateY(0);
            }

            .main-content {
                margin-left: 0;
                margin-bottom: 60px;
            }

            .top-bar {
                left: 0;
                right: 0;
                position: relative;
                padding: 0.5rem 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .menu-toggle {
                display: block;
            }

            .nav-links {
                display: none;
            }

            .nav-links.active {
                display: block;
            }

            .middle-actions {
                display: none;
                /* Hide middle actions on mobile for better space management */
            }

            .user-actions {
                display: flex;
                justify-content: space-around;
                width: 100%;
            }
        }

        /* Additional Styles for Toggle Balance Animation */
        .action-item .toggle-balance {
            transition: color 0.3s ease;
        }

        .action-item .toggle-balance.hidden {
            color: var(--deep-orange);
        }

        .subscription-notification {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .subscription-notification a {
            background-color: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
        }

        .subscription-notification a:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="/writer/dashboard" class="logo">
                <img src="/images/logo.png" alt="Logo" style="width: 150px; height: auto;">
                {{-- Uvo Writers --}}
            </a>
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav>
            <ul class="nav-links" id="navLinks">
                <li class="nav-item">
                    <a href="/writer/dashboard" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/writer/assignments/" class="nav-link">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Available Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/writer/bids/active" class="nav-link">
                        <i class="fas fa-hand-paper"></i>
                        <span>Active Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-comments"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/subscriptions/plans" class="nav-link">
                        <i class="fas fa-bell"></i>
                        <span>Subscription</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/subscriptions/active" class="nav-link">
                        <i class="fas fa-check-circle"></i>
                        <span>Active Subscription</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/writer/balance" class="nav-link">
                        <i class="fas fa-wallet"></i>
                        <span>Payments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/writer/profile" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="main-content">
        <header class="top-bar">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search...">
            </div>
            <div class="middle-actions">
                <div class="action-item">
                    <div class="icon">
                        <i class="fas fa-level-up-alt"></i>
                    </div>
                    <div class="value">Regular +</div>
                    <div class="label">Level</div>
                </div>
                {{-- <div class="action-item">
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="value">
                        <span id="balanceAmount">KES {{ number_format($writer->balance, 2) }}</span>
                        <i class="fas fa-eye toggle-balance" id="toggleBalance" title="Hide Balance"></i>
                    </div>
                    <div class="label">Balance</div>
                </div> --}}
                {{-- <div class="action-item">
                    <div class="icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="value">
                        <span class="rating-stars">{{ number_format($averageRating, 1) }}</span> / 5
                    </div>
                    <div class="label">Rating</div>
                </div> --}}
                <div class="action-item">
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="value">100%</div>
                    <div class="label">Success Rate</div>
                </div>
                <div class="action-item">
                    <div class="icon">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <div class="value">Rate</div>
                    <div class="label">Rating</div>
                </div>
            </div>
            <div class="user-actions">
                <a href="#" title="Notifications"><i class="fas fa-bell"></i></a>
                <a href="#" title="Messages"><i class="fas fa-envelope"></i></a>
                <a href="/writer/profile" title="Profile"><i class="fas fa-user-circle"></i></a>
            </div>
        </header>

        <main class="content">
            <div class="dashboard-card" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2>Welcome, {{ Auth::user()->name }}!</h2>
                    <p>Enjoy Your Writers Dashboard.</p>
                </div>
                <a href="/subscriptions/plans" class="btn-subscription"
                    style="display: flex; align-items: center; text-decoration: none; color: var(--white); background-color: var(--green); padding: 0.5rem 1rem; border-radius: 0.5rem;">
                    <i class="fas fa-bell" style="margin-right: 0.5rem;"></i>
                    Subscription
                </a>
            </div>
            @php
                $hasActiveSubscription = Auth::user()->subscriptions()->where('end_date', '>', now())->exists();
            @endphp

            @if (!$hasActiveSubscription)
                <div class="subscription-notification">
                    <span>You don't have an active subscription. Subscribe now to access all features!</span>
                    <a href="{{ route('subscriptions.plans') }}">Subscribe Now</a>
                </div>
            @endif
            @if (isset($writer) && $writer->profile_completion < 70)
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px;">
                    <p>Your profile is incomplete. Please <a href="{{ route('writer.profile') }}">complete your
                            profile</a>.</p>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="footer">
            © <span id="currentYear"></span> Uvo Writers. All rights reserved. | Developed by <a
                href="https://www.jrmhd.tech" target="_blank" rel="noopener noreferrer">Jrmhd Technologies</a>
        </footer>

        <script>
            // Update Current Year in Footer
            document.getElementById('currentYear').textContent = new Date().getFullYear();

            // Toggle Sidebar on Mobile
            const menuToggle = document.getElementById('menuToggle');
            const navLinks = document.getElementById('navLinks');

            menuToggle.addEventListener('click', () => {
                document.querySelector('.sidebar').classList.toggle('active');
                navLinks.classList.toggle('active');
            });

            // Toggle Balance Visibility
            const toggleBalance = document.getElementById('toggleBalance');
            const balanceAmount = document.getElementById('balanceAmount');

            toggleBalance.addEventListener('click', () => {
                if (balanceAmount.textContent.trim() !== '****') {
                    // Hide Balance
                    balanceAmount.textContent = '****';
                    toggleBalance.classList.add('hidden');
                    toggleBalance.title = 'Show Balance';
                } else {
                    // Show Balance
                    {{-- balanceAmount.textContent = 'KES {{ number_format($writer->balance, 2) }}'; --}}
                    toggleBalance.classList.remove('hidden');
                    toggleBalance.title = 'Hide Balance';
                }
            });
        </script>
    </div>

</body>

</html>
