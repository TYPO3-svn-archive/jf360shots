(function(d){d.queryParams=function(a){for(var b=window.location.search.substr(1).split("&"),c={},e,g,f,h=0,i=b.length;h<i;h++){e=b[h].split("=");g=decodeURI(e[0]);f=decodeURI(e[1]);switch(f.toLowerCase()){case "true":f=true;break;case "false":f=false;break;case "":case "null":f=null;break;default:e=parseFloat(f);isNaN(e)||(f=e)}c[g]=f}if(a)d.extend(a,c);else a=c;return a};d.widget("ui.gestalt",d.ui.mouse,{version:"1.0.0",options:{url:null,size:"small",controls:false,largeUrl:null,largeUrl2:null,images:null,wait:60,
keyboard:true,animate:false,framerate:5,mouse:10},_create:function(){var a=this,b=this.options,c=this.element[0];this.element.addClass("ui-gs ui-widget ui-widget-content ui-helper-clearfix").attr("role","gestalt").append('<div class="ui-gs-images">    <div class="ui-gs-progressbar" style="display:none;"></div></div>');b.controls&&this._appendControls();this._mouseInit();this.images=d(".ui-gs-images",c);this.progressbar=d(".ui-gs-progressbar",c).progressbar({value:0});this.running=this.loaded=false;
this.imageList=[];this.direction="forward";this.once=b.animate==="once";this.retry={list:[],count:0,id:0};this._setOption("framerate",b.framerate);if(b.url)d.get(b.url+"/"+b.size+"/Filelist.txt",function(e){a._setOption("images",e.replace(/['"]/g,"").split(","))},"text");else b.images&&this._setOption("images",b.images);b.loaded=function(){a.loaded=true;a.progressbar.progressbar("destroy").remove();b.keyboard&&a._keyboardBindings();b.animate&&a.start()};b.added=function(){a.progressbar.progressbar("option",
"value",100*a._imageLoadCount/a.imageList.length)};c.ontouchstart=function(e){a._mouseStart(e.touches[0]);e.preventDefault()};c.ontouchmove=function(e){a._mouseDrag(e.touches[0]);e.preventDefault()}},destroy:function(){this._mouseDestroy();if(this.options.keyboard)d(document).unbind(d.browser.mozilla?"keypress":"keydown",this._keydown);this.element.removeClass("ui-gs ui-gs-hide-controls ui-widget ui-widget-content ui-helper-clearfix").removeAttr("role","gestalt").removeData("gestalt").empty();d.Widget.prototype.destroy.call(this)},
_setOption:function(a,b){d.Widget.prototype._setOption.apply(this,arguments);switch(a){case "images":b&&b.length>0&&this.stop()._load();break;case "framerate":if(b<1)b=1;if(b>22)b=22;this.options[a]=b;var c=1E3/b;if(c!==this.delay){this.delay=c;if(this.running){this._stop();this._start()}}break}},_load:function(){var a=this,b=null;clearInterval(this.retry.id);this.retry.list.length=0;this.retry.count=0;this.images.find("img").remove();this._imageLoadCount=this.imageList.length=0;d.each(this.options.images,
function(c,e){b=d("<img />");a.imageList.push(b);a.images.append(b);a._addImage(c,e)});this.retry.id=setInterval(function(){a._retryLoad()},1E3);return this},_addImage:function(a,b){if(this.retry.count)b+="?_="+(new Date).getTime();var c=this,e=this.imageList[a],g=d("<img />").attr("src",b).load(function(){c._imageLoaded(a)}).error(function(){c.retry.list.push(a)});this.imageList[a]=g;e.removeAttr("src").replaceWith(g);return this},_imageLoaded:function(a){this._imageLoadCount++;if(this._imageLoadCount===
1){this._setImageSize(this.imageList[a]);this.progressbar.show();a=2*parseInt(this.progressbar.css("left")||10);this.progressbar.css({width:this.images.width()-a});this._activate(0)}this._trigger("added",undefined,{count:this._imageLoadCount});this._imageLoadCount==this.imageList.length&&this._trigger("loaded");return this},_retryLoad:function(){if(this._imageLoadCount===this.imageList.length||this.retry.count>=this.options.wait){clearInterval(this.retry.id);this.retry.id=0;return this}var a=this,
b=this.options.images;this.retry.count++;d.each(this.retry.list,function(c,e){a._addImage(e,b[e])});this.retry.list.length=0;return this},_activate:function(a){this.images.find("img").hide();this.imageList[a].show();this._active=a;return this},next:function(a){var b=this.stop(a)._next();this._activate(b);this._trigger("next",a,{index:b});return this},prev:function(a){var b=this.stop(a)._prev();this._activate(b);this._trigger("prev",a,{index:b});return this},_next:function(){var a=this._active,b=this.imageList.length;
a++;if(a>=b)a=0;return a},_prev:function(){var a=this._active,b=this.imageList.length;a--;if(a<0)a=b-1;return a},start:function(a){this._start()&&this._trigger("start",a);return this},stop:function(a){this._stop()&&this._trigger("stop",a);return this},_start:function(){if(!this.running){var a=this,b=null;switch(this.direction){case "forward":b=function(){var c=a._next();if(a.once&&c<a._active){a.once=false;a.stop()}a._activate(c)};break;case "reverse":b=function(){var c=a._prev();if(a.once&&c===0){a.once=
false;a.stop()}a._activate(c)};break}this.running=setInterval(b,this.delay);return true}return false},_stop:function(){if(this.running){clearInterval(this.running);this.running=0;this.once=false;return true}return false},startStop:function(a){if(!this.loaded)return this;this.running?this.stop(a):this.start(a);return this},_direction:function(a){this.direction=a;if(this.running){this._stop();this._start()}return this},_setImageSize:function(a){var b=this.element.outerWidth(true)-this.images.width(),
c=this.element.outerHeight(true)-this.images.height();b=window.innerWidth-b;c=window.innerHeight-c;b=b/a.width();c=c/a.height();c=b<c?b:c;a=c<1?{width:a.width()*c,height:a.height()*c}:{width:a.width(),height:a.height()};this.images.css(a);d("img",this.images[0]).css(a);this.element.css("min-width",this.images.outerWidth(true))},_keyboardBindings:function(){var a=this;this._keydown=function(b){if(!(b.altKey||b.ctrlKey||b.metaKey))switch(b.keyCode?b.keyCode:b.which){case d.ui.keyCode.SPACE:a.startStop(b);
return false;case d.ui.keyCode.LEFT:a.next(b);return false;case d.ui.keyCode.RIGHT:a.prev(b);return false;case d.ui.keyCode.UP:a._setOption("framerate",a.options.framerate+1);return false;case d.ui.keyCode.DOWN:a._setOption("framerate",a.options.framerate-1);return false}};d(document).bind(d.browser.mozilla?"keypress":"keydown",this._keydown)},_mouseStart:function(a){if(this.options.mouse&&this.loaded)this.xStart=a.pageX},_mouseDrag:function(a){if(this.options.mouse&&this.loaded){var b=(a.pageX-this.xStart)/
this.options.mouse,c=b<0;b=Math.abs(b);if(!(b<1)){if(c)for(;b>0;b--)this.next(a);else for(;b>0;b--)this.prev(a);this.xStart=a.pageX}}},_appendControls:function(){var a=this,b=this.element[0];this.element.append(d('<div class="ui-gs-controls"></div>').append('<button title="prev">Prev</button>').append('<button title="play">Play/Pause</button>').append('<button title="next">Next</button>'));d(".ui-gs-controls button:first",b).button({text:false,icons:{primary:"ui-icon-seek-prev"}}).addClass("ui-state-disabled").click(function(f){a.next(f);
return false}).next().button({text:false,icons:{primary:"ui-icon-play"}}).addClass("ui-state-disabled").click(function(f){a.startStop(f);return false}).next().button({text:false,icons:{primary:"ui-icon-seek-next"}}).addClass("ui-state-disabled").click(function(f){a.prev(f);return false});if(this.options.controls==="resizeable"){var c=this.options.url+"/large.html";if(this.options.largeUrl)c=window.location.href.split("?")[0]+"?url="+encodeURI(this.options.url)+"&"+decodeURIComponent(this.options.largeUrl);if(this.options.largeUrl2)c=this.options.largeUrl2;
d(".ui-gs-controls",b).append(d('<button title="resize" class="ui-gs-resize">Resize</button>').button({text:false,icons:{primary:"ui-icon-arrow-4-diag"}}).addClass("ui-state-disabled").click(function(){window.open(c,"","type=fullWindow, fullscreen=yes, scrollbars=auto")}))}var e=d(".ui-gs-controls button[title=play]",b);this.element.bind("gestaltloaded",function(){d(".ui-gs-controls button",b).each(function(){d(this).removeClass("ui-state-disabled")})}).bind("gestaltstart",function(){e.attr("title",
"pause").find("span.ui-button-icon-primary").removeClass("ui-icon-play").addClass("ui-icon-pause")}).bind("gestaltstop",function(){e.attr("title","play").find("span.ui-button-icon-primary").removeClass("ui-icon-pause").addClass("ui-icon-play")});var g=0;d(".ui-gs-controls button",b).each(function(){g+=d(this).outerWidth(true)});d(".ui-gs-controls",b).css({width:g})}})})(jQuery);
