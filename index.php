<?php
/**
 * Mutta - Modern Web Developer Portfolio
 * PHP 8+ Modern Architecture & Dynamic Configuration
 */

// --------------------------------------------------------------------------
// 1. Contact Form Backend Handler (AJAX & Standard POST)
// --------------------------------------------------------------------------
$flashMessage = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && (isset($_POST['ajax_contact']) || isset($_POST['contact_submit']))) {
    $rawName = $_POST['name'] ?? '';
    $rawEmail = $_POST['email'] ?? '';
    $rawSubject = $_POST['subject'] ?? 'General Inquiry';
    $rawService = $_POST['service'] ?? 'Full-Stack Development';
    $rawMessage = $_POST['message'] ?? '';

    $name = trim(htmlspecialchars((string)$rawName, ENT_QUOTES, 'UTF-8'));
    $email = trim(filter_var((string)$rawEmail, FILTER_SANITIZE_EMAIL));
    $subject = trim(htmlspecialchars((string)$rawSubject, ENT_QUOTES, 'UTF-8'));
    $service = trim(htmlspecialchars((string)$rawService, ENT_QUOTES, 'UTF-8'));
    $message = trim(htmlspecialchars((string)$rawMessage, ENT_QUOTES, 'UTF-8'));

    $isSuccess = false;
    $responseMsg = 'Please provide valid information for all required fields.';

    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $storageDir = __DIR__ . '/storage';
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }
        $dataFile = $storageDir . '/messages.json';
        $messages = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
        if (!is_array($messages)) {
            $messages = [];
        }

        $newMessage = [
            'id' => 'msg_' . time() . '_' . bin2hex(random_bytes(4)),
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'service' => $service,
            'message' => $message,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $messages[] = $newMessage;
        file_put_contents($dataFile, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $isSuccess = true;
        $responseMsg = "Thanks, $name! Your message has been sent successfully. I'll get back to you shortly!";
    }

    if (isset($_POST['ajax_contact'])) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $isSuccess ? 'success' : 'error',
            'message' => $responseMsg
        ]);
        exit;
    } else {
        $flashMessage = [
            'type' => $isSuccess ? 'success' : 'error',
            'text' => $responseMsg
        ];
    }
}

// --------------------------------------------------------------------------
// 2. Personal Profile Data Configuration
// (Easily customize details here)
// --------------------------------------------------------------------------
$profile = [
    'name' => 'Mutta',
    'title' => 'Full-Stack Web Developer',
    'tagline' => 'Crafting high-performance web applications, scalable backends & pixel-perfect UI experiences.',
    'bio' => "I am a passionate Full-Stack Web Developer with expertise in building robust, modern web architectures. From sleek front-end interfaces to secure, scalable RESTful APIs and databases, I transform complex ideas into intuitive, high-velocity digital products.",
    'location' => 'Indonesia (Open to Remote Worldwide)',
    'email' => 'mutta.developer@gmail.com',
    'phone' => '+62 812-3456-7890',
    'status' => 'Available for Freelance & Full-Time Roles',
    'years_exp' => '3+',
    'projects_done' => '35+',
    'satisfaction' => '99.4%',
    'production_apis' => '18+',
    'github' => 'https://github.com',
    'linkedin' => 'https://linkedin.com',
    'twitter' => 'https://twitter.com',
    'discord' => 'mutta#1234'
];

// Skills Array
$skills = [
    // Frontend
    [
        'name' => 'HTML5 / Modern CSS3',
        'category' => 'frontend',
        'level' => 'Mastery',
        'icon' => 'devicon-html5-plain colored',
        'progress' => 95,
        'description' => 'Semantic layouts, accessible markup & CSS Grid/Flexbox architectures'
    ],
    [
        'name' => 'JavaScript (ES6+)',
        'category' => 'frontend',
        'level' => 'Advanced',
        'icon' => 'devicon-javascript-plain colored',
        'progress' => 92,
        'description' => 'Asynchronous JS, modern DOM manipulation, modules & performance'
    ],
    [
        'name' => 'Tailwind CSS',
        'category' => 'frontend',
        'level' => 'Mastery',
        'icon' => 'devicon-tailwindcss-original colored',
        'progress' => 96,
        'description' => 'Component design systems, responsive utilities & dark mode theming'
    ],
    [
        'name' => 'React.js',
        'category' => 'frontend',
        'level' => 'Advanced',
        'icon' => 'devicon-react-original colored',
        'progress' => 88,
        'description' => 'Hooks, Context API, component lifecycle, Next.js hydration & state'
    ],
    [
        'name' => 'TypeScript',
        'category' => 'frontend',
        'level' => 'Proficient',
        'icon' => 'devicon-typescript-plain colored',
        'progress' => 82,
        'description' => 'Strict type safety, generic interfaces & robust client code'
    ],

    // Backend
    [
        'name' => 'PHP 8.x',
        'category' => 'backend',
        'level' => 'Expert',
        'icon' => 'devicon-php-plain colored',
        'progress' => 94,
        'description' => 'OOP, Modern attributes, Enums, Match expressions & strict typing'
    ],
    [
        'name' => 'Laravel Framework',
        'category' => 'backend',
        'level' => 'Expert',
        'icon' => 'devicon-laravel-original colored',
        'progress' => 90,
        'description' => 'Eloquent ORM, Blade, Queues, Auth guards, Migrations & MVC patterns'
    ],
    [
        'name' => 'RESTful & GraphQL APIs',
        'category' => 'backend',
        'level' => 'Advanced',
        'icon' => 'fa-solid fa-network-wired text-cyan-400',
        'progress' => 91,
        'description' => 'Secure authentication (JWT, OAuth2), rate limiting & API versioning'
    ],
    [
        'name' => 'Node.js & Express',
        'category' => 'backend',
        'level' => 'Proficient',
        'icon' => 'devicon-nodejs-plain colored',
        'progress' => 83,
        'description' => 'Microservices, real-time WebSockets & event-driven processing'
    ],

    // Database & DevOps
    [
        'name' => 'MySQL / MariaDB',
        'category' => 'database',
        'level' => 'Advanced',
        'icon' => 'devicon-mysql-plain colored',
        'progress' => 90,
        'description' => 'Complex relational joins, indexing, query optimization & ACID compliance'
    ],
    [
        'name' => 'PostgreSQL',
        'category' => 'database',
        'level' => 'Proficient',
        'icon' => 'devicon-postgresql-plain colored',
        'progress' => 84,
        'description' => 'JSONB attributes, foreign keys, triggers & advanced analytics'
    ],
    [
        'name' => 'Redis Caching',
        'category' => 'database',
        'level' => 'Proficient',
        'icon' => 'devicon-redis-plain colored',
        'progress' => 80,
        'description' => 'High-speed in-memory caching, pub/sub channels & session storage'
    ],
    [
        'name' => 'Docker & Containers',
        'category' => 'devops',
        'level' => 'Proficient',
        'icon' => 'devicon-docker-plain colored',
        'progress' => 82,
        'description' => 'Docker Compose multi-service stacks, isolated dev environments'
    ],
    [
        'name' => 'Git & GitHub Workflows',
        'category' => 'devops',
        'level' => 'Mastery',
        'icon' => 'devicon-git-plain colored',
        'progress' => 95,
        'description' => 'Branching strategies, PR reviews, CI/CD pipelines & release tags'
    ],
    [
        'name' => 'Laragon & Nginx / Apache',
        'category' => 'devops',
        'level' => 'Advanced',
        'icon' => 'fa-solid fa-server text-emerald-400',
        'progress' => 89,
        'description' => 'Virtual hosts, SSL configs, fast local PHP development & deployment'
    ]
];

