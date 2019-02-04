<?php 
include'config/db.php';
include'config/functions.php';
include'config/main_function.php';
?>
<?php include'assets/header.php';?>

      </nav> 

    </div>
  </div>
  <div style="margin:100px;"></div>
   <div class="container" style="background:white; padding:50px;">
<div class = "content">
            <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class = "col-md-8 col-lg-8">
                    <div class = "widget">
                        <div class = "widget-head">
                            Message/Feedback
                        </div>
                        <div class = "widget-content">
                            <div class = "padd">
                                <form class="form-horizontal" action = "add_message.php" method="post">                              
                                <div class="form-group">
                                  <label class="col-lg-3 control-label">Fullname</label>
                                  <div class="col-lg-8">
                                    <input name = "fullname" type="text" class="form-control" placeholder="Please type your name" required >
                                  </div>
                                </div>                                
                                <div class="form-group">
                                  <label class="col-lg-3 control-label">Email</label>
                                  <div class="col-lg-8">
                                    <input type="email"  name = "email" class="form-control" placeholder="Please type your email" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-lg-3 control-label">Subject</label>
                                  <div class="col-lg-8">
                                    <input type="text" name = "subject" class="form-control" placeholder="Subject" required>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-3 control-label">Comments</label>
                                  <div class="col-lg-8">
                                    <textarea name = "message" class="form-control" rows="5" placeholder="Comments here....."required></textarea>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-offset-3 col-lg-8">
                                    <button  class="btn btn-sm btn-success btn-block">Send</button>                                  
                                  </div>
                                </div>
                              </form>

                        </div>
                        </div>
                    </div>              
                </div>
                <div class = "col-md-4 col-lg-4">
                    <div class = "widget">
                        <div class="widget-head">
                  <div class="pull-left">Contact Information</div>
                   
                  <div class="clearfix"></div>
                </div>
                <div class="widget-content">
                  <!-- Widget content -->
                  <div class="padd">
                                               <!-- Contact box -->
                             <div class="support-contact">
                                <!-- Phone, email and address with font awesome icon -->
                                
                                <p><i class="fa fa-phone"></i>&nbsp; Phone<strong>:</strong> (+63) 9156726535</p>
                                <hr />
                                <p><i class="fa fa-envelope"></i>&nbsp; Email<strong>:</strong> http://www.tratskitchenette.tk/</p>
                                <hr />
                                <p><i class="fa fa-home"></i>&nbsp; Address<strong>:</strong> Quezon City </p>
                                <hr />
                        <p><i class="fa fa-facebook"></i>&nbsp; Facebook<strong>:</strong> facebook.com/tratskitchenette </p>
                                <hr />              
                                                <!-- Button -->
                                              
                                             </div>
                                  </div>
                                </div>

                              </div> 

                            </div>
                      </div>  
                    </div>
                     </div>
                    </div>      
                </div>              
            </div>  
        </div>
        <div class = "content">
            <div class = "col-lg-12 col-md-12  col-sm-12">
                <div class = "col-lg-12 col-md-12 col-sm-12 ">
                    <div class = "title-header">
                        <h2 class = "center">
                            Owner of JMDC KITCHENETTE
                        </h2>
                    </div>                  
                </div>
                <br/>
                <br/>
                <br/>
                <div class = "col-lg-3 col-md-3 col-sm-3">
                    
                </div>
                <div class = "col-lg-3 col-md-3 col-sm-3">
                    <div class = "center user-icon">
                        <img src = "images/iconz.png"/>
                    </div>
                    <h4 class = "center">Jose Angelo S. Cerdon</h4>
                    <h5 class = "center">Owner</h5>                                         
                </div>
                <div class = "col-lg-3 col-md-3 col-sm-3">
                    <div class = "center">
                        <img src = "images/card.jpg" height="150px;" width="250px;" />
                    </div>
                    <h4 class = "center">Calling Card</h4>
                    <h5 class = "center"></h5>                                      
                </div>
                <div class = "col-lg-3 col-md-3 col-sm-3">
                                        
                </div>

            </div>
        </div>
        <!-- / row -->
    </div><!-- / container -->
    <div style="margin:100px;"></div>
<?php include'assets/footer.php';?>
</body>
</html>



