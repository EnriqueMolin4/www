/* 本插件参考了imgZoom,在这个基础上添加了以下功能
    1，在iframe下全屏展示和操作图片；
    2，添加上一张，下一张，左旋，右旋，和关闭图片按钮的功能；
    3，添加十字键盘切换图片和进行缩放；
    4，支持图片元素在dom不同的层级下同时进行绑定；
    5，缩放(原有功能)

    使用方法：
    $(imgs).imgZoomAndRotate()
    可选参数{'loop':true}，图片切换时可循环。

    作者：leopold;
    github:https://github.com/lenisleopold/imgZoomAndRotate.git
*/

(function ($) {
    $.fn.extend({
        imgZoomAndRotate: function (data) {
            var $all = this;//初始化绑定的所有图片
            var $this;//点击的小图片，点击后赋值
            var picNum = $all.length//图片总数
            var degs = 0;//旋转度数

            var defaults = {
                loop: false
            }

            var options = $.extend({}, defaults, data);

            //点击上一张箭头
            function showPrevPic(self) {
                // debugger
                var bigImg = $(self).parent().find('.zoomImg')
                var index = bigImg.attr('index')//当前大图片的index
                if (index >= 1) {
                    var prevIndex = $this.attr('imgIndex') - 1;
                    var prevSrc = $all.eq(prevIndex).attr('src')
                    bigImg.attr('index', index - 1);
                    bigImg.attr('src', prevSrc);
                    bigImg.css({ 'width': 'auto', 'height': 'auto' });
                    $this = $all.eq(prevIndex);//更新当前小图
                    degs = 0;
                    $(window.top.document).find(".zoomImg").css({ 'transform': 'rotate(0deg)' })
                } else if (index == 0 && options.loop) {
                    bigImg.attr('index', picNum - 1);
                    bigImg.attr('src', $all.last().attr('src'));
                    bigImg.css({ 'width': 'auto', 'height': 'auto' });
                    $this = $all.eq(picNum - 1)
                    degs = 0;
                    $(window.top.document).find(".zoomImg").css({ 'transform': 'rotate(0deg)' })
                }
            }

            //点击下一张箭头
            function showNextPic(self) {
                // debugger
                var bigImg = $(self).parent().find('.zoomImg');
                var index = bigImg.attr('index');//当前大图片的index
                if (index < picNum - 1) {
                    var nextIndex = Number($this.attr('imgIndex')) + 1;
                    var nextSrc = $all.eq(nextIndex).attr('src')
                    bigImg.attr('index', nextIndex);
                    bigImg.attr('src', nextSrc);
                    bigImg.css({ 'width': 'auto', 'height': 'auto' });
                    $this = $all.eq(nextIndex);//更新当前小图
                    degs = 0;
                    $(window.top.document).find(".zoomImg").css({ 'transform': 'rotate(0deg)' })

                } else if (index == picNum - 1 && options.loop) {

                    bigImg.attr('index', 0);
                    bigImg.attr('src', $all.eq(0).attr('src'));
                    bigImg.css({ 'width': 'auto', 'height': 'auto' });
                    $this = $all.eq(0)
                    degs = 0;
                    $(window.top.document).find(".zoomImg").css({ 'transform': 'rotate(0deg)' })
                }
            }

            //左旋转
            function rotateLeft() {//点击
                degs -= 10;
                $(window.top.document).find(".foreground .zoomImg").css({ 'transform': 'rotate(' + degs + 'deg)' })
            }
            var timer1;
            function rotateToLeft() {//按住
                timer1 = setInterval(function () {
                    rotateLeft()
                }, 100)
            }
            function clearRotateToLeft() {
                clearInterval(timer1)
            }

            //右旋转
            function rotateRight() {//点击
                degs += 10;
                $(window.top.document).find(".foreground .zoomImg").css({ 'transform': 'rotate(' + degs + 'deg)' })
            }
            var timer2;
            function rotateToRight() {//按住
                timer2 = setInterval(function () {
                    rotateRight()
                }, 100)
            }
            function clearRotateToRight() {
                clearInterval(timer2)
            }

            //鼠标滚轮缩放
            function mousewheelHandler(e, d) {
                //d 1 上 -1 下
                try {
                    if (d === 1) {
                        var width = $(window.top.document).find(".zoomImg").width();
                        var height = $(window.top.document).find(".zoomImg").height();
                        $(window.top.document).find(".zoomImg").css({ "width": width * 1.1, "height": 'auto', "transform-origin": "center center 0px" });
                    }
                    if (d === -1) {//如以宽高缩放，缩放+拖拽都没问题，只是缩放起始点是左上角
                        //如以scale缩放，可以设置缩放起始点为图片中心，但是缩放后，拖拽定位会偏移
                        var width = $(window.top.document).find(".zoomImg").width();
                        var height = $(window.top.document).find(".zoomImg").height();
                        if (height * 0.9 >= 200 && width * 0.9 >= 200) {
                            $(window.top.document).find(".zoomImg").css({ "width": width * 0.9, "height": 'auto', "transform-origin": "center center 0px" });
                        }
                    }
                } catch (err) {
                    console.log(err);
                }
            }

            $(window.top.document).on("mousewheel", mousewheelHandler)

            //关闭图片
            function closeModal() {
                degs = 0;
                $(window.top.document).find(".backdrop").remove()
                $(window.top.document).find(".foreground").remove()
            }

            $(window.top.document).on('click', '.angle_.angle-left', function () {//上一张
                showPrevPic(this)
            })

            $(window.top.document).on('click', '.angle_.angle-right', function () {//下一张
                // console.log('下一张');
                showNextPic(this)
            })

            $(window.top.document).on('mousedown', '.rotate_.rotate-left', function () {//左旋转-按住
                rotateToLeft(this)
            })

            $(window.top.document).on('mouseup', '.rotate_.rotate-left', function () {//左旋转-取消
                clearRotateToLeft(this)
            })

            $(window.top.document).on('mousedown', '.rotate_.rotate-right', function () {//右旋转-按住
                rotateToRight(this)
            })

            $(window.top.document).on('mouseup', '.rotate_.rotate-right', function () {//右旋转-取消
                clearRotateToRight(this)
            })

            $(window.top.document).on('click', '.foreground #picClose', function () {//关闭
                closeModal()
                $(window.document).off('keydown')
                $(window.top.document).off('keydown')
            })

            this.each(function (i, t) {
                $(t).attr('imgIndex', i)
            })

            return this.each(function (i, t) {

                $(this).click(function () {

                    $this = $(this)//更新全局 $this

                    var index = $this.attr('imgIndex');
                    var src = $this.attr('src');

                    var background = '<div class="backdrop"></div>';
                    var foreground = '<div class="foreground"></div>';
                    var leftIcon = '<div class="rotate_ rotate-left">' +
                        '<div class="triangle triangle-left"></div>' +
                        '</div>' +
                        '<i class="angle_ angle-left" ></i>'

                    var img = '<img src=' + src + ' index=' + index + ' class="zoomImg"></img>'

                    var rightIcon = '<div class="rotate_ rotate-right">' +
                        '<div class="triangle triangle-right"></div>' +
                        '</div>' +
                        '<i class="angle_ angle-right"></i>' +
                        '<i class="picClose" id="picClose">&times;</i>'

                    $(window.top.document).find('body').append(background)
                    $(window.top.document).find('body').append(foreground)
                    $(window.top.document).find('.foreground').append(leftIcon + img + rightIcon)
                    $(window.top.document).find('.backdrop').css('cssText', 'position: fixed;top: 0;right: 0;bottom: 0;left: 0;z-index: 1040;background:rgba(0,0,0,0.9);')
                    $(window.top.document).find('.foreground').css('cssText', 'width:100%;height:100%;text-align:center;top:0;left:0;z-index:3000;overflow: hidden;position:absolute;!important;')
                    $(window.top.document).find('.foreground .angle-left').css('cssText', 'width:55px;height: 55px;border-top: 5px solid #c5c5c5;display: inline-block;border-left: 5px solid #c5c5c5;transform:rotate(-45deg);position:fixed;top:50%;left:6%;cursor:pointer;z-index:9999;transition: all 0.3s;opacity:0.4')
                    $(window.top.document).find('.foreground .angle-right').css('cssText', 'width:55px;height: 55px;border-right: 5px solid #c5c5c5;display: inline-block;border-bottom: 5px solid #c5c5c5;transform: rotate(-45deg);cursor: pointer;position: fixed;top: 50%;right: 6%;z-index:9999;transition: all 0.3s;opacity:0.4')

                    $(window.top.document).find('.foreground .rotate-left').css('cssText', 'display:inline-block;width: 80px;height: 80px;border: 2px solid #c5c5c5;border-radius: 100%;cursor: pointer;position: fixed;top: 25%;left: 10%;z-index: 10;transition: all 0.3s;transform: scale(1.0);z-index:9999')
                    $(window.top.document).find('.foreground .triangle-left').css('cssText', 'width: 0;border: 6px solid transparent;border-top: 16px solid;position: absolute;left: -7px;top: 40px;transform: rotate(-1deg);z-index: 200;color:#c5c5c5;')

                    $(window.top.document).find('.foreground .rotate-right').css('cssText', 'display: inline-block;width: 80px;height: 80px;border: 2px solid #c5c5c5;border-radius: 100%;cursor: pointer;position: fixed;top: 25%;right: 10%;z-index: 10;transition: all 0.3s;transform: scale(1.0);z-index:9999')
                    $(window.top.document).find('.foreground .triangle-right').css('cssText', 'width: 0;border: 6px solid transparent;border-top: 16px solid;position: absolute;right: -7px;top: 40px;transform: rotate(-1deg);z-index: 200;color:#c5c5c5;')

                    $(window.top.document).find('.foreground #picClose').css('cssText', 'display:inline-block;cursor:pointer;position: fixed;top: 5%;right: 5%;z-index: 10;transition: all 0.3s;opacity: 0.6;background: transparent;font-size: 60px;color: #c5c5c5;font-style: normal;font-weight: 900px;;transform-origin: 45% 55%;z-index:9999')

                    $(window.top.document).find('.foreground .angle_').hover(function () {
                        $(this).css({ 'border-color': '#fff', 'opacity': 1, 'transform': 'scale(1.5) rotate(-45deg)' })
                    }, function () {
                        $(this).css({ 'border-color': '#c5c5c5', 'opacity': 0.6, 'transform': 'scale(1.0) rotate(-45deg)' })
                    })

                    $(window.top.document).find('.foreground .rotate_').hover(function () {
                        $(this).css({ 'border-color': '#f30', 'transform': 'scale(1.5)' })
                        $(this).find('.triangle').css({ 'color': '#f30', 'transform': 'scale(1.5)' })
                    }, function () {
                        $(this).css({ 'border-color': '#c5c5c5', 'transform': 'scale(1.0)' })
                        $(this).find('.triangle').css({ 'color': '#c5c5c5', 'transform': 'scale(1.0)' })
                    })

                    $(window.top.document).find('.foreground #picClose').hover(function () {
                        $(this).css({ 'color': '#fd0000', 'transform': 'scale(1.8) rotate(90deg)', 'opacity': '1' })
                    }, function () {
                        $(this).css({ 'color': '#c5c5c5', 'transform': 'scale(1.0) rotate(0deg)', 'opacity': '0.6' })
                    })

                    if (window == window.top) {//不是在iframe里
                        $(window.top.document).on('keydown', function (e) { keyControl(e) })
                    } else {//在iframe里
                        $(window.document).on('keydown', function (e) { keyControl(e) })

                        $(window.top.document).on('click', function () {
                            $(window.document).off('keydown')

                            if ($(window.top.document).attr('keydown') == undefined) {
                                $(window.top.document).attr('keydown', 'keyControl')
                                $(window.top.document).on('keydown', function (e) { keyControl(e) })
                            }
                        })
                    }

                    function keyControl(e) {//十字键控制
                        if (e.keyCode == '37') {//左 上一张
                            showPrevPic($(window.top.document).find('.angle_.angle-left').get(0))
                        } else if (e.keyCode == '39') {//右 下一张
                            showNextPic($(window.top.document).find('.angle_.angle-right').get(0))
                        } else if (e.keyCode == '38') {//上 放大
                            mousewheelHandler(this, 1)
                        } else if (e.keyCode == '40') {//下 缩小
                            mousewheelHandler(this, -1)
                        }
                    }

                    $(window.top.document).find(".foreground .zoomImg").on('load',function () {
                        $(window.top.document).find(".foreground .zoomImg").dragging({ randomPosition: false })//激活拖拽
                    })

                })
            })
        }
    })
})(jQuery)
