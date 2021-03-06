 var Davur = function(){
	/* Search Bar ============ */
	var screenWidth = $( window ).width();
	
	var handleSelectPicker = function(){
		if(jQuery('.default-select').length > 0 ){
			jQuery('.default-select').selectpicker();
		}
	}

	var handleTheme = function(){
		$('#preloader').fadeOut(500);
		$('#main-wrapper').addClass('show');
		
		jQuery('.menu-btn, .openbtn').on('click',function(){
			jQuery('.menu-sidebar').addClass('active');
		});
		
		jQuery('.menu-close').on('click',function(){
			jQuery('.menu-sidebar').removeClass('active');
			jQuery('.menu-btn').removeClass('open');
		});
		
		jQuery('.navicon').on('click',function(){
			if($(this).hasClass('open')){
				jQuery('.menu-sidebar').removeClass('active');
			}
			$(this).toggleClass('open');
		});
		
		
	}
	
	var handleBootstrapTouchSpin = function(){
		if(jQuery(".btn-quantity input").length > 0 ){
			jQuery(".btn-quantity input").TouchSpin({
			  verticalbuttons: true,
			});
		}
	}

	

   var handleMetisMenu = function() {
		if(jQuery('#menu').length > 0 ){
			$("#menu").metisMenu();
		}
		jQuery('.metismenu > .mm-active ').each(function(){
			if(!jQuery(this).children('ul').length > 0)
			{
				jQuery(this).addClass('active-no-child');
			}
		});
	}
	
    var handleAllChecked = function() {
		$("#checkAll").on('change',function() {
			$("td input:checkbox, .email-list .custom-checkbox input:checkbox").prop('checked', $(this).prop("checked"));
		});
	}

    var handleNavigation = function() {
		$(".nav-control").on('click', function() {

			$('#main-wrapper').toggleClass("menu-toggle");

			$(".hamburger").toggleClass("is-active");
		});
	}

	var handleCurrentActive = function() {
		for (var nk = window.location,
			o = $("ul#menu a").filter(function() {
				
				return this.href == nk;
				
			})
			.addClass("mm-active")
			.parent()
			.addClass("mm-active");;) 
		{
			
			if (!o.is("li")) break;
			
			o = o.parent()
				.addClass("mm-show")
				.parent()
				.addClass("mm-active");
		}
	}

	var handleMiniSidebar = function() {
		$("ul#menu>li").on('click', function() {
			const sidebarStyle = $('body').attr('data-sidebar-style');
			if (sidebarStyle === 'mini') {
				console.log($(this).find('ul'))
				$(this).find('ul').stop()
			}
		})
	}
   
	var handleMinHeight = function() {
		var win_h = window.outerHeight;
		var win_h = window.outerHeight;
		if (win_h > 0 ? win_h : screen.height) {
			$(".content-body").css("min-height", (win_h + 60) + "px");
		};
	}
    
	var handleDataAction = function() {
		$('a[data-action="collapse"]').on("click", function(i) {
			i.preventDefault(),
				$(this).closest(".card").find('[data-action="collapse"] i').toggleClass("mdi-arrow-down mdi-arrow-up"),
				$(this).closest(".card").children(".card-body").collapse("toggle");
		});

		$('a[data-action="expand"]').on("click", function(i) {
			i.preventDefault(),
				$(this).closest(".card").find('[data-action="expand"] i').toggleClass("icon-size-actual icon-size-fullscreen"),
				$(this).closest(".card").toggleClass("card-fullscreen");
		});



		$('[data-action="close"]').on("click", function() {
			$(this).closest(".card").removeClass().slideUp("fast");
		});

		$('[data-action="reload"]').on("click", function() {
			var e = $(this);
			e.parents(".card").addClass("card-load"),
				e.parents(".card").append('<div class="card-loader"><i class=" ti-reload rotate-refresh"></div>'),
				setTimeout(function() {
					e.parents(".card").children(".card-loader").remove(),
						e.parents(".card").removeClass("card-load")
				}, 2000)
		});
	}

    var handleHeaderHight = function() {
		const headerHight = $('.header').innerHeight();
		$(window).scroll(function() {
			if ($('body').attr('data-layout') === "horizontal" && $('body').attr('data-header-position') === "static" && $('body').attr('data-sidebar-position') === "fixed")
				$(this.window).scrollTop() >= headerHight ? $('.deznav').addClass('fixed') : $('.deznav').removeClass('fixed')
		});
	}
	
	var handleDzScroll = function() {
		jQuery('.dz-scroll').each(function(){
		
			var scroolWidgetId = jQuery(this).attr('id');
			const ps = new PerfectScrollbar('#'+scroolWidgetId, {
			  wheelSpeed: 2,
			  wheelPropagation: true,
			  minScrollbarLength: 20
			});
		})
	}
	
	var handleMenuTabs = function() {
		if(screenWidth <= 991 ){
			jQuery('.menu-tabs .nav-link').on('click',function(){
				if(jQuery(this).hasClass('open'))
				{
					jQuery(this).removeClass('open');
					jQuery('.fixed-content-box').removeClass('active');
					jQuery('.hamburger').show();
				}else{
					jQuery('.menu-tabs .nav-link').removeClass('open');
					jQuery(this).addClass('open');
					jQuery('.fixed-content-box').addClass('active');
					jQuery('.hamburger').hide();
				}
				//jQuery('.fixed-content-box').toggleClass('active');
			});
			jQuery('.close-fixed-content').on('click',function(){
				jQuery('.fixed-content-box').removeClass('active');
				jQuery('.hamburger').removeClass('is-active');
				jQuery('#main-wrapper').removeClass('menu-toggle');
				jQuery('.hamburger').show();
			});
		}
	}
	
	var handleChatbox = function() {
		jQuery('.bell-link').on('click',function(){
			jQuery('.chatbox').addClass('active');
		});
		jQuery('.chatbox-close').on('click',function(){
			jQuery('.chatbox').removeClass('active');
		});
	}
	
	var handlePerfectScrollbar = function() {
		if(jQuery('.deznav-scroll').length > 0)
		{
			const qs = new PerfectScrollbar('.deznav-scroll');
		}
	}

	var handleBtnNumber = function() {
		$('.btn-number').on('click', function(e) {
			e.preventDefault();

			fieldName = $(this).attr('data-field');
			type = $(this).attr('data-type');
			var input = $("input[name='" + fieldName + "']");
			var currentVal = parseInt(input.val());
			if (!isNaN(currentVal)) {
				if (type == 'minus')
					input.val(currentVal - 1);
				else if (type == 'plus')
					input.val(currentVal + 1);
			} else {
				input.val(0);
			}
		});
	}
	
	var handleDzChatUser = function() {
		jQuery('.dz-chat-user-box .dz-chat-user').on('click',function(){
			jQuery('.dz-chat-user-box').addClass('d-none');
			jQuery('.dz-chat-history-box').removeClass('d-none');
		}); 
		
		jQuery('.dz-chat-history-back').on('click',function(){
			jQuery('.dz-chat-user-box').removeClass('d-none');
			jQuery('.dz-chat-history-box').addClass('d-none');
		}); 
		
		jQuery('.dz-fullscreen').on('click',function(){
			jQuery('.dz-fullscreen').toggleClass('active');
		});
	}
	
	var handleDzFullScreen = function() {
		jQuery('.dz-fullscreen').on('click',function(e){
			if(document.fullscreenElement||document.webkitFullscreenElement||document.mozFullScreenElement||document.msFullscreenElement) { 
				/* Enter fullscreen */
				if(document.exitFullscreen) {
					document.exitFullscreen();
				} else if(document.msExitFullscreen) {
					document.msExitFullscreen(); /* IE/Edge */
				} else if(document.mozCancelFullScreen) {
					document.mozCancelFullScreen(); /* Firefox */
				} else if(document.webkitExitFullscreen) {
					document.webkitExitFullscreen(); /* Chrome, Safari & Opera */
				}
			} 
			else { /* exit fullscreen */
				if(document.documentElement.requestFullscreen) {
					document.documentElement.requestFullscreen();
				} else if(document.documentElement.webkitRequestFullscreen) {
					document.documentElement.webkitRequestFullscreen();
				} else if(document.documentElement.mozRequestFullScreen) {
					document.documentElement.mozRequestFullScreen();
				} else if(document.documentElement.msRequestFullscreen) {
					document.documentElement.msRequestFullscreen();
				}
			}		
		});
	}
	
	var heartBlast = function (){
		$(".heart").on("click", function() {
			$(this).toggleClass("heart-blast");
		});
	}	
	
	var handleshowPass = function(){
		jQuery('.show-pass').on('click',function(){
			jQuery(this).toggleClass('active');
			if(jQuery('#dz-password').attr('type') == 'password'){
				jQuery('#dz-password').attr('type','text');
			}else if(jQuery('#dz-password').attr('type') == 'text'){
				jQuery('#dz-password').attr('type','password');
			}
		});
	}
	
	var handleCustomFileInput = function() {
		$(".custom-file-input").on("change", function() {
			var fileName = $(this).val().split("\\").pop();
			$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		});
	}
	
	var handleDzLoadMore = function() {
		$(".dz-load-more").on('click', function(e)
		{
			e.preventDefault();	//STOP default action
			$(this).append(' <i class="fa fa-refresh"></i>');
			
			var dzLoadMoreUrl = $(this).attr('rel');
			var dzLoadMoreId = $(this).attr('id');
			
			$.ajax({
				method: "POST",
				url: dzLoadMoreUrl,
				dataType: 'html',
				success: function(data) {
					$( "#"+dzLoadMoreId+"Content").append(data);
					$('.dz-load-more i').remove();
				}
			})
		});
	}
	
	/* Masonry Box ============ */
	var masonryBox = function(){
		'use strict';
		/* masonry by  = bootstrap-select.min.js */
		if(jQuery('#masonry, .masonry').length > 0)
		{
			var self = jQuery("#masonry, .masonry");
	 
			if(jQuery('.card-container').length > 0)
			{
				var gutterEnable = self.data('gutter');
				
				var gutter = (self.data('gutter') === undefined)?0:self.data('gutter');
				gutter = parseInt(gutter);
				
				
				var columnWidthValue = (self.attr('data-column-width') === undefined)?'':self.attr('data-column-width');
				if(columnWidthValue != ''){columnWidthValue = parseInt(columnWidthValue);}
				
				 /* self.imagesLoaded(function () {
					self.masonry({
						//gutter: gutter,
						//columnWidth:columnWidthValue, 
						gutterWidth: 15,
						isAnimated: true,
						itemSelector: ".card-container",
						//percentPosition: true
					});
					
				});  */
			} 
		}
		if(jQuery('.filters').length)
		{
			jQuery(".filters li:first").addClass('active');
			
			jQuery(".filters").on("click", "li", function() {
				jQuery('.filters li').removeClass('active');
				jQuery(this).addClass('active');
				
				var filterValue = $(this).attr("data-filter");
				self.isotope({ filter: filterValue });
			});
		}
		/* masonry by  = bootstrap-select.min.js end */
	}
	
	
	var handleImageUpload = function(){
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#imagePreview').css('background-image', 'url('+e.target.result +')');
					$('#imagePreview').hide();
					$('#imagePreview').fadeIn(650);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}
		$("#imageUpload").change(function() {
			readURL(this);
		});
	}
	var handleVideoUpload = function(){
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#videoPreview').css('background-image', 'url('+e.target.result +')');
					$('#videoPreview').hide();
					$('#videoPreview').fadeIn(650);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}
		$("#videoUpload").change(function() {
			readURL(this);
		});
	}
