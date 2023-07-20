<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\UltraMsg\WhatsAppApi;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function pdf(Invoice $invoice)
    {
        $invoice->load('invoice_details.service');
        $page_title = 'MD Invoice No.' . $invoice->id;
        $file_name = $page_title . '.pdf';
        $mpdf = new \Mpdf\Mpdf();
        $body = view('pages.invoices.pdf', compact('invoice', 'page_title'));
        $footer = view('pages.invoices.footer');
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($body); //should be before output directly
        $mpdf->Output($file_name, 'I');
    }
    public function detailed_pdf(Invoice $invoice)
    {
        $invoice->load('invoice_details.service');
        $page_title = 'MD Detailed Invoice No.' . $invoice->id;
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

        $body = view('pages.invoices.detailed_pdf', compact('invoice', 'page_title'));
        $footer = view('pages.invoices.footer');
        $mpdf->SetHTMLFooter($footer);

        // ini_set("pcre.backtrack_limit", "5000000");
        $mpdf->WriteHTML($body); //should be before output directly
        $mpdf->Output($file_name, 'I');
        // $mpdf->Output(storage_path('app/public/invoices/' . $file_name), 'F'); //use this when send to whatsapp
        // 'D': download the PDF file
        // 'I': serves in-line to the browser
        // 'S': returns the PDF document as a string
        // 'F': save as file $file_out

        // $ultramsg_token = "h0721ef250tbrafm"; // Ultramsg.com token
        // $instance_id = "instance54424"; // Ultramsg.com instance id
        // $client = new WhatsAppApi($ultramsg_token, $instance_id);
        // $to = "+96599589018";
        // $filename = $file_name;
        // $document = asset('storage/invoices/'.$file_name); 
        // $api = $client->sendDocumentMessage($to, $filename, $document);
        // print_r($api);
    }
}
