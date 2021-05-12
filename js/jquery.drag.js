$.fn.extend({
    //---元素拖动插件
    dragging: function (data) {
        var $this = $(this);//只在调用dragging()的时候获取一次。
        var xPage;//实时的鼠标x点
        var yPage;//实时的鼠标y点
        var X;//按下时鼠标的x点
        var Y;//按下时鼠标的y点
        var xRand = 0;//
        var yRand = 0;//
        var father = $this.parent();
        var defaults = {
            move: 'both',
            randomPosition: true,
            hander: 1
        }
        var opt = $.extend({}, defaults, data);
        var movePosition = opt.move;
        var random = opt.randomPosition;

        var hander = opt.hander;

        if (hander === 1) {
            hander = $this;//hander是触发的元素
        } else {
            hander = $this.find(opt.hander);//hander是触发元素内部指定的子元素
        }

        //---初始化
        father.css({ "overflow": "hidden" });
        $this.css({ "position": "absolute" });
        hander.css({ "cursor": "move" });

        var windowWidth = $(window.top).width();//添加
        var windowHeight = $(window.top).height();//添加
        var faWidth = father.width();
        var faHeight = father.height();
        var thisWidth = $this.width() + parseInt($this.css('padding-left')) + parseInt($this.css('padding-right'));//获取初始宽度
        var thisHeight = $this.height() + parseInt($this.css('padding-top')) + parseInt($this.css('padding-bottom'));//获取初始高度

        // console.log($this);
        // console.log($this.width());
        // console.log($this.height());
        // console.log(parseInt($this.css('padding-left')));
        // console.log(parseInt($this.css('padding-right')));
        // console.log(`thisWidth ${thisWidth},thisHeight ${thisHeight}`)

        //设置可拖拽图片的初始位置
        $this.css('cssText',"position:absolute;left:"+ windowWidth/2+"px;margin-left:-"+thisWidth/2+"px;top:"+windowHeight/2+"px;margin-top:-"+thisHeight/2+"px;z-index:6666;")
        // $this.css('cssText',"position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);z-index:6666;")

        var mDown = false;//
        var positionX;//按下鼠标时，图片绝对定位的位置，但是不包含margin值，所以不是图片实际的位置
        var positionY;
        var moveX;
        var moveY;

        if (random) {
            $thisRandom();
        }
        function $thisRandom() { //随机函数
            $this.each(function (index) {
                var randY = parseInt(Math.random() * (faHeight - thisHeight));///
                var randX = parseInt(Math.random() * (faWidth - thisWidth));///
                if (movePosition.toLowerCase() == 'x') {
                    $(this).css({
                        left: randX
                    });
                } else if (movePosition.toLowerCase() == 'y') {
                    $(this).css({
                        top: randY
                    });
                } else if (movePosition.toLowerCase() == 'both') {
                    $(this).css({
                        top: randY,
                        left: randX
                    });
                }

            });
        }

        // var downX,downY,upX,upY,oldElementLeft,oldElementTop;

        hander.mousedown(function (e) {
            // console.log('hander')
            // father.children().css({ "zIndex": "0" });
            $this.css({ "zIndex": "6666" });
            mDown = true;
            X = e.pageX;//按下时鼠标的x点
            Y = e.pageY;//按下时鼠标的y点
            // downX = e.pageX;//按下时鼠标的x点
            // downY = e.pageY;//按下时鼠标的y点
            positionX = $this.position().left;//按下鼠标时图片绝对定位的位置，但是不包含margin值，所以不是图片实际的位置
            positionY = $this.position().top;
            // oldElementLeft = $this.offset().left;//鼠标按下时时图片的left值
            // oldElementTop = $this.offset().top;//鼠标按下时时图片的top值
            // oldElementLeft = $this.position().left+$this.width()/2;//鼠标按下时时图片的left值
            // oldElementTop = $this.position().top+$this.height()/2;//鼠标按下时时图片的top值
            // console.log('positionX------按下鼠标时图片绝对定位的位置x',positionX);
            // console.log('positionY------按下鼠标时图片绝对定位的位置y',positionY);
            // console.log('按下时的x点-----',X);
            // console.log('按下鼠标时的y点-----',Y);
            // positionX = $(this).position().left;
            // positionY = $(this).position().top;
            return false;
        });

        $(window.top.document).mouseup(function (e) {
            // console.log('抬起时的x点',e.pageX);
            // console.log('移动的距离',e.pageX-X);
            // upX=e.pageX
            // upY=e.pageY
            mDown = false;
        });

        $(window.top.document).mousemove(function (e) {
            // console.log('mousemove');
            xPage = e.pageX;//--实时的鼠标x点
            moveX = positionX + xPage - X;// 按下鼠标时图片绝对定位的位置 + 实时的鼠标x点 - 按下鼠标时的x点
            
            // console.log('实时的鼠标x点',xPage);// 


            // 960+0-449=511+(-512) 正好贴边 
            // 511+1319-425=1405+(-512)=893  左边893+1024=1917 屏幕宽度

            // 1113+603-0

            yPage = e.pageY;//--实时的鼠标y点
            moveY = positionY + yPage - Y;
            // console.log(positionY,yPage,Y,'值是'+moveY);
            // console.log('实时的鼠标y点',yPage);

            function thisXMove() { //x轴移动
                if (mDown == true) {
                    $this.css({ "left": moveX });
                } else {
                    return;
                }
                if (moveX < 0) {
                    $this.css({ "left": "0" });
                }
                if (moveX > (faWidth - thisWidth)) {
                    $this.css({ "left": faWidth - thisWidth });
                }
                return moveX;
            }

            function thisYMove() { //y轴移动
                if (mDown == true) {
                    $this.css({ "top": moveY });
                } else {
                    return;
                }
                if (moveY < 0) {
                    $this.css({ "top": "0" });
                }
                if (moveY > (faHeight - thisHeight)) {
                    $this.css({ "top": faHeight - thisHeight });
                }
                return moveY;
            }

            function thisAllMove() { //全部移动
                // moveX=e.pageX-downX+oldElementLeft
                // moveY=e.pageY-downY+oldElementTop

                
            //     // console.log(moveX,moveY,mDown);
                if (mDown == true) {
                    // console.log('实际X值',moveX-512);
                    $this.css({ "left": moveX, "top": moveY });
                } else {
                    return;
                }
                if (moveX < 0) {
                    $this.css({ "left": "0" });
                }
                if (moveY < 0) {
                    $this.css({ "top": "0" });
                }
            }
            if (movePosition.toLowerCase() == "x") {
                thisXMove();
            } else if (movePosition.toLowerCase() == "y") {
                thisYMove();
            } else if (movePosition.toLowerCase() == 'both') {
                thisAllMove();
            }
        });
    }
});



