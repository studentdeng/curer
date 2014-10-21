( function( $ ) {

var dialogEl = null,
    template = '<div id="dialog-ical-subscribe" style="display: none;">\
                    <h3 class="lightbox-title">iCal订阅工作记录</h3>\
                    <div class="desc">\
                        你可以在 Outlook、Google Calendar 和 iCal 等日历软件中订阅<em>#{name}</em>的工作记录。<br/><a href="/help/about_icalendar.html">查看如何使用</a>\
                    </div>\
                    <div class="subscribe-box clearfix">\
                        <a href="#" class="btn unselectable" unselectable="on" id="btn-ical-subscribe">获取iCaldendar地址</a>\
                        <a href="#" class="link-icalendar" style="display: none;"></a>\
                    </div>\
                    <div class="info">\
                        如果您不希望其他人查看这些内容，请不要与他们共享此网址。<br/>\
                        意外泄露请<a href="#" id="btn-ical-resubscribe">重新生成iCalendar地址</a>\
                    </div>\
                </div>';

$( function() {
    
    $( "#link-ical-subscribe" ).click( function( e ) {
        e.preventDefault();
        
        if ( !dialogEl ) {
            initDialog();
        }
        
        dialogEl.lightbox( "show" );
    });
    
});

function initDialog() {
    var name = "";
    if ( teamcola.members ) {
        name = getCurrentTeam().name + "团队";
    } else if ( teamcola.member ) {
        name = teamcola.member.name;
    } else {
        name = teamcola.me.name;
    }
    
    dialogEl = $( template.replace( /\#\{name\}/g, name )).lightbox({
        width: 480,
        autoShow: false,
        buttons: [{
            text: "完成",
            handler: function( e ) {
                dialogEl.lightbox( "hide" );
            }
        }]
    });
    
    if ( teamcola.ical ) {
        dialogEl.find( "#btn-ical-subscribe" ).hide();
        dialogEl.find( ".link-icalendar" )
            .text( "webcal://mycolorway.teamcola.com/ical/" + teamcola.ical +  "/" )
            .attr( "href", "webcal://mycolorway.teamcola.com/ical/" + teamcola.ical +  "/" )
            .show();
        dialogEl.find( ".info" ).show();
    }
    
    dialogEl.find( "#btn-ical-subscribe, #btn-ical-resubscribe" ).click( function( e ) {
        e.preventDefault();
        var btn = $( this ),
            resubscribe = ( this.id == "btn-ical-resubscribe" );
        if ( !resubscribe ) {
            target = $( this );
        } else {
            target = dialogEl.find( ".link-icalendar" );
        }
        
        if ( resubscribe && !confirm( "重新生成后，旧的地址会失效。确认要重新生成？" )) {
            return;
        }
        
        var params = {};
        if ( teamcola.members ) {
            params.team = teamcola.currentTeam;
        } else if ( teamcola.member ) {
            params.member = teamcola.member.guid;
        } else {
            params.member = teamcola.me.guid;
        }
        
        tinyLoading.show( target );
        $.ajax({
            url: resubscribe ? "/resubscribe/ical" : "/subscribe/ical",
            data: {
                data: $.toJSON( params )
            },
            success: function( result ) {
                var icalAddress = "webcal://mycolorway.teamcola.com/ical/" + result.guid +  "/";
                
                tinyLoading.hide( target );
                dialogEl.find( "#btn-ical-subscribe" ).hide();
                dialogEl.find( ".link-icalendar" )
                    .text( icalAddress )
                    .attr( "href", icalAddress )
                    .show();
                dialogEl.find( ".info" ).show();
            },
            error: function() {
                tinyLoading.hide( target );
            }
        });
    });
}

})( jQuery );