/* 	var handleSupport = function(){
		var support = '<script id="DZScript" src="../../dzassets.s3.amazonaws.com/w3-global8bb6.js?btn_dir=right"></script>';
		jQuery('body').append(support);
	} */
	
	/* Function ============ */
	return {
		init:function(){
			handleMetisMenu();
			handleAllChecked();
			handleNavigation();
			handleMiniSidebar();
			handleMinHeight();
			handleDataAction();
			handleHeaderHight();
			handleDzScroll();
			handleMenuTabs();
			handleChatbox();
			handlePerfectScrollbar();
			handleBtnNumber();
			handleDzChatUser();
			handleDzFullScreen();
			heartBlast();
			handleshowPass();
			handleSelectPicker();
			handleCustomFileInput();
			handleDzLoadMore();
			handleCurrentActive();
			handleBootstrapTouchSpin();
			handleImageUpload();
			handleVideoUpload();
			
		},

		
		load:function(){
			handleTheme();
			handleSelectPicker();
			masonryBox();
			/* handleSupport(); */
		},
		
		resize:function(){
			
			
		}
	}
	
}();

/* Document.ready Start */	
jQuery(document).ready(function() {
	$('[data-toggle="popover"]').popover();
    'use strict';
	Davur.init();
	
	jQuery('a[data-bs-toggle="tab"]').on('click',function(){
		$('a[data-bs-toggle="tab"]').on('click',function() {
		  $($(this).attr('href')).show().addClass('show active').siblings().hide();
		})
	});
	
	
	
});
/* Document.ready END */

