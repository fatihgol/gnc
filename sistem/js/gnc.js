/*
 * gnc içinde çalışan ajax istekleri, php tetikleyicileri ajax.php'nin içinde bulunmaktadır.
 * 
 * Ajax istekleri çalıştırılırken sadece fonksiyon içeriği çalıştırılır daha önce veya daha sonra sayfa yüklemesi 
 * yapılmamaktadır. Zaten ajax'ın olayı da budur. Ayrıca kullanılan tüm js kodları tek bir js dosyasında bulunmalıdır.
 * 
 * Ajax isteklerinin url kısmına    ajax_adresi+"fonskiyon_adi"    yazılmalıdır. 
 * Bu sayede sistem/ajax.php içindeki fonksiyonlar ajax ile çalıştırılabilir.
 */


/* Sayfayı yenileyen fonksiyon */
function yenile(){
	location.reload();
}
/* GNC'de sürekli kullanılan nesnelere ait JS kodları */
$(function() {
	/* Sayfanın üstüne gitmeyi sağlayan, scroll to top */
	$(window).scroll(function(){
	    if ($(this).scrollTop() > 100) {
	        $('.yukari').fadeIn();
	    } else {
	        $('.yukari').fadeOut();
	    }
	});
	$('.yukari').click(function(){
	    $("html, body").animate({ scrollTop: 0 }, 600);
	    return false;
	}); 

	/* AJAX ile tüm formları göndermek
	 * 
	 * form elemanının class değeri "gnc_ajax_form" ise, form'un içindeki elemanların değerlerini serialize ederek form'un action ve method'una uygun olarak veriyi 
	 * işlemeyi sağlar. 
	 * 
	 * Önemli not: Şuan file upload'u desteklemiyor, HTML 5 ile artık yapılabilir, gelecekte bu özellik eklenecektir.
	 */
	$('.gnc_ajax_form').submit(function(){
		$('#loading').fadeIn();
        $.ajax({
            url     : $(this).attr('action'),
            type    : $(this).attr('method'),
            dataType: 'json',
            data    : $(this).serialize(),
            cache: false,
            success : function(data) {
            	//yenile();
  			}
        });
        if ($(this).attr('rel') == 'temizle')
        	$("form.gnc_ajax_form input:not([type='submit'], [type='reset'])").val('');
        $('#loading').fadeOut();
        return false;
    });
	/* AJAX ile açılan modal penceresi
	 * 
	 * Mantık olarak Kylefox tarafından yazılan plugin'inden esinlenilmiştir
	 * Ayrıntılı bilgi için https://github.com/kylefox/jquery-modal
	 *
	 * Açma tuşunun rel değeri neyse pencerenin içine ajax ile rel değerinden gelen veri döndürülür.
	 */
    $('.gnc-modal-acma-tusu').live("click",function (event) {
    	// Eğer ajaxta işlenecek birşey varsa bunu a'nın id değişkenine ata, bu değer ajax'ın data değerine gönderilecek
    	id = event.target.id;
    	// Tuşun rel değerini ajax'ın url değerine gönder
    	rel = event.target.rel;
    	// Tuşun title değeri pencerenin de title'ını oluşturur
    	title = $(this).attr('title');
		rev = event.target.rev;
		
		$('.gnc-modal-penceresi').dialog('option','title',title).dialog('open');
		var veri = {
    		id: id
  		}  
  		$('#loading').fadeIn();
  		$.ajax({
    		url: rel,            
			type: "POST",       
			data: veri,   
			cache: false,
			success: function (response) {
				$('#loading').fadeOut();
				$('#modal-penceresinin-icerigi').delay(1000).html(response);
				
				//$(".check, .check :checkbox, input:radio, input:file").uniform(); // Uniform olan yerler ikinci kez yüklemede saçmalamaktadır
				$(".select").chosen();	
				$(".ui-dialog").width(rev);	
			}
		});
        return false;
    });
    $('.gnc-modal-penceresi').dialog({
    	autoOpen: false, 
		width: modal_box_width,
		modal: true
	});

	/* Tablolar
	 * 
	 * Dinamik tablo yapısı, dil dosyası ile etkileşim içerisinde çalışmaktadır, global değişkenler önceden yaratılmıştır.
	 */
	oTable = $('.dinamik_tablo').dataTable({
		"bJQueryUI": false,
		"bAutoWidth": false,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"fl>t<"F"ip>',
		"sSearch" : 'sadasda',
		"oLanguage": {
			"sSearch": sSearch,
            "sLengthMenu": sLengthMenu,
            "sZeroRecords": "Nothing found - sorry",
            "sInfo": sInfo,
            "sInfoEmpty": "Showing 0 to 0 of 0 records",
            "sInfoFiltered": "(filtered from _MAX_ total records)",
            "oPaginate": {
		    	"sFirst": sFirst,
		    	"sLast": sLast,
		    	"sNext": sNext,
		    	"sPrevious": sPrevious
	    	}
        },
	});
});
/* Id'ye göre veri silme fonksiyonu
 * 
 * 3 adet parametre alır. Bunlar;
 * veri_id, ajax_fonk_adi, elemanin_idsi
 * 
 * Silinecek verinin id'si
 * İşlemi yapacak AJAX fonksiyonunun adı
 * İşlem sonucunda gizlenecek olan elemanın id ismi
 * 
 * Örnek kullanım
 * onClick="gnc_veri_sil('.$sonuc['kullanici_id'].', \'gnc_yonetim_kullanici_sil\', \'kullanici\');"
 * 
 * NOT: PHP içinde string değeri js fonksiyonuna gönderirken \' kullanmayı unutmayın!
 */
