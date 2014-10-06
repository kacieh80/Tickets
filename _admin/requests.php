<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('class.TicketAdminPage.php');
require_once('class.FlipsideTicketDB.php');
$page = new TicketAdminPage('Burning Flipside - Tickets');

$script_start_tag = $page->create_open_tag('script', array('src'=>'/js/jquery.dataTables.js'));
$script_close_tag = $page->create_close_tag('script');
$page->add_head_tag($script_start_tag.$script_close_tag);

$script_start_tag = $page->create_open_tag('script', array('src'=>'js/requests.js'));
$page->add_head_tag($script_start_tag.$script_close_tag);

$css_tag = $page->create_open_tag('link', array('rel'=>'stylesheet', 'href'=>'/css/jquery.dataTables.css', 'type'=>'text/css'), true);
$page->add_head_tag($css_tag);

$db = new FlipsideTicketDB();
$years = $db->getAllYears();

$options = '';
for($i = 0; $i < count($years); $i++)
{
    if($years[$i] == FlipsideTicketDB::getTicketYear())
    {
        $options .= '<option value="'.$years[$i].'" selected>'.$years[$i].'</option>';
    }
    else
    {
        $options .= '<option value="'.$years[$i].'">'.$years[$i].'</option>';
    }
}

    $page->body .= '
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Ticket Requests</h1>
            </div>
        </div>
        <div class="row">
            Request Year: <select id="year" onchange="change_year(this)">
            '.$options.'
            </select>
            <table class="table" id="requests">
                <thead>
                    <th></th>
                    <th>Request ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Number of Tickets</th>
                    <th>Total Due</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal fade in" aria-hidden="false" id="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="modal_title"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="request_edit_form">
                            <div class="form-group">
                                <label for="request_id" class="col-sm-2 control-label">Request ID:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="request_id" id="request_id" readonly value="114558">
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="givenName" class="col-sm-2 control-label">First Name:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="givenName" name="givenName" type="text">
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="sn" class="col-sm-2 control-label">Last Name:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="sn" name="sn" type="text">
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="mail" class="col-sm-2 control-label">Email:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="mail" id="mail">
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="c" class="col-sm-2 control-label">Country:</label>
                                <div class="col-sm-10">
                                    <select class="form-control bfh-countries" id="c" name="c" data-country="US"></select>
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="mobile" class="col-sm-2 control-label">Cell Number:</label>
                                <div class="col-sm-10">
                                    <input id="mobile" name="mobile" type="text" class="form-control bfh-phone" data-country="c">
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="street" class="col-sm-2 control-label">Street Address:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="street" name="street" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="zip" class="col-sm-2 control-label">Postal/Zip Code:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="zip" name="zip" type="text">
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="l" class="col-sm-2 control-label">City:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="l" name="l" type="text" value="AUSTIN">
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="st" class="col-sm-2 control-label">State:</label>
                                <div class="col-sm-10">
                                    <select class="form-control bfh-states" data-country="c" id="st" name="st" type="text"></select>
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <table id="ticket_table" class="table">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Age</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <table id="donation_table" class="table">
                                <thead>
                                    <tr>
                                        <th>Entity</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="critvol" class="col-sm-2 control-label">Critical Volunteer:</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="critvol" name="critvol"></input>
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                            <div class="form-group">
                                <label for="protected" class="col-sm-2 control-label">Protected:</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="protected" name="protected"></input>
                                </div>
                            </div>
                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                       </form>
                  </div>
                  <div class="modal-footer"><button type="button" class="btn btn-default" onclick="save_request(this)">Ok</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></div></div></div></div>
    </div>
</div>
';

$page->print_page();
// vim: set tabstop=4 shiftwidth=4 expandtab:
?>