//原始版本
// $.fn.extend({dragging:function(s){var t,o,e,n,i=$(this),a=i.parent(),c=$.extend({},{move:"both",randomPosition:!0,hander:1},s),r=c.move,d=c.randomPosition,p=c.hander;p=1===p?i:i.find(c.hander),a.css({position:"relative",overflow:"hidden"}),i.css({position:"absolute"}),p.css({cursor:"move"});var h,f,u,g,m=a.width(),l=a.height(),w=i.width()+parseInt(i.css("padding-left"))+parseInt(i.css("padding-right")),v=i.height()+parseInt(i.css("padding-top"))+parseInt(i.css("padding-bottom")),I=!1;d&&i.each(function(s){var t=parseInt(Math.random()*(l-v)),o=parseInt(Math.random()*(m-w));"x"==r.toLowerCase()?$(this).css({left:o}):"y"==r.toLowerCase()?$(this).css({top:t}):"both"==r.toLowerCase()&&$(this).css({top:t,left:o})}),p.mousedown(function(s){return a.children().css({zIndex:"0"}),i.css({zIndex:"6666"}),I=!0,e=s.pageX,n=s.pageY,h=i.position().left,f=i.position().top,!1}),$(document).mouseup(function(s){I=!1}),$(document).mousemove(function(s){t=s.pageX,u=h+t-e,o=s.pageY,g=f+o-n,"x"==r.toLowerCase()?function(){if(1==I)i.css({left:u}),u<0&&i.css({left:"0"}),u>m-w&&i.css({left:m-w})}():"y"==r.toLowerCase()?function(){if(1==I)i.css({top:g}),g<0&&i.css({top:"0"}),g>l-v&&i.css({top:l-v})}():"both"==r.toLowerCase()&&1==I&&(i.css({left:u,top:g}),u<0&&i.css({left:"0"}),g<0&&i.css({top:"0"}))})}});