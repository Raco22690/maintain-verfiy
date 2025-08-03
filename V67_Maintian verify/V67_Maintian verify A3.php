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
            background: url('BG6.png') no-repeat center 98% / cover;
            padding: 60px 40px 320px 40px;
            margin-bottom: -150px;
            color: #fff;
            width: 100%;
            position: relative;
        }

        /* --- 標籤頁內容樣式 --- */
        .tab-content {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.35s cubic-bezier(0.4,0,0.2,1), transform 0.35s cubic-bezier(0.4,0,0.2,1);
            width: 100%;
        }

        .tab-content.active {
            display: flex;
            flex-direction: row;
            gap: 15px;
            align-items: flex-start;
            opacity: 1;
            transform: translateY(0);
            width: 100%;
        }

        .tab-content.fading {
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
        }

        /* 空白區域樣式 */
        .blank-area {
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
            height: calc(100vh - 250px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 16px;
            width: 100%;
        }

        /* Toast 提示樣式 */
        .toast {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(76, 175, 80, 0.95);
            color: #fff;
            padding: 12px 24px;
            border-radius: 6mm;
            box-shadow: 0 3px 9px rgba(0, 0, 0, .2);
            opacity: 0;
            pointer-events: none;
            z-index: 99999;
            transition: opacity .4s ease;
            font-size: 14px;
            text-align: center;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .toast.show {
            opacity: 1;
            animation: toastFadeIn 0.3s ease;
        }

        @keyframes toastFadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -40%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        /* BKM內容模組樣式 */
        .bkm-module {
            background: rgba(255,255,255,1);
            border-radius: 10px;
            box-shadow: 0 4px 18px rgba(26,35,126,0.10), 0 1.5px 6px rgba(0,0,0,0.08);
            padding: 24px 32px 24px 32px;
            width: 90%;
            margin: 0 auto 32px auto;
        }
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            gap: 10px;
            background: #F5F5F5;
            border-radius: 6px;
            padding: 10px 18px;
            flex-wrap: wrap;
        }
        .bkm-action-btn {
            background: rgb(55, 55, 55);
            color: #FAFAFA;
            border: none;
            border-radius: 6px;
            padding: 7px 22px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .bkm-action-btn:hover {
            background: #888;
            color: #fff;
        }
        .bkm-table-title {
            font-size: 22px;
            color: #FAFAFA;
            background:rgb(55, 55, 55);
            font-weight: 700;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0;
            border-radius: 6px 6px 0 0;
            height: 48px;
            position: relative;
            padding-top: 7px;
            padding-bottom: 7px;
        }
         .bkm-title-icon {
            color:rgb(255, 187, 0);
            font-size: 26px;
            margin-right: 6px;
        }
        .bkm-table-wrapper {
            overflow-x: auto;
        }
        .bkm-table {
            width: 100%;
            border-collapse: collapse;
            background: #888;
            overflow: hidden;
            font-size: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .bkm-table th {
			background: #666;
			color: #FAFAFA;
			font-weight: 700;
			padding: 12px 8px;
			text-align: center;
			font-size: 15px;
			border-right: 1px solid #aaa;
			border-bottom: 2px solid rgb(229, 154, 24); /* 新增這行 */
			border-radius: 0 !important;
		}


        .bkm-table th:last-child {
            border-right: none;
        }
        .bkm-table td {
            background: #f8f9fa;
            color: #333;
            padding: 8px 8px;
            border-bottom: 1px solid #e0e0e0;
            border-right: 1px solid #eee;
            word-break: break-all;
            text-align: center;
            line-height: 1.2;
            font-size: 16px;
        }
        .bkm-table td:last-child {
            border-right: none;
        }
        .bkm-table tr:last-child td {
            border-bottom: none;
        }
        .bkm-table td.desc-col {
            text-align: left;
        }

        /* --- 修改: 統一 Modal 過渡動畫 --- */
        .modal {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.3s ease, background-color 0.3s ease, visibility 0s 0.3s;
        }
        .modal.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            background-color: rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease, background-color 0.3s ease, visibility 0s 0s;
        }
        .modal-content {
            background-color: #fafafa;
            padding: 30px 40px;
            border-radius: 8px;
            width: 90%;
            max-width: 990px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
            border: 1px solid #e0e0e0;
            /* 動畫效果 */
            transform: scale(0.95);
            opacity: 0;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .modal.show .modal-content {
            transform: scale(1);
            opacity: 1;
        }
        .close {
            position: absolute;
            right: 20px;
            top: 10px;
            color: #888;
            font-size: 28px;
            font-weight: normal;
            cursor: pointer;
            transition: color 0.2s;
        }
        .close:hover {
            color: #333;
        }
        .modal-banner {
            background: url('BG6.png') no-repeat center 90% / 120% 150%;
            color: #fff;
            border-bottom: 1px solid #fff;
            padding: 30px 25px;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 6px;
            text-align: center;
            margin: -20px -30px 25px -30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .modal-banner .bkm-title-icon {
            color: #FFA000;
            font-size: 1.5rem;
            margin-right: 6px;
        }
        .modal-content h2 {
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 25px;
            color: #333;
            font-size: 1.4rem;
            font-weight: 500;
        }
        .form-group {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 15px;
        }
        .form-group label {
            width: 150px;
            font-weight: 500;
            text-align: right;
            margin-right: 10px;
            font-size: 14px;
            color: #555;
            padding-top: 10px;
        }
        .form-group label span {
            color: #e53935;
            margin-right: 3px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            flex-grow: 1;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 70%;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #546E7A;
            box-shadow: 0 0 0 2px rgba(55, 71, 79, 0.2);
            outline: none;
        }
        .form-group textarea {
            min-height: 100px;
            max-height: 300px;
            resize: vertical;
        }
        .form-group textarea:focus {
            border-color: #546E7A;
            box-shadow: 0 0 0 2px rgba(55, 71, 79, 0.2);
            outline: none;
        }
        /* Action menu 樣式 */
        .action-menu-wrap {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .action-menu-btn {
            background: none;
            border: none;
            font-size: 22px;
            color: #757575;
            cursor: pointer;
              padding: 4px 18px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .action-menu-btn:hover {
        
            padding: 4px 18px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); 
        }
        .action-menu-list-global {
            display: none;
            position: fixed;
            min-width: 110px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            z-index: 9999;
            padding: 4px 0;
            flex-direction: column;
            transition: opacity 0.15s;
        }
        .action-menu-list-global.show {
            display: flex;
            opacity: 1;
        }
        .action-menu-list-global button {
            width: 100%;
            background: none;
            border: none;
            color: #333;
            font-size: 15px;
            padding: 8px 16px;
            text-align: left;
            cursor: pointer;
            transition: background 0.2s;
        }
        .action-menu-list-global button:hover {
            background: #f5f5f5;
            color: #FFA000;
        }

        /* 刪除確認 modal 樣式 */
        #deleteModal {
            /* 樣式已由通用的 .modal class 接管 */
            z-index: 10001;
        }
        #deleteModal .modal-content {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.18);
            padding: 32px 36px 24px 36px;
            max-width: 350px;
            width: 90%;
            text-align: center;
            position: relative;
            border: 1px solid #e0e0e0;
        }
        #deleteModal .modal-content h3 {
            color: #d84315;
            font-size: 1.2rem;
            margin-bottom: 18px;
            font-weight: 600;
        }
        #deleteModal .modal-content p {
            color: #333;
            margin-bottom: 24px;
        }
        #deleteModal .modal-actions {
            display: flex;
            justify-content: center;
            gap: 18px;
        }
        #deleteModal .modal-actions button {
            min-width: 80px;
            padding: 7px 0;
            border-radius: 6px;
            border: none;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        #deleteModal .btn-cancel {
            background: #eee;
            color: #333;
        }
        #deleteModal .btn-cancel:hover {
            background: #ccc;
        }
        #deleteModal .btn-confirm {
            background: #FFA000;
            color: #fff;
        }
        #deleteModal .btn-confirm:hover {
            background: #ffb733;
        }

        .bkm-table th:nth-child(1), .bkm-table td:nth-child(1) { width: 5%; min-width: 5px; }
        .bkm-table th:nth-child(2),  .bkm-table td:nth-child(2)  { width: 3%; min-width: 3px; }
