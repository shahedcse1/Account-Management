

<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->       
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        System Settings
                    </header>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('settings/system/update_system') ?>">
                            <div class="col-lg-6" style="padding-left: 35px;">                                
                                <div class="form-group">

                                </div>
                                <?php
                                $arr = array();
                                foreach ($settings as $key => $value) :
                                    $arr[$key] = $value->value;
                                endforeach;
                                ?>

                                <div class="form-group">
                                    <label for="paidto" class="col-lg-6  control-label " style="text-align: left">1. Allow Maximum Sales Discount :</label>
                                    <div class="col-lg-2">
                                        <input type="text"  class="form-control" id="1" name="1" value="<?php echo  $arr[0]; ?>" />  
                                    </div>  
                                     <label for="paidto" class="col-lg-1  control-label" style="text-align: left;padding-left: 0px">%</label>
                                </div>
                                <div class="form-group">
                                    <label for="chequeNumber" class="col-lg-6  control-label" style="text-align: left">2. Edit Sale Rate on Sale :</label>
                                    <div class="col-lg-6">
                                        <input type="radio"  id="2" name="2" value="1" <?php  if($arr[1] == "1") echo 'checked' ; ?>  /> Yes &nbsp;&nbsp;
                                        <input type="radio"   id="2" name="2" value="0" <?php  if($arr[1] == "0") echo 'checked' ; ?> /> No 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="voucherNumber" class="col-lg-6  control-label" style="text-align: left">3. Printer Type : </label>
                                    <div class="col-lg-6">                                     
                                        <input type="radio"  id="3" name="3" value="1" <?php  if($arr[2] == "1") echo 'checked' ; ?> /> A4 &nbsp;&nbsp;
                                        <input type="radio"   id="3" name="3" value="0" <?php  if($arr[2] == "0") echo 'checked' ; ?> /> POS                                      
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-6  control-label" style="text-align: left">4. Allow Over Sale Than Stock :</label>
                                    <div class="col-lg-6" > 
                                        <input type="radio"  id="4" name="4" value="1" <?php  if($arr[3] == "1") echo 'checked' ; ?> /> Yes &nbsp;&nbsp;
                                        <input type="radio"   id="4" name="4" value="0" <?php  if($arr[3] == "0") echo 'checked' ; ?> /> No 
                                    </div>
                                </div> 
                                
                                 <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-6  control-label" style="text-align: left">5. Enable Virtual Keyboard :</label>
                                    <div class="col-lg-6" > 
                                        <input type="radio"  id="5" name="5" value="1" <?php  if($arr[4] == "1") echo 'checked' ; ?> /> Yes &nbsp;&nbsp;
                                        <input type="radio"   id="5" name="5" value="0" <?php  if($arr[4] == "0") echo 'checked' ; ?> /> No 
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-6  control-label" style="text-align: left">6. Customer Pay Set to "0" :</label>
                                    <div class="col-lg-6" > 
                                        <input type="radio"  id="6" name="6" value="1" <?php  if($arr[5] == "1") echo 'checked' ; ?> /> Yes &nbsp;&nbsp;
                                        <input type="radio"   id="6" name="6" value="0" <?php  if($arr[5] == "0") echo 'checked' ; ?> /> No 
                                    </div>
                                </div>
                                
                                 <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-6  control-label" style="text-align: left">7. Dashboard Graph :</label>
                                    <div class="col-lg-6" > 
                                        <input type="radio"  id="7" name="7" value="1" <?php  if($arr[6] == "1") echo 'checked' ; ?> /> Column &nbsp;&nbsp;
                                        <input type="radio"   id="7" name="7" value="0" <?php  if($arr[6] == "0") echo 'checked' ; ?> /> Line 
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="productsearch" class="col-lg-6  control-label" style="text-align: left">8. Enable Product Search:</label>
                                    <div class="col-lg-6" > 
                                        <input type="radio"  id="8" name="8" value="1" <?php  if($arr[7] == "1") echo 'checked' ; ?> /> Yes &nbsp;&nbsp;
                                        <input type="radio"   id="8" name="8" value="0" <?php  if($arr[7] == "0") echo 'checked' ; ?> /> No 
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="sales_man" class="col-lg-6  control-label" style="text-align: left">9. Sold By:</label>
                                    <div class="col-lg-6" > 
                                        <input type="radio"  id="9" name="9" value="1" <?php  if($arr[8] == "1") echo 'checked' ; ?> /> Yes &nbsp;&nbsp;
                                        <input type="radio"   id="9" name="9" value="0" <?php  if($arr[8] == "0") echo 'checked' ; ?> /> No 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sales_man" class="col-lg-6  control-label" style="text-align: left">10. Product Serial:</label>
                                    <div class="col-lg-6" >
                                        <input type="radio" id="11" name="11" value="1" <?= ($arr[10] == "1") ? 'checked' : '' ; ?> /> Yes &nbsp;&nbsp;
                                        <input type="radio" id="11" name="11" value="0" <?= ($arr[10] == "0") ? 'checked' : '' ; ?> /> No
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sales_man" class="col-lg-6  control-label" style="text-align: left">11. Barcode Scan on Sales:</label>
                                    <div class="col-lg-6" >
                                        <input type="radio" id="12" name="12" value="1" <?= ($arr[11] == "1") ? 'checked' : '' ; ?> /> Yes &nbsp;&nbsp;
                                        <input type="radio" id="12" name="12" value="0" <?= ($arr[11] == "0") ? 'checked' : '' ; ?> /> No
                                    </div>
                                </div>


                                <div class="form-group">                                
                                    <div class="col-lg-6 col-lg-offset-6">
                                        <button type="submit" class="btn btn-primary">Update</button>                                    
                                        <button type="button"  class="btn btn-info"><a href="<?php echo site_url('home') ?>">Cancel</a></button>

                                    </div>
                                </div>
                            </div>

                        </form>                        
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>


