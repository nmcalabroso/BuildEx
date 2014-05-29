var answer_cache = {};
var total_page = 0;
var qid_list = Array();
$.count = 1;
$.current_page = 1;
$.last_selected = null;
$.start_time = 0;
$.times = [];
$.unload_flagger = true;

function clear_form(){
	var my_form = document.getElementById("demographics");
	my_form.reset();
}

function register_answer(qid,value){
	answer_cache[qid] = value;
}

function draw_question(posX, posY, text_input, page_num, width, height, color, qid){
	posX = typeof posX !== 'undefined' ? posX : null;
	posY = typeof posY !== 'undefined' ? posY : null;
	page_num = typeof page_num !== 'undefined' ? page_num : 0;
	text_input = typeof text_input !== 'undefined' ? text_input : "";
	width = typeof width !== 'undefined' ? width : 200;
	height = typeof height !== 'undefined' ? height : 40;
	color = typeof color !== 'undefined' ? color : 000000;
	color = '#' + color;	

	workspace_width = $('#workspace').width()/1024; //hardcoded
	workspace_height = $('#workspace').height()/576; //hardcoded
	new_font_size = Math.sqrt(Math.pow(workspace_width,2) * Math.pow(workspace_height,2));
	zoomed_x = (posX/1024)*100; //hardcoded
	zoomed_y = (posY/576)*100; //hardcoded

	var htmlData='<div id="qtn'+$.count+'" class = "static_obj" data-page=" ' + total_page + '"';

	if (posX !== null && posY !== null){
		htmlData += 'style="left:'+ zoomed_x +'%; top:'+ zoomed_y +'%; width:'+ width*workspace_width + 'px; height:'+ height*workspace_height +'px;"';
	}

	if(text_input !== ""){
		htmlData += '><div id="qtneditable'+$.count+'" value="'+qid+'" data-page="'+page_num+'" class="text-holder" style="font-size:'+new_font_size*14+'px;">'+text_input+'</div></div>';
	}

	else{
		htmlData += '><div id="qtneditable'+$.count+'" value="'+qid+'" data-page="'+page_num+'" class="text-holder" data-placeholder="Enter Question" style="font-size:'+new_font_size*14+'px;"></div></div>';
	}

	var temp = $.count;
	var index = page_num;
	if(index <= 0){
		$("#page" + $.current_page).append(htmlData);
	}
	else{
		$("#page" + index).append(htmlData);
	}
	
	document.getElementById('qtneditable'+$.count).style.color = color;	
	$.count++;
}

function draw_text_input(posX, posY, text_input, page_num, width, height){
	posX = typeof posX !== 'undefined' ? posX : null;
	posY = typeof posY !== 'undefined' ? posY : null;
	page_num = typeof page_num !== 'undefined' ? page_num : 0;
	text_input = typeof text_input !== 'undefined' ? text_input : "";
	width = typeof width !== 'undefined' ? width : 200;
	height = typeof height !== 'undefined' ? height : 40;

	workspace_width = $('#workspace').width()/1024; //hardcoded
	workspace_height = $('#workspace').height()/576; //hardcoded
	new_font_size = Math.sqrt(Math.pow(workspace_width,2) * Math.pow(workspace_height,2));
	zoomed_x = (posX/1024)*100; //hardcoded
	zoomed_y = (posY/576)*100; //hardcoded

	var htmlData='<div id="inp'+$.count+'" class = "static_obj" data-page="' + total_page + '"';

	if (posX !== null && posY !== null){
		htmlData += 'style="left:'+ zoomed_x +'%; top:'+ zoomed_y +'%;  width:' + width*workspace_width + 'px; height:' + height*workspace_height + 'px"';
	}

	htmlData += '><div id="inpeditable'+$.count+'"class="text-holder" data-placeholder="Enter Input" style="font-size:'+new_font_size*14+'px;"></div></div>';

	var temp = $.count;
	var index = page_num;
	if(index <= 0){
		$("#page" + $.current_page).append(htmlData);
	}
	else{
		$("#page" + index).append(htmlData);
	}

	$('#inpeditable'+temp).click(function(){
        $(this).attr('contenteditable','true');
	});
	$.count++;
}

