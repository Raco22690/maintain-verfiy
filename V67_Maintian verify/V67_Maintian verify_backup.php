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
            width: 100%;
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
        /* --- 修改: 提高關閉按鈕 z-index --- */
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
        .verify-layout-container {
            display: flex;
            gap: 20px;
        }
        .verify-list-panel {
            width: 350px;
            flex-shrink: 0;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            height: calc(100vh - 280px);
            display: flex;
            flex-direction: column;
        }
        .verify-item-list {
            overflow-y: auto;
            flex-grow: 1;
        }
        .verify-item {
            background: #fff;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .verify-item:hover {
            border-color: #007bff;
            box-shadow: 0 2px 8px rgba(0,123,255,0.1);
        }
        .verify-item.active {
            background-color: #e7f3ff;
            border-color: #007bff;
        }
        .verify-item-title {
            font-weight: 600;
            color: #333;
        }
        .verify-item-subtitle {
            font-size: 13px;
            color: #666;
        }
        .verify-preview-panel {
            flex-grow: 1;
            background: #fff;
            border-radius: 8px;
            padding: 20px 30px;
            height: calc(100vh - 280px);
            overflow-y: auto;
            border: 1px solid #e0e0e0;
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
        #verifyModal .verify-form-grid {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        #verifyModal .form-section {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        #verifyModal .form-section-title {
            font-size: 16px;
            font-weight: 600;
            color: #343a40;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 8px;
        }
        #verifyModal .form-row {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 10px 15px;
            align-items: center;
            margin-bottom: 10px;
        }
        #verifyModal .form-row[data-columns="3"] {
            grid-template-columns: auto 1fr auto 1fr auto 1fr;
        }

        #verifyModal input[type="text"],
        #verifyModal textarea,
        #verifyModal select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }
        #verifyModal textarea {
            min-height: 80px;
            resize: vertical;
        }
        #verifyModal .dynamic-verify-item {
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-bottom: 15px;
            position: relative;
            background: #fff;
        }
        #verifyModal .dynamic-verify-item .delete-item-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3545;
            color: white;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            line-height: 24px;
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
            <button class="tab-button" onclick="switchTab('BKM')">Device Maintain BKM</button>
            <button class="tab-button active" onclick="switchTab('Verify')">Device Verify information</button>
            <button class="tab-button" onclick="switchTab('Wafer')">Wafer control table</button>
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
            <div class="verify-layout-container">
                <div class="verify-list-panel">
                    <div class="control-panel" style="padding: 15px; margin-bottom: 10px;">
                        <div class="action-bar">
                            <div class="bkm-search-group">
                                <input type="text" id="verifySearchInput" class="bkm-search-input" placeholder="依 Part6 或 Device Name 搜尋...">
                            </div>
                            <div class="right-group">
                                <button class="bkm-action-btn" onclick="openVerifyModal()">New Request</button>
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
        <div id="Wafer-content" class="tab-content">
            <div class="blank-area">
                Wafer control table 功能區域 [開發中] 
            </div>
        </div>
    </section>
</main>

<div id="verifyModal" class="modal">
    <div class="modal-content" style="max-width: 1200px;">
        <span class="close" onclick="closeVerifyModal()">&times;</span>
        <div class="modal-banner">
            <div class="banner-content">
                <div class="banner-title">
                    <span class="bkm-title-icon">⛛</span>
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
                    <h3 class="form-section-title">Basic Information</h3>
                    <div class="form-row">
                        <label for="part6">Part6</label><input type="text" id="part6" name="part6" required>
                        <label for="device_name">Device_name</label><input type="text" id="device_name" name="device_name" required>
                    </div>
                    <div class="form-row">
                        <label for="pcr_owner">PCR Owner</label><input type="text" id="pcr_owner" name="pcr_owner">
                        <label for="otc_owner">OTC Owner</label><input type="text" id="otc_owner" name="otc_owner">
                        <label for="rd_owner">RD Owner</label><input type="text" id="rd_owner" name="rd_owner">
                    </div>
                </div>

                <!-- Verify Data -->
                <div class="form-section" id="verify-data-section">
                    <h3 class="form-section-title">Verify Data</h3>
                    <!-- Dynamic rows will be inserted here -->
                </div>
                 <button type="button" class="bkm-action-btn" onclick="addVerifyDataItem()">+ Add Verify Type</button>

                <!-- Corr Wafer -->
                <div class="form-section">
                     <h3 class="form-section-title">Corr Wafer</h3>
                    <textarea id="corr_wafer" name="corr_wafer" placeholder="每行一個 LOT..."></textarea>
                </div>

                <!-- Parameters -->
                <div class="form-section">
                    <h3 class="form-section-title">Parameters</h3>
                     <div class="form-row">
                        <label for="clean_pad_type">Clean Pad type</label><select id="clean_pad_type" name="clean_pad_type"></select>
                        <label for="verify_sort">Verify Sort</label><select id="verify_sort" name="verify_sort"></select>
                        <label for="verify_method">Verify method</label><select id="verify_method" name="verify_method"></select>
                    </div>
                </div>
                
                <!-- Rules -->
                 <div class="form-section">
                    <h3 class="form-section-title">Rules</h3>
                     <div class="form-row">
                        <label for="rule_verify_pass">Rule of verify pass</label><select id="rule_verify_pass" name="rule_verify_pass"></select>
                        <label for="rule_contact_window">Rule of Contact window</label><select id="rule_contact_window" name="rule_contact_window"></select>
                        <label for="rule_dib_check">Rule of DIB check</label><select id="rule_dib_check" name="rule_dib_check"></select>
                    </div>
                </div>

                <!-- Remark -->
                <div class="form-section">
                    <h3 class="form-section-title">General Remark</h3>
                    <textarea id="general_remark" name="general_remark" placeholder="輸入備註..."></textarea>
                </div>
            </div>

            <div style="text-align:center; margin-top:20px;">
                <button type="submit" class="bkm-action-btn" style="width:100%;font-size:17px;padding:15px 0;letter-spacing:1px;">Submit</button>
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
// 定義 Site 相關常數
const DEFAULT_SITE = 'AT';  // 預設的 Site
const AVAILABLE_SITES = ['AT', 'XT', 'TT', 'LT', 'CT'];  // 可檢視的 Site 列表

const ALL_SITES_OPTION = 'ALL';  // 檢查所有 Site 的選項

// 在頁面載入時設置預設 Site
document.addEventListener('DOMContentLoaded', function() {
    const modalSite = document.getElementById('modalSite');
    if (modalSite) {
        modalSite.value = DEFAULT_SITE;
    }
});

// 修改 loadBKMTable 函數，增加 Site 過濾功能
function loadBKMTable() {
    fetch('bkm_db.php')
        .then(res => res.json())
        .then(json => {
            if (!json.success || !Array.isArray(json.data) || json.data.length === 0) {
                const tbody = document.querySelector('.bkm-table tbody');
                tbody.innerHTML = '<tr><td colspan="11" style="text-align:center;color:#aaa;">尚無資料</td></tr>';
                bkmTableCache = [];
                return;
            }
            
            // 過濾可檢視的 Site
            const filteredData = json.data.filter(row => AVAILABLE_SITES.includes(row.Site));
            bkmTableCache = filteredData;
            renderBKMTableRows(filteredData);
        })
        .catch(() => {
            const tbody = document.querySelector('.bkm-table tbody');
            tbody.innerHTML = '<tr><td colspan="11" style="text-align:center;color:#aaa;">資料載入失敗</td></tr>';
            bkmTableCache = [];
        });
}

// 修改 submitBKMForm 函數，增加 Site 驗證
function submitBKMForm() {
    // 檢查必填欄位
    const device = document.getElementById('modalDevice').value;
    if (!device) {
        showToast('請填寫 Device 欄位');
        return;
    }

    // 構建 FormData
    const formData = new FormData();
    formData.append('Device', device);
    formData.append('SWBin_Issue', document.getElementById('modalSWBin').value);
    formData.append('Sort', document.getElementById('modalSort').value);
    formData.append('Description', document.getElementById('modalDesc').value);
    formData.append('Updater', document.getElementById('modalUpdater').value);
    formData.append('Last_update', new Date().toISOString().slice(0, 19).replace('T', ' '));
    formData.append('Status', document.getElementById('modalStatus').value);
    formData.append('Site', document.getElementById('modalSite').value);

    // 處理附件
    const attchInput = document.getElementById('modalAttch');
    if (attchInput.files.length > 0) {
        const uploadFormData = new FormData();
        uploadFormData.append('attachment', attchInput.files[0]);
        if (editMode && editingId) {
            uploadFormData.append('data_id', editingId);
        }

        // 顯示上傳中提示
        showToast('上傳附件中...');

        // 先上傳附件
        fetch('upload_attachment.php', {
            method: 'POST',
            body: uploadFormData
        })
        .then(res => res.json())
        .then(json => {
            if (json.success) {
                // 設置附件路徑（使用完整的相對路徑）
                formData.append('Attch', json.url);
                // 提交表單
                submitFormData(formData);
            } else {
                throw new Error(json.error || '附件上傳失敗');
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            showToast(error.message || '附件上傳失敗');
        });
    } else {
        // 如果是編輯模式且附件被刪除
        if (editMode && attchRemoved) {
            formData.append('Attch', '');
        }
        submitFormData(formData);
    }
}

function submitFormData(formData) {
    const url = editMode ? 'bkm_edit.php' : 'bkm_add.php';
    
    // 將 FormData 轉換為 URLSearchParams
    const params = new URLSearchParams();
    for (let [key, value] of formData.entries()) {
        if (value !== null && value !== undefined) {
            params.append(key, value);
        }
    }
    
    // 添加必要的欄位
    if (!params.has('Site')) {
        params.append('Site', DEFAULT_SITE);
    }
    if (!params.has('Status')) {
        params.append('Status', 'BKM needed');
    }
    
    // 顯示提交中提示
    showToast('提交中...');
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params.toString()
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
    })
    .then(json => {
        if (json.success) {
            showToast(editMode ? '更新成功' : '新增成功');
            closeBKMModal();
            loadBKMTable();
        } else {
            throw new Error(json.error || (editMode ? '更新失敗' : '新增失敗'));
        }
    })
    .catch(error => {
        console.error('Submit error:', error);
        showToast(error.message || (editMode ? '更新失敗' : '新增失敗'));
    });
}

