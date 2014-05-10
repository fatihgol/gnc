<?php
 
// wsdl cache 'ini devre disi birak
ini_set("soap.wsdl_cache_enabled", "0");
 
try {
 
  // SOAPClient nesnesi olustur
  $client = new SoapClient("http://bma-sbsoft-02.ble.local:4410/SportsbookPartnerServicesExternal/PartnerServicesV2.svc?wsdl");
 
  // SOAPClient uzerinden karsi sunucudaki getAllNotebooks metodunu cagir
  $notebooks = $client->getAllNotebooks();
 
  echo "Metod basarili bir sekilde calistirildi.<br/>Sonuc asagidadir.<br/>";
 
  echo  "<pre>";
  // Sonucu ekrana bas
  var_dump($notebooks);
  echo  "</pre>";
} catch (Exception $exc) { // Hata olusursa yakala
  echo "Soap Hatasi Olustu: " . $exc->getMessage();
}

