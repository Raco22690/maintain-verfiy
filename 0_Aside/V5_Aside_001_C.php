<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TPCD_entrance首頁</title>
  <link rel="icon" href="..\Icon file\logo1.svg" type="image/svg+xml">
  <style>
    /* 初始暫停動畫 */
    .no-transition, .no-transition * {
      transition: none !important;
    }
    
    /* 主體設定：aside 預設 280px，收合時變 60px */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: rgb(239, 239, 239);
      color: #333;
      margin-left: 280px;
      transition: margin-left 0.3s ease;
    }
    body.collapsed-aside {
      margin-left: 60px;
    }
    
    /* Aside 側邊欄 */
    .tpcd-aside {
      position: fixed;
      top: 0;
      left: 0;
      width: 280px;
      height: 100vh;
      background: linear-gradient(to bottom, #000, #262626);
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 8px rgba(0,0,0,0.2);
      transition: width 0.3s ease;
      overflow: hidden;
    }
    /* 收合狀態 */
    .tpcd-aside.collapsed {
      width: 60px;
      overflow-y: auto;
      overflow-x: hidden;
    }
    
    /* 隱藏 aside 中的滾輪 */
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
      transition: all 0.3s ease;
    }
    .tpcd-aside.collapsed .tpcd-logo {
      width: 40px;
      height: 40px;
      padding-top: 10px;
      margin-bottom: 4px;
    }
    
    /* 標題 */
    #tpcd-title {
      font-size: 30px;
      font-weight: bold;
      color: white;
      margin: 0;
      text-decoration: none;
      font-family: 'Georgia', serif;
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
    
    /* 右側金色漸層線 */
    .tpcd-aside::after {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(180deg, #FFC107, #FF9800, #FFC107, #FF5722);
      background-size: 100% 300%;
      animation: gradientMove 6s ease-in-out infinite;
    }
    @keyframes gradientMove {
      0% { background-position: 0% 0%; }
      50% { background-position: 0% 100%; }
      100% { background-position: 0% 0%; }
    }
    
    /* Aside 頂部：Logo 與標題 */
    .tpcd-aside-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      border-bottom: 1px solid #444;
      transition: opacity 0.3s ease, padding 0.3s ease;
    }
    /* 收合狀態下，隱藏 aside header 中除 Logo 外的所有元素 */
    .tpcd-aside.collapsed .tpcd-aside-header > *:not(.tpcd-logo) {
      opacity: 0;
      pointer-events: none;
      height: 0;
      margin: 0;
      overflow: hidden;
    }
    
    /* Aside 導覽列 */
    .tpcd-nav a .nav-text {
      vertical-align: middle;
      transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .tpcd-aside.collapsed .tpcd-nav a .nav-text {
      opacity: 0;
      transform: translateX(-10px);
    }
    .tpcd-nav a {
      display: block;
      color: #f3f4f6;
      text-decoration: none;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
      white-space: nowrap;
    }
    .tpcd-nav a:hover {
      background-color: #888;
      color: #2c3e50;
    }
    /* 專屬 nav icon */
    .tpcd-nav-icon {
      width: 20px;
      height: 20px;
      vertical-align: middle;
      margin-right: 10px;
    }
    /* 每個連結的文字 */
    .nav-text {
      vertical-align: middle;
    }
    /* 收合時隱藏連結文字 */
    .tpcd-aside.collapsed .tpcd-nav a .nav-text {
      display: none;
    }
    
    .tpcd-nav .tpcd-dropdown:nth-of-type(2) a:hover,
    .tpcd-nav .tpcd-dropdown:nth-of-type(1) a:hover {
      color: initial;
    }
    .tpcd-nav .tpcd-dropdown:nth-of-type(2) a:hover::after,
    .tpcd-nav .tpcd-dropdown:nth-of-type(1) a:hover::after {
      content: "";
      margin: 0;
    }
    
    /* 展開式選單 */
    .tpcd-dropdown {
      position: relative;
    }
    .tpcd-dropdown-content {
      display: none;
      background-color: rgb(50,50,50);
      box-shadow: 0px 4px 8px rgba(0,0,0,0.2);
      border-radius: 5px;
      margin-left: 20px;
    }
    .tpcd-dropdown.expanded .tpcd-dropdown-content {
      display: block;
    }
    .tpcd-dropdown-content a {
      padding: 5px 20px;
      font-size: 16px;
      color: white;
      text-decoration: none;
      display: block;
    }
    .tpcd-dropdown-content a:hover {
      background-color: #888;
      color: #2c3e50;
    }
    
    /* 收合按鈕（手動切換側邊欄展開／收合） */
    #aside-toggle {
      position: fixed;
      top: 0px;
      left: 250px;
      border: none;
      background: none;
      cursor: pointer;
      z-index: 1000;
      padding: 5px 15px;
      margin-left: 30px;
      border-radius: 4px;
      transition: left 0.3s ease;
    }
    #aside-toggle img {
      width: 30px;
      height: 30px;
    }
    body.collapsed-aside #aside-toggle {
      left: 30px;
    }
    
    /* 群組標題 */
    .tpcd-group-title {
      font-size: 16px;
      color: #999;
      padding: 20px 20px 8px;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: bold;
      display: inline-block;
      border-bottom: 2px solid #555;
      margin: 0 0 10px 20px;
      padding-right: 160px;
      transition: all 0.3s ease;
    }
    /* 收合狀態下縮短群組標題底線 */
    .tpcd-aside.collapsed .tpcd-group-title {
      font-size: 0;
      border-bottom: 2px solid #555;
      width: 20px;
      height: 10px;
      margin: 10px auto;
      padding: 0;
      display: block;
    }
    
    /* 自動收合切換（固定/非固定側邊欄）用圖片按鈕 */
    #pin-toggle-container {
      text-align: center;
      padding: 10px;
      margin-top: auto; /* 自動推到最下面 */
    }
    #pin-toggle {
      border: none;
      background: none;
      cursor: pointer;
    }
    #pin-toggle img {
      width: 20px;
      height: 20px;
    }
  </style>