function renameAttachment(oldFilename, newId) {
    const formData = new FormData();
    formData.append('old_filename', oldFilename);
    formData.append('new_id', newId);
    
    fetch('rename_attachment.php', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('重命名失敗');
        }
        return res.json();
    })
    .then(json => {
        if (json.success) {
            // 更新資料庫中的檔案路徑
            updateAttachmentPath(newId, json.url);
        } else {
            throw new Error(json.message || '檔案重新命名失敗');
        }
    })
    .catch(error => {
        console.error('Rename error:', error);
        showToast(error.message || '檔案重新命名失敗');
    });
}

function updateAttachmentPath(id, newPath) {
    fetch('update_attachment_path.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}&path=${encodeURIComponent(newPath)}`
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('更新路徑失敗');
        }
        return res.json();
    })
    .then(json => {
        if (json.success) {
            showToast('更新成功');
            loadBKMData();
        } else {
            throw new Error(json.message || '更新檔案路徑失敗');
        }
    })
    .catch(error => {
        console.error('Update path error:', error);
        showToast(error.message || '更新檔案路徑失敗');
    });
}

// 移除附件預覽
function removeAttchPreview() {
    const attchInput = document.getElementById('modalAttch');
    const attchPreviewArea = document.getElementById('attchPreviewArea');
    const oldAttchPath = attchPreviewArea.getAttribute('data-attch-path');
    
    // 如果有旧附件路径，发送请求删除服务器端文件
    if (oldAttchPath) {
        fetch('delete_attachment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'file_path=' + encodeURIComponent(oldAttchPath)
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('刪除失敗');
            }
            return res.json();
        })
        .then(json => {
            if (!json.success) {
                console.error('附件删除失败:', json.error);
            }
        })
        .catch(error => {
            console.error('附件删除请求失败:', error);
        });
    }
    
    attchInput.value = '';
    attchPreviewArea.innerHTML = '';
    attchPreviewArea.removeAttribute('data-attch-path');
    attchRemoved = true;
}

// 重置編輯狀態
function resetEditMode() {
    editMode = false;
    editingId = null;
    attchRemoved = false;
    document.getElementById('bkmModalSubtitle').textContent = '新增資料';
    document.getElementById('bkmAddForm').reset();
    const attchPreviewArea = document.getElementById('attchPreviewArea');
    attchPreviewArea.innerHTML = '';
    attchPreviewArea.removeAttribute('data-attch-path');
}

// 關閉 modal 時重置編輯狀態
document.getElementById('bkmModal').addEventListener('hidden.bs.modal', function () {
    resetEditMode();
});

// 增加 Site 過濾功能
function filterBySite() {
    const selectedSite = document.getElementById('siteFilter').value;
    const filteredData = bkmTableCache.filter(row => {
        if (!selectedSite || selectedSite === ALL_SITES_OPTION) return true; // 如果沒有選擇 Site 或選擇了 ALL，顯示全部
        return row.Site === selectedSite;
    });
    renderBKMTableRows(filteredData);
}

// 修改 searchBKMTable 函數，使其與 Site 過濾協同工作
function searchBKMTable() {
    const searchText = document.getElementById('bkmSearchInput').value.toLowerCase();
    const selectedSite = document.getElementById('siteFilter')?.value;
    
    const filteredData = bkmTableCache.filter(row => {
        const searchMatch = !searchText || 
            (row.Device && row.Device.toLowerCase().includes(searchText)) ||
            (row.SWBin_Issue && row.SWBin_Issue.toLowerCase().includes(searchText)) ||
            (row.Description && row.Description.toLowerCase().includes(searchText));
        const siteMatch = !selectedSite || selectedSite === ALL_SITES_OPTION || row.Site === selectedSite;
        return searchMatch && siteMatch;
    });
    renderBKMTableRows(filteredData);
}

// 修改 cleanSearch 函數，重置所有過濾條件
function cleanSearch() {
    document.getElementById('bkmSearchInput').value = '';
    if (document.getElementById('siteFilter')) {
        document.getElementById('siteFilter').value = ALL_SITES_OPTION;
    }
    renderBKMTableRows(bkmTableCache);
}

// 基本功能函數
function showToast(text) {
    const t = document.getElementById('toast');
    t.textContent = text;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2000);
}

// 取得BKM資料並渲染到表格
let bkmTableCache = [];
function renderBKMTableRows(data) {
    const tbody = document.querySelector('.bkm-table tbody');
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="11" style="text-align:center;color:#aaa;">查無資料</td></tr>';
        return;
    }
    tbody.innerHTML = '';
    data.forEach(row => {
        const descHtml = (row.Description || '').replace(/\n/g, '<br>');
        const attchHtml = (!row.Attch || row.Attch === '[object File]')
            ? '-' 
            : `<img src="..\/..\/Project03\/icons\/attch.png" alt="附件" style="width:20px;height:20px;cursor:pointer;" onclick="viewAttachment(event, '${row.Attch}')">`;
        
        const statusClass = {
            'BKM needed': 'status-needed',
            'BKM finding': 'status-finding',
            'BKM done': 'status-done'
        }[row.Status] || 'status-needed';
        
        // 格式化 ID 为 6 位数
        const formattedId = String(row.ID).padStart(6, '0');
        
        tbody.innerHTML += `
            <tr onclick="viewData(${JSON.stringify(row).replace(/"/g, '&quot;')})">
                <td>${formattedId}</td>
                <td>${row.Site || ''}</td>
                <td>${row.Device || ''}</td>
                <td>${row.SWBin_Issue || ''}</td>
                <td>${row.Sort || ''}</td>
                <td class="desc-col">${descHtml}</td>
                <td>${attchHtml}</td>
                <td><span class="status-tag ${statusClass}">${row.Status || 'BKM needed'}</span></td>
                <td>${row.Updater || ''}</td>
                <td>${row.Last_update || ''}</td>
                <td>
                    <div class="action-menu-wrap">
                        <button class="action-menu-btn" onclick="showGlobalActionMenu(event, ${row.ID})">⋯</button>
                    </div>
                </td>
            </tr>
        `;
    });
}

// 保留新增資料功能的JS結構
function addBKMData(formData) {
    // 這裡未來可用 fetch('bkm_add.php', { method: 'POST', body: formData })
    // 送出後呼叫 loadBKMTable() 重新載入
}

function switchTab(tabName) {
    // 更新標籤按鈕狀態
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`.tab-button[onclick="switchTab('${tabName}')"]`).classList.add('active');

    // 更新內容顯示
    document.querySelectorAll('.tab-content').forEach(content => {
        if(content.classList.contains('active')) {
            content.classList.remove('active');
            content.classList.add('fading');
            setTimeout(() => {
                content.classList.remove('fading');
                content.style.display = 'none';
            }, 350);
        } else {
            content.style.display = 'none';
        }
    });
    const nextTab = document.getElementById(`${tabName}-content`);
    setTimeout(() => {
        nextTab.style.display = 'flex';
        setTimeout(() => {
            nextTab.classList.add('active');
        }, 10);
    }, 350);

    // 更新標題
    const titles = {
        'Main': 'Main',
        'BKM': 'Device Maintain BKM imformation | 維修資訊',
        'Verify': 'Device Verify information | 驗卡資訊',
        'Wafer': 'Wafer control table | 驗卡WAFER管理'
    };
    const titleElement = document.getElementById('currentPageTitle');
    titleElement.style.opacity = '0';
    titleElement.style.transform = 'translateY(-10px)';
    setTimeout(() => {
        titleElement.textContent = titles[tabName] || '';
        titleElement.style.opacity = '1';
        titleElement.style.transform = 'translateY(0)';
    }, 200);
    // 切到BKM分頁時自動刷新表格
    if(tabName === 'BKM') loadBKMTable();
    if (tabName === 'Verify') {
        // loadVerifyTable(); // 預留給未來載入驗卡資料
    }
}

