<?php 
 
widget('icheck' , array(
	'skin'=>'flat', 
	'color'=>'blue'
));
  ?>
<label>
  <input type="checkbox" name="quux[1]" disabled>
  Foo
</label>
<label>
  <input type="checkbox" name="quux[2]" >
  Foo2
</label>
	  
<label for="baz[1]">Bar</label>
<input type="radio" name="quux[2]" id="baz[1]" checked>

<label for="baz[2]">Bar</label>
<input type="radio" name="quux[2]" id="baz[2]">