function draw_button(posX, posY, text_input, page_num, width, height){
	posX = typeof posX !== 'undefined' ? posX : null;
	posY = typeof posY !== 'undefined' ? posY : null;
	page_num = typeof page_num !== 'undefined' ? page_num : 0;
	text_input = typeof text_input !== 'undefined' ? text_input : "Button";
	width = typeof width !== 'undefined' ? width : 150;
	height = typeof height !== 'undefined' ? height : 40;

	workspace_width = $('#workspace').width()/1024; //hardcoded
	workspace_height = $('#workspace').height()/576; //hardcoded
	new_font_size = Math.sqrt(Math.pow(workspace_width,2) * Math.pow(workspace_height,2));
	zoomed_x = (posX/1024)*100; //hardcoded
	zoomed_y = (posY/576)*100; //hardcoded

	var htmlData='<div id="btn'+$.count+'" class="static_obj" ' + 'data-page="' + total_page + '" ';

	if (posX !== null && posY !== null){

		htmlData += 'style="left:'+ zoomed_x +'%; top:'+ zoomed_y +'%; width:' + width*workspace_width + 'px; height:' + height*workspace_height + 'px;"';
	}
	else{
		htmlData += 'style="width:150px; height:60px"';
	}
	
	htmlData += '><button id="btneditable'+$.count+'" style="width:100%; height:100%; margin-bottom:0px; padding:0px; font-size:'+new_font_size*14+'px;">'+text_input+'</button></div>';
	
	var temp = $.count;

	var index = page_num;

	if(index <= 0)
		$("#page" + $.current_page).append(htmlData);
	else
		$("#page" + index).append(htmlData);

	$(document).click(function(e){
		if($(e.target).attr('id') == ('btneditable'+temp)){
			$(e.target).children().click();
			$(e.target).children().focus();
		}
	});
	$.count++;
}

function draw_radio_button(posX, posY, text_input, page_num, width, height){
	posX = typeof posX !== 'undefined' ? posX : null;
	posY = typeof posY !== 'undefined' ? posY : null;
	page_num = typeof page_num !== 'undefined' ? page_num : 0;
	text_input = typeof text_input !== 'undefined' ? text_input : "Radio Button";
	width = typeof width !== 'undefined' ? width : 120;
	height = typeof height !== 'undefined' ? height : 25;

	workspace_width = $('#workspace').width()/1024; //hardcoded
	workspace_height = $('#workspace').height()/576; //hardcoded
	new_font_size = Math.sqrt(Math.pow(workspace_width,2) * Math.pow(workspace_height,2));
	zoomed_x = (posX/1024)*100; //hardcoded
	zoomed_y = (posY/576)*100; //hardcoded

	var htmlData='<div id="radbtn'+$.count+'" class="radiosnap static_obj"';
	if (posX != null && posY != null){
		htmlData += 'style="left:'+ zoomed_x +'%; top:'+ zoomed_y +'%; width:' + width*workspace_width + 'px; height:' + workspace_height + 'px;"';
	}
	else{
		htmlData += 'style="height:25px; width:120px;"';
	}
	
	htmlData += '><input type="radio" id="radbtneditable'+$.count+'" name="'+ total_page +'" value="'+text_input+'" style="font-size:'+new_font_size*14+'px;">'+text_input+'</div>';
	
	var temp = $.count;
	var index = page_num;

	if(index <= 0)
		$("#page" + $.current_page).append(htmlData);
	else
		$("#page" + index).append(htmlData);

    $(document).click(function(e){
    	if($(e.target).attr('id') == ('radbtn'+temp)){
    		$(e.target).children('.default').click();
    		$(e.target).children('.default').focus();
    	}
    });
    
    $.count++;
}