// 添加標題動畫樣式
// 頁面載入自動載入BKM表格

document.addEventListener('DOMContentLoaded', () => {
    const style = document.createElement('style');
    style.textContent = `
        #currentPageTitle {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    `;
    document.head.appendChild(style);
    
    // 預設載入 Verify Tab
    loadVerifyOptions();
});

// JS 控制 modal 開關與送出
let attchRemoved = false;
function openBKMModal() {
  const modal = document.getElementById('bkmModal');
  const subtitle = document.getElementById('bkmModalSubtitle');
  modal.classList.add('show');
  document.getElementById('modalIdInfo').textContent = 'ID: New';
  // 設置標題
  subtitle.textContent = '新增資料';
  // 自動填入當下時間
  const now = new Date();
  const yyyy = now.getFullYear();
  const mm = String(now.getMonth()+1).padStart(2,'0');
  const dd = String(now.getDate()).padStart(2,'0');
  const hh = String(now.getHours()).padStart(2,'0');
  const mi = String(now.getMinutes()).padStart(2,'0');
  const ss = String(now.getSeconds()).padStart(2,'0');
  const nowStr = `${yyyy}-${mm}-${dd} ${hh}:${mi}:${ss}`;
  document.getElementById('modalLastUpdate').value = nowStr;
  // 清空附件預覽與狀態
  const attchInput = document.getElementById('modalAttch');
  const attchPreviewArea = document.getElementById('attchPreviewArea');
  attchInput.value = '';
  attchPreviewArea.innerHTML = '';
  attchRemoved = false;
}
function closeBKMModal() {
    document.getElementById('bkmModal').classList.remove('show');
    document.getElementById('bkmAddForm').reset();
    // 清空附件預覽與狀態
    const attchInput = document.getElementById('modalAttch');
    const attchPreviewArea = document.getElementById('attchPreviewArea');
    attchInput.value = '';
    attchPreviewArea.innerHTML = '';
    attchRemoved = false;
    // 重置編輯狀態
    editMode = false;
    editingId = null;
    // 重置標題
    document.getElementById('bkmModalSubtitle').textContent = '新增資料';
    // 清空 ID 資訊
    document.getElementById('modalIdInfo').textContent = '';
}

// Action bar 新增按鈕加上 onclick="openBKMModal()"
document.querySelector('.bkm-action-btn').setAttribute('onclick', 'openBKMModal()');

// 全域 action menu
if (!document.getElementById('actionMenuGlobal')) {
    const menu = document.createElement('div');
    menu.id = 'actionMenuGlobal';
    menu.className = 'action-menu-list-global';
    menu.innerHTML = `
        <button type="button" onclick="_actionMenuEdit(event)">編輯</button>
        <button type="button" onclick="_actionMenuDelete(event)">刪除</button>
    `;
    document.body.appendChild(menu);
}
let _actionMenuTargetId = null;
function showGlobalActionMenu(e, id) {
    e.stopPropagation();
    _actionMenuTargetId = id;
    const btn = e.currentTarget;
    const menu = document.getElementById('actionMenuGlobal');
    menu.classList.add('show');
    // 計算位置
    const rect = btn.getBoundingClientRect();
    const menuHeight = menu.offsetHeight || 80;
    let top = rect.bottom + 2;
    let left = rect.left;
    // 若下方空間不足，往上展開
    if (top + menuHeight > window.innerHeight && rect.top > menuHeight) {
        top = rect.top - menuHeight - 2;
    }
    // 若右側超出視窗，往左移
    if (left + menu.offsetWidth > window.innerWidth) {
        left = window.innerWidth - menu.offsetWidth - 8;
    }
    menu.style.top = top + 'px';
    menu.style.left = left + 'px';
}
// 點擊外部自動關閉
document.addEventListener('click', function() {
    document.getElementById('actionMenuGlobal').classList.remove('show');
});
// 編輯/刪除功能代理
function _actionMenuEdit(e) {
    e.stopPropagation();
    document.getElementById('actionMenuGlobal').classList.remove('show');
    if (_actionMenuTargetId) editBKM(_actionMenuTargetId);
}
function _actionMenuDelete(e) {
    e.stopPropagation();
    document.getElementById('actionMenuGlobal').classList.remove('show');
    if (_actionMenuTargetId) {
        deleteTargetId = _actionMenuTargetId;
        openDeleteModal();
    }
}

// 編輯/刪除功能預留
let editMode = false;
let editingId = null;
function editBKM(id) {
    fetch('bkm_db.php')
        .then(res => res.json())
        .then(json => {
            if (!json.success) return showToast('資料載入失敗');
            const row = json.data.find(r => r.ID == id);
            if (!row) return showToast('找不到資料');
            
            // 設置標題
            document.getElementById('bkmModalSubtitle').textContent = '編輯資料';
            
            // 填入modal
            document.getElementById('modalSite').value = row.Site || '';
            document.getElementById('modalDevice').value = row.Device || '';
            document.getElementById('modalSWBin').value = row.SWBin_Issue || '';
            document.getElementById('modalSort').value = row.Sort || '';
            document.getElementById('modalDesc').value = row.Description || '';
            document.getElementById('modalStatus').value = row.Status || 'BKM needed';
            document.getElementById('modalUpdater').value = row.Updater || '';
            document.getElementById('modalLastUpdate').value = row.Last_update || '';
            document.getElementById('modalIdInfo').textContent = 'ID: ' + String(row.ID).padStart(6, '0');
            
            // 顯示舊附件
            const attchInput = document.getElementById('modalAttch');
            const attchPreviewArea = document.getElementById('attchPreviewArea');
            attchInput.value = '';
            attchPreviewArea.innerHTML = '';
            if (row.Attch && row.Attch !== '[object File]') {
                const ext = row.Attch.split('.').pop().toLowerCase();
                if(['jpg','jpeg','png','gif','bmp','webp'].includes(ext)) {
                    attchPreviewArea.innerHTML = `<div style='display:inline-block;position:relative;'>
                        <img src='${row.Attch}' style='max-width:120px;max-height:80px;border-radius:6px;border:1px solid #ccc;box-shadow:0 1px 4px rgba(0,0,0,0.08);'>
                        <span onclick='removeAttchPreview()' style='position:absolute;right:-10px;top:-10px;background:#FFA000;color:#fff;font-size:18px;width:24px;height:24px;line-height:24px;text-align:center;border-radius:50%;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,0.12);'>×</span>
                    </div>`;
                    attchPreviewArea.setAttribute('data-attch-path', row.Attch);
                } else if(ext === 'pdf') {
                    attchPreviewArea.innerHTML = `<div style='display:inline-block;position:relative;'>
                        <span style='display:inline-block;width:120px;height:80px;background:#eee;border-radius:6px;line-height:80px;text-align:center;color:#888;font-size:32px;border:1px solid #ccc;'>PDF</span>
                        <span onclick='removeAttchPreview()' style='position:absolute;right:-10px;top:-10px;background:#FFA000;color:#fff;font-size:18px;width:24px;height:24px;line-height:24px;text-align:center;border-radius:50%;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,0.12);'>×</span>
                    </div>`;
                    attchPreviewArea.setAttribute('data-attch-path', row.Attch);
                }
            }
            editMode = true;
            editingId = id;
            document.getElementById('bkmModal').classList.add('show');
        })
        .catch(error => {
            console.error('Edit error:', error);
            showToast('資料載入失敗');
        });
}
function deleteBKM(id) {
    showToast('刪除功能開發中 (ID: ' + id + ')');
}

// 刪除流程
let deleteTargetId = null;
function openDeleteModal() {
    document.getElementById('deleteModal').classList.add('show');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
    deleteTargetId = null;
}
function confirmDeleteBKM() {
    if (!deleteTargetId) return closeDeleteModal();
    // 這裡可呼叫後端API刪除
    fetch('bkm_delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'ID=' + encodeURIComponent(deleteTargetId)
    })
    .then(res => res.json())
    .then(json => {
        if(json.success) {
            showToast('刪除成功');
            loadBKMTable();
        } else {
            showToast(json.error || '刪除失敗');
        }
        closeDeleteModal();
    })
    .catch(() => {
        showToast('刪除失敗');
        closeDeleteModal();
    });
}

// --- 修改: viewAttachment 函式 ---
function viewAttachment(event, url) {
    event.preventDefault();
    event.stopPropagation(); // 阻止事件冒泡
    
    const viewer = document.getElementById('imageViewer');
    const img = document.getElementById('viewerImage');
    const zoomLevel = document.getElementById('zoomLevel');
    
    // 重置缩放
    currentZoom = 1;
    img.style.transform = `scale(${currentZoom})`;
    zoomLevel.style.display = 'none';
    
    img.src = url;
    viewer.style.display = 'flex';
    
    // 触发重排以启动动画
    viewer.offsetHeight;
    viewer.classList.add('show');
    
    // 添加键盘事件监听
    document.addEventListener('keydown', handleKeyPress);
}

