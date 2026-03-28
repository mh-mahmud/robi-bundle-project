<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bundle User Guid</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/tab.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="background-image: url(image/bg_0.png)">
		<div class="container" style="background-image: url(image/bg_1.png)">
			<div class="row">
		        <div class="col-lg-5 col-md-5 col-sm-8 col-xs-9 bhoechie-tab-container">
		            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
		              <div class="list-group">
		              	<!-- Welcome section -->
		                <a href="#" class="list-group-item active text-center">
		                  <h2 class="glyphicon glyphicon-off"></h2><br/>Welcome
		                </a>
		                <!-- Bundle section -->
		                <a href="#" class="list-group-item text-center">
		                  <h2 class="glyphicon glyphicon-folder-close"></h2><br/>Bundle
		                </a>
		                <!-- Configuration section -->
		                <a href="#" class="list-group-item text-center">
		                  <h2 class="glyphicon glyphicon-cog"></h2><br/>Configuration
		                </a>
		                <!-- Report section -->
		                <a href="#" class="list-group-item text-center">
		                  <h2 class="glyphicon glyphicon-list-alt"></h2><br/>Report
		                </a>
		                <!-- User section -->
		                <a href="#" class="list-group-item text-center">
		                  <h2 class="glyphicon glyphicon-user"></h2><br/>User
		                </a>
		                <!-- My Account section -->
		                <a href="#" class="list-group-item text-center">
		                  <h2 class="glyphicon glyphicon-wrench"></h2><br/>My Account
		                </a>
		              </div><!-- end .list-group -->
		            </div><!-- enc .bhoechie-tab-menu -->
		            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
		                <!-- Welcome section -->
		                <div class="bhoechie-tab-content active">
		                    <center>
		                      <h1 class="glyphicon glyphicon-user" style="font-size:14em;color:#55518a"></h1>
		                      <h2 style="margin-top: 0;color:#55518a">Welcome to Bundle User Guide</h2>
		                      <h3 style="margin-top: 0;color:#55518a">Please follow the instractions.</h3>
		                    </center>
		                </div>
		                
		                <!-- Bundle section -->
		                <div class="bhoechie-tab-content">
											<h2>Bundle</h2>
											  <ul class="nav nav-tabs">
											    <li class="active"><a href="#create_bundle">CREATE BUNDLE</a></li>
											    <li><a href="#manage_bundle">MANAGE BUNDLE</a></li>
											    <li><a href="#upload_sale-batch">UPLOAD SALE BATCH</a></li>
											    <li><a href="#upload_sale-individual">UPLOAD SALE INDIVIDUAL</a></li>
											    <li><a href="#manage_sale">MANAGE SALE</a></li>
											  </ul>
											  <div class="tab-content">
											    <div id="create_bundle" class="tab-pane fade in active">
														<h4>Create Bundle:</h4>
														<ol>
															<li>Click on Create Bundle Menu.</li>
															<center><img src="image/create_bundle.png"  class="img-responsive img-thumbnail"></center><hr />
															<li>Fillup the mandatory field.</li>
															<li>Click Submit Data Button.</li>
															<p>&nbsp; &nbsp; &nbsp; &nbsp;* If type = EMI then MRP (BDT) might be monthly installment value and Bundle item might be inserted as monthly basis.</p>
															<p>&nbsp; &nbsp; &nbsp; &nbsp;* If type = In Cash or Credit MRP (BDT) might be sale value and Bundle item might be inserted as total.</p>
															<center><img src="image/create_bundle_form.png" class="img-responsive img-thumbnail"></center>
														</ol>
											    </div>
											    
											    <div id="manage_bundle" class="tab-pane fade">
											      <h4>Manage Bundle:</h4>
											      <ol>
											      	<li>Click on Manage Bundle Menu</li>
											      	<center><img src="image/manage_bundle.png" class="img-responsive img-thumbnail"></center>
											      </ol>
														<hr />
														<center><img src="image/manage_bundle_page.png" class="img-responsive img-thumbnail"></center>
														<center>Fig: Manage Bundle Page.</center>
														<hr />
											      <h4>Filter the data:</h4>
											      <ol>
											      	<li>Select Subscriber's Base.</li>
											      	<center><img src="image/subscriber_base.png" class="img-responsive img-thumbnail"></center>
											      	<li>Give your keyword:</li>
											      	<center><img src="image/keyword.png" class="img-responsive img-thumbnail"></center>
											      	<li>Click the Filter Data Button.</li>
											      	<center><img src="image/filter.png" class="img-responsive img-thumbnail"></center>
											      	<li>To refresh Bundle data filter use Refrash button</li>
											      	<center><img src="image/refresh.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											      <hr />
											      <h4>Generate A Report:</h4>
											      <ol>
											      	<li>To print a report on manage bundle page click on Print Button.</li>
											      	<center><img src="image/print.png" class="img-responsive img-thumbnail"></center>
											      	<li>To export report as excel click on Export Button.</li>
											      	<center><img src="image/export.png" class="img-responsive img-thumbnail"></center>
											      </ol>
														<hr />
														<h4>Bundle Details:</h4>
											      <ol>
											      	<li>To see Bundle Details Click on Details Button.</li>
											      	<center><img src="image/details.png" class="img-responsive img-thumbnail"></center>
											      	<hr />
											      	<center><img src="image/bundle_details_page.png" class="img-responsive img-thumbnail"></center>
											      	<center>Fig: Bundle Details Page.</center>
											      	<hr />
											      	<li>To print a report on Bundle Details page click on Print Button.</li>
											      	<center><img src="image/print.png" class="img-responsive img-thumbnail"></center>
											      	<li>To export Bundle Details as excel click on Export Button.</li>
											      	<center><img src="image/export.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											    </div>
											    
											    <div id="upload_sale-batch" class="tab-pane fade">
														<h4>Upload Sale Batch:</h4>
														<ol>
															<li>Click on Upload Sale Batch menu.</li>
															<center><img src="image/upload_sale_batch.png"  class="img-responsive img-thumbnail"></center>
														<hr />
															<li>Browse your file and select Submit Data.</li>
															<p>&nbsp; &nbsp; &nbsp; &nbsp;* File must be unique.</p>
															<p>&nbsp; &nbsp; &nbsp; &nbsp;* If files are same name you have to rename it to different name.</p>
															<p>&nbsp; &nbsp; &nbsp; &nbsp;* You are allowed to upload only .csv and .xls file formate.</p>
															<center><img src="image/upload_sale_batch_form.png" class="img-responsive img-thumbnail"></center>
															<li>To see formated file download from here.</li>
															<center><img src="image/download_file.png" class="img-responsive img-thumbnail"></center>
														</ol>
											    </div>
											    
											    <div id="upload_sale-individual" class="tab-pane fade">
														<h4>Upload Sale Individual:</h4>
														<ol>
															<li>Click on Upload Sale Individual Menu.</li>
															<center><img src="image/upload_sale_individual.png"  class="img-responsive img-thumbnail"></center>
														<hr />
															<li>Fillup the mandatory field then click Submit Data.</li>
															<center><img src="image/upload_sale_individual_form.png" class="img-responsive img-thumbnail"></center>
														</ol>
											    </div>
											    
											    <div id="manage_sale" class="tab-pane fade">
											      <h4>Manage Sale:</h4>
											      <ol>
											      	<li>Click on Manage Sale Menu.</li>
											      	<center><img src="image/manage_sale.png"  class="img-responsive img-thumbnail"></center>
											      </ol>
											      <hr />
														<center><img src="image/manage_sale_page.png" class="img-responsive img-thumbnail"></center>
														<center>Fig: Manage Sale Page.</center>
														<hr />
											      <h4>Generate A Report:</h4>
											      <ol>
											      	<li>To print a report on Manage Sale page click on Print Button.</li>
											      	<center><img src="image/print.png" class="img-responsive img-thumbnail"></center>
											      	<li>To export report as excel click on Export Button.</li>
											      	<center><img src="image/export.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											    </div>
											  </div>
											    <hr>
		                </div>

										<!-- Configuration search -->
		                <div class="bhoechie-tab-content">
		                	<h2>Configuration</h2>
											  <ul class="nav nav-tabs">
											    <li class="active"><a href="#create_option">CREATE UNIT</a></li>
											    <li><a href="#manage_option">MANAGE OPTION</a></li>
											    <li><a href="#create_service">CREATE SERVICE</a></li>
											    <li><a href="#manage_service">MANAGE SERVICE</a></li>
											  </ul>
											  <div class="tab-content">
											    <div id="create_option" class="tab-pane fade in active">
											    	<h4>Create Unit:</h4>
														<ol>
															<li>Click on Create Option Menu.</li>
															<center><img src="image/create_option.png"  class="img-responsive img-thumbnail"></center><hr />
															<li>Fillup the mandatory field.</li>
															<li>Click Submit Data Button.</li>
															<center><img src="image/create_option_form.png" class="img-responsive img-thumbnail"></center>
														</ol>
											    </div>
											    
											    <div id="manage_option" class="tab-pane fade">
											      <h4>Manage Unit:</h4>
											      <ol>
											      	<li>Click on Manage Option Menu</li>
											      	<center><img src="image/manage_option.png" class="img-responsive img-thumbnail"></center>
											      </ol>
														<hr />
														<center><img src="image/manage_option_page.png" class="img-responsive img-thumbnail"></center>
														<center>Fig: Manage Option Page.</center>
														<hr />
											      <h4>Filter the data:</h4>
											      <ol>
											      	<li>Give your keyword.</li>
											      	<center><img src="image/keyword.png" class="img-responsive img-thumbnail"></center>
											      	<li>Click the Filter Data Button.</li>
											      	<center><img src="image/filter.png" class="img-responsive img-thumbnail"></center>
											      	<li>To refresh option data filter use Refrash button</li>
											      	<center><img src="image/refresh.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											      <hr />
											      <h4>Generate A Report:</h4>
											      <ol>
											      	<li>To print a report on manage option page click on Print Button.</li>
											      	<center><img src="image/print.png" class="img-responsive img-thumbnail"></center>
											      	<li>To export report as excel click on Export Button.</li>
											      	<center><img src="image/export.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											      <hr>
											      <h4>Actions:</h4>
											      <ol>
											      	<li>To edit a option  click on edit Button.</li>
											      	<center><img src="image/edit.png" class="img-responsive img-thumbnail"></center>
											      	<li>To inactive any option click on Inactive button.</li>
											      	<center><img src="image/inactive.png" class="img-responsive img-thumbnail"></center>
											      	<li>To active any option click on Active button.</li>
											      	<center><img src="image/active.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											    </div>
											    
											    <div id="create_service" class="tab-pane fade">
											    	<h4>Create Service:</h4>
														<ol>
															<li>Click on Create Service Menu.</li>
															<center><img src="image/create_service.png"  class="img-responsive img-thumbnail"></center><hr />
															<li>Fillup the mandatory field.</li>
															<li>Click Submit Data Button.</li>
															<center><img src="image/create_service_form.png" class="img-responsive img-thumbnail"></center>
														</ol>
											    </div>
											    
											    <div id="manage_service" class="tab-pane fade">
											      <h4>Manage Service Menu:</h4>
											      <ol>
											      	<li>Click on Manage Service Menu</li>
											      	<center><img src="image/manage_service.png" class="img-responsive img-thumbnail"></center>
											      </ol>
														<hr />
														<center><img src="image/manage_service_page.png" class="img-responsive img-thumbnail"></center>
														<center>Fig: Manage Service Page.</center>
														<hr />
											      <h4>Filter the data:</h4>
											      <ol>
											      	<li>Give your keyword.</li>
											      	<center><img src="image/keyword.png" class="img-responsive img-thumbnail"></center>
											      	<li>Click the Filter Data Button.</li>
											      	<center><img src="image/filter.png" class="img-responsive img-thumbnail"></center>
											      	<li>To refresh option data filter use Refrash button</li>
											      	<center><img src="image/refresh.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											      <hr />
											      <h4>Generate A Report:</h4>
											      <ol>
											      	<li>To print a report on manage option page click on Print Button.</li>
											      	<center><img src="image/print.png" class="img-responsive img-thumbnail"></center>
											      	<li>To export report as excel click on Export Button.</li>
											      	<center><img src="image/export.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											      <hr>
											      <h4>Actions:</h4>
											      <ol>
											      	<li>To edit a option  click on edit Button.</li>
											      	<center><img src="image/edit.png" class="img-responsive img-thumbnail"></center>
											      	<li>To inactive any option click on Inactive button.</li>
											      	<center><img src="image/inactive.png" class="img-responsive img-thumbnail"></center>
											      	<li>To active any option click on Active button.</li>
											      	<center><img src="image/active.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											    </div>
											  </div>
											    <hr>
		                </div>
		    
		                <!-- Report search -->
		                <div class="bhoechie-tab-content">
		                	<h2>Report</h2>
											  <ul class="nav nav-tabs">
											    <li class="active"><a href="#fv_allocation">FV ALLOCATION</a></li>
											    <li><a href="#fv_deferment">FV DEFERMENT</a></li>
											    <li><a href="#fv_summery">FV_SUMMERY</a></li>
											    <li><a href="#summery_jv">SUMMERY_JV</a></li>
											  </ul>
											  <div class="tab-content">
											    <div id="fv_allocation" class="tab-pane fade in active">
											    	<h4>Generate FV Allocation Report:</h4>
														<ol>
															<li>Click on FV Allocation Menu.</li>
															<center><img src="image/fv_allocation.png"  class="img-responsive img-thumbnail"></center>
															<hr />
															<center><img src="image/fv_allocation_report.png"  class="img-responsive img-thumbnail"></center>
															<center>Fig: FV Allocation Report Form.</center>
															<hr />
											      	<li>Select a Bundle Name.</li>
											      	<li>To print a report click on Print Button.</li>
											      	<center><img src="image/print.png" class="img-responsive img-thumbnail"></center>
											      	<li>To export report as excel click on Export Button.</li>
											      	<center><img src="image/export.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											    </div>
											    
											    <div id="fv_deferment" class="tab-pane fade">
											      <h4>Generate FV Deferment Report:</h4>
														<ol>
															<li>Click on FV Deferment Menu.</li>

														<center><img src="image/fv_deferment.png"  class="img-responsive img-thumbnail"></center>
														<hr />
														<center><img src="image/fv_deferment_report.png"  class="img-responsive img-thumbnail"></center>
														<center>Fig: FV Deferment Report Form.</center>
														<hr />
											      	<li>Select a Bundle Name.</li>
											      	<li>Give Start Date and End Date.</li>
											      	<li>To print a report click on Print Button.</li>
											      	<center><img src="image/print.png" class="img-responsive img-thumbnail"></center>
											      	<li>To export report as excel click on Export Button.</li>
											      	<center><img src="image/export.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											    </div>
											    
											    <div id="fv_summery" class="tab-pane fade">
											    	<h4>Generate FV Summery Report:</h4>
														<ol>
															<li>Click on FV Summery Menu.</li>
														<center><img src="image/fv_summery.png"  class="img-responsive img-thumbnail"></center>
														<hr />
														<center><img src="image/fv_summery_report.png"  class="img-responsive img-thumbnail"></center>
														<center>Fig: FV Summery Report Form.</center>
														<hr />
											      	<li>Give the month you want to generate a report.</li>
											      	<li>To print a report click on Print Button.</li>
											      	<center><img src="image/print.png" class="img-responsive img-thumbnail"></center>
											      	<li>To export report as excel click on Export Button.</li>
											      	<center><img src="image/export.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											    </div>
											    
											    <div id="summery_jv" class="tab-pane fade">
											      <h4>Generate Summery JV Report:</h4>
														<ol>
															<li>Click on FV Summery Menu.</li>
														<center><img src="image/summary_jv.png"  class="img-responsive img-thumbnail"></center>
														<hr />
														<center><img src="image/summary_jv_report.png"  class="img-responsive img-thumbnail"></center>
														<center>Fig: Revenue Deferment Report Form.</center>
														<hr />
											      	<li>Select Revenue Type.</li>
											      	<li>Give the month you want to generate a report.</li>
											      	<li>To print a report click on Print Button.</li>
											      	<center><img src="image/print.png" class="img-responsive img-thumbnail"></center>
											      	<li>To export report as excel click on Export Button.</li>
											      	<center><img src="image/export.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											    </div>
											  </div>
											    <hr>
		                </div>
		                
		                <!-- User search -->
		                <div class="bhoechie-tab-content">
		                	<h2>User</h2>
											  <ul class="nav nav-tabs">
											    <li class="active"><a href="#create_role">CREATE ROLE</a></li>
											    <li><a href="#manage_role">MANAGE ROLE</a></li>
											    <li><a href="#create_user">CREATE USER</a></li>
											    <li><a href="#manage_user">MANAGE USER</a></li>
											  </ul>
											  <div class="tab-content">
											    <div id="create_role" class="tab-pane fade in active">
											    	<h4>Create Role:</h4>
														<ol>
															<li>Click on Create Role Menu.</li>
															<center><img src="image/create_role.png"  class="img-responsive img-thumbnail"></center><hr />
															<li>Fillup the mandatory field.</li>
															<li>Click Submit Data Button.</li>
															<center><img src="image/create_role_form.png" class="img-responsive img-thumbnail"></center>
														</ol>
											    </div>
											    
											    <div id="manage_role" class="tab-pane fade">
											      <h4>Manage Role Menu:</h4>
											      <ol>
											      	<li>Click on Manage Role Menu</li>
											      	<center><img src="image/manage_role.png" class="img-responsive img-thumbnail"></center>
											      </ol>
														<hr />
														<center><img src="image/manage_role_page.png" class="img-responsive img-thumbnail"></center>
														<center>Fig: Manage Role Page.</center>
														<hr />
											      <h4>Filter the data:</h4>
											      <ol>
											      	<li>Give your keyword.</li>
											      	<center><img src="image/keyword.png" class="img-responsive img-thumbnail"></center>
											      	<li>Click the Filter Data Button.</li>
											      	<center><img src="image/filter.png" class="img-responsive img-thumbnail"></center>
											      	<li>To refresh user data filter use Refrash button</li>
											      	<center><img src="image/refresh.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											      <hr>
											      <h4>Actions:</h4>
											      <ol>
											      	<li>To edit a User Role  click on edit Button.</li>
											      	<center><img src="image/edit.png" class="img-responsive img-thumbnail"></center>
											      	<li>To inactive any user role click on Inactive button.</li>
											      	<center><img src="image/inactive.png" class="img-responsive img-thumbnail"></center>
											      	<li>To active any user role click on Active button.</li>
											      	<center><img src="image/active.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											    </div>
											    
											    <div id="create_user" class="tab-pane fade">
											    	<h4>Create User:</h4>
														<ol>
															<li>Click on Create User Menu.</li>
															<center><img src="image/create_user.png"  class="img-responsive img-thumbnail"></center><hr />
															<li>Fillup the mandatory field.</li>
															<li>Click Submit Data Button.</li>
															<center><img src="image/create_user_form.png" class="img-responsive img-thumbnail"></center>
														</ol>
											    </div>
											    
											    <div id="manage_user" class="tab-pane fade">
											      <h4>Manage User Menu:</h4>
											      <ol>
											      	<li>Click on Manage User Menu</li>
											      	<center><img src="image/manage_user.png" class="img-responsive img-thumbnail"></center>
											      </ol>
														<hr />
														<center><img src="image/manage_user_page.png" class="img-responsive img-thumbnail"></center>
														<center>Fig: Manage User Page.</center>
														<hr />
											      <h4>Filter the data:</h4>
											      <ol>
											      	<li>Give your keyword.</li>
											      	<center><img src="image/keyword.png" class="img-responsive img-thumbnail"></center>
											      	<li>Click the Filter Data Button.</li>
											      	<center><img src="image/filter.png" class="img-responsive img-thumbnail"></center>
											      	<li>To refresh user data filter use Refrash button</li>
											      	<center><img src="image/refresh.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											      <hr />
											      <h4>Generate A Report:</h4>
											      <ol>
											      	<li>To print a report on manage user page click on Print Button.</li>
											      	<center><img src="image/print.png" class="img-responsive img-thumbnail"></center>
											      	<li>To export report as excel click on Export Button.</li>
											      	<center><img src="image/export.png" class="img-responsive img-thumbnail"></center>
											      </ol>
											    </div>
											  </div>
											    <hr>
		                </div>
		                
		                <!-- My Account search -->
		                <div class="bhoechie-tab-content">
		                	<h2>My Account</h2>
											  <ul class="nav nav-tabs">
											    <li class="active"><a href="#change_password">CHANGE PASSWORD</a></li>
											  </ul>
										    <div id="change_password" class="tab-pane fade in active">
										      <h4>Change Password Menu:</h4>
														<ol>
															<li>Click on Change Password Menu.</li>
															<center><img src="image/change_password_menu.png"  class="img-responsive img-thumbnail"></center><hr />
															<li>Give New Password and Repeat Password.</li>
															<li>Click Change Password Button.</li>
															<center><img src="image/change_password.png" class="img-responsive img-thumbnail"></center>
														</ol>
														<hr />
										    </div>
		                </div>
		            </div><!-- end .bhoechie-tab-->
		        </div><!-- end .bhoechie-tab-container-->
		  </div><!-- end .row -->
		</div><!-- end .container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/tab.js"></script>
  </body>
</html>