</head>

<body class="no-transition">
  <!-- Aside 側邊欄 -->
  <aside class="tpcd-aside" id="sidebar">
    <!-- Aside 頂部：Logo 與標題 -->
    <div class="tpcd-aside-header">
      <img src="..\Icon file\logo1.svg" alt="TPCD Logo" class="tpcd-logo">
      <a href="..\0_homepage\V1_M_Top_main.php" id="tpcd-title">TPCD</a>
      <span id="tpcd-department">Test Probe Card Department</span>
      <div class="tpcd-current-time" id="current-time"></div>
    </div>
    
    <nav class="tpcd-nav">
      <!-- TYPE1 -->
      <div class="tpcd-group">
        <div class="tpcd-group-title">TYPE1</div>
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
      </div>
      
      <!-- TYPE2 -->
      <div class="tpcd-group">
        <div class="tpcd-group-title">TYPE2</div>
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
      </div>
      
      <!-- TYPE3 -->
      <div class="tpcd-group">
        <div class="tpcd-group-title">TYPE3</div>
        <div class="tpcd-dropdown">
          <a href="#">
            <img src="..\Icon file\Aside\machine.png" alt="P/C Tool status dashboard" class="tpcd-nav-icon">
            <span class="nav-text">P/C Tool status dashboard</span>
          </a>
        </div>
        <div class="tpcd-dropdown">
          <a href="#">
            <img src="..\Icon file\Aside\development.png" alt="Development progress" class="tpcd-nav-icon">
            <span class="nav-text">Development progress</span>
          </a>
          <div class="tpcd-dropdown-content">
            <a href="#">進度總覽</a>
            <a href="#">Bug 修復</a>
            <a href="#">功能開發</a>
          </div>
        </div>
      </div>
    </nav>
    <!-- 自動收合功能的切換：點此按鈕可切換側邊欄是否固定（啟用或停用自動收合） -->
    <div id="pin-toggle-container">
      <button id="pin-toggle" aria-label="Toggle Auto Collapse">
        <img id="pin-toggle-img" src="../icons/pin1.png" alt="Auto Collapse Toggle">
      </button>
    </div>
  </aside>
  
  <!-- 收合/展開按鈕（手動切換側邊欄展開／收合），使用圖片呈現 -->
  <button id="aside-toggle" aria-label="Toggle sidebar">☰</button>
  
  <!-- 主內容區 -->
  
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // 依據 localStorage 設定 aside 初始狀態
      var isCollapsed = localStorage.getItem("asideCollapsed") === "true";
      var sidebar = document.getElementById('sidebar');
      var body = document.body;
      if(isCollapsed) {
        sidebar.classList.add("collapsed");
        body.classList.add("collapsed-aside");
      }
      
      // 若 autoCollapse 尚未設定，預設啟用（true，代表自動收合功能開啟；即側邊欄非固定）
      if(localStorage.getItem("autoCollapse") === null){
        localStorage.setItem("autoCollapse", "true");
      }
      // 載入後短暫延遲後移除 no-transition，以啟用動畫
      setTimeout(function(){
         body.classList.remove("no-transition");
         sidebar.classList.remove("no-transition");
         updateAsideToggleImg();
         updatePinToggleImg();
      }, 50);
      
      // 初始更新按鈕圖片
      updateAsideToggleImg();
      updatePinToggleImg();
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
    
    // 更新手動切換按鈕圖片（側邊欄展開／收合）
    function updateAsideToggleImg() {
      var sidebar = document.getElementById('sidebar');
      var toggleImg = document.getElementById('aside-toggle-img');
      // 當側邊欄收合，顯示 pin2.png，否則顯示 pin1.png
      if (sidebar.classList.contains('collapsed')) {
        toggleImg.src = '../icons/pin2.png';
      } else {
        toggleImg.src = '../icons/pin1.png';
      }
    }
    
    // 更新自動收合設定切換的按鈕圖片
    function updatePinToggleImg() {
      var pinImg = document.getElementById('pin-toggle-img');
      // 讀取 autoCollapse 狀態：若為 true 代表啟用自動收合（側邊欄非固定），顯示 pin1.png；
      // 若為 false 代表停用自動收合（側邊欄固定），顯示 pin2.png
      var autoCollapse = localStorage.getItem("autoCollapse") === "true";
      if (autoCollapse) {
        pinImg.src = '../icons/pin1.png';
      } else {
        pinImg.src = '../icons/pin2.png';
      }
    }
    
    // 切換側邊欄展開／收合（手動控制），並更新 localStorage 與按鈕圖片
    document.getElementById('aside-toggle').addEventListener('click', function() {
      var sidebar = document.getElementById('sidebar');
      var isCollapsed = sidebar.classList.toggle('collapsed');
      document.body.classList.toggle('collapsed-aside');
      localStorage.setItem("asideCollapsed", isCollapsed);
      updateAsideToggleImg();
    });
    
    // 切換自動收合設定（固定／非固定側邊欄）的按鈕，並更新 localStorage 與按鈕圖片
    document.getElementById('pin-toggle').addEventListener('click', function(e) {
      e.stopPropagation(); // 避免觸發其他點擊事件（例如頁面自動收合）
      var current = localStorage.getItem("autoCollapse");
      // 反轉設定：若目前為 "true" 則改為 "false"，反之亦然
      var newValue = current === "true" ? "false" : "true";
      localStorage.setItem("autoCollapse", newValue);
      updatePinToggleImg();
    });
    
    // 點擊頁面其他區域時，若自動收合功能啟用（autoCollapse 為 true），則收合側邊欄
    document.addEventListener('click', function (event) {
      const sidebar = document.getElementById('sidebar');
      const toggleButton = document.getElementById('aside-toggle');
      const autoCollapseEnabled = localStorage.getItem('autoCollapse') === "true";
      if (autoCollapseEnabled && !sidebar.contains(event.target) && event.target !== toggleButton) {
        sidebar.classList.add('collapsed');
        document.body.classList.add('collapsed-aside');
        localStorage.setItem("asideCollapsed", "true");
        updateAsideToggleImg();
      }
    });
  </script>
</body>
</html>
