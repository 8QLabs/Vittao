<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<div id="search-inputs">
<input type="submit" id="searchsubmit" value="Search" />
<input type="text" value="Search" name="s" id="s" onfocus="if(this.value == 'Search'){this.value = '';}" onblur="if(this.value == ''){this.value='Search';}" />
</div>
</form>