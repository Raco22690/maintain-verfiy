<?php
/**
 * 置頂系統警示 bar
 * 使用方法：在每個頁面最開頭 `<?php ... ?>` 之後直接引用本函式，或是 include/require 本檔
 */
function renderSystemBanner(): void
{
    echo <<<HTML
<!-- System Test Banner -->
<style>
    /* 置頂橘黃色漸層警示 bar */
    #system-banner {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 28px;             /* bar 的高度，可自行調整 */
        line-height: 28px;         /* 與高度一致，文字垂直置中 */
        background: linear-gradient(90deg, #FFBC2B 0%, #FF9300 100%);
        color: #000;
        font-weight: bold;
        font-size: 14px;
        text-align: center;
        z-index: 9999;             /* 確保永遠位於最上層 */
        box-shadow: 0 1px 4px rgba(0,0,0,.1);
    }
    /* 讓正文內容不被 bar 擋住 */
    body { 
        padding-top: 28px;
        margin: 0;
    }
</style>
<div id="system-banner">系統測試中</div>
<!-- /System Test Banner -->
HTML;
}

// ====== 呼叫顯示 ======
renderSystemBanner();
?>
