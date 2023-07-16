<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

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
        // $attachment = $mpdf->Output($file_name, 'F');
        // 'D': download the PDF file
        // 'I': serves in-line to the browser
        // 'S': returns the PDF document as a string
        // 'F': save as file $file_out




        $params = array(
            'token' => 'h0721ef250tbrafm',
            'to' => '%2B96599589018',
            'filename' => 'hello.pdf',
            'document' => 'https://file-example.s3-accelerate.amazonaws.com/documents/cv.pdf',
            'caption' => 'document caption'
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance54424/messages/document",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
