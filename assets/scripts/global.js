( function( $ ) {

if ( $.cookie && $.isFunction( $.cookie )) {
    var tz = - ( new Date()).getTimezoneOffset() / 60;

    $.cookie( "tz", '' + tz, {
        expires: new Date( 3010, 0, 1 ),
        path: "/"
    } );
}

window.iPad = navigator.userAgent.match(/iPad/i) ? true : false;

$.ajaxSetup({
    type: "POST",
    dataType: "json",
    data: {
        timezone: tz
    },
    error: function( jqXHR, textStatus, errorThrown ) {
        var result = $.parseJSON( jqXHR.responseText );
        if ( !result ) {
            return;
        }
        
        $.message({
            content: result.msg
        });
    }
});

var bodyStyle = ( document.body || document.documentElement ).style;
$.support.cssTransition = bodyStyle.WebkitTransition !== undefined
    || bodyStyle.MozTransition !== undefined
    || bodyStyle.OTransition !== undefined
    || bodyStyle.transition !== undefined;

$.preloadImages = function( images ) {
    $.each( images, function( i, img ) {
        var preload = new Image();
        preload.src = img;
    });
}
$.preloadImages([
    "/curer/assets/images/tiny-loading.gif",
    "/curer/assets/images/huge-loading.gif"
]);


$.scrollrefresh = function( opts ) {
    if ( typeof opts == "object" ) {
        $.scrollrefresh.opts = opts;
        $( window ).bind( "scroll.scrollrefresh", onScroll );
    } else if ( typeof opts == "string" && opts == "pause" ) {
        $( window ).unbind( "scroll.scrollrefresh" );
    } else if ( typeof opts == "string" && opts == "resume" ) {
        $( window ).unbind( "scroll.scrollrefresh" )
            .bind( "scroll.scrollrefresh", onScroll );
    }
    
    function onScroll( e ) {
        var win = $( window ),
            opts = $.scrollrefresh.opts,
            scrollTop = win.scrollTop();
        if ( scrollTop <= 0 ) {
			return;
        }
        if ( scrollTop + win.height() >= document.body.scrollHeight - opts.offset ) {
            opts.callback();
        }
    }
}

$.fn.selectRange = function( start, end ) {
    end = end || start;
    return this.each( function() {
        if ( this.setSelectionRange ) {
            this.focus();
            this.setSelectionRange( start, end );
        } else if ( this.createTextRange ) {
            var range = this.createTextRange();
            range.collapse( true );
            range.moveEnd( 'character', end );
            range.moveStart( 'character', start );
            range.select();
        }
    });
};

// fuck ie
if ( !Array.prototype.indexOf ) {
    Array.prototype.indexOf = function( value, from ){
        var len = this.length,
            from = Number( arguments[1] ) || 0;

        from = ( from < 0 ) ? Math.ceil( from ) : Math.floor( from );
        if ( from < 0 ) {
            from += len;
        }

        for ( ; from < len; from++ ) {
            if ( from in this && this[from] === value ) {
                return from;
            }
        }
        return -1;
    };
}

$( function() {
    // touch event for ipad
    if ( iPad ) {
        $( document ).bind( "touchstart.touch", function( e ) {
            if ( e.originalEvent.touches.length > 1 ) {
                return;
            }
            
            var target = $( e.target ),
                originX = e.originalEvent.touches[0].pageX,
                originY = e.originalEvent.touches[0].pageY,
                deltaX,
                deltaY;
            var longPressTimer = setTimeout( function() {
                $( document ).unbind( "touchmove.touch touchend.touch" );
                target.trigger( "press", e );
            }, 600 );
            
            $( document ).bind( "touchmove.touch", function( e ) {
                var pageX = e.originalEvent.touches[0].pageX,
                    pageY = e.originalEvent.touches[0].pageY,
                    deltaX = Math.abs( pageX - originX ),
                    deltaY = Math.abs( pageY - originY );
                
                if ( deltaX < 5 && deltaY < 5 ) {
                    return;
                }
                
                clearTimeout( longPressTimer );
                $( document ).unbind( "touchmove.touch touchend.touch" );
            });
            
            $( document ).bind( "touchend.touch", function( e ) {
                if ( deltaX < 5 && deltaY < 5 ) {
                    return;
                }
                
                clearTimeout( longPressTimer );
                $( document ).unbind( "touchmove.touch touchend.touch" );
                target.trigger( "tap", e );
            });
        });
        
        $( "#feedback" ).hide();
    }
    
    $( ".nav li" ).hover(
        function() {
            $( this ).addClass( "over" );
        },
        function() {
            $( this ).removeClass( "over" );
        }
    );
    
    var seconds = 30;
    $( "#resend-verified" ).live( "click", function( e ) {
        var link = $( this );
        
        if ( link.hasClass( "disabled" )) {
            return;
        }
        
        tinyLoading.show( link );
        $.ajax({
            url: "/email/reconfirm/",
            success: function( result ) {
                tinyLoading.hide( link );

                $.message({
                    content: "验证邮件已经发送到你的新邮箱中，现在就去验证吧"
                });
                
                tick();
            }
        });
        
        function tick() {
            if ( seconds < 1 ) {
                link.removeClass( "disabled" )
                    .text( "重新发送验证邮件" );
                seconds = 30;
                return;
            }
            
            link.addClass( "disabled" )
                .text( "重新发送验证邮件(" + seconds + ")" );
            seconds--;
            setTimeout( tick, 1000 );
        }

    });

    if ( iPad && $( ".header-team" ).hasClass( "hover" )) {
        $( ".header-team" )
            .removeClass( "hover" )
            .bind( "click", function( e ) {
                e.stopPropagation();

                var target = $( e.target ),
                    curTarget = $( e.currentTarget ),
                    list = $( "#switch-list" ),
                    doc = $( document );

                if ( list.is( ":hidden" )) {
                    e.preventDefault();
                    list.show();
                    curTarget.addClass( "active" );

                    doc.bind( "touchstart", function( e ) {
                        var target = $( e.target );

                        if ( !target.is( ".header-team" )
                                && !target.parents( ".header-team" ).length ) {
                            list.hide();
                            curTarget.removeClass( "active" );
                            doc.unbind( "touchstart" );
                        }
                    });
                }
            });
    }
    
    Feedback.init();
});

window.tinyLoading = {
    show: function( target ) {
        var loadingEl = $( '<div class="tiny-loading"><img alt="Loading..." src="/assets/images/tiny-loading.gif"/></div>' );
        
        loadingEl.css({
            display: target.css( "display" ),
            "float": target.css( "float" ),
            position: target.css( "position" ),
            top: target.css( "top" ),
            left: target.css( "left" ),
            width: target.outerWidth(),
            height: target.outerHeight(),
            "line-height": target.outerHeight() + "px"
        }).insertBefore( target );
        
        target.hide()
            .data( "loadingEl", loadingEl );
    },
    hide: function( target ) {
        target.show()
            .data( "loadingEl" )
            .remove();
    }
};

window.hugeLoading = {
    show: function( msg ) {
        var el = $( ".huge-loading" ),
            msg = msg || "正在加载",
            header = $( ".header" ),
            top = Math.max( header.offset().top - $( window ).scrollTop(), 0 );
        
        if ( el.length ) {
            el.text( msg );
        } else {
            el = $( '<div class="huge-loading"></div>' )
                .text( msg )
                .appendTo( "body" );
        }
        
        el.css({
            marginLeft: 0 - el.outerWidth() / 2,
            top: top
        }).show();
    },
    hide: function() {
        var el = $( ".huge-loading" );
        if ( el.length ) {
            el.hide();
        }
    }
};

window.resultMsg = function( options ) {
    var opts = $.extend( {
            msg: "保存成功",
            type: "success",
            delay: 5000,
            css: {}
        }, options ),
        $msg = opts.target.next( "span.result-msg" );

    if ( !opts.target ) return false
    if ( $msg.length ) $msg.remove();

    $( "<span/>", {
        text: opts.msg,
        "class": "result-msg",
        css: opts.css
    }).addClass( opts.type )
    .insertAfter( opts.target )
    .delay( opts.delay )
    .fadeOut();
};

window.labelColors = [
    "#aaaaaa",
    "#ed9a51",
    "#e3886f",
    "#d96666",
    "#a47768",
    "#a6887d",
    "#e1c44f",
    "#99b869",
    "#90a342",
    "#5e966f",
    "#62b298",
    "#75b7cd",
    "#72abd7",
    "#808fda",
    "#6383cc",
    "#b48fd2",
    "#9073b8",
    "#ce78c0",
    "#d98aaa",
    "#777777",
    "#444444"
];

window.RGBToHex = function( rgb ) {
    var regexp = /^rgb\(([0-9]{0,3})\,\s([0-9]{0,3})\,\s([0-9]{0,3})\)/g;
    var re = rgb.replace(regexp, "$1 $2 $3").split(" ");//利用正则表达式去掉多余的部分  

    if ( re.length == 1 ) {
        return rgb
    }

    var hexColor = "#";  
    var hex = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F'];  

    for ( var i = 0; i < 3; i++ ) {  
        var r = null;  
        var c = re[i];  
        var hexAr = [];  

        while (c > 16) {  
            r = c % 16;  
            c = (c / 16) >> 0;  
            hexAr.push(hex[r]);
        }

        hexAr.push(hex[c]);
        if ( hexAr.length == 1 ) hexAr.push( 0 );
        hexColor += hexAr.reverse().join('');
    }  

    return hexColor;
}

window.Tips = {
    show: function( opt ) {
        opt = $.extend({
                color: "red",
                autoHide: true
            },opt );

        if ( !opt.target || !opt.content ) return

        opt.target.next( ".valid-tip" ).remove();

        $( "<span class=valid-tip>" + opt.content + "</span>" )
            .css({
                "color": "red",
                "marginLeft": "10px"
            })
            .insertAfter( opt.target )
            .delay( 5000 )
            .fadeOut( function() {
                $( this ).remove();   
            });
    },

    clear: function() {
        $( "span.valid-tip" ).remove();
    }
}

window.getStrCharNum = function( str ){
    return str.replace(/[^\x00-\xff]/g,"**").length;
}

/*
 * Feedback
 */
var Feedback = {

    init: function() {
        $( "#feedback" ).click( Feedback.buildForm );
    },

    buildForm: function( e ) {
        e.preventDefault();

        $.Shortcuts.add({
            type: "down",
            mask: "Ctrl+Enter",
            enableInInput: true,
            list: "lightbox",
            handler: Feedback.submit
        }).start();

        $.lightbox({
            content: "<div id=lb-feedback class=feedback>" +
                        "<div class=feedback-form>" +
                            "<label for=fb-content>把你要说的写在这里：</label><br />" +
                            "<textarea id=fb-content></textarea><br /><span style='font-size:12px;position:absolute;bottom:36px;right:55px;'>想要更多功能？<a href='http://iwish.mycolorway.com/tc/' target='_blank'>来这里许个愿吧</a></span>" +
                        "</div>" +
                    "</div>",
            buttons: [{
                    type: "button",
                    text: "完成",
                    handler: Feedback.submit
                }, {
                    type: "cancel",
                    text: "取消",
                    handler: function() {
                        $.lightbox( "hide" );
                    }
            }],
            onHide: function() {
                $.Shortcuts.start();
            },
            width: 500
        });
    },

    submit: function( e ) {
        e.preventDefault();

        var target = $( e.target ),
            content = $( "#fb-content" ),
            contentVal = $.trim( content.val() );
        
        if ( contentVal == "" ) {
            Tips.show({
                target: content.siblings( "label" ),
                content: "别急，还没有写意见呢"
            });

            content.focus();
            return false
        }
        
        var data = {
            content: contentVal,
            windowHeight: $( window ).height().toString(),
            windowWidth: $( window ).width().toString(),
            screenWidth: screen.width.toString(),
            screenHeight: screen.height.toString(),
            url: window.location.href
        };

        tinyLoading.show( target );

        $.ajax({
            url: "/feedback/",
            data: { data: $.toJSON( data ) },
            success: function( result ) {
                tinyLoading.hide( target );

                if ( result.success ) {
                    $.lightbox({
                        content: "<div id=lb-feedback class=feedback>" + 
                                    "<div class=feedback-success>" +
                                        "<span class=feedback-desc>" + 
                                            "已经把你说的发送给了TeamCola团队。<br/>" + 
                                            "你可以随时通过 m2@teamcola.com 与他们联系，" +
                                            "谢谢你的反馈 :)" + 
                                        "</span>" +
                                    "</div></div>",
                        buttons: [{
                            type: "button",
                            text: "不用客气，关闭窗口",
                            handler: function() {
                                $.lightbox( "hide" );
                            }
                        }],
                        width: 500
                    });
                } else {
                    
                }
            },
            error: function( error ) {
                
            }
        });
    }
}

var serverTimezone = 8;
window.serverTime = function( date ) {
    var utcTime = date * 1 + Date.today().getTimezoneOffset() * 60000;
    return utcTime + 3600000 * serverTimezone;
}
window.localTime = function( date ) {
    var utcTime = date * 1 - 3600000 * serverTimezone;
    return utcTime - Date.today().getTimezoneOffset() * 60000;
}
window.now = function() {
    return new Date( serverTime( new Date().getTime()));
}


})( jQuery );
