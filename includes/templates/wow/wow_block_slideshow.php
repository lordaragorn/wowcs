<!-- START: Slideshow -->
<div id="slideshow">
        <div class="container">
<?php
global $carousel;
$i = 0;
$paging_text = null;
$js_string = null;
foreach($carousel as $car) {
    echo sprintf("                <div class=\"slide\" id=\"slide-%d\"
                    style=\"background-image: url('/cms/carousel_header/%s'); \">
                </div>\n", $i, $car->image);
    $paging_text .= sprintf("<a href=\"javascript:;\" id=\"paging-%d\" onclick=\"Slideshow.jump(%d, this);\" onmouseover=\"Slideshow.preview(%d);\" class=\"current\"></a>\n", $i, $i, $i);
    $js_string .= sprintf("                {
                    image: \"/cms/carousel_header/%s\",
                    desc: \"%s\",
                    title: \"%s\",
                    url: \"%s\",
                    id: \"%d\"
                },\n", $car->image, $car->desc, $car->title, $car->url, $car->id);
    $i++;
}
?>
		</div>

			<div class="paging"><?php echo $paging_text; ?></div>
		
		<div class="caption">
            <?php
            $max = count($carousel)-1;
            echo sprintf("<h3><a href=\"#\" class=\"link\">%s</a></h3>\n
			%s\n", $carousel[$max]->title, $carousel[$max]->desc);
            ?>
			
		</div>

		<div class="preview"></div>
		<div class="mask"></div>
    </div>

	<script type="text/javascript">
	//<![CDATA[
        $(function() {
            Slideshow.initialize('#slideshow', [
<?php echo $js_string; ?>
            ]);

        });
	//]]>
	</script>
<!-- END: Slideshow -->