.bkm-table th:nth-child(3),  .bkm-table td:nth-child(3)  { width: 5%; min-width: 10px; }
.bkm-table th:nth-child(4),  .bkm-table td:nth-child(4)  { width: 8%; min-width: 10px; }
.bkm-table th:nth-child(5),  .bkm-table td:nth-child(5)  { width: 3%; min-width: 10px; }
.bkm-table th:nth-child(6),  .bkm-table td:nth-child(6)  { width: 32%; min-width: 10px; }
.bkm-table th:nth-child(7),  .bkm-table td:nth-child(7)  { width: 3%; min-width: 10px; }
.bkm-table th:nth-child(8),  .bkm-table td:nth-child(8)  { width: 5%; min-width: 10px; }
.bkm-table th:nth-child(9),  .bkm-table td:nth-child(9)  { width: 5%; min-width: 10px; }
.bkm-table th:nth-child(10), .bkm-table td:nth-child(10) { width: 8%; min-width: 10px; }
.bkm-table th:nth-child(11), .bkm-table td:nth-child(11) { width: 3%; min-width: 10px; }


        /* BKM table 列間隔條紋效果（兩種不同淺灰） */
        .bkm-table tbody tr:nth-child(even) td {
            background:rgb(249, 249, 249);
        }
        .bkm-table tbody tr:nth-child(odd) td {
            background:rgb(246, 246, 246);
        }

        .bkm-table tbody tr:hover td {
            background:rgb(220, 230, 237);
            cursor: pointer;
        }

        /* Search欄優化 */
        .bkm-search-group {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 220px;
            max-width: 350px;
        }

        .bkm-search-input {
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 15px;
            min-width: 240px;
            background: #fff;
            outline: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }

        .bkm-search-input:focus {
            border-color: rgb(57, 57, 57);
            box-shadow: 0 2px 5px rgba(26, 35, 126, 0.1);
        }

        .bkm-search-btn {
            background: rgb(55, 55, 55);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 20px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .bkm-search-btn:hover {
            background: rgb(161, 161, 161);
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(0,0,0,0.15);
        }

        .bkm-clean-btn {
            background: rgb(86, 85, 85);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 20px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .bkm-clean-btn:hover {
            background: rgb(161, 161, 161);
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(0,0,0,0.15);
        }

        @media (max-width: 700px) {
            .action-bar { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 12px; 
            }
            .bkm-search-group {
                flex-direction: column;
                width: 100%;
                max-width: none;
            }
            .bkm-search-input {
                width: 100%;
                min-width: 0;
            }
            .bkm-search-btn {
                width: 100%;
            }
        }

        /* --- 附件預覽 Modal --- */
        #attachmentPreviewModal {
            z-index: 10003;
        }
        .attachment-modal-close {
            position: absolute;
            right: 0;
            top: 0;

            color: #fff;
            font-size: 28px;
            width: 36px;
            height: 36px;
            line-height: 36px;
            border-radius: 0 8px 0 8px;
            z-index: 10;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
        }
        .attachment-modal-close:hover {

            color: #fff;
        }
        .bkm-announcement {
            background: linear-gradient(90deg, #FFA000 0%, #FFD54F 100%);
            color: #fff;
            border-radius: 8px;
            padding: 12px 24px;
            margin-bottom: 16px;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(255, 160, 0, 0.08);
            letter-spacing: 0.5px;
        }
        .bkm-announcement .icon {
            font-size: 22px;
            margin-right: 6px;
            color: #fffbe7;
        }
        /* 資料檢視 modal 樣式 */
        #viewDataModal {
            /* 樣式已由通用的 .modal class 接管 */
            z-index: 1000;
        }
        #viewDataModal .modal-content {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            padding: 0;
            max-width: 990px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            overflow-x: hidden;
            position: relative;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
        }
        #viewDataModal .modal-content::-webkit-scrollbar {
            width: 6px;
        }
        #viewDataModal .modal-content::-webkit-scrollbar-track {
            background: transparent;
        }
        #viewDataModal .modal-content::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }
        #viewDataModal .modal-content::-webkit-scrollbar-thumb:hover {
            background-color: rgba(0, 0, 0, 0.3);
        }
        #viewDataModal .modal-banner {
            background: url('BG6.png') no-repeat center 90% / 120% 150%;
            color: #fff;
            border-bottom: 1px solid #fff;
            padding: 30px 50px;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 12px 12px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            min-height: 80px;
            box-sizing: border-box;
            margin: 10px;
        }
        #viewDataModal .modal-body {
            padding: 30px 40px;
            margin: 0 10px;
            scrollbar-gutter: stable;
        }
        #viewDataModal .data-row {
            display: flex;
            margin-bottom: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
            flex-wrap: wrap;
            gap: 8px;
        }
        #viewDataModal .data-label {
            width: 150px;
            min-width: 150px;
            font-weight: 500;
            color: #666;
            padding-top: 4px;
        }
        #viewDataModal .data-value {
            flex: 1;
            color: #333;
            white-space: pre-line;
            word-break: break-word;
            padding-top: 4px;
            line-height: 1.2;
        }
        #viewDataModal .attachment-preview {
            margin-top: 15px;
            text-align: center;
        }
        #viewDataModal .attachment-preview img {
            max-width: 100%;
            max-height: 350px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        #viewDataModal .attachment-preview .pdf-icon {
            display: inline-block;
            padding: 40px;
            background: #f5f5f5;
            border-radius: 8px;
            color: #666;
            font-size: 24px;
            cursor: pointer;
        }
        /* 修改: 提高關閉按鈕 z-index */
        #viewDataModal .close {
            position: absolute;
            right: 10px;
            top: 20px;
            transform: translateY(-50%);
            color: #888;
            font-size: 28px;
            font-weight: normal;
            cursor: pointer;
            transition: color 0.2s;
            background-color: transparent;
            border: none;
            padding: 0;
            line-height: 1;
        }
        #viewDataModal .close:hover {
            color: #fff;
            transform: translateY(-50%) rotate(90deg);
        }

        #viewDataModal .modal-banner .banner-subtitle,
        #bkmModal .modal-banner .banner-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.4;
            margin-top: 8px;
            color: #fff;
            position: relative;
            padding-top: 16px;
        }

        #viewDataModal .modal-banner .banner-subtitle::before,
        #bkmModal .modal-banner .banner-subtitle::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 2px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 1px;
            
        }

        .status-tag {
            display: inline-block;
            padding: 6px 3px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            color: #fff;
            text-align: center;
            min-width: 100px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .status-needed {
            background-color: rgb(170, 170, 170);
        }

        .status-finding {
            background-color:rgb(253, 198, 32);
        }

        .status-done {
            background-color:rgb(124, 177, 89);
        }

        /* 點擊次數樣式 */
        .click-count {
            display: inline-block;
            font-size: 12px;
            color: #666;
            margin-left: 8px;
            padding: 2px 6px;
            background: #f5f5f5;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        /* 新增熱門 Device 樣式 */
        .hot-devices-bar {
            background: #f5f5f5;
            border-radius: 6px;
            padding: 12px 18px;
            margin-bottom: 18px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hot-devices-label {
            font-weight: 600;
            color: #666;
            white-space: nowrap;
            font-style: italic;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-right: 10px;
        }

        .hot-devices-label::before {
            content: '▪';
            color: #FFA000;
            font-size: 18px;
        }

        .hot-devices-list {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .hot-device-item {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 6px 18px;
            margin: 6px 0;
            background:rgb(233, 233, 233);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .hot-device-item:hover {
            background: #e9ecef;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .hot-device-name {
            font-weight: 600;
            color:rgb(73, 73, 73);
            font-size: 0.7em;
            letter-spacing: 0.5px;
            text-align: center;
            width: 100%;
        }

        .no-hot-devices {
            color: #888;
            font-style: italic;
            text-align: center;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 6px;
            margin: 6px 0;
        }

        /* 新增容器樣式 */
        .control-panel {
            background: #EEEEEE;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .control-panel > * {
            margin-bottom: 15px;
        }

        .control-panel > *:last-child {
            margin-bottom: 0;
        }

        /* 图片查看器样式 */
        .image-viewer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-viewer.show {
            opacity: 1;
        }

        .image-viewer .viewer-content {
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .image-viewer.show .viewer-content {
            transform: scale(1);
        }

        .image-viewer .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s ease;
            transform: scale(0.9);
            opacity: 0;
        }

        .image-viewer.show .close-btn {
            transform: scale(1);
            opacity: 1;
        }

        .image-viewer .close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .image-viewer .viewer-image {
            max-width: 90vw;
            max-height: 90vh;
            object-fit: contain;
            transition: transform 0.3s ease;
            border: none;
        }

        .image-viewer .zoom-controls {
            position: absolute;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            border-radius: 20px;
            display: flex;
            gap: 10px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .image-viewer.show .zoom-controls {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .image-viewer .zoom-btn {
            background: rgba(149, 149, 149, 0.1);
            border: none;
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            transition: all 0.3s ease;
        }

        .image-viewer .zoom-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .image-viewer .zoom-level {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .image-viewer .zoom-level.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        /* 修改附件图片样式 */
        .bkm-table td img {
            cursor: pointer;
            max-width: 100px;
            padding: 8px;
            border-radius: 4px;
            transition: all 0.3s ease;
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
        }

        .bkm-table td img:hover {
            background: #e0e0e0;
            transform: scale(1.05);
        }

        /* 修改附件预览区域样式 */
        #attchPreviewArea {
            margin-top: 10px;
            margin-left: 150px;
            margin-bottom: 100px;
            padding: 10px;
            border: 1px dashed #ccc;
            border-radius: 4px;
            min-height: 100px;
            width: 80%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #attchPreviewArea img {
            max-width: 200px;
            max-height: 200px;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
        }

        #attchPreviewArea img:hover {
            background: #e0e0e0;
            transform: scale(1.05);
        }

        /* 修改附件上传按钮样式 */
        .upload-btn {
            padding: 8px 16px;
            background: #f5f5f5;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .upload-btn:hover {
            background: #e0e0e0;
        }

        /* 确保所有模态框的层级正确 */
        .modal {
            z-index: 1000;
        }

        .modal.show {
            z-index: 1000;
        }

        .image-viewer.show {
            z-index: 9999;
        }

        /* 修改 Description 字段样式 */
        #viewDesc {
            line-height: 1.2;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* 修改表格中 Description 单元格样式 */
        .bkm-table td:nth-child(4) {
            line-height: 1.2;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* Description 输入框样式 */
        #modalDesc {
            min-height: 180px;
            line-height: 1.5;
            padding: 12px;
            resize: vertical;
            font-family: inherit;
            font-size: 14px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            transition: border-color 0.2s, box-shadow 0.2s;
            background-color: #fff;
        }

        #modalDesc:focus {
            border-color: #e0e0e0;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
            outline: none;
        }

        /* 确保输入框与其他元素对齐 */
        .form-group textarea {
            width: 100%;
            box-sizing: border-box;
            margin: 0;
        }

        /* 统一输入框样式 */
        #modalDesc,
        #modalStatus,
        #modalUpdater,
        #modalDevice,
        #modalSWBin,
        #modalSort {
            min-height: 180px;
            line-height: 1.5;
            padding: 12px;
            resize: vertical;
            font-family: inherit;
            font-size: 14px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            transition: border-color 0.2s, box-shadow 0.2s;
            background-color:rgb(255, 255, 255);
        }

        #modalDesc:focus,
        #modalStatus:focus,
        #modalUpdater:focus,
        #modalDevice:focus,
        #modalSWBin:focus,
        #modalSort:focus {
            border-color: #e0e0e0;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
            outline: none;
        }

        /* 确保输入框与其他元素对齐 */
        .form-group textarea,
        .form-group select,
        .form-group input {
            width: 100%;
            box-sizing: border-box;
            margin: 0;
        }

        /* 下拉选单特殊样式 */
        #modalStatus {
            min-height: auto;
            height: 40px;
            padding: 8px 12px;
            cursor: pointer;
        }

        /* 文本输入框特殊样式 */
        #modalUpdater,
        #modalDevice,
        #modalSWBin,
        #modalSort {
            min-height: auto;
            height: 40px;
            padding: 8px 12px;
        }

        /* Last_update 和 Attch 字段样式 */
        #modalLast_Update,
        #modalAttch {
            width: 100%;
            box-sizing: border-box;
            margin: 0;
            padding: 8px 12px;
            font-family: inherit;
            font-size: 14px;
            border: 1px solidrgb(210, 188, 140);
            border-radius: 4px;
            background-color:rgb(205, 205, 205);
            cursor: not-allowed;
        }

        /* 附件預覽相關樣式 */
        .attachment-preview-container {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .attachment-preview-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: contain;
            border-radius: 4px;
        }

        .pdf-preview-icon {
            font-size: 48px;
            color: #666;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            background: #fff;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .attachment-file-info {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .file-name {
            font-size: 14px;
            color: #333;
            word-break: break-all;
        }

        .remove-attachment {
            background: none;
            border: none;
            color: #ff4444;
            font-size: 20px;
            cursor: pointer;
            padding: 0 5px;
        }

        .remove-attachment:hover {
            color: #cc0000;
        }

        /* --- Verify Card Format Styles --- */
        #Verify-content h2 {
          font-size: 20px;
          font-weight: 600;
          color: #3b3d3f;
          border-bottom: 2px solid #dee2e6;
          padding-bottom: 6px;
          margin-top: 30px;
          margin-bottom: 15px;
        }
        #Verify-content table {
          border-collapse: collapse;
          width: 100%;
          margin-top: 10px;
          margin-bottom: 25px;
          background-color: white;
          table-layout: fixed;
          font-size: 14px;
          border: 1px solid #dee2e6;
          border-radius: 6px;
          overflow: hidden;
        }
        #Verify-content colgroup col:nth-child(1),
        #Verify-content colgroup col:nth-child(3) {
          width: 25%;
        }
        #Verify-content colgroup col:nth-child(2),
        #Verify-content colgroup col:nth-child(4) {
          width: 25%;
        }
        #Verify-content th {
          background-color: #6c757d;
          color: white;
          font-weight: bold;
          text-align: left;
          padding: 8px 12px;
        }
        #Verify-content td {
          border: 1px solid #dee2e6;
          padding: 8px 12px;
          text-align: left;
          word-wrap: break-word;
          white-space: normal;
        }
        #Verify-content tr:nth-child(even):not(.subsection) td {
          background-color: #f1f1f1;
        }
        #Verify-content .subsection td {
          background-color: #ffb327;
          font-weight: bold;
          color: #333;
          border: 1px solid #dee2e6;
        }

        /* --- Verify Tab Layout --- */
        .verify-main-container {
            background-color: #f0f2f5;
            padding: 20px;
            border-radius: 8px;
            width:95%;
            margin: 0 auto;
        }
        .verify-layout-container {
            display: flex;
            gap: 20px;
        }

        /* Verify 專用按鈕樣式 */
        .verify-action-btn, .verify-submit-btn {
            background: rgb(55, 55, 55);
            color: #FAFAFA;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .verify-action-btn:hover, .verify-submit-btn:hover {
            background: #888;
            transform: translateY(-1px);
        }

        .verify-action-add-btn{
            background: rgb(55, 55, 55);
            color: #FAFAFA;
            border: none;
            padding: 10px 30px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

         .verify-action-add-btn:hover{
            background: #888;
            transform: translateY(-1px);
        }

        /* Verify 搜尋欄樣式 */
        .verify-search-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .verify-search-input {
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            width: 300px;
        }
        .verify-search-input:focus {
            outline: none;
            border-color: #FFA000;
            box-shadow: 0 0 0 0.2rem rgba(255, 160, 0, 0.25);
        }

        /* Verify icon 樣式 */
        .verify-title-icon {
            font-size: 24px;
            color: #FFA000;
            margin-right: 10px;
        }
        .verify-list-panel {
            flex: 0.7; /* 0.7 part of the width */
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            height: calc(100vh - 340px); /* Adjust height for parent padding */
            display: flex;
            flex-direction: column;
        }
        .verify-item-list {
            overflow-y: auto;
            flex-grow: 1;
        }
        .verify-item {
            background: #fff;
            padding: 6px 12px;
            border: 1px solid #e0e0e0;
            border-left: 5px solid #525252ff;
            border-radius: 6px;
            margin-bottom: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .verify-item-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex-grow: 1;
            overflow: hidden; /* Prevent content from overflowing */
        }
        .verify-item-main {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            width: 100%;
        }
        .verify-item:hover {
            background-color: rgb(220, 230, 237);
            border-color:rgb(164, 179, 190);
            box-shadow: 0 2px 8px rgba(255, 160, 0, 0.1);
        }
        .verify-item.active {
            background-color: #fff3e0;
            border-color: #FFA000;
            border-left-color: #FFA000;
        }
        .verify-edit-btn {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: background-color 0.2s;
            flex-shrink: 0;
            margin-left: 10px;
        }
        .verify-edit-btn:hover {
            background-color: #5a6268;
        }
        .verify-item-title {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-shrink: 1;
        }
        .verify-item-subtitle {
            font-size: 11px;
            color: #888;
            white-space: nowrap;
            flex-shrink: 0;
            margin-left: 10px;
        }
        .verify-preview-panel {
            flex: 2; /* 2 parts of the width */
            background: #f8f9fa; /* Lighter background for the whole panel */
            border-radius: 8px;
            padding: 0;
            border: 1px solid #dee2e6;
            position: relative;
        }
        .verify-preview-panel .preview-content {
            padding: 20px 30px;
            transition: opacity 0.2s ease-in-out;
        }
        .verify-preview-panel .preview-content.fading {
            opacity: 0;
        }
        .verify-preview-panel h2, .verify-preview-panel h3 {
            background-color: #343a40;
            color: white;
            padding: 12px 30px;
            margin: -20px -30px 20px -30px;
            font-size: 18px;
            border-bottom: 3px solid #FFA000;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .verify-preview-panel h3 { /* Style for sub-headers */
            margin: 20px -30px 10px -30px; /* Reduced top/bottom margin */
            font-size: 16px;
            background-color: #495057;
        }
        .verify-preview-panel .preview-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px !important; /* Force reduced margin */
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .verify-preview-panel .preview-table tr:hover td {
            background-color: #e7f5ff !important; /* Light blue hover */
        }
        .verify-preview-panel .preview-table td {
            border: 1px solid #e9ecef;
            padding: 6px 10px; /* Reduced padding */
            vertical-align: middle;
            text-align: center;
        }
        .verify-preview-panel .preview-key {
            background-color: #595959ff !important;
            color: white;
            font-weight: 600;
            width: 150px;
            text-align: left;
        }
        .verify-preview-panel .preview-value {
            background-color: #f2f2f2ff !important; /* White background for value */

        }
        /* Utility class for centering text in specific cells */
        .text-center {
            text-align: center !important;
        }
        .verify-preview-panel .preview-subsection-header {
            background-color: #ffc107 !important;
            color: #212529;
            font-weight: 600;
            text-align: center;
        }
        .preview-placeholder {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            color: #888;
            font-size: 18px;
        }

        /* --- Verify Modal Styles --- */
        #verifyModal {
            font-size: 13px; /* Base font size reduced by 3px (from 14px) */
        }
        
        #verifyModal .verify-form-grid {
            display: flex;
            flex-direction: column;
            gap: 0px; /* Removed gaps between sections */
        }
        #verifyModal .form-section {
            background: #f8f9fa;
            padding: 10px 15px; /* Reduced from 15px 20px */
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        #verifyModal .form-section-title {
            font-size: 13px; /* Reduced from 16px (already changed to 12px, now 13px) */
            font-weight: 600;
            color: #343a40;
            margin-top: 0;
            margin-bottom: 5px; /* Further reduced from 10px */
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 3px; /* Further reduced from 6px */
        }
        
        /* Redesigned form rows for preview-like layout */
        #verifyModal .form-row {
            display: grid;
            grid-template-columns: 180px 1fr; /* Reduced from 200px */
            gap: 10px; /* Reduced from 15px */
            align-items: center;
            margin-bottom: 0px; /* Removed margin between rows */
            padding: 3px 0; /* Further reduced padding */
            border-bottom: 1px solid #f0f0f0;
        }
        
        #verifyModal .form-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        #verifyModal .form-row label {
            font-weight: 600;
            color: #495057;
            background: #f8f9fa;
            padding: 4px 10px; /* Reduced from 6px 12px */
            border-radius: 4px;
            border: 1px solid #e9ecef;
            text-align: center;
            margin: 0;
            font-size: 11px; /* Reduced from 14px */
        }
        
        /* Modal content padding adjustment - Override general modal-content styles */
        #verifyModal .modal-content {
            padding: 20px 30px !important; /* Reduced from 30px 40px */
            max-width: 1200px !important; /* Ensure width is maintained */
            margin: auto !important; /* Center the modal */
            width: 95% !important; /* Ensure proper width */
        }
        
        /* Modal banner adjustment */
        #verifyModal .modal-banner {
            margin: -10px -20px 20px -20px; /* Adjusted for new padding */
            padding: 20px 15px; /* Reduced padding */
        }
        
        /* Remove multi-column layouts */
        #verifyModal .form-row[data-columns="2"],
        #verifyModal .form-row[data-columns="3"] {
            grid-template-columns: 200px 1fr; /* Keep single column layout */
        }
        
        /* Redesigned Verify Data Items - Preview Modal Style */
        #verifyModal .dynamic-verify-item {
            padding: 0;
            border: 1px solid #e9ecef;
            border-radius: 0;
            margin-bottom: 0;
            position: relative;
            background: #fff;
            overflow: hidden;
        }
        
        #verifyModal .dynamic-verify-item:first-child {
            border-radius: 6px 6px 0 0;
        }
        
        #verifyModal .dynamic-verify-item:last-child {
            border-radius: 0 0 6px 6px;
        }
        
        #verifyModal .dynamic-verify-item:not(:last-child) {
            border-bottom: none;
        }
        
        /* Table header style for verify items */
        #verifyModal #verify-data-section {
            padding: 0;
            background: transparent;
            border: none;
        }
        
        #verifyModal .verify-table-header {
            display: grid;
            grid-template-columns: 120px 1fr 1fr 1fr 1fr; /* Type | Test Program | Prober file | Test OD | Clean OD */
            gap: 0;
            background: #6c757d;
            color: white;
            font-weight: 600;
            font-size: 11px; /* Reduced from 14px */
            border-radius: 6px 6px 0 0;
            overflow: hidden;
        }
        
        #verifyModal .verify-table-header > div {
            padding: 6px 10px; /* Reduced from 8px 12px */
            text-align: center;
            border-right: 1px solid #5a6268;
        }
        
        #verifyModal .verify-table-header > div:last-child {
            border-right: none;
        }
        
        #verifyModal .verify-item-content {
            padding: 0;
        }
        
        #verifyModal .verify-table-row {
            display: grid;
            grid-template-columns: 120px 1fr 1fr 1fr 1fr; /* Match header */
            gap: 0;
            align-items: stretch;
            margin-bottom: 0;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }
        
        #verifyModal .verify-table-row:last-child {
            border-bottom: none;
        }
        
        #verifyModal .verify-field-group {
            display: flex;
            flex-direction: column;
            padding: 6px; /* Reduced from 8px */
            border-right: 1px solid #e9ecef;
        }
        
        #verifyModal .verify-field-group:last-child {
            border-right: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        #verifyModal .verify-field-label {
            display: none; /* Hide individual labels since we have header */
        }
        
        /* Unified input styles for all form elements in modal */
        #verifyModal input[type="text"],
        #verifyModal textarea,
        #verifyModal select {
            width: 100%;
            padding: 5px 8px; /* Reduced from 6px 10px */
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 11px; /* Reduced from 14px */
            box-sizing: border-box;
        }
        #verifyModal textarea {
            min-height: 40px; /* Reduced from 50px */
            resize: vertical;
        }
        
        /* Reduce spacing for form sections in Corr Wafer and Remark */
        #verifyModal #corr_wafer,
        #verifyModal #general_remark {
            min-height: 60px; /* Reduced from 100px */
        }
        
        /* Adjust button spacing */
        #verifyModal .verify-action-btn,
        #verifyModal .verify-submit-btn {
            font-size: 13px; /* Reduced from ~16px */
            padding: 6px 16px; /* Reduced from 8px 18px */
            margin-top: 5px; /* Add small margin */
        }
        
        /* Submit button adjustment */
        #verifyModal button[type="submit"] {
            margin-top: 10px; /* Reduced margin */
            padding: 10px 0; /* Reduced from 15px */
        }
        
        /* Specific width adjustments for verify data fields */
        #verifyModal .verify-field-group.target input,
        #verifyModal .verify-field-group.remark textarea {
            width: 100%; /* Longer fields */
        }
        
        #verifyModal .verify-field-group.od input {
            width: 100%; /* Shorter field but within its column */
        }
        
        #verifyModal .verify-field-group.type select {
            width: 100%;
        }
        
        #verifyModal .dynamic-verify-item .delete-item-btn {
            background: #dc3545;
            color: white;
            border: none;
            width: 18px; /* Further reduced from 20px */
            height: 18px; /* Further reduced from 20px */
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px; /* Reduced from 13px */
            line-height: 18px; /* Adjusted */
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
            padding: 0;
        }
        #verifyModal .dynamic-verify-item .delete-item-btn:hover {
            background: #b71c1c; /* Darker red for emphasis */
            color: white;
            border-color: #b71c1c;
        }
        
        /* Modal banner font adjustments */
        #verifyModal .modal-banner {
            font-size: 14px; /* Reduced from 15px */
        }
        
        #verifyModal .banner-subtitle {
            font-size: 11px; /* Reduced from ~14px */
        }
        
        /* --- Verify Preview Panel Styles --- */
        .verify-preview-panel h2 {
            background-color: #e9ecef;
            padding: 10px 15px;
            margin: -20px -30px 20px -30px;
            font-size: 18px;
            color: #495057;
            border-bottom: 1px solid #dee2e6;
        }
        #Verify-content .preview-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
        }
        #Verify-content .preview-table td {
            border: 1px solid #d2d2d2ff;
            padding: 8px 12px;
            vertical-align: middle;
        }
        .preview-key {
            background-color: #6c757d;
            color: white;
            font-weight: 600;
            width: 150px;
        }
        .preview-value {
            background-color: #f8f9fa;
        }
        .preview-subsection-header {
            background-color: #ffc107;
            color: #212529;
            font-weight: 600;
            text-align: center;
        }

        .verify-preview-panel .preview-table tr:hover .preview-value {
            background-color: rgb(220, 230, 237) !important; /* Specific color on value cell hover */
        }
        .verify-preview-panel .preview-table tr:hover .preview-key {
            background-color: #6c757d !important; /* Keep original color on hover */
        }
        .verify-preview-panel .preview-table td {
            border: 1px solid #e9ecef;
            padding: 3px 8px !important; /* Force padding */
            vertical-align: middle;
            transition: background-color 0.2s ease; /* Smooth transition for hover */
        }
        /* Specific rule for OD content centering with higher specificity */
        #Verify-content .verify-preview-panel .preview-value.od-content {
            text-align: center !important;
        }
        /* Specific rule for OD key/title centering */
        #Verify-content .verify-preview-panel .preview-key.od-key {
            text-align: center !important;
        }
        .verify-preview-panel .preview-subsection-header {
            background-color: #ffc107 !important;
            color: #212529;
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>
<body>
<?php include '..\0_Aside\V5_Aside_001_D.php'; ?>

<main class="main-container">
    <header class="block1 header-bg">
        <h1>Device information center</h1>
    </header>

    <div class="tab-bar">
        <div class="tab-container">
            <a class="tab-button" href="../V65_Maintian BKM/V67_Maintian BKM.php">Device Maintain BKM</a>
            <a class="tab-button active" href="../V67_Maintian verify/V67_Maintian verify A3.php">Device Verify information</a>
            <a class="tab-button" href="#">Wafer control table</a>
        </div>
    </div>

    <div class="page-title-bar">
        <h2 class="page-title">
            <span id="currentPageTitle">Device Verify information | 驗卡資訊</span> 
        </h2>
    </div>

    <section class="container">

        <div id="BKM-content" class="tab-content">
            
            <div class="bkm-module">
                <div class="control-panel">
                    <?php
                    // 載入公告模組
                    require_once 'announcement.php';
                    // 呼叫函式顯示公告區
                    displayAnnouncement();
                    ?>
                    
                    <div class="action-bar">
                        <div class="bkm-search-group">
                            <input type="text" id="bkmSearchInput" class="bkm-search-input" placeholder="Search...">
                            <button class="bkm-search-btn" onclick="searchBKMTable()">Search</button>
                            <button class="bkm-clean-btn" onclick="cleanSearch()">Clean</button>
                        </div>
                        <div class="right-group">
                            <button class="bkm-action-btn" onclick="openBKMModal()">新增資料</button>
                        </div>
                    </div>

                    <div class="hot-devices-bar">
                        <span class="hot-devices-label">Key Maintain Device Top 5:</span>
                        <div class="hot-devices-list" id="hotDevicesList">
                            </div>
                    </div>
                </div>

                <h3 class="bkm-table-title"><span class="bkm-title-icon">⛞</span>Device Maintain BKM information</h3>
                <div class="bkm-table-wrapper">
                    <table class="bkm-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Site</th>
                                <th>Device</th>
                                <th>SWBin & Issue</th>
                                <th>Sort</th>
                                <th>Desc.</th>
                                <th>Attch.</th>
                                <th>Status</th>
                                <th>Updater</th>
                                <th>Last_update</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="11" style="text-align:center;color:#aaa;">尚無資料</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="Verify-content" class="tab-content active">
            <div class="verify-main-container">
                <div class="verify-layout-container">
                    <div class="verify-list-panel">
                        <div class="control-panel" style="padding: 15px; margin-bottom: 10px;">
                            <div class="action-bar">
                                <div class="verify-search-group">
                                    <input type="text" id="verifySearchInput" class="verify-search-input" placeholder="依 Part6 或 Device Name 搜尋...">
                                    <button class="bkm-search-btn" onclick="searchVerifyTable()">Search</button>
                                    <button class="bkm-clean-btn" onclick="cleanVerifySearch()">Clean</button>
                                </div>
                                <div class="right-group">
                                    <button class="verify-action-add-btn" onclick="openVerifyModal()">+ New Request</button>
                                </div>
                            </div>
                        </div>
                        <div class="verify-item-list" id="verify-list-container">
                            <!-- 資料列表將由 JS 動態載入 -->
                            <div class="no-data">尚無資料</div>
                        </div>
                    </div>
                    <div class="verify-preview-panel">
                        <div class="preview-placeholder" id="verify-preview-placeholder">
                            點擊左側項目以預覽詳細資訊
                        </div>
                        <div class="preview-content" id="verify-preview-content" style="display: none;">
                             <!-- 預覽內容將由 JS 動態生成 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="Wafer-content" class="tab-content">
            <div class="blank-area">
                Wafer control table 功能區域 [開發中] 
            </div>
        </div>
    </section>
</main>

<div id="verifyModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeVerifyModal()">&times;</span>
        <div class="modal-banner">
            <div class="banner-content">
                <div class="banner-title">
                    <span class="verify-title-icon">⛛</span>
                    Device Verify Information
                </div>
                <div class="banner-subtitle" id="verifyModalSubtitle">新增驗卡資料</div>
            </div>
        </div>
        <form id="verifyForm" onsubmit="submitVerifyForm(event)">
            <input type="hidden" id="verifyId" name="id">
            
            <div class="verify-form-grid">
                <!-- Basic Info -->
                <div class="form-section">
                    <h3 class="form-section-title">BasicInformation</h3>
                    <div class="form-row">
                        <label for="part6">Part6</label>
                        <input type="text" id="part6" name="part6" required>
                    </div>
                    <div class="form-row">
                        <label for="device_name">Device_name</label>
                        <input type="text" id="device_name" name="device_name" required>
                    </div>
                    <div class="form-row">
                        <label for="pcr_owner">PCR Owner</label>
                        <input type="text" id="pcr_owner" name="pcr_owner">
                    </div>
                    <div class="form-row">
                        <label for="otc_owner">OTC Owner</label>
                        <input type="text" id="otc_owner" name="otc_owner">
                    </div>
                    <div class="form-row">
                        <label for="rd_owner">RD Owner</label>
                        <input type="text" id="rd_owner" name="rd_owner">
                    </div>
                </div>

                <!-- Verify Data -->
                <div class="form-section" id="verify-data-section">
                    <h3 class="form-section-title">VerifyData</h3>
                    <!-- Dynamic rows will be inserted here -->
                </div>
                 <button type="button" class="verify-action-btn" onclick="addVerifyDataItem()">+ Add Verify Type</button>

                <!-- Corr Wafer -->
                <div class="form-section">
                     <h3 class="form-section-title">CorrWafer</h3>
                    <textarea id="corr_wafer" name="corr_wafer" placeholder="每行一個 LOT..." style="width: 100%; min-height: 100px;"></textarea>
                </div>

                <!-- Parameters -->
                <div class="form-section">
                    <h3 class="form-section-title">Parameters</h3>
                    <div class="form-row">
                        <label for="clean_pad_type">Clean Pad type</label>
                        <select id="clean_pad_type" name="clean_pad_type">
                            <option value="">請選擇</option>
                            <option value="Clean Pad type">Clean Pad type</option>
                            <option value="Type1">Type 1</option>
                            <option value="Type2">Type 2</option>
                            <option value="Type3">Type 3</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="verify_sort">Verify Sort</label>
                        <select id="verify_sort" name="verify_sort">
                            <option value="">請選擇</option>
                            <option value="Verify Sort">Verify Sort</option>
                            <option value="Sort1">Sort 1</option>
                            <option value="Sort2">Sort 2</option>
                            <option value="Sort3">Sort 3</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="verify_method">Verify method</label>
                        <select id="verify_method" name="verify_method">
                            <option value="">請選擇</option>
                            <option value="Verify method">Verify method</option>
                            <option value="Method1">Method 1</option>
                            <option value="Method2">Method 2</option>
                            <option value="Method3">Method 3</option>
                        </select>
                    </div>
                </div>
                
                <!-- Rules -->
                 <div class="form-section">
                    <h3 class="form-section-title">Rules</h3>
                    <div class="form-row">
                        <label for="rule_verify_pass">Rule of verify pass</label>
                        <select id="rule_verify_pass" name="rule_verify_pass">
                            <option value="">請選擇</option>
                            <option value="Rule A">Rule A</option>
                            <option value="Pass1">Pass Rule 1</option>
                            <option value="Pass2">Pass Rule 2</option>
                            <option value="Pass3">Pass Rule 3</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="rule_contact_window">Rule of Contact window</label>
                        <select id="rule_contact_window" name="rule_contact_window">
                            <option value="">請選擇</option>
                            <option value="Contact Rule X">Contact Rule X</option>
                            <option value="Window1">Window Rule 1</option>
                            <option value="Window2">Window Rule 2</option>
                            <option value="Window3">Window Rule 3</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="rule_dib_check">Rule of DIB check</label>
                        <select id="rule_dib_check" name="rule_dib_check">
                            <option value="">請選擇</option>
                            <option value="DIB Rule 1">DIB Rule 1</option>
                            <option value="DIB1">DIB Check 1</option>
                            <option value="DIB2">DIB Check 2</option>
                            <option value="DIB3">DIB Check 3</option>
                        </select>
                    </div>
                </div>

                <!-- Remark -->
                <div class="form-section">
                    <h3 class="form-section-title">GeneralRemark</h3>
                    <textarea id="general_remark" name="general_remark" placeholder="輸入備註..." style="width: 100%; min-height: 100px;"></textarea>
                </div>
            </div>

            <div style="text-align:center; margin-top:20px;">
                <button type="submit" class="verify-submit-btn" style="width:100%;font-size:17px;padding:15px 0;letter-spacing:1px;">Submit</button>
            </div>
        </form>
    </div>
</div>

<div id="toast" class="toast">操作完成 ✔</div>

<div id="bkmModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeBKMModal()">&times;</span>
    <div class="modal-banner">
        <div class="banner-content">
            <div class="banner-title">
                <span class="bkm-title-icon">⛞</span>
                Device maintain BKM information
            </div>
            <div class="banner-subtitle" id="bkmModalSubtitle">新增資料</div>
        </div>
    </div>
    <form id="bkmAddForm" enctype="multipart/form-data" onsubmit="submitBKMForm(event)">
      <div class="form-group">
        <label for="modalSite">Site</label>
        <select id="modalSite" name="Site" required style="flex-grow: 1; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; width: 100%; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s, box-shadow 0.2s; background-color: #fff; cursor: pointer;">
          <option value="">請選擇 Site</option>
          <option value="AT">AT</option>
          <option value="XT">XT</option>
          <option value="TT">TT</option>
          <option value="LT">LT</option>
          <option value="CT">CT</option>
        </select>
      </div>
      <div class="form-group">
        <label for="modalDevice">Device</label>
        <input type="text" id="modalDevice" name="Device" required placeholder="請輸入Devcie 四碼">
      </div>
      <div class="form-group">
        <label for="modalSWBin"> SWBin & Issue</label>
        <input type="text" id="modalSWBin" name="SWBin_Issue" required placeholder="請輸入Failed model">
      </div>
      <div class="form-group">
        <label for="modalSort"> Sort</label>
        <select id="modalSort" name="Sort" required style="flex-grow: 1; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; width: 100%; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s, box-shadow 0.2s; background-color: #fff; cursor: pointer;">
          <option value="">請選擇 Sort</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="1,2">1,2</option>
          <option value="1,2,3">1,2,3</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
        </select>
      </div>
      <div class="form-group">
        <label for="modalDesc"> Desc.</label>
        <textarea id="modalDesc" name="Description" rows="4" required placeholder="請描述內容" style="resize:vertical;"></textarea>
      </div>
      <div class="form-group">
        <label for="modalAttch">Attch.</label>
        <input type="file" id="modalAttch" name="Attch" accept="image/*,application/pdf">
      </div>
      <div id="attchPreviewArea" style="text-align:left;margin-bottom:20px;"></div>
      <div class="form-group">
        <label for="modalStatus">Status</label>
        <select id="modalStatus" name="Status" required style="flex-grow: 1; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; width: 100%; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s, box-shadow 0.2s; background-color: #fff; cursor: pointer;">
            <option value="BKM needed">BKM needed</option>
            <option value="BKM finding">BKM finding</option>
            <option value="BKM done">BKM done</option>
        </select>
      </div>
      <div class="form-group">
        <label for="modalUpdater">Updater</label>
        <input type="text" id="modalUpdater" name="Updater" required placeholder="請Owner輸入名稱">
      </div>
      <div class="form-group">
        <label for="modalLastUpdate">Last_update</label>
        <input type="text" id="modalLastUpdate" name="Last_update" readonly style="background:#f5f5f5;color:#888;">
      </div>
      <div class="form-group" style="margin-top: -10px;">
        <label></label>
        <span id="modalIdInfo" style="display:inline-block;font-size:14px;color:#555;font-weight:500;background:#f5f5f5;padding:4px 12px;border-radius:4px;text-align:right;width:100%;box-sizing:border-box;"></span>
      </div>
      <div style="text-align:center; margin-top:20px;">
        <button type="submit" class="bkm-action-btn" style="width:100%;font-size:17px;padding:15px 0;letter-spacing:1px;">Submit</button>
      </div>
    </form>
  </div>
</div>

<div id="deleteModal" class="modal">
  <div class="modal-content">
    <h3>確定要刪除？</h3>
    <p>此操作無法復原，是否確定要刪除此筆資料？</p>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeDeleteModal()">取消</button>
      <button class="btn-confirm" onclick="confirmDeleteBKM()">確定</button>
    </div>
  </div>
</div>

<div id="attachmentPreviewModal" class="modal">
  <div class="modal-content" id="attachmentPreviewModalContent" style="background:transparent;box-shadow:none;padding:0;border:none;display:inline-block;position:relative;max-width:none;">
    <span class="close attachment-modal-close" onclick="closeAttachmentPreview()">&times;</span>
    <div id="attachmentPreviewContent"></div>
  </div>
</div>

<div id="viewDataModal" class="modal">
    <div class="modal-content">
        <div class="modal-banner">
            <div class="banner-content">
                <div class="banner-title">
                    <span class="bkm-title-icon">⛞</span>
                    Device maintain BKM information
                </div>
                <div class="banner-subtitle">檢視資料</div>
            </div>
            <button class="close" onclick="closeViewDataModal()" title="關閉">&times;</button>
        </div>
        <div class="modal-body">
            <div class="data-row">
                <div class="data-label">Site</div>
                <div class="data-value" id="viewSite"></div>
            </div>
            <div class="data-row">
                <div class="data-label">Device</div>
                <div class="data-value" id="viewDevice"></div>
            </div>
            <div class="data-row">
                <div class="data-label">SWBin & Issue</div>
                <div class="data-value" id="viewSWBin"></div>
            </div>
            <div class="data-row">
                <div class="data-label">Sort</div>
                <div class="data-value" id="viewSort"></div>
            </div>
            <div class="data-row">
                <div class="data-label">Desc.</div>
                <div class="data-value" id="viewDesc"></div>
            </div>
            <div class="data-row">
                <div class="data-label">Status</div>
                <div class="data-value" id="viewStatus"></div>
            </div>
            <div class="data-row">
                <div class="data-label">Updater</div>
                <div class="data-value" id="viewUpdater"></div>
            </div>
            <div class="data-row">
                <div class="data-label">Last Update</div>
                <div class="data-value" id="viewLastUpdate"></div>
            </div>
            <div class="attachment-preview" id="viewAttachment"></div>
        </div>
    </div>
</div>

<div class="image-viewer" id="imageViewer">
    <span class="close-btn" onclick="closeImageViewer()">&times;</span>
    <img id="viewerImage" src="" alt="查看图片">
    <div class="zoom-controls">
        <button class="zoom-btn" onclick="zoomImage(-0.1)">-</button>
        <button class="zoom-btn" onclick="zoomImage(0.1)">+</button>
    </div>
    <div class="zoom-level" id="zoomLevel"></div>
</div>

<script>


// --- Shared Utility Functions ---
function showToast(text) {
    const t = document.getElementById('toast');
    t.textContent = text;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2000);
}

