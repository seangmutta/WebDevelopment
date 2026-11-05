# Mutta — Modern Web Developer Portfolio Profile 🚀

A high-performance, aesthetically crafted personal developer portfolio profile designed for **Mutta**. Built with modern PHP, Tailwind CSS, custom glassmorphism, responsive micro-interactions, and functional contact messaging.

---

## ✨ Features & Highlights

- **Modern Visual Identity**:
  - Dark mode by default with glowing radial mesh gradients and ambient lighting.
  - Interactive Light / Dark mode toggle switch with preference persistence (`localStorage`), with synchronized desktop and mobile toggles.
  - Crisp adaptive top navigation and mobile drawer supporting both Dark and Light themes.
  - Frosted glassmorphism panels (`backdrop-filter`) and glowing hover states.
  - Custom Mac-style code terminal with interactive tabs (`Mutta.php`, `stack.json`, `run.sh`).
  - Clean typography powered by **Plus Jakarta Sans** and **JetBrains Mono**.

- **Interactive Sections & Mobile Experience**:
  - **Mobile Bottom Navigation Dock**: Ultra-sleek floating glassmorphic bar on mobile devices (`Home`, `About`, `Skills`, `Projects`, `Contact`) with active tab detection, glowing indicator, and tactile feedback.
  - **Hero Section**: Pulsing availability badge, punchy bio, quick CTA action buttons, and animated stat badges.
  - **Live Statistics Banner**: Animated number counters (Years of Experience, Projects, Client Satisfaction, APIs).
  - **About Me**: Narrative story, personal facts, and 4 core engineering pillars.
  - **Skills & Tech Matrix**: Filterable by category (*Frontend*, *Backend*, *Databases*, *DevOps*) with animated proficiency bars.
  - **Featured Projects Showcase**: Category filtering (*Full-Stack*, *Frontend*, *Backend*), gradient mockups, live tech pills, and an interactive **Project Details Modal**.
  - **Services & Solutions**: Clear breakdown of core offerings and value propositions.
  - **Career Roadmap**: Illuminated vertical timeline of work experience and milestones.
  - **Client Endorsements**: Social proof cards highlighting feedback and endorsements.
  - **Working Contact Form**:
    - Dual handling: Async AJAX submission with animated toast notifications, plus standard PHP POST fallback.
    - Automatic JSON message storage in `storage/messages.json`.
    - One-click "Copy Email" button with instant feedback tooltip.

---

## 📁 Project Structure

```text
c:\laragon\www\WebDevelopment\
├── index.php                 # Main application & dynamic profile configuration
├── assets/
│   ├── css/
│   │   └── style.css         # Glassmorphism, glow effects, custom scrollbars, animations
│   ├── js/
│   │   └── main.js           # Theme toggle, scrollspy, filters, modal, AJAX form handler
│   └── images/               # Media assets and icons
├── storage/
│   └── messages.json         # Incoming contact form messages
└── README.md                 # Project documentation
```

---

## 🚀 How to Run Locally

### Option 1: Via Laragon (Recommended)
1. Open the **Laragon** control panel.
2. Click **Start All** (starts Apache and MySQL).
3. Open your browser and navigate to:
   ```text
   http://localhost/WebDevelopment
   ```
   *(or `http://webdevelopment.test` if Laragon auto-virtual hosts is enabled)*

### Option 2: Via PHP Built-in Server
Open your terminal in `C:\laragon\www\WebDevelopment` and run:
```bash
C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe -S localhost:8000
```
Then visit: [http://localhost:8000](http://localhost:8000)

---

## 🛠️ How to Customize

All content is cleanly organized in PHP arrays near the top of [index.php](file:///c:/laragon/www/WebDevelopment/index.php):

1. **Personal Information**:
   Update the `$profile` array (name, bio, location, email, phone, social URLs).
2. **Skills Matrix**:
   Add, remove, or modify items in the `$skills` array.
3. **Projects Showcase**:
   Add new projects or update existing case studies in the `$projects` array.
4. **Experience & Education**:
   Update roles and dates in the `$timeline` array.
5. **Services**:
   Customize offerings and feature lists in the `$services` array.

---

## 📬 Contact Form Inbox

When visitors submit messages through the contact form, they are automatically stored in:
- `storage/messages.json`

Each message includes:
- Submission ID
- Sender Name & Email
- Subject & Service Category
- Message Text
- Client IP & Timestamp

---

*Designed & Engineered with modern web standards for Mutta.*
