( function( $ ) {

var datepickerPanel,
    chart,
    chartOpts,
    endDate = Date.today(),
    startDate = endDate.clone().addDays( -30 ),
    dateUnit = 1,
    template = {
        tr: '<tr guid="#{guid}">\
                <td class="col-num">#{num}.</td>\
                <td class="col-target"></td>\
                <td class="col-hour">\
                    <span class="hour">#{amount}</span>\
                </td>\
                <td class="col-ratio">\
                    <div class="ratio-bar"></div>\
                    <span class="ratio-num">#{ratio}</span>\
                </td>\
            </tr>'
    };

$( function() {
    chartOpts = {
        chart: {
            renderTo: "chart",
            type: "area"
        },
        title: {
            text: null,
        },
        xAxis: {
            tickmarkPlacement: "on"
        },
        yAxis: {
            title: {
                text: null
            }
        },
        tooltip: {
            formatter: function() {
                    return this.x +': '+ this.y +'小时';
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: '工时',
            data: [],
            color: "#008cd8",
            fillOpacity: .1
        }],
        credits: {
            enabled: false
        }
    };
    
    $( ".switch-date-unit .btn" ).mousedown( function( e ) {
        e.preventDefault();
        
        $( this ).addClass( "active" )
            .siblings( ".btn" )
            .removeClass( "active" );
        
        if ( this.id == "btn-unit-day" ) {
            dateUnit = 1;
        } else if ( this.id == "btn-unit-week" ) {
            dateUnit = 7;
        }
        
        fetchData();
    }).click( function( e ) {
        e.preventDefault();
    });
    
    $( "#btn-change-date" ).click( function( e ) {
        e.preventDefault();
        fetchData();
        datepickerPanel.hide();
        $( "#choose-period .start" ).text( startDate.toString( "yyyy年M月d日" ));
        $( "#choose-period .end" ).text( endDate.toString( "yyyy年M月d日" ));
    });
    
    $( "#choose-period" ).click( function( e ) {
        e.preventDefault();
        
        if ( !datepickerPanel ) {
            initDatepicker( $( this ));
        } else {
            datepickerPanel.toggle();
        }
        
        return false;
    });
    
    $( document ).click( function( e ) {
        $( "#choose-date-panel" ).hide();
    });
    
    if ( !teamcola.tour ) {
        var start = $.cookie( "statsStartDate" ),
            end = $.cookie( "statsEndDate" );
        if ( start ) {
            startDate = new Date( start * 1 );
        }
        if ( end ) {
            endDate = new Date( end * 1 );
        }
        
        $( "#choose-period .start" ).text( startDate.toString( "yyyy年M月d日" ));
        $( "#choose-period .end" ).text( endDate.toString( "yyyy年M月d日" ));
        
        dateUnit = $.cookie( "dateUnit" ) || 1;
        if ( dateUnit == 7 ) {
            $( "#btn-unit-week" ).mousedown();
        } else {
            $( "#btn-unit-day" ).mousedown();
        }
    }
});

function initDatepicker( target ) {
    var offset = target.offset();
    
    datepickerPanel = $( "#choose-date-panel" );
    datepickerPanel.click( function( e ) {
        return false;
    }).css({
        top: offset.top + target.outerHeight() + 2,
        left: offset.left + target.outerWidth() - datepickerPanel.outerWidth()
    }).show();
    
    $( "#rangepicker" ).datepicker({
        dateFormat: "yy-mm-dd",
        numberOfMonths: 3,
        maxDate: Date.today().addDays( 1 ),
        showAnim: "", 
        beforeShowDay: function( date ) {
            var selectable = ( date.getTime() < Date.today().addDays( 1 ).getTime()),
                selected = date.between( startDate, endDate ),
                tooltip = date.toString( "M月d日" );
            return [selectable, selected ? "selected" : "", tooltip];
        },
        onSelect: function( selectedDate ) {
            var date = Date.parse( selectedDate, "yyyy-MM-dd" );
            
            if ( startDate.getTime() == endDate.getTime()) {
                if ( date.getTime() <= startDate.getTime()) {
                    startDate = date;
                } else {
                    endDate = date;
                }
            } else {
                startDate = date;
                endDate = date;
            }
        }
    });
    
    $( "#link-range-week" ).click( function( e ) {
        e.preventDefault();
        endDate = Date.today();
        startDate = endDate.clone().addDays( -7 );
        $( "#rangepicker" ).datepicker( "refresh" );
    });
    
    $( "#link-range-month" ).click( function( e ) {
        e.preventDefault();
        endDate = Date.today();
        startDate = endDate.clone().addDays( -30 );
        $( "#rangepicker" ).datepicker( "refresh" );
    });
    
    $( "#link-range-quater" ).click( function( e ) {
        e.preventDefault();
        endDate = Date.today();
        startDate = endDate.clone().addDays( -90 );
        $( "#rangepicker" ).datepicker( "refresh" );
    });
}

function fetchData() {
    var start = startDate.getTime(),
        end = endDate.clone().addDays( 1 ).getTime();
    
    if ( dateUnit == 7 && startDate.getDay() != 1 ) {
        start = startDate.clone().moveToDayOfWeek( 1, -1 ).getTime();
    }
    
    if ( dateUnit == 7 && endDate.getDay() != 0 ) {
        end = endDate.clone().moveToDayOfWeek( 0 ).getTime();
    }
    
    hugeLoading.show();
    $.ajax({
        url: "/curer/index.php/cola/stats/chat",
        data: {
            data: $.toJSON({
                start: start,
                end: end,
                interval: dateUnit,
                team: teamcola.team,
                member: teamcola.member,
                label: teamcola.label,
                type: teamcola.type
            })
        },
        success: function( result ) {
            if ( chart ) {
                chart.destroy();
            }
            
            var step;
            if ( dateUnit == 7 ) {
                step = Math.round( result.chart.categories.length / 10 ) || 1;
            } else {
                step = Math.round( result.chart.categories.length / 15 ) || 1;
            }
            
            chartOpts.xAxis.labels = {
                step: step,
                y: 20
            };
            chartOpts.xAxis.categories = result.chart.categories;
            chartOpts.series[0].data = result.chart.data;
            
            chart = new Highcharts.Chart( chartOpts );
            
            renderTable( result.table );
            hugeLoading.hide();
            
            $.cookie( "statsStartDate", startDate.getTime(), {
                path: "/stats/"
            });
            $.cookie( "statsEndDate", endDate.getTime(), {
                path: "/stats/"
            });
            $.cookie( "dateUnit", dateUnit, {
                path: "/stats/"
            });
        }
    });
}

function renderTable( rows ) {
    var tbody = $( ".stats-table tbody" ).empty();
    $.each( rows, function( index, row ) {
        var tr = $( template.tr
            .replace( /\#\{guid\}/g, row.guid )
            .replace( /\#\{amount\}/g, ( row.amount / 3600 ).toFixed( 1 ))
            .replace( /\#\{ratio\}/g, Math.round( row.percent * 100 ) + "%" )
            .replace( /\#\{num\}/g, index + 1 ))
            .appendTo( tbody );
        
        var titleTd = tr.find( ".col-target" );
        $.each( row.title, function( j, title ) {
            if ( title.avatar ) {
                $( "<img />", {
                    src: title.avatar,
                    alt: title.name
                }).appendTo( titleTd );
            }
            
            var el;
            if ( title.url ) {
                el = $( "<a />", {
                    href: title.url,
                    text: title.name
                }).appendTo( titleTd );
            } else {
                el = $( "<span />", {
                    text: title.name
                }).appendTo( titleTd );
            }
        });
        
        if ( row.sub_title ) {
            $( "<span class='sub'>-</span>" )
                .appendTo( titleTd );
            
            $.each( row.sub_title, function( j, title ) {
                if ( title.avatar ) {
                    $( "<img />", {
                        "class": "sub",
                        src: title.avatar,
                        alt: title.name
                    }).appendTo( titleTd );
                }
            
                var el;
                if ( title.url ) {
                    el = $( "<a />", {
                        href: title.url,
                        text: title.name
                    });
                } else {
                    el = $( "<span />", {
                        text: title.name
                    });
                }
            
                el.addClass( "sub" )
                    .appendTo( titleTd );
            });
        }
        
        if ( index % 2 != 0 ) {
            tr.addClass( "odd" );
        }
        
        setTimeout( function() {
            tr.find( "td.col-ratio .ratio-bar" ).css({
                width: 260 * row.percent
            });
        }, 200 );
    });
    
    tbody.data( "initialized", true );
}

})( jQuery );