// Initialize the page state
document.addEventListener('DOMContentLoaded', () => {
    // Set up tab styles
    const style = document.createElement('style');
    style.textContent = `
        #currentPageTitle {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    `;
    document.head.appendChild(style);

    // BKM related initializations if any (can be removed if BKM is fully separated)
    // For example: loadBKMTable();
});

// --- Verify Tab Specific Functions ---

// Global variables for Verify tab
let allVerifyData = []; // To cache all verify data loaded from the server
let currentVerifyData = null; // To store data of the item being edited or viewed
let verifyItemCounter = 0; // To keep track of dynamic verify items

// --- Data Fetching and Rendering ---

async function loadAndRenderVerifyData() {
    try {
        const response = await fetch('verify_api.php?action=getAll');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        
        if (result.success && Array.isArray(result.data)) {
            allVerifyData = result.data;
            renderVerifyList(allVerifyData);
        } else {
            allVerifyData = [];
            renderVerifyList([]);
            console.error('Failed to load verify data:', result.message || 'Unknown error');
            showToast('無法載入驗卡資料: ' + (result.message || '未知錯誤'));
        }
    } catch (error) {
        allVerifyData = [];
        renderVerifyList([]);
        console.error('Error fetching verify data:', error);
        showToast('載入資料時發生錯誤: ' + error.message);
    }
}

