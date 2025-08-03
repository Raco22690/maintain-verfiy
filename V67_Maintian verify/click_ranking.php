<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>查看數排行</title>
    <link rel="icon" href="..\Icon file\logo1.svg" type="image/svg+xml">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            color: #333;
        }

        .ranking-container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            padding: 20px;
        }

        .ranking-title {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .ranking-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .ranking-table th {
            background: #666;
            color: #fff;
            padding: 12px 8px;
            text-align: center;
            font-weight: 600;
        }

        .ranking-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .ranking-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .ranking-table tr:hover {
            background: #f0f0f0;
        }

        .rank-number {
            font-weight: bold;
            color: #666;
            width: 50px;
        }

        .click-count {
            font-weight: bold;
            color: #FFA000;
        }

        .desc-col {
            text-align: left;
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background: #666;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 20px;
            transition: background 0.3s;
        }

        .back-button:hover {
            background: #888;
        }
    </style>
</head>
<body>
    <div class="ranking-container">
        <a href="V63_Maintian BKM.php" class="back-button">返回主頁</a>
        <h1 class="ranking-title">查看數排行</h1>
        <table class="ranking-table">
            <thead>
                <tr>
                    <th>排名</th>
                    <th>Device</th>
                    <th>SWBin & Issue</th>
                    <th>Sort</th>
                    <th>Desc.</th>
                    <th>查看數</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 讀取查看數據
                $clickDataFile = __DIR__ . '/click_data.json';
                $clickData = [];
                if (file_exists($clickDataFile)) {
                    $clickData = json_decode(file_get_contents($clickDataFile), true);
                }

                // 讀取BKM數據
                $dbHost = 'localhost';
                $dbUser = 'root';
                $dbPass = 'A12345678';
                $dbName = 'mydatabase';

                $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
                $conn->set_charset("utf8");

                if ($conn->connect_error) {
                    die("連接失敗: " . $conn->connect_error);
                }

                // 獲取所有BKM數據
                $sql = "SELECT ID, Device, SWBin_Issue, Sort, Description FROM BKM_table";
                $result = $conn->query($sql);

                $rankingData = [];
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $clickCount = isset($clickData[$row['ID']]) ? $clickData[$row['ID']]['count'] : 0;
                        $rankingData[] = [
                            'id' => $row['ID'],
                            'device' => $row['Device'],
                            'swbin' => $row['SWBin_Issue'],
                            'sort' => $row['Sort'],
                            'desc' => $row['Description'],
                            'clicks' => $clickCount
                        ];
                    }
                }

                // 按查看數排序
                usort($rankingData, function($a, $b) {
                    return $b['clicks'] - $a['clicks'];
                });

                // 顯示排行
                $rank = 1;
                foreach ($rankingData as $data) {
                    echo "<tr>";
                    echo "<td class='rank-number'>" . $rank++ . "</td>";
                    echo "<td>" . htmlspecialchars($data['device']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['swbin']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['sort']) . "</td>";
                    echo "<td class='desc-col'>" . htmlspecialchars($data['desc']) . "</td>";
                    echo "<td class='click-count'>" . $data['clicks'] . "</td>";
                    echo "</tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html> 