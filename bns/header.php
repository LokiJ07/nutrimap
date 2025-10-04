<?php
// header.php
?>
<style>
/* Header bar */
.topbar {
  background: white;
  border-bottom: 1px solid #ccc;
  padding: 8px 15px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  z-index: 1000;
  position: relative;
}

.brand {
  display: flex;
  align-items: center;
  font-weight: bold;
  font-size: 18px;
  cursor: pointer;
}

.brand i {
  font-size: 20px;
  margin-right: 8px;
}

.brand .cno {
  color: #009688; /* green */
  margin-right: 4px;
}

.brand .nutrimap {
  color: #000; /* black */
}

.topbar-right {
  display: flex;
  align-items: center;
  gap: 15px;
}

.searchbox {
  position: relative;
}

.searchbox input {
  padding: 8px 30px 8px 30px;
  border: 1px solid #aaa;
  border-radius: 4px;
  width: 220px;
  font-size: 14px;
  outline: none;
}

.searchbox i {
  position: absolute;
  left: 10px;
  top: 50%;
  transform: translateY(-50%);
  color: #666;
}

.bell {
  font-size: 20px;
  cursor: pointer;
  color: #333;
  position: relative;
}

/* Badge for unread notifications */
#notificationBadge {
  position: absolute; top: -5px; right: -5px;
  background: red; color: white; font-size: 10px;
  padding: 2px 5px; border-radius: 50%;
  display: none;
}

/* Container for dynamic side menu */
#sidemenu-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 0;
  height: 100%;
  overflow: hidden;
  z-index: 2000;
}

/* Modal overlay styles */
.modal {
  position: fixed;
  z-index: 3000;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>

<header class="topbar">
  <div class="brand" id="menuBtn">
    <i class="fa fa-bars"></i>
    <span class="cno">CNO</span><span class="nutrimap">NutriMap</span>
  </div>
  <div class="topbar-right">
    <div class="searchbox">
      <i class="fa fa-search"></i>
      <input type="text" placeholder="Search">
    </div>
    <!-- Notification Bell with badge -->
    <div class="bell" id="bellBtn" style="position: relative;">
      <i class="fa fa-bell"></i>
      <span id="notificationBadge"></span>
    </div>
  </div>
</header>

<div id="sidemenu-container"></div>

<!-- Notification Modal -->
<div id="notificationModal" class="modal" style="display:none;">
  <div class="modal-content" style="width: 80%; max-width: 600px; margin: 10% auto; background: #fff; padding: 20px; border-radius: 8px; position: relative;">
    <span class="close" id="closeNotificationModal" style="position: absolute; top: 10px; right: 15px; font-size: 24px; cursor: pointer;">&times;</span>
    <h2>Notifications</h2>
    <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
  <button id="markAllReadBtn" style="padding: 6px 12px;">Mark All as Read</button>
  <button id="filterUnreadBtn" style="padding: 6px 12px;">Show Read</button>
  <button id="showAllBtn" style="padding: 6px 12px; display:none;">Show All</button>
</div>
    <table id="notificationTable" style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th style="border-bottom: 1px solid #ccc; padding: 8px;">Message</th>
          <th style="border-bottom: 1px solid #ccc; padding: 8px;">Date</th>
          <th style="border-bottom: 1px solid #ccc; padding: 8px;">Status</th>
        </tr>
      </thead>
      <tbody>
        <!-- Notifications will be dynamically inserted here -->
      </tbody>
    </table>
    <!-- Pagination controls -->
    <div style="margin-top: 10px; display: flex; justify-content: center; gap: 10px;">
      <button id="prevPage" style="padding: 6px 12px;">Previous</button>
      <button id="nextPage" style="padding: 6px 12px;">Next</button>
    </div>
  </div>
</div>

<!-- Add your existing scripts here -->
<script>
document.getElementById('menuBtn').addEventListener('click', async () => {
  const container = document.getElementById('sidemenu-container');

  if (!container.innerHTML.trim()) {
    const response = await fetch('sidemenu.php');
    const html = await response.text();
    container.innerHTML = html;

    const menu = document.getElementById('sideMenu');
    if (!menu) return;

    const closeBtn = menu.querySelector('.close-btn');
    if (closeBtn) closeBtn.addEventListener('click', () => menu.classList.remove('open'));

    const menuItems = menu.querySelectorAll('.menu-links li[data-url]');
    menuItems.forEach(item => {
      item.addEventListener('click', () => {
        const url = item.getAttribute('data-url');
        if (url) window.location.href = url;
        menu.classList.remove('open');
      });
    });

    const footerLinks = menu.querySelectorAll('.footer-links > a');
    footerLinks.forEach(link => {
      link.addEventListener('click', () => menu.classList.remove('open'));
    });

    const profileBtn = menu.querySelector('#userProfileBtn');
    if (profileBtn) {
      profileBtn.addEventListener('click', () => {
        window.location.href = 'profile.php';
        menu.classList.remove('open');
      });
    }

    const settingsBtn = menu.querySelector('#settingsBtn');
    const settingsMenu = menu.querySelector('#settingsMenu');
    if (settingsBtn && settingsMenu) {
      settingsBtn.addEventListener('click', (e) => {
        e.preventDefault();
        settingsMenu.style.display = settingsMenu.style.display === 'block' ? 'none' : 'block';
      });
      document.addEventListener('click', (e) => {
        if (!settingsBtn.contains(e.target) && !settingsMenu.contains(e.target)) {
          settingsMenu.style.display = 'none';
        }
      });
      const settingsItems = settingsMenu.querySelectorAll('li[data-url]');
      settingsItems.forEach(item => {
        item.addEventListener('click', () => {
          const url = item.getAttribute('data-url');
          if (url) window.location.href = url;
          menu.classList.remove('open');
        });
      });
    }
  }

  const menu = document.getElementById('sideMenu');
  if (menu) menu.classList.add('open');
});

// Notification System with Pagination and Read/Unread Indicators

// Variables for pagination and filter
let currentPage = 1;
const pageSize = 5;
let totalNotifications = 0;
let lastUnreadCount = 0;
let showUnreadOnly = false; // toggle for unread filter

// DOM elements
const badge = document.getElementById('notificationBadge');
const modal = document.getElementById('notificationModal');
const closeModal = document.getElementById('closeNotificationModal');

const btnPrev = document.getElementById('prevPage');
const btnNext = document.getElementById('nextPage');

const bell = document.getElementById('bellBtn');
const notificationSound = new Audio('notification.wav'); 

// Fetch notifications with pagination and filter
async function fetchNotifications() {
  try {
    const response = await fetch(`get_notifications.php?page=${currentPage}&size=${pageSize}`);
    const data = await response.json();

    totalNotifications = data.totalCount;

    // Count unread notifications
    const totalUnread = data.notifications.filter(n => !n.read).length;

    // Update badge for unread count
    if (totalUnread > 0) {
      badge.innerText = totalUnread;
      badge.style.display = 'inline-block';
    } else {
      badge.style.display = 'none';
    }

    // Filter notifications if showUnreadOnly is true
    let notifications = data.notifications;
    if (showUnreadOnly) {
      notifications = notifications.filter(n => !n.read);
    }

    // Populate table
    const tbody = document.querySelector('#notificationTable tbody');
    tbody.innerHTML = '';

    notifications.forEach(notif => {
      const tr = document.createElement('tr');
      tr.style.cursor = 'pointer';

      // Style unread notifications (bold)
      if (!notif.read) {
        tr.style.fontWeight = 'bold';
      }

      // Message
      const msgTd = document.createElement('td');
      msgTd.innerText = notif.message;
      tr.appendChild(msgTd);

      // Date
      const dateTd = document.createElement('td');
      dateTd.innerText = notif.date;
      tr.appendChild(dateTd);

      // Status
      const statusTd = document.createElement('td');
      statusTd.innerText = notif.read ? 'Read' : 'New';
      tr.appendChild(statusTd);

      // Mark as read on click
      tr.onclick = () => {
        markAsRead(notif.id);
      };

      tbody.appendChild(tr);
    });

    // Pagination control
    btnPrev.disabled = currentPage <= 1;
    btnNext.disabled = (currentPage * pageSize) >= totalNotifications;

    // Save last unread count for sound check
    lastUnreadCount = totalUnread;

  } catch (err) {
    console.error('Error fetching notifications:', err);
  }
}

// Pagination button handlers
document.getElementById('prevPage').addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    fetchNotifications();
  }
});
document.getElementById('nextPage').addEventListener('click', () => {
  if ((currentPage * pageSize) < totalNotifications) {
    currentPage++;
    fetchNotifications();
  }
});

