<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VM Dashboard - 版面整合</title>
  <link rel="icon" href="..\..\Project02\Icon file\VM logo.svg" type="image/svg+xml">
  <style>
    /* 初始暫停動畫 */
    .no-transition, .no-transition * {
      transition: none !important;
    }

    /* 字體 */
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Noto+Sans+TC:wght@300;400;500;700&display=swap');

    /* 主體設定 */
    body {
      margin: 0;
      font-family: 'Roboto', 'Noto Sans TC', Arial, sans-serif;
      background-color: #f0f2f5; /* 主要內容背景色 */
      color: #333;
      margin-left: 280px; /* 初始側邊欄寬度，JS 會控制 */
      padding-top: 75px; /* Header 高度 + 間隙 */
      transition: margin-left 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
      overflow-x: hidden;
      position: relative;
    }

    body.collapsed-aside {
      margin-left: 70px; /* 收合後側邊欄寬度，JS 會控制 */
    }

    /* Header 區域 */
    #main-header {
      position: fixed;
      top: 0;
      left: 280px; /* 初始側邊欄寬度，JS 會控制 */
      right: 0;
      height: 60px;
      background-color: #1a222e; /* 主色 */
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 25px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.15);
      z-index: 999; /* 比 aside 低一層，但高於內容 */
      transition: left 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    #main-header h1 {
      font-size: 1.5em;
      margin: 0;
      font-weight: 500;
    }
    #main-header .user-info {
      font-size: 0.9em;
    }

    body.collapsed-aside #main-header {
      left: 70px; /* 收合後側邊欄寬度，JS 會控制 */
    }

    /* 主要內容容器 */
    .page-content {
        padding: 20px;
    }


    /* Aside 側邊欄 */
    .tpcd-aside {
      position: fixed;
      top: 0;
      left: 0;
      width: 280px;
      height: 100vh;
      background:rgb(11, 28, 32); /* 副色 */
      display: flex;
      flex-direction: column;
      box-shadow: 3px 0 15px rgba(0,0,0,0.25);
      transition: width 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
      overflow-y: auto;
      overflow-x: hidden;
      z-index: 1000;
    }

    .tpcd-aside.collapsed {
      width: 70px;
    }

    .tpcd-aside::-webkit-scrollbar {
      width: 6px;
    }
    .tpcd-aside::-webkit-scrollbar-track {
      background: rgba(255,255,255,0.08);
    }
    .tpcd-aside::-webkit-scrollbar-thumb {
      background: rgba(255,255,255,0.2);
      border-radius: 3px;
    }
    .tpcd-aside::-webkit-scrollbar-thumb:hover {
      background: rgba(255,255,255,0.3);
    }


    /* Aside 頂部：Logo 與標題 */
    .tpcd-aside-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 25px 15px;
      border-bottom: 1px solid #3d5f6d; /* 副色的暗色調做為分隔線 */
      transition: padding 0.4s ease, opacity 0.3s ease;
      text-align: center;
    }
    .tpcd-logo { /* 使用者提供的 LOGO */
      width: 60px; /* 可調整 LOGO 大小 */
      height: 60px; /* 可調整 LOGO 大小 */
      margin-bottom: 10px;
      /* border-radius: 50%; */ /* SVG 可能不需要圓角，根據 LOGO 設計決定 */
      transition: width 0.3s ease, height 0.3s ease;
    }
    

    .tpcd-aside.collapsed .tpcd-logo {
      width: 40px; /* 收合時 LOGO 大小 */
      height: 40px; /* 收合時 LOGO 大小 */
      margin-bottom: 0;
      padding: 4px 0;
    }

    #tpcd-title {
      font-size: 28px; /* 調整標題大小 */
      font-weight: bold;
      font-family: 'Georgia', serif;
      color: white;
      margin: 0;
      text-decoration: none;
      letter-spacing: 0.5px;
      transition: opacity 0.3s ease 0.1s, transform 0.3s ease 0.1s;
    }

    #tpcd-department {
      font-size: 10px;
      font-weight: normal;
      color: #ccc;
      font-style: italic;
      letter-spacing: 1px;
      text-transform: uppercase;
      padding-top: 4px;
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .tpcd-current-time {
      margin-top: 15px;
      font-size: 14px;
      color: #d4d4d8;
      font-weight: 400;
      transition: opacity 0.3s ease 0.05s, transform 0.3s ease 0.05s;
    }

    .tpcd-aside.collapsed .tpcd-aside-header > *:not(.tpcd-logo) {
      opacity: 0;
      pointer-events: none;
      height: 0;
      margin: 0 !important;
      padding: 0 !important;
      transform: translateY(-10px);
      overflow: hidden;
    }

    /* 移除原始的金色漸層邊框 .tpcd-aside::after */


    /* Aside 導覽列 */
    .tpcd-nav {
      padding-top: 10px;
      flex-grow: 1;
    }

    .tpcd-nav a {
      display: flex;
      align-items: center;
      color: #f0f0f0; /* 導覽文字顏色 */
      text-decoration: none;
      padding: 12px 25px;
      font-size: 15px;
      border-radius: 8px;
      margin: 4px 10px;
      transition: background-color 0.3s ease, color 0.3s ease, padding-left 0.3s ease;
      white-space: nowrap;
      position: relative;
      overflow: hidden;
      
    }

    .tpcd-nav a:hover {
      background-color: #1a222e; /* 主色作為 Hover 背景 */
      color: #ffffff;
      padding-left: 30px;
    }

    .tpcd-nav a.active {
      background-color: rgba(50, 68, 85, 0.6); /* 主色相關的較亮色調 */
      color: #ffffff; /* Active 時文字顏色 */
      font-weight: 500;
    }
    .tpcd-nav a.active::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 70%;
      background-color: #1a222e; /* 主色作為 Active 指示條 */
      border-radius: 0 2px 2px 0;
    }


    .tpcd-nav-icon {
      width: 20px;
      height: 20px;
      vertical-align: middle;
      margin-right: 15px;
      transition: transform 0.3s ease, filter 0.3s ease;
      filter: grayscale(10%) opacity(0.85); /* 調整圖示在副色背景上的對比和飽和度 */
    }
    .tpcd-nav a:hover .tpcd-nav-icon {
      transform: scale(1.1);
      filter: grayscale(0%) opacity(1);
    }

    .nav-text {
      vertical-align: middle;
      opacity: 1;
      transform: translateX(0);
      transition: opacity 0.3s ease 0.1s, transform 0.3s ease 0.1s;
    }

    .tpcd-aside.collapsed .tpcd-nav a {
      padding: 12px 20px;
      justify-content: center;
    }

    .tpcd-aside.collapsed .tpcd-nav a .nav-text {
      opacity: 0;
      transform: translateX(-20px);
      pointer-events: none;
      width: 0;
      display: inline-block;
    }
    .tpcd-aside.collapsed .tpcd-nav a .tpcd-nav-icon {
      margin-right: 0;
    }


    .tpcd-dropdown {
      position: relative;
    }
    .tpcd-dropdown > a.tpcd-dropdown-toggle::after {
        content: '›';
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%) rotate(0deg);
        font-size: 20px;
        transition: transform 0.3s ease;
        color: #bbb;
    }
    .tpcd-dropdown.expanded > a.tpcd-dropdown-toggle::after {
        transform: translateY(-50%) rotate(90deg);
    }
    .tpcd-aside.collapsed .tpcd-dropdown > a.tpcd-dropdown-toggle::after {
        opacity: 0;
        display:none;
    }

    .tpcd-dropdown-content {
      display: none;
      background-color: #2c3a4a; /* 調整為比主色稍亮的深藍灰色調 */
      border-radius: 5px;
      margin: 5px 10px 5px 35px;
      overflow: hidden;
      max-height: 0;
      opacity: 0;
      transition: max-height 0.4s ease-out, padding-top 0.4s ease-out, padding-bottom 0.4s ease-out, opacity 0.3s ease-out;
    }

    .tpcd-dropdown.expanded .tpcd-dropdown-content {
      display: block;
      max-height: 500px;
      opacity: 1;
      padding-top: 5px;
      padding-bottom: 5px;
    }
    .tpcd-dropdown-content a {
      padding: 8px 20px;
      font-size: 14px;
      color: #e0e0e0;
      display: block;
      margin: 2px 0;
    }
    .tpcd-dropdown-content a:hover {
      background-color: #1a222e; /* 主色 */
      color: #ffffff;
    }
    .tpcd-aside.collapsed .tpcd-dropdown-content {
        display: none !important;
        opacity: 0;
        max-height: 0;
    }
    .tpcd-aside.collapsed .tpcd-dropdown.expanded > a.tpcd-dropdown-toggle::after{
        display: none;
    }


    #aside-toggle { /* 側邊欄收合按鈕 */
      position: fixed;
      top: 15px; /* 對齊 Header 的垂直位置 */
      left: 280px; /* 初始位置，JS 會控制 */
      border: none;
      background-color: #1A444F; /* 副色 */
      color: #f0f0f0;
      cursor: pointer;
      z-index: 1050; /* 確保在 Header 和 Aside 之上 */
      padding: 8px 10px; /* 調整 padding */
      margin-left: 10px; /* 與 aside 的間隙 */
      border-radius: 0 8px 8px 0; /* 圓角調整 */
      transition: left 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), background-color 0.3s ease, transform 0.3s ease;
      box-shadow: 2px 0 8px rgba(0,0,0,0.2);
      font-size: 20px;
      line-height: 1;
    }
     #aside-toggle:hover {
        background-color: #1a222e; /* 主色 */
        transform: translateX(1px); /* 微調 hover 動畫 */
     }

    body.collapsed-aside #aside-toggle {
      left: 70px; /* 收合後的位置，JS 會控制 */
    }
    #aside-toggle::before {
        content: '‹';
        display: inline-block;
        transition: transform 0.3s ease;
    }
    body.collapsed-aside #aside-toggle::before {
        content: '›';
    }


    /* 群組標題 */
    .tpcd-group-title {
      font-size: 11px;
      color: #aabbc3; /* 調整為在副色背景下更清晰的淺灰藍 */
      padding: 20px 25px 8px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      font-weight: 500;
      display: block;
      margin: 10px 0 5px 0;
      transition: all 0.4s ease;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .tpcd-aside.collapsed .tpcd-group-title {
      text-align: center;
      font-size: 0px;
      opacity: 0;
      height: 0;
      margin: 0;
      padding: 0;
      border: none;
      transform: scale(0.5);
    }


    #pin-toggle-container {
      padding: 15px 0;
      margin-top: auto;
      border-top: 1px solid #3d5f6d; /* 副色的暗色調 */
      display: flex;
      justify-content: center;
      align-items: center;
      transition: opacity 0.3s ease 0.1s;
    }

    #pin-toggle {
      border: none;
      background: none;
      cursor: pointer;
      padding: 5px;
    }
    #pin-toggle img {
      width: 22px;
      height: 22px;
      transition: transform 0.3s ease, filter 0.3s ease;
      filter: grayscale(20%) opacity(0.8);
    }
    #pin-toggle:hover img {
      transform: scale(1.15);
      filter: grayscale(0%) opacity(1);
    }

  </style>