function gnc_veri_sil(veri_id, ajax_fonk_adi, elemanin_idsi){
	var veri = {
		veri_id: veri_id
	}	
	
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_adresi+ajax_fonk_adi,  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonun adı     
		type: "POST",       
		data: veri,   
		cache: false,
		success: function (response) {
			if (elemanin_idsi == 'yenile')
				yenile();
			else
				$('#'+elemanin_idsi+'_'+veri_id).slideUp();
				
			$('#loading').fadeOut();
		}
	});	
	return false;	
}
/* Id'si gelen degeri değiştir
 * 
 * 2 adet parametre alır. Bunlar;
 * veri_id, ajax_fonk_adi
 * 
 * Çağırılan fonksiyonda id değeri kullanılarak her hangi bir işlem yapılmasını sağlar
 */
function gnc_veri_isle(veri_id, ajax_fonk_adi){
	var veri = {
		veri_id: veri_id
	}
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_adresi+ajax_fonk_adi,  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonun adı     
		type: "POST",       
		data: veri,   
		cache: false,
		success: function (response) {
			$('#loading').fadeOut();
		}
	});	
	return false;		
}
/* Ajax ile dosya seçildiğinde oto upload işlemini sağlayan jquery kodu
 * 
 */
$(function() {	
	// Son yüklenen resmi göster
	function yuklenen_resmi_goster(source) {
  		var img  = document.createElement("img");
  		img.src = source;
		$('#image-list').html(img);
	}   
	
	// Ajax ile mi dosya yüklenecek elemanın id değerinden kontrol et
	if ($('#gnc_ajax_ile_dosya_yukle').length > 0)
	{
		var input = document.getElementById("gnc_ajax_ile_dosya_yukle"), 
					formdata = false;
		
		if (window.FormData) {
	  		formdata = new FormData();
	  	}
		
	 	input.addEventListener("change", function (evt) {
	 		$('#loading').fadeIn();
	 		var i = 0, len = this.files.length, img, reader, file;
		
			for ( ; i < len; i++ ) {
				file = this.files[i];
		
				
					if ( window.FileReader ) {
						reader = new FileReader();
						reader.onloadend = function (e) { 
							// Yüklenen resmi göster
							yuklenen_resmi_goster(e.target.result, file.fileName);
						};
						reader.readAsDataURL(file);
					}
					if (formdata) {
						formdata.append("images[]", file);
					}	
			}
			/* Varsayılan dosya yükleme fonksiyonu "gnc_dosya_yukle"dir. Farklı yükleme şekilleri için farklı fonksiyonlar çalıştırılabilir, 
			 * 
			 * Bunun için id'si "gnc_ajax_dosya_yukleme_fonksiyonu" olan bir elemana value değeri ajax.php dosyasındaki fonksiyonun ismi olarak belirtilmelidir.
			 */
			fonksiyon_adi = 'gnc_dosya_yukle';
			if ($('#gnc_ajax_ile_dosya_yukle_fonksiyon').length > 0)
				fonksiyon_adi = $('#gnc_ajax_ile_dosya_yukle_fonksiyon').val();
			
			if (formdata) {
				$.ajax({
					url: ajax_adresi+fonksiyon_adi,
					type: "POST",
					data: formdata,
					processData: false,
					contentType: false,
					success: function (res) {
						$('.dosya_yuklendi').slideDown();
						document.getElementById("response_2").innerHTML = res; 
						$('#loading').fadeOut();
					}
				});
			}
		}, false);
	}
	// Ajax ile mi dosya yüklenecek elemanın id değerinden kontrol et
	if ($('#gnc_ajax_ile_dosya_yukle_2').length > 0)
	{
		var input = document.getElementById("gnc_ajax_ile_dosya_yukle_2"), 
					formdata = false;
	
		if (window.FormData) {
	  		formdata = new FormData();
	  	}
		
	 	input.addEventListener("change", function (evt) {
	 		$('#loading').fadeIn();
	 		var i = 0, len = this.files.length, img, reader, file;
		
			for ( ; i < len; i++ ) {
				file = this.files[i];
		
				
					if ( window.FileReader ) {
						reader = new FileReader();
						reader.onloadend = function (e) { 
							// Yüklenen resmi göster
							yuklenen_resmi_goster(e.target.result, file.fileName);
						};
						reader.readAsDataURL(file);
					}
					if (formdata) {
						formdata.append("images_2[]", file);
					}	
			}
			/* Varsayılan dosya yükleme fonksiyonu "gnc_dosya_yukle"dir. Farklı yükleme şekilleri için farklı fonksiyonlar çalıştırılabilir, 
			 * 
			 * Bunun için id'si "gnc_ajax_dosya_yukleme_fonksiyonu" olan bir elemana value değeri ajax.php dosyasındaki fonksiyonun ismi olarak belirtilmelidir.
			 */
			fonksiyon_adi = 'gnc_dosya_yukle_2';
			if ($('#gnc_ajax_ile_dosya_yukle_fonksiyon_2').length > 0)
				fonksiyon_adi = $('#gnc_ajax_ile_dosya_yukle_fonksiyon_2').val();
			
			if (formdata) {
				$.ajax({
					url: ajax_adresi+fonksiyon_adi,
					type: "POST",
					data: formdata,
					processData: false,
					contentType: false,
					success: function (res) {
						$('.dosya_yuklendi').slideDown();
						document.getElementById("response").innerHTML = res; 
						$('#loading').fadeOut();
					}
				});
			}
		}, false);
	}
});
/* Yönetim sayfası
 * 
 * GNC'nin CMS'si içerisinde kullanılan JS fonksiyonları, sadece yönetim sayfasında kullanılmaktadır. 
 * Dolayısıyla sadaece yönetim sayfasının header'ından çağırılabilir. Ancak üst tarafta yer alan JS fonksiyonları 
 * her yerde kullanım alanı olan ve işleri kolaylaştıran JS fonksiyonlarıdır.
 */
