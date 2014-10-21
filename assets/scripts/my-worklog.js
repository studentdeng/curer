( function( $ ) {

$.preloadImages([
    "/curer/assets/images/pop-arrow.png",
    "/curer/assets/images/date-control-prev.png",
    "/curer/assets/images/date-control-next.png"
]);

var cals = {},
    currentDate = {},
    worklogs = {};

$( function() {
    
    $( window ).bind( "hashchange", function (){
        if( location.hash ) {
            var hashArray = location.hash.split( '/' ),
                date = new Date( hashArray[1] * 1 ),
                view = hashArray[0].substring(1);
            if( view == 'month' ){
                currentDate[view] = date.moveToFirstDayOfMonth();
            } else {
                currentDate[view] = date;
            }
        } else{
            var view = $( ".switch-cal-view .active" ).attr( "id" ).replace( "btn-cal-", "" ),
                date = Date.today().getTime();
            location.replace( location.href + '#' + view +'/'+ date );
            return;
        }
        
        $( '.switch-cal-view #btn-cal-'+view )
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
        
        var view = $( ".switch-cal-view .active" ).attr( "id" ).replace( "btn-cal-", "" ),
            date;
        if ( view == "day" ) {
            if ( btn.attr( "id" ) == "btn-next" ) {
                date = currentDate[view].addDays( 1 );
            } else {
                date = currentDate[view].addDays( -1 );
            }
        } else if ( view == "week" ) {
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
        
        location.hash = "#" + view + '/' + date.getTime();
    });
    
    $( "#btn-today" ).click( function( e ) {
        e.preventDefault();
        var btn = $( this );
        
        if ( btn.hasClass( "disabled" )) {
            return;
        }
        
        var view = $( ".switch-cal-view .active" ).attr( "id" ).replace( "btn-cal-", "" ),
            today = Date.today(),
            date;
        if ( view == 'week') {
            date = today.addDays( 1 ).moveToDayOfWeek( 1, -1 );
        } else if ( view == "month" ) {
            date = today.moveToFirstDayOfMonth();
        }
            
        location.hash = "#" + view + '/' + date.getTime();
    });
    
    $( ".switch-cal-view .btn" ).mousedown( function( e ) {
        e.preventDefault();
        var btn = $( this ),
            view = btn.attr( "id" ).replace( "btn-cal-", "" );
        
        if ( btn.hasClass( "active" )) {
            return;
        }
        
        btn.addClass( "active" )
            .siblings()
            .removeClass( "active" );
        
        var popboxes = $( ".popbox" );
        if ( popboxes.length ) {
            popboxes.each( function() {
                $( this ).data( "popsrc" ).popbox( "destroy" );
            });
        }
        
        location.hash = "#" + view + '/' + location.hash.split('/')[1];
        
        $.cookie( "calView", view, {
            expires: new Date( 3010, 0, 1 ),
            path: "/"
        });
    }).click( function( e ) {
        e.preventDefault();
    });
    
    if( location.hash ) {
        $( window ).trigger( "hashchange" );
    } else {
        var storedView = $.cookie( "calView" ) || "week",
            hash = "#" + storedView + "/" + Date.today().addDays( 1 ).moveToDayOfWeek( 1, -1 ).getTime();
        location.replace( location.href + hash );
    }
    
    if ( teamcola.tour ) {
        $( ".tour" ).css({
            width: $( "#my-worklog" ).width() + 40,
            "min-height": $( window ).height(),
            top: $( ".content" ).offset().top - 20
        }).show();
        
        $( "#btn-start" ).click( function( e ) {
            e.preventDefault();

            var animate = $.support.cssTransition ? "animateWithCss" : "animate";
            $( ".tour" )[animate]({
                opacity: 0
            }, 400, function() {
                $( this ).remove();
            });
        });
    }
    
});

function fetchData( view ) {
    var startDate = currentDate[view],
        start, end, endDate;
    if ( view == "day" ) {
        endDate = startDate.clone().addDays( 1 );
    } else if ( view == "week" ) {
        endDate = startDate.clone().addDays( 7 );
    } else if ( view == "month" ) {
        endDate = startDate.clone().moveToLastDayOfMonth().addDays( 1 );
    }
    
    if ( view == "month" ) {
        start = startDate.clone().moveToDayOfWeek( 1, -1 ).getTime();
        end = endDate.clone().moveToDayOfWeek( 0 ).getTime();
    } else {
        start = startDate.getTime();
        end = endDate.getTime();
    }
    
    if ( worklogs[start]) {
        loadData( worklogs );
    } else {
        //hugeLoading.show();
        $.ajax({
            url: teamcola.api.getWorklog,
            data: {
                data: $.toJSON({
                    start: start,
                    end: end
                })
            },
            success: function( result ) {
                if ( result.success ) {
                    $.extend( worklogs, result.worklogs );
                    loadData( worklogs );
                }
                //hugeLoading.hide();
            }
        });
    }
    
    function loadData( data ) {
        $( "#cal-" + view ).show()
            .siblings()
            .hide();
        
        if ( !cals[view] ) {
            cals[view] = $( "#cal-" + view ).tcal({
                editable: !teamcola.overdue,
                height: $( window ).height() - $( ".content" ).offset().top - 123,
                view: view
            });
            
            if ( view == "month" ) {
                cals[view].bind( "celldetail", function( e, date ) {
                    currentDate["day"] = date;
                    $( "#btn-cal-day" ).mousedown();
                });
            }
        }

        cals[view].tcal( "loadData", data, startDate.getTime());
        
        if ( Date.today().between( startDate, endDate.addDays( -1 ))) {
            $( "#btn-today" ).addClass( "disabled" );
        } else {
            $( "#btn-today" ).removeClass( "disabled" );
        }
        
        var weekdays = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
        if ( view == "day" ) {
            var dateStr = startDate.toString( "yyyy年M月d日" ),
                weekdayStr = weekdays[startDate.getDay()];
            $( ".date-control .date" ).text( dateStr + " " + weekdayStr );
        } else if ( view == "week" ) {
            var startStr = startDate.toString( "yyyy年M月d日" ),
                endStr = startDate.clone().addDays( 6 ).toString( "yyyy年M月d日" );
            $( ".date-control .date" ).text( startStr + " ~ " + endStr );
        } else if ( view == "month" ) {
            $( ".date-control .date" ).text( startDate.toString( "yyyy年M月" ));
        }
        
        $.cookie( view + "CurrentDate", currentDate[view].getTime(), {
            expires: new Date( 3010, 0, 1 ),
            path: "/"
        });
    }
    
}

})( jQuery );
