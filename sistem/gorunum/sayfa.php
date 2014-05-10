<?php
if (!defined('gnc'))
	die();

echo '	<div class="container marketing">
			<div class="page-header">
				<div class="container">
					<h1>'.$yazi['icerik_baslik'].'</h1>
				</div><!--/container-->
			</div><!--/page-header-->
			<div class="container">
			  <div class="row featurette">';
			  	/* Sayfa içinde düzenleme eklentisi*/
				if ($_SESSION['kullanici_tipi'] > 99)
				{
				?>
				<script type="text/javascript" src="<?php echo $site['url']; ?>ckeditor/ckeditor.js"></script>
				<script type="text/javascript" src="<?php echo $site['url']; ?>ckfinder/ckfinder.js"></script>
				<script>
					$('#gnc_metin_duzelt').live('click', function() {
						metin = $('#gnc_duzenlenebilir_metin').html();
						sef   = $(this).attr('rel');
						var veri = {
							metin: metin,
							sef: sef
						}
						$.ajax({
							url: ajax_adresi+"gnc_yonetim_sayfa_icinden_icerik_duzenle",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
							type: "POST",       
							data: veri,   
							cache: false,
							success: function (response) {
								//yenile();											  // Gerekli ise ajax ile gelen verinin jquery ye gözükmesi için rebind et!
							}
						});
					});
				</script>
				<?php
					$contenteditable = 'contenteditable="true"';
				}
				else
				{
					$contenteditable = '';
				}
			  
			  	echo '
		        <div class="col-md-12">
		        	<div id="gnc_duzenlenebilir_metin" '.$contenteditable.'>'.$yazi['icerik_icerik'].'</div>';
					
					if ($_SESSION['kullanici_tipi'] > 99)
						echo '<p class="text-center"><a href="javascript:void(0);" id="gnc_metin_duzelt" rel="'.$yazi['icerik_sef'].'" class="btn  btn-lg btn-primary" role="button">Değişiklikleri Kaydet</a></p>';
					
		      	echo '  
		      	</div>
			</div>';
?>

