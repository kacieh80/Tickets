<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('class.TicketAdminPage.php');
require_once('class.FlipsideTicketDB.php');
$page = new TicketAdminPage('Burning Flipside - Tickets');

$page->add_js(JS_DATATABLE);
$page->add_css(CSS_DATATABLE);
$page->add_js_from_src('js/sold_tickets.js');

$page->body .= '
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sold Tickets</h1>
            </div>
        </div>
        <div class="row">
            <table class="table" id="tickets">
                <thead>
                    <tr>
                        <th>Short Code</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
';

$page->print_page();
// vim: set tabstop=4 shiftwidth=4 expandtab:
?>

