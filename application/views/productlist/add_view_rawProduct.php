<section id="main-content">
    <section class="wrapper site-min-height">    
        <section class="panel">            
            <div class="panel-body">
                <form class="cmxform form-horizontal" id="unitgroupadd" method="post" action="<?php echo site_url('productlist/rawproduct/add_rawProduct'); ?>" enctype="multipart/form-data">
                    <div class="modal-header">                        
                        <h4 class="modal-title" id="myModalLabel">Add Raw Product Information</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="productName" class="control-label col-lg-4">Product Name :</label>
                            <div class="col-lg-8">
                                <input class=" form-control" id="productName" name="productName" type="text" required onchange="return name();" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="productGroupId" class="control-label col-lg-4">Product Group :</label>
                            <div class="col-lg-8">
                                <select class="form-control" id="productGroupId" name="productGroupId" type="text" required>
                                    <option value="">--Product Group Under --</option>
                                    <?php foreach ($productlist as $prolist): ?>
                                        <option value="<?php echo $prolist->productGroupId; ?>"><?php echo $prolist->productGroupName; ?></option>
                                    <?php endforeach; ?> 
                                    <option value="addgrup"><?php echo 'Add New Product Group'; ?></option>
                                </select>
                                <span id="grpmsg"></span>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="manufactureId" class="control-label col-lg-4">Manufacturer :</label>
                            <div class="col-lg-8">
                                <select class="form-control" id="manufactureId" name="manufactureId" type="text" required>
                                    <option value="">--Manufacturer Under --</option>
                                    <?php foreach ($manufaclist as $manus): ?>
                                        <option value="<?php echo $manus->manufactureId; ?>"><?php echo $manus->manufactureName; ?></option>
                                    <?php endforeach; ?> 
                                    <option value="addmanu"><?php echo 'Add New Manufacturer'; ?></option>
                                </select>
                                <span id="manumsg"></span>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="stockMinimumLevel" class="control-label col-lg-4">Stock Minimum Level :</label>
                            <div class="col-lg-8">
                                <input class=" form-control" id="stockMinimumLevel" name="stockMinimumLevel" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="stockMaximumLevel" class="control-label col-lg-4">Stock Maximum Level :</label>
                            <div class="col-lg-8">
                                <input class=" form-control" id="stockMaximumLevel" name="stockMaximumLevel" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="unitId" class="control-label col-lg-4">Unit :</label>
                            <div class="col-lg-8">
                                <select class="form-control" id="unitId" name="unitId" type="text" required>
                                    <option value="">--Unit Under --</option>
                                    <?php foreach ($unitlist as $unit): ?>
                                        <option value="<?php echo $unit->unitId; ?>"><?php echo $unit->unitName; ?></option>
                                    <?php endforeach; ?> 
                                    <option value="addunit"><?php echo 'Add New Unit'; ?></option>
                                </select>
                                <span id="unitmsg"></span>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="taxType" class="control-label col-lg-4">Tax Type :</label>
                            <div class="col-lg-8">
                                <select class="form-control" id="taxType" name="taxType" type="text" required>
                                    <option value="1">N/A</option>
                                    <option value="2">Included</option>
                                    <option value="3">Excluded</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="tax" class="control-label col-lg-4">Tax% :</label>
                            <div class="col-lg-8">
                                <input class=" form-control" id="tax" name="tax" type="text" />
                            </div>
                        </div>                                
                        <div class="form-group ">
                            <label for="description" class="control-label col-lg-4 ">Description</label>
                            <div class="col-lg-8">
                                <textarea class="form-control" type="text" id="description" name="description"></textarea>
                            </div>
                        </div> 
                        <div class="form-group ">
                            <label for="userfile" class="control-label col-lg-4">Upload Images:</label>
                            <div class="col-lg-8">                                                   
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
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Save"/>
                        <input type="reset" class="btn btn-info" value="Clear"/>
                        <a  href="<?php echo site_url('productlist/product') ?>"><button type="button" class="btn btn-default">Close</button></a>
                    </div> 
                </form>
            </div>
        </section>
    </section>
</section>
<!-- ############################# Add Product Group ############################### -->
<div class="modal fade" id="addprgrpModal" tabindex="-1" role="dialog" aria-labelledby="addProductunit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="cmxform form-horizontal" id="unitgroupadd" method="post" action="<?php echo site_url('productlist/productGroup/addproductGroup'); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Product Group Information</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group ">
                        <label for="unitname" class="control-label col-lg-4">Product Group Name:</label>
                        <div class="col-lg-8">
                            <input class=" form-control" id="productGroupName" name="productGroupName" type="text" />
                            <input class=" form-control" id="modalname" name="modalname" type="hidden" value="fromproduct"/>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="description" class="control-label col-lg-4">Description:</label>
                        <div class="col-lg-8 col-sm-8">
                            <textarea class="form-control" type="text" id="description" name="description"></textarea>
                        </div>
                    </div>                                  
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save"/>
                    <input type="reset" class="btn btn-info" value="Clear"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                                
                </div> 
            </form>
        </div>
    </div>
</div>
<!-- ############################# /Add Product Group ############################### -->
<!-- #############################  Add Manufacture #################################-->
<div class="modal fade" id="myModalmanu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="addfarmer" method="post" action="<?php echo site_url('manufacture/manufacture/addManufacture'); ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center">Add Manufacturer Information</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="manufactureName" class="control-label col-lg-4">Manufacturer Name :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="manufactureName" name="manufactureName"  type="text" required  onchange="return accountNameCheck()"/>
                                        <input class=" form-control" id="modalname" name="modalname" type="hidden" value="fromproduct"/>
                                        <span id="servermsg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="Address" class="control-label col-lg-4">Address :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="address" name="address"  type="text" required />                                       
                                    </div>
                                </div>
                            </div> 
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="phone" class="control-label col-lg-4">Phone No :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="phone" name="phone"  type="text" required />                                       
                                    </div>
                                </div>
                            </div> 
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="email" class="control-label col-lg-4">E-mail Id :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="email" name="email"  type="email" required />                                     
                                    </div>
                                </div>
                            </div>                           
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="description" class="control-label col-lg-4">Description :</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control " id="description" name="description" type="text"></textarea>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-info">Clear</button>
                    <button type="button" class="btn btn-default " data-dismiss="modal" onclick="return reloadMymodal();">Cancel</button>
                </div>
            </div>
    </div>
</form>
</div> 
<!-- #############################  /Add Manufacture #################################-->
<!-- #############################  Add Unit #########################################-->
<div class="modal fade" id="addProductunit" tabindex="-1" role="dialog" aria-labelledby="addProductunit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="cmxform form-horizontal" id="unitgroupadd" method="post" action="<?php echo site_url('productunit/unit/addunit'); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Unit Information</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group ">
                        <label for="unitname" class="control-label col-lg-3">Unit Name:</label>
                        <div class="col-lg-8">
                            <input class=" form-control" id="unitname" name="unitname" type="text" />
                            <input class=" form-control" id="modalname" name="modalname" type="hidden" value="fromproduct"/>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="description" class="control-label col-lg-3 col-sm-3">Description:</label>
                        <div class="col-lg-8 col-sm-8">
                            <textarea class="form-control" type="text" id="description" name="description"></textarea>
                        </div>
                    </div>                                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Save unit"/>
                </div> 
            </form>
        </div>
    </div>
</div>
<!-- #############################  /Add Unit #########################################-->