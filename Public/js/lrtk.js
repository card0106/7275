/*
 name : yanggang;
 QQ:392017299;
 E-mail:yanggang1@conew.com;
 */
window.navigator.userAgent,clearAnimatea = null;
var testStyle=document.createElement('div').style,
camelCase=function(str){
    return str.replace(/^-ms-/, "ms-").replace(/-([a-z]|[0-9])/ig, function(all, letter){
        return (letter+"").toUpperCase();
    });
},
cssVendor=(function(){
    var ts=testStyle,
        cases=['-o-','-webkit-','-moz-','-ms-',''],i=0;
    do {
        if(camelCase(cases[i]+'transform') in ts){
            return cases[i];
        }
    } while(++i<cases.length);
    return '';
})(),

isCSS = function(property){
   
};
var liebaoBrowser = {
    domAnimation: function(ele){
        ele.detBtn.hover(function(){
            $(this).addClass('btn-hover');
        },function(){
            $(this).removeClass('btn-hover');
        });
        ele.navhover.hover(function(){
            $(this).find("i").addClass('nav-hover');
        },function(){
            $(this).find("i").removeClass('nav-hover');
        });
        ele.downBtn.hover(function(){
            $(this).addClass('down-btn');
        },function(){
            $(this).removeClass('down-btn');
        });
        ele.watchLb.hover(function(){
            ele.code.addClass('code-show').show();
        },function(){
            ele.code.removeClass('code-show').hide();
        });
        ele.fnLi.hover(function(){
            var radiusEle = $(this).find('div');
            $(this).addClass('span-img');
            if(ele.aniMation){
                radiusEle.addClass('zoom');
            }else{
                radiusEle.show();
            }
        },function(){
            var radiusEle = $(this).find('div');
            $(this).removeClass('span-img');
            if(ele.aniMation){
                radiusEle.removeClass('zoom');
            }else{
                radiusEle.hide();
            }
        });
    },
    banSlide: function(item,time,ele,speed){
        clearTimeout(clearAnimatea);
        var length = ele.slide.length- 1;
        /*自动播放*/
        function autoPlay() {
            item++;
            if (item == length+1) {
                item = 0;
                aniObj(item);
            }else{
                aniObj(item);
            }
            spanCur(item);
            clearAnimatea = setTimeout(autoPlay, time);
        }
        clearAnimatea = setTimeout(autoPlay, time);
        /*点击切换动画*/
        function slidePrev(e){
            e.preventDefault();
            if(!ele.slide.is(':animated')){
                if (item == 0) {
                    item = length;
                    aniObj(item);
                } else {
                    item--;
                    aniObj(item);
                }
                spanCur(item);
            }
        };
        function slideNext(e){
            e.preventDefault();
            if(!ele.slide.is(':animated')){
                if (item == length) {
                    item = 0;
                    aniObj(item);
                } else {
                    item++;
                    aniObj(item);
                }
                spanCur(item);
            }
        };
        /* 点击切换动画 */
        ele.slideCur.click(function() {
            clearTimeout(clearAnimatea);
            ele.slideCur.removeClass('cur');
            $(this).addClass('cur');
            item = $(this).index();
            if (item <= length) {
                aniObj(item);
            }
        });
        /*执行动画方法*/
        function aniObj(getNum){
            ele.slide.hide().css({ opacity: 0.5,zIndex: 0});
            ele.slide.eq(getNum).show().stop(true,true).animate({opacity:1,zIndex:8},speed);
            if(ele.aniMation){
                ele.slide.removeClass('banAnimate');
                ele.slide.eq(getNum).addClass('banAnimate');
            }
        }
        /*当前动画指示*/
        function spanCur(eqNum) {
            ele.slideCur.removeClass('cur');
            ele.slideCur.eq(eqNum).addClass('cur');
        }
        /* 触发执行事件 */
        ele.prev.click(slidePrev);
        ele.next.click(slideNext);
        /* 手机上执行touch事件 */
      
        /*初始化动画*/
        ele.slide.eq(0).show().addClass('banAnimate');
    },

 
    
    init: function(ele){
        liebaoBrowser.banSlide(0,4200,ele,500);
    }
};
$(function(){
    var domEle = {
		navhover: $('.nav-main a'), detBtn: $('.details'),
		maxImg: $('.news-img'), fnLi: $('.ft-list li'), 
		aniMation: isCSS('animation'), watchLb: $('#watch-lb'), 
		code: $('.watch-code'), 
		downBtn: $('.beta-info a'), 
		downlaodMain: $('.downlaod-main'), 
		windowMain: $(window), 
		bodyEle: $('body'), 
		stopAnimte: $('.slide,.prev,.next,.item'), 
		prev: $('.prev'),
		next: $('.next'), 
		slide: $('.slide'), 
		slideCur: $('.item a'),
		phoneImg: $('.phone-img'),
		codeImg: $('.code-img') 
	};
	liebaoBrowser.init(domEle);
});
