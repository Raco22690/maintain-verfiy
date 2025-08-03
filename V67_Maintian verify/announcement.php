<?php
// announcement.php
function displayAnnouncement() {
    ?>
    <div id="announcement" style="background:rgb(241, 241, 241); padding:2px; margin:10px 0; 
         height:40px; overflow:hidden; border-radius:8px; font-size:16px; text-align:center; color:#616161; font-weight: bold;">
        <div id="announcement-wrapper" style="transition: transform 0.5s;">
            <?php
            $announcements = array(
   
                "系統提醒:Open Resource 請各位踴躍更新",
                "系統提醒:若有不知道如何維修的BIN 請登記於系統",
                "系統提醒:Key Maintain Device Top 5 根據查閱次數做排行，快速查找資訊",
            );
            foreach ($announcements as $announcement) {
                echo '<div class="announcement-item" style="height:40px; line-height:40px;">' . $announcement . '</div>';
            }
            ?>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('announcement-wrapper');
        const items = wrapper.getElementsByClassName('announcement-item');
        const itemHeight = 40; // 與容器高度一致
        const totalItems = items.length;
        let currentIndex = 0;
        setInterval(() => {
            currentIndex = (currentIndex + 1) % totalItems;
            wrapper.style.transform = `translateY(-${currentIndex * itemHeight}px)`;
        }, 5000);
    });
    </script>
    <?php
}
?>