// Featured Projects Array
$projects = [
    [
        'id' => 'novacommerce',
        'title' => 'NovaCommerce Suite',
        'subtitle' => 'Omnichannel E-Commerce & Inventory Management Platform',
        'category' => 'fullstack',
        'category_label' => 'Full-Stack Web App',
        'description' => 'A lightning-fast modern e-commerce storefront and merchant control panel. Built with Laravel and modern JS, featuring real-time inventory synchronization, multi-currency checkout via Stripe/Midtrans, dynamic product filtering, and an automated invoice generator.',
        'tech' => ['PHP 8.2', 'Laravel', 'Tailwind CSS', 'MySQL', 'Stripe API', 'Alpine.js'],
        'highlights' => 'Sub-second page load times with Redis cache|Real-time stock reservation system|Full automated transaction email workflows|Comprehensive sales analytics dashboard',
        'gradient' => 'from-indigo-600 via-purple-600 to-pink-500',
        'badge' => 'Featured Project',
        'live' => 'https://example.com/demo/novacommerce',
        'repo' => 'https://github.com/mutta/novacommerce'
    ],
    [
        'id' => 'pulseboard',
        'title' => 'PulseBoard SaaS',
        'subtitle' => 'Real-Time Agile Sprint & Task Collaboration Platform',
        'category' => 'fullstack',
        'category_label' => 'Full-Stack / SaaS',
        'description' => 'Interactive project management workspace designed for modern engineering teams. Features drag-and-drop Kanban boards, live presence indicators via WebSockets, markdown task descriptions, file attachments, and activity audit logs.',
        'tech' => ['React.js', 'Node.js', 'Express', 'Tailwind CSS', 'PostgreSQL', 'Socket.io'],
        'highlights' => 'Zero-lag real-time card updates across collaborative users|Optimistic UI updates for snappy user feedback|Role-based access control (Admin, Member, Viewer)|Exportable sprint velocity metrics',
        'gradient' => 'from-cyan-600 via-blue-600 to-indigo-600',
        'badge' => 'SaaS Product',
        'live' => 'https://example.com/demo/pulseboard',
        'repo' => 'https://github.com/mutta/pulseboard'
    ],
    [
        'id' => 'apexanalytics',
        'title' => 'ApexAnalytics Dashboard',
        'subtitle' => 'Live Telemetry & Business Intelligence Portal',
        'category' => 'frontend',
        'category_label' => 'Frontend / Data Viz',
        'description' => 'High-density visual analytics dashboard presenting multi-metric telemetry data in real-time. Designed with a sleek dark cyberpunk aesthetic, interactive SVG charts, customizable widgets, and export options in CSV and PDF.',
        'tech' => ['JavaScript ES6+', 'Chart.js', 'Tailwind CSS', 'PHP API', 'HTML5 Canvas'],
        'highlights' => 'Handles 50,000+ data points smoothly with canvas rendering|Custom dark-mode glassmorphic widget cards|Responsive layout adapting effortlessly from mobile to 4K displays|100/100 Google Lighthouse performance score',
        'gradient' => 'from-emerald-500 via-teal-600 to-cyan-600',
        'badge' => 'Interactive UI',
        'live' => 'https://example.com/demo/apexanalytics',
        'repo' => 'https://github.com/mutta/apexanalytics'
    ],
    [
        'id' => 'cloudbridge',
        'title' => 'CloudBridge API Gateway',
        'subtitle' => 'High-Throughput Microservice Authentication & Rate Limiter',
        'category' => 'backend',
        'category_label' => 'Backend Architecture',
        'description' => 'Robust middleware gateway orchestrating multiple internal microservices. Provides centralized OAuth2 token verification, sliding-window rate limiting with Redis, request telemetry, and automated API documentation endpoints.',
        'tech' => ['PHP 8.1', 'REST API', 'Redis', 'Docker', 'MySQL', 'JWT Auth'],
        'highlights' => 'Sustains 2,400+ requests per second with under 15ms overhead|Configurable token blacklisting and automated IP banning|Structured JSON error payloads following RFC 7807 specs|Dockerized single-command setup for development',
        'gradient' => 'from-violet-600 via-fuchsia-600 to-rose-600',
        'badge' => 'High Performance',
        'live' => 'https://example.com/demo/cloudbridge',
        'repo' => 'https://github.com/mutta/cloudbridge'
    ],
    [
        'id' => 'finvault',
        'title' => 'FinVault Wealth Tracker',
        'subtitle' => 'Personal Finance, Expense & Multi-Currency Portfolio',
        'category' => 'fullstack',
        'category_label' => 'Full-Stack Web App',
        'description' => 'A clean, privacy-focused financial management tool that lets users track expenses, budgets, bank accounts, and crypto assets. Features automated currency exchange rate polling and intuitive visual breakdown charts.',
        'tech' => ['PHP MVC', 'Vanilla JS', 'Tailwind CSS', 'SQLite', 'Exchange Rate API'],
        'highlights' => 'Zero external tracking; 100% user data privacy|Automated recurring expense projections|Lightweight architecture with ultra-fast page response (<80ms)|Exportable financial reports for tax prep',
        'gradient' => 'from-amber-500 via-orange-600 to-red-600',
        'badge' => 'Finance App',
        'live' => 'https://example.com/demo/finvault',
        'repo' => 'https://github.com/mutta/finvault'
    ],
    [
        'id' => 'devforge',
        'title' => 'DevForge Code Vault',
        'subtitle' => 'Developer Snippet Manager & Technical Documentation CMS',
        'category' => 'frontend',
        'category_label' => 'Frontend / Developer Tool',
        'description' => 'An elegant personal knowledge base for software engineers. Supports syntax-highlighted code blocks for 40+ programming languages, tag filtering, instant full-text search, and quick snippet sharing via private URLs.',
        'tech' => ['JavaScript', 'Prism.js', 'Tailwind CSS', 'PHP API', 'Local Storage'],
        'highlights' => 'Instant search filtering with sub-millisecond responsiveness|One-click code snippet copy with visual toast confirmation|Dark mode optimized syntax theme inspired by One Dark Pro|Offline support with PWA service worker capabilities',
        'gradient' => 'from-blue-600 via-indigo-600 to-violet-700',
        'badge' => 'Open Source',
        'live' => 'https://example.com/demo/devforge',
        'repo' => 'https://github.com/mutta/devforge'
    ]
];

// Experience Timeline
$timeline = [
    [
        'period' => '2024 - Present',
        'role' => 'Lead Full-Stack Web Developer',
        'company' => 'TechNova Digital Solutions',
        'badge' => 'Current Role',
        'description' => 'Architecting and maintaining high-traffic web applications, customer portals, and internal business platforms. Mentoring junior developers, implementing CI/CD pipelines, and driving adoption of modern PHP 8 and component-based frontend workflows.'
    ],
    [
        'period' => '2022 - 2024',
        'role' => 'Full-Stack Web Developer',
        'company' => 'PixelCraft Interactive Agency',
        'badge' => 'Full-Time',
        'description' => 'Developed custom Laravel and WordPress web solutions for international clients. Built custom REST APIs, integrated payment gateways (Stripe, PayPal), and optimized database queries for 40% faster server responses.'
    ],
    [
        'period' => '2021 - 2022',
        'role' => 'Junior Frontend & Web Developer',
        'company' => 'DevSphere Studio',
        'badge' => 'Early Career',
        'description' => 'Converted high-fidelity Figma mockups into pixel-perfect, accessible, and responsive HTML5/CSS3/JavaScript components. Collaborated closely with backend engineers to consume REST endpoints.'
    ],
    [
        'period' => '2018 - 2022',
        'role' => 'B.S. in Computer Science / Informatics',
        'company' => 'Faculty of Computer Science',
        'badge' => 'Education',
        'description' => 'Graduated with honors. Specialized in Software Engineering, Web Technologies, Relational Database Management Systems, and Object-Oriented System Architecture.'
    ]
];

// Services
$services = [
    [
        'icon' => 'fa-solid fa-laptop-code text-cyan-400',
        'title' => 'Custom Web App Development',
        'desc' => 'End-to-end full-stack web applications built for speed, security, and effortless scalability using PHP, Laravel, and modern JavaScript.',
        'features' => ['Bespoke business logic & workflows', 'Responsive UI on all screen sizes', 'Modern MVC architecture', 'Clean, documented code']
    ],
    [
        'icon' => 'fa-solid fa-server text-indigo-400',
        'title' => 'API & Database Engineering',
        'desc' => 'High-throughput, secure RESTful APIs and optimized database schemas designed to reliably support thousands of concurrent users.',
        'features' => ['JWT & OAuth2 authentication', 'MySQL & PostgreSQL optimization', 'Redis in-memory caching', 'Structured OpenAPI / Swagger specs']
    ],
    [
        'icon' => 'fa-solid fa-wand-magic-sparkles text-purple-400',
        'title' => 'UI/UX Design & Frontend Craft',
        'desc' => 'Crafting intuitive, accessible, and breathtaking interfaces that convert visitors into loyal users with micro-interactions and smooth styling.',
        'features' => ['Figma to pixel-perfect code', 'Tailwind CSS design systems', 'Dark / Light mode adaptability', 'Micro-interactions & animations']
    ],
    [
        'icon' => 'fa-solid fa-gauge-high text-emerald-400',
        'title' => 'Performance & SEO Optimization',
        'desc' => 'Auditing existing codebases to eliminate bottlenecks, boost Core Web Vitals to 95+, and implement technical SEO best practices.',
        'features' => ['Core Web Vitals acceleration', 'Asset minification & image pipelines', 'Database query profiling', 'Schema markup & metadata SEO']
    ]
];

