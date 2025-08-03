<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>Device information center</title>
    <link rel="icon" href="..\Icon file\logo1.svg" type="image/svg+xml">
    <style>
        /* --- 基本樣式 --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }

        /* --- Tab Bar 樣式 --- */
        .tab-bar {
            background: #1a237e;
            padding: 15px 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            margin-bottom: 20px;
            box-shadow: none;
        }

        .tab-container {
            display: flex;
            gap: 10px;
            max-width: 1200px;
            margin: 0;
            justify-content: flex-start;
            position: relative;
            margin-top: -160px;
        }

        .tab-button {
            padding: 10px 20px;
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
            background: transparent;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: none;
            text-decoration: none;
        }

        .tab-button:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }

        .tab-button.active {
            color: #fff;
            font-weight: 600;
        }

        .tab-button::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #FFA000;
            border-radius: 3px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tab-button:hover::after {
            transform: scaleX(0.3);
        }

        .tab-button.active::after {
            transform: scaleX(1);
        }

        /* 更新：標題欄位樣式 */
        .page-title-bar {
            background: rgba(128, 128, 128, 0.5);
            padding: 10px 40px;
            margin-top: -140px;
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .page-title {
            font-size: 26px;
            color: #ffffff;
            font-weight: 600;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        #currentPageTitle {
            position: relative;
            display: inline-block;
        }

        .main-container {
            max-width: 95%;
            margin: 20px auto;
            padding: 0;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            border-radius: 12px;
            overflow: hidden;
        }

        header h1 {
            text-align: left;
            font-size: 32px;
            margin: 0 0 10px 0;
            padding-bottom: 5px;
            padding-right: -20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        }

        .header-bg {
            background: url('../V65_Maintian verify/BG6.png') no-repeat center 98% / cover;
            padding: 60px 40px 320px 40px;
            margin-bottom: -150px;
            color: #fff;
            width: 100%;
            position: relative;
        }
    </style>
</head>
<body>
<?php 
    // Determine the current page to set the active tab
    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<main class="main-container">
    <header class="block1 header-bg">
        <h1>Device information center</h1>
    </header>

    <div class="tab-bar">
        <div class="tab-container">
            <a class="tab-button <?php echo ($currentPage == 'V67_Maintian BKM.php') ? 'active' : ''; ?>" href="../V65_Maintian BKM/V67_Maintian BKM.php">Device Maintain BKM</a>
            <a class="tab-button <?php echo ($currentPage == 'V67_Maintian verify A2.php') ? 'active' : ''; ?>" href="../V65_Maintian verify/V67_Maintian verify A2.php">Device Verify information</a>
            <a class="tab-button" href="#">Wafer control table</a>
        </div>
    </div>