function draw_checkbox(posX, posY, text_input, page_num, width, height){
	posX = typeof posX !== 'undefined' ? posX : null;
	posY = typeof posY !== 'undefined' ? posY : null;
	page_num = typeof page_num !== 'undefined' ? page_num : 0;
	text_input = typeof text_input !== 'undefined' ? text_input : "Checkbox";
	width = typeof width !== 'undefined' ? width : 200;
	height = typeof height !== 'undefined' ? height : 40;

	workspace_width = $('#workspace').width()/1024; //hardcoded
	workspace_height = $('#workspace').height()/576; //hardcoded
	new_font_size = Math.sqrt(Math.pow(workspace_width,2) * Math.pow(workspace_height,2));
	zoomed_x = (posX/1024)*100; //hardcoded
	zoomed_y = (posY/576)*100; //hardcoded

	var htmlData='<div id="chkbox'+$.count+'" class="checksnap static_obj"';

	if (posX != null && posY != null){
		htmlData += 'style="left:'+ zoomed_x +'%; top:'+ zoomed_y +'%; width:' + width*workspace_width + 'px; height:' + workspace_height + 'px;"';
	}
	else{
		htmlData += 'style="height:25px; width:120px;"';
	}
	
	htmlData += '><input type="checkbox" id="chkeditable'+$.count+'" name="'+ total_page +'" value="'+text_input+'">'+text_input+'</div>';
	
	var temp = $.count;
	var index = page_num;

	if(index <= 0)
		$("#page" + $.current_page).append(htmlData);
	else
		$("#page" + index).append(htmlData);

    $(document).click(function(e){
    	if($(e.target).attr('id') == ('chkbox'+temp)){
    		$(e.target).children('.default').click();
    		$(e.target).children('.default').focus();
    	}
    });
    
    $.count++;
}

function draw_slider(posX, posY, page_num, min, max){
	posX = typeof posX !== 'undefined' ? posX : null;
	posY = typeof posY !== 'undefined' ? posY : null;
	page_num = typeof page_num !== 'undefined' ? page_num : 0;

	workspace_width = $('#workspace').width()/1024; //hardcoded
	workspace_height = $('#workspace').height()/576; //hardcoded
	new_font_size = Math.sqrt(Math.pow(workspace_width,2) * Math.pow(workspace_height,2));
	zoomed_x = (posX/1024)*100; //hardcoded
	zoomed_y = (posY/576)*100; //hardcoded

	var htmlData='<div id="sldr'+$.count+'" class="static_obj"';
	if (posX != null && posY != null){
		htmlData += 'style="left:'+ zoomed_x +'%; top:'+ zoomed_y +'%; height:'+25*workspace_height+'px; width:'+360*workspace_width+'px"';
	}
	else{
		htmlData += 'style="height:25px; width:360px"';
	}

	htmlData += '><input id="movingslider'+$.count+'" class="sldr" type="text" data-slider="true" data-slider-range="1,1000"><span id="sldrspan'+$.count+'" class="output"></span></div>';

	var temp = $.count;
	var index = page_num;

	if(index <= 0)
		$("#page" + $.current_page).append(htmlData);
	else
		$("#page" + index).append(htmlData);

	$('#movingslider'+temp).simpleSlider();
	$('#sldrspan'+temp).html($('#movingslider'+temp).data('slider-range').split(',')[0]);
	$('#movingslider'+temp)
	    .bind("slider:ready slider:changed", function (event, data) {

	    	var a = $(this).data('slider-range').split(',');
	    	var base = 0;
	    	if(data.value.toFixed(3) == 0){
	    		base = parseInt(a[0]);
	    	}
	    	else{
	    		base = data.value.toFixed(3) * parseInt(a[1]);
	    	}
	      	$(this).nextAll(".output:first").html(base);
	});
    $.count++;
}

