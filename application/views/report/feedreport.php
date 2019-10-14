<style type="text/css">
    .btn-group>.btn:first-child {
        margin-left: 0;
        margin-top: 0px;
    }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Product Group Report
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('report/feedreport'); ?>">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5" style="padding-left: 0">
                                        <div class="input-group input-sm" >
                                            <span class="input-group-addon">From </span>
                                            <div class="iconic-input right">
                                                <i class="fa fa-calendar"></i>
                                                <input type="text" id="datetimepickerfrom" class="form-control" name="date_from"
                                                       value="<?php echo $date_from; ?>">
                                            </div>
                                            <span class="input-group-addon">To</span>
                                            <div class="iconic-input right">
                                                <i class="fa fa-calendar"></i>
                                                <input type="text" id="datetimepickerto" class="form-control" name="date_to" 
                                                       value="<?php echo $date_to; ?>">
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-md-3 myselect" style="padding-top: 5px;">
                                        <select id="productgroupname" name="productgroupname" onchange="getManufacturerName()" class="form-control m-bot15 selectpicker" data-live-search="true">
                                            <option value="">-- Select Product Group Name --</option>
                                            <?php
                                            if (sizeof($getProductGroupData) > 0):
                                                foreach ($getProductGroupData as $row):
                                                    if ($idSelectProductGroup == $row->productGroupId):
                                                        ?>                                                                                                      
                                                        <option value="<?php echo $row->productGroupId; ?>"selected="selected" ><?php echo $row->productGroupName; ?></option>
                                                        <?php
                                                    elseif ($idSelectProductGroup != $row->productGroupId):
                                                        ?>
                                                        <option value="<?php echo $row->productGroupId; ?>" ><?php echo $row->productGroupName; ?></option>
                                                        <?php
                                                    else:
                                                        ?>
                                                        <option value="<?php echo $row->productGroupId; ?>" ><?php echo 'All Data' ?></option>
                                                    <?php
                                                    endif;
                                                endforeach;
                                            endif;
                                            ?>

                                        </select>
                                    </div>

                                    <div class="col-md-3 myselect" style="padding-top: 5px;">
                                        <select id="manufacturename" name="manufacturename"  class="form-control m-bot15" data-live-search="true">
                                            <option value="">-- Select Manufacturer Name --</option>
                                            <?php
                                            if (sizeof($getManufactureData) > 0):
                                                foreach ($getManufactureData as $row):
                                                    if ($selectedId == $row->manufactureId):
                                                        ?>                                                                                                      
                                                        <option value="<?php echo $row->manufactureId; ?>"selected="selected" ><?php echo $row->manufactureName; ?></option>
                                                        <?php
                                                    elseif ($selectedId != $row->manufactureId):
                                                        ?>
                                                        <option value="<?php echo $row->manufactureId; ?>" ><?php echo $row->manufactureName; ?></option>
                                                        <?php
                                                    else:
                                                        ?>
                                                        <option value="<?php echo $row->manufactureId; ?>" ><?php echo 'All  Data' ?></option>
                                                    <?php
                                                    endif;
                                                endforeach;
                                            endif;
                                            ?>

                                        </select>
                                    </div> 
                                </div>
                                <div class="row">

                                    <div class="col-md-3">   

                                    </div>

                                    <div class="col-md-2" style="padding-top: 10px;">
                                        <label>
                                            <?php
                                            if ($selectedIdCheck == ""):
                                                ?>
                                                <input type="radio" checked="true" onclick="togglebankdiv()"  value="customer" id="customer" name="feed_report_radio">
                                                Customer 
                                                <?php
                                            elseif ($selectedIdCheck == "customer"):
                                                ?>
                                                <input type="radio" checked="true" onclick="togglebankdiv()"  value="customer" id="customer" name="feed_report_radio">
                                                Customer
                                                <?php
                                            else:
                                                ?>
                                                <input type="radio"  onclick="togglebankdiv()"  value="customer" id="customer" name="feed_report_radio">
                                                Customer 
                                            <?php
                                            endif
                                            ?>
                                        </label>
                                        <label>
                                            <?php
                                            if ($selectedIdCheck == "supplier"):
                                                ?>
                                                <input type="radio" checked="true"  value="supplier" onclick="togglebankdiv()"  id="supplier" name="feed_report_radio">
                                                Supplier
                                                <?php
                                            else :
                                                ?>
                                                <input type="radio"   value="supplier" onclick="togglebankdiv()"  id="supplier" name="feed_report_radio">
                                                Supplier
                                            <?php
                                            endif
                                            ?>
                                        </label>
                                    </div>
                                    <div id="customerDiv" class="col-md-3 myselect" style="padding-top: 5px;">
                                        <select name="customername"  id="customername"  class="form-control m-bot15 selectpicker" data-live-search="true">
                                            <option value="">-- Select Customer Name --</option>
                                            <?php
                                            if (sizeof($getCustomer) > 0):
                                                foreach ($getCustomer as $row):
                                                    if ($idSelectCustomer == $row->ledgerId):
                                                        ?>                                                                                                      
                                                        <option value="<?php echo $row->ledgerId; ?>"selected="selected" ><?php echo $row->acccountLedgerName; ?></option>
                                                        <?php
                                                    elseif ($idSelectCustomer != $row->ledgerId):
                                                        ?>
                                                        <option value="<?php echo $row->ledgerId; ?>" ><?php echo $row->acccountLedgerName; ?></option>
                                                        <?php
                                                    else:
                                                        ?>
                                                        <option value="<?php echo $row->ledgerId; ?>" ><?php echo 'All  Data' ?></option>
                                                    <?php
                                                    endif;
                                                endforeach;
                                            endif;
                                            ?>

                                        </select>
                                    </div> 

                                    <div  id="supplierDiv" class="col-md-3 myselect" style="padding-top: 5px;">
                                        <select name="suppliername" id="suppliername"  class="form-control m-bot15 selectpicker" data-live-search="true">
                                            <option value="">-- Select Supplier Name --</option>
                                            <?php
                                            if (sizeof($getSupplier) > 0):
                                                foreach ($getSupplier as $row):
                                                    if ($idSelectSupplier == $row->ledgerId):
                                                        ?>                                                                                                      
                                                        <option value="<?php echo $row->ledgerId; ?>"selected="selected" ><?php echo $row->acccountLedgerName; ?></option>
                                                        <?php
                                                    elseif ($idSelectSupplier != $row->ledgerId):
                                                        ?>
                                                        <option value="<?php echo $row->ledgerId; ?>" ><?php echo $row->acccountLedgerName; ?></option>
                                                        <?php
                                                    else:
                                                        ?>
                                                        <option value="<?php echo $row->ledgerId; ?>" ><?php echo 'All  Data' ?></option>
                                                    <?php
                                                    endif;
                                                endforeach;
                                            endif;
                                            ?>

                                        </select>
                                    </div> 

                                    <div class="col-md-2" style="padding-top: 8px;">   
                                        <label>
                                            <button class="btn btn-info" type="submit">Submit</button>
                                        </label>   
                                    </div>
                                    <div class="col-md-2" style="padding-top: 8px;">   
                                        <div class="btn-group pull-right">
                                            <button class="btn dropdown-toggle" data-toggle="dropdown">Export <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="#" id="btnExport"> Save as CSV</a></li>
                                                <li><a href="#" onclick="generatePdf()" >Save as PDF</a></li>
                                                <li><a href="#" onclick="Clickheretoprint()">Print Report</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </form>       
                    </div>
                    <div>
                        <table  class="display table table-bordered table-striped" id="editable-sample">
                            <thead>
                                <tr>
                                    <th style="width:20%">Sl No</th>
                                    <th style="width:20%">Products</th>
                                    <th style="width:20%">Unit</th>
                                    <th style="width:20%">Qty</th>
                                        <?php
                                        if ($productGroupIdCol == 3):
                                            echo '<th style="width:20%">Ton</th>';
                                        endif;
                                        ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $company_data = $this->session->userdata('logindata');
                                $company_id = $company_data['companyid'];
                                 $tonSum = 0;
                                if (sizeof($getProductData) > 0):     
                                    foreach ($getProductData as $value):
                                        $productid = $value->productId;
                                        $productname = $value->productName;
                                        $qty = $value->qty;
                                        $unitid = $value->unitId;

                                        $getUnitName = $this->db->query("SELECT unitName FROM unit WHERE unitId = '$unitid' AND companyId = '$company_id'");
                                        if ($getUnitName->num_rows() > 0):
                                            $unitName = $getUnitName->row()->unitName;
                                        else:
                                            $unitName = "not found";
                                        endif;

                                        if ($string = explode('K', $unitName)):
                                            $unitValue = trim($string[0]);
                                            $float_value_of_var = floatval($unitValue);
                                            $ton = ($float_value_of_var * $qty) / 1000;
                                        elseif ($string = explode('k', $unitName)):
                                            $unitValue = trim($string[0]);
                                            $float_value_of_var = floatval($unitValue);
                                            $ton = ($float_value_of_var * $qty) / 1000;
                                        else:
                                            $ton = 0;
                                        endif;
                                        $tonSum += $ton;

                                        if ($productGroupIdCol == 3):
                                            echo '<tr><td>' . $i++ . '</td><td>' . $productname . '</td><td>' . $unitName . '</td><td>' . floor($qty) == $qty? number_format($qty): number_format($qty, 3). '</td><td>' . $ton . '</td></tr>';
                                        else :
                                            echo '<tr><td>' . $i++ . '</td><td>' . $productname . '</td><td>' . $unitName . '</td><td>' . floor($qty) == $qty? number_format($qty): number_format($qty, 3) . '</td></tr>';
                                        endif;
                                    endforeach;
                                endif;

                                if ($productGroupIdCol == 3):
                                    echo '<tr><td>' . " " . '</td><td>' . " " . '</td><td>' . " " . '</td><td>' . "Total" . '</td><td>' . $tonSum. '</td></tr>';
                                endif;
                                ?>

                            </tbody>
                        </table> 
                    </div>
                </div>
            </div> 
        </section>
    </section>
</section>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        //  var x = document.getElementById("customer").checked = true;
        $("#supplierDiv").hide();
        $("#customerDiv").hide();
        var selected_val = document.querySelector('input[name="feed_report_radio"]:checked').value;
        if (selected_val == "customer") {
            $("#supplierDiv").hide();
            $("#customerDiv").show();
        } else {
            $("#supplierDiv").show();
            $("#customerDiv").hide();
        }

//        $('#editable-sample').dataTable({
//            "sPaginationType": "full_numbers",
//            'iDisplayLength': 50
//        });
    });

    function getManufacturerName() {
        var productGroupId = $("#productgroupname").val();


        $.ajax({
            type: "POST",
            url: "<?php echo site_url('report/feedreport/getManufacturerName'); ?>",
            data: 'productGroupId=' + productGroupId,
            success: function (data) {
                console.log(data);
                document.getElementById("manufacturename").innerHTML = data;
            }
        });

    }



</script>
