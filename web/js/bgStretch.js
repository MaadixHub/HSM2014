//0.3.1
(function($){
	$.fn.bgStretch=function(o){
		this.each(function(){
			var th=$(this),
				data=th.data('bgStretch'),
				_={
					align:'leftTop',
					css:{
						leftTop:{
							left:0,
							right:'auto',
							top:0,
							bottom:'auto'
						},
						rightTop:{
							left:'auto',
							right:0,
							top:0,
							bottom:'auto'
						},
						leftBottom:{
							left:0,
							right:'auto',
							top:'auto',
							bottom:0
						},
						rightBottom:{
							left:'auto',
							right:0,
							top:'auto',
							bottom:0
						}
					},
					preFu:function(){
						_.img
							.load(function(){
								_.checkWidthFu()
								_.img
									.css({
										width:'100%',
										height:'100%',
										position:'absolute',
										zIndex:-1,
										left:0,
										top:0
									})
								$(window).trigger('resize')
								return false
							})
						_.img[0].complete
							&&_.img.trigger('load')
						_.me
							.css({
								position:'absolute',
								zIndex:-1
							})
							.css(_.css[_.aalign=_.align])
						_.wrap
							.css({
								width:'100%',
								height:'100%',
								position:'fixed',
								left:0,
								top:0,
								overflow:'hidden',
								zIndex:-1
							})
					},
					checkWidthFu:function(){
						var i=$('<img>')
						i
							.css({
								position:'absolute'
								,left:'-999%'
								,top:'-999%'
							})
							.appendTo('body')
							.load(function(){
								_.k=i.height()/i.width()
								_.resizeFu()
								i.remove()
							})
							.attr({src:_.img.attr('src')})									
					},
					resizeFu:function(){
						var wh=_.win.height(),
							ww=_.win.width(),
							k=wh/ww
						if(_.aalign!=_.align)
							_.me
								.css(_.css[_.aalign=_.align])

						if(/*(k<_.k)&&*/(ww>=1300))
							_.me
								.css({
									width:ww,
									height:ww*_.k,
									top:-(185*(ww/1300-1)),
									left:0
								})
						else
							_.me
								.css({
									width:1300,
									height:1300*_.k,
									top:0,
									left:-((1300-ww)/2)
								})
						
					},
					chngFu:function(str){
						$.fn.sImg
							?_.me.sImg(str)
							:_.img.attr({src:str})
					},
					init:function(){
						_.win=$(window)						
						_.img=$('img',_.me)
						_.me.wrap('<div></div>')
						_.wrap=_.me.parent()
						
						_.preFu()
						$(window)
							.resize(function(){
								_.resizeFu()
							})
							.trigger('resize')
						_.navs&&_.navs.data('navs')
							&&_.navs.navs(function(n,__){
								_.chngFu(__.href)
							})
							
					}
				}
			data?_=data:th.data({bgStretch:_})
			typeof o=='object'&&(_=$.extend(true,_,o))
			_.me||_.init(_.me=th)
			
			typeof o=='string'&&_.chngFu(o)
		})
		return this		
	}
	//0.2.3 image changer
	$.fn.sImg=function(o,cb){
		this.each(function(){
			var th=$(this),
				data=th.data('sImg'),
				_={
					duration:1000,
					sleep:300,
					spinner:false,
					preFu:function(){
						_.me.css('position')=='static'
							&&_.me.css({position:'relative',zIndex:1})
					},					
					chngFu:function(src){
						if(src==_.src)
							return false
						_.src=src
						_.buff=_.buff||$('<img>').css({position:'absolute',top:'-999%',left:'-999%'})
						if(_.clone&&_.clone.is(':animated'))
							_.clone.stop()
						if(_.clone)
							_.clone.remove()
						
						if(_.spinner!==false)
							if(typeof _.spinner=='string')
								_.spinner=$(_.spinner).hide()
							else
								if(typeof _.spinner=='object')
									_.spinner
										.appendTo(_.me)
										.fadeIn()
						_.buff
							.appendTo('body')
							.unbind('load')
							.load(function(){
								setTimeout(function(){
									if(_.img.css('position')=='static')										
										_.me
											.css({
												width:_.buff.width(),
												height:_.buff.height()
											}),
										_.img
											.css({
												position:'absolute',
												left:0,
												top:0
											})
									_.clone=_.img.clone()
										.css({
											position:'absolute',
											left:_.img.prop('offsetLeft'),
											top:_.img.prop('offsetTop')
										})
										.appendTo(_.me)
									_.spinner
										&&_.spinner.fadeOut()
									_.img.attr({src:src})
									_.clone
										.stop()
										.animate({
											opacity:0
										},{
											duration:_.duration,
											complete:function(){
												_.clone.remove()
												cb&&cb()
											}
										})
										_.buff.detach()
										_.spinner
											&&_.spinner.hide()
								},_.sleep)
							})
							.attr({src:src})
					},
					init:function(){
						_.img=$('>img',_.me)
						_.preFu()						
					}
				}
			data?_=data:th.data({sImg:_})
			typeof o=='object'&&$.extend(_,o)
			_.me||_.init(_.me=th)
			
			if(_.spinner!==false)
				if(typeof _.spinner=='string')
					_.spinner=$(_.spinner).hide()
			
			typeof o=='string'&&_.chngFu(o)
		})
		return this
	}
	$.fn.navs=function(o){
		this.each(function(){
			var th=$(this),
				data=th.data('navs'),
				_={
					enable:true,
					actCl:'active',
					changeEv:'change',
					indx:[],
					hshx:[],
					useHash:false,
					defHash:'#!/',
					emptyHash:'#',
					outerHash:false,
					autoPlay:true,
					blockSame:true,
					hover:true,
					contRetFalse:true,
					preFu:function(){						
						_.li.each(function(n){
							var th=$(this)
							_.indx[n]=th
							_.useHash
								&&(_.hshx[n]=$('a',th).attr('href'))
								&&location.hash==_.hshx[n]
									&&th.addClass(_.actCl)
						})						
					},
					rfrshFu:function(){
						_.prev=_.curr
						_.pren=_.n
						_.curr=false
						_.n=-1
						_.param='close'
						
						_.li.each(function(n){
							var th=$(this)
							if(th.hasClass(_.actCl))
								_.curr=th,
								_.n=n,
								_.href=$('a',th).attr('href'),
								_.param=_.useHash?_.href:_.n
						})						
					},
					markFu:function(){
						_.li.each(function(n){
							var th=$(this)
							_.n==n?_.hvrin(th):_.hvrout(th)
						})
					},
					hashFu:function(){
						$(window)
							.bind('hashchange',function(){
								if(location.hash==_.emptyHash||location.hash.length==0){
									location.hash=_.hash
									return false
								}
								_.prevHash=_.hash
								_.checkHashFu(_.outerHash=_.hash=location.hash)
							})
						$('a',_.li)
							.click(function(){
								if(!_.enable)
									return false
							})
					},
					checkHashFu:function(hash){
						if(hash==_.emptyHash||hash.length==0)
							location.hash=_.defHash
						if(hash=='#back')
							return _.backFu()
						if(hash=='#close')
							return _.closeFu()
						_.li.each(function(n){
							if(_.hshx[n]==_.hash)
								_.chngFu(n),
								_.outerHash=false
						})
						if(_.outerHash)							
							_.li.removeClass(_.actCl),
							_.rfrshFu(),
							_.markFu(),
							_.param=_.outerHash,
							_.me.trigger(_.changeEv)
					},
					cntrFu:function(){
						_.li.each(function(n){
							var th=$(this)
							$('a',th)
								.click(function(){
									_.chngFu(n)
									if(_.contRetFalse)
										return false
								})									
						})
					},
					autoPlayFu:function(){
						if(!_.autoPlay)
							return false
						if(_.int)
							clearInterval(_.int)
						_.int=setInterval(_.nextFu,_.autoPlay)
					},
					chngFu:function(n){
						if(!_.enable)
							return false
						if(n==_.n&&_.blockSame)
							return false						
						_.indx[n]
							&&_.li.removeClass(_.actCl)
							&&_.indx[n].addClass(_.actCl)
						_.rfrshFu()
						_.markFu()
						_.autoPlayFu()
						if(_.useHash&&location.hash!=_.hshx[_.n])
							location.hash=_.hshx[_.n]
							
						_.me.trigger(_.changeEv)
					},
					closeFu:function(){
						_.li.removeClass(_.actCl)
						_.rfrshFu()
						_.markFu()
						_.me.trigger(_.changeEv)
						location.hash=_.defHash
					},
					backFu:function(){
						_.chngFu(_.pren)
					},
					nextFu:function(){
						var n=_.n
						_.chngFu(++n<_.li.length?n:0)
					},
					prevFu:function(){
						var n=_.n
						_.chngFu(--n>=0?n:_.li.length-1)
					},
					customStr:function(str){
						//console.log(str)
					},
					init:function(){						
						_.li=$('>ul>li',_.me)
						_.preFu()
						_.rfrshFu()
						_.markFu()
						_.useHash
							?_.hashFu()
							:_.cntrFu()
						_.hoverFu()
						_.autoPlayFu()
						_.useHash
							&&_.checkHashFu(_.outerHash=_.hash=location.hash)
						_.li.hasClass(_.actCl)
							&&_.me.trigger(_.changeEv)
					},
					hoverFu:function(){
						_.li.each(function(n){
							var th=$(this)
							$('a',th)
								.bind('mouseenter',function(){
									if(_.enable)
										if(_.hover&&n!=_.n)
											_.hvrin(th)
								})
								.bind('mouseleave',function(){
									if(_.enable)
										if(_.hover&&n!=_.n)
											_.hvrout(th)
								})
						})
					},
					hvrin:function(el){
						_.hoverIn(el,_)
						_.hover=='sprites'
							&&$('a',el).sprites('hoverin')
					},
					hvrout:function(el){
						_.hoverOut(el,_)
						_.hover=='sprites'
							&&$('a',el).sprites('hoverout')
					},
					hoverIn:function(){},
					hoverOut:function(){},
					defFunc:function(){}
				}
				
			data?_=data:th.data({navs:_})
			typeof o=='object'&&$.extend(_,o)
			
			if(typeof o=='function')
				return th.bind(_.changeEv,function(){o(_.param,_);return false}).trigger(_.changeEv)
			
			_.me||_.init(_.me=th)
			
			typeof o=='number'&&_.chngFu(o)
			typeof o=='boolean'&&(_.enable=o)
			typeof o=='string'&&(o=='prev'||o=='next'||o=='close'||o=='back'?_[o+'Fu']():_.useHash?o.slice(0,3)=='#!/'&&(location.hash=o)||_.customStr(o):_.customStr(o))
		})
		return this
	}
})(jQuery)