function closeImageViewer() {
    const viewer = document.getElementById('imageViewer');
    viewer.classList.remove('show');
    
    // 等待动画完成后隐藏元素
    setTimeout(() => {
        viewer.style.display = 'none';
    }, 300);
    
    document.removeEventListener('keydown', handleKeyPress);
}

function zoomImage(delta) {
    const img = document.getElementById('viewerImage');
    const zoomLevel = document.getElementById('zoomLevel');
    
    // 计算新的缩放值
    const newZoom = Math.max(MIN_ZOOM, Math.min(MAX_ZOOM, currentZoom + delta));
    
    // 如果缩放值没有变化，直接返回
    if (newZoom === currentZoom) return;
    
    currentZoom = newZoom;
    img.style.transform = `scale(${currentZoom})`;
    
    // 显示缩放级别
    zoomLevel.textContent = `${Math.round(currentZoom * 100)}%`;
    zoomLevel.style.display = 'block';
    
    // 2秒后隐藏缩放级别
    clearTimeout(zoomLevel.hideTimeout);
    zoomLevel.hideTimeout = setTimeout(() => {
        zoomLevel.style.display = 'none';
    }, 2000);
}

function handleKeyPress(event) {
    if (event.key === 'Escape') {
        closeImageViewer();
    } else if (event.key === '+' || event.key === '=') {
        zoomImage(ZOOM_STEP);
    } else if (event.key === '-') {
        zoomImage(-ZOOM_STEP);
    }
}

// 点击图片查看器背景关闭
document.getElementById('imageViewer').addEventListener('click', function(event) {
    if (event.target === this) {
        closeImageViewer();
    }
});

// 添加輸入框驗證事件
document.addEventListener('DOMContentLoaded', function() {
    const requiredFields = ['modalSWBin', 'modalSort', 'modalDesc', 'modalUpdater'];
    
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '#ccc';
                this.style.boxShadow = 'none';
            }
        });
    });
});

// 修改 viewData 函數
function viewData(data) {
    // 記錄點擊
    fetch('record_click.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${data.ID}`
    }).catch(error => {
        console.error('記錄點擊失敗:', error);
    });
    
    document.getElementById('viewSite').textContent = data.Site || '';
    document.getElementById('viewDevice').textContent = data.Device || '';
    document.getElementById('viewSWBin').textContent = data.SWBin_Issue || '';
    document.getElementById('viewSort').textContent = data.Sort || '';
    document.getElementById('viewDesc').innerHTML = (data.Description || '').replace(/\n/g, '<br>');
    document.getElementById('viewStatus').innerHTML = `<span class="status-tag ${getStatusClass(data.Status)}">${data.Status || 'BKM needed'}</span>`;
    document.getElementById('viewUpdater').textContent = data.Updater || '';
    document.getElementById('viewLastUpdate').textContent = data.Last_update || '';
    
    const attachmentDiv = document.getElementById('viewAttachment');
    if (data.Attch && data.Attch !== '[object File]') {
        const ext = data.Attch.split('.').pop().toLowerCase();
        if(['jpg','jpeg','png','gif','bmp','webp'].includes(ext)) {
            attachmentDiv.innerHTML = `<img src="${data.Attch}" alt="附件" onclick="viewAttachment(event, '${data.Attch}')" style="cursor:pointer;">`;
        } else if(ext === 'pdf') {
            attachmentDiv.innerHTML = `<div class="pdf-icon" onclick="viewAttachment(event, '${data.Attch}')">點擊預覽 PDF</div>`;
        } else {
            attachmentDiv.innerHTML = '';
        }
    } else {
        attachmentDiv.innerHTML = '';
    }
    
    document.getElementById('viewDataModal').classList.add('show');
}

function closeViewDataModal() {
    document.getElementById('viewDataModal').classList.remove('show');
}

function getStatusClass(status) {
    switch(status) {
        case 'BKM needed': return 'status-needed';
        case 'BKM finding': return 'status-finding';
        case 'BKM done': return 'status-done';
        default: return 'status-needed';
    }
}

// 獲取熱門 Device
function loadHotDevices() {
    // 獲取點擊數據
    fetch('click_counter.php')
        .then(response => response.json())
        .then(clickData => {
            if (!clickData.success) {
                console.error('載入點擊數據失敗:', clickData.error);
                return;
            }

            // 獲取BKM數據
            fetch('bkm_db.php')
                .then(response => response.json())
                .then(bkmData => {
                    if (!bkmData.success) {
                        console.error('載入BKM數據失敗:', bkmData.error);
                        return;
                    }

                    // 計算每個設備的總點擊數
                    const deviceClicks = {};
                    bkmData.data.forEach(item => {
                        const clickInfo = clickData.counts[item.ID];
                        if (clickInfo && clickInfo.count > 0) {
                            deviceClicks[item.Device] = (deviceClicks[item.Device] || 0) + clickInfo.count;
                        }
                    });

                    // 轉換為數組並排序
                    const sortedDevices = Object.entries(deviceClicks)
                        .sort((a, b) => b[1] - a[1])
                        .slice(0, 5);

                    const hotDevicesList = document.getElementById('hotDevicesList');
                    if (sortedDevices.length > 0) {
                        hotDevicesList.innerHTML = sortedDevices.map(([device]) => `
                            <div class="hot-device-item" onclick="filterByDevice('${device}')">
                                <span class="hot-device-name">${device}</span>
                            </div>
                        `).join('');
                    } else {
                        hotDevicesList.innerHTML = '<div class="no-hot-devices">暫無熱門設備</div>';
                    }
                })
                .catch(error => {
                    console.error('載入BKM數據失敗:', error);
                });
        })
        .catch(error => {
            console.error('載入點擊數據失敗:', error);
        });
}

// 按 Device 篩選
function filterByDevice(device) {
    const filtered = bkmTableCache.filter(row => row.Device === device);
    renderBKMTableRows(filtered);
}

// 頁面載入時加載熱門 Device
document.addEventListener('DOMContentLoaded', () => {
    loadBKMTable();
    loadHotDevices();
});

let currentZoom = 1;
const ZOOM_STEP = 0.1;
const MAX_ZOOM = 3;
const MIN_ZOOM = 0.5;

// 附件預覽相關函數
function previewAttachment(input) {
    const previewArea = document.getElementById('attchPreviewArea');
    previewArea.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileType = file.type;
        
        // 創建預覽容器
        const previewContainer = document.createElement('div');
        previewContainer.className = 'attachment-preview-container';
        
        if (fileType.startsWith('image/')) {
            // 圖片預覽
            const img = document.createElement('img');
            img.className = 'attachment-preview-image';
            img.file = file;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            previewContainer.appendChild(img);
        } else if (fileType === 'application/pdf') {
            // PDF 預覽
            const pdfIcon = document.createElement('div');
            pdfIcon.className = 'pdf-preview-icon';
            pdfIcon.innerHTML = '📄';
            previewContainer.appendChild(pdfIcon);
        }
        
        // 添加文件名和刪除按鈕
        const fileInfo = document.createElement('div');
        fileInfo.className = 'attachment-file-info';
        fileInfo.innerHTML = `
            <span class="file-name">${file.name}</span>
            <button type="button" class="remove-attachment" onclick="removeAttachment()">×</button>
        `;
        previewContainer.appendChild(fileInfo);
        
        previewArea.appendChild(previewContainer);
    }
}

// 移除附件
function removeAttachment() {
    const attchInput = document.getElementById('modalAttch');
    const previewArea = document.getElementById('attchPreviewArea');
    
    attchInput.value = '';
    previewArea.innerHTML = '';
    attchRemoved = true;
}

// --- Verify Tab Functions (Placeholders) ---
function searchVerifyTable() {
    showToast('搜尋驗卡功能開發中...');
}

function cleanVerifySearch() {
    document.getElementById('verifySearchInput').value = '';
    showToast('清除搜尋');
}

function openVerifyModal() {
    showToast('新增驗卡資料功能開發中...');
}

// JS 控制 modal 開關與送出
let attchRemoved = false;
function openBKMModal() {
  const modal = document.getElementById('bkmModal');
  const subtitle = document.getElementById('bkmModalSubtitle');
  modal.classList.add('show');
  document.getElementById('modalIdInfo').textContent = 'ID: New';
  // 設置標題
  subtitle.textContent = '新增資料';
  // 自動填入當下時間
  const now = new Date();
  const yyyy = now.getFullYear();
  const mm = String(now.getMonth()+1).padStart(2,'0');
  const dd = String(now.getDate()).padStart(2,'0');
  const hh = String(now.getHours()).padStart(2,'0');
  const mi = String(now.getMinutes()).padStart(2,'0');
  const ss = String(now.getSeconds()).padStart(2,'0');
  const nowStr = `${yyyy}-${mm}-${dd} ${hh}:${mi}:${ss}`;
  document.getElementById('modalLastUpdate').value = nowStr;
  // 清空附件預覽與狀態
  const attchInput = document.getElementById('modalAttch');
  const attchPreviewArea = document.getElementById('attchPreviewArea');
  attchInput.value = '';
  attchPreviewArea.innerHTML = '';
  attchRemoved = false;
}
function closeBKMModal() {
    document.getElementById('bkmModal').classList.remove('show');
    document.getElementById('bkmAddForm').reset();
    // 清空附件預覽與狀態
    const attchInput = document.getElementById('modalAttch');
    const attchPreviewArea = document.getElementById('attchPreviewArea');
    attchInput.value = '';
    attchPreviewArea.innerHTML = '';
    attchRemoved = false;
    // 重置編輯狀態
    editMode = false;
    editingId = null;
    // 重置標題
    document.getElementById('bkmModalSubtitle').textContent = '新增資料';
    // 清空 ID 資訊
    document.getElementById('modalIdInfo').textContent = '';
}