// Yeni yönlendirici yarat
function gnc_yonetim_yeni_yonlendirici_ekle() {
	dosya = $('#yonlendirici_dosya_id').val();
	yonlendirici = $('#yonlendirici_yonlendirici_sef').val();
	dil    = $('#yonlendirici_dil_id').val();

	// Ajax'a gönderilecek hale getir
	var veri = {
		dosya: dosya,
		yonlendirici: yonlendirici,
		dil: dil
	}  
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_adresi+"gnc_yonetim_yonlendirici_yeni_yonlendirici_ekle",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
		type: "POST",       
		data: veri,   
		cache: false,
		success: function (response) {
			yenile(); // Sayfayı yenile
		}
	});	
}
function gnc_yonetim_yeni_album(){
	$('#gnc_yonetim_yeni_album').slideDown();	
}
function gnc_yonetim_yeni_album_gizle(){
	$('#gnc_yonetim_yeni_album').slideUp();
}
function gnc_yonetim_secili_albumu_goster(album_id){
	
	var veri = {
		album_id: album_id
	}  
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_adresi+"gnc_yonetim_album_detaylari",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
		type: "POST",       
		data: veri,   
		cache: false,
		success: function (response) {
			$('#gnc_yonetim_secili_album').html(response);
			$('#loading').fadeOut();
		}
	});	
	
}