/* Window Load START */
jQuery(window).on('load',function () {
	'use strict'; 
	Davur.load();
	
});
/*  Window Load END */
/* Window Resize START */
jQuery(window).on('resize',function () {
	'use strict'; 
	Davur.resize();
});
/*  Window Resize END */

/*  Custom code START */

const base_url = $("#base_url").val();

const showItemList = (className) => {
	$(".item-box-check.active").removeClass("active");
  	$(".active-" + className).addClass("active");
	$("#products-list").children().not("." + className).fadeOut('fast', function(){
		$("." + className).fadeIn('fast');
	});
};

const viewItemDetails = (id) => {
	const details = $(`input[name=${id}]`).val();
	$('#item-details').html(details);
	$("#itemDetailsModal").modal("show");
};

var ajaxReq = "ToCancelPrevReq";

const saveToCart = () => {

	if($("input[name=admin]").val() === 'captain' || ($("input[name=role]").length > 0 && $("input[name=role]").val() === 'Accountant'))
	{
		const items = JSON.parse(localStorage.getItem("cart"));
		
		if(items !== null)
		{
			ajaxReq = $.ajax({
				url: `${base_url}saveToCart`,
				method: 'POST',
				data: {items: items},
				beforeSend : function(){
					if (ajaxReq != 'ToCancelPrevReq' && ajaxReq.readyState < 4) {
						ajaxReq.abort();
					}
				}
			});
		}

	}else return;
};

