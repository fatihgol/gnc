<?php
if (!defined('gnc'))
	die();
?>
			<hr>
			
			<!-- FOOTER -->
			<footer>
	        	<p class="pull-right"><a href="" class="yukari">Yukarı</a></p>
	        	<p><?php echo $ayar['site_adi']; ?> <!--&middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a>--></p>
			</footer>
	
	    </div><!-- /.container -->


	    <!-- Bootstrap core JavaScript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
	    <script src="<?php echo $site['url']; ?>bootstrap/dist/js/bootstrap.min.js"></script>
	    <script src="<?php echo $site['url']; ?>bootstrap/docs-assets/js/holder.js"></script>
	    <?php
	    if (gnc_yetki(100))
		{
		?>
		<script type="text/javascript">
		// This is a check for the CKEditor class. If not defined, the paths must be checked.
		if ( typeof CKEDITOR != 'undefined' )
		{
			// var editor = CKEDITOR.replace( 'editor1' );
			// editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );	
			// Just call CKFinder.setupCKEditor and pass the CKEditor instance as the first argument.
			// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
			CKFinder.setupCKEditor( null, '<?php echo $site['url'] ?>') ;
		}
		<?php
		}
		?>
		</script>
	</body>
</html>