<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('class.TicketAdminPage.php');
require_once('class.FlipsideTicketRequestPDF.php');
$page = new TicketAdminPage('Burning Flipside - Tickets');

$page->add_js_from_src('//cdn.ckeditor.com/4.4.5/full/ckeditor.js');
$page->add_js_from_src('//cdn.ckeditor.com/4.4.5/full/adapters/jquery.js');
$page->add_js_from_src('js/pdf.js');

$pdf = new FlipsideTicketRequestPDF(FALSE);

    $page->body .= '
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Request PDF</h1>
    </div>
</div>
<div class="row">
    <textarea id="pdf-source" style="width: 100%">'.$pdf->source.'</textarea>
</div>
<div class="row">
    <button onclick="gen_preview()">Preview</button><button onclick="save()">Save</button>
</div>
<div class="row">
    {$ticket_count}    => The number of tickets in the request<br/>
    {$barcode}         => The barcode<br/>
    {$year}            => The request year<br/>
    {$request_id}      => The request id<br/>
    {$total_due}       => The total amount due<br/>
    {$open_date}       => The starting date of the ticket window<br/>
    {$close_date}      => The ending date of the ticket window<br/>
    {$address}         => The mailing address<br/>
    {$ticket_table}    => A table of all the tickets in the request<br/>
    {$donation_table}  => A table of all the donations in the request<br/>
    {$requestor}       => The requestor\'s full name<br/>
    {$email}           => The requestor\'s email<br/>
    {$phone}           => The requestor\'s phone number<br/>
    {$request_date}
</div>
';

$page->print_page();
// vim: set tabstop=4 shiftwidth=4 expandtab:
?>

