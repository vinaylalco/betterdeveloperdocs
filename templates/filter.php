<b>Monthly Budget</b></br>
<?php
foreach($template->get('hostingCompanyCategories') as $key => $value){ ?>
    <!-- $html .= '<input type="checkbox" name="'.$category->name.'" id="'.$category->name.'" value="'.$category->name.'" >'.$category->name.'</input></br>'; -->
    <input type="checkbox" class="filter<?php echo $key; ?>" data-fbdeep="0" data-fbflush="true" name="filter<?php echo $key; ?>"  value="<?php echo $key; ?>"/><?php echo $key; ?>
<?php } ?>
<!-- 
<input type="checkbox" class="filter1" data-fbdeep="0" data-fbflush="true" name="filter1"  value="none"/>None
<input type="checkbox" class="filter1" data-fbdeep="0" name="filter1" value="Ford"/>Ford
<input type="checkbox" class="filter1" data-fbdeep="0" name="filter1" value="Opel"/>Opel
<br/>
<br/>
<input type="checkbox" class="filter1" data-fbdeep="1" data-fbflush="true" name="filter2" value="none"/>None
<input type="checkbox" class="filter1" data-fbdeep="1" name="filter2" value="Speed"/>Speed
<input type="checkbox" class="filter1" data-fbdeep="1" name="filter2" value="Comfort"/>Comfort 
<input type="checkbox" class="filter1" data-fbdeep="1" name="filter2" value="Extreme"/>Extreme 
-->