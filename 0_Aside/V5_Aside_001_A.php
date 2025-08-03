<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TPCD_entrance首頁</title>
  <link rel="icon" href="..\Icon file\logo1.svg" type="image/svg+xml">
  <style>
    /* CSS 變數管理主題色系與尺寸 */
    :root {
      --aside-width: 280px;
      --aside-collapsed-width: 60px;
      --bg-gradient-start: #000;
      --bg-gradient-end: #262626;
      --aside-bg: linear-gradient(to bottom, var(--bg-gradient-start), var(--bg-gradient-end));
      --text-color: #f3f4f6;
      --hover-bg: #888;
      --hover-text: #2c3e50;
      --primary-color: #FFC107;
      --secondary-color: #FF9800;
      --accent-color: #FF5722;
      --login-bg: #333;
      --shadow-color: rgba(0, 0, 0, 0.2);
      --transition-speed: 0.3s;
      --font-main: 'Arial', sans-serif;
      --header-font: 'Georgia', serif;
    }

    /* 初始暫停動畫 */
    .no-transition, .no-transition * {
      transition: none !important;
    }
    
    /* 主內容設定 */
    body {
      margin: 0;
      font-family: var(--font-main);
      background-color: rgb(239, 239, 239);
      color: #333;
      margin-left: var(--aside-width);
      transition: margin-left var(--transition-speed) ease;
    }
    body.collapsed-aside {
      margin-left: var(--aside-collapsed-width);
    }
    
    /* Aside 側邊欄 */
    .tpcd-aside {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--aside-width);
      height: 100vh;
      background: var(--aside-bg);
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 8px var(--shadow-color);
      transition: width var(--transition-speed) ease;
      overflow: hidden;
    }
    .tpcd-aside.collapsed {
      width: var(--aside-collapsed-width);
      overflow-y: auto;
      overflow-x: hidden;
    }
    .tpcd-aside::-webkit-scrollbar {
      display: none;
    }
    .tpcd-aside {
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    
    .tpcd-logo {
      width: 50px;
      height: 50px;
      margin-bottom: 10px;
      padding-top: 20px;
      border-radius: 50%;
      transition: width var(--transition-speed) ease, height var(--transition-speed) ease;
    }
    
    /* 標題與部門文字 */
    #tpcd-title {
      font-size: 30px;
      font-weight: bold;
      color: #fff;
      margin: 0;
      text-decoration: none;
      font-family: var(--header-font);
      display: flex;
      align-items: center;
    }
    #tpcd-department {
      font-size: 10px;
      font-weight: normal;
      color: #ccc;
      font-style: italic;
      letter-spacing: 1px;
      text-transform: uppercase;
      padding-top: 4px;
    }
    .tpcd-current-time {
      margin-top: 10px;
      font-size: 14px;
      color: #d4d4d8;
    }
    
    /* 右側漸層線 */
    .tpcd-aside::after {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(180deg, var(--primary-color), var(--secondary-color), var(--primary-color), var(--accent-color));
      background-size: 100% 300%;
      animation: gradientMove 6s ease-in-out infinite;
    }
    @keyframes gradientMove {
      0% { background-position: 0% 0%; }
      50% { background-position: 0% 100%; }
      100% { background-position: 0% 0%; }
    }
    
    /* Aside 頂部 */
    .tpcd-aside-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      border-bottom: 1px solid #444;
      transition: opacity var(--transition-speed) ease, padding var(--transition-speed) ease;
    }
    /* aside 收合時隱藏除 logo 外的其他內容 */
    .tpcd-aside.collapsed .tpcd-aside-header > *:not(.tpcd-logo) {
      opacity: 0;
      pointer-events: none;
      height: 0;
      margin: 0;
      overflow: hidden;
    }
    
    /* 導覽列 */
    .tpcd-nav {
      flex: 1;
      overflow-y: auto;
      padding: 10px 0;
    }
    .tpcd-nav a {
      display: block;
      color: var(--text-color);
      text-decoration: none;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 5px;
      transition: background-color var(--transition-speed) ease;
      white-space: nowrap;
    }
    .tpcd-nav a:hover {
      background-color: var(--hover-bg);
      color: var(--hover-text);
    }
    .tpcd-nav-icon {
      width: 20px;
      height: 20px;
      vertical-align: middle;
      margin-right: 10px;
    }
    .nav-text {
      vertical-align: middle;
    }
    /* aside 收合狀態下僅顯示 icon */
    .tpcd-aside.collapsed .tpcd-nav a .nav-text {
      display: none;
    }
    
    /* 下拉選單效果 */
    .tpcd-dropdown {
      position: relative;
    }
    .tpcd-dropdown > a {
      position: relative;
    }
    .tpcd-dropdown > a:hover {
      color: transparent;
    }
    .tpcd-dropdown > a:hover::after {
      content: "***待更新 (WAIT DADETE)***";
      position: absolute;
      left: calc(20px + 20px + 10px);
      top: 50%;
      transform: translateY(-50%);
      font-size: 16px;
      color: rgb(232, 149, 4);
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }
    .tpcd-dropdown > a:hover::after {
      content: "";
    }
    .tpcd-dropdown-content {
      display: none;
      background-color: rgb(50,50,50);
      box-shadow: 0px 4px 8px var(--shadow-color);
      border-radius: 5px;
      margin-left: 20px;
      padding: 10px;
    }
    .tpcd-dropdown.expanded .tpcd-dropdown-content {
      display: block;
    }
    .tpcd-dropdown-content input {
      width: 100%;
      margin: 5px 0;
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .tpcd-dropdown-content .error-message {
      color: red;
      font-size: 14px;
      margin-top: 5px;
    }
    .tpcd-dropdown-content .login-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 5px;
    }
    .tpcd-dropdown-content .login-actions button {
      width: 48%;
      padding: 5px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }
    .tpcd-dropdown-content .login-actions button:hover {
      background-color: var(--hover-bg);
    }
    
    /* 收合/展開按鈕 */
    #aside-toggle {
      position: fixed;
      top: 0;
      left: calc(var(--aside-width) - 30px);
      border: none;
      color: grey;
      font-size: 20px;
      cursor: pointer;
      z-index: 1000;
      padding: 5px 15px;
      border-radius: 4px;
      transition: left var(--transition-speed) ease;
      background: none;
    }
    body.collapsed-aside #aside-toggle {
      left: calc(var(--aside-collapsed-width) - 30px);
    }
  </style>
