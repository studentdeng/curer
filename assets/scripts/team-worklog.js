( function( $ ) {

$.preloadImages([
    "/curer/assets/images/yin-dang-de-yi-tian.png",
    "/curer/assets/images/no-worklog-day.png"
]);

var currentDate = Date.today(),
    worklogs = {},
    template = {
        memberTitle: '<div class="title"><a class="avatar" href="/member/#{guid}/"><img alt="#{name}" src="#{avatar}" /></a><a href="/member/#{guid}/" class="name">#{name}</a><span class="total-hour">#{total}</span></div>',
        memberWorklog: '<div class="worklog"><span class="hour">#{hour}</span><span class="period" title="#{start} ~ #{end}"><span></span></span><div class="worklog-content markdown"><span class="worklog-info"><span class="labels"></span><a class="comments" href="/worklog/#{guid}/" target="_blank"><img alt="评论" src="/assets/images/icon-comment.png" /><span class="count">#{comments}</span></a></span></div></div>',
        member: '<li><a href="/member/#{guid}/" class="avatar"><img alt="#{name}" src="#{avatar}" /></a><a href="/member/#{guid}/" class="name" title="#{name}">#{name}</a></li>'
    };

$( function() {
    
    $( window ).bind( "hashchange", function (){
        if( location.hash ) {
            var date =  location.hash.replace( "#", "" );
            currentDate = new Date( date * 1 );
        } else{
            var date = Date.today().getTime();
            location.replace( location.href + '#'+ date );
            return;
        }
        fetchData();
    });
    
    $( "#btn-prev, #btn-next" ).click( function( e ) {
        e.preventDefault();
        var btn = $( this );
        if ( btn.hasClass( "disabled" )) {
            return;
        }
        
        var date;
        if ( btn.attr( "id" ) == "btn-next" ) {
            date = currentDate.addDays( 1 );
        } else {
            date = currentDate.addDays( -1 );
        }
        location.hash = '#' + date.getTime();
    });
            
    $( "#btn-today" ).click( function( e ) {
        e.preventDefault();
        var btn = $( this );
        
        if ( btn.hasClass( "disabled" )) {
            return;
        }
        
        var today = Date.today();
        if ( currentDate.getTime() != today.getTime()) {
            currentDate = today;
            location.hash = '#' + currentDate.getTime();
        }
    });
    
    $( ".worklog" ).live( "mouseenter", function() {
        $( this ).addClass( "over" );
    }).live( "mouseleave", function() {
        $( this ).removeClass( "over" );
    });
    
    $( "#link-toggle-labels" ).click( function( e ) {
        e.preventDefault();
        var labelsEl = $( ".label-list" ),
            labels = labelsEl.find( "li" ),
            liH = labels.eq( 0 ).outerHeight( true ),
            link = $( this );
        
        if ( link.hasClass( "expanded" )) {
            labelsEl.css({
                height: liH * 5 - 2
            });
            link.removeClass( "expanded" )
                .text( "显示不常用的" + ( labels.length - 5 ) + "个分类" )
                .siblings( "span" )
                .html( "&#x25BC;" );
        } else {
            labelsEl.css({
                height: liH * labels.length - 2
            });
            link.addClass( "expanded" )
                .text( "只显示常用的5个分类" )
                .siblings( "span" )
                .html( "&#x25B2;" );
        }
    });
    
    if ( $( ".label-list li" ).length > 5 ) {
        $( ".toggle-labels" ).show()
            .find( "#link-toggle-labels" )
            .click();
    } else {
        $( ".toggle-labels" ).hide();
    }
    
    if ( !teamcola.tour ) {
        if( location.hash ) {
            $( window ).trigger( "hashchange" );
        } else {
            var hash = '#' + currentDate.getTime();
            location.replace( location.href + hash);
        }
    }
    
});

function fetchData( ) {
    var date = currentDate.getTime();
    if ( worklogs[date] ) { 
        loadData( worklogs[date] );
    } else {
        hugeLoading.show();
        $.ajax({
            url: teamcola.api.getWorklog,
            data: {
                data: $.toJSON({
                    start: date,
                    end: date + 86400000,
                    teams: [teamcola.currentTeam]
                })
            },
            success: function( result ) {
                $.extend( worklogs, result.worklogs );
                loadData( worklogs[date] );
                hugeLoading.hide();
            }
        });
    }
    
        
    function loadData( data ) {

        var teamWorklog = $( ".team-worklog" ).empty().removeClass( "no-worklog" ),
            noWorklogMembers = [],
            noWorklog = true;
        
        teamcola.members.sort( function( a, b ) {
            return getTotalHour( data[b.guid] ) - getTotalHour( data[a.guid] );
        });
        
        $.each( teamcola.members, function( index, member ) {

            if ( data[member.guid] && data[member.guid].length ) {
                noWorklog = false;
                
                var memberEl = $( '<div class="member-worklog"></div>' )
                        .appendTo( teamWorklog ),
                    titleEl = $( template.memberTitle
                        .replace( /\#\{guid\}/g, member.guid )
                        .replace( /\#\{name\}/g, member.nickname )
                        .replace( /\#\{total\}/g, getTotalHour( data[member.guid] ).toFixed( 1 ))
                        .replace( /\#\{avatar\}/g, member.avatar ))
                        .appendTo( memberEl );
                
                $.each( data[member.guid], function( index, worklog ) {
                    var hour = ( worklog.end_time - worklog.start_time ) / 3600000;
                        worklogEl = $( template.memberWorklog
                            .replace( /\#\{guid\}/g, worklog.guid )
                            .replace( /\#\{hour\}/g, hour.toFixed( 1 ))
                            .replace( /\#\{start\}/g, ( new Date( worklog.start_time )).toString( "HH:mm" ))
                            .replace( /\#\{end\}/g, ( new Date( worklog.end_time )).toString( "HH:mm" ))
                            .replace( /\#\{comments\}/g, worklog.comments || "" ))
                            .appendTo( memberEl );
                    
                    if ( worklog.comments > 0 ) {
                        worklogEl.find( ".comments" ).removeClass( "no-comment" );
                    } else {
                        worklogEl.find( ".comments" ).addClass( "no-comment" );
                    }
                    
                    var htmlContent = $( worklog.html_content );
                    if ( htmlContent.length == 1 && htmlContent.is( "p" )) {
                        worklogEl.find( ".worklog-content" ).prepend( htmlContent.html());
                    } else {
                        worklogEl.find( ".worklog-content" ).prepend( worklog.html_content );
                    }
                    
                    var periodEl = worklogEl.find( ".period" );
                    periodEl.find( "span" ).css({
                        left: Math.round(( worklog.start_time - date ) / 864000 ) + "%",
                        width: Math.max( 1, ( worklog.end_time - worklog.start_time ) / 86400000 * periodEl.width())
                    });
                                    
                    var labelsEl = worklogEl.find( ".labels" );
                    if ( worklog.labels.length ) {
                        $.each( worklog.labels, function( index, label ) {
                            $( '<a/>' , {
                                href: "/label/" + label.guid + "/",
                                text: label.name
                            }).appendTo( labelsEl );
                    
                            if ( index != worklog.labels.length - 1 ) {
                                labelsEl.append( ", " );
                            }
                        });
                    } else {
                        labelsEl.hide();
                    }
                });
            } else if ( member.is_active ) {
                noWorklogMembers.push( member );
            }
            
        });
        
        var noWorklogEl = $( ".no-worklog-members" ),
            noWorklogList = noWorklogEl.find( ".member-list" ).empty();
        if ( noWorklogMembers.length ) {
            noWorklogEl.show();
            $.each( noWorklogMembers, function( index, member ) {
                $( template.member
                    .replace( /\#\{guid\}/g, member.guid )
                    .replace( /\#\{name\}/g, member.nickname )
                    .replace( /\#\{avatar\}/g, member.avatar ))
                    .appendTo( noWorklogList );
            });
        } else {
            noWorklogEl.hide();
        }
        
        if ( noWorklog ) {
            teamWorklog.addClass( "no-worklog" );
        } else {
            teamWorklog.removeClass( "no-worklog" );
        }
        
        if ( Date.today().getTime() == date ) {
            $( "#btn-today, #btn-next" ).addClass( "disabled" );
            teamWorklog.addClass( "new-day" );
        } else {
            $( "#btn-today, #btn-next" ).removeClass( "disabled" );
            teamWorklog.removeClass( "new-day" );
        }
        
        var weekdays = ["日", "一", "二", "三", "四", "五", "六"];
        $( ".date-control .date" ).text( currentDate.toString( "yyyy年M月d日" ) + " 星期" + weekdays[currentDate.getDay()] );
    }
}

function getTotalHour( logs ) {
    var total = 0;
    $.each( logs, function( index, log ) {
        total += ( log.end_time - log.start_time ) / 3600000;
    });
    return total;
}


})( jQuery );