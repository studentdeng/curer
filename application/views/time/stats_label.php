
<?php
$url = 'http://'. $_SERVER['HTTP_HOST']. '/curer/index.php/cola/stats/category_list';
$labels = file_get_contents($url);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=1000" />
    <title>统计 - TeamCola</title>
    <link rel="shortcut icon" href="/favicon.ico" />

    <link href="/curer/assets/styles/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <link href="/curer/assets/styles/style.css" rel="stylesheet" />
    <link href="/curer/assets/styles/lightbox.css" rel="stylesheet" />

    <link rel="stylesheet" href="/curer/assets/styles/stats-detail.css">



    <script>
        var teamcola = {
            me: {
                guid: "1bf27d0f003c411193b6f8bfe28b8dfc",
                avatar: "/uploads/avatar/1bf27d0f003c411193b6f8bfe28b8dfc.jpg",
                name: "curer",
                email: "studentdeng@hotmail.com"
            },
            currentTeam: '990de71f506043858c431e1ea41dc725',
            teams: [{"labels": <?php echo $labels?>, "guid": "990de71f506043858c431e1ea41dc725", "name": "Studentdeng", "archive_labels": []}]
        };
    </script>
    <script src="/curer/assets/scripts/jquery-1.6.2.min.js?version=103"></script>
    <script src="/curer/assets/scripts/jquery.json-2.2.min.js?version=103"></script>
    <script src="/curer/assets/scripts/jquery.cookie.js?version=103"></script>
    <script src="/curer/assets/scripts/jquery-ui-1.8.16.custom.min.js?version=103"></script>
    <script src="/curer/assets/scripts/jquery.ui.datepicker-zh-CN.min.js?version=103"></script>
    <script src="/curer/assets/scripts/jquery.lightbox.js?version=103"></script>
    <script src="/curer/assets/scripts/jquery.shortcuts.js?version=103"></script>
    <script src="/curer/assets/scripts/global.js?version=103"></script>

    <script>
        $.extend( teamcola, {
            team: "990de71f506043858c431e1ea41dc725",
            member: "1bf27d0f003c411193b6f8bfe28b8dfc",
            label: "",
            type: "2",
            tour: false
        });
    </script>
    <script src="/curer/assets/scripts/date.js?version=103"></script>
    <script src="/curer/assets/scripts/highcharts.js"></script>
    <script src="/curer/assets/scripts/stats-detail.js"></script>

    <script type="text/javascript">

    </script>
</head>
<body>
<div class="bg">


    <div class="wrapper layout-2">
        <div class="header">
            <div class="header-team hover">
                <h1 title="回到首页"><a href="/home/">Studentdeng</a></h1>

                <a href="#" class="switch-team" title="切换团队">&#x25bc;</a>
                <ul id="switch-list" class="switch-list">



                    <li class="first">


                        <a href="http://iknowteam.teamcola.com/home/">
                            <span class="team-name">iKnow Team</span>
                            <span class="team-domain">iknowteam.teamcola.com</span>
                        </a>
                    </li>




                    <li class="last">



                        <a href="http://kylll.teamcola.com/home/">
                            <span class="team-name">口语练练练</span>
                            <span class="team-domain">kylll.teamcola.com</span>
                        </a>
                    </li>

                </ul>

            </div>
            <ul class="nav">
                <li class=""><a href="<?php echo base_url("index.php/time")?>">我的日志</a></li>
                <li class="team">
                    <a href="<?php echo base_url("index.php/time/team")?>"><span>团队日志</span></a>
                </li>
                <li class="active"><a href="<?php echo base_url("index.php/time/stats_label")?>">统计</a></li>
                <li class=""><a href="/shop/">积分</a></li>
            </ul>
            <ul class="header-links">
                <li class=""><a href="/member/settings/1bf27d0f003c411193b6f8bfe28b8dfc">curer的设置</a></li>

                <li class=""><a href="/company/settings/61a0d1251d9444078196ad940ca77094">团队设置</a></li>


                <li class=""><a href="/payment/">付费</a></li>

                <li class="last"><a href="/logout/">退出</a></li>
            </ul>

        </div>






        <div class="content clearfix">
            <ul class="stats-nav">

                <li><a href="/stats/team/member/">成员统计</a></li>
                <li class="active"><a href="/stats/team/label/">分类统计</a></li>

            </ul>
            <div class="control-bar">
                <!--<div class="desc">curer的工作日志统计</div>-->
                <div class="crumb">


                    <div class="crumb-item first">

                        <a href="/stats/team/member/">
                            按成员统计
                        </a>
                        <span class="arrow">»</span>

                    </div>

                    <div class="crumb-item last">

                        <span>curer</span>

                    </div>


                </div>

                <a href="#" id="choose-period">
                    <span class="date">
                        <span class="start"></span> - <span class="end"></span>
                    </span>
                    <span class="arrow"></span>
                </a>
                <div class="switch-date-unit btn-group">
                    <button class="btn first" id="btn-unit-day">日</button>
                    <button class="btn last" id="btn-unit-week">周</button>
                </div>
            </div>
            <div id="chart">

            </div>
            <table class="stats-table">
                <thead>
                <tr>
                    <th class="col-num"></th>
                    <th class="col-target">分类</th>
                    <th class="col-hour">工作量(小时)</th>
                    <th class="col-ratio">占比</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <!--&hearts; 由 <a href="http://mycolorway.com">彩程设计</a> 提供-->
            &hearts; 由 <a href="http://mycolorway.com" target="_blank">彩程设计</a> 驱动
        </div>

        <div id="choose-date-panel">
            <div class="title clearfix">
                <span>选择时间范围</span>
                <a href="#" id="link-range-week">[最近一周]</a>
                <a href="#" id="link-range-month">[最近一月]</a>
                <a href="#" id="link-range-quater">[最近三月]</a>
            </div>
            <div id="rangepicker"></div>
            <div class="buttons clearfix">
                <button class="btn-blue" id="btn-change-date">确定</button>
            </div>
        </div>


    </div>



</div>
<a href="#" id="feedback">意见反馈</a>
</body>
</html>