function save_input(){
	var x = new Array();
	console.log(total_page + " pages.");
	console.log($.times);

	x.push(total_page);
	x.push($.times);

	for(i=1; i<=$.count; i++){
		if ($('#inp'+i).offset() !== undefined){
			page = $('#inp'+i).parent().attr("id").slice(4);
			question = $("div").find('[data-page="'+page+'"]');
			qid = question.attr('value');
			var data = {
				'qid'		:	 qid,
				'page'		:	 page,
				'type'		:	 "text_input",
				'text'	 	:	 $('#inpeditable'+i).text(),
			}

			x.push(data);
			// console.log(data);
		}

		if ($('#radbtn'+i).offset() !== undefined){
			page = $('#radbtn'+i).parent().attr("id").slice(4);
			question = $("div").find('[data-page="'+page+'"]');
			qid = question.attr('value');
			var data = {
				'qid'		:	 qid,
				'page'		:	 page,
				'type'		:	 "radio",
				'text'	 	:	 $('#radbtneditable'+i).val(),
				'checked'	:	 $('#radbtneditable'+i).prop('checked'),
			}

			x.push(data);
			// console.log(data);
		}

		if ($('#chkbox'+i).offset() !== undefined){
			page = $('#chkbox'+i).parent().attr("id").slice(4);
			question = $("div").find('[data-page="'+page+'"]');
			qid = question.attr('value');
			var data = {
				'qid'		:	 qid,
				'page'		:	 page,
				'type'		:	 "checkbox",
				'text'	 	:	 $('#chkeditable'+i).val(),
				'checked'	:	 $('#chkeditable'+i).prop('checked'),
			}

			x.push(data);
			// console.log(data);
		}

		if ($('#sldr'+i).offset() !== undefined){
			page = $('#sldr'+i).parent().attr("id").slice(4);
			question = $("div").find('[data-page="'+page+'"]');
			qid = question.attr('value');
			var data = {
				'qid'		:	 qid,
				'page'		:	 page,
				'type'		:	 "slider",
				'value'	 	:	 $('#sldrspan'+i).text(),
			}

			x.push(data);
			// console.log(data);
		}
	}

	$.ajax({
		url: window.location.protocol+"//"+window.location.host + '/BuildEx/respond/save',
		type:"POST",
		data:{
			'msg':x,
		},

		dataType: 'json',
		complete: function(data) {
			// window.location.href = window.location.protocol+"//"+window.location.host + '/BuildEx/' + data.responseText + '/experiments';
			console.log(data.responseText);
		},
	});
}

(function($){
	$(function() {
		function checkEndPage() {
			if($.current_page+1 == total_page) {
				$('#next_page').text('Done')
				.css('padding-left',21).css('padding-right',21);
			}

			if($.current_page == total_page) {
				save_input();
				// window.location.href = window.location.protocol+"//"+window.location.host + '/BuildEx/respond/debrief/some_string';
				$.unload_flagger = false;
			}
		}

		$(window).on('beforeunload', function() {
			if($.unload_flagger) {
				$.ajax({
					url: window.location.protocol+"//"+window.location.host + '/BuildEx/respond/interrupted',
			        type:"POST",
			        data:{
			          'done' : 'false',
			        },
			        dataType: 'json',
				});
				return 'Exiting will not submit your form';
			}
		});

		$(document).ready(function(){
			$.start_time = (Date.now())/1000;
		});

		$("#debrief-btn").click(function() {
			$.unload_flagger = false;
		});
		
		$("#next_page").click(function(){
			$.end_time = (Date.now()/1000);
			$.times.push($.end_time - $.start_time);

			if($.current_page != total_page){
				$.start_time = (Date.now())/1000;
			}
			else if($.current_page == total_page){
				$.unload_flagger = false;
			}

			checkEndPage();

    		$("#page" + $.current_page).css('visibility','hidden');

			if($.current_page < total_page){
				$.current_page++;
			}

    		$("#page" + $.current_page).css('visibility','visible');		
		});
	});
})(jQuery);
