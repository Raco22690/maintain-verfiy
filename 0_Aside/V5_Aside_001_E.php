<?php
/* ============================
 * 更新码: E001-20241223-011
 * 更新内容: 收合状态图标调整为26px，并增加与缩写文字的间距
 * 更新日期: 2024-12-23
 * ============================ */

/* ====== 讀取訪問紀錄並計算 ====== */
date_default_timezone_set('Asia/Taipei');

// TSSO 權限檢查 (新增)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userInfo = isset($_SESSION['userInfo']) ? $_SESSION['userInfo'] : null;

$visitFile = '../V90 visite tracker/logs/system_visits.json';
$data      = file_exists($visitFile) ? json_decode(file_get_contents($visitFile), true) : [];

$totalVisits = count($data);                  // 系統總拜訪人次
$todayDate   = date('Y-m-d');
$todayVisits = 0;
foreach ($data as $e) {
    if (isset($e['time']) && substr($e['time'], 0, 10) === $todayDate) $todayVisits++;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TPCD_entrance首頁 - Compact Redesign</title>
  <link rel="icon" href="..\Icon file\logo1.svg" type="image/svg+xml">
  <style>
    /* ========================  基本字體  ======================== */
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Noto+Sans+TC:wght@300;400;500;700&display=swap');

    :root{
      --group-title-pad-y: 14px;
      --group-title-font: 10px;
      --nav-padding-y: 9px;
      --nav-padding-x: 22px;
      --nav-margin-y : 2px;
      --nav-font     : 14px;
    }

    /* ========================  主體設定  ======================== */
    body{
      margin:0;
      font-family:'Roboto','Noto Sans TC',Arial,sans-serif;
      color:#333;
      margin-left:280px;
      transition:margin-left .4s cubic-bezier(.25,.8,.25,1);
      overflow-x:hidden;
      position:relative;
    }
    body.collapsed-aside{margin-left:70px;}

    /* 右下浮水印 */
    body::before{
      content:"TPCD Design";
      position:fixed;bottom:20px;right:20px;
      font:700 16px 'Georgia',serif;
      color:rgba(0,0,0,.08);
      transform:rotate(-15deg);
      pointer-events:none;z-index:0;opacity:.7;
    }

    /* ========================  側邊欄  ======================== */
    .tpcd-aside{
      position:fixed;top:0;left:0;width:280px;height:100vh;
      background:linear-gradient(to bottom,#000,#262626);
      display:flex;flex-direction:column;
      box-shadow:3px 0 15px rgba(0,0,0,.25);
      transition:width .4s cubic-bezier(.25,.8,.25,1);
      overflow-y:auto;overflow-x:hidden;z-index:1000;
    }
    .tpcd-aside.collapsed{width:70px;}

    .tpcd-aside::-webkit-scrollbar{width:6px;}
    .tpcd-aside::-webkit-scrollbar-track{background:rgba(255,255,255,.08);}
    .tpcd-aside::-webkit-scrollbar-thumb{background:rgba(255,255,255,.2);border-radius:3px;}
    .tpcd-aside::-webkit-scrollbar-thumb:hover{background:rgba(255,255,255,.3);}

    /* ===== Aside 頂部 ===== */
    .tpcd-aside-header{
      display:flex;flex-direction:column;align-items:center;text-align:center;
      padding:20px 15px;
      border-bottom:1px solid #444;
      transition:padding .4s ease,opacity .3s ease;
    }
    .tpcd-logo{width:48px;height:48px;margin-bottom:8px;border-radius:50%;transition:width .3s,height .3s;}
    .tpcd-aside.collapsed .tpcd-logo{width:40px;height:40px;margin-bottom:0;padding:4px;}

    #tpcd-title{
      font:700 28px 'Georgia',serif;
      color:#fff;margin:0;text-decoration:none;letter-spacing:.5px;
      transition:opacity .3s .1s,transform .3s .1s;
    }
    #tpcd-department{
      font-size:10px;color:#ccc;font-style:italic;letter-spacing:1px;text-transform:uppercase;padding-top:2px;
      transition:opacity .3s,transform .3s;
    }
    .tpcd-current-time{margin-top:10px;font-size:15px;color:#d4d4d8;font-weight:400;}

    .tpcd-aside.collapsed .tpcd-aside-header>*:not(.tpcd-logo){opacity:0;height:0;margin:0!important;padding:0!important;overflow:hidden;}

    /* User Profile section - Redesigned for Alignment (新增) */
    .tpcd-user-profile {
      margin: 15px;
      padding: 3px 12px;
      background: linear-gradient(180deg, #272727ff, #3f3f3fff);
      border-radius: 25px;
      /* border: 1.5px solid rgba(170, 122, 0, 0.83); */
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: all .3s ease;
      min-height: 36px;
    }
    .tpcd-user-profile .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
      transition: gap .3s ease;
    }
    .tpcd-user-profile .user-icon {
      width: 24px;
      height: 24px;
      flex-shrink: 0;
    }
    .tpcd-user-profile .user-text {
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 4px;
      color: #e0e0e0;
    }
    .tpcd-user-profile .user-text .label {
      color: #a0a0a0;
    }
    .tpcd-user-profile .user-text .value {
      color: #fff;
      font-weight: 500;
    }
    .tpcd-user-profile .login-options {
      margin: 0; padding: 0; border: none;
    }
    .tpcd-user-profile .auth-link {
      background: #5c5c5cff;
      color: #343434ff;
      font-size: 12px;
      font-weight: 700;
      padding: 0.5px 14px;
      border-radius: 20px;
      text-decoration: none;
      white-space: nowrap;
      transition: background-color .2s ease;
      display: inline-flex;
      align-items: center;
      height: 28px;
      line-height: 1;
    }
    .tpcd-user-profile .auth-link:hover {
      background: #e0e0e0;
      color: #000;
    }
    .tpcd-aside.collapsed .tpcd-user-profile {
      width: 44px;
      height: 44px;
      padding: 0;
      margin: 15px auto;
      border-radius: 50%;
      justify-content: center;
    }
    .tpcd-aside.collapsed .user-info {
      gap: 0;
    }
    .tpcd-aside.collapsed .user-text,
    .tpcd-aside.collapsed .login-options {
      display: none;
    }

    /* ===== 金色漸層邊框 ===== */
    .tpcd-aside::after{
      content:'';position:absolute;top:0;right:0;width:5px;height:100%;
      background:linear-gradient(180deg,#FFC107,#FF9800,#FFC107,#FF5722);
      background-size:100% 300%;animation:gradientMove 6s ease-in-out infinite;
    }
    @keyframes gradientMove{0%{background-position:0 0;}50%{background-position:0 100%;}100%{background-position:0 0;}}

    /* ========================  導覽列  ======================== */
    .tpcd-nav{padding-top:8px;flex-grow:1;}

    .tpcd-nav a{
      display:flex;align-items:center;
      color:#f0f0f0;text-decoration:none;
      padding:var(--nav-padding-y) var(--nav-padding-x);
      font-size:var(--nav-font);
      border-radius:8px;
      margin:var(--nav-margin-y) 8px;
      transition:all .4s cubic-bezier(.25,.8,.25,1);
      white-space:nowrap;position:relative;overflow:hidden;
    }
    .tpcd-nav a:hover{
      background:rgba(255,255,255,.15);
      color:#fff;
      padding-left:calc(var(--nav-padding-x) + 4px);
      transform:translateX(2px);
    }
    .tpcd-nav a.active{background:rgba(255,193,7,.20);color:#FFC107;font-weight:500;}
    .tpcd-nav a.active::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:3px;height:70%;background:#FFC107;border-radius:0 2px 2px 0;}

    .tpcd-nav-icon{width:19px;height:19px;margin-right:12px;filter:grayscale(30%) opacity(.9);transition:all .4s cubic-bezier(.25,.8,.25,1);}
    .tpcd-nav a:hover .tpcd-nav-icon{transform:scale(1.15);filter:none;}

    .tpcd-aside.collapsed .tpcd-nav a{
      padding:8px 6px 6px 6px;
      justify-content:center;
      flex-direction:column;
      align-items:center;
      min-height:45px;
      transition:all .4s cubic-bezier(.25,.8,.25,1);
    }
    .tpcd-aside.collapsed .tpcd-nav a:hover{
      background:rgba(255,255,255,.18);
      transform:translateY(-1px);
      padding-left:6px;
    }
    .tpcd-aside.collapsed .tpcd-nav a .nav-text{
      opacity:1;
      transform:translateX(0);
      width:auto;
      pointer-events:auto;
      display:block;
      font-size:0; /* 强制隐藏原始文字 */
      text-align:center;
      line-height:1.1;
      margin-top:2px;
      max-width:50px;
      word-break:break-all;
      overflow:hidden;
      text-overflow:ellipsis;
      white-space:normal;
      height:auto;
      max-height:20px;
    }
    
    /* 收合状态下显示缩写 */
    .tpcd-aside.collapsed .nav-text::before {
      content: attr(data-short);
      font-size: 7px; /* 确保缩写文字可见 */
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    
    .tpcd-aside.collapsed .nav-text {
      /* 此处不再需要重复设置 font-size: 0; */
    }
    
    .tpcd-aside.collapsed .nav-text::before {
      /* 此处不再需要重复设置样式 */
    }

    .tpcd-aside.collapsed .tpcd-nav-icon{
      margin-right:0;
      width:26px;
      height:26px;
      margin-bottom:4px;
    }
    .tpcd-aside.collapsed .tpcd-nav a:hover .tpcd-nav-icon{
      transform:scale(1.3);
      filter:none;
    }

    /* ========================  Dropdown  ======================== */
    .tpcd-dropdown{position:relative;}
    .tpcd-dropdown>.tpcd-dropdown-toggle::after{
      content:'›';position:absolute;right:16px;top:50%;transform:translateY(-50%) rotate(0);
      font-size:18px;color:#bbb;transition:transform .3s;
    }
    .tpcd-dropdown.expanded>.tpcd-dropdown-toggle::after{transform:translateY(-50%) rotate(90deg);}
    .tpcd-aside.collapsed .tpcd-dropdown>.tpcd-dropdown-toggle::after{display:none;}
    
    /* 收合状态下的下拉菜单按钮样式调整 */
    .tpcd-aside.collapsed .tpcd-dropdown>.tpcd-dropdown-toggle{
      padding:8px 6px 6px 6px;
      flex-direction:column;
      align-items:center;
      min-height:45px;
    }

    .tpcd-dropdown-content{
      display:none;background:#323232;border-radius:4px;margin:4px 8px 4px 34px;
      overflow:hidden;max-height:0;opacity:0;transition:max-height .4s ease-out,padding .4s ease-out,opacity .3s ease-out;
    }
    .tpcd-dropdown.expanded .tpcd-dropdown-content{display:block;max-height:480px;opacity:1;padding:4px 0;}
    .tpcd-dropdown-content a{padding:6px 18px;font-size:13px;color:#e0e0e0;display:block;margin:2px 0;}
    .tpcd-dropdown-content a:hover{background:rgba(255,255,255,.2);color:#fff;}
    .tpcd-aside.collapsed .tpcd-dropdown-content{display:none!important;max-height:0;opacity:0;}

    /* ========================  群組標題  ======================== */
    .tpcd-group-title{
      font-size:var(--group-title-font);
      color:#999;text-transform:uppercase;
      letter-spacing:1.2px;font-weight:500;
      padding:var(--group-title-pad-y) var(--nav-padding-x) 4px;
      margin:6px 0 2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
      border-bottom:1px solid rgba(255,255,255,.06);
    }
    .tpcd-aside.collapsed .tpcd-group-title{font-size:0;opacity:0;padding:0;height:0;margin:0;border:none;}
    
    /* 收合状态下的群组分隔线 */
    .tpcd-aside.collapsed .tpcd-group:not(:first-child)::before{
      content:'';
      display:block;
      width:40px;
      height:1px;
      background:rgba(255,255,255,.15);
      margin:8px auto 6px auto;
    }

    /* ========================  訪問統計 (新增)  ======================== */
    .tpcd-visit-stats{
      padding:12px var(--nav-padding-x);
      border-top:1px solid #444;
      font-size:12px;
      line-height:1.4;
      color:#FFC107;
      background:rgba(255,255,255,.03);
    }
    .tpcd-visit-stats span.label{color:#bbb;margin-right:4px;}
    .tpcd-aside.collapsed .tpcd-visit-stats{font-size:0;opacity:0;height:0;padding:0;border:none;}

    /* ========================  pin & toggle  ======================== */
    #toggle-container{
      position:fixed;top:14px;left:280px;margin-left:6px;z-index:1050;
      background:rgba(255, 255, 255, 0.2);
      border-radius:0 8px 8px 0;
      box-shadow:1px 0 6px rgba(0,0,0,0.1);
      backdrop-filter:blur(10px);
      -webkit-backdrop-filter:blur(10px);
      transition:left .4s cubic-bezier(.25,.8,.25,1), background .3s, transform .3s;
      display:flex;
      flex-direction:column;
      border:1px solid rgba(255, 255, 255, 0.3);
    }
    #toggle-container:hover{
      background:rgba(255, 255, 255, 0.25);
      transform:translateX(2px);
    }
    body.collapsed-aside #toggle-container{left:70px;}

    #aside-toggle{
      border:none;cursor:pointer;z-index:1051;
      background:transparent;color:#666;
      font-size:18px;line-height:1;
      padding:5px 7px;
      transition:background .3s, color .3s;
      border-radius:0 8px 0 0;
    }
    #aside-toggle:hover{background:rgba(200,200,200,0.2); color:#444;}
    #aside-toggle::before{content:'‹';display:inline-block;transition:transform .3s;}
    body.collapsed-aside #aside-toggle::before{content:'›';}

    #pin-toggle{
      border:none;cursor:pointer;z-index:1051;
      background:transparent;color:#666;
      padding:4px 7px;
      transition:background .3s, color .3s;
      border-radius:0 0 8px 0;
      border-top:1px solid rgba(180, 180, 180, 0.3);
    }
    #pin-toggle:hover{background:rgba(200,200,200,0.2); color:#444;}
    #pin-toggle img{width:16px;height:16px;filter:grayscale(40%) opacity(.7);transition:transform .3s,filter .3s;}
    #pin-toggle:hover img{transform:scale(1.1);filter:grayscale(20%) opacity(.9);}
  </style>
</head>
<body class="no-transition">
  <!-- ===== Aside ===== -->
  <aside class="tpcd-aside" id="sidebar">
    <div class="tpcd-aside-header">
      <img src="..\Icon file\logo1.svg" alt="TPCD Logo" class="tpcd-logo">
      <a href="..\0_homepage\V1_M_Top_main.php" id="tpcd-title">TPCD</a>
      <span id="tpcd-department">Test Probe Card Department</span>
      <div class="tpcd-current-time" id="current-time"></div>
    </div>

    <!-- User Profile Section (新增) -->
    <div class="tpcd-user-profile">
        <div class="user-info">
          <img src="../Icon file/Aside/user.png" class="user-icon" alt="User">
          <div class="user-text">
            <span class="label">Hi,</span>
            <span class="value"><?= htmlspecialchars($userInfo['name'] ?? 'Guest') ?></span>
          </div>
        </div>
        
        <div class="login-options">
          <?php if ($userInfo): ?>
            <a href="../V90_SSO/V90_SSO_logout.php" class="auth-link">登出</a>
          <?php else: ?>
            <a href="../V90_SSO/V90_SSO_login.php" class="auth-link">登入</a>
          <?php endif; ?>
        </div>
    </div>

    <!-- ===== Nav ===== -->
    <nav class="tpcd-nav">
      <div class="tpcd-group">
        <div class="tpcd-group-title">SYSTEM</div>
        <div class="tpcd-dropdown"><a href="..\V50_homepage\V50_homepage D.php"><img src="..\Icon file\Aside\Home.png" class="tpcd-nav-icon" alt="首頁"><span class="nav-text" data-short="HOME">首頁</span></a></div>
        <div class="tpcd-dropdown"><a href="..\V51_deviceonwerlist\V5_M_deviceownerlist D.php"><img src="..\Icon file\Aside\owner.png" class="tpcd-nav-icon" alt="Device owner"><span class="nav-text" data-short="OWNER">Device owner control table</span></a></div>
      </div>

      <div class="tpcd-group">
        <div class="tpcd-group-title">DEVICE</div>
        <div class="tpcd-dropdown"><a href="#"><img src="..\Icon file\Aside\tester.png" class="tpcd-nav-icon" alt="Validation"><span class="nav-text" data-short="VALID">Validation tool control table</span></a></div>
        <div class="tpcd-dropdown"><a href="#"><img src="..\Icon file\Aside\ateam.png" class="tpcd-nav-icon" alt="A-team"><span class="nav-text" data-short="A-TEAM">PCR A-team booking</span></a></div>
      </div>

      <div class="tpcd-group">
        <div class="tpcd-group-title">P/C Tool</div>
        <div class="tpcd-dropdown"><a href="#"><img src="..\Icon file\Aside\machine.png" class="tpcd-nav-icon" alt="Dashboard"><span class="nav-text" data-short="DASH">P/C Tool status dashboard</span></a></div>
        <div class="tpcd-dropdown"><a href="#"><img src="..\Icon file\Aside\machine.png" class="tpcd-nav-icon" alt="Feedback"><span class="nav-text" data-short="FEED">PCR Feedback system</span></a></div>
      </div>

      <div class="tpcd-group">
        <div class="tpcd-group-title">Other</div>
        <div class="tpcd-dropdown"><a href="#"><img src="..\Icon file\Aside\tester.png" class="tpcd-nav-icon" alt="Duty"><span class="nav-text" data-short="DUTY">值班名單&值班交換系統</span></a></div>
      </div>

      <div class="tpcd-group">
        <div class="tpcd-group-title">UNDER DEVELOPMENT</div>
        <div class="tpcd-dropdown" id="development-dropdown">
          <a href="#" class="tpcd-dropdown-toggle"><img src="..\Icon file\Aside\development.png" class="tpcd-nav-icon" alt="Dev"><span class="nav-text" data-short="DEV">Development progress</span></a>
          <div class="tpcd-dropdown-content"><a href="#">進度總覽</a><a href="#">Bug 修復</a><a href="#">功能開發</a></div>
        </div>
      </div>
    </nav>

    <!-- ===== 訪問統計區 (新增) ===== -->
    <div class="tpcd-visit-stats">
      <!-- <div><span class="label">總拜訪人次：</span><span class="value"><?= $totalVisits ?></span></div>
      <div><span class="label">今日人次：</span><span class="value"><?= $todayVisits ?></span></div> -->

      <!-- <div><span class="label"></span><span class="value"><?= $totalVisits ?>/<?= $todayVisits ?></span></div> -->
    </div>
  </aside>

  <div id="toggle-container">
    <button id="aside-toggle" aria-label="Toggle sidebar"></button>
    <button id="pin-toggle" aria-label="Toggle Auto Collapse"><img id="pin-toggle-img" src="../icons/pin1.png" alt="Auto Collapse Toggle"></button>
  </div>

  <!-- ========================  Script  ======================== -->
  <script>
    document.addEventListener('DOMContentLoaded',()=>{
      const sidebar=document.getElementById('sidebar');
      const body=document.body;
      const asideToggleBtn=document.getElementById('aside-toggle');
      const pinToggleBtn=document.getElementById('pin-toggle');
      const pinToggleImg=document.getElementById('pin-toggle-img');
      let isCollapsed=localStorage.getItem('asideCollapsed')==='true';
      if(isCollapsed){sidebar.classList.add('collapsed');body.classList.add('collapsed-aside');}
      if(localStorage.getItem('autoCollapse')===null){localStorage.setItem('autoCollapse','true');}
      setTimeout(()=>{body.classList.remove('no-transition');sidebar.classList.remove('no-transition');updatePinToggleImg();},50);

      /* 時間顯示 */
      const weekNum=d=>{d=new Date(Date.UTC(d.getFullYear(),d.getMonth(),d.getDate()));d.setUTCDate(d.getUTCDate()-d.getUTCDay());const ys=new Date(Date.UTC(d.getUTCFullYear(),0,1));return Math.ceil(((d-ys)/864e5+1)/7);}  
      const updateTime=()=>{
        const now=new Date();const y=now.getFullYear();const wd=String(y).slice(-1)+String(weekNum(now)).padStart(2,'0');
        const day=['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][now.getDay()]+'.';
        const str=`W${wd} ${day} ${y}/${String(now.getMonth()+1).padStart(2,'0')}/${String(now.getDate()).padStart(2,'0')} ${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}`;
        document.getElementById('current-time').textContent=str;
      };
      updateTime();setInterval(updateTime,6e4);

      /* pin 圖示切換 */
      function updatePinToggleImg(){const auto=localStorage.getItem('autoCollapse')==='true';pinToggleImg.src=auto?'../icons/pin1.png':'../icons/pin2.png';pinToggleImg.alt=auto?'Auto collapse enabled (Unpinned)':'Auto collapse disabled (Pinned)';}

      /* toggle aside */
      asideToggleBtn.addEventListener('click',()=>{isCollapsed=sidebar.classList.toggle('collapsed');body.classList.toggle('collapsed-aside');localStorage.setItem('asideCollapsed',isCollapsed);} );

      /* pin 按鈕 */
      pinToggleBtn.addEventListener('click',e=>{e.stopPropagation();const cur=localStorage.getItem('autoCollapse');localStorage.setItem('autoCollapse',cur==='true'?'false':'true');updatePinToggleImg();});

      /* auto collapse on body click */
      document.addEventListener('click',e=>{const auto=localStorage.getItem('autoCollapse')==='true';if(auto&&!isCollapsed&&!sidebar.contains(e.target)&&!asideToggleBtn.contains(e.target)){sidebar.classList.add('collapsed');body.classList.add('collapsed-aside');localStorage.setItem('asideCollapsed','true');isCollapsed=true;}});

      /* dropdowns */
      document.querySelectorAll('.tpcd-dropdown .tpcd-dropdown-toggle').forEach(t=>t.addEventListener('click',e=>{e.preventDefault();const parent=t.closest('.tpcd-dropdown');if(sidebar.classList.contains('collapsed')){sidebar.classList.remove('collapsed');body.classList.remove('collapsed-aside');localStorage.setItem('asideCollapsed','false');isCollapsed=false;setTimeout(()=>parent.classList.toggle('expanded'),100);}else parent.classList.toggle('expanded');}));

      /* active link highlight */
      document.querySelectorAll('.tpcd-nav a:not(.tpcd-dropdown-toggle)').forEach(l=>l.addEventListener('click',()=>{document.querySelectorAll('.tpcd-nav a.active').forEach(a=>a.classList.remove('active'));l.classList.add('active');}));
      const currentPath=window.location.pathname.split('/').pop();
      document.querySelectorAll('.tpcd-nav a').forEach(nav=>{const href=nav.getAttribute('href');if(href&&href.split('/').pop()===currentPath&&currentPath!==''){nav.classList.add('active');const dc=nav.closest('.tpcd-dropdown-content');if(dc)dc.closest('.tpcd-dropdown').classList.add('expanded');}});
    });
  </script>
</body>
</html>
