<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function pdf(Invoice $invoice)
    {
        $invoice->load('invoice_details.service');
        $page_title = 'MD Invoice No. ' . $invoice->id;
        $file_name = $page_title . '.pdf';
        $mpdf = new \Mpdf\Mpdf([
            // 'pagenumPrefix' => 'Page number ',
            // 'pagenumSuffix' => ' - ',
            // 'nbpgPrefix' => ' of ',
            // 'nbpgSuffix' => ' pages',
            // 'margin_top' => 25,
            // 'margin_bottom' => 15,
        ]);

        // $mpdf->showImageErrors = true;
        
        $body = view('pages.invoices.pdf', compact('invoice', 'page_title'));
        $footer = view('pages.invoices.footer');
        $mpdf->SetHTMLFooter($footer);

        // ini_set("pcre.backtrack_limit", "5000000");
        $mpdf->WriteHTML($body); //should be before output directly
        $mpdf->Output($file_name, 'D'); 
        // 'D': download the PDF file
        // 'I': serves in-line to the browser
        // 'S': returns the PDF document as a string
        // 'F': save as file $file_out
    }
}