$(function() {	
	// Arama
	$(".arama").keyup(function() 
	{
		aranan = $(this).val();
		var veri = {
			aranan: aranan
		}  	
		if(aranan == ''){
    		$(".arama_sonuclari").slideUp('fast'); 
		}
		else{  
    		$.ajax({
      			type: "POST",
  				url: ajax_adresi+"gnc_yonetim_arama_sonuclarini_goster",
  				data: veri,
				cache: false,
				success: function(html){
					$(".arama_sonuclari").html(html).slideDown('fast');
				}
			});
  		}
  		return false;    
	});
	/* Menuleri görüntüle
	 * 
	 */
	$('#gnc_yonetim_menu_secin').on("change", function (){
		// HTML'deki verileri JS'ye al
		menu_id = $('#gnc_yonetim_menu_secin').val();
		// Ajax'a gönderilecek hale getir
		var veri = {
    		menu_id: menu_id
  		}  	
  		$('#loading').fadeIn();
		$.ajax({
			url: ajax_adresi+"gnc_yonetim_ayarlar_menu_secimi",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
			type: "POST",       
			data: veri,   
			cache: false,
			success: function (response) {
				$('#gnc_yonetim_menu_dil_secildi').html(response);	 // Ajax'ın cevabını ekrana yazdır
				$(".select").chosen(); 										 // Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
				$('#loading').fadeOut();
				
				$('ol.sortable').nestedSortable({
					forcePlaceholderSize: true,
					handle: 'div',
					helper:	'clone',
					items: 'li',
					opacity: .6,
					placeholder: 'placeholder',
					revert: 250,
					tabSize: 25,
					tolerance: 'pointer',
					toleranceElement: '> div',
					maxLevels: 9,
			
					isTree: true,
					expandOnHover: 700,
					startCollapsed: true
				});
			
				$('.disclose').on('click', function() {
					$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
				})
			
				$('#serialize').click(function(){
					serialized = $('ol.sortable').nestedSortable('serialize');
					$('#serializeOutput').text(serialized+'\n\n');
					
					$('#loading').fadeIn();
					$.ajax({
						url: ajax_adresi+"gnc_yonetim_serialize_menu",
						type: "POST",       
						data: serialized,   
						cache: false,
						success: function (response) {
							//$('#serializeOutput').html(response);
							$('#loading').fadeOut();
							//window.location.replace("http://localhost/gnc/yonetim/dosya-yukle");
						}
					});	
				})
			
				$('#toHierarchy').click(function(e){
					hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
					hiered = dump(hiered);
					(typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
					$('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
				})
			
				$('#toArray').click(function(e){
					arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
					arraied = dump(arraied);
					(typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
					$('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
					alert(arraied);
				})
			
			}
		});	
	});
	/* Kategorileri görüntüle
	 *
	 */
	$('#gnc_yonetim_kategori_dil').on("change",function () {	
		// HTML'deki verileri JS'ye al
		secilen_dil = $('#gnc_yonetim_kategori_dil').val();
		// Ajax'a gönderilecek hale getir
		var veri = {
    		dil_id: secilen_dil
  		}  	
  		$('#loading').fadeIn();
		$.ajax({
			url: ajax_adresi+"gnc_yonetim_ayarlar_kategori_dil_secimi",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
			type: "POST",       
			data: veri,   
			cache: false,
			success: function (response) {
				$('#gnc_yonetim_kategori_dil_secildi').html(response);	 // Ajax'ın cevabını ekrana yazdır
				$(".select").chosen(); 										 // Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
				$('#loading').fadeOut();
				
				$('ol.sortable').nestedSortable({
					forcePlaceholderSize: true,
					handle: 'div',
					helper:	'clone',
					items: 'li',
					opacity: .6,
					placeholder: 'placeholder',
					revert: 250,
					tabSize: 25,
					tolerance: 'pointer',
					toleranceElement: '> div',
					maxLevels: 9,
			
					isTree: true,
					expandOnHover: 700,
					startCollapsed: true
				});
			
				$('.disclose').on('click', function() {
					$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
				})
			
				$('#serialize').click(function(){
					serialized = $('ol.sortable').nestedSortable('serialize');
					$('#serializeOutput').text(serialized+'\n\n');
					
					$('#loading').fadeIn();
					$.ajax({
						url: ajax_adresi+"gnc_yonetim_serialize_kategori",
						type: "POST",       
						data: serialized,   
						cache: false,
						success: function (response) {
							//$('#serializeOutput').html(response);
							$('#loading').fadeOut();
							//window.location.replace("http://localhost/gnc/yonetim/dosya-yukle");
						}
					});	
				})
			
				$('#toHierarchy').click(function(e){
					hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
					hiered = dump(hiered);
					(typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
					$('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
				})
			
				$('#toArray').click(function(e){
					arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
					arraied = dump(arraied);
					(typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
					$('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
					alert(arraied);
				})
			
			}
		});
	});
			
	/* Yeni kategori yarat
	 * 
	 * Yeni kategori yaratılırken dil seçimine uygun olarak, o dilde yaratılmış olan tüm kategorileri gösteren fonksiyon
	 */
	$('#gnc_yonetim_yeni_kategori_dil').on("change",function () {	
		// HTML'deki verileri JS'ye al
		secilen_dil = $('#gnc_yonetim_yeni_kategori_dil').val();
		// Ajax'a gönderilecek hale getir
		var veri = {
    		dil_id: secilen_dil
  		}  	
  		$('#loading').fadeIn();
		$.ajax({
			url: ajax_adresi+"gnc_yonetim_ayarlar_yeni_kategori_ekle_dil_secimi",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
			type: "POST",       
			data: veri,   
			cache: false,
			success: function (response) {
				$('#gnc_yonetim_yeni_kategori_ekle_dil_secildi').html(response);	// Ajax'ın cevabını ekrana yazdır
				$(".select").chosen(); 												// Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
				$('#loading').fadeOut();
			}
		});
	});

	/* Yeni içerik yarat
	 * 
	 * Yeni içerik girilirken dil seçimi yapıldığında bu dile ait kategori ve benzer içerik nesnelerini gösteren fonksiyon
	 */
	$('#gnc_yonetim_yeni_icerik_dil').live("change",function () {	
		// HTML'deki verileri JS'ye al
		secilen_dil = $('#gnc_yonetim_yeni_icerik_dil').val();
		// Ajax'a gönderilecek hale getir
		var veri = {
    		dil_id: secilen_dil
  		}  	
  		$('#loading').fadeIn();
		$.ajax({
			url: ajax_adresi+"gnc_yonetim_ayarlar_yeni_icerik_ekle_dil_secimi",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
			type: "POST",       
			data: veri,   
			cache: false,
			success: function (response) {
				$('#gnc_yonetim_yeni_icerik_ekle_dil_secildi').html(response);	// Ajax'ın cevabını ekrana yazdır
				$.configureBoxes();												// Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
				$(".select").chosen(); 
				$('#loading').fadeOut();
			}
		});
	});
	// Yeni içerik eklerken dil seçimi yapıldıktan sonra açılan şablon seçimi seçeneği yapıldıktan sonra açılacak şablon bölümü
	$('#gnc_yonetim_yeni_icerik_sablon').live("change",function () {	
		// HTML'deki verileri JS'ye al
		sablon_id = $('#gnc_yonetim_yeni_icerik_sablon').val();
		// Ajax'a gönderilecek hale getir
		var veri = {
    		sablon_id: sablon_id
  		}  	
  		$('#loading').fadeIn();
		$.ajax({
			url: ajax_adresi+"gnc_yonetim_ayarlar_yeni_icerik_ekle_sablon_secimi",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
			type: "POST",       
			data: veri,   
			cache: false,
			success: function (response) {
				$('#gnc_yonetim_yeni_icerik_ekle_sablon_secildi').html(response);	// Ajax'ın cevabını ekrana yazdır
				$('#loading').fadeOut();
			}
		});
	});
	// Yeni içeriği veritabanına kaydet
	$('#gnc_yonetim_yeni_icerik_ekle').on("click",function () {	
		// HTML'deki verileri JS'ye al
		baslik = $('#gnc_yonetim_yeni_icerik_baslik').val();
		icerik = CKEDITOR.instances['ckeditor'].getData();
		ozet   = $('#gnc_yonetim_yeni_icerik_ozet').val();
		yuklenen_resim_id = $('#yuklenen_resim_id').val();
		yuklenen_resim_id_2 = $('#yuklenen_resim_id_2').val();
		sira = $('#gnc_yonetim_yeni_icerik_sira').val();
		
		dil    = $('#gnc_yonetim_yeni_icerik_dil').val();
		kategori = $('#gnc_yonetim_yeni_icerik_kategori').val();
		//benzer_icerik = $('#box2View').val();
		benzer_icerik = []; 
		$('#box2View option').each(function(i, selected){ 
			benzer_icerik[i] = $(selected).val(); 
		}); 
		sablon_id = $('#gnc_yonetim_yeni_icerik_sablon').val();
		sablon_icerik_id = [];
		sablon_icerik = []; 
		$('.icerik_sablonu').each(function(i){ 
			sablon_icerik_id[i] = $(this).attr('id');
			sablon_icerik[i] = $(this).val(); 
		});
		lig = $('#gnc_yonetim_yeni_icerik_lig').val();
		sezon = $('#gnc_yonetim_yeni_icerik_sezon').val();
		hafta = $('#gnc_yonetim_yeni_icerik_hafta').val();

		// Ajax'a gönderilecek hale getir
		var veri = {
    		baslik: baslik,
    		icerik: icerik,
    		ozet: ozet,
    		yuklenen_resim_id: yuklenen_resim_id,
    		yuklenen_resim_id_2: yuklenen_resim_id_2,
    		sira: sira,
    		dil: dil,
    		kategori: kategori,
    		benzer_icerik: benzer_icerik,
    		sablon_id: sablon_id,
    		sablon_icerik_id: sablon_icerik_id,
    		sablon_icerik: sablon_icerik,
    		lig: lig,
    		sezon: sezon,
    		hafta: hafta   		
  		}  
  		$('#loading').fadeIn();
		$.ajax({
			url: ajax_adresi+"gnc_yonetim_yeni_icerik_ekle",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
			type: "POST",       
			data: veri,   
			cache: false,
			success: function (response) {
				yenile();											  // Gerekli ise ajax ile gelen verinin jquery ye gözükmesi için rebind et!
			}
		});
	});
	// Mevcut bir içeriği düzenle
	$('#gnc_yonetim_icerik_duzenle').on("click",function () {	
		// HTML'deki verileri JS'ye al
		id = $('#gnc_icerik_id').val();
		baslik = $('#gnc_icerik_baslik').val();
		icerik = CKEDITOR.instances['ckeditor'].getData();
		ozet   = $('#gnc_icerik_ozet').val();
		
		yuklenen_resim_buyuk = $('#gnc_ckfinder_ile_dosya_yukle').val();
		yuklenen_resim_kucuk = $('#gnc_ckfinder_ile_dosya_yukle_2').val();
		
    	yuklenen_resim_id = $('#yuklenen_resim_id').val();
		yuklenen_resim_id_2 = $('#yuklenen_resim_id_2').val();
		kategori = $('#gnc_yonetim_yeni_icerik_kategori').val();
		benzer_icerik = []; 
		$('#box2View option').each(function(i, selected){ 
			benzer_icerik[i] = $(selected).val(); 
		}); 
		sablon_icerik_id = [];
		sablon_icerik = []; 
		$('.icerik_sablonu').each(function(i){ 
			sablon_icerik_id[i] = $(this).attr('id');
			sablon_icerik[i] = $(this).val(); 
		});
		
		// Ajax'a gönderilecek hale getir
		var veri = {
			id: id,
    		baslik: baslik,
    		icerik: icerik,
    		ozet: ozet,
    		yuklenen_resim_buyuk: yuklenen_resim_buyuk,
	    	yuklenen_resim_kucuk: yuklenen_resim_kucuk,
    		yuklenen_resim_id: yuklenen_resim_id,
    		yuklenen_resim_id_2: yuklenen_resim_id_2,
    		kategori: kategori,
    		benzer_icerik: benzer_icerik,
    		sablon_icerik_id: sablon_icerik_id,
    		sablon_icerik: sablon_icerik
  		}  
  		$('#loading').fadeIn();
		$.ajax({
			url: ajax_adresi+"gnc_yonetim_icerik_duzenle",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
			type: "POST",       
			data: veri,   
			cache: false,
			success: function (response) {
				yenile();											  // Gerekli ise ajax ile gelen verinin jquery ye gözükmesi için rebind et!
			}
		});
	});
	// Yeni şablon için yeni alan yarat
	var addDiv = $('#sablon_alanlari');
	var i = $('#sablon_alanlari p').size() + 1;
	// Alan ekle	
	$('.sablona_yeni_alan_ekle').live('click', function() {
		if( i < 10 ) {
			i++;
			alan_adi 		= $('.alan_adi').html();
			alan_aciklamasi = $('.sablon_alan_aciklama').attr('placeholder');
			yeni_alan_ekle 	= $('.sablona_yeni_alan_ekle').html();
			yeni_alan_sil  	= $('.sablona_yeni_alan_sil').html();
			$('<div class="formRow"><div class="grid2"><label>'+alan_adi+'</label></div><div class="grid2"><input type="text" id="gnc_yonetim_yeni_sablon_alani" name="gnc_yonetim_yeni_sablon_alani_'+i+'" placeholder="'+alan_adi+'" /></div><div class="grid6"><input type="text" id="sablon_alani" name="gnc_yonetim_yeni_sablon_aciklama_'+i+'" placeholder="'+alan_aciklamasi+'"/></div><div class="grid2"><div class=""><a class="sablona_yeni_alan_ekle buttonS bGreen first" title="" href="javascript:void(0)">'+yeni_alan_ekle+'</a>&nbsp<a class="sablona_yeni_alan_sil buttonS bRed first" title="" href="javascript:void(0)">'+yeni_alan_sil+'</a></div></div><div class="clear"></div></div>').appendTo(addDiv);
			
		}
		return false;
	});
	// Ekli alanı sil
	$('.sablona_yeni_alan_sil').live('click', function() {

		if( i > 1 ) {
			$(this).parents('.formRow').remove();
			i--;
		}
		return false;
	});	
	// Dosya yükleme sırasında dosya tipine uygun olarak açılacak olan formu belirtir
	$('#dosya_tipi').on("change",function () {	
		tip = $('#dosya_tipi').val();
		if (tip > 10){
			$('.dosya_tipi_normal').slideUp();	
			$('.dosya_tipi_harici').slideDown();
		}
		else{
			$('.dosya_tipi_harici').slideUp();
			$('.dosya_tipi_normal').slideDown();		
		}			
	});
	/* JCrop eklentisi ile resim kırpma işlemi
	 * 
	 * Albüme eklenecek resmi, kırpma penceresinin içerisinde görüntüleyerek albüm standartlarına uygun olarak resmi kırpma işlemi
	 * Kelly Hallman tarafından yapılmış olup eklenti hakkında detaylı bilgi için http://deepliquid.com/content/Jcrop.html adresini ziyaret edebilirisniz.
	 * 
	 * Resim yükleme işleminden sonra resmin orjinali görüntülenerek resim kırpma işlemini albümde belirtilen standarta uygun olarak yapmayı sağlar.
	 * Site içerisinde sağı solu kaymış resimlerin oluşmaması için mutlaka kullanılmalıdır.
	 */
	$('#album_secimi').live("change",function () {
		$('.resim_kirpma_islemi').slideDown();
		
		crop = $('#album_secimi').val();
		crop_deger = crop.split("-");
				
		var crop_deger = crop.split("-");
		
		album_id = crop_deger[0];
		crop_x = crop_deger[1];
		crop_y = crop_deger[2];
		
     	$('#cropbox').Jcrop({
			onChange: showCoords,
			onSelect: showCoords,
			minSize: [ crop_x, crop_y ],
			maxSize: [ crop_x, crop_y ]
		});	
		
	})
});
function showCoords(c)
{
	$('#x').val(c.x);
	$('#y').val(c.y);
	$('#x2').val(c.x2);
	$('#y2').val(c.y2);
	$('#w').val(c.w);
	$('#h').val(c.h);
};
function resim_kirp(){
	crop = $('#cropbox').attr('src');
	x1 = $('#x').val();
	y1 = $('#y').val();
	x2 = $('#x2').val();
	y2 = $('#y2').val();
	w  = $('#w').val();
	h  = $('#h').val();
	
	album_degeri = $('#album_secimi').val();
	album_degerleri = album_degeri.split("-");
	album_id = album_degerleri[0];
	resim_aciklama = $('#gnc_yonetim_resim_aciklama').val();
	var veri = {
		album_id: album_id,
		crop: crop,
		x1: x1,
		y1: y1,
		x2: x2,
		y2: y2,
		w: w,
		h: h,
		resim_aciklama: resim_aciklama
	}  

	$.ajax({
		url: ajax_adresi+"gnc_yonetim_resim_kirp",
		type: "POST",       
		data: veri,   
		cache: false,
		success: function (response) {
			$('#sonuc').html(response);
			//window.location.replace("http://localhost/gnc/yonetim/dosya-yukle");
		}
	});	
}
/* Menü, kategori gibi sıralama ve yapılandırma için çalışan nestedSortable isimli eklenti
 * 
 * Detaylı bilgi için aşağıdaki adreslere bakabilirsiniz; 
 * http://mjsarfatti.com/sandbox/nestedSortable 
 * https://github.com/mjsarfatti/nestedSortable
 */
$(document).ready(function(){

	$('ol.sortable').nestedSortable({
		forcePlaceholderSize: true,
		handle: 'div',
		helper:	'clone',
		items: 'li',
		opacity: .6,
		placeholder: 'placeholder',
		revert: 250,
		tabSize: 25,
		tolerance: 'pointer',
		toleranceElement: '> div',
		maxLevels: 9,

		isTree: true,
		expandOnHover: 700,
		startCollapsed: true
	});

	$('.disclose').on('click', function() {
		$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
	})

	$('#serialize').click(function(){
		serialized = $('ol.sortable').nestedSortable('serialize');
		$('#serializeOutput').text(serialized+'\n\n');
	})

	$('#toHierarchy').click(function(e){
		hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
		hiered = dump(hiered);
		(typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
		$('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
	})

	$('#toArray').click(function(e){
		arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
		arraied = dump(arraied);
		(typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
		$('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
	})

});

function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;

	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Strings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
		
	return dumped_text;
}