function renderVerifyList(data) {
    const listContainer = document.getElementById('verify-list-container');
    if (!listContainer) return;

    if (data.length === 0) {
        listContainer.innerHTML = '<div class="no-data">尚無資料</div>';
        return;
    }

    listContainer.innerHTML = data.map(item => `
        <div class="verify-item" id="verify-item-list-${item.id}" onclick="renderVerifyPreview('${item.id}')">
            <div class="verify-item-content">
                <div class="verify-item-main">
                    <span class="verify-item-title">${escapeHtml(item.part6)} - ${escapeHtml(item.device_name)}</span>
                    <span class="verify-item-subtitle">Updated: ${new Date(item.updated_at).toLocaleString()}</span>
                </div>
            </div>
            <button class="verify-edit-btn" onclick="event.stopPropagation(); openVerifyModalById('${item.id}');">編輯</button>
        </div>
    `).join('');
}

function renderVerifyPreview(id) {
    const item = allVerifyData.find(d => d.id === id);
    if (!item) {
        console.error(`Preview failed: item with id ${id} not found.`);
        return;
    }

    // Highlight active item
    document.querySelectorAll('.verify-item.active').forEach(el => el.classList.remove('active'));
    document.getElementById(`verify-item-list-${id}`).classList.add('active');

    const previewContainer = document.getElementById('verify-preview-content');
    const placeholder = document.getElementById('verify-preview-placeholder');

    let contentHtml = `<h2>${escapeHtml(item.part6)} - ${escapeHtml(item.device_name)}</h2>`;

    contentHtml += createPreviewTable(item);

    previewContainer.innerHTML = contentHtml;
    placeholder.style.display = 'none';
    previewContainer.style.display = 'block';
}

