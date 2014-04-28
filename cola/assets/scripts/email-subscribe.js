( function( $ ) {

var dialogEl = null,
    template = '<div id="dialog-email-subscribe" style="display: none;">\
                    <h3 class="lightbox-title">邮件订阅工作记录</h3>\
                    <div class="desc">\
                        通过邮件订阅，每天早上只需查看新邮件，即可了解昨天发生的事。\
                    </div>\
                    <div class="subscribe-box clearfix">\
                        <a href="#" class="btn unselectable" unselectable="on" id="btn-email-subscribe">订阅#{name}的工作日志</a>\
                        <div class="subscribe-success" style="display: none">\
                            <span>已订阅#{name}的工作日志</span>\
                            <a href="#" id="link-email-unsubscribe">退订</a>\
                        </div>\
                    </div>\
                    <div class="info">\
                        订阅的工作记录会在每天早上9点发送到<em>#{email}</em><br/>\
                        你可以<a href="/assets/images/email-subscribe.png" target="_blank">查看邮件示例</a>\
                    </div>\
                </div>';

$( function() {
    
    $( "#link-email-subscribe" ).click( function( e ) {
        e.preventDefault();
        
        if ( !dialogEl ) {
            initDialog();
        }
        
        dialogEl.lightbox( "show" );
    });
    
});

function initDialog() {
    var name = "";
    if ( teamcola.label ) {
        name = teamcola.label.name + "分类";
    } else if ( teamcola.members ) {
        name = getCurrentTeam().name + "团队";
    } else if ( teamcola.member ) {
        name = teamcola.member.name;
    } else {
        name = teamcola.me.name;
    }
    
    dialogEl = $( template
        .replace( /\#\{name\}/g, name )
        .replace( /\#\{email\}/g, teamcola.me.email ));
    
    if ( teamcola.subscribed ) {
        dialogEl.find( "#btn-email-subscribe" ).hide();
        dialogEl.find( ".subscribe-success" ).show();
    }
        
    dialogEl.lightbox({
        width: 450,
        autoShow: false,
        buttons: [{
            text: "完成",
            handler: function( e ) {
                dialogEl.lightbox( "hide" );
            }
        }]
    });
    
    dialogEl.find( "#btn-email-subscribe" ).click( function( e ) {
        e.preventDefault();
        var btn = $( this ),
            params = {};
        
        if ( teamcola.label ) {
            params.label = teamcola.label.guid;
        } else if ( teamcola.member ) {
            params.member = teamcola.member.guid;
        } else {
            params.member = teamcola.me.guid;
        }
        
        tinyLoading.show( btn );
        $.ajax({
            url: "/subscribe/email",
            data: {
                data: $.toJSON( params )
            },
            success: function( result ) {
                tinyLoading.hide( btn );
                btn.hide()
                    .siblings( ".subscribe-success" )
                    .show();
            },
            error: function() {
                tinyLoading.hide( btn );
            }
        });
    });
    
    dialogEl.find( "#link-email-unsubscribe" ).click( function( e ) {
        e.preventDefault();
        var btn = $( this ),
            params = {};
        
        if ( teamcola.members ) {
            params.team = teamcola.currentTeam;
        } else if ( teamcola.member ) {
            params.member = teamcola.member.guid;
        } else {
            params.member = teamcola.me.guid;
        }
        
        tinyLoading.show( btn );
        $.ajax({
            url: "/unsubscribe/email",
            data: {
                data: $.toJSON( params )
            },
            success: function( result ) {
                tinyLoading.hide( btn );
                btn.parent( ".subscribe-success" )
                    .hide()
                    .siblings( "#btn-email-subscribe" )
                    .show();
            },
            error: function() {
                tinyLoading.hide( btn );
            }
        });
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