// Action bar 新增按鈕加上 onclick="openBKMModal()"
document.querySelector('.bkm-action-btn').setAttribute('onclick', 'openBKMModal()');

// 全域 action menu
if (!document.getElementById('actionMenuGlobal')) {
    const menu = document.createElement('div');
    menu.id = 'actionMenuGlobal';
    menu.className = 'action-menu-list-global';
    menu.innerHTML = `
        <button type="button" onclick="_actionMenuEdit(event)">編輯</button>
        <button type="button" onclick="_actionMenuDelete(event)">刪除</button>
    `;
    document.body.appendChild(menu);
}
let _actionMenuTargetId = null;
function showGlobalActionMenu(e, id) {
    e.stopPropagation();
    _actionMenuTargetId = id;
    const btn = e.currentTarget;
    const menu = document.getElementById('actionMenuGlobal');
    menu.classList.add('show');
    // 計算位置
    const rect = btn.getBoundingClientRect();
    const menuHeight = menu.offsetHeight || 80;
    let top = rect.bottom + 2;
    let left = rect.left;
    // 若下方空間不足，往上展開
    if (top + menuHeight > window.innerHeight && rect.top > menuHeight) {
        top = rect.top - menuHeight - 2;
    }
    // 若右側超出視窗，往左移
    if (left + menu.offsetWidth > window.innerWidth) {
        left = window.innerWidth - menu.offsetWidth - 8;
    }
    menu.style.top = top + 'px';
    menu.style.left = left + 'px';
}
// 點擊外部自動關閉
document.addEventListener('click', function() {
    document.getElementById('actionMenuGlobal').classList.remove('show');
});
// 編輯/刪除功能代理
function _actionMenuEdit(e) {
    e.stopPropagation();
    document.getElementById('actionMenuGlobal').classList.remove('show');
    if (_actionMenuTargetId) editBKM(_actionMenuTargetId);
}
function _actionMenuDelete(e) {
    e.stopPropagation();
    document.getElementById('actionMenuGlobal').classList.remove('show');
    if (_actionMenuTargetId) {
        deleteTargetId = _actionMenuTargetId;
        openDeleteModal();
    }
}

// 編輯/刪除功能預留
let editMode = false;
let editingId = null;
function editBKM(id) {
    fetch('bkm_db.php')
        .then(res => res.json())
        .then(json => {
            if (!json.success) return showToast('資料載入失敗');
            const row = json.data.find(r => r.ID == id);
            if (!row) return showToast('找不到資料');
            
            // 設置標題
            document.getElementById('bkmModalSubtitle').textContent = '編輯資料';
            
            // 填入modal
            document.getElementById('modalSite').value = row.Site || '';
            document.getElementById('modalDevice').value = row.Device || '';
            document.getElementById('modalSWBin').value = row.SWBin_Issue || '';
            document.getElementById('modalSort').value = row.Sort || '';
            document.getElementById('modalDesc').value = row.Description || '';
            document.getElementById('modalStatus').value = row.Status || 'BKM needed';
            document.getElementById('modalUpdater').value = row.Updater || '';
            document.getElementById('modalLastUpdate').value = row.Last_update || '';
            document.getElementById('modalIdInfo').textContent = 'ID: ' + String(row.ID).padStart(6, '0');
            
            // 顯示舊附件
            const attchInput = document.getElementById('modalAttch');
            const attchPreviewArea = document.getElementById('attchPreviewArea');
            attchInput.value = '';
            attchPreviewArea.innerHTML = '';
            if (row.Attch && row.Attch !== '[object File]') {
                const ext = row.Attch.split('.').pop().toLowerCase();
                if(['jpg','jpeg','png','gif','bmp','webp'].includes(ext)) {
                    attchPreviewArea.innerHTML = `<div style='display:inline-block;position:relative;'>
                        <img src='${row.Attch}' style='max-width:120px;max-height:80px;border-radius:6px;border:1px solid #ccc;box-shadow:0 1px 4px rgba(0,0,0,0.08);'>
                        <span onclick='removeAttchPreview()' style='position:absolute;right:-10px;top:-10px;background:#FFA000;color:#fff;font-size:18px;width:24px;height:24px;line-height:24px;text-align:center;border-radius:50%;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,0.12);'>×</span>
                    </div>`;
                    attchPreviewArea.setAttribute('data-attch-path', row.Attch);
                } else if(ext === 'pdf') {
                    attchPreviewArea.innerHTML = `<div style='display:inline-block;position:relative;'>
                        <span style='display:inline-block;width:120px;height:80px;background:#eee;border-radius:6px;line-height:80px;text-align:center;color:#888;font-size:32px;border:1px solid #ccc;'>PDF</span>
                        <span onclick='removeAttchPreview()' style='position:absolute;right:-10px;top:-10px;background:#FFA000;color:#fff;font-size:18px;width:24px;height:24px;line-height:24px;text-align:center;border-radius:50%;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,0.12);'>×</span>
                    </div>`;
                    attchPreviewArea.setAttribute('data-attch-path', row.Attch);
                }
            }
            editMode = true;
            editingId = id;
            document.getElementById('bkmModal').classList.add('show');
        })
        .catch(error => {
            console.error('Edit error:', error);
            showToast('資料載入失敗');
        });
}
function deleteBKM(id) {
    showToast('刪除功能開發中 (ID: ' + id + ')');
}

// 刪除流程
let deleteTargetId = null;
function openDeleteModal() {
    document.getElementById('deleteModal').classList.add('show');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
    deleteTargetId = null;
}
function confirmDeleteBKM() {
    if (!deleteTargetId) return closeDeleteModal();
    // 這裡可呼叫後端API刪除
    fetch('bkm_delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'ID=' + encodeURIComponent(deleteTargetId)
    })
    .then(res => res.json())
    .then(json => {
        if(json.success) {
            showToast('刪除成功');
            loadBKMTable();
        } else {
            showToast(json.error || '刪除失敗');
        }
        closeDeleteModal();
    })
    .catch(() => {
        showToast('刪除失敗');
        closeDeleteModal();
    });
}

// --- 修改: viewAttachment 函式 ---
function viewAttachment(event, url) {
    event.preventDefault();
    event.stopPropagation(); // 阻止事件冒泡
    
    const viewer = document.getElementById('imageViewer');
    const img = document.getElementById('viewerImage');
    const zoomLevel = document.getElementById('zoomLevel');
    
    // 重置缩放
    currentZoom = 1;
    img.style.transform = `scale(${currentZoom})`;
    zoomLevel.style.display = 'none';
    
    img.src = url;
    viewer.style.display = 'flex';
    
    // 触发重排以启动动画
    viewer.offsetHeight;
    viewer.classList.add('show');
    
    // 添加键盘事件监听
    document.addEventListener('keydown', handleKeyPress);
}

function closeImageViewer() {
    const viewer = document.getElementById('imageViewer');
    viewer.classList.remove('show');
    
    // 等待动画完成后隐藏元素
    setTimeout(() => {
        viewer.style.display = 'none';
    }, 300);
    
    document.removeEventListener('keydown', handleKeyPress);
}

function zoomImage(delta) {
    const img = document.getElementById('viewerImage');
    const zoomLevel = document.getElementById('zoomLevel');
    
    // 计算新的缩放值
    const newZoom = Math.max(MIN_ZOOM, Math.min(MAX_ZOOM, currentZoom + delta));
    
    // 如果缩放值没有变化，直接返回
    if (newZoom === currentZoom) return;
    
    currentZoom = newZoom;
    img.style.transform = `scale(${currentZoom})`;
    
    // 显示缩放级别
    zoomLevel.textContent = `${Math.round(currentZoom * 100)}%`;
    zoomLevel.style.display = 'block';
    
    // 2秒后隐藏缩放级别
    clearTimeout(zoomLevel.hideTimeout);
    zoomLevel.hideTimeout = setTimeout(() => {
        zoomLevel.style.display = 'none';
    }, 2000);
}

function handleKeyPress(event) {
    if (event.key === 'Escape') {
        closeImageViewer();
    } else if (event.key === '+' || event.key === '=') {
        zoomImage(ZOOM_STEP);
    } else if (event.key === '-') {
        zoomImage(-ZOOM_STEP);
    }
}