function createPreviewTable(item) {
    let tableHtml = '<table class="preview-table">';
    const addRow = (key, value) => {
        if (value) {
            tableHtml += `<tr><td class="preview-key">${key}</td><td class="preview-value">${escapeHtml(value)}</td></tr>`;
        }
    };

    addRow('PCR Owner', item.pcr_owner);
    addRow('OTC Owner', item.otc_owner);
    addRow('RD Owner', item.rd_owner);
    addRow('Clean Pad Type', item.clean_pad_type);
    addRow('Verify Sort', item.verify_sort);
    addRow('Verify Method', item.verify_method);
    addRow('Rule of Verify Pass', item.rule_verify_pass);
    addRow('Rule of Contact Window', item.rule_contact_window);
    addRow('Rule of DIB Check', item.rule_dib_check);
    addRow('Corr Wafer', item.corr_wafer);
    addRow('General Remark', item.general_remark);
    addRow('Created At', new Date(item.created_at).toLocaleString());
    addRow('Updated At', new Date(item.updated_at).toLocaleString());
    
    tableHtml += '</table>';

    if (item.verify_data && item.verify_data.length > 0) {
        tableHtml += '<h3>Verify Items</h3>';
        tableHtml += '<table class="preview-table"><thead><tr><th>Type</th><th>Test Program</th><th>Prober File</th><th>Test OD</th><th>Clean OD</th></tr></thead><tbody>';
        item.verify_data.forEach(subItem => {
            tableHtml += `<tr>
                <td>${escapeHtml(subItem.verify_type)}</td>
                <td>${escapeHtml(subItem.test_program)}</td>
                <td>${escapeHtml(subItem.prober_file)}</td>
                <td class="text-center od-content">${escapeHtml(subItem.test_od)}</td>
                <td class="text-center od-content">${escapeHtml(subItem.clean_od)}</td>
            </tr>`;
        });
        tableHtml += '</tbody></table>';
    }

    return tableHtml;
}


