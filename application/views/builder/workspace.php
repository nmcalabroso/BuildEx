<div id="workspace" class="demo panel callout" style="min-width:576px; max-width:576px; height:432px; position:relative; margin:auto; vertical-align: middle; padding:5px; border:0px" data-eid='<?= $eid;?>'>
<div id="page1"></div>
</div>
<script>
// (function($){
// 	$(function(){
// 		// alert('fak');
// 		alert($.count);
// 		$.count = 10;
// 		alert($.count);
// 	});
	
// }) (jQuery); 
</script>
<? 	
	if(isset($var)){
		echo '<script>';
		echo '(function($){ ';
		echo '$(function() {';
		foreach ($var as $obj){
			if($obj[2] == "question")
				echo '$("#question").trigger("click",['.$obj[0].','.$obj[1].',"' .$obj[3] .'",1]);';
			
			else if($obj[2] == "label")
				echo '$("#textinput").trigger("click",['.$obj[0].','.$obj[1].',"' .$obj[3] .'",1]);';
			
			else if($obj[2] == "button")
				echo '$("#button").trigger("click",['.$obj[0].','.$obj[1].',"' .$obj[3] .'",1]);';
			
			else if($obj[2] == "radio")
				echo '$("#radiobutton").trigger("click",['.$obj[0].','.$obj[1].']);';
			
			else if($obj[2] == "checkbox")
				echo '$("#checkbox").trigger("click",['.$obj[0].','.$obj[1].']);';
			
			else if($obj[2] == "dropdown")
				echo '$("#dropdown").trigger("click",['.$obj[0].','.$obj[1].']);';
			
			else if($obj[2] == "slider")
				echo '$("#slider").trigger("click",['.$obj[0].','.$obj[1].']);';
			
			else
				echo '$("#question").trigger("click",['.$obj[0].','.$obj[1].']);';
		}
		echo '});';
		echo '}) (jQuery);';
		echo '</script>';
	}
?>