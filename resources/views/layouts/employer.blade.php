<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Auth::user()->name }} Employer Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: var(--white);
            color: var(--dark-gray);
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            transition: all 0.3s ease;
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
            position: relative;
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
            color: var(--green);
            transition: color 0.3s ease;
        }

        .nav-link:hover i {
            color: var(--white);
        }

        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            background-color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        }

        .search-bar input {
            border: none;
            background: none;
            margin-left: 0.5rem;
            font-size: 0.9rem;
            color: var(--dark-gray);
        }

        .user-actions a {
            color: var(--green);
            text-decoration: none;
            margin-left: 1rem;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .user-actions a:hover {
            color: var(--deep-orange);
        }

        .content {
            padding: 2rem;
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
            margin-bottom: 1rem;
            font-size: 2rem;
            font-weight: 600;
        }

        .dashboard-card p {
            font-size: 1rem;
            font-weight: 400;
        }

        .footer {
            background-color: var(--green);
            color: var(--white);
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            position: relative;
            margin-top: auto;
            width: calc(100% - 250px);
        }

        .level-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            /* Space between items */
        }

        .level-info .action-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.8rem;
            /* Smaller font size */
            color: var(--dark-gray);
        }

        .level-info .icon {
            font-size: 1.2rem;
            /* Adjust icon size */
            color: var(--green);
        }

        @media (max-width: 768px) {
            body {
                overflow: auto;
            }

            .sidebar {
                width: 100%;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: auto;
                padding: 1rem;
                z-index: 1000;
            }

            .sidebar-header {
                margin-bottom: 0;
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

            .main-content {
                margin-left: 0;
                margin-bottom: 60px;
            }

            .top-bar {
                flex-direction: column;
                align-items: stretch;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
            }

            .search-bar {
                margin-bottom: 1rem;
            }

            .user-actions {
                display: flex;
                justify-content: space-around;
            }

            .footer {
                width: 100%;
                position: relative;
            }
        }

        .dropdown-toggle {
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            list-style: none;
            padding-left: 20px;
        }

        .dropdown-menu.active {
            display: block;
        }

        .new-badge {
            background-color: #8e44ad;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 5px;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
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
            <a href="#" class="logo" style="display: inline-block; width: 150px; height: auto;">
                <img src="/images/logo.png" alt="Logo" style="width: 120%; height: auto; display: block;">
            </a>
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav>
            <ul class="nav-links" id="navLinks">
                <li class="nav-item">
                    <a href="/employer/dashboard" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle">
                        <i class="fas fa-file-alt"></i>
                        <span>Orders</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu"
                        style="list-style-type: none; padding: 10px; margin: 0; background-color: #f8f9fa; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                        <li style="margin-bottom: 8px;">
                            <a href="/employer/assignments/create"
                                style="text-decoration: none; color: green; font-weight: 600; padding: 10px 15px; display: block; border-radius: 5px; transition: color 0.3s ease;">
                                New order
                            </a>
                        </li>
                        <li style="margin-bottom: 8px;">
                            <a href="/employer/assignments"
                                style="text-decoration: none; color: green; font-weight: 600; padding: 10px 15px; display: block; border-radius: 5px; transition: color 0.3s ease;">
                                My orders
                            </a>
                        </li>
                        <li style="margin-bottom: 8px;">
                            <a href="/employer/given-out-assignments"
                                style="text-decoration: none; color: green; font-weight: 600; padding: 10px 15px; display: block; border-radius: 5px; transition: color 0.3s ease;">
                                Active Orders
                            </a>
                        </li>
                        <li>
                            <a href="/employer/assignments-with-bids"
                                style="text-decoration: none; color: green; font-weight: 600; padding: 10px 15px; display: block; border-radius: 5px; transition: color 0.3s ease;">
                                Assignments with Bids
                            </a>
                        </li>
                    </ul>

                    <!-- Adding hover effect to change text color to purple -->
                    <style>
                        .dropdown-menu a:hover {
                            color: purple;
                        }
                    </style>

                </li>

                <li class="nav-item">
                    <a href="/employer/wallet" class="nav-link">
                        <i class="fas fa-wallet"></i>
                        <span>Balance</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/employer/subscriptions/plans" class="nav-link">
                        <i class="fas fa-bell"></i>
                        <span>Subscriptions</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/employer/writers" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Writers</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-comments"></i>
                        <span>Chats</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-calendar"></i>
                        <span>Planner</span>
                        <span class="new-badge">Soon</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <ul class="nav-links">
                <li class="nav-item">
                    <a href="/employer/profile" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-question-circle"></i>
                        <span>Help Center</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Community</span>
                        <span class="new-badge">Soon</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-file-contract"></i>
                        <span>Terms</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="main-content">
        <header class="top-bar">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search...">
            </div>

            <div class="middle-actions">
                <div class="level-info">
                    <div class="action-item">
                        <div class="icon">
                            <i class="fas fa-level-up-alt"></i>
                        </div>
                        <div class="value">Regular +</div>
                    </div>
                    <div class="action-item">
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="value">100%</div>
                    </div>

                    <div class="action-item">
                        <div class="icon">
                            <i class="fas fa-thumbs-up"></i>
                        </div>
                        <div class="value">Rating</div>
                    </div>
                </div>
            </div>


            <div class="user-actions">
                <a href="#" title="Notifications"><i class="fas fa-bell"></i></a>
                <a href="#" title="Messages"><i class="fas fa-envelope"></i></a>
                <a href="/employer/profile" title="Profile"><i class="fas fa-user-circle"></i></a>
            </div>
        </header>

        <main class="content">
            <div class="dashboard-card" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2>Welcome, {{ Auth::user()->name }}!</h2>
                    <p>Here you can manage your assignments, view bids, and handle payments.</p>
                </div>
                <a href="/employer/subscriptions/plans" class="btn-subscription"
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
                    <a href="{{ route('employer.subscriptions.plans') }}">Subscribe Now</a>
                </div>
            @endif
            @yield('content')
        </main>

        <footer class="footer">
            © <span id="currentYear"></span> Uvo Writers. All rights reserved. | Developed by <a
                href="https://www.jrmhd.tech" target="_blank" rel="noopener noreferrer">Jrmhd Technologies</a>
        </footer>

        <script>
            document.getElementById('currentYear').textContent = new Date().getFullYear();
        </script>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const dropdownMenu = this.nextElementSibling;
                    dropdownMenu.classList.toggle('active');
                });
            });
        });
    </script>
</body>

</html>