// --- Modal and Form Handling ---

function openVerifyModalById(id) {
    const data = allVerifyData.find(item => item.id === id);
    if (data) {
        openVerifyModal(data);
    } else {
        console.error(`Could not find data for id ${id} to edit.`);
        showToast('找不到要編輯的資料');
    }
}

async function submitVerifyForm(event) {
    event.preventDefault();
    
    try {
        const form = document.getElementById('verifyForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        const existingId = document.getElementById('verifyId').value;
        if (!existingId) {
            data.id = 'verify_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            data.created_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
        } else {
            data.id = existingId;
        }
        data.updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');


        data.verify_data = [];
        const verifyItems = document.querySelectorAll('#verify-data-section .dynamic-verify-item');
        
        verifyItems.forEach((item, index) => {
            const verifyType = item.querySelector('select[name="verify_type[]"]')?.value || '';
            const testProgram = item.querySelector('input[name="test_program[]"]')?.value || '';
            const proberFile = item.querySelector('input[name="prober_file[]"]')?.value || '';
            const testOd = item.querySelector('input[name="test_od[]"]')?.value || '';
            const cleanOd = item.querySelector('input[name="clean_od[]"]')?.value || '';

            if (verifyType || testProgram || proberFile || testOd || cleanOd) {
                data.verify_data.push({
                    verify_type: verifyType,
                    test_program: testProgram,
                    prober_file: proberFile,
                    test_od: testOd,
                    clean_od: cleanOd
                });
            }
        });

        if (!data.part6 || !data.device_name) {
            showToast('請填寫必要欄位：Part6 和 Device Name');
            return;
        }

        const response = await fetch('verify_api.php?action=save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();

        if (result.success) {
            showToast(existingId ? '資料已成功更新！' : '資料已成功新增！');
            closeVerifyModal();
            loadAndRenderVerifyData(); // Refresh the list
        } else {
            showToast('儲存失敗: ' + result.message);
        }
        
    } catch (error) {
        console.error('Form submission error:', error);
        showToast('儲存失敗，請重試');
    }
}

function addVerifyDataItem(itemData = {}) {
    const existingItems = document.querySelectorAll('#verify-data-section .dynamic-verify-item');
    if (existingItems.length >= 5) {
        showToast('最多只能新增五個驗證項目');
        return;
    }

    if (existingItems.length === 0) {
        const headerHtml = `
            <div class="verify-table-header">
                <div>Type</div>
                <div>Test Program</div>
                <div>Prober file</div>
                <div>Test OD</div>
                <div>Clean OD</div>
            </div>
        `;
        document.getElementById('verify-data-section').insertAdjacentHTML('beforeend', headerHtml);
    }

    verifyItemCounter++;
    const newItemHtml = `
        <div class="dynamic-verify-item" id="verify-item-${verifyItemCounter}">
            <div class="verify-item-content">
                <div class="verify-table-row">
                    <div class="verify-field-group type">
                        <select id="verify_type_${verifyItemCounter}" name="verify_type[]">
                            <option value="">選擇類型</option>
                            <option value="Test Program">Test Program</option>
                            <option value="Prober file">Prober file</option>
                            <option value="Test OD">Test OD</option>
                            <option value="Clean OD">Clean OD</option>
                        </select>
                    </div>
                    <div class="verify-field-group test-program">
                        <input type="text" id="test_program_${verifyItemCounter}" name="test_program[]" placeholder="Test Program...">
                    </div>
                    <div class="verify-field-group prober-file">
                        <input type="text" id="prober_file_${verifyItemCounter}" name="prober_file[]" placeholder="Prober file...">
                    </div>
                    <div class="verify-field-group test-od">
                        <input type="text" id="test_od_${verifyItemCounter}" name="test_od[]" placeholder="Test OD...">
                    </div>
                    <div class="verify-field-group clean-od">
                        <input type="text" id="clean_od_${verifyItemCounter}" name="clean_od[]" placeholder="Clean OD...">
                    </div>
                </div>
            </div>
        </div>
    `;
    document.getElementById('verify-data-section').insertAdjacentHTML('beforeend', newItemHtml);
    
    // Populate data if provided
    if(itemData.verify_type) document.getElementById(`verify_type_${verifyItemCounter}`).value = itemData.verify_type;
    if(itemData.test_program) document.getElementById(`test_program_${verifyItemCounter}`).value = itemData.test_program;
    if(itemData.prober_file) document.getElementById(`prober_file_${verifyItemCounter}`).value = itemData.prober_file;
    if(itemData.test_od) document.getElementById(`test_od_${verifyItemCounter}`).value = itemData.test_od;
    if(itemData.clean_od) document.getElementById(`clean_od_${verifyItemCounter}`).value = itemData.clean_od;
}

function openVerifyModal(data = null) {
    currentVerifyData = data;
    const modal = document.getElementById('verifyModal');
    const form = document.getElementById('verifyForm');
    form.reset();
    
    document.getElementById('verify-data-section').innerHTML = '';
    verifyItemCounter = 0;

    if (data) {
        document.getElementById('verifyModalSubtitle').textContent = '編輯驗卡資料';
        document.getElementById('verifyId').value = data.id;
        document.getElementById('part6').value = data.part6;
        document.getElementById('device_name').value = data.device_name;
        document.getElementById('pcr_owner').value = data.pcr_owner;
        document.getElementById('otc_owner').value = data.otc_owner;
        document.getElementById('rd_owner').value = data.rd_owner;
        document.getElementById('corr_wafer').value = data.corr_wafer;
        document.getElementById('clean_pad_type').value = data.clean_pad_type;
        document.getElementById('verify_sort').value = data.verify_sort;
        document.getElementById('verify_method').value = data.verify_method;
        document.getElementById('rule_verify_pass').value = data.rule_verify_pass;
        document.getElementById('rule_contact_window').value = data.rule_contact_window;
        document.getElementById('rule_dib_check').value = data.rule_dib_check;
        document.getElementById('general_remark').value = data.general_remark;

        if (data.verify_data && Array.isArray(data.verify_data)) {
            data.verify_data.forEach(item => addVerifyDataItem(item));
        }
    } else {
        document.getElementById('verifyModalSubtitle').textContent = '新增驗卡資料';
        const defaultTypes = ["Test Program", "Prober file", "Test OD", "Clean OD"];
        defaultTypes.forEach(type => {
            addVerifyDataItem({ verify_type: type });
        });
    }

    modal.classList.add('show');
}

function closeVerifyModal() {
    document.getElementById('verifyModal').classList.remove('show');
}

function searchVerifyTable() {
    const searchTerm = document.getElementById('verifySearchInput').value.toLowerCase();
    const filteredData = allVerifyData.filter(item => 
        item.part6.toLowerCase().includes(searchTerm) || 
        item.device_name.toLowerCase().includes(searchTerm)
    );
    renderVerifyList(filteredData);
}

function cleanVerifySearch() {
    document.getElementById('verifySearchInput').value = '';
    renderVerifyList(allVerifyData);
}


// --- Page Initialization ---
document.addEventListener('DOMContentLoaded', () => {
    // Initial data load for Verify Tab
    loadAndRenderVerifyData();
});

// 在 // --- Shared Utility Functions --- 區塊後新增
function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

</script>

<!-- Dedicated script for all Verify Tab functionality -->
<script src="verify_js_fix.js"></script>

</body>
</html>