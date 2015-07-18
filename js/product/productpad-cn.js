function totalPrice(){
	var totalPrice = 0;
	$('.input-product').each(function(){
		var price = $(this).attr('price');
		var num = $(this).val();
		totalPrice += parseInt(price)*parseInt(num);
	});
	totalPrice = totalPrice.toFixed(2);
	$('.total-price').html(totalPrice);
}
function totalNum(){
	var totalNum = 0;
	$('.input-product').each(function(){
		var num = $(this).val();
		totalNum += parseInt(num);
	});
	$('.total-num').html(totalNum);
}
function addToCart() {
	//var reddot = document.querySelector('.aniele');
        var shcart = document.querySelector('.shoppingCart');
	//reddot.style.visibility="visible";
	//classie.add(reddot,'added');
        classie.add(shcart,'rotate');
	setTimeout(function(){
		//reddot.style.visibility="hidden";
		//classie.remove(reddot,'added');
                classie.remove(shcart,'rotate');
	}, 800); 
}
$(document).ready(function(){
	var language = $('input[name="language"]').val();
    $('#forum_list').on('touchstart','.addCart',function(){
    	var _this = $(this);
    	var store = _this.parents('.blockCategory').attr('store');
    	if(parseInt(store)==0){
    		layer.msg('库存不足');
    		return;
    	}else if(parseInt(store) > 0){
    		store -= 1;
    		_this.parents('.blockCategory').attr('store',store);
    	}
    	var type = _this.attr('type');
    	var parentsBlockCategory = _this.parents('.blockCategory');
    	var category = parentsBlockCategory.attr('category');//分类id
    	var categoryName = parentsBlockCategory.attr('category-name');//分类 名称
    	var productId = parentsBlockCategory.find('a.product-pic').attr('lid');//产品 ID
    	var productName = parentsBlockCategory.find('.inmiddle').html();//产品 名称
    	var productPrice = _this.attr('price');//产品 价格
    	
    	var singleNumObj = parentsBlockCategory.find('.single-num-circel');
		var singleNums = 0;
			singleNums = parseInt(singleNumObj.html());
		singleNumObj.html(singleNums+1);
		
		var str = '';
		str +='<div class="order-product catory'+category+'">';
		str +='<div class="product-catory">'+categoryName+'</div>';
		if(parseInt(type)){
			str +='<div class="product-catory-product">'+productName+'<div class="product-catory-product-right"><input class="set-num input-product" type="text" name="'+productId+',1" value="1" price="'+productPrice+'" readonly="true"/> X '+productPrice+'</div></div>';
		}else{
			str +='<div class="product-catory-product">'+productName+'<div class="product-catory-product-right"><input class="set-num input-product" type="text" name="'+productId+'" value="1" price="'+productPrice+'" readonly="true"/> X '+productPrice+'</div></div>';
		}
		str +='</div>';
		
		var substr = '';
		if(parseInt(type)){
			substr +='<div class="product-catory-product">'+productName+'<div class="product-catory-product-right"><input class="set-num input-product" type="text" name="'+productId+',1" value="1" price="'+productPrice+'" readonly="true"/> X '+productPrice+'</div></div>';
		}else{
			substr +='<div class="product-catory-product">'+productName+'<div class="product-catory-product-right"><input class="set-num input-product" type="text" name="'+productId+'" value="1" price="'+productPrice+'" readonly="true"/> X '+productPrice+'</div></div>';
		}
		if($('.catory'+category).length > 0){
			var inputNumObj = $('.catory'+category).find('input[name="'+productId+'"]');
			if(inputNumObj.length > 0){
				var val = inputNumObj.val();
				inputNumObj.val(parseInt(val)+1);
			}else{
				$('.catory'+category).append(substr);
				parentsBlockCategory.find('.subject-order').css('display','block');
			}
		}else{
			$('.product-pad-mask .info').append(str);
			parentsBlockCategory.find('.subject-order').css('display','block');
		}
		
    	var price = parseFloat(_this.attr('price'));
    	var total = 0;
    		total = parseFloat($('.total-price').html());
    	var nums = 0;
    		nums = parseInt($('.total-num').html());
 		
		total += price;
		if(!parseInt(language)){
			total = total.toFixed(2);
		}
		$('.total-price').html(total);
		$('.total-num').html(nums+1);
                
                //alert(padprinterping);
	if (typeof Androidwymenuprinter != "undefined") {
                    if(padprinterping!="local")
                    {
                        Androidwymenuprinter.printNetPing(padprinterping,10);
                    }
                 }	
    });
   
    $('#forum_list').on(event_clicktouchstart,'.delCart',function(){
    	var _this = $(this);
    	var store = _this.parents('.blockCategory').attr('store');
    	if(parseInt(store) >= 0){
    		store =parseInt(store) + 1;
    		 _this.parents('.blockCategory').attr('store',store);
    	}
    	var parentsBlockCategory = _this.parents('.blockCategory');
    	var category = parentsBlockCategory.attr('category');//分类id
    	var productId = parentsBlockCategory.find('a.product-pic').attr('lid');//产品 ID
    	var singleNumObj = parentsBlockCategory.find('.single-num-circel');
    	var singleNums = singleNumObj.html();
    	var inputNumObj = $('.catory'+category).find('input[name="'+productId+'"]');
    	
    	if(parseInt(singleNums) > 1){
    		singleNumObj.html(parseInt(singleNums) - 1);
    		var val = inputNumObj.val();
			inputNumObj.val(parseInt(val)-1);
    	}else{
    		singleNumObj.html(parseInt(singleNums) - 1);
    		inputNumObj.parents('.product-catory-product').remove();
    		if(!$('.catory'+category).find('.product-catory-product').length){
    			$('.catory'+category).remove();
    		}
    		parentsBlockCategory.find('.subject-order').css('display','none');
    	}
    	
    	var productId = _this.attr('product-id');
    	var type = _this.attr('type');
    	var price = parseFloat(_this.attr('price'));
    	var total = 0;
    		total = parseFloat($('.total-price').html());
    	var nums = 0;
    		nums = parseInt($('.total-num').html());
 		if(nums > 0){
	 		total -= price;
	 		if(!parseInt(language)){
				total = total.toFixed(2);
			}
			$('.total-price').html(total);
			$('.total-num').html(nums-1);
 		}
               // alert(padprinterping);
        if (typeof Androidwymenuprinter != "undefined") {
                    if(padprinterping!="local")
                    {
                        Androidwymenuprinter.printNetPing(padprinterping,10);
                    }
                 }        
    });
    $('#forum_list').on(event_clicktouchend,'.product-pic',function(){
    	$('.blockCategory').each(function(){
    		$(this).find('.icon-hover-1').css('left','-150px');
    	 	$(this).find('.icon-hover-2').css('right','-150px');
    	});
    	$(this).find('.icon-hover-1').css('left','20%');
	 	$(this).find('.icon-hover-2').css('right','20%');
	 });
    $('#cancelPadOrder').on(event_clicktouchend,function(){
    	$('.product-pad-mask').find('.info').html('');
    	$('.product-pad-mask').css('display','none');
    	$('.blockCategory').each(function(){
    		$(this).find('.subject-order').css('display','none');
    		$(this).find('.single-num-circel').html(0);
    		
    		$(this).find('.product-taste').removeClass('hasclick'); //去掉口味点击类
    		$(this).find('.taste-list').each(function(eq){
				if(eq > 0){
					$(this).remove();
				}else{
					$(this).find('.item').removeClass('active'); //去掉第一个口味选中
				}
			});
    	});
    	
    	var total = 0;
    	if(!parseInt(language)){
			total = total.toFixed(2);
		}
    	$('.total-price').html(total);
		$('.total-num').html(0);
    });
   //help
   $('.padsetting').on(event_clicktouchstart,function(){
            $(".setting-pad-mask").toggle();});
   
   $('#content').on(event_clicktouchend,function(){
            $(".setting-pad-mask").css('display','none');
            $('.product-pad-mask').css('display','none');
        });
   
    //查看菜单
    $('body').on(event_clicktouchstart,'.top-right',function(){
    	  if($('.product-pad-mask').is(':hidden')) {
              $('.product-pad-mask').show();
     	  }else{
              $('.product-pad-mask').hide();
          }
          if (typeof Androidwymenuprinter != "undefined") {
            if(padprinterping!="local")
            {
                Androidwymenuprinter.printNetPing(padprinterping,10);
            }
         }
    });
//    $('.product-pad-mask').on(event_clicktouchstart,'.minus',function(){
//		var input = $(this).siblings('input');
//		var num = input.val();
//		if(num > 0){
//			num = num - 1;
//		}
//		input.val(num);	
//		totalPrice();
//		totalNum();		
//	});
//    $('.product-pad-mask').on(event_clicktouchstart,'.plus',function(){
//                //alert('+');
//		var input = $(this).siblings('input');
//		var num = parseInt(input.val());
//		num = num + 1;
//		input.val(num);	
//		totalPrice();	
//		totalNum();
//	});
    $('#pad-disbind-menu').on(event_clicktouchstart,function(){
            location.href='../../../../../../../padbind/login';
            //绑定和解绑必须到我们的服务器。
            //location.href='http://menu.wymenu.com/wymenuv2/padbind/login';
	});
        
    
     //打印测试关闭
    $('#printerClose').on(event_clicktouchstart,function(){
        $('#print_check').hide();
    });
    //打印测试关闭
    $('#printerShow').on(event_clicktouchstart,function(){
        $('#print_check').show();
    });
    //打印校正
    $('#printerCheck').on(event_clicktouchstart,function(){
        if (typeof Androidwymenuprinter == "undefined") {
                alert(language_notget_padinfo);
                return false;
         }
        var padinfo=Androidwymenuprinter.getPadInfo();
        var pad_id=padinfo.substr(10,10); //also can get from session
       	var company_id=padinfo.substr(0,10);
         $.ajax({
 			url:'/wymenuv2/product/printCheck',
 			async: false,
 			data:"companyId="+company_id+'&padId='+pad_id,
 			success:function(msg){
                            var data = eval('(' + msg + ')');
                            if(data.status)
                            {
 				if(Androidwymenuprinter.printJob(data.dpid,data.jobid))
                                {
                                    alert(language_printer_check_success);
                                    isPrintChecked=true;
                                    $('#print_check').hide();
                                }else{
                                    alert(language_printer_check_falil+"1");
                                }
                            }else{
                                alert(language_printer_check_falil+"2");
                            }
 			},
                        error:function(){
 				alert(language_printer_check_falil+"3");
 			},
 		});
                 
    });
    
    $('#pad-app-exit').on(event_clicktouchstart,function(){
            if (typeof Androidwymenuprinter == "undefined") {
                alert(language_notget_padinfo);
                return false;
            }
            var statu = confirm(language_clean_exit);
            if(statu){
                Androidwymenuprinter.appExitClear();
            }
	});
	 
    $('#forum_list').on('click','.view-product-pic',function(){
        var lid = $(this).attr('product-id');
        //alert(lid);//($('.large-pic').width() - $("#gallery").outerWidth())/2,//($('.large-pic').height() - $("#gallery").outerHeight())/2
    	$.ajax({
 			url:'/wymenuv2/product/getProductPicJson',
 			async: false,
 			data:'id='+lid,
 			success:function(msg){
 				if(msg!='nopic'){
                //alert(msg);
                $('.large-pic').css('display','block');
                        $('.large-pic').html(msg);
                                $('#gallery').slick({
                                          dots: true,
                                          infinite: true,
                                          speed: 1000,
                                          slidesToShow: 1,
                                          slidesToScroll: 1,
                                          autoplay: true,
                                          arrows: false
                                });
                $("#gallery").css({
                        position:'absolute',
                                top: '15%'
                        });
                }else{
                        alert(language_no_bigpic);
                }
},
 		});
    });
    
    $('.large-pic').on('click',function(){
    	$(this).html('');
    	$(this).css('display','none');
    });
    
    
    //点产品口味
    $('#forum_list').on('click','.product-taste',function(){
    	//第一次点击 同步订单数量  点击后增加 hasclick 类
    	var blockCategory = $(this).parents('.blockCategory');
	   	var category = blockCategory.attr('category');//分类id
	   	var productId = blockCategory.find('a.product-pic').attr('lid');//产品 ID
    	if(!$(this).hasClass('hasclick')){
    		//添加已点击类
    		$(this).addClass('hasclick');
    		
    		var inputNumObj = $('.catory'+category).find('input[name="'+productId+'"]');//订单中数量改变
    		var inputVal = inputNumObj.val();
    		blockCategory.find('.taste-list input').val(inputVal);
    	}
    	$('.taste-layer').show();
    	$('.tastepad').hide();
    	$(this).parents('.blockCategory').find('.tastepad').show();
    });
    //选择产品口味
    $('#forum_list').on('click','.tastepad .item',function(){
    	var tasteList = $(this).parents('.taste-list');
    	var eq = tasteList.attr('eq');
    	
    	var num = tasteList.find('input.input-product').val();
    	
    	if($(this).hasClass('active')){
    		var productId = $(this).attr('product-id');
    		var tasteId = $(this).attr('taste-id');
    		$('input[name="'+productId+'['+num+'-'+eq+']['+tasteId+']'+'"]').remove();
    		$(this).removeClass('active');
    	}else{
    		var productId = $(this).attr('product-id');
    		var tasteId = $(this).attr('taste-id');
    		var str = '<input type="hidden" name="'+productId+'['+num+'-'+eq+']['+tasteId+']'+'" value="1"/>';
    		$('#padOrderForm').append(str);
    		$(this).addClass('active');
    	}
    });
  //增加口味
    var i = 2;
    $('#forum_list').on('click','#addTaste',function(){
    	//订单 和 商品中数量变化
		 var blockCategory = $(this).parents('.blockCategory');
	   	 
	   	 var category = blockCategory.attr('category');//分类id
	   	 var productId = blockCategory.find('a.product-pic').attr('lid');//产品 ID
	   	 var store = blockCategory.attr('store'); // 库存
	   	 
	   	 //检查库存
	   	 if(store==0){
	   		 layer.msg('库存不足');
	   		 return;
	   	 }
	   	 if(store >= 0){
				store -=1;
				blockCategory.attr('store',store);
		}
    	
    	var str= '';
		str +='<div class="taste-list" eq="'+i+'">';
		str +='<div class="taste-title"><div class="taste-title-l">口味'+i+'</div><div class="taste-title-m"><a id="delTaste" href="javascript:;">-</a></div>';
		str +='<div class="taste-title-r"><span class="taste-minus" >-</span><input class="input-product" type="text" name="taste-num" value="1" readonly="true"/><span class="taste-plus">+</span></div><div class="clear"></div></div>';
		str +='<div class="taste-item">';
		str +=$(this).parents('.taste-list').find('.taste-item').html();
		str +='</div></div>';
		
		$(this).parents('.tastepad').append(str);
		
		 var singleNumObj = blockCategory.find('.single-num-circel'); //数量变化
			var singleNums = 0;
				singleNums = parseInt(singleNumObj.html());
			singleNumObj.html(singleNums+1);
			
		var inputNumObj = $('.catory'+category).find('input[name="'+productId+'"]');//订单中数量改变
		var inputVal = inputNumObj.val();
				inputNumObj.val(parseInt(inputVal)+1);
		 
		 totalPrice();
		 totalNum();
		 
		i++;
    });
    //删除口味
     $('#forum_list').on('click','#delTaste',function(){
     	 $(this).parents('.taste-list').remove();
     	 var blockCategory = $(this).parents('.blockCategory');
	   	 var productId = blockCategory.attr('product-id');
	   	 var store = blockCategory.attr('store');
	   	 
   		if(store >= 0){
   			store =parseInt(store) + 1;
   			blockCategory.attr('store',store);
   		}
   		
		 var singleNumObj = blockCategory.find('.single-num-circel'); //数量变化
			var singleNums = 0;
				singleNums = parseInt(singleNumObj.html());
			singleNumObj.html(singleNums-1);
			
		var inputNumObj = $('.catory'+category).find('input[name="'+productId+'"]');//订单中数量改变
		var inputVal = inputNumObj.val();
				inputNumObj.val(parseInt(inputVal)-1);
					
	   	 totalPrice();
		 totalNum();
     });
     
     //口味中数量减少
     $('#forum_list').on('click','.taste-minus',function(){
    	 
    	 var blockCategory = $(this).parents('.blockCategory');
    	 var nextInput = $(this).next('input');
    	 
    	 var category = blockCategory.attr('category');//分类id
    	 var productId = blockCategory.attr('product-id');
    	 var store = blockCategory.attr('store');
    	 var val = nextInput.val();//口味中数量变化
    	 if(parseInt(val) > 1){
    		nextInput.val(parseInt(val)-1); 
    		if(store >= 0){
    			store =parseInt(store) + 1;
    			blockCategory.attr('store',store);
    		}
    	 }
		 var singleNumObj = blockCategory.find('.single-num-circel'); //数量变化
			var singleNums = 0;
				singleNums = parseInt(singleNumObj.html());
			singleNumObj.html(singleNums-1);
			
		var inputNumObj = $('.catory'+category).find('input[name="'+productId+'"]');//订单中数量改变
		var inputVal = inputNumObj.val();
				inputNumObj.val(parseInt(inputVal)-1);
				
    	 totalPrice();
 		 totalNum();
      });
     
     //口味中数量增加
     $('#forum_list').on('click','.taste-plus',function(){
    	 var blockCategory = $(this).parents('.blockCategory');
    	 var prevInput = $(this).prev('input');
    	 
    	 var category = blockCategory.attr('category');//分类id
    	 var productId = blockCategory.find('a.product-pic').attr('lid');//产品 ID
    	 var store = blockCategory.attr('store'); // 库存
    	 
    	 if(store==0){
    		 layer.msg('库存不足');
    		 return;
    	 }
    	 if(store >= 0){
 			store -=1;
 			blockCategory.attr('store',store);
 		 }
    	 var val = prevInput.val();//口味中数量变化
    	 	prevInput.val(parseInt(val)+1); 
		 var singleNumObj = blockCategory.find('.single-num-circel'); //数量变化
			var singleNums = 0;
				singleNums = parseInt(singleNumObj.html());
			singleNumObj.html(singleNums+1);
			
		var inputNumObj = $('.catory'+category).find('input[name="'+productId+'"]');//订单中数量改变
		var inputVal = inputNumObj.val();
				inputNumObj.val(parseInt(inputVal)+1);
		 
		 totalPrice();
		 totalNum();
    });
    $('.taste-layer').on('click',function(){
    	$('.tastepad').hide();
    	$(this).hide();
    });
    $('#updatePadOrder').on(event_clicktouchstart,function(){
    	//layer页面层
//    	var str = '<a herf="javascript:;" class="pay-type cash-color" id="cashpay">柜台支付</a><a herf="javascript:;" class="pay-type wx-color" id="weixinpay">微信支付</a><a herf="javascript:;" class="pay-type zfb-color" id="zhifubaopay">支付宝支付</a>';
//		layer.open({
//		    type: 1,
//		    skin: 'layui-layer-rim', //加上边框
//		    area: ['420px', '240px'], //宽高
//		    content: str
//		});
        if (typeof Androidwymenuprinter == "undefined") {
            alert(language_notget_padinfo);
            return false;
        }
    	$('#padOrderForm').ajaxSubmit({
            async:false,
            dataType: "json",
            success:function(msg){
                var data=msg;
                var printresult;
    		if(data.status){
                 if(data.type=='local')
                 {
                     printresult=Androidwymenuprinter.printJob(data.dpid,data.jobid);
                 }else{
                     printresult=Androidwymenuprinter.printNetJob(data.dpid,data.jobid,data.address);
                 }
                 if(printresult)
                 {
                	 $('#padOrderForm').find('.input-product').each(function(){
                		 	var _this = $(this);
                            var productId = _this.attr('name');
                            var productIdArr = productId.split(","); //字符分割 
                            productId = productIdArr[0];
                            var parents = $('.blockCategory a[lid="'+productId+'"]').parents('.blockCategory');
                            var category = parents.attr('category');//分类id
                            parents.find('.subject-order').css('display','none');
                            parents.find('.single-num-circel').html(0);
                            _this.parents('.product-catory-product').remove();
                            if(!$('.catory'+category).find('.product-catory-product').length){
			    			$('.catory'+category).remove();
			    			parents.find('.product-taste').removeClass('hasclick'); //去掉口味点击类
			    			parents.find('.taste-list').each(function(eq){
			    				if(eq > 0){
			    					$(this).remove();
			    				}else{
			    					$(this).find('.item').removeClass('active'); //去掉第一个口味选中
			    				}
			    			});
			    		}
                     });
                     $('.product-pad-mask').hide();
                     var total = 0;
                     if(!parseInt(language)){
             			total = total.toFixed(2);
             		}
                     $('.total-price').html(total);
                        $('.total-num').html(0);
                 }else{
                     alert(language_print_pad_fail);
                 }                                                
                }else{
                    alert(data.msg);
                }
    		}
     	});
    });
    $('body').on(event_clicktouchstart,'#cashpay',function(){
     	alert('现金支付');
     });
     $('body').on(event_clicktouchstart,'#weixinpay',function(){
     	alert('微信支付');
     });
     $('body').on(event_clicktouchstart,'#zhifubaopay',function(){
     	alert('支付宝支付');
     });
    $('#padOrderForm').on('click','.product-catory-product',function(){
    	var input = $(this).find('input');
    	var productId = input.attr('name');
    	var productIdArr = productId.split(","); //字符分割 
        productId = productIdArr[0];
        var parents = $('.blockCategory a[lid="'+productId+'"]').parents('.blockCategory');
        var category = parents.attr('category');//分类id
        $('#pad_category_select').val(category);
        var height = parents.offset().top;
		$('body').scrollTop(parseInt(height)-70);
        $(".setting-pad-mask").css('display','none');
        $('.product-pad-mask').css('display','none');
    });
 });