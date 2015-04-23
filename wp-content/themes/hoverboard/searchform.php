<form role="search" role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text">Search for:</span>
		<input type="search" class="search-form__input search-field" placeholder="Search…" value="" name="s" title="Search for:">
	</label>
	<button type="submit" class="search-submit"><?php hb_func_icon_svg('magnifying-glass'); ?><span class="visuallyhidden">Search</span></button>
</form>
