
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=1000" />
    <title>我的日志 - TeamCola</title>
    <link rel="shortcut icon" href="/favicon.ico" />

    <link href="/curer/cola/assets/styles/jquery-ui-1.8.16.custom.css?version=103" rel="stylesheet" />
    <link href="/curer/cola/assets/styles/style.css?version=103" rel="stylesheet" />
    <link href="/curer/cola/assets/styles/lightbox.css?version=103" rel="stylesheet" />
    
    <link rel="stylesheet" href="/curer/cola/assets/styles/popbox.css?version=103">
    <link rel="stylesheet" href="/curer/cola/assets/styles/calendar.css?version=103">
    <link rel="stylesheet" href="/curer/cola/assets/styles/sidebar.css?version=103">
    <link rel="stylesheet" href="/curer/cola/assets/styles/export.css?version=103">
    <link rel="stylesheet" href="/curer/cola/assets/styles/my-worklog.css?version=103">

	
    
    <script>
        var teamcola = {
            me: {
                guid: "1bf27d0f003c411193b6f8bfe28b8dfc",
                avatar: "/uploads/avatar/1bf27d0f003c411193b6f8bfe28b8dfc.jpg",
                name: "curer",
                email: "studentdeng@hotmail.com"
            },
            currentTeam: '990de71f506043858c431e1ea41dc725',
            teams: [{"labels": [{"color": "#5e966f", "status": 1, "guid": "6362d81ca0574f1d85d2bdaf064ef140", "name": "\u81ea\u6211\u63d0\u9ad8"}, {"color": "#9073b8", "status": 1, "guid": "1fa37549b3eb45ce86f2ded7d4e29310", "name": "\u4ea7\u54c1\u5f00\u53d1"}, {"color": "#ed9a51", "status": 1, "guid": "e5bdd8514d1240b2ba953bf9c2d5a28e", "name": "\u5176\u4ed6"}, {"color": "#72abd7", "status": 1, "guid": "d0a4f92bf564427eaa96e7b76ea65685", "name": "\u82f1\u8bed"}, {"color": "#e1c44f", "status": 1, "guid": "c8df0f1011f343138d631a61ed8b0455", "name": "\u6d3b\u52a8"}, {"color": "#72abd7", "status": 1, "guid": "0f3d68fd588f45bcb4e3f766428f048f", "name": "code review"}, {"color": "#808fda", "status": 1, "guid": "6b1a02ae1d764fc48c4fa24ec3008a7f", "name": "\u9879\u76ee\u4f1a\u8bae\u4e0e\u6c9f\u901a"}, {"color": "#a47768", "status": 1, "guid": "2da5e9731d1547a2b369070ed1139e12", "name": "\u5065\u8eab"}, {"color": "#444444", "status": 1, "guid": "8c9a5957d1574d589264f65237fff2fc", "name": "\u4ea7\u54c1\u8bbe\u8ba1"}, {"color": "#d98aaa", "status": 1, "guid": "b53fb7e792fc434983aca02e65786baa", "name": "\u6587\u6863\u7f16\u5199"}, {"color": "#e1c44f", "status": 1, "guid": "551445a49f9a4dc59e008546e1f8ece4", "name": "\u9a7e\u7167"}], "guid": "990de71f506043858c431e1ea41dc725", "name": "Studentdeng", "archive_labels": []}]
        };
    </script>
    <script src="/curer/cola/assets/scripts/jquery-1.6.2.min.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/jquery.json-2.2.min.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/jquery.cookie.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/jquery-ui-1.8.16.custom.min.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/jquery.ui.datepicker-zh-CN.min.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/jquery.lightbox.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/jquery.shortcuts.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/global.js?version=103"></script>
    
    <script>
        $.extend( teamcola, {
            api: {
                addWorklog:     "/curer/index.php/cola/worklog/add",
                updateWorklog:  "/curer/index.php/cola/worklog/update",
                getWorklog:     "/curer/index.php/cola/worklog/list",
                deleteWorklog:  "/curer/index.php/cola/worklog/delete",
                exportWorklog:  "/curer/index.php/cola/worklog/export/"
            },
            firstWorklogDate: "1381593600000",
            tour: false,
            overdue: false
        });

    </script>
    <script src="/curer/cola/assets/scripts/date.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/jquery.animateWithCss.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/jquery.xcolor.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/jquery.tcal.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/jquery.popbox.js?version=103"></script>
    
    <script src="/curer/cola/assets/scripts/export.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/my-worklog.js?version=103"></script>

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
        <li class="active"><a href="/curer/cola/">我的日志</a></li>
        <li class="team">
            <a href="/curer/cola/team/"><span>团队日志</span></a>
        </li>
        <li class=""><a href="/curer/cola/stats/team/label/">统计</a></li>
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
                    <span class="title"><a href="/curer/cola/stats/team/label">统计</a></span>
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
