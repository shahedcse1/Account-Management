<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
<!--main content start-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Day Book Information
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <!--                            <div class="btn-group pull-right">-->
                        <!--                                <button  class="btn btn-info" data-toggle="modal" data-target="#myModal">-->
                        <!--                                    Add New <i class="fa fa-plus"></i>-->
                        <!--                                </button>-->
                        <!--                            </div>-->
                        <form class="tasi-form" action="#">
                            <div class="form-group">
                                <div class="col-md-3" style="padding-left: 0">
                                    <div class="input-group input-sm" data-date="13/07/2013" data-date-format="mm/dd/yyyy" style="padding-left: 0">
                                        <span class="input-group-addon"> Date</span>
                                        <div class="iconic-input right">
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date_from"
                                                   placeholder="From Date"
                                                   value="01 Jan 2014">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-2">
                                    <div class="input-group input-sm" style="padding-left: 10px">
                                        <span class="input-group-addon">Search By</span>
                                        <div class="iconic-input right">
                                            <select class="form-control" style="color: #555;">
                                                <option>Account Ledger</option>
                                                <option>All</option>
                                            </select>
                                        </div>
                                        <span class="input-group-addon">Search By</span>

                                        <div class="iconic-input right">
                                            <select class="form-control" style="color: #555;">
                                                <option>Voucher Type</option>
                                                <option>All</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>
                                        <button class="btn btn-info" type="submit">Submit</button>
                                    </label>  
                                    <div class="btn-group pull-right">                             
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">Export <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="#"> Save as CSV</a></li>
                                            <li><a href="#">Save as PDF</a></li>
                                            <li><a href="#">Print Report</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form>                        
                    </div>
                    <br/>

                    <div class="space15"></div>

                    <table  class="table table-striped table-hover table-bordered tab-pane active editable-sample1" id="editable-sample">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Voucher Type</th>
                                <th>Voucher No</th>
                                <th>Account Ledger</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="center"></td>
                                <td class="center"></td>
                            </tr>
                            <tr class="">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="center" ></td>
                                <td class="center" ></td>
                            </tr>
                            <tr class="">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="center"></td>
                                <td class="center"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="form">
                    <form class="cmxform form-horizontal tasi-form" id="signupForm" method="get" action="">
                        <div class="form-group ">
                            <label for="supplier_name" class="control-label col-lg-3">Supplier Name</label>
                            <div class="col-lg-8">
                                <input class=" form-control" id="supplier_name" name="supplier_name" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="address" class="control-label col-lg-3">Address</label>
                            <div class="col-lg-8">
                                <input class=" form-control" id="address" name="address" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="phone" class="control-label col-lg-3">Phone</label>
                            <div class="col-lg-8">
                                <input class="form-control " id="phone" name="phone" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="mobile" class="control-label col-lg-3">Mobile</label>
                            <div class="col-lg-8">
                                <input class="form-control " id="mobile" name="mobile" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="fax" class="control-label col-lg-3">Fax</label>
                            <div class="col-lg-8">
                                <input class="form-control " id="fax" name="fax" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="email" class="control-label col-lg-3">Email</label>
                            <div class="col-lg-8">
                                <input class="form-control " id="email" name="email" type="email" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="opening_balance" class="control-label col-lg-3 col-sm-3">Opening Balance</label>
                            <div class="col-lg-8 col-sm-8">
                                <input  class="form-control "  type="text" id="opening_balance" name="opening_balance" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="dr_cr" class="control-label col-lg-3 col-sm-3">[Dr] / [Cr]</label>
                            <div class="col-lg-8 col-sm-8">
                                <input   class="form-control "  type="text" id="dr_cr" name="dr_cr" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="description" class="control-label col-lg-3 col-sm-3">Description</label>
                            <div class="col-lg-8 col-sm-8">
                                <input   class="form-control "  type="text" id="description" name="description" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>