</head>

<body class="no-transition">
  <aside class="tpcd-aside" id="sidebar">
    <div class="tpcd-aside-header">
      <img src="..\..\Project02\Icon file\VM logo.svg" alt="VM Logo" class="tpcd-logo">
      <a href="..\0_homepage\V1_M_Top_main.php" id="tpcd-title">TPCD</a> <span id="tpcd-department">Information Center of Vendor Management</span> <div class="tpcd-current-time" id="current-time"></div>
    </div>

    <nav class="tpcd-nav">
      <div class="tpcd-group">
        <div class="tpcd-group-title">General</div>
        <div class="tpcd-dropdown">
          <a href="..\V50_homepage\V50_homepage D.php"> <img src="..\Icon file\Aside\Home.png" alt="首頁" class="tpcd-nav-icon"> <span class="nav-text">首頁</span>
          </a>
        </div>
        <div class="tpcd-dropdown">
          <a href="..\V51_deviceonwerlist\V5_M_deviceownerlist D.php"> <img src="..\Icon file\Aside\owner.png" alt="項目管理" class="tpcd-nav-icon"> <span class="nav-text">項目管理</span>
          </a>
        </div>
      </div>

      <div class="tpcd-group">
        <div class="tpcd-group-title">Tools</div>
        <div class="tpcd-dropdown">
          <a href="#">
            <img src="..\Icon file\Aside\tester.png" alt="工具A" class="tpcd-nav-icon"> <span class="nav-text">工具 A</span>
          </a>
        </div>
        <div class="tpcd-dropdown">
          <a href="#">
            <img src="..\Icon file\Aside\ateam.png" alt="工具B" class="tpcd-nav-icon"> <span class="nav-text">工具 B</span>
          </a>
        </div>
      </div>

      <div class="tpcd-group">
        <div class="tpcd-group-title">Reports</div>
        <div class="tpcd-dropdown">
          <a href="#">
            <img src="..\Icon file\Aside\machine.png" alt="報表X" class="tpcd-nav-icon"> <span class="nav-text">報表 X</span>
          </a>
        </div>
        <div class="tpcd-dropdown" id="development-dropdown">
          <a href="#" class="tpcd-dropdown-toggle">
            <img src="..\Icon file\Aside\development.png" alt="進階功能" class="tpcd-nav-icon"> <span class="nav-text">進階功能</span>
          </a>
          <div class="tpcd-dropdown-content">
            <a href="#">功能甲</a>
            <a href="#">功能乙</a>
            <a href="#">功能丙</a>
          </div>
        </div>
      </div>
    </nav>

    <div id="pin-toggle-container">
      <button id="pin-toggle" aria-label="Toggle Auto Collapse">
        <img id="pin-toggle-img" src="../icons/pin1.png" alt="Auto Collapse Toggle">
      </button>
    </div>
  </aside>

  <header id="main-header">
    <h1>控制台主頁</h1>
    <div class="user-info">使用者：Demo User</div>
  </header>

  <button id="aside-toggle" aria-label="Toggle sidebar"></button>

  <main class="page-content">
    <h2>歡迎來到 VM 系統</h2>
    <p>這裡是您的主要工作區域。</p>
    </main>


  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const sidebar = document.getElementById('sidebar');
      const body = document.body;
      const asideToggleBtn = document.getElementById('aside-toggle');
      const pinToggleBtn = document.getElementById('pin-toggle');
      const pinToggleImg = document.getElementById('pin-toggle-img');
      const header = document.getElementById('main-header'); // 新增：獲取 header 元素

      let isCollapsed = localStorage.getItem("asideCollapsed") === "true";

      // 初始化 localStorage 中的 autoCollapse，如果不存在
      if (localStorage.getItem("autoCollapse") === null) {
        localStorage.setItem("autoCollapse", "true");
      }

      // 統一更新佈局的函數
      function updateLayout(collapsed) {
          isCollapsed = collapsed; // 更新全局狀態
          if (sidebar) {
            sidebar.classList.toggle("collapsed", collapsed);
          }
          body.classList.toggle("collapsed-aside", collapsed);
          if (header) { // 更新 header 的 left 樣式
            header.style.left = collapsed ? '70px' : '280px';
          }
          // 更新 aside-toggle 按鈕的 left 樣式
          if (asideToggleBtn) {
            asideToggleBtn.style.left = collapsed ? '70px' : '280px';
          }
          localStorage.setItem("asideCollapsed", collapsed);
      }

      // 初始佈局設定
      updateLayout(isCollapsed);
      updatePinToggleImg(); // 更新釘選圖示

      // 延遲移除 no-transition 以避免初始動畫
      setTimeout(function() {
        body.classList.remove("no-transition");
        if(sidebar) sidebar.classList.remove("no-transition");
        if(header) header.classList.remove("no-transition"); // header 也移除
        if(asideToggleBtn) asideToggleBtn.classList.remove("no-transition"); // toggle 按鈕也移除
      }, 50);


      function getWeekNumber(d) {
        d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
        d.setUTCDate(d.getUTCDate() - d.getUTCDay());
        const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
        const weekNumber = Math.ceil(((d - yearStart) / 86400000 + 1) / 7);
        return weekNumber;
      }

      function updateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const yearDigit = String(year).slice(-1);
        const weekNumberBasedOnOriginalLogic = getWeekNumber(now);
        const weekPadded = String(weekNumberBasedOnOriginalLogic).padStart(2, '0');
        const weekStr = `W${yearDigit}${weekPadded}`;
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        const dayAbbrev = days[now.getDay()] + '.';
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const date = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const formattedTime = `${weekStr} ${dayAbbrev} ${year}/${month}/${date} ${hours}:${minutes}`;
        const timeElement = document.getElementById('current-time');
        if (timeElement) {
            timeElement.textContent = formattedTime;
        }
      }

      updateTime();
      setInterval(updateTime, 60000);

      function updatePinToggleImg() {
        if (!pinToggleImg) return;
        const autoCollapse = localStorage.getItem("autoCollapse") === "true";
        // 確保釘選圖示路徑正確
        if (autoCollapse) {
          pinToggleImg.src = '../icons/pin1.png'; // 或您的 VM 主題圖示
          pinToggleImg.alt = 'Auto collapse enabled (Unpinned)';
        } else {
          pinToggleImg.src = '../icons/pin2.png'; // 或您的 VM 主題圖示
          pinToggleImg.alt = 'Auto collapse disabled (Pinned)';
        }
      }

      if (asideToggleBtn) {
        asideToggleBtn.addEventListener('click', function() {
          updateLayout(!sidebar.classList.contains('collapsed'));
        });
      }

      if (pinToggleBtn) {
        pinToggleBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          let current = localStorage.getItem("autoCollapse");
          let newValue = current === "true" ? "false" : "true";
          localStorage.setItem("autoCollapse", newValue);
          updatePinToggleImg();
        });
      }

      document.addEventListener('click', function (event) {
        if (!sidebar || !asideToggleBtn || !header) return;
        const autoCollapseEnabled = localStorage.getItem('autoCollapse') === "true";

        // isCollapsed 應該使用全局更新的 isCollapsed 變數
        if (autoCollapseEnabled && !isCollapsed) {
          // 檢查點擊是否在 sidebar, asideToggleBtn, header 之外
          if (!sidebar.contains(event.target) &&
              !asideToggleBtn.contains(event.target) &&
              !header.contains(event.target) // 避免點擊 header 時也觸發收合
             ) {
            updateLayout(true);
          }
        }
      });

      const dropdownToggles = document.querySelectorAll('.tpcd-dropdown .tpcd-dropdown-toggle');
      dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(event) {
          event.preventDefault();
          if (!sidebar) return;
          const parentDropdown = this.closest('.tpcd-dropdown');
          if (parentDropdown) {
            if (sidebar.classList.contains('collapsed')) {
                updateLayout(false); // 先展開側邊欄
                // 延遲一點再展開下拉選單，確保側邊欄動畫完成
                setTimeout(() => {
                    parentDropdown.classList.toggle('expanded');
                }, 300); // 這個延遲時間可以根據側邊欄動畫時間調整
            } else {
                parentDropdown.classList.toggle('expanded');
            }
          }
        });
      });

      const navLinks = document.querySelectorAll('.tpcd-nav a:not(.tpcd-dropdown-toggle)');
      navLinks.forEach(link => {
        if (!link.closest('.tpcd-dropdown-content')) { // 非下拉選單內的連結
            link.addEventListener('click', function(event) {
                // 移除所有主要導航連結和下拉標題的 active class
                document.querySelectorAll('.tpcd-nav > .tpcd-group > .tpcd-dropdown > a.active, .tpcd-nav > .tpcd-group > .tpcd-dropdown.expanded > a.active').forEach(activeLink => {
                    activeLink.classList.remove('active');
                });
                // 移除所有下拉選單內容中的 active class
                document.querySelectorAll('.tpcd-dropdown-content a.active').forEach(activeLink => {
                    activeLink.classList.remove('active');
                });

                this.classList.add('active');

                // 如果點擊的是下拉選單的觸發器，則其父 .tpcd-dropdown 也應該保持 expanded
                const parentDropdownToggle = this.closest('.tpcd-dropdown');
                if (parentDropdownToggle && this.classList.contains('tpcd-dropdown-toggle')) {
                    // 此處邏輯由 dropdownToggles 的事件處理器負責 expanded class
                } else if (parentDropdownToggle) {
                    // 如果點擊的是普通連結，且該連結位於一個已展開的下拉選單的父層，則不需要關閉該下拉
                }

                // 關閉其他已展開的下拉選單 (如果需要)
                // document.querySelectorAll('.tpcd-dropdown.expanded').forEach(expandedDropdown => {
                //   if (!this.closest('.tpcd-dropdown') || (this.closest('.tpcd-dropdown') !== expandedDropdown && !this.classList.contains('tpcd-dropdown-toggle'))) {
                //     // expandedDropdown.classList.remove('expanded'); // 這行會導致點擊下拉項時，下拉菜單收起
                //   }
                // });
            });
        }
      });
      // 下拉選單內的連結點擊也設定 active
      const dropdownContentLinks = document.querySelectorAll('.tpcd-dropdown-content a');
        dropdownContentLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                // 移除所有連結的 active class
                document.querySelectorAll('.tpcd-nav a.active').forEach(activeLink => {
                    activeLink.classList.remove('active');
                });
                // 為當前點擊的連結添加 active class
                this.classList.add('active');
                // 同時為其父下拉選單的觸發器也添加 active class
                const parentToggle = this.closest('.tpcd-dropdown').querySelector('.tpcd-dropdown-toggle');
                if (parentToggle) {
                    parentToggle.classList.add('active');
                }
            });
        });


      function setActiveLink() {
        if (!sidebar) return;
        const currentPath = window.location.pathname;
        const currentFile = currentPath.substring(currentPath.lastIndexOf('/') + 1) || "V1_M_Top_main.php"; // 預設首頁檔案

        let activeSet = false;
        document.querySelectorAll('.tpcd-nav a').forEach(navLink => {
            navLink.classList.remove('active');
            const linkHref = navLink.getAttribute('href');
            if (linkHref) {
                const linkFile = linkHref.substring(linkHref.lastIndexOf('/') + 1);
                if (linkFile && currentFile && linkFile.toLowerCase() === currentFile.toLowerCase() && currentFile !== '') {
                    navLink.classList.add('active');
                    activeSet = true;
                    const dropdownContent = navLink.closest('.tpcd-dropdown-content');
                    if(dropdownContent){
                        const parentDropdown = dropdownContent.closest('.tpcd-dropdown');
                        if(parentDropdown) {
                            parentDropdown.classList.add('expanded');
                            const parentToggle = parentDropdown.querySelector('.tpcd-dropdown-toggle');
                            if (parentToggle) parentToggle.classList.add('active');
                        }
                    } else { // 如果是頂層的下拉觸發器本身匹配
                        const parentDropdown = navLink.closest('.tpcd-dropdown');
                        if (parentDropdown && navLink.classList.contains('tpcd-dropdown-toggle')) {
                           // parentDropdown.classList.add('expanded'); // 初始不自動展開，除非子項 active
                        }
                    }
                }
            }
        });
        // 如果沒有根據檔案名精確匹配到 active，則檢查預設首頁
        if (!activeSet) {
            const homeLinkSelectors = [
                '.tpcd-nav a[href*="V50_homepage D.php"]', // 參考代碼中的首頁
                '.tpcd-nav a[href*="V1_M_Top_main.php"]'  // 另一個可能的首頁
            ];
            let homeLinkFound = false;
            for (const selector of homeLinkSelectors) {
                const homeLink = document.querySelector(selector);
                if (homeLink && (currentFile.toLowerCase() === "v1_m_top_main.php" || currentPath === "/" || currentFile === "")) {
                    homeLink.classList.add('active');
                    homeLinkFound = true;
                    break;
                }
            }
        }
      }
      setActiveLink();
    });
  </script>
</body>
</html>