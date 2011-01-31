<?php
/**
 * @package WordPress
 * @subpackage Toolbox
 */

$htmlFootFirst = "http://".$_SERVER["SERVER_NAME"]."/modulaise.php?action=printPane&pane=PANE_HTML_FOOT_FIRST";
$jsFoot        = "http://".$_SERVER["SERVER_NAME"]."/modulaise.php?action=printPane&pane=PANE_JS_FOOT";
$htmlFootLast  = "http://".$_SERVER["SERVER_NAME"]."/modulaise.php?action=printPane&pane=PANE_HTML_FOOT_LAST";

?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">
			<div id="site-generator">
				<a href="http://wordpress.org/" rel="generator">Proudly powered by WordPress</a><span class="sep"> | </span><?php printf( __( 'Theme: %1$s by %2$s.', 'toolbox' ), 'Toolbox', '<a href="http://automattic.com/" rel="designer">Automattic</a>' ); ?>
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<!-- Printing pane: <?php echo $htmlFootFirst; ?> -->
<?php readfile($htmlFootFirst);?>
<!-- Printing pane: <?php echo $jsFoot; ?> -->
<?php readfile($jsFoot);?>
<!-- Printing pane: <?php echo $htmlFootLast; ?> -->
<?php readfile($htmlFootLast);?>
</body>
</html>