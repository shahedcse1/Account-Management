<section id="main-content">
    <section class="wrapper site-min-height">    
        <div class="row">
            <?php
            if (sizeof($databyid) > 0):
                foreach ($databyid as $unitvalue):
                    ?>
                    <header class="panel-heading">
                        Edit Product Information
                    </header>
                    <div class="col-lg-7" style="margin-top: 20px;">
                        <section class="panel">
                            <form class="cmxform form-horizontal" id="unitgroupedit" method="post" action="<?php echo site_url('productlist/rawproduct/edit_rawProduct'); ?>" enctype="multipart/form-data">
                                <div class="panel-body">
                                    <div class="form-group" style="margin-top: 20px;">
                                        <label for="productName" class="control-label col-lg-3">Product Name :</label>
                                        <div class="col-lg-6">
                                            <input class=" form-control" id="editproductName" name="editproductName" type="text" value="<?php echo $unitvalue->productName; ?>" required />
                                            <input class=" form-control" id="editproductId" name="editproductId" type="hidden" value="<?php echo $unitvalue->productId; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="productGroupId" class="control-label col-lg-3">Product Group :</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="editproductGroupId" name="editproductGroupId" type="text">
                                                <option value="">--Product Group Under --</option>                                                   
                                                <?php
                                                foreach ($productlist as $prolist):
                                                    if ($unitvalue->productGroupId == $prolist->productGroupId):
                                                        ?>                                                    
                                                        <option selected value="<?php echo $prolist->productGroupId; ?>"><?php echo $prolist->productGroupName; ?></option>                                                    
                                                    <?php else:
                                                        ?>
                                                        <option value="<?php echo $prolist->productGroupId; ?>"><?php echo $prolist->productGroupName; ?></option>
                                                    <?php
                                                    endif;
                                                endforeach;
                                                ?> 
                                                <option value="addprgrp"><?php echo 'Add New Product Group'; ?></option>
                                            </select>
                                            <span id="grpmsg"></span>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="manufactureId" class="control-label col-lg-3">Manufacturer :</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="editmanufactureId" name="editmanufactureId" type="text">
                                                <option value="">--Manufacturer Under --</option>
                                                <?php
                                                foreach ($manufaclist as $manus):
                                                    if ($unitvalue->manufactureId == $manus->manufactureId):
                                                        ?>
                                                        <option selected value="<?php echo $manus->manufactureId; ?>"><?php echo $manus->manufactureName; ?></option>
                                                    <?php else: ?>
                                                        <option  value="<?php echo $manus->manufactureId; ?>"><?php echo $manus->manufactureName; ?></option>
                                                    <?php
                                                    endif;
                                                endforeach;
                                                ?> 
                                                <option value="addmanu"><?php echo 'Add New Manufacturer'; ?></option>
                                            </select>
                                            <span id="manumsg"></span>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="stockMinimumLevel" class="control-label col-lg-3">Stock Minimum Level :</label>
                                        <div class="col-lg-6">
                                            <input class=" form-control" id="editstockMinimumLevel" name="editstockMinimumLevel" type="text" value="<?php echo $unitvalue->stockMinimumLevel; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="stockMaximumLevel" class="control-label col-lg-3">Stock Maximum Level :</label>
                                        <div class="col-lg-6">
                                            <input class=" form-control" id="editstockMaximumLevel" name="editstockMaximumLevel" type="text" value="<?php echo $unitvalue->stockMaximumLevel; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="unitId" class="control-label col-lg-3">Unit :</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="editunitId" name="editunitId" type="text">
                                                <option value="">--Unit Under --</option>
                                                <?php
                                                foreach ($unitlist as $unit):
                                                    if ($unitvalue->unitId == $unit->unitId):
                                                        ?>
                                                        <option selected value="<?php echo $unit->unitId; ?>"><?php echo $unit->unitName; ?></option>
                                                    <?php else : ?>
                                                        <option value="<?php echo $unit->unitId; ?>"><?php echo $unit->unitName; ?></option>
                                                    <?php
                                                    endif;
                                                endforeach;
                                                ?> 
                                                <option value="addunit"><?php echo 'Add New Unit'; ?></option>
                                            </select>
                                            <span id="unitmsg"></span>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="taxType" class="control-label col-lg-3">Tax Type :</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="edittaxType" name="edittaxType" type="text" >
                                                <?php if ($unitvalue->taxType == "1"): ?>
                                                    <option value="1" selected >N/A</option>
                                                    <option value="2">Included</option>
                                                    <option value="3">Excluded</option>
                                                <?php endif; ?>
                                                <?php if ($unitvalue->taxType == "2"): ?>
                                                    <option value="1" >N/A</option>
                                                    <option value="2" selected>Included</option>
                                                    <option value="3">Excluded</option>
                                                <?php endif; ?>
                                                <?php if ($unitvalue->taxType == "3"): ?>
                                                    <option value="1">N/A</option>
                                                    <option value="2">Included</option>
                                                    <option value="3" selected>Excluded</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="tax" class="control-label col-lg-3">Tax% :</label>
                                        <div class="col-lg-6">
                                            <input class=" form-control" id="edittax" name="edittax" type="text" value="<?php echo $unitvalue->tax; ?>" />
                                        </div>
                                    </div>   
                                    <div class="form-group ">
                                        <label for="tax" class="control-label col-lg-3">Sale Rate :</label>
                                        <div class="col-lg-6">
                                            <input class="form-control" id="psalesrate" name="psalesrate" type="text" value="<?php echo $psalesrate; ?>" />
                                            <input type="hidden" name="pbatchid" value="<?php echo $pbatchid; ?>">
                                        </div>
                                    </div>   
                                    <div class="form-group ">
                                        <label for="description" class="control-label col-lg-3 ">Description:</label>
                                        <div class="col-lg-6 col-sm-6">
                                            <textarea class="form-control" type="text" id="editdescription" name="editdescription" ><?php echo $unitvalue->description; ?></textarea>
                                        </div>
                                    </div>  
                                    <div class="form-group ">
                                        <label for="userfile" class="control-label col-lg-3">Upload Images:</label>
                                        <div class="col-lg-6">                                                   
                                            <input class=" form-control" id="userfile" name="picture"  type="file" />
                                            <p>Max (1000&#10005;1000)px, Type (jpg, png, gif)</p>
                                            <!--                                
                                            <span style="color:blue" id="file_msg"><?php
                                            echo $this->session->userdata('error_msg');
                                            $this->session->unset_userdata('error_msg');
                                            ?>
                                            </span>
                                            -->
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="text-align: center">
                                    <input type="submit" class="btn btn-primary" value="Update"/>&nbsp;&nbsp;&nbsp;                                  
                                    <a  href="<?php echo site_url('productlist/product') ?>"><button type="button" class="btn btn-default">Cancel</button></a>
                                </div> 
                            </form>
                        </section>
                    </div>
                    <div class="col-lg-5" style="margin-top: 20px">
                        <section class="panel">
                            <img src="<?php echo base_url('assets/uploads/product/' . $unitvalue->images) ?>"  height="600" width="100%">
                        </section>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </section>
</section>