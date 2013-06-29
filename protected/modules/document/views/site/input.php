<input id='input'  rel='show'>

<div id='show' >
	 <span>热门推荐</span>
	 <div class='tab'><a rel='t0' href='#'>城市</a> &nbsp;&nbsp;<a rel='t1'  href='#'>景点</a></div>
	 <div id='t0' class='value'>
	 	<span>上海</span>，<span>北京</span>，<span>香港</span>
	 </div>
	 <div id='t1'  class='value'>
	 	<span>西湖</span>，<span>黄山</span>
	 </div>
</div>
<?php
js(" 
$('#input').myinput({attr:'#input'});  
$('.tab').mytab();
");
js_file('js/myinput.js');
js_file('js/mytab.js');
?>