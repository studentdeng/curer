
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=1000" />
    <title>统计 - TeamCola</title>
    <link rel="shortcut icon" href="/favicon.ico" />

    <link href="/curer/cola/assets/styles/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <link href="/curer/cola/assets/styles/style.css" rel="stylesheet" />
    <link href="/curer/cola/assets/styles/lightbox.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="/curer/cola/assets/styles/stats-detail.css">

	
    
    <script>
        var teamcola = {
            me: {
                guid: "1bf27d0f003c411193b6f8bfe28b8dfc",
                avatar: "/uploads/avatar/1bf27d0f003c411193b6f8bfe28b8dfc.jpg",
                name: "curer",
                email: "studentdeng@hotmail.com"
            },
            currentTeam: '990de71f506043858c431e1ea41dc725',
            teams: [{"labels": [{"color": "#e1c44f", "status": 1, "guid": "551445a49f9a4dc59e008546e1f8ece4", "name": "\u9a7e\u7167"}, {"color": "#d98aaa", "status": 1, "guid": "b53fb7e792fc434983aca02e65786baa", "name": "\u6587\u6863\u7f16\u5199"}, {"color": "#444444", "status": 1, "guid": "8c9a5957d1574d589264f65237fff2fc", "name": "\u4ea7\u54c1\u8bbe\u8ba1"}, {"color": "#72abd7", "status": 1, "guid": "0f3d68fd588f45bcb4e3f766428f048f", "name": "code review"}, {"color": "#72abd7", "status": 1, "guid": "d0a4f92bf564427eaa96e7b76ea65685", "name": "\u82f1\u8bed"}, {"color": "#e1c44f", "status": 1, "guid": "c8df0f1011f343138d631a61ed8b0455", "name": "\u6d3b\u52a8"}, {"color": "#5e966f", "status": 1, "guid": "6362d81ca0574f1d85d2bdaf064ef140", "name": "\u81ea\u6211\u63d0\u9ad8"}, {"color": "#9073b8", "status": 1, "guid": "1fa37549b3eb45ce86f2ded7d4e29310", "name": "\u4ea7\u54c1\u5f00\u53d1"}, {"color": "#808fda", "status": 1, "guid": "6b1a02ae1d764fc48c4fa24ec3008a7f", "name": "\u9879\u76ee\u4f1a\u8bae\u4e0e\u6c9f\u901a"}, {"color": "#ed9a51", "status": 1, "guid": "e5bdd8514d1240b2ba953bf9c2d5a28e", "name": "\u5176\u4ed6"}, {"color": "#a47768", "status": 1, "guid": "2da5e9731d1547a2b369070ed1139e12", "name": "\u5065\u8eab"}], "guid": "990de71f506043858c431e1ea41dc725", "name": "Studentdeng", "archive_labels": []}]
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
            team: "990de71f506043858c431e1ea41dc725",
            member: "1bf27d0f003c411193b6f8bfe28b8dfc",
            label: "",
            type: "2",
            tour: false
        });
    </script>
    <script src="/curer/cola/assets/scripts/date.js?version=103"></script>
    <script src="/curer/cola/assets/scripts/highcharts.js"></script>
    <script src="/curer/cola/assets/scripts/stats-detail.js"></script>

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
        <li class=""><a href="/home/">我的日志</a></li>
        <li class="team">
            <a href="/team/"><span>团队日志</span></a>
        </li>
        <li class="active"><a href="/stats/team/member/">统计</a></li>
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