</head>
<body class="no-transition">
  <!-- Aside 側邊欄 -->
  <aside class="tpcd-aside" id="sidebar">
    <div class="tpcd-aside-header">
      <img src="..\Icon file\logo1.svg" alt="TPCD Logo" class="tpcd-logo">
      <a href="..\0_homepage\V1_M_Top_main.php" id="tpcd-title">TPCD</a>
      <span id="tpcd-department">Test Probe Card Department</span>
      <div class="tpcd-current-time" id="current-time"></div>
    </div>
    <!-- 導覽列，包含一般選項與登入項目 -->
    <nav class="tpcd-nav">
      <div class="tpcd-dropdown">
        <a href="..\V50_homepage\V50_homepage D.php">
          <img src="..\Icon file\Aside\Home.png" alt="首頁" class="tpcd-nav-icon">
          <span class="nav-text">首頁</span>
        </a>
      </div>
      <div class="tpcd-dropdown">
        <a href="..\V51_deviceonwerlist\V5_M_deviceownerlist D.php">
          <img src="..\Icon file\Aside\owner.png" alt="Device owner control table" class="tpcd-nav-icon">
          <span class="nav-text">Device owner control table</span>
        </a>
      </div>
      <div class="tpcd-dropdown">
        <a href="#">
          <img src="..\Icon file\Aside\tester.png" alt="Validation tool control table" class="tpcd-nav-icon">
          <span class="nav-text">Validation tool control table</span>
        </a>
      </div>
      <div class="tpcd-dropdown">
        <a href="#">
          <img src="..\Icon file\Aside\ateam.png" alt="PCR A-team booking" class="tpcd-nav-icon">
          <span class="nav-text">PCR A-team booking</span>
        </a>
      </div>
      <div class="tpcd-dropdown">
        <a href="#">
          <img src="..\Icon file\Aside\machine.png" alt="P/C Tool status dashbroad" class="tpcd-nav-icon">
          <span class="nav-text">P/C Tool status dashbroad</span>
        </a>
      </div>
      <div class="tpcd-dropdown">
        <a href="#">
          <img src="..\Icon file\Aside\development.png" alt="Development progress" class="tpcd-nav-icon">
          <span class="nav-text">Development progress</span>
        </a>
      </div>
      <!-- 登入項目：與其他選項同排序，點選後展開登入/登出下拉表單 -->
      <div class="tpcd-dropdown" id="login-dropdown">
        <a href="#" id="login-link">
          <img src="..\Icon file\Aside\log.png" alt="Login Icon" class="tpcd-nav-icon">
          <span class="nav-text" id="login-text">Log In</span>
        </a>
        <div class="tpcd-dropdown-content" id="login-dropdown-content">
          <!-- 登入表單 -->
          <div id="login-form-content">
            <input type="text" id="username-input" placeholder="Enter username">
            <input type="password" id="password-input" placeholder="Enter password">
            <div class="error-message" style="display: none;"></div>
            <div class="login-actions">
              <button id="submit-login">Submit</button>
              <button id="cancel-login">Cancel</button>
            </div>
          </div>
          <!-- 登入後顯示 -->
          <div id="user-info" style="display: none;">
            <span id="greeting"></span>
            <button id="logout-btn">Log Out</button>
          </div>
        </div>
      </div>
    </nav>
  </aside>
  
  <!-- 收合/展開 aside 按鈕 -->
  <button id="aside-toggle" aria-label="Toggle sidebar">☰</button>
  
  <!-- 主內容區 -->
  <script>
    // 初始化 aside 狀態與移除暫停動畫
    document.addEventListener("DOMContentLoaded", function() {
      var isCollapsed = localStorage.getItem("asideCollapsed") === "true";
      var sidebar = document.getElementById('sidebar');
      var body = document.body;
      if(isCollapsed) {
        sidebar.classList.add("collapsed");
        body.classList.add("collapsed-aside");
      }
      setTimeout(function(){
        body.classList.remove("no-transition");
        sidebar.classList.remove("no-transition");
      }, 50);
    });
    
    // 時間更新
    function getWeekNumber(d) {
      d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
      d.setUTCDate(d.getUTCDate() - d.getUTCDay());
      const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
      const weekNumber = Math.ceil(((d - yearStart) / 86400000 + 2) / 7);
      return weekNumber;
    }
    
    function updateTime() {
      const now = new Date();
      const year = now.getFullYear();
      const yearDigit = String(year).slice(-1);
      const weekNumber = getWeekNumber(now) + 1;
      const weekPadded = String(weekNumber).padStart(2, '0');
      const weekStr = `W${yearDigit}${weekPadded}`;
      
      const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
      const dayAbbrev = days[now.getDay()] + '.';
      
      const month = String(now.getMonth() + 1).padStart(2, '0');
      const date = String(now.getDate()).padStart(2, '0');
      const hours = String(now.getHours()).padStart(2, '0');
      const minutes = String(now.getMinutes()).padStart(2, '0');
      
      const formattedTime = `${weekStr} ${dayAbbrev} ${year}/${month}/${date} ${hours}:${minutes}`;
      document.getElementById('current-time').textContent = formattedTime;
    }
    
    updateTime();
    setInterval(updateTime, 60000);
    
    // aside 收合/展開控制
    document.getElementById('aside-toggle').addEventListener('click', function() {
      var sidebar = document.getElementById('sidebar');
      var isCollapsed = sidebar.classList.toggle('collapsed');
      document.body.classList.toggle('collapsed-aside');
      localStorage.setItem("asideCollapsed", isCollapsed);
    });
    
    // 點擊頁面其他區域時自動收合 aside
    document.addEventListener('click', function (event) {
      var sidebar = document.getElementById('sidebar');
      var toggleButton = document.getElementById('aside-toggle');
      if (!sidebar.contains(event.target) && event.target !== toggleButton) {
        sidebar.classList.add('collapsed');
        document.body.classList.add('collapsed-aside');
        localStorage.setItem("asideCollapsed", "true");
      }
    });
    
    // 登入功能：整合於導覽列的下拉表單
    document.addEventListener("DOMContentLoaded", function() {
      var loginLink = document.getElementById("login-link");
      var loginDropdownContent = document.getElementById("login-dropdown-content");
      var loginFormContent = document.getElementById("login-form-content");
      var userInfo = document.getElementById("user-info");
      var greeting = document.getElementById("greeting");
      var usernameInput = document.getElementById("username-input");
      var passwordInput = document.getElementById("password-input");
      var errorMessage = document.querySelector("#login-dropdown-content .error-message");
      var submitLogin = document.getElementById("submit-login");
      var cancelLogin = document.getElementById("cancel-login");
      var logoutBtn = document.getElementById("logout-btn");

      // 檢查是否已登入
      var storedUsername = localStorage.getItem("username");
      if (storedUsername) {
        greeting.textContent = "Hi, " + storedUsername;
        userInfo.style.display = "block";
        loginFormContent.style.display = "none";
        document.getElementById("login-text").textContent = "Hi, " + storedUsername;
      } else {
        userInfo.style.display = "none";
        loginFormContent.style.display = "block";
        document.getElementById("login-text").textContent = "Log In";
      }

      // 點擊登入項目切換下拉表單顯示
      loginLink.addEventListener("click", function(e) {
        e.preventDefault();
        // 切換展開狀態
        if (loginDropdownContent.style.display === "block") {
          loginDropdownContent.style.display = "none";
        } else {
          loginDropdownContent.style.display = "block";
        }
      });

      submitLogin.addEventListener("click", function() {
        var username = usernameInput.value.trim();
        var password = passwordInput.value.trim();
        if (username === "" || password === "") {
          errorMessage.textContent = username === "" ? "請輸入使用者名稱" : "請輸入密碼";
          errorMessage.style.display = "block";
          return;
        }
        localStorage.setItem("username", username);
        greeting.textContent = "Hi, " + username;
        document.getElementById("login-text").textContent = "Hi, " + username;
        userInfo.style.display = "block";
        loginFormContent.style.display = "none";
        errorMessage.style.display = "none";
      });

      cancelLogin.addEventListener("click", function() {
        usernameInput.value = "";
        passwordInput.value = "";
        errorMessage.style.display = "none";
        loginDropdownContent.style.display = "none";
      });

      logoutBtn.addEventListener("click", function() {
        localStorage.removeItem("username");
        greeting.textContent = "";
        userInfo.style.display = "none";
        loginFormContent.style.display = "block";
        document.getElementById("login-text").textContent = "Log In";
      });

      usernameInput.addEventListener("input", function() {
        if (usernameInput.value.trim() !== "") {
          errorMessage.style.display = "none";
        }
      });
      passwordInput.addEventListener("input", function() {
        if (passwordInput.value.trim() !== "") {
          errorMessage.style.display = "none";
        }
      });
    });
  </script>
</body>
</html>
