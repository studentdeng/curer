( function( $ ) {

var dialogEl = null,
    template = '<div id="dialog-export" style="display: none;">\
                    <h3 class="lightbox-title">导出#{name}的工作日志</h3>\
                    <div class="choose-time">\
                        <div class="desc">\
                            请选择要下载数据的时间范围\
                            [<a href="#" class="link-shortcut" id="link-export-all">所有</a>]\
                        </div>\
                        <div class="time">\
                            <input type="text" id="export-start-date" class="datepicker" />\
                            <span>到</span>\
                            <input type="text" id="export-end-date" class="datepicker" />\
                        </div>\
                    </div>\
                    <div class="info">\
                        下载的数据可以使用Excel/Numbers等电子表格软件打开查看\
                    </div>\
                </div>';

$( function() {
    
    $( "#link-export-worklogs" ).click( function( e ) {
        e.preventDefault();
        
        if ( !dialogEl ) {
            initDialog();
        }
        
        dialogEl.lightbox( "show" );
        
        var today = Date.today(),
            lastMonth = today.clone().moveToFirstDayOfMonth().addDays( -1 ).set({
                day: today.getDate()
            }),
            initialDate = new Date( teamcola.firstWorklogDate * 1 ),
            startDate = new Date( Math.max( initialDate.getTime(), lastMonth.getTime()));
        
        $( "#export-start-date" ).datepicker( "setDate", startDate );
        $( "#export-end-date" ).datepicker( "setDate", today );
    });
    
});

function initDialog() {
    var name = "";
    if ( teamcola.label ) {
        name = teamcola.label.name + "分类";
    } else if ( teamcola.members ) {
        name = getCurrentTeam().name + "团队";
        teamcola.api.exportWorklog = teamcola.api.exportWorklog + "team/"
    } else if ( teamcola.member ) {
        name = teamcola.member.name;
    } else {
        name = teamcola.me.name;
    }
    
    dialogEl = $( template.replace( /\#\{name\}/g, name )).lightbox({
        width: 450,
        autoShow: false,
        buttons: [{
            text: "以.csv格式下载",
            handler: function( e ) {
                var params = {
                    start: $( "#export-start-date" ).datepicker( "getDate" ).getTime(),
                    end: $( "#export-end-date" ).datepicker( "getDate" ).addDays( 1 ).getTime()
                };
                
                if ( teamcola.label ) {
                    $.extend( params, {
                        label: teamcola.label.guid
                    });
                } else if ( teamcola.member ) {
                    $.extend( params, {
                        member: teamcola.member.guid
                    });
                }
                
                location.href = teamcola.api.exportWorklog + "?" + $.param( params );
            }
        }]
    });
    
    dialogEl.find( "#export-start-date, #export-end-date" ).datepicker({
        showOn: "both",
        buttonImage: "/assets/images/icon-datepicker.png",
        buttonImageOnly: true,
        dateFormat: "yy-mm-dd",
        showOtherMonths: true,
        selectOtherMonths: true,
        maxDate: new Date(),
        showAnim: "",
        onSelect: function( selectedDate ) {
            if ( this.id == "export-start-date" ) {
                var start = Date.parse( selectedDate, "yyyy-MM-dd" ),
                    end = $( "#export-end-date" ).datepicker( "getDate" );

                if ( start.getTime() > end.getTime()) {
                    $( "#export-end-date" ).datepicker( "setDate", start.clone());
                }
            } else if ( this.id == "export-end-date" ) {
                var end = Date.parse( selectedDate, "yyyy-MM-dd" ),
                    start = $( "#export-start-date" ).datepicker( "getDate" );

                if ( start.getTime() > end.getTime()) {
                    $( "#export-start-date" ).datepicker( "setDate", end.clone());
                }
            }
        }
    });
    
    dialogEl.find( ".link-shortcut" ).click( function( e ) {
        e.preventDefault();
        var start = new Date( teamcola.firstWorklogDate * 1 ),
            end = Date.today();
        
        $( "#export-start-date" ).datepicker( "setDate", start );
        $( "#export-end-date" ).datepicker( "setDate", end );
    });
}

function getCurrentTeam() {
    var result = null;
    $.each( teamcola.teams, function( index, team ) {
        if ( team.guid == teamcola.currentTeam ) {
            result = team;
            return false;
        }
    });
    return result;
}

})( jQuery );