// Testimonials
$testimonials = [
    [
        'quote' => 'Mutta is an exceptional developer who combines technical mastery with an eye for design. He transformed our complex product requirements into a sleek, lightning-fast application ahead of deadline.',
        'author' => 'Alexandre Vance',
        'role' => 'CTO & Co-Founder, SaaSify Labs',
        'avatar' => 'AV'
    ],
    [
        'quote' => 'Working with Mutta was seamless. His code is remarkably clean, well-structured, and he communicated proactive updates every single week. Our checkout conversion improved by 34% after his revamp.',
        'author' => 'Sarah Jenkins',
        'role' => 'Product Director, Nova Retail',
        'avatar' => 'SJ'
    ],
    [
        'quote' => 'Finding a developer who understands both deep backend architectural patterns (PHP/Laravel/APIs) and modern frontend UI aesthetics is rare. Mutta is that developer.',
        'author' => 'Rizky Pratama',
        'role' => 'Lead Engineer, Nexus Digital',
        'avatar' => 'RP'
    ]
];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($profile['name']); ?> — <?= htmlspecialchars($profile['title']); ?> | Portfolio</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="<?= htmlspecialchars($profile['tagline']); ?>">
    <meta name="keywords" content="Mutta, Web Developer, Full Stack Developer, PHP, Laravel, React, Tailwind CSS, Frontend Developer, Backend Developer, Indonesia, Portfolio">
    <meta name="author" content="Mutta">
    
    <!-- Open Graph / Social Sharing -->
    <meta property="og:title" content="<?= htmlspecialchars($profile['name']); ?> — <?= htmlspecialchars($profile['title']); ?>">
    <meta property="og:description" content="<?= htmlspecialchars($profile['tagline']); ?>">
    <meta property="og:type" content="website">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Devicon Programming Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">

    <!-- Tailwind CSS (via CDN with Custom Configuration) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        darkBg: '#090d16',
                        darkCard: '#0f172a',
                        cyberCyan: '#06b6d4',
                        neonIndigo: '#6366f1',
                        neonPurple: '#a855f7',
                        neonEmerald: '#10b981'
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace']
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="font-sans relative selection:bg-indigo-500 selection:text-white pb-20 md:pb-0">

    <!-- Reading Scroll Progress Bar -->
    <div id="scroll-progress"></div>

    <!-- Background Ambient Glow Orbs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="glow-orb w-[500px] h-[500px] -top-40 -left-20 bg-indigo-600/20"></div>
        <div class="glow-orb w-[600px] h-[600px] top-1/3 -right-40 bg-cyan-600/15"></div>
        <div class="glow-orb w-[500px] h-[500px] bottom-10 left-1/4 bg-purple-600/15"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-60"></div>
    </div>

    <!-- ======================================================================
         NAVIGATION BAR
         ====================================================================== -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5">
            <nav id="main-nav" class="glass-nav rounded-2xl px-5 py-3 flex items-center justify-between shadow-lg">
                
                <!-- Brand / Logo -->
                <a href="#hero" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-indigo-600 flex items-center justify-center font-mono font-bold text-lg text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                        M
                    </div>
                    <div class="flex flex-col">
                        <span class="brand-text font-bold text-lg tracking-tight transition-colors">
                            <span class="text-cyan-400 font-mono">&lt;</span><?= htmlspecialchars($profile['name']); ?><span class="text-indigo-400 font-mono">.dev/&gt;</span>
                        </span>
                        <span class="brand-subtext text-[10px] -mt-1 font-mono tracking-wider">FULL-STACK ENGINEER</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center gap-7 text-sm font-medium">
                    <a href="#about" class="nav-link py-1">About</a>
                    <a href="#skills" class="nav-link py-1">Skills</a>
                    <a href="#projects" class="nav-link py-1">Projects</a>
                    <a href="#services" class="nav-link py-1">Services</a>
                    <a href="#experience" class="nav-link py-1">Experience</a>
                    <a href="#contact" class="nav-link py-1">Contact</a>
                </div>

                <!-- Action Controls: Theme Switcher & Hire Me -->
                <div class="hidden md:flex items-center gap-3">
                    <!-- Dark / Light Mode Switch -->
                    <button id="theme-toggle" type="button" aria-label="Toggle Dark / Light Theme" class="theme-btn w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:scale-105">
                        <i id="theme-icon" class="fa-solid fa-sun text-amber-400 text-lg"></i>
                    </button>

                    <!-- CTA Button -->
                    <a href="#contact" class="btn-glow px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider text-white bg-gradient-to-r from-cyan-500 via-indigo-600 to-purple-600 hover:from-cyan-400 hover:to-purple-500 shadow-md shadow-indigo-500/20 transition-all hover:shadow-indigo-500/40">
                        <i class="fa-solid fa-paper-plane mr-1.5 text-xs"></i> Hire Me
                    </a>
                </div>

                <!-- Mobile Header Actions -->
                <div class="flex items-center gap-2 md:hidden">
                    <button id="theme-toggle-mobile" type="button" aria-label="Toggle Theme" class="theme-btn w-9 h-9 rounded-lg flex items-center justify-center">
                        <i id="theme-icon-mobile" class="fa-solid fa-sun text-amber-400 text-sm"></i>
                    </button>
                    <button id="mobile-menu-btn" type="button" aria-label="Open Mobile Menu" class="menu-btn w-9 h-9 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-bars text-base"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile Drawer Navigation -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300"></div>
    <div id="mobile-drawer" class="fixed top-0 right-0 w-72 h-full z-50 transform translate-x-full transition-transform duration-300 p-6 flex flex-col justify-between shadow-2xl">
        <div>
            <div class="flex items-center justify-between pb-6 border-b border-slate-700/40 mobile-drawer-border">
                <span class="font-bold text-lg font-mono brand-text">
                    <span class="text-cyan-400">&lt;</span><?= htmlspecialchars($profile['name']); ?><span class="text-indigo-400">/&gt;</span>
                </span>
                <button id="mobile-menu-close" type="button" aria-label="Close Mobile Menu" class="menu-btn w-8 h-8 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            <nav class="flex flex-col gap-3 mt-6 text-sm font-medium">
                <a href="#hero" class="mobile-nav-link py-2 border-b border-slate-700/20 mobile-drawer-border">Home</a>
                <a href="#about" class="mobile-nav-link py-2 border-b border-slate-700/20 mobile-drawer-border">About</a>
                <a href="#skills" class="mobile-nav-link py-2 border-b border-slate-700/20 mobile-drawer-border">Skills & Tech</a>
                <a href="#projects" class="mobile-nav-link py-2 border-b border-slate-700/20 mobile-drawer-border">Featured Projects</a>
                <a href="#services" class="mobile-nav-link py-2 border-b border-slate-700/20 mobile-drawer-border">Services</a>
                <a href="#experience" class="mobile-nav-link py-2 border-b border-slate-700/20 mobile-drawer-border">Experience</a>
                <a href="#contact" class="mobile-nav-link py-2">Contact</a>
            </nav>
        </div>
        <div class="pt-6 border-t border-slate-700/40 mobile-drawer-border">
            <a href="#contact" class="mobile-nav-link block text-center py-2.5 rounded-xl font-medium text-white bg-gradient-to-r from-cyan-500 to-indigo-600 shadow-md">
                Get in Touch
            </a>
        </div>
    </div>

    <!-- Global Toast Notification Container -->
    <div id="global-toast" class="toast"></div>

    <main class="relative z-10 pt-28">

        <!-- Flash message from standard POST fallback if any -->
        <?php if ($flashMessage): ?>
            <div class="max-w-4xl mx-auto px-4 mb-6">
                <div class="p-4 rounded-xl flex items-center gap-3 <?= $flashMessage['type'] === 'success' ? 'bg-emerald-500/20 border border-emerald-500/40 text-emerald-300' : 'bg-rose-500/20 border border-rose-500/40 text-rose-300'; ?>">
                    <i class="fa-solid <?= $flashMessage['type'] === 'success' ? 'fa-circle-check text-emerald-400' : 'fa-circle-exclamation text-rose-400'; ?> text-xl"></i>
                    <span><?= htmlspecialchars($flashMessage['text']); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- ==================================================================
             HERO SECTION
             ================================================================== -->
        <section id="hero" class="min-h-[85vh] flex items-center py-12 lg:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                    
                    <!-- Left Hero Content (7 Cols) -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- Availability Badge -->
                        <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-slate-900/80 border border-emerald-500/30 backdrop-blur-md text-xs font-medium text-emerald-400 shadow-sm">
                            <span class="pulse-indicator">
                                <span class="ping"></span>
                                <span class="dot"></span>
                            </span>
                            <span><?= htmlspecialchars($profile['status']); ?></span>
                        </div>

                        <!-- Main Headline -->
                        <div class="space-y-3">
                            <h2 class="text-sm md:text-base font-mono uppercase tracking-widest text-cyan-400 font-semibold">
                                Hello World! I'm
                            </h2>
                            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-white leading-[1.1]">
                                <span class="text-gradient"><?= htmlspecialchars($profile['name']); ?></span>
                                <span class="block text-2xl sm:text-4xl lg:text-5xl font-bold text-slate-300 mt-2">
                                    Crafting Modern Web Experiences
                                </span>
                            </h1>
                        </div>

                        <!-- Pitch / Bio -->
                        <p class="text-base sm:text-lg text-slate-300/90 leading-relaxed max-w-2xl">
                            <?= htmlspecialchars($profile['tagline']); ?> Bridging elegant visual aesthetics with rock-solid, production-ready backend systems.
                        </p>

                        <!-- Tech Chips Row -->
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            <span class="text-xs font-mono text-slate-400 mr-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-code text-cyan-400"></i> Core Focus:
                            </span>
                            <span class="tech-pill"><i class="devicon-php-plain"></i> PHP 8</span>
                            <span class="tech-pill"><i class="devicon-laravel-plain"></i> Laravel</span>
                            <span class="tech-pill"><i class="devicon-react-original"></i> React</span>
                            <span class="tech-pill"><i class="devicon-tailwindcss-original"></i> Tailwind</span>
                            <span class="tech-pill"><i class="devicon-mysql-plain"></i> MySQL</span>
                            <span class="tech-pill"><i class="fa-solid fa-server"></i> REST APIs</span>
                        </div>

                        <!-- CTA Action Buttons -->
                        <div class="flex flex-wrap items-center gap-4 pt-4">
                            <a href="#projects" class="btn-glow px-6 py-3.5 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-cyan-500 via-indigo-600 to-purple-600 hover:from-cyan-400 hover:to-purple-500 shadow-lg shadow-indigo-500/25 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-briefcase"></i> View Featured Work
                            </a>
                            <a href="#contact" class="px-6 py-3.5 rounded-xl font-semibold text-sm text-slate-200 bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 hover:border-slate-600 transition-all flex items-center gap-2">
                                <i class="fa-regular fa-envelope text-cyan-400"></i> Let's Talk
                            </a>
                            <button type="button" class="copy-email-btn px-4 py-3.5 rounded-xl text-slate-300 bg-slate-800/50 hover:bg-slate-800 border border-slate-700/60 hover:text-white transition-all flex items-center gap-2 text-sm" data-email="<?= htmlspecialchars($profile['email']); ?>" title="Copy Email to Clipboard">
                                <i class="fa-regular fa-copy text-slate-400"></i>
                                <span class="hidden sm:inline">Copy Email</span>
                            </button>
                        </div>

                        <!-- Social Links Bar -->
                        <div class="flex items-center gap-4 pt-2 text-slate-400">
                            <span class="text-xs uppercase font-mono tracking-wider text-slate-500">Connect:</span>
                            <a href="<?= htmlspecialchars($profile['github']); ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-slate-800/60 hover:bg-slate-700 flex items-center justify-center text-slate-300 hover:text-white transition-colors" title="GitHub">
                                <i class="fa-brands fa-github text-lg"></i>
                            </a>
                            <a href="<?= htmlspecialchars($profile['linkedin']); ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-slate-800/60 hover:bg-slate-700 flex items-center justify-center text-slate-300 hover:text-cyan-400 transition-colors" title="LinkedIn">
                                <i class="fa-brands fa-linkedin text-lg"></i>
                            </a>
                            <a href="<?= htmlspecialchars($profile['twitter']); ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-slate-800/60 hover:bg-slate-700 flex items-center justify-center text-slate-300 hover:text-cyan-400 transition-colors" title="Twitter / X">
                                <i class="fa-brands fa-x-twitter text-lg"></i>
                            </a>
                            <a href="mailto:<?= htmlspecialchars($profile['email']); ?>" class="w-9 h-9 rounded-lg bg-slate-800/60 hover:bg-slate-700 flex items-center justify-center text-slate-300 hover:text-rose-400 transition-colors" title="Direct Email">
                                <i class="fa-solid fa-at text-base"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Right Hero Visual / Interactive Code Terminal (5 Cols) -->
                    <div class="lg:col-span-5">
                        <div class="relative">
                            <!-- Floating decorative glow in background -->
                            <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-cyan-500 via-indigo-600 to-purple-600 opacity-30 blur-xl"></div>
                            
                            <!-- Mac-Style Code Terminal Card -->
                            <div class="code-window relative">
                                <!-- Top Window Bar -->
                                <div class="px-4 py-3 bg-slate-900/90 border-b border-slate-800/80 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-rose-500/80 inline-block"></span>
                                        <span class="w-3 h-3 rounded-full bg-amber-500/80 inline-block"></span>
                                        <span class="w-3 h-3 rounded-full bg-emerald-500/80 inline-block"></span>
                                        <span class="text-xs font-mono text-slate-400 ml-2">mutta-dev-terminal</span>
                                    </div>
                                    <!-- Code Tabs -->
                                    <div class="flex items-center gap-1 text-xs font-mono">
                                        <button type="button" class="code-tab-btn px-2.5 py-1 rounded bg-slate-800/80 text-cyan-400 border-b-2 border-cyan-400" data-tab="php">
                                            Mutta.php
                                        </button>
                                        <button type="button" class="code-tab-btn px-2.5 py-1 rounded text-slate-400 hover:text-slate-200" data-tab="json">
                                            stack.json
                                        </button>
                                        <button type="button" class="code-tab-btn px-2.5 py-1 rounded text-slate-400 hover:text-slate-200" data-tab="bash">
                                            run.sh
                                        </button>
                                    </div>
                                </div>

                                <!-- Code Content Panels -->
                                <div class="p-5 text-xs sm:text-sm font-mono overflow-x-auto leading-relaxed">
                                    <!-- Tab 1: PHP -->
                                    <div id="code-panel-php" class="code-panel space-y-1">
                                        <div class="text-slate-500">&lt;?php</div>
                                        <div class="text-slate-400"><span class="text-purple-400">namespace</span> Developer\Mutta;</div>
                                        <div class="text-slate-500">// Ready to collaborate and engineer value</div>
                                        <div class="text-slate-300">
                                            <span class="text-indigo-400">class</span> <span class="text-amber-300">Engineer</span> <span class="text-indigo-400">implements</span> <span class="text-cyan-300">FullStackInterface</span> {
                                        </div>
                                        <div class="pl-4 text-slate-300">
                                            <span class="text-indigo-400">public string</span> <span class="text-emerald-400">$name</span> = <span class="text-cyan-300">'<?= htmlspecialchars($profile['name']); ?>'</span>;
                                        </div>
                                        <div class="pl-4 text-slate-300">
                                            <span class="text-indigo-400">public string</span> <span class="text-emerald-400">$role</span> = <span class="text-cyan-300">'Full-Stack Web Developer'</span>;
                                        </div>
                                        <div class="pl-4 text-slate-300">
                                            <span class="text-indigo-400">public array</span> <span class="text-emerald-400">$stack</span> = [
                                        </div>
                                        <div class="pl-8 text-cyan-300">
                                            'PHP 8', 'Laravel', 'React', 'Tailwind', 'MySQL'
                                        </div>
                                        <div class="pl-4 text-slate-300">];</div>
                                        <div class="pl-4 text-slate-300">
                                            <span class="text-indigo-400">public bool</span> <span class="text-emerald-400">$availableForHire</span> = <span class="text-amber-400">true</span>;
                                        </div>
                                        <div class="pl-4 text-slate-300 mt-2">
                                            <span class="text-indigo-400">public function</span> <span class="text-blue-400">buildSolutions</span>(): <span class="text-amber-300">Impact</span> {
                                        </div>
                                        <div class="pl-8 text-slate-300">
                                            <span class="text-indigo-400">return new</span> <span class="text-amber-300">DigitalProduct</span>(<span class="text-cyan-300">'Pixel-Perfect & Scalable'</span>);
                                        </div>
                                        <div class="pl-4 text-slate-300">}</div>
                                        <div class="text-slate-300">}</div>
                                    </div>

                                    <!-- Tab 2: JSON -->
                                    <div id="code-panel-json" class="code-panel space-y-1 hidden">
                                        <div class="text-slate-300">{</div>
                                        <div class="pl-4 text-slate-300"><span class="text-cyan-300">"developer"</span>: <span class="text-amber-300">"Mutta"</span>,</div>
                                        <div class="pl-4 text-slate-300"><span class="text-cyan-300">"experience_years"</span>: <span class="text-purple-400">3</span>,</div>
                                        <div class="pl-4 text-slate-300"><span class="text-cyan-300">"frameworks"</span>: [</div>
                                        <div class="pl-8 text-emerald-300">"Laravel", "React", "Next.js", "Express", "Tailwind CSS"</div>
                                        <div class="pl-4 text-slate-300">],</div>
                                        <div class="pl-4 text-slate-300"><span class="text-cyan-300">"databases"</span>: [<span class="text-emerald-300">"MySQL"</span>, <span class="text-emerald-300">"PostgreSQL"</span>, <span class="text-emerald-300">"Redis"</span>],</div>
                                        <div class="pl-4 text-slate-300"><span class="text-cyan-300">"philosophy"</span>: <span class="text-amber-300">"Clean Code. Fast Load. High Security."</span></div>
                                        <div class="text-slate-300">}</div>
                                    </div>

                                    <!-- Tab 3: Bash -->
                                    <div id="code-panel-bash" class="code-panel space-y-1 hidden">
                                        <div class="text-slate-400"><span class="text-emerald-400">mutta@laragon</span>:<span class="text-cyan-400">~/WebDevelopment</span>$ php artisan serve</div>
                                        <div class="text-slate-300">INFO Server running on [http://127.0.0.1:8000].</div>
                                        <div class="text-slate-300">Press Ctrl+C to stop the server</div>
                                        <div class="text-slate-500 mt-2"># Compiling front-end assets with Vite...</div>
                                        <div class="text-slate-400"><span class="text-emerald-400">mutta@laragon</span>:<span class="text-cyan-400">~/WebDevelopment</span>$ npm run build</div>
                                        <div class="text-emerald-400">✓ 42 modules transformed.</div>
                                        <div class="text-cyan-300">✓ Built in 320ms. Ready for production! 🚀</div>
                                    </div>
                                </div>

                                <!-- Terminal Footer Stats -->
                                <div class="px-4 py-2.5 bg-slate-900/90 border-t border-slate-800/80 flex items-center justify-between text-xs font-mono text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-circle-check text-emerald-400"></i>
                                        <span>Git: main* (clean)</span>
                                    </div>
                                    <span class="text-cyan-400">UTF-8 | PHP 8.1</span>
                                </div>
                            </div>

                            <!-- Floating Mini Badge -->
                            <div class="animate-float absolute -bottom-6 -left-6 glass-card p-3.5 rounded-xl shadow-xl flex items-center gap-3 border border-white/10 hidden sm:flex">
                                <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-bolt"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-400 font-mono">Performance</div>
                                    <div class="text-sm font-bold text-white">99% Core Web Vitals</div>
                                </div>
                            </div>

                            <!-- Floating Mini Badge 2 -->
                            <div class="animate-float-delayed absolute -top-6 -right-6 glass-card p-3 rounded-xl shadow-xl flex items-center gap-3 border border-white/10 hidden sm:flex">
                                <div class="w-9 h-9 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-base">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-400 font-mono">Architecture</div>
                                    <div class="text-xs font-bold text-white">Clean MVC & REST</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ==================================================================
             STATISTICS BANNER
             ================================================================== -->
        <section id="stats-section" class="py-10 border-y border-white/5 bg-slate-900/40 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    
                    <!-- Stat 1 -->
                    <div class="glass-card p-6 rounded-2xl text-center group">
                        <div class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 mb-1 stat-counter font-mono" data-target="3" data-suffix="+">
                            0
                        </div>
                        <div class="text-xs sm:text-sm font-medium text-slate-400 uppercase tracking-wider">Years Experience</div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="glass-card p-6 rounded-2xl text-center group">
                        <div class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500 mb-1 stat-counter font-mono" data-target="35" data-suffix="+">
                            0
                        </div>
                        <div class="text-xs sm:text-sm font-medium text-slate-400 uppercase tracking-wider">Completed Projects</div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="glass-card p-6 rounded-2xl text-center group">
                        <div class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-500 mb-1 stat-counter font-mono" data-target="99.4" data-suffix="%" data-decimals="1">
                            0
                        </div>
                        <div class="text-xs sm:text-sm font-medium text-slate-400 uppercase tracking-wider">Client Satisfaction</div>
                    </div>

                    <!-- Stat 4 -->
                    <div class="glass-card p-6 rounded-2xl text-center group">
                        <div class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-rose-500 mb-1 stat-counter font-mono" data-target="18" data-suffix="+">
                            0
                        </div>
                        <div class="text-xs sm:text-sm font-medium text-slate-400 uppercase tracking-wider">APIs & Systems Built</div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ==================================================================
             ABOUT ME SECTION
             ================================================================== -->
        <section id="about" class="py-20 lg:py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-mono uppercase tracking-widest text-cyan-400 bg-cyan-500/10 px-3.5 py-1.5 rounded-full border border-cyan-500/20">
                        Behind The Code
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 tracking-tight">
                        About <span class="text-gradient">Mutta</span>
                    </h2>
                    <p class="text-slate-400 mt-3 text-base">
                        Dedicated to creating impactful digital software with purpose, precision, and passion.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                    
                    <!-- Left: Profile Snapshot Card (5 Cols) -->
                    <div class="lg:col-span-5">
                        <div class="glass-card rounded-2xl p-6 sm:p-8 relative overflow-hidden">
                            <!-- Background gradient flare -->
                            <div class="absolute -top-16 -right-16 w-36 h-36 bg-indigo-500/20 rounded-full blur-2xl"></div>

                            <div class="flex flex-col items-center text-center">
                                <!-- Modern Geometric / Avatar Frame -->
                                <div class="relative mb-5 group">
                                    <div class="w-32 h-32 rounded-2xl bg-gradient-to-tr from-cyan-500 via-indigo-600 to-purple-600 p-1 shadow-xl shadow-indigo-500/20">
                                        <div class="w-full h-full rounded-2xl bg-[#0d1322] flex flex-col items-center justify-center text-white relative overflow-hidden">
                                            <span class="text-4xl font-black font-mono text-cyan-400">M</span>
                                            <span class="text-[10px] font-mono tracking-widest text-slate-400 mt-1">MUTTA</span>
                                        </div>
                                    </div>
                                    <span class="absolute -bottom-2 -right-2 px-2.5 py-1 rounded-full bg-emerald-500 text-black text-[10px] font-bold uppercase tracking-wider shadow">
                                        Active
                                    </span>
                                </div>

                                <h3 class="text-2xl font-bold text-white"><?= htmlspecialchars($profile['name']); ?></h3>
                                <p class="text-sm font-mono text-cyan-400 mt-1"><?= htmlspecialchars($profile['title']); ?></p>
                                
                                <p class="text-xs text-slate-400 mt-3 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-rose-400"></i>
                                    <?= htmlspecialchars($profile['location']); ?>
                                </p>

                                <div class="w-full border-t border-slate-800 my-6"></div>

                                <!-- Quick Highlights List -->
                                <div class="w-full space-y-3 text-left text-xs font-mono text-slate-300">
                                    <div class="flex items-center justify-between py-1 border-b border-slate-800/60">
                                        <span class="text-slate-400">Experience</span>
                                        <span class="text-white font-semibold"><?= htmlspecialchars($profile['years_exp']); ?> Years</span>
                                    </div>
                                    <div class="flex items-center justify-between py-1 border-b border-slate-800/60">
                                        <span class="text-slate-400">Specialization</span>
                                        <span class="text-cyan-400 font-semibold">PHP / Laravel / React</span>
                                    </div>
                                    <div class="flex items-center justify-between py-1 border-b border-slate-800/60">
                                        <span class="text-slate-400">Availability</span>
                                        <span class="text-emerald-400 font-semibold">Immediate</span>
                                    </div>
                                    <div class="flex items-center justify-between py-1">
                                        <span class="text-slate-400">Languages</span>
                                        <span class="text-white font-semibold">English & Indonesian</span>
                                    </div>
                                </div>

                                <div class="w-full mt-6">
                                    <a href="#contact" class="btn-glow block w-full text-center py-3 rounded-xl font-semibold text-xs uppercase tracking-wider text-white bg-gradient-to-r from-cyan-500 to-indigo-600 shadow-md">
                                        Connect With Mutta
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Story & 4 Pillars (7 Cols) -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="glass-card p-6 sm:p-8 rounded-2xl">
                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-4">
                                Bridging Modern Front-End Design With Enterprise-Grade Architecture
                            </h3>
                            <p class="text-slate-300 leading-relaxed text-sm sm:text-base mb-4">
                                <?= htmlspecialchars($profile['bio']); ?>
                            </p>
                            <p class="text-slate-400 leading-relaxed text-sm">
                                My philosophy is centered around building sustainable software: writing clean, self-documenting code, structuring intuitive relational databases, optimizing Core Web Vitals, and maintaining seamless communication throughout each development sprint.
                            </p>
                        </div>

                        <!-- 4 Core Pillars Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            
                            <!-- Pillar 1 -->
                            <div class="glass-card p-5 rounded-xl border border-white/5 hover:border-cyan-500/40 transition-all">
                                <div class="w-10 h-10 rounded-lg bg-cyan-500/10 text-cyan-400 flex items-center justify-center text-lg mb-3">
                                    <i class="fa-solid fa-code"></i>
                                </div>
                                <h4 class="text-white font-semibold text-base mb-1">Clean & Scalable Code</h4>
                                <p class="text-slate-400 text-xs leading-relaxed">
                                    Adhering to SOLID principles, DRY standards, and modular architectures that grow effortlessly.
                                </p>
                            </div>

                            <!-- Pillar 2 -->
                            <div class="glass-card p-5 rounded-xl border border-white/5 hover:border-indigo-500/40 transition-all">
                                <div class="w-10 h-10 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-lg mb-3">
                                    <i class="fa-solid fa-bolt"></i>
                                </div>
                                <h4 class="text-white font-semibold text-base mb-1">High Velocity & Speed</h4>
                                <p class="text-slate-400 text-xs leading-relaxed">
                                    Optimized database queries, browser caching, and micro-benchmarking for instantaneous load speeds.
                                </p>
                            </div>

                            <!-- Pillar 3 -->
                            <div class="glass-card p-5 rounded-xl border border-white/5 hover:border-purple-500/40 transition-all">
                                <div class="w-10 h-10 rounded-lg bg-purple-500/10 text-purple-400 flex items-center justify-center text-lg mb-3">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>
                                <h4 class="text-white font-semibold text-base mb-1">Pixel-Perfect UI/UX</h4>
                                <p class="text-slate-400 text-xs leading-relaxed">
                                    Transforming creative ideas into fully responsive, accessible, and delightful interfaces on every device.
                                </p>
                            </div>

                            <!-- Pillar 4 -->
                            <div class="glass-card p-5 rounded-xl border border-white/5 hover:border-emerald-500/40 transition-all">
                                <div class="w-10 h-10 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-lg mb-3">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <h4 class="text-white font-semibold text-base mb-1">Security & Best Practices</h4>
                                <p class="text-slate-400 text-xs leading-relaxed">
                                    Robust sanitization, CSRF & XSS prevention, encryption, and secure authentication flows by default.
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ==================================================================
             SKILLS & TECH STACK SECTION
             ================================================================== -->
        <section id="skills" class="py-20 lg:py-28 bg-slate-900/30 border-t border-white/5 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <span class="text-xs font-mono uppercase tracking-widest text-indigo-400 bg-indigo-500/10 px-3.5 py-1.5 rounded-full border border-indigo-500/20">
                        Technical Arsenal
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 tracking-tight">
                        Skills & <span class="text-gradient">Technologies</span>
                    </h2>
                    <p class="text-slate-400 mt-3 text-base">
                        A curated toolkit honed through production environments and real-world software delivery.
                    </p>

                    <!-- Filter Tabs -->
                    <div class="flex flex-wrap items-center justify-center gap-2 mt-8">
                        <button type="button" class="skill-filter-btn px-4 py-2 rounded-xl text-xs font-mono font-medium border border-indigo-500 text-indigo-400 bg-indigo-500/10 transition-all" data-skill-filter="all">
                            All Technologies
                        </button>
                        <button type="button" class="skill-filter-btn px-4 py-2 rounded-xl text-xs font-mono font-medium border border-transparent text-slate-400 hover:text-slate-200 transition-all" data-skill-filter="frontend">
                            Frontend
                        </button>
                        <button type="button" class="skill-filter-btn px-4 py-2 rounded-xl text-xs font-mono font-medium border border-transparent text-slate-400 hover:text-slate-200 transition-all" data-skill-filter="backend">
                            Backend & APIs
                        </button>
                        <button type="button" class="skill-filter-btn px-4 py-2 rounded-xl text-xs font-mono font-medium border border-transparent text-slate-400 hover:text-slate-200 transition-all" data-skill-filter="database">
                            Databases
                        </button>
                        <button type="button" class="skill-filter-btn px-4 py-2 rounded-xl text-xs font-mono font-medium border border-transparent text-slate-400 hover:text-slate-200 transition-all" data-skill-filter="devops">
                            DevOps & Tools
                        </button>
                    </div>
                </div>

                <!-- Skills Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="skills-container">
                    <?php foreach ($skills as $skill): ?>
                        <div class="skill-item glass-card p-5 rounded-2xl flex flex-col justify-between group" data-category="<?= htmlspecialchars($skill['category']); ?>">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                                            <i class="<?= htmlspecialchars($skill['icon']); ?>"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-semibold text-sm sm:text-base group-hover:text-cyan-400 transition-colors">
                                                <?= htmlspecialchars($skill['name']); ?>
                                            </h4>
                                            <span class="text-[11px] font-mono uppercase text-slate-400"><?= htmlspecialchars($skill['category']); ?></span>
                                        </div>
                                    </div>
                                    <span class="text-xs font-mono font-semibold px-2.5 py-1 rounded-full bg-slate-800 text-indigo-300 border border-indigo-500/20">
                                        <?= htmlspecialchars($skill['level']); ?>
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400 leading-relaxed mb-4">
                                    <?= htmlspecialchars($skill['description']); ?>
                                </p>
                            </div>

                            <!-- Progress Bar -->
                            <div>
                                <div class="flex items-center justify-between text-xs font-mono text-slate-400 mb-1.5">
                                    <span>Proficiency</span>
                                    <span class="text-cyan-400 font-semibold"><?= (int)$skill['progress']; ?>%</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-cyan-400 to-indigo-500 rounded-full transition-all duration-1000" style="width: <?= (int)$skill['progress']; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- ==================================================================
             FEATURED PROJECTS SECTION
             ================================================================== -->
        <section id="projects" class="py-20 lg:py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                    <div>
                        <span class="text-xs font-mono uppercase tracking-widest text-cyan-400 bg-cyan-500/10 px-3.5 py-1.5 rounded-full border border-cyan-500/20">
                            Portfolio Showcase
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 tracking-tight">
                            Featured <span class="text-gradient">Projects</span>
                        </h2>
                        <p class="text-slate-400 mt-2 text-base max-w-xl">
                            Real-world web solutions engineered with performance, scalability, and UX craftsmanship.
                        </p>
                    </div>

                    <!-- Category Filter Buttons -->
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" class="project-filter-btn px-4 py-2 rounded-xl text-xs font-mono font-medium bg-indigo-600 text-white shadow-lg shadow-indigo-500/25 transition-all" data-filter="all">
                            All (<?= count($projects); ?>)
                        </button>
                        <button type="button" class="project-filter-btn px-4 py-2 rounded-xl text-xs font-mono font-medium bg-slate-800/50 text-slate-400 hover:text-white border border-slate-700/60 transition-all" data-filter="fullstack">
                            Full-Stack
                        </button>
                        <button type="button" class="project-filter-btn px-4 py-2 rounded-xl text-xs font-mono font-medium bg-slate-800/50 text-slate-400 hover:text-white border border-slate-700/60 transition-all" data-filter="frontend">
                            Frontend
                        </button>
                        <button type="button" class="project-filter-btn px-4 py-2 rounded-xl text-xs font-mono font-medium bg-slate-800/50 text-slate-400 hover:text-white border border-slate-700/60 transition-all" data-filter="backend">
                            Backend & API
                        </button>
                    </div>
                </div>

                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="projects-grid">
                    <?php foreach ($projects as $project): ?>
                        <div class="project-card glass-card rounded-2xl overflow-hidden flex flex-col justify-between group"
                             data-category="<?= htmlspecialchars($project['category']); ?>"
                             data-title="<?= htmlspecialchars($project['title']); ?>"
                             data-category-label="<?= htmlspecialchars($project['category_label']); ?>"
                             data-description="<?= htmlspecialchars($project['description']); ?>"
                             data-tech="<?= htmlspecialchars(implode(',', $project['tech'])); ?>"
                             data-highlights="<?= htmlspecialchars($project['highlights']); ?>"
                             data-live="<?= htmlspecialchars($project['live']); ?>"
                             data-repo="<?= htmlspecialchars($project['repo']); ?>"
                             data-gradient="<?= htmlspecialchars($project['gradient']); ?>">
                            
                            <!-- Project Banner / Mockup Preview -->
                            <div class="relative h-48 w-full bg-gradient-to-tr <?= htmlspecialchars($project['gradient']); ?> p-6 flex flex-col justify-between overflow-hidden">
                                <!-- Mesh overlay -->
                                <div class="absolute inset-0 bg-black/25 backdrop-blur-[1px] group-hover:backdrop-blur-none transition-all"></div>
                                
                                <div class="relative z-10 flex items-center justify-between">
                                    <span class="text-[10px] font-mono uppercase tracking-wider bg-black/50 text-cyan-300 px-3 py-1 rounded-full backdrop-blur-md border border-white/10">
                                        <?= htmlspecialchars($project['category_label']); ?>
                                    </span>
                                    <span class="text-[10px] font-semibold bg-white/20 text-white px-2.5 py-0.5 rounded-full backdrop-blur-md">
                                        <?= htmlspecialchars($project['badge']); ?>
                                    </span>
                                </div>

                                <div class="relative z-10">
                                    <h3 class="text-xl font-bold text-white tracking-tight group-hover:translate-x-1 transition-transform">
                                        <?= htmlspecialchars($project['title']); ?>
                                    </h3>
                                    <p class="text-xs text-slate-200 line-clamp-1 mt-0.5 opacity-90">
                                        <?= htmlspecialchars($project['subtitle']); ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <p class="text-xs sm:text-sm text-slate-300 line-clamp-3 leading-relaxed mb-4">
                                        <?= htmlspecialchars($project['description']); ?>
                                    </p>

                                    <!-- Tech Badges -->
                                    <div class="flex flex-wrap gap-1.5 mb-6">
                                        <?php foreach (array_slice($project['tech'], 0, 4) as $t): ?>
                                            <span class="tech-pill text-[11px]"><?= htmlspecialchars($t); ?></span>
                                        <?php endforeach; ?>
                                        <?php if (count($project['tech']) > 4): ?>
                                            <span class="tech-pill text-[11px]">+<?= count($project['tech']) - 4; ?> more</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="pt-4 border-t border-slate-800 flex items-center justify-between gap-3 text-xs font-mono">
                                    <button type="button" class="view-project-details text-cyan-400 hover:text-cyan-300 font-semibold flex items-center gap-1.5 transition-colors">
                                        <i class="fa-solid fa-circle-info"></i> Details
                                    </button>
                                    
                                    <div class="flex items-center gap-3">
                                        <a href="<?= htmlspecialchars($project['repo']); ?>" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors" title="Source Code">
                                            <i class="fa-brands fa-github text-base"></i> Code
                                        </a>
                                        <a href="<?= htmlspecialchars($project['live']); ?>" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-indigo-400 transition-colors" title="Live Preview">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-sm"></i> Live
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- ==================================================================
             SERVICES SECTION (WHAT I DELIVER)
             ================================================================== -->
        <section id="services" class="py-20 lg:py-28 bg-slate-900/30 border-t border-white/5 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-mono uppercase tracking-widest text-emerald-400 bg-emerald-500/10 px-3.5 py-1.5 rounded-full border border-emerald-500/20">
                        Capabilities & Value
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 tracking-tight">
                        Services & <span class="text-gradient">Solutions</span>
                    </h2>
                    <p class="text-slate-400 mt-3 text-base">
                        From zero to production — end-to-end development tailored to your exact business objectives.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($services as $srv): ?>
                        <div class="glass-card p-8 rounded-2xl relative overflow-hidden group">
                            <div class="w-12 h-12 rounded-xl bg-slate-800/80 border border-slate-700/80 flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform">
                                <i class="<?= htmlspecialchars($srv['icon']); ?>"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">
                                <?= htmlspecialchars($srv['title']); ?>
                            </h3>
                            <p class="text-slate-300 text-sm leading-relaxed mb-6">
                                <?= htmlspecialchars($srv['desc']); ?>
                            </p>
                            
                            <ul class="space-y-2.5">
                                <?php foreach ($srv['features'] as $f): ?>
                                    <li class="flex items-center gap-2.5 text-xs text-slate-300">
                                        <i class="fa-solid fa-check text-emerald-400 text-xs"></i>
                                        <span><?= htmlspecialchars($f); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- ==================================================================
             WORK EXPERIENCE & JOURNEY TIMELINE
             ================================================================== -->
        <section id="experience" class="py-20 lg:py-28 relative">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-mono uppercase tracking-widest text-purple-400 bg-purple-500/10 px-3.5 py-1.5 rounded-full border border-purple-500/20">
                        Career Progression
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 tracking-tight">
                        Experience & <span class="text-gradient">Milestones</span>
                    </h2>
                    <p class="text-slate-400 mt-3 text-base">
                        My journey building software, collaborating with cross-functional teams, and mastering the craft.
                    </p>
                </div>

                <!-- Timeline Container -->
                <div class="timeline-track space-y-12">
                    <?php foreach ($timeline as $index => $item): ?>
                        <div class="relative flex flex-col md:flex-row <?= ($index % 2 === 0) ? 'md:flex-row-reverse' : ''; ?> items-start md:items-center gap-6">
                            
                            <!-- Timeline Dot Node -->
                            <div class="absolute left-6 md:left-1/2 transform -translate-x-1/2 w-8 h-8 rounded-full bg-slate-900 border-2 border-indigo-500 shadow-md shadow-indigo-500/30 flex items-center justify-center z-10">
                                <span class="w-2.5 h-2.5 rounded-full bg-cyan-400"></span>
                            </div>

                            <!-- Content Card (Half Width) -->
                            <div class="ml-16 md:ml-0 md:w-1/2 <?= ($index % 2 === 0) ? 'md:pl-10 text-left' : 'md:pr-10 md:text-right'; ?>">
                                <div class="glass-card p-6 rounded-2xl relative group">
                                    <div class="flex items-center gap-2 <?= ($index % 2 === 0) ? '' : 'md:justify-end'; ?> mb-2">
                                        <span class="text-xs font-mono px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                            <?= htmlspecialchars($item['period']); ?>
                                        </span>
                                        <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-slate-800 text-slate-300">
                                            <?= htmlspecialchars($item['badge']); ?>
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-bold text-white group-hover:text-cyan-400 transition-colors">
                                        <?= htmlspecialchars($item['role']); ?>
                                    </h3>
                                    <p class="text-xs font-mono text-cyan-400 mb-3">
                                        @ <?= htmlspecialchars($item['company']); ?>
                                    </p>
                                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                                        <?= htmlspecialchars($item['description']); ?>
                                    </p>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- ==================================================================
             CLIENT TESTIMONIALS & ENDORSEMENTS
             ================================================================== -->
        <section class="py-20 lg:py-24 bg-slate-900/40 border-t border-white/5 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-mono uppercase tracking-widest text-amber-400 bg-amber-500/10 px-3.5 py-1.5 rounded-full border border-amber-500/20">
                        Social Proof
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 tracking-tight">
                        Client & Colleague <span class="text-gradient">Endorsements</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php foreach ($testimonials as $t): ?>
                        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between">
                            <div>
                                <div class="text-cyan-400 text-2xl mb-3">
                                    <i class="fa-solid fa-quote-left opacity-60"></i>
                                </div>
                                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed italic mb-6">
                                    "<?= htmlspecialchars($t['quote']); ?>"
                                </p>
                            </div>
                            <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-cyan-500 flex items-center justify-center font-bold text-xs text-white">
                                    <?= htmlspecialchars($t['avatar']); ?>
                                </div>
                                <div>
                                    <h4 class="text-white text-xs sm:text-sm font-semibold"><?= htmlspecialchars($t['author']); ?></h4>
                                    <span class="text-[11px] text-slate-400"><?= htmlspecialchars($t['role']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- ==================================================================
             INTERACTIVE CONTACT SECTION
             ================================================================== -->
        <section id="contact" class="py-20 lg:py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    
                    <!-- Left: Contact Details & Status (5 Cols) -->
                    <div class="lg:col-span-5 space-y-6">
                        <div>
                            <span class="text-xs font-mono uppercase tracking-widest text-cyan-400 bg-cyan-500/10 px-3.5 py-1.5 rounded-full border border-cyan-500/20">
                                Start A Conversation
                            </span>
                            <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 tracking-tight">
                                Let's Build Something <span class="text-gradient">Extraordinary</span>
                            </h2>
                            <p class="text-slate-300 mt-3 text-sm sm:text-base leading-relaxed">
                                Have an exciting project in mind, need full-stack expertise, or looking to add a dedicated engineer to your team? My inbox is always open.
                            </p>
                        </div>

                        <!-- Contact Channels List -->
                        <div class="space-y-4 pt-2">
                            
                            <!-- Email Card with Copy Trigger -->
                            <div class="glass-card p-4 rounded-xl flex items-center justify-between">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-lg">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                    <div>
                                        <span class="text-[11px] font-mono text-slate-400 block">Direct Email</span>
                                        <a href="mailto:<?= htmlspecialchars($profile['email']); ?>" class="text-sm font-medium text-white hover:text-cyan-400 transition-colors">
                                            <?= htmlspecialchars($profile['email']); ?>
                                        </a>
                                    </div>
                                </div>
                                <button type="button" class="copy-email-btn w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white flex items-center justify-center transition-colors" data-email="<?= htmlspecialchars($profile['email']); ?>" title="Copy Email">
                                    <i class="fa-regular fa-copy text-sm"></i>
                                </button>
                            </div>

                            <!-- Location Card -->
                            <div class="glass-card p-4 rounded-xl flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-lg bg-cyan-500/10 text-cyan-400 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <span class="text-[11px] font-mono text-slate-400 block">Location & Remote</span>
                                    <span class="text-sm font-medium text-white"><?= htmlspecialchars($profile['location']); ?></span>
                                </div>
                            </div>

                            <!-- Availability Card -->
                            <div class="glass-card p-4 rounded-xl flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div>
                                    <span class="text-[11px] font-mono text-slate-400 block">Typical Response Time</span>
                                    <span class="text-sm font-medium text-white">Within 12 - 24 Hours</span>
                                </div>
                            </div>

                        </div>

                        <!-- Social Network Icons -->
                        <div class="pt-4">
                            <span class="text-xs uppercase font-mono tracking-wider text-slate-400 block mb-3">Other Profiles:</span>
                            <div class="flex items-center gap-3">
                                <a href="<?= htmlspecialchars($profile['github']); ?>" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-xs font-mono text-slate-300 hover:text-white flex items-center gap-2 border border-slate-700 transition-all">
                                    <i class="fa-brands fa-github text-sm"></i> GitHub
                                </a>
                                <a href="<?= htmlspecialchars($profile['linkedin']); ?>" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-xs font-mono text-slate-300 hover:text-cyan-400 flex items-center gap-2 border border-slate-700 transition-all">
                                    <i class="fa-brands fa-linkedin text-sm"></i> LinkedIn
                                </a>
                                <a href="<?= htmlspecialchars($profile['twitter']); ?>" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-xs font-mono text-slate-300 hover:text-cyan-400 flex items-center gap-2 border border-slate-700 transition-all">
                                    <i class="fa-brands fa-x-twitter text-sm"></i> X (Twitter)
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Modern Contact Form (7 Cols) -->
                    <div class="lg:col-span-7">
                        <div class="glass-card rounded-2xl p-6 sm:p-8 border border-white/10 relative">
                            <h3 class="text-xl font-bold text-white mb-2">Send a Message</h3>
                            <p class="text-xs text-slate-400 mb-6">Fill in the form below and I'll receive your direct dispatch immediately.</p>

                            <form id="contact-form" action="#contact" method="POST" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    
                                    <!-- Name Field -->
                                    <div>
                                        <label class="block text-xs font-mono text-slate-300 mb-1.5" for="name">
                                            Your Name <span class="text-rose-400">*</span>
                                        </label>
                                        <input type="text" id="name" name="name" required placeholder="e.g. John Doe"
                                               class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-700/80 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                                    </div>

                                    <!-- Email Field -->
                                    <div>
                                        <label class="block text-xs font-mono text-slate-300 mb-1.5" for="email">
                                            Your Email <span class="text-rose-400">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" required placeholder="e.g. john@example.com"
                                               class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-700/80 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                                    </div>

                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    
                                    <!-- Subject Field -->
                                    <div>
                                        <label class="block text-xs font-mono text-slate-300 mb-1.5" for="subject">
                                            Subject
                                        </label>
                                        <input type="text" id="subject" name="subject" placeholder="e.g. Project Inquiry / Opportunity"
                                               class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-700/80 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                                    </div>

                                    <!-- Service Needed Dropdown -->
                                    <div>
                                        <label class="block text-xs font-mono text-slate-300 mb-1.5" for="service">
                                            Service Interested In
                                        </label>
                                        <select id="service" name="service"
                                                class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                                            <option value="Full-Stack Web App">Full-Stack Web App Development</option>
                                            <option value="Frontend UI/UX">Modern Frontend & UI Craft</option>
                                            <option value="Backend API / Laravel">PHP / Laravel Backend & APIs</option>
                                            <option value="Performance / Audit">Speed & Codebase Audit</option>
                                            <option value="Other Consultation">Other Collaboration</option>
                                        </select>
                                    </div>

                                </div>

                                <!-- Message Body -->
                                <div>
                                    <label class="block text-xs font-mono text-slate-300 mb-1.5" for="message">
                                        Your Message <span class="text-rose-400">*</span>
                                    </label>
                                    <textarea id="message" name="message" rows="5" required placeholder="Tell me about your goals, timelines, or questions..."
                                              class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-700/80 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"></textarea>
                                </div>

                                <input type="hidden" name="contact_submit" value="1">

                                <!-- Submit Button -->
                                <button type="submit" class="btn-glow w-full py-3.5 rounded-xl font-semibold text-sm uppercase tracking-wider text-white bg-gradient-to-r from-cyan-500 via-indigo-600 to-purple-600 hover:from-cyan-400 hover:to-purple-500 shadow-lg shadow-indigo-500/25 transition-all flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-paper-plane text-xs"></i> Send Dispatch Message
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>

    <!-- ======================================================================
         MODAL: PROJECT DETAILS
         ====================================================================== -->
    <div id="project-modal" class="fixed inset-0 z-50 modal-backdrop hidden flex items-center justify-center p-4">
        <div class="glass-card max-w-2xl w-full rounded-2xl overflow-hidden shadow-2xl border border-white/20 animate-fadeIn">
            
            <!-- Modal Header / Banner -->
            <div id="modal-image" class="w-full h-48 bg-gradient-to-tr from-indigo-600 to-cyan-500 p-6 flex flex-col justify-end text-white relative">
                <button id="modal-close-btn" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-black/60 text-white flex items-center justify-center hover:bg-black/80 transition-colors z-20">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 max-h-[70vh] overflow-y-auto space-y-6">
                <div>
                    <span id="modal-category" class="text-xs font-mono uppercase text-cyan-400 font-semibold tracking-wider">Category</span>
                    <h3 id="modal-title" class="text-2xl font-bold text-white mt-1">Project Name</h3>
                </div>

                <div>
                    <h4 class="text-xs uppercase font-mono tracking-wider text-slate-400 mb-2">Overview</h4>
                    <p id="modal-description" class="text-slate-300 text-sm leading-relaxed"></p>
                </div>

                <div>
                    <h4 class="text-xs uppercase font-mono tracking-wider text-slate-400 mb-2">Architecture & Highlights</h4>
                    <ul id="modal-highlights" class="space-y-2"></ul>
                </div>

                <div>
                    <h4 class="text-xs uppercase font-mono tracking-wider text-slate-400 mb-2">Technologies Used</h4>
                    <div id="modal-tech-stack" class="flex flex-wrap gap-2"></div>
                </div>

                <div class="pt-4 border-t border-slate-800 flex items-center justify-end gap-3">
                    <a id="modal-repo-link" href="#" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl text-xs font-mono bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors flex items-center gap-1.5">
                        <i class="fa-brands fa-github text-sm"></i> View Source
                    </a>
                    <a id="modal-live-link" href="#" target="_blank" rel="noopener noreferrer" class="btn-glow px-4 py-2.5 rounded-xl text-xs font-mono font-semibold text-white bg-gradient-to-r from-cyan-500 to-indigo-600 shadow-md flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> Open Live Project
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- ======================================================================
         MOBILE BOTTOM NAVIGATION BAR (FLOATING DOCK)
         ====================================================================== -->
    <nav id="mobile-bottom-bar" aria-label="Mobile Navigation Bar" class="fixed bottom-3 left-3 right-3 z-40 md:hidden flex justify-center pointer-events-none">
        <div class="glass-bottom-bar w-full max-w-md px-2 py-1.5 rounded-2xl flex items-center justify-around shadow-2xl pointer-events-auto">
            <a href="#hero" class="mobile-bottom-link flex flex-col items-center justify-center py-1 px-3 rounded-xl transition-all active" data-section="hero">
                <div class="icon-wrap w-8 h-8 rounded-lg flex items-center justify-center transition-all">
                    <i class="fa-solid fa-house text-sm"></i>
                </div>
                <span class="text-[10px] font-mono tracking-tight mt-0.5">Home</span>
            </a>
            <a href="#about" class="mobile-bottom-link flex flex-col items-center justify-center py-1 px-3 rounded-xl transition-all" data-section="about">
                <div class="icon-wrap w-8 h-8 rounded-lg flex items-center justify-center transition-all">
                    <i class="fa-solid fa-user text-sm"></i>
                </div>
                <span class="text-[10px] font-mono tracking-tight mt-0.5">About</span>
            </a>
            <a href="#skills" class="mobile-bottom-link flex flex-col items-center justify-center py-1 px-3 rounded-xl transition-all" data-section="skills">
                <div class="icon-wrap w-8 h-8 rounded-lg flex items-center justify-center transition-all">
                    <i class="fa-solid fa-code text-sm"></i>
                </div>
                <span class="text-[10px] font-mono tracking-tight mt-0.5">Skills</span>
            </a>
            <a href="#projects" class="mobile-bottom-link flex flex-col items-center justify-center py-1 px-3 rounded-xl transition-all" data-section="projects">
                <div class="icon-wrap w-8 h-8 rounded-lg flex items-center justify-center transition-all">
                    <i class="fa-solid fa-briefcase text-sm"></i>
                </div>
                <span class="text-[10px] font-mono tracking-tight mt-0.5">Projects</span>
            </a>
            <a href="#contact" class="mobile-bottom-link flex flex-col items-center justify-center py-1 px-3 rounded-xl transition-all" data-section="contact">
                <div class="icon-wrap w-8 h-8 rounded-lg flex items-center justify-center transition-all">
                    <i class="fa-solid fa-paper-plane text-sm"></i>
                </div>
                <span class="text-[10px] font-mono tracking-tight mt-0.5">Contact</span>
            </a>
        </div>
    </nav>

    <!-- ======================================================================
         BACK TO TOP FLOATING BUTTON
         ====================================================================== -->
    <button id="back-to-top" type="button" aria-label="Back to Top"
            class="fixed bottom-20 right-4 md:bottom-6 md:right-6 z-40 w-11 h-11 rounded-xl bg-slate-800/90 text-cyan-400 border border-slate-700 hover:bg-indigo-600 hover:text-white shadow-xl transition-all duration-300 flex items-center justify-center opacity-0 pointer-events-none">
        <i class="fa-solid fa-arrow-up text-sm"></i>
    </button>

    <!-- ======================================================================
         FOOTER
         ====================================================================== -->
    <footer class="py-12 pb-24 md:pb-12 border-t border-white/10 relative z-10 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                
                <!-- Brand Info -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-cyan-500 to-indigo-600 flex items-center justify-center font-mono font-bold text-sm text-white">
                        M
                    </div>
                    <div>
                        <span class="text-sm font-bold brand-text font-mono">
                            <span class="text-cyan-400">&lt;</span><?= htmlspecialchars($profile['name']); ?><span class="text-indigo-400">.dev/&gt;</span>
                        </span>
                        <span class="text-xs text-slate-500 block">Crafting modern web software</span>
                    </div>
                </div>

                <!-- Copyright Note -->
                <div class="text-center md:text-right text-xs text-slate-500 font-mono">
                    <p>&copy; <?= date('Y'); ?> <?= htmlspecialchars($profile['name']); ?>. All rights reserved.</p>
                    <p class="mt-1 text-slate-600">Engineered with PHP, Tailwind CSS & JavaScript.</p>
                </div>

            </div>
        </div>
    </footer>

    <!-- Main JavaScript Logic -->
    <script src="assets/js/main.js"></script>
</body>
</html>
