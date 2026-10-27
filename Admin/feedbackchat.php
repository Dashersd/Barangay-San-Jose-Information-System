<?php
// Feedback Chat
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Chat - Admin Panel</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="../assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/feedbackchat.css?v=<?= time() ?>">
    <style>
    <?php include __DIR__ . '/css/feedbackchat.css'; ?>
    </style>
</head>
<body>

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <img src="../assets/images/San Jose Logo 2.png" alt="Logo">
                <h2 style="color: #fbbf24;">Admin Panel</h2>
            </div>
            <ul class="sidebar-nav">
                <li>
                    <a href="dashboard.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="adminabout.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        </span>
                        About
                    </a>
                </li>
                <li class="admin-dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </span>
                        Officials
                        <svg class="chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                    <ul class="admin-dropdown-menu">
                        <li><a href="barangayofficial.php">Barangay Officials</a></li>
                        <li><a href="skofficials.php">SK Officials</a></li>
                    </ul>
                </li>
                <li class="admin-dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </span>
                        Spot Map
                        <svg class="chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                    <ul class="admin-dropdown-menu">
                        <li><a href="legends.php">Legends</a></li>
                        <li><a href="purok1.php">Purok 1</a></li>
                        <li><a href="purok2.php">Purok 2</a></li>
                        <li><a href="purok3.php">Purok 3</a></li>
                        <li><a href="purok4.php">Purok 4</a></li>
                    </ul>
                </li>
                <li class="admin-dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </span>
                        Household
                        <svg class="chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                    <ul class="admin-dropdown-menu">
                        <li><a href="resident1.php">Resident 1</a></li>
                        <li><a href="resident2.php">Resident 2</a></li>
                        <li><a href="resident3.php">Resident 3</a></li>
                        <li><a href="resident4.php">Resident 4</a></li>
                    </ul>
                </li>
                <li>
                    <a href="mediagallery.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </span>
                        Media Gallery
                    </a>
                </li>
                <li>
                    <a href="service.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        </span>
                        Services
                    </a>
                </li>
                <li>
                    <a href="announcement.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        </span>
                        Announcements
                    </a>
                </li>
                <li>
                    <a href="feedbackchat.php" class="active">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        </span>
                        Feedback Chat
                        <span class="nav-badge" id="nav-chat-badge" style="display:none;">0</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="nav-logout" onclick="return confirm('Are you sure you want to log out?');">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        </span>
                        Logout
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-left">
                    <h1>Feedback Chat</h1>
                    <p>Live Resident Communications &amp; Inquiry Center</p>
                </div>
                
                <div class="header-right-actions">
                    <!-- Audio Sound Alert Toggle -->
                    <button type="button" class="btn-audio-toggle" id="btn-audio-toggle" title="Toggle sound alerts on new inquiries">
                        <span id="audio-toggle-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        </span>
                        <span id="audio-toggle-label">Sound On</span>
                    </button>

                    <!-- Inquiry Notifications Bell -->
                    <div class="notif-bell-container" id="notif-bell-container">
                        <button type="button" class="btn-notif-bell" id="btn-notif-bell" title="Resident Inquiries" aria-label="Notifications">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <span class="notif-badge" id="notif-count-badge" style="display:none;">0</span>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div class="notif-dropdown" id="notif-dropdown" style="display:none;">
                            <div class="notif-dropdown-header">
                                <div class="notif-header-title">
                                    <span>Resident Inquiries</span>
                                    <span class="notif-badge-pill" id="notif-pill-count">0 New</span>
                                </div>
                                <button type="button" class="btn-mark-all-read" id="btn-mark-all-read">Mark all as read</button>
                            </div>
                            <div class="notif-list" id="notif-items-list">
                                <div class="notif-empty">No unread inquiries</div>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="header-user-profile">
                        <div class="user-text">
                            <span class="user-name">System Admin</span>
                            <span class="user-role">Administrator</span>
                        </div>
                        <div class="user-avatar">A</div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="admin-content chat-page-wrapper">
                
                <!-- Floating Real-Time Toast Container -->
                <div class="chat-toast-container" id="chat-toast-container"></div>

                <!-- Desktop Notification Banner -->
                <div class="desktop-notif-banner" id="desktop-notif-banner" style="display:none;">
                    <div class="banner-text">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span><strong>Stay Alerted:</strong> Turn on browser notifications so you immediately know when a resident reaches out, even if you are on another tab.</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <button type="button" class="btn-enable-notif" id="btn-enable-notif">Enable Notifications</button>
                        <button type="button" class="btn-banner-close" id="btn-banner-close" title="Dismiss">&times;</button>
                    </div>
                </div>

                <div class="chat-container">
                    <!-- Chat Sidebar (Conversations List) -->
                    <div class="chat-sidebar">
                        <div class="chat-sidebar-header">
                            <div class="chat-sidebar-title-row">
                                <h3>
                                    Resident Inquiries
                                    <span class="count-pill" id="stat-sidebar-count">0</span>
                                </h3>
                            </div>
                            <!-- Search Bar -->
                            <div class="chat-search-wrap">
                                <svg viewBox="0 0 24 24" width="16" height="16" style="width:16px; height:16px; max-width:16px; max-height:16px; position:absolute; left:10px; color:#94a3b8; pointer-events:none;" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" class="chat-search-input" id="chat-search-input" placeholder="Search resident or service...">
                                <button type="button" class="chat-search-clear" id="chat-search-clear" title="Clear search">&times;</button>
                            </div>
                            <!-- Filter Tabs -->
                            <div class="chat-filter-tabs">
                                <button type="button" class="chat-filter-btn active" id="tab-filter-all" data-filter="all">All Inquiries</button>
                                <button type="button" class="chat-filter-btn" id="tab-filter-unread" data-filter="unread">Unread (<span id="unread-filter-count">0</span>)</button>
                            </div>
                        </div>

                        <!-- Conversation List -->
                        <div class="conversation-list" id="conversation-list">
                            <!-- Populated dynamically via JavaScript -->
                        </div>
                    </div>

                    <!-- Chat Empty State (When no conversation is selected) -->
                    <div class="chat-empty-state" id="chat-empty-state">
                        <div class="empty-state-card">
                            <div class="empty-icon-bubble">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    <path d="M8 10h.01M12 10h.01M16 10h.01"></path>
                                </svg>
                            </div>
                            <h3>Select a Resident Conversation</h3>
                            <p>Choose an inquiry from the list on the left to review messages and send official responses in real-time.</p>
                            <div class="empty-quick-stats">
                                <span class="stat-tag"><strong id="stat-total-convos">0</strong> Total Inquiries</span>
                                <span class="stat-tag highlight"><strong id="stat-unread-convos">0</strong> Unread</span>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Main Area (Active Conversation) -->
                    <div class="chat-main" id="chat-main-area" style="display:none;">
                        <!-- Header -->
                        <div class="chat-main-header">
                            <div class="chat-resident-profile">
                                <div class="chat-header-avatar" id="current-chat-avatar">U</div>
                                <div class="chat-header-info">
                                    <h3 id="current-chat-name">Resident Name</h3>
                                    <div class="chat-header-meta">
                                        <span class="status-indicator">
                                            <span class="status-dot"></span>
                                            Citizen Inquirer
                                        </span>
                                        <span class="chat-header-service-badge" id="current-chat-service">General</span>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-header-actions">
                                <button type="button" class="btn-header-action" id="btn-refresh-chat" title="Refresh messages">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        
                        <!-- Messages Body -->
                        <div class="chat-messages" id="chat-messages">
                            <!-- Dynamically loaded messages -->
                        </div>

                        <!-- Canned Quick Replies -->
                        <div class="quick-replies-bar">
                            <span class="quick-reply-label">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                Quick:
                            </span>
                            <button type="button" class="quick-reply-chip" data-text="Good day! How may we assist you today?">Good day! How may we assist you?</button>
                            <button type="button" class="quick-reply-chip" data-text="Please bring 1 valid ID and visit the Barangay Hall during office hours (8AM - 5PM).">Visit Barangay Hall with 1 valid ID</button>
                            <button type="button" class="quick-reply-chip" data-text="Your requested document is ready for pickup at the barangay hall.">Ready for pickup</button>
                            <button type="button" class="quick-reply-chip" data-text="Thank you for reaching out to Barangay San Jose. Have a great day!">Thank you for reaching out</button>
                        </div>

                        <!-- Chat Input Bar with Messenger-style Document Attachment -->
                        <div class="chat-input-area">
                            <div class="chat-input-wrapper">
                                <!-- Staged Attachment Preview (shown when file is selected) -->
                                <div id="admin-staged-attachment" class="staged-attachment-bar" style="display: none;">
                                    <div class="staged-att-content">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#2563eb" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                                        <div class="staged-att-details">
                                            <span class="staged-att-label">Attached:</span>
                                            <span id="staged-att-name" class="staged-att-name">document.pdf</span>
                                        </div>
                                    </div>
                                    <button type="button" class="staged-att-remove" id="btn-remove-staged-att" title="Remove attachment">&times;</button>
                                </div>

                                <div class="chat-input-controls">
                                    <!-- Attachment Menu Toggle -->
                                    <div class="chat-attachment-dropdown-wrap">
                                        <button type="button" class="btn-chat-attach" id="btn-chat-attach" title="Attach &amp; Send Document/Form">
                                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                        </button>
                                        
                                        <!-- Hidden file input for uploading from device -->
                                        <input type="file" id="admin-chat-file-input" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="display: none;">

                                        <!-- Attachment Popup Menu -->
                                        <div class="chat-attach-menu" id="chat-attach-menu" style="display: none;">
                                            <button type="button" class="attach-menu-item" id="btn-attach-upload">
                                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#2563eb" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                                Upload Document from Device...
                                            </button>
                                            <button type="button" class="attach-menu-item" id="btn-attach-service-form">
                                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#059669" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                                Select Ready Barangay Form...
                                            </button>
                                        </div>
                                    </div>

                                    <input type="text" class="chat-input" id="admin-chat-input" placeholder="Type your reply to resident here... (Press Enter to send)">
                                    
                                    <button class="btn-send" id="admin-send-btn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                        Send Reply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Forms Picker Modal -->
                <div id="serviceFormsModal" class="service-forms-modal" style="display: none;" onclick="if(event.target === this) $('#serviceFormsModal').fadeOut(150);">
                    <div class="service-forms-modal-dialog">
                        <div class="service-forms-modal-header">
                            <h3>
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#15803d" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                Select Barangay Service Form
                            </h3>
                            <button type="button" class="service-forms-modal-close" id="close-service-forms-modal">&times;</button>
                        </div>
                        <div class="service-forms-modal-body" id="service-forms-list">
                            <!-- Populated dynamically -->
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/dashboard.js"></script>
    <script>
    $(document).ready(function() {
        let activeSessionId = null;
        let activeResidentName = '';
        let activeServiceType = '';
        let lastSeenMsgId = null;
        let isFirstFetch = true;
        let soundEnabled = (localStorage.getItem('admin_chat_sound') !== 'false');
        let currentFilter = 'all'; // 'all' or 'unread'
        let currentSearchQuery = '';
        let cachedSessions = [];
        let titleBlinkInterval = null;
        let stagedFile = null;
        let stagedServiceForm = null;
        const originalTitle = document.title;

        // Initialize Audio Toggle state
        function updateAudioButtonUI() {
            if (soundEnabled) {
                $('#btn-audio-toggle').removeClass('muted');
                $('#audio-toggle-icon').html('<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>');
                $('#audio-toggle-label').text('Sound On');
            } else {
                $('#btn-audio-toggle').addClass('muted');
                $('#audio-toggle-icon').html('<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>');
                $('#audio-toggle-label').text('Muted');
            }
        }
        updateAudioButtonUI();

        $('#btn-audio-toggle').on('click', function() {
            soundEnabled = !soundEnabled;
            localStorage.setItem('admin_chat_sound', soundEnabled ? 'true' : 'false');
            updateAudioButtonUI();
            if (soundEnabled) {
                playNotificationSound();
            }
        });

        // Web Audio Synthesizer Chime
        function playNotificationSound() {
            if (!soundEnabled) return;
            try {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                if (!AudioContext) return;
                const ctx = new AudioContext();

                const now = ctx.currentTime;
                // Tone 1: D5 (587.33Hz)
                const osc1 = ctx.createOscillator();
                const gain1 = ctx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(587.33, now);
                gain1.gain.setValueAtTime(0.25, now);
                gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.35);
                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.start(now);
                osc1.stop(now + 0.35);

                // Tone 2: A5 (880Hz)
                const osc2 = ctx.createOscillator();
                const gain2 = ctx.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(880, now + 0.12);
                gain2.gain.setValueAtTime(0.3, now + 0.12);
                gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.55);
                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.start(now + 0.12);
                osc2.stop(now + 0.55);
            } catch(e) {
                console.log("Audio alert note:", e);
            }
        }

        // Browser Desktop Notifications
        function checkNotificationPermission() {
            if ("Notification" in window) {
                if (Notification.permission === "default" && localStorage.getItem('dismiss_notif_banner') !== 'true') {
                    $('#desktop-notif-banner').slideDown(200);
                } else {
                    $('#desktop-notif-banner').hide();
                }
            }
        }
        checkNotificationPermission();

        $('#btn-enable-notif').on('click', function() {
            if ("Notification" in window) {
                Notification.requestPermission().then(function(permission) {
                    if (permission === "granted") {
                        $('#desktop-notif-banner').slideUp(200);
                        new Notification("Barangay San Jose Notifications Enabled", {
                            body: "You will now receive alerts whenever a resident contacts you.",
                            icon: "../assets/images/San Jose Logo 2.png"
                        });
                    }
                });
            }
        });

        $('#btn-banner-close').on('click', function() {
            $('#desktop-notif-banner').slideUp(200);
            localStorage.setItem('dismiss_notif_banner', 'true');
        });

        // Trigger Tab Title Blink
        function startTitleBlink(senderName) {
            if (document.hasFocus()) return;
            stopTitleBlink();
            let isAlternate = false;
            titleBlinkInterval = setInterval(() => {
                document.title = isAlternate ? `🔔 New message from ${senderName}!` : originalTitle;
                isAlternate = !isAlternate;
            }, 1200);
        }

        function stopTitleBlink() {
            if (titleBlinkInterval) {
                clearInterval(titleBlinkInterval);
                titleBlinkInterval = null;
            }
            document.title = originalTitle;
        }

        $(window).on('focus', function() {
            stopTitleBlink();
        });

        // Floating Toast Notification
        function showToast(sender, service, message, sessionId) {
            const toastId = 'toast-' + Date.now();
            const safeSender = $('<div>').text(sender).html();
            const safeService = $('<div>').text(service).html();
            const safeMsg = $('<div>').text(message).html();

            const toastHtml = `
                <div class="chat-toast" id="${toastId}">
                    <div class="chat-toast-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </div>
                    <div class="chat-toast-content">
                        <div class="chat-toast-meta">
                            <span class="chat-toast-title">New Resident Message</span>
                            <span class="chat-toast-time">Just now</span>
                        </div>
                        <div class="chat-toast-sender">
                            ${safeSender}
                            <span class="chat-toast-service-tag">${safeService}</span>
                        </div>
                        <div class="chat-toast-msg">"${safeMsg}"</div>
                        <div class="chat-toast-actions">
                            <button type="button" class="btn-toast-open" data-id="${sessionId}" data-name="${safeSender}" data-service="${safeService}">
                                Reply Now
                            </button>
                            <button type="button" class="btn-toast-dismiss">Dismiss</button>
                        </div>
                    </div>
                </div>
            `;

            $('#chat-toast-container').append(toastHtml);

            // Auto dismiss after 8 seconds
            setTimeout(() => {
                const $t = $('#' + toastId);
                $t.css({ opacity: 0, transform: 'translateX(60px)' });
                setTimeout(() => $t.remove(), 300);
            }, 8000);
        }

        $(document).on('click', '.btn-toast-dismiss', function() {
            const $t = $(this).closest('.chat-toast');
            $t.css({ opacity: 0, transform: 'translateX(60px)' });
            setTimeout(() => $t.remove(), 300);
        });

        $(document).on('click', '.btn-toast-open', function() {
            const sid = $(this).data('id');
            const name = $(this).data('name');
            const service = $(this).data('service');
            openConversation(sid, name, service);
            const $t = $(this).closest('.chat-toast');
            $t.css({ opacity: 0, transform: 'translateX(60px)' });
            setTimeout(() => $t.remove(), 300);
        });

        // Toggle Notifications Dropdown
        $('#btn-notif-bell').on('click', function(e) {
            e.stopPropagation();
            $('#notif-dropdown').fadeToggle(150);
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#notif-bell-container').length) {
                $('#notif-dropdown').fadeOut(150);
            }
        });

        // Mark All Read Button
        $('#btn-mark-all-read').on('click', function() {
            $.post('api/admin_mark_all_read.php', function(res) {
                fetchSessions();
            });
        });

        let lastRenderedMessagesJson = '';
        let lastRenderedSessionsJson = '';

        // Open Conversation Helper
        function openConversation(id, name, service) {
            if (activeSessionId == id && $('#chat-main-area').is(':visible')) {
                return; // Already open, prevent re-render flicker
            }
            activeSessionId = id;
            activeResidentName = name;
            activeServiceType = service;
            lastRenderedMessagesJson = ''; // Reset so messages render fresh once

            // Highlight in sidebar
            $('.conversation-item').removeClass('active');
            $(`.conversation-item[data-id="${id}"]`).addClass('active').removeClass('has-unread');
            $(`.conversation-item[data-id="${id}"] .conv-unread-pill`).remove();

            // Switch to chat view smoothly
            $('#chat-empty-state').hide();
            $('#chat-main-area').show();

            // Update Header Info
            const initial = name ? name.charAt(0).toUpperCase() : 'U';
            $('#current-chat-avatar').text(initial);
            $('#current-chat-name').text(name);
            $('#current-chat-service').text(service ? service : 'General Inquiry');
            $('#admin-chat-input').focus();

            fetchMessages(true);
            stopTitleBlink();
        }

        // Render Conversation List from Cache
        function renderConversationList() {
            let filtered = cachedSessions.filter(s => {
                // Search filter
                if (currentSearchQuery) {
                    const q = currentSearchQuery.toLowerCase();
                    const nameMatch = (s.user_name || '').toLowerCase().includes(q);
                    const serviceMatch = (s.service_type || '').toLowerCase().includes(q);
                    const msgMatch = (s.last_msg || '').toLowerCase().includes(q);
                    if (!nameMatch && !serviceMatch && !msgMatch) return false;
                }
                // Tab filter
                if (currentFilter === 'unread') {
                    return (parseInt(s.unread_count) || 0) > 0;
                }
                return true;
            });

            if (filtered.length === 0) {
                $('#conversation-list').html(`
                    <div class="sidebar-empty-hint">
                        <svg viewBox="0 0 24 24" width="36" height="36" style="width:36px; height:36px; stroke:#cbd5e1; margin-bottom:0.75rem;" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <p style="margin:0; font-size:0.85rem; font-weight:600;">No conversations found</p>
                        <span style="font-size:0.75rem; color:#94a3b8;">Try clearing the search or filter</span>
                    </div>
                `);
                return;
            }

            let html = '';
            filtered.forEach(s => {
                const activeClass = (s.id == activeSessionId) ? 'active' : '';
                const unreadCount = parseInt(s.unread_count) || 0;
                const hasUnreadClass = (unreadCount > 0 && s.id != activeSessionId) ? 'has-unread' : '';
                const unreadBadge = (unreadCount > 0 && s.id != activeSessionId) ? `<span class="conv-unread-pill">${unreadCount} new</span>` : '';
                const safeLastMsg = s.last_msg ? $('<div>').text(s.last_msg).html() : 'No messages yet';
                const initial = s.user_name ? s.user_name.charAt(0).toUpperCase() : 'U';

                html += `
                    <div class="conversation-item ${activeClass} ${hasUnreadClass}" data-id="${s.id}" data-name="${s.user_name}" data-service="${s.service_type}">
                        <div class="conv-avatar">${initial}</div>
                        <div class="conv-body">
                            <div class="conv-header">
                                <span class="conv-name">${s.user_name}</span>
                                <span class="conv-time">${s.time || ''}</span>
                            </div>
                            <div class="conv-meta">
                                <span class="conv-service-tag">${s.service_type || 'General'}</span>
                                ${unreadBadge}
                            </div>
                            <div class="conv-preview">${safeLastMsg}</div>
                        </div>
                    </div>
                `;
            });
            $('#conversation-list').html(html);
        }

        // Fetch Sessions & Live Check
        function fetchSessions() {
            $.get('api/admin_fetch_sessions.php', function(res) {
                if (res.status === 'success') {
                    cachedSessions = res.sessions || [];

                    // Update Counters
                    const totalCount = cachedSessions.length;
                    const totalUnread = res.total_unread || 0;

                    $('#stat-sidebar-count').text(totalCount);
                    $('#stat-total-convos').text(totalCount);
                    $('#stat-unread-convos').text(totalUnread);
                    $('#unread-filter-count').text(totalUnread);

                    // Update Top Badges
                    if (totalUnread > 0) {
                        $('#notif-count-badge').text(totalUnread > 99 ? '99+' : totalUnread).show();
                        $('#nav-chat-badge').text(totalUnread > 99 ? '99+' : totalUnread).show();
                        $('#notif-pill-count').text(`${totalUnread} Unread`);
                    } else {
                        $('#notif-count-badge').hide();
                        $('#nav-chat-badge').hide();
                        $('#notif-pill-count').text('0 Unread');
                    }

                    // Render Notifications Dropdown
                    if (res.notifications && res.notifications.length > 0) {
                        let notifHtml = '';
                        res.notifications.forEach(n => {
                            const initial = n.user_name ? n.user_name.charAt(0).toUpperCase() : 'U';
                            notifHtml += `
                                <div class="notif-item unread notif-open-chat" data-id="${n.session_id}" data-name="${n.user_name}" data-service="${n.service_type}">
                                    <div class="notif-avatar">${initial}</div>
                                    <div class="notif-content">
                                        <div class="notif-user-row">
                                            <span class="notif-sender-name">${n.user_name}</span>
                                            <span class="notif-time">${n.time || ''}</span>
                                        </div>
                                        <div><span class="notif-service-tag">${n.service_type}</span></div>
                                        <div class="notif-preview-msg">${n.message}</div>
                                    </div>
                                </div>
                            `;
                        });
                        $('#notif-items-list').html(notifHtml);
                    } else {
                        $('#notif-items-list').html('<div class="notif-empty">No unread inquiries</div>');
                    }

                    // Detect New Incoming Message from resident
                    if (res.latest_message && res.latest_message.id) {
                        const currentMsgId = parseInt(res.latest_message.id);

                        if (isFirstFetch) {
                            lastSeenMsgId = currentMsgId;
                            // Auto open first chat on initial load if available
                            if (!activeSessionId && cachedSessions.length > 0) {
                                const first = cachedSessions[0];
                                openConversation(first.id, first.user_name, first.service_type);
                            }
                            isFirstFetch = false;
                        } else if (lastSeenMsgId && currentMsgId > lastSeenMsgId) {
                            lastSeenMsgId = currentMsgId;
                            const lm = res.latest_message;

                            // 1. Play Chime
                            playNotificationSound();

                            // 2. Show Visual Floating Toast
                            showToast(lm.user_name, lm.service_type, lm.message, lm.session_id);

                            // 3. Tab Title Alert
                            startTitleBlink(lm.user_name);

                            // 4. Desktop Notification (if granted)
                            if ("Notification" in window && Notification.permission === "granted") {
                                const desktopNotif = new Notification(`New message from ${lm.user_name}`, {
                                    body: `[${lm.service_type}] ${lm.message}`,
                                    icon: "../assets/images/San Jose Logo 2.png"
                                });
                                desktopNotif.onclick = function() {
                                    window.focus();
                                    openConversation(lm.session_id, lm.user_name, lm.service_type);
                                    desktopNotif.close();
                                };
                            }

                            // If this session is currently open, fetch messages right away
                            if (activeSessionId == lm.session_id) {
                                fetchMessages(true);
                            }
                        }
                    }

                    // Only re-render sidebar list if sessions actually changed
                    const currentSessionsJson = JSON.stringify(cachedSessions);
                    if (currentSessionsJson !== lastRenderedSessionsJson) {
                        lastRenderedSessionsJson = currentSessionsJson;
                        renderConversationList();
                    }
                }
            });
        }

        // Fetch Messages for active session without glitching
        function fetchMessages(forceScroll = false) {
            if (!activeSessionId) return;
            $.get('api/admin_fetch_messages.php', { session_id: activeSessionId }, function(res) {
                if (res.status === 'success') {
                    const currentMessagesJson = JSON.stringify(res.messages || []);

                    // IF MESSAGES HAVE NOT CHANGED AND NO FORCE SCROLL, DO NOT TOUCH DOM (PREVENTS GLITCHING)
                    if (currentMessagesJson === lastRenderedMessagesJson && !forceScroll) {
                        return;
                    }
                    lastRenderedMessagesJson = currentMessagesJson;

                    let html = `
                        <div class="chat-date-divider">
                            <span>Official Resident Feedback & Inquiry Thread</span>
                        </div>
                    `;

                    if (!res.messages || res.messages.length === 0) {
                        html += `
                            <div style="text-align:center; padding: 2.5rem 1rem; color: #94a3b8;">
                                <p style="margin:0; font-size:0.9rem;">No messages exchanged yet in this conversation.</p>
                            </div>
                        `;
                    } else {
                        res.messages.forEach(msg => {
                            const isAdmin = (msg.sender === 'admin');
                            const typeClass = isAdmin ? 'admin-message' : 'user-message';
                            const safeMsg = $('<div>').text(msg.message || '').html().replace(/\n/g, '<br>');
                            const avatarInitial = isAdmin ? 'A' : (activeResidentName ? activeResidentName.charAt(0).toUpperCase() : 'U');
                            const docCardHtml = msg.attachment_file ? renderChatDocCard(msg.attachment_file, msg.attachment_name, isAdmin) : '';

                            html += `
                                <div class="message-wrapper ${typeClass}">
                                    ${!isAdmin ? `<div class="msg-sender-avatar" title="${activeResidentName}">${avatarInitial}</div>` : ''}
                                    <div class="message-bubble">
                                        ${safeMsg ? `<p>${safeMsg}</p>` : ''}
                                        ${docCardHtml}
                                        <div class="msg-footer">
                                            <span class="msg-time">${msg.time}</span>
                                            ${isAdmin ? `
                                                <svg class="msg-check" viewBox="0 0 24 24" width="13" height="13" style="width:13px; height:13px; max-width:13px; max-height:13px; vertical-align:middle; display:inline-block;" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            ` : ''}
                                        </div>
                                    </div>
                                    ${isAdmin ? `<div class="msg-sender-avatar" title="Barangay Admin">${avatarInitial}</div>` : ''}
                                </div>
                            `;
                        });
                    }

                    const $container = $('#chat-messages');
                    const isNearBottom = $container.length > 0 && 
                        ($container[0].scrollHeight - $container.scrollTop() - $container.outerHeight() < 100);

                    $container.html(html);

                    if (forceScroll || isNearBottom) {
                        $container.scrollTop($container[0].scrollHeight);
                    }
                }
            });
        }

        // Click Conversation Item
        $(document).on('click', '.conversation-item', function() {
            const sid = $(this).data('id');
            const name = $(this).data('name');
            const service = $(this).data('service');
            openConversation(sid, name, service);
        });

        // Click Notification Dropdown Item
        $(document).on('click', '.notif-open-chat', function() {
            const sid = $(this).data('id');
            const name = $(this).data('name');
            const service = $(this).data('service');
            $('#notif-dropdown').fadeOut(150);
            openConversation(sid, name, service);
        });

        // Search conversations in real-time
        $('#chat-search-input').on('input', function() {
            currentSearchQuery = $(this).val().trim();
            if (currentSearchQuery.length > 0) {
                $('#chat-search-clear').show();
            } else {
                $('#chat-search-clear').hide();
            }
            renderConversationList();
        });

        $('#chat-search-clear').on('click', function() {
            $('#chat-search-input').val('');
            currentSearchQuery = '';
            $(this).hide();
            renderConversationList();
        });

        // Filter tabs: All vs Unread
        $('.chat-filter-btn').on('click', function() {
            $('.chat-filter-btn').removeClass('active');
            $(this).addClass('active');
            currentFilter = $(this).data('filter');
            renderConversationList();
        });

        // Quick Canned Replies
        $(document).on('click', '.quick-reply-chip', function() {
            const text = $(this).data('text');
            $('#admin-chat-input').val(text).focus();
        });

        // Refresh Chat Button
        $('#btn-refresh-chat').on('click', function() {
            const $btn = $(this);
            $btn.css('opacity', '0.6');
            fetchMessages(true);
            fetchSessions();
            setTimeout(() => $btn.css('opacity', '1'), 400);
        });

        // Document Card Helpers
        function getFileIconAndBadge(ext) {
            ext = (ext || '').toLowerCase();
            if (ext === 'pdf') {
                return {
                    badge: 'PDF Document',
                    color: '#ef4444',
                    bg: '#fee2e2',
                    icon: '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#ef4444" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>'
                };
            }
            if (ext === 'doc' || ext === 'docx') {
                return {
                    badge: 'Word Document',
                    color: '#2563eb',
                    bg: '#dbeafe',
                    icon: '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#2563eb" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>'
                };
            }
            if (ext === 'jpg' || ext === 'jpeg' || ext === 'png') {
                return {
                    badge: 'Image Document',
                    color: '#059669',
                    bg: '#dcfce7',
                    icon: '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#059669" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>'
                };
            }
            return {
                badge: 'Official Document',
                color: '#64748b',
                bg: '#f1f5f9',
                icon: '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#64748b" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>'
            };
        }

        function renderChatDocCard(filePath, fileName, isAdmin) {
            if (!filePath) return '';
            const ext = filePath.split('.').pop().toLowerCase();
            const meta = getFileIconAndBadge(ext);
            const rawName = fileName || filePath.split('/').pop();
            const safeName = $('<div>').text(rawName).html();
            const fullUrl = '../' + filePath.replace(/^\/+/, '');

            return `
                <div class="chat-doc-card">
                    <div class="chat-doc-main">
                        <div class="chat-doc-icon" style="background:${meta.bg};">
                            ${meta.icon}
                        </div>
                        <div class="chat-doc-info">
                            <span class="chat-doc-title" title="${safeName}">${safeName}</span>
                            <span class="chat-doc-badge">${meta.badge}</span>
                        </div>
                    </div>
                    <div class="chat-doc-actions">
                        <a href="${fullUrl}" download="${safeName}" class="btn-chat-doc-dl" target="_blank">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            Download
                        </a>
                        <button type="button" class="btn-chat-doc-print" onclick="printChatDoc('${fullUrl}', '${ext}')">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            Print
                        </button>
                    </div>
                </div>
            `;
        }

        window.printChatDoc = function(fileUrl, ext) {
            ext = (ext || '').toLowerCase();
            if (ext === 'pdf') {
                const printWindow = window.open(fileUrl, '_blank');
                if (printWindow) {
                    printWindow.onload = function() {
                        try { printWindow.print(); } catch(e) {}
                    };
                }
            } else if (['jpg', 'jpeg', 'png', 'webp'].includes(ext)) {
                const printWindow = window.open('', '_blank');
                if (printWindow) {
                    printWindow.document.write(`
                        <html>
                            <head><title>Print Document</title><style>body{margin:0;display:flex;align-items:center;justify-content:center;background:#fff;} img{max-width:98vw;max-height:98vh;object-fit:contain;}</style></head>
                            <body onload="window.print();">
                                <img src="${fileUrl}" alt="Print Preview" />
                            </body>
                        </html>
                    `);
                    printWindow.document.close();
                }
            } else {
                alert('For Word/Office documents (.doc, .docx), please download the file to open and print directly.');
                const tempLink = document.createElement('a');
                tempLink.href = fileUrl;
                tempLink.download = '';
                document.body.appendChild(tempLink);
                tempLink.click();
                document.body.removeChild(tempLink);
            }
        };

        // Attachment Dropdown Handlers
        $('#btn-chat-attach').on('click', function(e) {
            e.stopPropagation();
            $('#chat-attach-menu').toggle();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.chat-attachment-dropdown-wrap').length) {
                $('#chat-attach-menu').hide();
            }
        });

        // 1. Upload from device
        $('#btn-attach-upload').on('click', function() {
            $('#chat-attach-menu').hide();
            $('#admin-chat-file-input').click();
        });

        $('#admin-chat-file-input').on('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                if (file.size > 20 * 1024 * 1024) {
                    alert('File is too large (max 20MB).');
                    $(this).val('');
                    return;
                }
                stagedFile = file;
                stagedServiceForm = null;
                const sizeKb = (file.size / 1024).toFixed(1);
                $('#staged-att-name').text(file.name + ' (' + sizeKb + ' KB)');
                $('#admin-staged-attachment').fadeIn(150);
                $('#admin-chat-input').focus();
            }
        });

        // 2. Select ready service form
        $('#btn-attach-service-form').on('click', function() {
            $('#chat-attach-menu').hide();
            $('#serviceFormsModal').fadeIn(200);
            loadServiceForms();
        });

        function loadServiceForms() {
            $('#service-forms-list').html('<p style="text-align:center;color:#94a3b8;padding:1.5rem;">Loading available service forms...</p>');
            $.get('api/admin_get_service_forms.php', function(res) {
                if (res.status === 'success' && res.forms && res.forms.length > 0) {
                    let html = '';
                    res.forms.forEach(f => {
                        const ext = f.file_path.split('.').pop().toUpperCase();
                        html += `
                            <div class="service-form-card" data-path="${f.file_path}" data-title="${f.title}" data-name="${f.file_name}">
                                <div class="service-form-card-info">
                                    <div class="service-form-icon-wrap">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                    </div>
                                    <div>
                                        <h4 class="service-form-card-title">${f.title}</h4>
                                        <p class="service-form-card-sub">${f.file_name} • <span style="font-weight:700;color:#15803d;">${ext}</span></p>
                                    </div>
                                </div>
                                <button type="button" class="btn-select-service-form">Attach Form</button>
                            </div>
                        `;
                    });
                    $('#service-forms-list').html(html);
                } else {
                    $('#service-forms-list').html(`
                        <div style="text-align:center;padding:2.5rem 1rem;color:#64748b;">
                            <p style="margin:0 0 0.5rem 0;font-weight:700;">No Ready-Made Service Forms Available</p>
                            <span style="font-size:0.82rem;color:#94a3b8;">You can attach document templates to services in the Services management page first.</span>
                        </div>
                    `);
                }
            });
        }

        $(document).on('click', '.service-form-card, .btn-select-service-form', function(e) {
            const card = $(this).closest('.service-form-card');
            const path = card.data('path');
            const title = card.data('title');
            const name = card.data('name');
            stagedServiceForm = { path: path, name: `${title} (${name})` };
            stagedFile = null;
            $('#admin-chat-file-input').val('');
            $('#staged-att-name').text(stagedServiceForm.name);
            $('#admin-staged-attachment').fadeIn(150);
            $('#serviceFormsModal').fadeOut(150);
            $('#admin-chat-input').focus();
        });

        $('#close-service-forms-modal').on('click', function() {
            $('#serviceFormsModal').fadeOut(150);
        });

        // 3. Remove staged attachment
        $('#btn-remove-staged-att').on('click', function() {
            stagedFile = null;
            stagedServiceForm = null;
            $('#admin-chat-file-input').val('');
            $('#admin-staged-attachment').fadeOut(150);
        });

        // Send Reply Message with Attachment Support
        function sendReply() {
            const msg = $('#admin-chat-input').val();
            if (!activeSessionId) return;
            if (msg.trim() === '' && !stagedFile && !stagedServiceForm) return;

            const $btn = $('#admin-send-btn');
            $btn.prop('disabled', true).css('opacity', '0.7');

            const formData = new FormData();
            formData.append('session_id', activeSessionId);
            formData.append('message', msg.trim());

            if (stagedFile) {
                formData.append('chatDocument', stagedFile);
            }
            if (stagedServiceForm) {
                formData.append('service_doc_path', stagedServiceForm.path);
                formData.append('service_doc_name', stagedServiceForm.name);
            }

            $.ajax({
                url: 'api/admin_send_message.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    $btn.prop('disabled', false).css('opacity', '1');
                    if (res.status === 'success') {
                        $('#admin-chat-input').val('');
                        stagedFile = null;
                        stagedServiceForm = null;
                        $('#admin-chat-file-input').val('');
                        $('#admin-staged-attachment').hide();
                        fetchMessages(true);
                        fetchSessions();
                    } else {
                        alert(res.message || 'Failed to send message');
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).css('opacity', '1');
                    alert('Network error while sending message.');
                }
            });
        }

        $('#admin-send-btn').on('click', sendReply);

        $('#admin-chat-input').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendReply();
            }
        });

        // Poll every 3 seconds without glitching
        setInterval(fetchSessions, 3000);
        setInterval(fetchMessages, 3000);
        fetchSessions();
    });
    </script>
</body>
</html>