// 点击图片查看器背景关闭
document.getElementById('imageViewer').addEventListener('click', function(event) {
    if (event.target === this) {
        closeImageViewer();
    }
});

// 添加輸入框驗證事件
document.addEventListener('DOMContentLoaded', function() {
    const requiredFields = ['modalSWBin', 'modalSort', 'modalDesc', 'modalUpdater'];
    
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '#ccc';
                this.style.boxShadow = 'none';
            }
        });
    });
});

// 修改 viewData 函數
function viewData(data) {
    // 記錄點擊
    fetch('record_click.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${data.ID}`
    }).catch(error => {
        console.error('記錄點擊失敗:', error);
    });
    
    document.getElementById('viewSite').textContent = data.Site || '';
    document.getElementById('viewDevice').textContent = data.Device || '';
    document.getElementById('viewSWBin').textContent = data.SWBin_Issue || '';
    document.getElementById('viewSort').textContent = data.Sort || '';
    document.getElementById('viewDesc').innerHTML = (data.Description || '').replace(/\n/g, '<br>');
    document.getElementById('viewStatus').innerHTML = `<span class="status-tag ${getStatusClass(data.Status)}">${data.Status || 'BKM needed'}</span>`;
    document.getElementById('viewUpdater').textContent = data.Updater || '';
    document.getElementById('viewLastUpdate').textContent = data.Last_update || '';
    
    const attachmentDiv = document.getElementById('viewAttachment');
    if (data.Attch && data.Attch !== '[object File]') {
        const ext = data.Attch.split('.').pop().toLowerCase();
        if(['jpg','jpeg','png','gif','bmp','webp'].includes(ext)) {
            attachmentDiv.innerHTML = `<img src="${data.Attch}" alt="附件" onclick="viewAttachment(event, '${data.Attch}')" style="cursor:pointer;">`;
        } else if(ext === 'pdf') {
            attachmentDiv.innerHTML = `<div class="pdf-icon" onclick="viewAttachment(event, '${data.Attch}')">點擊預覽 PDF</div>`;
        } else {
            attachmentDiv.innerHTML = '';
        }
    } else {
        attachmentDiv.innerHTML = '';
    }
    
    document.getElementById('viewDataModal').classList.add('show');
}

function closeViewDataModal() {
    document.getElementById('viewDataModal').classList.remove('show');
}

function getStatusClass(status) {
    switch(status) {
        case 'BKM needed': return 'status-needed';
        case 'BKM finding': return 'status-finding';
        case 'BKM done': return 'status-done';
        default: return 'status-needed';
    }
}

// 獲取熱門 Device
function loadHotDevices() {
    // 獲取點擊數據
    fetch('click_counter.php')
        .then(response => response.json())
        .then(clickData => {
            if (!clickData.success) {
                console.error('載入點擊數據失敗:', clickData.error);
                return;
            }

            // 獲取BKM數據
            fetch('bkm_db.php')
                .then(response => response.json())
                .then(bkmData => {
                    if (!bkmData.success) {
                        console.error('載入BKM數據失敗:', bkmData.error);
                        return;
                    }

                    // 計算每個設備的總點擊數
                    const deviceClicks = {};
                    bkmData.data.forEach(item => {
                        const clickInfo = clickData.counts[item.ID];
                        if (clickInfo && clickInfo.count > 0) {
                            deviceClicks[item.Device] = (deviceClicks[item.Device] || 0) + clickInfo.count;
                        }
                    });

                    // 轉換為數組並排序
                    const sortedDevices = Object.entries(deviceClicks)
                        .sort((a, b) => b[1] - a[1])
                        .slice(0, 5);

                    const hotDevicesList = document.getElementById('hotDevicesList');
                    if (sortedDevices.length > 0) {
                        hotDevicesList.innerHTML = sortedDevices.map(([device]) => `
                            <div class="hot-device-item" onclick="filterByDevice('${device}')">
                                <span class="hot-device-name">${device}</span>
                            </div>
                        `).join('');
                    } else {
                        hotDevicesList.innerHTML = '<div class="no-hot-devices">暫無熱門設備</div>';
                    }
                })
                .catch(error => {
                    console.error('載入BKM數據失敗:', error);
                });
        })
        .catch(error => {
            console.error('載入點擊數據失敗:', error);
        });
}

// 按 Device 篩選
function filterByDevice(device) {
    const filtered = bkmTableCache.filter(row => row.Device === device);
    renderBKMTableRows(filtered);
}

// 頁面載入時加載熱門 Device
document.addEventListener('DOMContentLoaded', () => {
    loadBKMTable();
    loadHotDevices();
});

let currentZoom = 1;
const ZOOM_STEP = 0.1;
const MAX_ZOOM = 3;
const MIN_ZOOM = 0.5;

// 附件預覽相關函數
function previewAttachment(input) {
    const previewArea = document.getElementById('attchPreviewArea');
    previewArea.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileType = file.type;
        
        // 創建預覽容器
        const previewContainer = document.createElement('div');
        previewContainer.className = 'attachment-preview-container';
        
        if (fileType.startsWith('image/')) {
            // 圖片預覽
            const img = document.createElement('img');
            img.className = 'attachment-preview-image';
            img.file = file;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            previewContainer.appendChild(img);
        } else if (fileType === 'application/pdf') {
            // PDF 預覽
            const pdfIcon = document.createElement('div');
            pdfIcon.className = 'pdf-preview-icon';
            pdfIcon.innerHTML = '📄';
            previewContainer.appendChild(pdfIcon);
        }
        
        // 添加文件名和刪除按鈕
        const fileInfo = document.createElement('div');
        fileInfo.className = 'attachment-file-info';
        fileInfo.innerHTML = `
            <span class="file-name">${file.name}</span>
            <button type="button" class="remove-attachment" onclick="removeAttachment()">×</button>
        `;
        previewContainer.appendChild(fileInfo);
        
        previewArea.appendChild(previewContainer);
    }
}

// 移除附件
function removeAttachment() {
    const attchInput = document.getElementById('modalAttch');
    const previewArea = document.getElementById('attchPreviewArea');
    
    attchInput.value = '';
    previewArea.innerHTML = '';
    attchRemoved = true;
}

// --- Verify Tab Functions (Placeholders) ---
function searchVerifyTable() {
    showToast('搜尋驗卡功能開發中...');
}

function cleanVerifySearch() {
    document.getElementById('verifySearchInput').value = '';
    showToast('清除搜尋');
}

function openVerifyModal() {
    showToast('新增驗卡資料功能開發中...');
}

// JS 控制 modal 開關與送出
let attchRemoved = false;
function openBKMModal() {
  const modal = document.getElementById('bkmModal');
  const subtitle = document.getElementById('bkmModalSubtitle');
  modal.classList.add('show');
  document.getElementById('modalIdInfo').textContent = 'ID: New';
  // 設置標題
  subtitle.textContent = '新增資料';
  // 自動填入當下時間
  const now = new Date();
  const yyyy = now.getFullYear();
  const mm = String(now.getMonth()+1).padStart(2,'0');
  const dd = String(now.getDate()).padStart(2,'0');
  const hh = String(now.getHours()).padStart(2,'0');
  const mi = String(now.getMinutes()).padStart(2,'0');
  const ss = String(now.getSeconds()).padStart(2,'0');
  const nowStr = `${yyyy}-${mm}-${dd} ${hh}:${mi}:${ss}`;
  document.getElementById('modalLastUpdate').value = nowStr;
  // 清空附件預覽與狀態
  const attchInput = document.getElementById('modalAttch');
  const attchPreviewArea = document.getElementById('attchPreviewArea');
  attchInput.value = '';
  attchPreviewArea.innerHTML = '';
  attchRemoved = false;
}
function closeBKMModal() {
    document.getElementById('bkmModal').classList.remove('show');
    document.getElementById('bkmAddForm').reset();
    // 清空附件預覽與狀態
    const attchInput = document.getElementById('modalAttch');
    const attchPreviewArea = document.getElementById('attchPreviewArea');
    attchInput.value = '';
    attchPreviewArea.innerHTML = '';
    attchRemoved = false;
    // 重置編輯狀態
    editMode = false;
    editingId = null;
    // 重置標題
    document.getElementById('bkmModalSubtitle').textContent = '新增資料';
    // 清空 ID 資訊
    document.getElementById('modalIdInfo').textContent = '';
}

// Action bar 新增按鈕加上 onclick="openBKMModal()"
document.querySelector('.bkm-action-btn').setAttribute('onclick', 'openBKMModal()');