const addItem = (id) => {
	let myCart = JSON.parse(localStorage.getItem("cart"));
	
	if (myCart && myCart.length > 0)
		myCart.push({
				'item' : id,
				'qty' : 1
			});
	else
		myCart = [{
			'item' : id,
			'qty' : 1
		}];

	localStorage.setItem("cart", JSON.stringify(myCart));
	showItems();
};

const clearItems = () => {
	localStorage.setItem("cart", JSON.stringify([]));
};

const updateItem = (id, qty) => {
	let myCart = JSON.parse(localStorage.getItem("cart"));

	myCart = myCart.filter(function(item){
		if (id == item.item)
		{
			if (qty > 0){
				item.qty = qty;
				return item;
			}else{
				if ($(`#remove-${item.item}`).length > 0) 
					$(`#remove-${item.item}`).remove();
				else{
					let html;
					html = `
						<a href="javascript:;" onclick="addItem('${item.item}');" class="btn btn-warning light btn-xs btn-rounded ms-1 d-inline-block"><i class="fa fa-plus"></i></a>
						<a href="javascript:;" onclick="viewItemDetails('item-details-${item.item}');" class="btn btn-danger light btn-xs btn-rounded ms-1 d-inline-block"><i class="fa fa-eye"></i></a>
					`;
					$(`#item-${item.item}`).html(html);
				}
				return;
			}
		}else
			return item;
	});

	if ((window.location.href.indexOf("cart") !== -1 || window.location.href.indexOf('add-order') !== -1) && myCart.length <= 0)
	{
		$("#products-list").html(`<tr class="">
			<td colspan="7" class="text-center"><span class="font-w500">No products available.</span></td>
		</tr>`);
	}

	localStorage.setItem("cart", JSON.stringify(myCart));
  	showItems();
};

