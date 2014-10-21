( function( $ ) {

var worklogEl = {},
    currentDate = {},
    worklogs = {},
    reachEnd = false,
    template = {
        worklogTitle: '<div class="title" title="#{month}月#{date}日 星期#{weekday}"><span class="month">#{month}月</span><span class="date">#{date}</span><span class="weekday">#{weekday}</span></div>',
        memberWorklog: '<div class="worklog"><span class="hour">#{hour}</span><span class="period" title="#{start} ~ #{end}"><span></span></span><div class="worklog-content markdown"><span class="worklog-info"><span class="labels"></span><a class="comments" href="/worklog/#{guid}/" target="_blank"><img alt="评论" src="/assets/images/icon-comment.png" /><span class="count">#{comments}</span></a></span></div></div>'
    };


$( function() {

	$( '#back-to-top' ).click( function ( e ) {
		e.preventDefault();
		window.scrollTo(0,0);
	});
		
	var winHeight = window.innerHeight;
	$( window ).scroll( function() {
		var win = $( window ),
			scrollTop = win.scrollTop();
		if( scrollTop >= winHeight*2 ) {
			$( '#back-to-top' ).show();
		} else {
			$( '#back-to-top' ).hide();
		}
	});
	

    $( '#back-to-top' ).click( function ( e ) {
        e.preventDefault();
        window.scrollTo(0,0);
    });
    
    var winHeight = window.innerHeight;
    $( window ).scroll( function() {
        var win = $( window ),
            scrollTop = win.scrollTop();
        if( scrollTop >= winHeight*2 ) {
            $( '#back-to-top' ).show();
        } else {
            $( '#back-to-top' ).hide();
        }
    });
    
    $( window ).bind( "hashchange", function (){
        if ( location.hash ) {
            var hashArray = location.hash.split( '/' ),
                date = new Date( hashArray[1]*1 ),
                view = hashArray[0].substring(1);
            if( view == 'month' ){
                currentDate[view] = date.moveToFirstDayOfMonth();
            }
            if( view == 'week') {
                currentDate[view] = date.addDays( 1 ).moveToDayOfWeek( 1, -1 );
            } 
            currentDate[view] = date;
        } else {
            var view = $( ".switch-cal-view .active" ).attr( "id" ).replace( "btn-cal-", "" );
            var date = Date.today().getTime();
            location.replace( location.href + '#' + view +'/'+ date );
            return;
        }
        
        $( '.switch-worklog-views #btn-view-'+view )
            .addClass( 'active' )
            .siblings()
            .removeClass( 'active' );
        
        fetchData( view );
    });
 
    $( "#btn-prev, #btn-next" ).click( function( e ) {
        e.preventDefault();
        var btn = $( this );
        
        if ( btn.hasClass( "disabled" )) {
            return;
        }

        var view = $( ".switch-worklog-views .active" ).attr( "id" ).replace( "btn-view-", "" ),
            date;
        if ( view == "week" ) {
            if ( btn.attr( "id" ) == "btn-next" ) {
                date = currentDate[view].moveToDayOfWeek( 1 );
            } else {
                date = currentDate[view].moveToDayOfWeek( 1, -1 );
            }
        } else if ( view == "month" ) {
            if ( btn.attr( "id" ) == "btn-next" ) {
                date = currentDate[view].moveToLastDayOfMonth().addDays( 1 );
            } else {
                date = currentDate[view].addDays( -1 ).moveToFirstDayOfMonth();
            }
        }
        location.hash = "#" + view +'/'+ date.getTime();
    });
    

    $( "#btn-today" ).click( function( e ) {
        e.preventDefault();
        var btn = $( this );
        
        if ( btn.hasClass( "disabled" )) {
            return;
        }
        
        var view = $( ".switch-worklog-views .active" ).attr( "id" ).replace( "btn-view-", "" ),
            date;
        if ( view == 'week') {
            date = Date.today().addDays( 1 ).moveToDayOfWeek( 1, -1 );
        } else {
            date = Date.today().moveToFirstDayOfMonth();
        }
        
        location.hash = "#" + view + '/' + date.getTime();;
    });
    
    $( ".switch-worklog-views .btn" ).mousedown( function( e ) {
        e.preventDefault();
        var btn = $( this );
        
        if ( btn.hasClass( "active" )) {
            return;
        }
        
        btn.addClass( "active" )
            .siblings()
            .removeClass( "active" );
        
        var view = btn.attr( "id" ).replace( "btn-view-", "" );
        
        if ( view == "list" ) {
            $.scrollrefresh( "resume" );
        } else {
            $.scrollrefresh( "pause" );
        }
        
        var popboxes = $( ".popbox" );
        if ( popboxes.length ) {
            popboxes.each( function() {
                $( this ).data( "popsrc" ).popbox( "destroy" );
            });
        }
        
        var date;
        if ( location.hash ) {
            date = new Date( location.hash.split('/')[1] * 1 );
        } else {
            date = Date.today().addDays( 1 ).moveToDayOfWeek( 1, -1 );
        }
        
        location.hash = "#" + view + '/' + date.getTime();
    }).click( function ( e ) {
        e.preventDefault();
    });
    
    $( ".scroll-loading" ).click( function( e ) {
        e.preventDefault();
        if ( $( this ).hasClass( "loading" )) {
            return;
        }
        fetchData( "list" );
    });
    
    $( "#worklog-list .worklog" ).live( "mouseenter", function() {
        $( this ).addClass( "over" );
    }).live( "mouseleave", function() {
        $( this ).removeClass( "over" );
    });
    
    if ( !teamcola.tour ) {
        $.scrollrefresh({
            offset: 80,
            callback: function() {
                if ( $( ".scroll-loading" ).hasClass( "loading" ) || reachEnd ) {
                    return;
                }
                fetchData( "list" );
            }
        });
        
        if( location.hash ) {
            $( window ).trigger( "hashchange" );
        } else {
            var hash =  "#list/" +Date.today().addDays( 1 ).getTime();
            location.replace( location.href + hash );
        }
    }
});


function fetchData( view ) {
    var start, end, startDate, endDate;
    if ( view == "list" ) {
        endDate = currentDate[view];
        // startDate = endDate.clone().addDays( -5 );
    } else if ( view == "week" ) {
        startDate = currentDate[view];
        endDate = startDate.clone().addDays( 7 );
    } else if ( view == "month" ) {
        startDate = currentDate[view];
        endDate = startDate.clone().moveToLastDayOfMonth().addDays( 1 );
    }
    
    start = startDate ? startDate.getTime() : null;
    end = endDate.getTime();
    if ( worklogs[start]) {
        loadData( worklogs );
    } else {
        
        var params = {
            end: end,
            members: [teamcola.member.guid]
        };
        
        if ( view == "list" ) {
            var loadingEl = $( ".scroll-loading" ).addClass( "loading" );
            loadingEl.find( "span" ).text( "正在加载..." );
            params.max = 20;
        } else {
            hugeLoading.show();
            params.start = start;
        }
        
        $.ajax({
            url: teamcola.api.getWorklog,
            data: {
                data: $.toJSON( params )
            },
            success: function( result ) {
                if ( result.success ) {
                    $.extend( worklogs, result.worklogs );
                    loadData( worklogs );
                }
                
                hugeLoading.hide();
                
                if ( result.end ) {
                    reachEnd = true;
                    $( ".scroll-loading" ).css( "visibility", "hidden" );
                }
            }
        });
    }
    
    function loadData( data ) {
        
        $( "#worklog-" + view ).show()
            .siblings()
            .hide();
        
        if ( !worklogEl[view] ) {
            worklogEl[view] = $( "#worklog-" + view );
            if ( view != "list" ) {
                worklogEl[view].tcal({
                    height: $( window ).height() - $( ".content" ).offset().top - 123,
                    view: view,
                    editable: false
                });
                
                if ( view == "month" ) {
                    worklogEl[view].bind( "cellpopover", function( e, el ) {
                        el.find( ".buttons" ).hide();
                    });
                }
            }
        }
        
        if ( view == "list" ) {
            $( ".date-control" ).hide();
            
            $( ".scroll-loading" ).removeClass( "loading" )
                .find( "span" )
                .text( "加载更多" );
            
            var worklogsWrapper = $( ".worklogs-wrapper" ),
                weekdays = ["日", "一", "二", "三", "四", "五", "六"],
                date = end - 86400000,
                noWorklogBuffer = [];
            
            console.log(date);
            while ( worklogs[date]) {
                var dateObj = new Date( date ),
                    logs = data[date];
                if ( !logs || !logs.length ) {
                    noWorklogBuffer.push( dateObj );
                    date -= 86400000;
                    continue;
                }
                
                if ( noWorklogBuffer.length ) {
                    var noWorklogStr;
                    if ( noWorklogBuffer.length > 1 ) {
                        var noWorklogStart = noWorklogBuffer[noWorklogBuffer.length - 1],
                            noWorklogEnd = noWorklogBuffer[0];
                        noWorklogStr = noWorklogStart.toString( "M月d日" ) + "(星期" + weekdays[noWorklogStart.getDay()] + ") ~ "
                            + noWorklogEnd.toString( "M月d日" ) + "(星期" + weekdays[noWorklogEnd.getDay()] + ") 没有工作记录";
                    } else {
                        noWorklogStr = noWorklogBuffer[0].toString( "M月d日" ) + "（星期" + weekdays[noWorklogBuffer[0].getDay()] + "） 没有工作记录";
                    }
                    $( '<div class="worklogs no-worklog"></div>' )
                        .text( noWorklogStr )
                        .appendTo( worklogsWrapper );
                    noWorklogBuffer.length = 0;
                }
                
                var worklogsEl = $( '<div class="worklogs"></div>' ).appendTo( worklogsWrapper );
                
                if ( dateObj.getDay() == 6 || dateObj.getDay() == 0 ) {
                    worklogsEl.addClass( "vocation" );
                }
                
                $( template.worklogTitle
                    .replace( /\#\{month\}/g, dateObj.getMonth() + 1 )
                    .replace( /\#\{date\}/g, dateObj.getDate())
                    .replace( /\#\{weekday\}/g, weekdays[dateObj.getDay()] ))
                    .appendTo( worklogsEl );
                
                $.each( logs, function( index, worklog ) {
                    var hour = ( worklog.end_time - worklog.start_time ) / 3600000;
                        worklogEl = $( template.memberWorklog
                            .replace( /\#\{guid\}/g, worklog.guid )
                            .replace( /\#\{hour\}/g, hour.toFixed( 1 ))
                            .replace( /\#\{start\}/g, ( new Date( worklog.start_time )).toString( "HH:mm" ))
                            .replace( /\#\{end\}/g, ( new Date( worklog.end_time )).toString( "HH:mm" ))
                            .replace( /\#\{content\}/g, worklog.content )
                            .replace( /\#\{comments\}/g, worklog.comments || "" ))
                            .appendTo( worklogsEl );
                    
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
                
                date -= 86400000;
            }
            
            currentDate[view] = new Date( date + 86400000 );
        } else {
            $( ".date-control" ).show();
            
            worklogEl[view].tcal( "loadData", data, start );
            
            if ( Date.today().between( startDate, endDate.addDays( -1 ))) {
                $( "#btn-today" ).addClass( "disabled" );
            
            } else {
                $( "#btn-today" ).removeClass( "disabled" );

            }
            var weekdays = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
            if ( view == "week" ) {
                var startStr = startDate.toString( "yyyy年M月d日" ),
                    endStr = startDate.clone().addDays( 6 ).toString( "yyyy年M月d日" );
                $( ".date-control .date" ).text( startStr + " ~ " + endStr );
            } else if ( view == "month" ) {
                $( ".date-control .date" ).text( startDate.toString( "yyyy年M月" ));
            }
        }
    }
    
}


})( jQuery );