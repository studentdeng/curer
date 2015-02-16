<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=1000"/>
        <title>我的日志 - TeamCola</title>
        <?php $this->load->view('header'); ?>
        <script>
            var teamcola = <?php echo json_encode($teamcola) ?>
        </script>


        <script>
            $.extend(teamcola, {
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


                <?php $this->load->view('nav'); ?>

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
