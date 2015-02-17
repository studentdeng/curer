
<?php
if ($this->uri->segment(2) === 'stats_label') {
    $path = 'stats_label';
} else if ($this->uri->segment(2) === 'team') {
    $path = 'team';
} else {
    $path = 'time';
}
?>

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
        <li class="<?php if ($path === 'time') echo 'team active' ?>"><a href="<?php echo base_url("index.php/time") ?>">我的日志</a></li>
        <li class="<?php if ($path === 'team') echo 'team active' ?>"><a href="<?php echo base_url("index.php/time/team") ?>"><span>团队日志</span></a></li>
        <li class="<?php if ($path === 'stats_label') echo 'team active' ?>"><a href="<?php echo base_url("index.php/time/stats_label") ?>">统计</a></li>
    </ul>
    <ul class="header-links">
        <li class=""><a href="/member/settings/1bf27d0f003c411193b6f8bfe28b8dfc">curer的设置</a></li>

        <li class=""><a href="/company/settings/61a0d1251d9444078196ad940ca77094">团队设置</a></li>


        <li class=""><a href="/payment/">付费</a></li>

        <li class="last"><a href="/logout/">退出</a></li> 
    </ul>
</div>