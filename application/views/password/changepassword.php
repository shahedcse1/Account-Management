<section id="main-content" >
    <section class="wrapper site-min-height">
        <section class="panel">
            <header class="panel-heading">
                Change Password
            </header>
            <style>
                #myModalLabel{
                    font-weight: bold
                }
            </style>                          
            <form class="cmxform form-horizontal tasi-form" method="post" action="<?php echo site_url('password/changepassword/updatepassword') ?>">
                <br/>
                <div class="panel-body"> 
                    <div class="form-group ">
                        <label for="currentpassword" class="control-label col-lg-4">Current Password :</label>
                        <div class="col-lg-6">
                            <input class=" form-control" id="currentpassword" name="currentpassword" type="password" onchange="checkcurrentpassword()" required/>
                            <span id ="currentpassmsg"></span>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="text-align: center"> 
                    <div class="form-group ">
                        <label for="newpassword" class="control-label col-lg-4">New Password :</label>
                        <div class="col-lg-6">
                            <input class=" form-control" id="newpassword" name="newpassword"  type="password" required/>
                            <span id="newpassmsg"></span>
                        </div>
                    </div>
                </div>
                <div class="panel-body"> 
                    <div class="form-group ">
                        <label for="verifynewpassword" class="control-label col-lg-4">Verify New Password :</label>
                        <div class="col-lg-6">
                            <input class=" form-control" id="verifynewpassword" name="verifynewpassword" type="password" onchange="return checksamepass()" required/>
                            <span id="confnewpassmsg" style="text-align: left"></span>
                        </div>
                    </div>
                </div>
                <div class="panel-body m-bot15" style="text-align: center"> 
                    <div class="form-group">
                        <button type="submit" id="updatepass" class="btn btn-danger">Update Password</button>&nbsp;&nbsp;
                        <button type="reset" class="btn btn-inverse">Clear</button>&nbsp;&nbsp;
                        <a href="<?php echo site_url('home');?>"><button type="button" class="btn btn-default">Cancel</button></a>
                    </div>  
                </div> 
                <br/>
            </form>
        </section>
    </section>
</section>


<script>
    function checksamepass() {        
        if ($("#newpassword").val() == $("#verifynewpassword").val()) {
            $("#confnewpassmsg").text("");
            $("#updatepass").prop('disabled', false);
            return true;
        } else {
            $("#confnewpassmsg").text("Password not match");
            $("#confnewpassmsg").css('color', 'red');
            $("#updatepass").prop('disabled', true);
            return false
        }
    }
    function checkcurrentpassword() {
        var dataString = "currentpass=" + $("#currentpassword").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('password/changepassword/checkcurrentpassword'); ?>",
            data: dataString,
            success: function (data) {
                if (data == 'matched') {
                    $("#currentpassmsg").text('Current password  Matched with existing password');
                    $("#updatepass").prop('disabled', false);
                    return true;
                }
                if (data == 'notmatched') {
                    $("#currentpassmsg").text('Current password not matched with existing password');
                    $("#currentpassmsg").css('color','red');
                    $("#updatepass").prop('disabled', true);
                    return true;
                }                
            }
        });
    }
</script>
<?php if ($this->session->userdata('success')): ?>
    <script>

        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Password Updated Successfully',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('success');
endif;
?>
<?php if ($this->session->userdata('fail')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Failed!',
                text: 'Password Update Fail',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('fail');
endif;
?>
