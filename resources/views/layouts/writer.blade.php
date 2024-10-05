<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Auth::user()->name }} Writers Dashboard</title>
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
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        .user-actions a:hover {
            color: var(--deep-orange);
        }

        .content {
            padding: 2rem;
            margin-top: 4rem;
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

            .user-actions {
                display: flex;
                justify-content: space-around;
            }
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="logo">
                <img src="/images/logo.png" alt="Logo" style="width: 200px; height: auto;">
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
                        <span>Available Assignments</span>
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
            document.getElementById('currentYear').textContent = new Date().getFullYear();
        </script>
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');

        menuToggle.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    </script>
</body>

</html>