const showItems = () => {
	const items = JSON.parse(localStorage.getItem("cart"));
	
	if(items && items.length > 0)
	{
		let html;
		$.each(items, function (index, item){
			html = `
				<a href="javascript:;" onclick="updateItem(${item.item}, ${item.qty - 1});" class="btn btn-warning light btn-rounded btn-xxs"><i class="fa fa-minus"></i></a>
				<span class="p-2" id="qty-${item.item}">${item.qty}</span>
				<a href="javascript:;" onclick="updateItem(${item.item}, ${item.qty + 1});" class="btn btn-warning light btn-rounded btn-xxs"><i class="fa fa-plus"></i></a>
			`;
			$(`#item-${item.item}`).html(html);
			$(`#place-order`).fadeIn('slow');
		});
	}else
		$(`#place-order`).fadeOut('fast');

	saveToCart();
};

const checkRemarks = (id) => {
	$("#item-id").val(id);
	const remarks = $(`#item-remarks-${id}`).html();
	$("#remarks").val(remarks);
	return;
};

const addRemarks = () => {
	const id = $("#item-id").val();
	const remarks = $("#remarks").val();
	
	$(`#item-remarks-${id}`).html(remarks);
	$("#remarks").val('');
	$("#addRemarksModal").modal("hide");

	let myCart = JSON.parse(localStorage.getItem("cart"));

	myCart = myCart.filter(function(item){
		if (id == item.item)
		{
			item.remarks = remarks;
			return item;
		}else
			return item;
	});

	localStorage.setItem("cart", JSON.stringify(myCart));
	
	saveToCart();
};

showItems();

if($('.item-carousel').length > 0)
{
	$('.item-carousel').owlCarousel({
		loop:true,
		margin:15,
		nav:true,
		autoplay:true,
		dots: false,
		
		responsive : {
			// breakpoint from 0 up
			0 : {
				items:2,
			},
			// breakpoint from 480 up
			480 : {
				items:2,
			},
			// breakpoint from 768 up
			768 : {
				items:4,
			}
		},
		navText: ['', ''],
		breackpoint:[
			
		]
	});

	if($(".item-box-check").length > 0)
	{
		let className;

		$.each($(".item-box-check"), function (key, item) {
			if($(item).hasClass('active')) className = $(item).data("class");
		});

		showItemList(className);
		showItems();
	}
}

const successMsg = (msg) => {
	toastr.success(msg, "Success : ", {
		positionClass: "toast-bottom-full-width",
		timeOut: 5e3,
		closeButton: !0,
		debug: !1,
		newestOnTop: !0,
		progressBar: !0,
		preventDuplicates: !0,
		onclick: null,
		showDuration: "300",
		hideDuration: "1000",
		extendedTimeOut: "1000",
		showEasing: "swing",
		hideEasing: "linear",
		showMethod: "fadeIn",
		hideMethod: "fadeOut",
		tapToDismiss: !1,
	});
};

const errorMsg = (msg) => {
	toastr.error(msg, "Error : ", {
		positionClass: "toast-bottom-full-width",
		timeOut: 5e3,
		closeButton: !0,
		debug: !1,
		newestOnTop: !0,
		progressBar: !0,
		preventDuplicates: !0,
		onclick: null,
		showDuration: "300",
		hideDuration: "1000",
		extendedTimeOut: "1000",
		showEasing: "swing",
		hideEasing: "linear",
		showMethod: "fadeIn",
		hideMethod: "fadeOut",
		tapToDismiss: !1,
	});
};

