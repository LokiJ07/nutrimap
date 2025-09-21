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
    <div class="bell" id="bellBtn"><i class="fa fa-bell"></i></div>
  </div>
</header>

<div id="sidemenu-container"></div>

<!-- <script>
document.getElementById('menuBtn').addEventListener('click', async () => {
  const container = document.getElementById('sidemenu-container');

  // Load side menu only once
  if (!container.innerHTML.trim()) {
    const response = await fetch('sidemenu.php');
    const html = await response.text();
    container.innerHTML = html;

    // Attach close button listener
    const menu = document.getElementById('sideMenu');
    const closeBtn = menu.querySelector('.close-btn');
    closeBtn.addEventListener('click', () => menu.classList.remove('open'));
  }

  // Open menu
  const menu = document.getElementById('sideMenu');
  if (menu) menu.classList.add('open');
});
</script> -->

<script>
document.getElementById('menuBtn').addEventListener('click', async () => {
  const container = document.getElementById('sidemenu-container');

  // Load side menu only once
  if (!container.innerHTML.trim()) {
    const response = await fetch('sidemenu.php');
    const html = await response.text();
    container.innerHTML = html;

    const menu = document.getElementById('sideMenu');
    if (!menu) return;

    // Close button
    const closeBtn = menu.querySelector('.close-btn');
    if (closeBtn) closeBtn.addEventListener('click', () => menu.classList.remove('open'));

    // Menu links
    const menuItems = menu.querySelectorAll('.menu-links li[data-url]');
    menuItems.forEach(item => {
      item.addEventListener('click', () => {
        const url = item.getAttribute('data-url');
        if (url) window.location.href = url;
        menu.classList.remove('open');
      });
    });

    // Footer links
    const footerLinks = menu.querySelectorAll('.footer-links > a');
    footerLinks.forEach(link => {
      link.addEventListener('click', () => menu.classList.remove('open'));
    });

    // ✅ Profile click
    const profileBtn = menu.querySelector('#userProfileBtn');
    if (profileBtn) {
      profileBtn.addEventListener('click', () => {
        window.location.href = 'profile.php';
        menu.classList.remove('open');
      });
    }

    // Settings dropdown
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

  // Open menu
  const menu = document.getElementById('sideMenu');
  if (menu) menu.classList.add('open');
});
</script>