// 全域 action menu
if (!document.getElementById('actionMenuGlobal')) {
    const menu = document.createElement('div');
    menu.id = 'actionMenuGlobal';
    menu.className = 'action-menu-list-global';
    menu.innerHTML = `
        <button type="button" onclick="_actionMenuEdit(event)">編輯</button>
        <button type="button" onclick="_actionMenuDelete(event)">刪除</button>
    `;
    document.body.appendChild(menu);
}
let _actionMenuTargetId = null;
function showGlobalActionMenu(e, id) {
    e.stopPropagation();
    _actionMenuTargetId = id;
    const btn = e.currentTarget;
    const menu = document.getElementById('actionMenuGlobal');
    menu.classList.add('show');
    // 計算位置
    const rect = btn.getBoundingClientRect();
    const menuHeight = menu.offsetHeight || 80;
    let top = rect.bottom + 2;
    let left = rect.left;
    // 若下方空間不足，往上展開
    if (top + menuHeight > window.innerHeight && rect.top > menuHeight) {
        top = rect.top - menuHeight - 2;
    }
    // 若右側超出視窗，往左移
    if (left + menu.offsetWidth > window.innerWidth) {
        left = window.innerWidth - menu.offsetWidth - 8;
    }
    menu.style.top = top + 'px';
    menu.style.left = left + 'px';
}
// 點擊外部自動關閉
document.addEventListener('click', function() {
    document.getElementById('actionMenuGlobal').classList.remove('show');
});
// 編輯/刪除功能代理
function _actionMenuEdit(e) {
    e.stopPropagation();
    document.getElementById('actionMenuGlobal').classList.remove('show');
    if (_actionMenuTargetId) editBKM(_actionMenuTargetId);
}
function _actionMenuDelete(e) {
    e.stopPropagation();
    document.getElementById('actionMenuGlobal').classList.remove('show');
    if (_actionMenuTargetId) {
        deleteTargetId = _actionMenuTargetId;
        openDeleteModal();
    }
}

// 編輯/刪除功能預留
let editMode = false;
let editingId = null;
function editBKM(id) {
    fetch('bkm_db.php')
        .then(res => res.json())
        .then(json => {
            if (!json.success) return showToast('資料載入失敗');
            const row = json.data.find(r => r.ID == id);
            if (!row) return showToast('找不到資料');
            
            // 設置標題
            document.getElementById('bkmModalSubtitle').textContent = '編輯資料';
            
            // 填入modal
            document.getElementById('modalSite').value = row.Site || '';
            document.getElementById('modalDevice').value = row.Device || '';
            document.getElementById('modalSWBin').value = row.SWBin_Issue || '';
            document.getElementById('modalSort').value = row.Sort || '';
            document.getElementById('modalDesc').value = row.Description || '';
            document.getElementById('modalStatus').value = row.Status || 'BKM needed';
            document.getElementById('modalUpdater').value = row.Updater || '';
            document.getElementById('modalLastUpdate').value = row.Last_update || '';
            document.getElementById('modalIdInfo').textContent = 'ID: ' + String(row.ID).padStart(6, '0');
            
            // 顯示舊附件
            const attchInput = document.getElementById('modalAttch');
            const attchPreviewArea = document.getElementById('attchPreviewArea');
            attchInput.value = '';
            attchPreviewArea.innerHTML = '';
            if (row.Attch && row.Attch !== '[object File]') {
                const ext = row.Attch.split('.').pop().toLowerCase();
                if(['jpg','jpeg','png','gif','bmp','webp'].includes(ext)) {
                    attchPreviewArea.innerHTML = `<div style='display:inline-block;position:relative;'>
                        <img src='${row.Attch}' style='max-width:120px;max-height:80px;border-radius:6px;border:1px solid #ccc;box-shadow:0 1px 4px rgba(0,0,0,0.08);'>
                        <span onclick='removeAttchPreview()' style='position:absolute;right:-10px;top:-10px;background:#FFA000;color:#fff;font-size:18px;width:24px;height:24px;line-height:24px;text-align:center;border-radius:50%;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,0.12);'>×</span>
                    </div>`;
                    attchPreviewArea.setAttribute('data-attch-path', row.Attch);
                } else if(ext === 'pdf') {
                    attchPreviewArea.innerHTML = `<div style='display:inline-block;position:relative;'>
                        <span style='display:inline-block;width:120px;height:80px;background:#eee;border-radius:6px;line-height:80px;text-align:center;color:#888;font-size:32px;border:1px solid #ccc;'>PDF</span>
                        <span onclick='removeAttchPreview()' style='position:absolute;right:-10px;top:-10px;background:#FFA000;color:#fff;font-size:18px;width:24px;height:24px;line-height:24px;text-align:center;border-radius:50%;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,0.12);'>×</span>
                    </div>`;
                    attchPreviewArea.setAttribute('data-attch-path', row.Attch);
                }
            }
            editMode = true;
            editingId = id;
            document.getElementById('bkmModal').classList.add('show');
        })
        .catch(error => {
            console.error('Edit error:', error);
            showToast('資料載入失敗');
        });
}
function deleteBKM(id) {
    showToast('刪除功能開發中 (ID: ' + id + ')');
}

// 刪除流程
let deleteTargetId = null;
function openDeleteModal() {
    document.getElementById('deleteModal').classList.add('show');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
    deleteTargetId = null;
}
function confirmDeleteBKM() {
    if (!deleteTargetId) return closeDeleteModal();
    // 這裡可呼叫後端API刪除
    fetch('bkm_delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'ID=' + encodeURIComponent(deleteTargetId)
    })
    .then(res => res.json())
    .then(json => {
        if(json.success) {
            showToast('刪除成功');
            loadBKMTable();
        } else {
            showToast(json.error || '刪除失敗');
        }
        closeDeleteModal();
    })
    .catch(() => {
        showToast('刪除失敗');
        closeDeleteModal();
    });
}

// --- 修改: viewAttachment 函式 ---
function viewAttachment(event, url) {
    event.preventDefault();
    event.stopPropagation(); // 阻止事件冒泡
    
    const viewer = document.getElementById('imageViewer');
    const img = document.getElementById('viewerImage');
    const zoomLevel = document.getElementById('zoomLevel');
    
    // 重置缩放
    currentZoom = 1;
    img.style.transform = `scale(${currentZoom})`;
    zoomLevel.style.display = 'none';
    
    img.src = url;
    viewer.style.display = 'flex';
    
    // 触发重排以启动动画
    viewer.offsetHeight;
    viewer.classList.add('show');
    
    // 添加键盘事件监听
    document.addEventListener('keydown', handleKeyPress);
}

function closeImageViewer() {
    const viewer = document.getElementById('imageViewer');
    viewer.classList.remove('show');
    
    // 等待动画完成后隐藏元素
    setTimeout(() => {
        viewer.style.display = 'none';
    }, 300);
    
    document.removeEventListener('keydown', handleKeyPress);
}

function zoomImage(delta) {
    const img = document.getElementById('viewerImage');
    const zoomLevel = document.getElementById('zoomLevel');
    
    // 计算新的缩放值
    const newZoom = Math.max(MIN_ZOOM, Math.min(MAX_ZOOM, currentZoom + delta));
    
    // 如果缩放值没有变化，直接返回
    if (newZoom === currentZoom) return;
    
    currentZoom = newZoom;
    img.style.transform = `scale(${currentZoom})`;
    
    // 显示缩放级别
    zoomLevel.textContent = `${Math.round(currentZoom * 100)}%`;
    zoomLevel.style.display = 'block';
    
    // 2秒后隐藏缩放级别
    clearTimeout(zoomLevel.hideTimeout);
    zoomLevel.hideTimeout = setTimeout(() => {
        zoomLevel.style.display = 'none';
    }, 2000);
}

function handleKeyPress(event) {
    if (event.key === 'Escape') {
        closeImageViewer();
    } else if (event.key === '+' || event.key === '=') {
        zoomImage(ZOOM_STEP);
    } else if (event.key === '-') {
        zoomImage(-ZOOM_STEP);
    }
}

// 点击图片查看器背景关闭
document.getElementById('imageViewer').addEventListener('click', function(event) {
    if (event.target === this) {
        closeImageViewer();
    }
});

// 添加輸入框驗證事件
document.addEventListener('DOMContentLoaded', function() {
    const requiredFields = ['modalSWBin', 'modalSort', 'modalDesc', 'modalUpdater'];
    
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '#ccc';
                this.style.boxShadow = 'none';
            }
        });
    });
});

// 修改 viewData 函數
function viewData(data) {
    // 記錄點擊
    fetch('record_click.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${data.ID}`
    }).catch(error => {
        console.error('記錄點擊失敗:', error);
    });
    
    document.getElementById('viewSite').textContent = data.Site || '';
    document.getElementById('viewDevice').textContent = data.Device || '';
    document.getElementById('viewSWBin').textContent = data.SWBin_Issue || '';
    document.getElementById('viewSort').textContent = data.Sort || '';
    document.getElementById('viewDesc').innerHTML = (data.Description || '').replace(/\n/g, '<br>');
    document.getElementById('viewStatus').innerHTML = `<span class="status-tag ${getStatusClass(data.Status)}">${data.Status || 'BKM needed'}</span>`;
    document.getElementById('viewUpdater').textContent = data.Updater || '';
    document.getElementById('viewLastUpdate').textContent = data.Last_update || '';
    
    const attachmentDiv = document.getElementById('viewAttachment');
    if (data.Attch && data.Attch !== '[object File]') {
        const ext = data.Attch.split('.').pop().toLowerCase();
        if(['jpg','jpeg','png','gif','bmp','webp'].includes(ext)) {
            attachmentDiv.innerHTML = `<img src="${data.Attch}" alt="附件" onclick="viewAttachment(event, '${data.Attch}')" style="cursor:pointer;">`;
        } else if(ext === 'pdf') {
            attachmentDiv.innerHTML = `<div class="pdf-icon" onclick="viewAttachment(event, '${data.Attch}')">點擊預覽 PDF</div>`;
        } else {
            attachmentDiv.innerHTML = '';
        }
    } else {
        attachmentDiv.innerHTML = '';
    }
    
    document.getElementById('viewDataModal').classList.add('show');
}