if ($("input[name=error_msg]").val() !== '') errorMsg($("input[name=error_msg]").val());
if ($("input[name=success_msg]").val() !== '') successMsg($("input[name=success_msg]").val());

if (window.location.href.indexOf("order-success") !== -1) clearItems();

const donutChart = () => {
	
	$.get(`${base_url}getItemsData`, (data) => {

		data = JSON.parse(data);

		const options = {
			series: data.series,
			//colors:['#ff5c5a', '#2bc156', '#404a56'],
			chart: {
				height: 330,
				width:560,
				type: 'donut',
				sparkline: {
					enabled: true,
				},
			},
			labels: data.labels,
			plotOptions: {
				pie: {
					customScale: 1,
					donut: {
						size: '50%'
					}
				}
			},
			legend: {
				show:true,
				fontSize: '18px',
				position: 'right',
					offsetY: 0,
					//height: 270,
					itemMargin: {
						vertical: 5,
						horizontal: 5,
					},
					markers: {
						width: 16,
						height: 16,
						strokeWidth: 0,
						radius: 0,
					},
			},
			dataLabels: {
				enabled: false
			},
			responsive: [{
				breakpoint: 1300,
				options: {
					chart: {
						height: 230,
						width:400
					},
					legend: {
						fontSize: '14px',
						itemMargin: {
							vertical: 0,
							horizontal: 5,
						},
					}
				}
			},
			{
				breakpoint: 575,
				options: {
					chart: {
						height: 230,
						width:300
					},
					legend: {
						show:false,
						fontSize: '14px',
						itemMargin: {
							vertical: 0,
							horizontal: 5,
						},
					}
				}
			}],
		};
	
		const chart = new ApexCharts(document.querySelector("#chart"), options);
		
		chart.render();
	});
}

const activityBar = () => {

	const activity = document.getElementById("activity");

	if (activity !== null) {
		$.get(`${base_url}getRevenueData`, (data) => {

			data = JSON.parse(data);
			
			let total = 0;
			
			$.each(data.earnings, function (index, value) {
				total += value;
			});

			activity.height = 260;
		
			const config = {
				type: "bar",
				data: {
					labels: data.dates,
					datasets: [
						{
							label: "Total Earning",
							data:  data.earnings,
							borderColor: 'rgba(47, 76, 221, 1)',
							borderWidth: "0",
							barThickness:'flex',
							backgroundColor: '#ff6d4d',
							minBarLength:10
						}
					]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								color: "rgba(233,236,255,1)",
								drawBorder: true
							},
							ticks: {
								fontColor: "#3e4954",
								max: Math.max(...data.earnings) + 10,
								min: 0,
								stepSize: Math.ceil(total / data.earnings.length * 15)
							},
						}],
						xAxes: [{
							barPercentage: 0.7,
							
							gridLines: {
								display: true,
								zeroLineColor: "transparent"
							},
							ticks: {
								stepSize: 20,
								fontColor: "#3e4954",
								fontFamily: "Nunito, sans-serif"
							}
						}]
					},
					tooltips: {
						mode: "index",
						intersect: false,
						titleFontColor: "#888",
						bodyFontColor: "#555",
						titleFontSize: 12,
						bodyFontSize: 15,
						backgroundColor: "rgba(255,255,255,1)",
						displayColors: true,
						xPadding: 10,
						yPadding: 7,
						borderColor: "rgba(220, 220, 220, 1)",
						borderWidth: 1,
						caretSize: 6,
						caretPadding: 10
					}
				}
			};

			const ctx = document.getElementById("activity").getContext("2d");
			const myLine = new Chart(ctx, config);
		});
	}
}

const counterBar = () => {
	if($(".counter").length > 0)
		$(".counter").counterUp({
			delay: 30,
			time: 1500,
		});
};

if($("#chart").length > 0) donutChart();
activityBar();
counterBar();
/*  Custom code END */