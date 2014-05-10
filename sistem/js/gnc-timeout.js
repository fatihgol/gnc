/* Oturum zaman aşımına uğradığında açılacak uyarı mesajı
 * 
 * http://jsbin.com/uxoya adresinden alınmıştır.
 */
idleTimer = null;
idleState = false;
(function ($) {
    $(document).ready(function () {
    	
        $('*').bind('mousemove keydown scroll', function () {
            clearTimeout(idleTimer);

            idleState = false;
            idleTimer = setTimeout(function () { 
                $('#gnc-modal-oturum-suresi-doldu').dialog({ 
                	title: oturum_sureniz_doldu, 
                	height: 400, width: 400, 
                	close: function( event, ui ) {
                		yenile(); // Modal penceresi kapatıldığı zaman sayfayı yenile, oturum süresi dolmuşsa zaten site gerekli yönlendirmeyi yapacaktır.
                	} 
                });
                idleState = true; }, oturum_omru*1000);
        });
        $("body").trigger("mousemove");
    });
}) (jQuery)