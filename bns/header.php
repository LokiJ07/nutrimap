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

/* Bell pulse animation when new notification arrives */
@keyframes bellPulse {
  0% { transform: scale(1); color: #333; }
  25% { transform: scale(1.2); color: #ff4444; }
  50% { transform: scale(1); color: #ff4444; }
  75% { transform: scale(1.2); color: #ff4444; }
  100% { transform: scale(1); color: #333; }
}

.bell.pulse i {
  animation: bellPulse 0.8s ease;
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
      <button id="filterUnreadBtn" style="padding: 6px 12px;">Show Unread</button>
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

<script>
  
// Side menu logic (unchanged from previous)
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


// Notification System
let currentPage = 1;
const pageSize = 5;
let totalNotifications = 0;
let totalUnread = 0;
let showUnreadOnly = false;
let lastAlertedId = 0;
let initialized = false;
const basePath = 'notification/'; // ✅ correct relative folder
const notificationSound = new Audio(basePath + 'notification.wav');
const badge = document.getElementById('notificationBadge');
const modal = document.getElementById('notificationModal');
const bell = document.getElementById('bellBtn');
const closeModal = document.getElementById('closeNotificationModal');
const btnPrev = document.getElementById('prevPage');
const btnNext = document.getElementById('nextPage');

// 🟩 Create toast container
let toastContainer = document.getElementById('toastContainer');
if (!toastContainer) {
  toastContainer = document.createElement('div');
  toastContainer.id = 'toastContainer';
  toastContainer.style.position = 'fixed';
  toastContainer.style.top = '20px';
  toastContainer.style.left = '50%';
  toastContainer.style.transform = 'translateX(-50%)';
  toastContainer.style.zIndex = '9999';
  document.body.appendChild(toastContainer);
}

// 🟩 Unlock sound on first click
document.addEventListener('click', () => {
  notificationSound.muted = true;
  notificationSound.play().then(() => {
    notificationSound.pause();
    notificationSound.muted = false;
  }).catch(() => {});
}, { once: true });

function updateBadge(count) {
  badge.style.display = count > 0 ? 'inline-block' : 'none';
  badge.innerText = count > 0 ? count : '';
}

async function fetchUnreadCount() {
  try {
    const response = await fetch(basePath + 'get_notifications.php?count_unread=1');
    const data = await response.json();
    updateBadge(data.totalUnread);
  } catch (err) {
    console.error('Error fetching unread count:', err);
  }
}

let lastToastMessage = "";

function playNotificationEffect(message = "New notification received!") {
  if (message === lastToastMessage) return;
  lastToastMessage = message;

  try {
    notificationSound.currentTime = 0;
    notificationSound.play().catch(e => console.warn('Sound blocked:', e));
  } catch (e) {
    console.warn('Sound failed:', e);
  }

  bell.classList.add('pulse');
  setTimeout(() => bell.classList.remove('pulse'), 1000);

  showToast(message);
  setTimeout(() => { lastToastMessage = ""; }, 8000);
}

function showToast(message) {
  const toast = document.createElement('div');
  toast.innerText = `🔔 ${message}`;
  toast.style.background = '#333';
  toast.style.color = '#fff';
  toast.style.padding = '10px 16px';
  toast.style.borderRadius = '8px';
  toast.style.marginTop = '8px';
  toast.style.boxShadow = '0 2px 6px rgba(0,0,0,0.2)';
  toast.style.opacity = '0';
  toast.style.transition = 'opacity 0.5s, transform 0.5s';
  toast.style.transform = 'translateY(-20px)';
  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';
  }, 100);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(-20px)';
    setTimeout(() => toast.remove(), 500);
  }, 4000);
}

let isLiveUpdate = false;

async function fetchNotifications() {
  try {
    const response = await fetch(
      basePath + `get_notifications.php?page=${currentPage}&size=${pageSize}${showUnreadOnly ? '&unread_only=1' : ''}`
    );
    const data = await response.json();
    totalNotifications = data.totalCount;
    totalUnread = data.totalUnread;

    const tbody = document.querySelector('#notificationTable tbody');
    tbody.innerHTML = '';

    data.notifications.forEach(notif => {
      const tr = document.createElement('tr');
      tr.style.cursor = 'pointer';
      if (!notif.read) tr.style.fontWeight = 'bold';
      tr.innerHTML = `
        <td>${notif.message}</td>
        <td>${notif.date}</td>
        <td>${notif.read ? 'Read' : 'New'}</td>
      `;
      tr.onclick = () => markAsRead(notif.id);
      tbody.appendChild(tr);
    });

    const effectiveTotal = showUnreadOnly ? totalUnread : totalNotifications;
    btnPrev.disabled = currentPage <= 1;
    btnNext.disabled = (currentPage * pageSize) >= effectiveTotal;

    if (data.notifications.length > 0) {
      const newest = data.notifications[0];
      if (initialized && isLiveUpdate && newest.id > lastAlertedId) {
        playNotificationEffect(newest.message);
      }
      lastAlertedId = Math.max(lastAlertedId, newest.id);
    }

    if (!initialized) initialized = true;
    isLiveUpdate = false;
  } catch (err) {
    console.error('Error fetching notifications:', err);
  }
}

btnPrev.addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    fetchNotifications();
  }
});

btnNext.addEventListener('click', () => {
  const effectiveTotal = showUnreadOnly ? totalUnread : totalNotifications;
  if ((currentPage * pageSize) < effectiveTotal) {
    currentPage++;
    fetchNotifications();
  }
});

bell.addEventListener('click', () => {
  currentPage = 1;
  fetchNotifications();
  modal.style.display = 'flex';
  fetchUnreadCount();
});

closeModal.onclick = () => modal.style.display = 'none';
window.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };

async function markAsRead(id) {
  try {
    const response = await fetch(basePath + 'mark_as_read.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${id}`,
    });
    const result = await response.json();
    if (result.status === 'success') {
      fetchNotifications();
      fetchUnreadCount();
    }
  } catch (err) {
    console.error('Error marking as read:', err);
  }
}

// 🟦 SSE live update
let eventSource;
function initSSE() {
  if (eventSource) eventSource.close();
  eventSource = new EventSource(basePath + 'notifications_stream.php');
  eventSource.onmessage = function() {
    isLiveUpdate = true;
    fetchUnreadCount();
    fetchNotifications();
  };
  eventSource.onerror = function() {
    console.log('SSE connection lost, reconnecting...');
    setTimeout(initSSE, 3000);
  };
}

function initializeNotifications() {
  fetchUnreadCount();
  fetchNotifications();
  initSSE();
}
initializeNotifications();

// 🟧 Mark all as read
document.getElementById('markAllReadBtn').addEventListener('click', async () => {
  try {
    const response = await fetch(basePath + 'mark_as_read.php', { method: 'POST' });
    const result = await response.json();
    if (result.status === 'success') {
      fetchNotifications();
      fetchUnreadCount();
    }
  } catch (err) {
    console.error('Error marking all as read:', err);
  }
});

document.getElementById('filterUnreadBtn').addEventListener('click', () => {
  showUnreadOnly = true;
  document.getElementById('showAllBtn').style.display = 'inline-block';
  document.getElementById('filterUnreadBtn').style.display = 'none';
  currentPage = 1;
  fetchNotifications();
});

document.getElementById('showAllBtn').addEventListener('click', () => {
  showUnreadOnly = false;
  document.getElementById('showAllBtn').style.display = 'none';
  document.getElementById('filterUnreadBtn').style.display = 'inline-block';
  currentPage = 1;
  fetchNotifications();
});
</script>