// Show modal on bell click
document.getElementById('bellBtn').addEventListener('click', () => {
  currentPage = 1;
  fetchNotifications();
  document.getElementById('notificationModal').style.display = 'flex';
});

// Close modal
document.getElementById('closeNotificationModal').onclick = () => {
  document.getElementById('notificationModal').style.display = 'none';
};
window.onclick = (e) => {
  if (e.target === document.getElementById('notificationModal')) {
    document.getElementById('notificationModal').style.display = 'none';
  }
};

// Mark individual notification as read
async function markAsRead(id) {
  try {
    const response = await fetch('mark_as_read.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${id}`,
    });
    const result = await response.json();
    if (result.status === 'success') {
      fetchNotifications(); // update badge and list
    }
  } catch (err) {
    console.error('Error marking as read:', err);
  }
}

// Periodic check for new notifications
setInterval(async () => {
  if (document.getElementById('notificationModal').style.display === 'none') {
    await fetchNotifications();
    // Check for new notifications to play sound
    const response = await fetch(`get_notifications.php?page=${currentPage}&size=${pageSize}`);
    const data = await response.json();
    const unreadCount = data.notifications.filter(n => !n.read).length;
    if (unreadCount > lastUnreadCount) {
      notificationSound.play();
    }
    lastUnreadCount = unreadCount;
  }
}, 5000); // every 5 seconds

// Button: Mark all as read
document.getElementById('markAllReadBtn').addEventListener('click', async () => {
  try {
    const response = await fetch('mark_as_read.php', {
      method: 'POST',
    });
    const result = await response.json();
    if (result.status === 'success') {
      fetchNotifications();
    }
  } catch (err) {
    console.error('Error marking all as read:', err);
  }
});

// Button: Show only unread
document.getElementById('filterUnreadBtn').addEventListener('click', () => {
  showUnreadOnly = true;
  document.getElementById('showAllBtn').style.display = 'inline-block';
  document.getElementById('filterUnreadBtn').style.display = 'none';
  fetchNotifications();
});

// Button: Show all
document.getElementById('showAllBtn').addEventListener('click', () => {
  showUnreadOnly = false;
  document.getElementById('showAllBtn').style.display = 'none';
  document.getElementById('filterUnreadBtn').style.display = 'inline-block';
  fetchNotifications();
});
</script>