function closeViewDataModal() {
    document.getElementById('viewDataModal').classList.remove('show');
}

function getStatusClass(status) {
    switch(status) {
        case 'BKM needed': return 'status-needed';
        case 'BKM finding': return 'status-finding';
        case 'BKM done': return 'status-done';
        default: return 'status-needed';
    }
}

// 獲取熱門 Device
function loadHotDevices() {
    // 獲取點擊數據
    fetch('click_counter.php')
        .then(response => response.json())
        .then(clickData => {
            if (!clickData.success) {
                console.error('載入點擊數據失敗:', clickData.error);
                return;
            }

            // 獲取BKM數據
            fetch('bkm_db.php')
                .then(response => response.json())
                .then(bkmData => {
                    if (!bkmData.success) {
                        console.error('載入BKM數據失敗:', bkmData.error);
                        return;
                    }

                    // 計算每個設備的總點擊數
                    const deviceClicks = {};
                    bkmData.data.forEach(item => {
                        const clickInfo = clickData.counts[item.ID];
                        if (clickInfo && clickInfo.count > 0) {
                            deviceClicks[item.Device] = (deviceClicks[item.Device] || 0) + clickInfo.count;
                        }
                    });

                    // 轉換為數組並排序
                    const sortedDevices = Object.entries(deviceClicks)
                        .sort((a, b) => b[1] - a[1])
                        .slice(0, 5);

                    const hotDevicesList = document.getElementById('hotDevicesList');
                    if (sortedDevices.length > 0) {
                        hotDevicesList.innerHTML = sortedDevices.map(([device]) => `
                            <div class="hot-device-item" onclick="filterByDevice('${device}')">
                                <span class="hot-device-name">${device}</span>
                            </div>
                        `).join('');
                    } else {
                        hotDevicesList.innerHTML = '<div class="no-hot-devices">暫無熱門設備</div>';
                    }
                })
                .catch(error => {
                    console.error('載入BKM數據失敗:', error);
                });
        })
        .catch(error => {
            console.error('載入點擊數據失敗:', error);
        });
}

// 按 Device 篩選
function filterByDevice(device) {
    const filtered = bkmTableCache.filter(row => row.Device === device);
    renderBKMTableRows(filtered);
}

// 頁面載入時加載熱門 Device
document.addEventListener('DOMContentLoaded', () => {
    loadBKMTable();
    loadHotDevices();
});

let currentZoom = 1;
const ZOOM_STEP = 0.1;
const MAX_ZOOM = 3;
const MIN_ZOOM = 0.5;

// 附件預覽相關函數
function previewAttachment(input) {
    const previewArea = document.getElementById('attchPreviewArea');
    previewArea.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileType = file.type;
        
        // 創建預覽容器
        const previewContainer = document.createElement('div');
        previewContainer.className = 'attachment-preview-container';
        
        if (fileType.startsWith('image/')) {
            // 圖片預覽
            const img = document.createElement('img');
            img.className = 'attachment-preview-image';
            img.file = file;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            previewContainer.appendChild(img);
        } else if (fileType === 'application/pdf') {
            // PDF 預覽
            const pdfIcon = document.createElement('div');
            pdfIcon.className = 'pdf-preview-icon';
            pdfIcon.innerHTML = '📄';
            previewContainer.appendChild(pdfIcon);
        }
        
        // 添加文件名和刪除按鈕
        const fileInfo = document.createElement('div');
        fileInfo.className = 'attachment-file-info';
        fileInfo.innerHTML = `
            <span class="file-name">${file.name}</span>
            <button type="button" class="remove-attachment" onclick="removeAttachment()">×</button>
        `;
        previewContainer.appendChild(fileInfo);
        
        previewArea.appendChild(previewContainer);
    }
}

// 移除附件
function removeAttachment() {
    const attchInput = document.getElementById('modalAttch');
    const previewArea = document.getElementById('attchPreviewArea');
    
    attchInput.value = '';
    previewArea.innerHTML = '';
    attchRemoved = true;
}

// --- Verify Tab Functions (Placeholders) ---
function searchVerifyTable() {
    showToast('搜尋驗卡功能開發中...');
}

function cleanVerifySearch() {
    document.getElementById('verifySearchInput').value = '';
    showToast('清除搜尋');
}

function openVerifyModal() {
    showToast('新增驗卡資料功能開發中...');
}

// JS 控制 modal 開關與送出
let attchRemoved = false;
// ... existing code ...
// ... existing code ...
function removeAttachment() {
    const attchInput = document.getElementById('modalAttch');
    const previewArea = document.getElementById('attchPreviewArea');
    
    attchInput.value = '';
    previewArea.innerHTML = '';
    attchRemoved = true;
}

// --- Verify Tab Functions ---

function loadVerifyOptions() {
    fetch('verify_options.php')
        .then(response => response.json())
        .then(options => {
            const selects = {
                'clean_pad_type': options.clean_pad_type,
                'verify_sort': options.verify_sort,
                'verify_method': options.verify_method,
                'rule_verify_pass': options.rule_verify_pass,
                'rule_contact_window': options.rule_contact_window,
                'rule_dib_check': options.rule_dib_check,
            };

            for (const id in selects) {
                const selectElement = document.getElementById(id);
                if (selectElement) {
                    selectElement.innerHTML = '<option value="">請選擇</option>';
                    selects[id].forEach(optionText => {
                        const option = document.createElement('option');
                        option.value = optionText;
                        option.textContent = optionText;
                        selectElement.appendChild(option);
                    });
                }
            }
        })
        .catch(error => console.error('Error loading verify options:', error));
}

function openVerifyModal(data) {
    console.log('openVerifyModal called');
    try {
        const modal = document.getElementById('verifyModal');
        if (!modal) {
            console.error('Modal element not found!');
            showToast('找不到 Modal 元素');
            return;
        }
        
        const form = document.getElementById('verifyForm');
        const subtitle = document.getElementById('verifyModalSubtitle');
        const dynamicContainer = document.getElementById('verify-data-section');

        // Reset form for new entry
        form.reset();
        dynamicContainer.innerHTML = '<h3 class="form-section-title">Verify Data</h3>'; // Keep title

        if (data) {
            // Edit mode
            subtitle.textContent = '編輯驗卡資料';
            // (Logic to fill form for editing will be added later)
        } else {
            // New request mode
            subtitle.textContent = '新增驗卡資料';
            document.getElementById('verifyId').value = '';
            // 確保 loadVerifyOptions 已經執行
            const cleanPadSelect = document.getElementById('clean_pad_type');
            if (cleanPadSelect && cleanPadSelect.options.length <= 1) {
                loadVerifyOptions();
            }
            setTimeout(() => {
                addVerifyDataItem(); // Add one default item for a new request
            }, 100);
        }

        modal.style.display = 'block'; // 確保顯示
        modal.classList.add('show');
        console.log('Modal should be visible now');
    } catch (error) {
        console.error('Error opening verify modal:', error);
        showToast('開啟視窗時發生錯誤: ' + error.message);
    }
}

function closeVerifyModal() {
    const modal = document.getElementById('verifyModal');
    modal.classList.remove('show');
}

function addVerifyDataItem() {
    const container = document.getElementById('verify-data-section');
    const itemIndex = container.querySelectorAll('.dynamic-verify-item').length;
    
    const newItem = document.createElement('div');
    newItem.className = 'dynamic-verify-item';
    newItem.innerHTML = `
        <button type="button" class="delete-item-btn" onclick="this.parentElement.remove()">×</button>
        <div class="form-row">
            <label>Type</label><input type="text" name="verify_data[${itemIndex}][type_name]" placeholder="e.g., Sort1 點測">
        </div>
        <div class="form-row" data-columns="3">
            <label>Test Program</label><input type="text" name="verify_data[${itemIndex}][test_program]">
            <label>Test OD</label><input type="text" name="verify_data[${itemIndex}][test_od]">
        </div>
        <div class="form-row" data-columns="3">
            <label>Prober file</label><input type="text" name="verify_data[${itemIndex}][prober_file]">
            <label>Clean OD</label><input type="text" name="verify_data[${itemIndex}][clean_od]">
        </div>
    `;
    container.appendChild(newItem);
}

function submitVerifyForm(event) {
    event.preventDefault();
    showToast('儲存功能開發中...');
    // In a future step, we'll collect form data and save it.
    closeVerifyModal();
}

</script>

</body>
</html>