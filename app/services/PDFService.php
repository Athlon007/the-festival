<?php

class PDFService{

    public function generatePDF($html, $title, $filename){
      
        $dompdf = new Dompdf\Dompdf([
          "chroot" => __DIR__,
          "isRemoteEnabled" => true,
          "isHtml5ParserEnabled" => true,
          "isPhpEnabled" => true,
          "isJavascriptEnabled" => true,
          "isFontSubsettingEnabled" => true,
          "isImageSubsettingEnabled" => true,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->addInfo('Title', $title);
        $dompdf->stream($filename, array("Attachment" => false));

        return $dompdf;
    }
}
?>