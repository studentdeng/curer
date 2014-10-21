<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=1000"/>
    <title>我的日志 - TeamCola</title>
    <?php $this->load->view('header'); ?>
    <script>

        var teamcola = {
            me: {
                guid: "1bf27d0f003c411193b6f8bfe28b8dfc",
                avatar: "/uploads/avatar/1bf27d0f003c411193b6f8bfe28b8dfc.jpg",
                name: "curer",
                email: "studentdeng@hotmail.com"
            },
            currentTeam: '990de71f506043858c431e1ea41dc725',
            teams: [{
                "labels": <?php echo $labels?>,
                "guid": "990de71f506043858c431e1ea41dc725",
                "name": "Studentdeng",
                "archive_labels": []
            }]
        };
    </script>


    <script>
        $.extend(teamcola, {
            api: {
                addWorklog: "/curer/index.php/cola/worklog/add",
                updateWorklog: "/curer/index.php/cola/worklog/update",
                getWorklog: "/curer/index.php/cola/worklog/list",
                deleteWorklog: "/curer/index.php/cola/worklog/delete",
                exportWorklog: "/curer/index.php/cola/worklog/export/"
            },
            firstWorklogDate: "1381593600000",
            tour: false,
            overdue: false
        });

    </script>

    <script type="text/javascript">
    </script>
</head>
<body>
<div class="bg">


    <div class="wrapper layout-1" id="my-worklog">
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
                <li class="team active"><a href="<?php echo base_url("index.php/time") ?>">我的日志</a></li>
                <li class="">
                    <a href="<?php echo base_url("index.php/time/team") ?>"><span>团队日志</span></a>
                </li>
                <li class=""><a href="<?php echo base_url("index.php/time/stats_label") ?>">统计</a></li>
                <li class=""><a href="/shop/">积分</a></li>
            </ul>
            <ul class="header-links">
                <li class=""><a href="/member/settings/1bf27d0f003c411193b6f8bfe28b8dfc">curer的设置</a></li>

                <li class=""><a href="/company/settings/61a0d1251d9444078196ad940ca77094">团队设置</a></li>


                <li class=""><a href="/payment/">付费</a></li>

                <li class="last"><a href="/logout/">退出</a></li>
            </ul>

        </div>


        <div class="sidebar">


            <ul class="tool-links">
                <li class="stats">
                    <span class="title"><a href="<?php echo base_url("index.php/time/stats_label") ?>">统计</a></span>
                    <span class="desc">按照分类统计你的工作记录</span>
                </li>
                <li class="export">
                    <span class="title"><a href="#" id="link-export-worklogs">导出</a></span>
                    <span class="desc">以CSV格式导出你的工作记录</span>
                </li>
            </ul>


        </div>

        <div class="content">
            <div class="top-bar clearfix">
                <div class="date-control">
                    <button id="btn-today" class="btn unselectable" unselectable="on">今天</button>
                    <div class="btn-group">
                        <button id="btn-prev" class="btn unselectable first" unselectable="on"><span>以前</span></button>
                        <button id="btn-next" class="btn unselectable last" unselectable="on"><span>以后</span></button>
                    </div>
                    <div class="date"></div>
                </div>


                <div class="btn-group switch-cal-view">
                    <!-- <button class="btn first" id="btn-cal-day">日</button> -->
                    <button class="btn first" id="btn-cal-week">周</button>
                    <button class="btn last" id="btn-cal-month">月</button>
                </div>
            </div>
            <div class="cals">
                <div id="cal-day"></div>
                <div id="cal-week"></div>
                <div id="cal-month"></div>
            </div>
        </div>

        <div class="footer">
            <!--&hearts; 由 <a href="http://mycolorway.com">彩程设计</a> 提供-->
            &hearts; 由 <a href="http://mycolorway.com" target="_blank">彩程设计</a> 驱动
        </div>


    </div>


</div>
<a href="#" id="feedback">意见反馈</a>
</body>
</html>
