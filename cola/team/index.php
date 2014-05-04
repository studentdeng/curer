
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=1000" />
    <title>curer的工作日志 - TeamCola</title>
    <link rel="shortcut icon" href="/favicon.ico" />

    <link href="/curer/cola/assets/styles/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <link href="/curer/cola/assets/styles/style.css" rel="stylesheet" />
    <link href="/curer/cola/assets/styles/lightbox.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="/curer/cola/assets/styles/worklog.css">
    <link rel="stylesheet" href="/curer/cola/assets/styles/calendar.css">
    <link rel="stylesheet" href="/curer/cola/assets/styles/popbox.css">
    <link rel="stylesheet" href="/curer/cola/assets/styles/sidebar.css">
    <link rel="stylesheet" href="/curer/cola/assets/styles/export.css">
    <link rel="stylesheet" href="/curer/cola/assets/styles/ical-subscribe.css">
    <link rel="stylesheet" href="/curer/cola/assets/styles/email-subscribe.css">
    <link rel="stylesheet" href="/curer/cola/assets/styles/member.css">

	
    
    <script>
        var teamcola = {
            me: {
                guid: "1bf27d0f003c411193b6f8bfe28b8dfc",
                avatar: "/uploads/avatar/1bf27d0f003c411193b6f8bfe28b8dfc.jpg",
                name: "curer",
                email: "studentdeng@hotmail.com"
            },
            currentTeam: '990de71f506043858c431e1ea41dc725',
            teams: [{"labels": [{"color": "#808fda", "status": 1, "guid": "6b1a02ae1d764fc48c4fa24ec3008a7f", "name": "\u9879\u76ee\u4f1a\u8bae\u4e0e\u6c9f\u901a"}, {"color": "#5e966f", "status": 1, "guid": "6362d81ca0574f1d85d2bdaf064ef140", "name": "\u81ea\u6211\u63d0\u9ad8"}, {"color": "#9073b8", "status": 1, "guid": "1fa37549b3eb45ce86f2ded7d4e29310", "name": "\u4ea7\u54c1\u5f00\u53d1"}, {"color": "#ed9a51", "status": 1, "guid": "e5bdd8514d1240b2ba953bf9c2d5a28e", "name": "\u5176\u4ed6"}, {"color": "#e1c44f", "status": 1, "guid": "551445a49f9a4dc59e008546e1f8ece4", "name": "\u9a7e\u7167"}, {"color": "#d98aaa", "status": 1, "guid": "b53fb7e792fc434983aca02e65786baa", "name": "\u6587\u6863\u7f16\u5199"}, {"color": "#444444", "status": 1, "guid": "8c9a5957d1574d589264f65237fff2fc", "name": "\u4ea7\u54c1\u8bbe\u8ba1"}, {"color": "#72abd7", "status": 1, "guid": "0f3d68fd588f45bcb4e3f766428f048f", "name": "code review"}, {"color": "#72abd7", "status": 1, "guid": "d0a4f92bf564427eaa96e7b76ea65685", "name": "\u82f1\u8bed"}, {"color": "#e1c44f", "status": 1, "guid": "c8df0f1011f343138d631a61ed8b0455", "name": "\u6d3b\u52a8"}, {"color": "#a47768", "status": 1, "guid": "2da5e9731d1547a2b369070ed1139e12", "name": "\u5065\u8eab"}], "guid": "990de71f506043858c431e1ea41dc725", "name": "Studentdeng", "archive_labels": []}]
        };
    </script>
    <script src="/curer/cola/assets/scripts/jquery-1.6.2.min.js"></script>
    <script src="/curer/cola/assets/scripts/jquery.json-2.2.min.js"></script>
    <script src="/curer/cola/assets/scripts/jquery.cookie.js"></script>
    <script src="/curer/cola/assets/scripts/jquery-ui-1.8.16.custom.min.js"></script>
    <script src="/curer/cola/assets/scripts/jquery.ui.datepicker-zh-CN.min.js"></script>
    <script src="/curer/cola/assets/scripts/jquery.lightbox.js"></script>
    <script src="/curer/cola/assets/scripts/jquery.shortcuts.js"></script>
    <script src="/curer/cola/assets/scripts/global.js"></script>
    
    <script>
        $.extend( teamcola, {
           api: {
                addWorklog:     "/curer/index.php/cola/worklog/add",
                updateWorklog:  "/curer/index.php/cola/worklog/update",
                getWorklog:     "/curer/index.php/cola/worklog/mylist",
                deleteWorklog:  "/curer/index.php/cola/worklog/delete",
                exportWorklog:  "/curer/index.php/cola/worklog/export/"
            },
            member: {
                name: "curer",
                guid: "1bf27d0f003c411193b6f8bfe28b8dfc"
            },
            firstWorklogDate: "1381593600000",
            subscribed: false,
            ical: "f060bef88e374ab492fe5f248cd5769c",
            tour: false
        });
    </script>
    <script src="/curer/cola/assets/scripts/date.js"></script>
    <script src="/curer/cola/assets/scripts/jquery.xcolor.js"></script>
    <script src="/curer/cola/assets/scripts/jquery.tcal.js"></script>
    <script src="/curer/cola/assets/scripts/jquery.popbox.js"></script>
    
    <script src="/curer/cola/assets/scripts/export.js"></script>
    <script src="/curer/cola/assets/scripts/ical-subscribe.js"></script>
    <script src="/curer/cola/assets/scripts/email-subscribe.js"></script>
    <script src="/curer/cola/assets/scripts/member.js"></script>

    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21389765-1']);
  _gaq.push(['_setDomainName', 'teamcola.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
    <div class="bg">
        
    
    <div class="wrapper layout-1">
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
        <li class=""><a href="/curer/cola/">我的日志</a></li>
        <li class="team active">
            <a href="/team/"><span>团队日志</span></a>
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
            <div class="member-info">
                <span class="name" title="curer"><em>curer</em></span>
                <div class="avatar">
                    <img alt="curer" src="/uploads/avatar/1bf27d0f003c411193b6f8bfe28b8dfc.jpg" />
                </div>
                <ul class="info-list">
                    
                    <li style="display:none;" class="phone no-phone"><span>这人没有手机号</span></li>
                    
                    <li class="email"><span><a href="mailto:studentdeng@hotmail.com" title="studentdeng@hotmail.com">studentdeng@hotmail.com</a></span></li>
                </ul>
            </div>
            
            


            <ul class="tool-links">
                <li class="ical">
                    <span class="title"><a href="#" id="link-ical-subscribe">iCal订阅</a></span>
                    <span class="desc">使用日历软件订阅curer的日志</span>
                </li>
                <li class="email">
                    <span class="title"><a href="#" id="link-email-subscribe">邮件订阅</a></span>
                    <span class="desc">通过每日邮件查看curer的日志</span>
                </li>
                <li class="stats">
                    <span class="title"><a href="/stats/team/member/1bf27d0f003c411193b6f8bfe28b8dfc/">统计</a></span>
                    <span class="desc">按照分类和成员统计团队日志</span>
                </li>
                <li class="export">
                    <span class="title"><a href="#" id="link-export-worklogs">导出</a></span>
                    <span class="desc">以CSV格式导出curer的工作记录</span>
                </li>
            </ul>
        </div>
        
        <div class="content">
            
            <div class="top-bar clearfix">
                <h3>curer的工作日志</h3>
                <div class="btn-group switch-worklog-views">
                    <button class="btn first" id="btn-view-list">列表</button>
                    <button class="btn" id="btn-view-week">周</button>
                    <button class="btn last" id="btn-view-month">月</button>
                </div>
                <div class="date-control">
    <button id="btn-today" class="btn unselectable" unselectable="on">今天</button>
    <div class="btn-group">
        <button id="btn-prev" class="btn unselectable first" unselectable="on"><span>以前</span></button>
        <button id="btn-next" class="btn unselectable last" unselectable="on"><span>以后</span></button>
    </div>
    <div class="date"></div>
</div>


            </div>
            
            <div class="worklog-views">
                <div id="worklog-list">
                    <div class="worklogs-wrapper"></div>
                    <a href="#" class="scroll-loading">
                        <span>正在加载...</span>
                    </a>
                </div>
                <div id="worklog-week"></div>
                <div id="worklog-month"></div>
            </div>
            
            <button class="btn" id="back-to-top">回到顶部</button>
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
