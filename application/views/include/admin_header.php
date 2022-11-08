<?php
    $CI =& get_instance();
    $CI->load->model('Web_settings');
    $CI->load->model('Reports');
    $CI->load->model('Users');

    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
    $users = $CI->Users->profile_edit_data();
    $out_of_stock = $CI->Reports->out_of_stock_count();
    $out_of_date  = $CI->Reports->out_of_date_count();
?>
<!-- Admin header end -->
<header class="main-header" id="main-heades">
    <a href="<?php echo base_url()?>" class="logo"> <!-- Logo -->
        <span class="logo-mini">
            
            <img src="<?php if (isset($Web_settings[0]['favicon'])) {
               echo $Web_settings[0]['favicon']; }?>" alt="">
        </span>
        <span class="logo-lg">
            
            <img src="<?php if (isset($Web_settings[0]['logo'])) {
               echo $Web_settings[0]['logo']; }?>" alt="">
        </span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top text-center">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
            <span class="sr-only"><?php echo display('toggle_navigation')?></span>

            <span class="pe-7s-keypad"></span>
        </a>

        <?php
          $urcolp = '0';
          if($this->uri->segment(2) =="gui_pos" ){
            $urcolp = "gui_pos";
          }
          if($this->uri->segment(2) =="pos_invoice" ){
            $urcolp = "pos_invoice";
          }

           if($this->uri->segment(2) != $urcolp ){
          if($this->permission1->method('new_invoice','create')->access()){ ?>
           <a href="<?php echo base_url('Cinvoice/gui_pos')?>" class="btn btn-success btn-outline"><i class="fa fa-balance-scale"></i> <?php echo display('invoice') ?></a>
         <?php } ?>

       

        <?php
        if($this->permission1->method('manufacturer_payment','create')->access()){ ?>
          <a href="<?php echo base_url('accounts/manufacturer_payment')?>" class="btn btn-success btn-outline"><i class="fa fa-paypal" aria-hidden="true"></i> <?php echo 'Pay Supplier';?></a>
        <?php } ?>

       

        <?php
        if($this->permission1->method('add_purchase','create')->access()){ ?>
          <a href="<?php echo base_url('Cpurchase')?>" class="btn btn-success btn-outline"><i class="ti-shopping-cart"></i> <?php echo 'Buy Medicines'; ?></a>
        <?php }} ?>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                 
                <li class="dropdown notifications-menu">
                    <a href="<?php echo base_url('Creport/out_of_stock')?>" >
                        <i class="pe-7s-attention" title="<?php echo display('out_of_stock')?>"></i>
                        <span class="label label-danger"><?php echo html_escape($out_of_stock)?></span>
                    </a>
                </li>
                <!-- settings -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('Admin_dashboard/edit_profile')?>"><i class="pe-7s-users"></i><?php echo display('user_profile') ?></a></li>
                        <li><a href="<?php echo base_url('Admin_dashboard/change_password_form')?>"><i class="pe-7s-settings"></i><?php echo display('change_password') ?></a></li>
                        <li><a href="<?php echo base_url('Admin_dashboard/logout')?>"><i class="pe-7s-key"></i><?php echo display('logout') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="main-sidebar">
    <!-- sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel text-center">
            <div class="image">
                <img src="<?php echo $users[0]['logo']?>" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <p>Oscarina Tare</p>
                <a href="#"><i class="fa fa-circle text-success"></i> <?php echo display('online') ?></a>
            </div>
        </div>
        <!-- sidebar menu -->
        <ul class="sidebar-menu">

            <li class="<?php if ($this->uri->segment('1') == ("")) { echo "active";}else{ echo " ";}?>">

                <!-- DASHBOARD NAVIGATION BUTTON -->
                
            </li>


            <!-- INVOICES START -->
            <?php
             if($this->permission1->module('new_invoice')->access() || $this->permission1->module('manage_invoice')->access() || $this->permission1->module('pos_invoice')->access()|| $this->permission1->module('gui_pos')->access()) { ?>
                <li class="treeview <?php if ($this->uri->segment('1') == ("Cinvoice")) { echo "active";}else{ echo " ";}?>">
                    <a href="#">
                        <i class="fa fa-balance-scale"></i><span><?php echo display('invoice') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>

                    <ul class="treeview-menu">

                      

                        <?php
                        if($this->permission1->method('gui_pos','create')->access()) { ?>
                         <li  class="treeview <?php if ($this->uri->segment('2') == ("gui_pos")){
                        echo "active";
                            } else {
                                echo " ";
                            }?>"><a href="<?php echo base_url('Cinvoice/gui_pos')?>"><?php echo 'Sell Medicines'; ?></a></li>
                          <?php } ?>

                        <?php
                          if($this->permission1->method('manage_invoice','read')->access() || $this->permission1->method('manage_invoice','update')->access() || $this->permission1->method('manage_invoice','delete')->access()) { ?>
                            <li class="treeview <?php if ($this->uri->segment('2') == ("manage_invoice")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cinvoice/manage_invoice')?>"><?php echo display('manage_invoice') ?></a></li>
                        <?php } ?>


                       
                         </ul>
                      </li>
                        <?php } ?>
            <!-- Invoice menu end -->


            <!-- Customer menu start -->
            <?php
            if($this->permission1->module('add_customer')->access() || $this->permission1->module('manage_customer')->access() || $this->permission1->module('credit_customer')->access() || $this->permission1->module('paid_customer')->access()|| $this->permission1->module('customer_ledger')->access() || $this->permission1->module('customer_advance')->access()) { ?>
            <li class="treeview <?php if ($this->uri->segment('1') == ("Ccustomer")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="fa fa-handshake-o"></i><span><?php echo display('customer') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                     <ul class="treeview-menu">
                     <?php if($this->permission1->method('add_customer','create')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('1') == ("Ccustomer") && $this->uri->segment('2') == ("")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Ccustomer') ?>"><?php echo display('add_customer') ?></a></li>
                <?php } ?>
                <?php if($this->permission1->method('manage_customer','read')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("manage_customer")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Ccustomer/manage_customer') ?>"><?php echo display('manage_customer') ?></a></li>
            <?php } ?>

   
                </ul>
            </li>
            <?php } ?>
            <!-- Customer menu end -->

                   <!-- Product menu start -->
            <?php
            if($this->permission1->module('medicine_type')->access() || $this->permission1->module('add_medicine')->access() || $this->permission1->module('import_medicine_csv')->access() || $this->permission1->module('manage_medicine')->access() || $this->uri->segment('1') == ("Ccategory") || $this->permission1->module('add_category')->access()) { ?>
                <li class="treeview <?php if ($this->uri->segment('1') == "Cproduct" || $this->uri->segment('1') == ("Ccategory")) { echo "active";}else{ echo " ";}?>">
                    <a href="#">
                        <i class="ti-bag"></i><span><?php echo display('product') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                               <!-- Category menu start -->

           
                        <?php
                        if($this->permission1->method('add_category','create')->access() || $this->permission1->method('add_category','read')->access() || $this->permission1->method('add_category','update')->access() || $this->permission1->method('add_category','delete')->access()) { ?>
                          <li   class="treeview <?php if ($this->uri->segment('1') == ("Ccategory")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Ccategory')?>"><?php echo display('category') ?></a></li>
                     <?php } ?>
               
            <!-- Category menu end -->
                        <?php
                        if($this->permission1->method('medicine_type','create')->access() || $this->permission1->method('medicine_type','read')->access() || $this->permission1->method('medicine_type','update')->access() || $this->permission1->method('medicine_type','delete')->access()) { ?>
                         <li  class="treeview <?php if ($this->uri->segment('2') == ("typeindex")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cproduct/typeindex')?>"><?php echo display('product_type') ?></a></li>
                        <?php } ?>

                         <?php
            if($this->permission1->module('add_unit')->access() || $this->permission1->module('unit_list')->access()) { ?>
                <li class="treeview <?php if ($this->uri->segment('2') == ("unit_form") || $this->uri->segment('2') == ("unit_list")) { echo "active";}else{ echo " ";}?>">
                    <a href="#">
                        <i class="fa fa-universal-access"></i><span><?php echo display('unit') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                          <li   class="treeview <?php if ($this->uri->segment('1') == ("Cproduct") && $this->uri->segment('2') == ("unit_form")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cproduct/unit_form')?>"><?php echo display('add_unit') ?></a></li>

                     <li   class="treeview <?php if ($this->uri->segment('1') == ("Cproduct") && $this->uri->segment('2') == ("unit_list")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cproduct/unit_list')?>"><?php echo display('unit_list') ?></a></li>
                    </ul>
                </li>
            <?php } ?>

                        <?php
                        if($this->permission1->method('add_medicine','create')->access()) { ?>
                            <li class="treeview <?php if ($this->uri->segment('1') == ("Cproduct") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cproduct')?>"><?php echo display('add_product') ?></a></li>
                        <?php } ?>


                       


                        <?php
                        if($this->permission1->method('manage_medicine','read')->access() || $this->permission1->method('manage_medicine','update')->access() || $this->permission1->method('manage_medicine','delete')->access()) { ?>
                          <li class="treeview <?php if ($this->uri->segment('2') == ("manage_product")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cproduct/manage_product')?>"><?php echo display('manage_product') ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <!-- Product menu end -->

            <!-- manufacturer menu start -->
            <?php
            if($this->permission1->module('add_manufacturer')->access() || $this->permission1->module('manage_manufacturer')->access() || $this->permission1->module('manufacturer_ledger')->access() || $this->permission1->module('manufacturer_sales_details')->access()) { ?>
                <li class="treeview <?php if ($this->uri->segment('1') == ("Cmanufacturer")) {
                        echo "active";
                      } else {
                        echo " ";
                      } ?>">
                    <a href="#">
                        <i class="ti-user"></i><span><?php echo display('supplier') ?></span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                         <ul class="treeview-menu">
                     <?php if($this->permission1->method('add_manufacturer','create')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('1') == "Cmanufacturer" && $this->uri->segment('2') == "") {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cmanufacturer') ?>"><?php echo display('add_supplier') ?></a></li>
                <?php }?>
                  <?php if($this->permission1->method('manage_manufacturer','read')->access()){ ?>
                    <li class="treeview <?php
            if ( $this->uri->segment('2') == "manage_manufacturer") {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cmanufacturer/manage_manufacturer') ?>"><?php echo display('manage_supplier') ?></a></li>
                    <?php } ?>

                    
                </ul>
                </li>
                <?php
                }
                ?>
            <!-- manufacturer menu end -->


            <!-- Purchase menu start --> 
            <?php
            if($this->permission1->module('add_purchase')->access() || $this->permission1->module('manage_purchase')->access()){ ?>
             <li class="treeview <?php if ($this->uri->segment('1') == ("Cpurchase")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-shopping-cart"></i><span><?php echo "Buy Medicines"; ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    if($this->permission1->method('add_purchase','create')->access()){ ?>
                      <li class="treeview <?php  if ($this->uri->segment('1') == ("Cpurchase") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpurchase')?>"><?php echo display('add_purchase') ?></a></li>
                    <?php
                    } ?>

                    <?php
                    if($this->permission1->method('manage_purchase','read')->access() || $this->permission1->method('manage_purchase','update')->access() || $this->permission1->method('manage_purchase','delete')->access()){ ?>
                        <li  class="treeview <?php  if ($this->uri->segment('2') == ("manage_purchase")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpurchase/manage_purchase')?>"><?php echo display('manage_purchase') ?></a></li>
                    <?php
                     }
                    ?>
                </ul>
             </li>
           <?php } ?>
            <!-- Purchase menu end -->
             <!-- stock menu start -->
              <?php
            if($this->permission1->module('stock_report')->access() || $this->permission1->module('stock_report_manufacturer_wise')->access() || $this->permission1->module('stock_report_product_wise')->access() || $this->permission1->module('stock_report_batch_wise')->access()){ ?>
            <!-- Stock menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Creport")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-bar-chart"></i><span><?php echo display('stock') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    if($this->permission1->method('stock_report','read')->access()){ ?>
                      <li class="treeview <?php  if ($this->uri->segment('1') == ("Creport") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Creport')?>"><?php echo display('stock_report') ?></a></li>
                    <?php } ?>

                
                    <?php
                    if($this->permission1->method('stock_report_batch_wise','read')->access()){ ?>
                      <li class="treeview <?php  if ($this->uri->segment('2') == ("stock_report_batch_wise")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Creport/stock_report_batch_wise')?>"><?php echo display('stock_report_batch_wise') ?></a></li>
                    <?php } ?>

                </ul>
            </li>
           <?php
             }
           ?>
            <!-- Stock menu end -->

              <!-- start return -->
           <?php
             if($this->permission1->module('return')->access() || $this->permission1->module('stock_return_list')->access() || $this->permission1->module('manufacturer_return_list')->access() || $this->permission1->module('wastage_return_list')->access() ){ ?>
              <li class="treeview <?php if ($this->uri->segment('1') == ("Cretrun_m")) { echo "active";}else{ echo " ";}?>">

                <!-- REMOVE COMMENT PARA NAAY RETURN SA STOCK BUTTON -->
                

                <!-- REMOVE PARA DISPLAY ANG SULOD SA RETURN BUTTON -->
               
              </li>
           <?php
             }
           ?>
           
            <!-- Report menu start -->
             <?php if($this->permission1->module('add_closing')->access() || $this->permission1->module('date_wise_closing_reports')->access() || $this->permission1->module('closing_report')->access() || $this->permission1->module('todays_report')->access() || $this->permission1->module('sales_report')->access() || $this->permission1->module('purchase_report')->access() || $this->permission1->module('sales_report_medicine_wise')->access() || $this->permission1->module('profit_loss')->access()){ ?>
                <!-- Report menu start -->
            <li class="treeview <?php if ($this->uri->segment('2') == ("all_report") || $this->uri->segment('2') == ("todays_sales_report") || $this->uri->segment('2') == ("todays_purchase_report") || $this->uri->segment('2') == ("product_sales_reports_date_wise") || $this->uri->segment('2') == ("total_profit_report") || $this->uri->segment('2') == ("profit_manufacturer_form") || $this->uri->segment('2') == ("profit_productwise_form") || $this->uri->segment('2') == ("profit_productwise") || $this->uri->segment('2') == ("profit_manufacturer") || $this->uri->segment('2') == ("closing") || $this->uri->segment('2') == ("closing_report") || $this->uri->segment('2') == ("date_wise_closing_reports") ) { echo "active";}else{ echo " ";}?>">

                

                <ul class="treeview-menu">
                         <?php if($this->permission1->method('add_closing','create')->access()){ ?>


                    <!-- CLOSING BUTTON -->

                    <!--<li class="treeview <?php if ($this->uri->segment('2') == ("closing")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/closing') ?>"><?php echo display('closing') ?></a></li>
                  <?php } ?>-->


                   


                    <?php
                    if($this->permission1->method('todays_report','read')->access()){ ?>
                      <li class="treeview <?php  if ($this->uri->segment('2') == ("all_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/all_report')?>"><?php echo display('todays_report') ?></a></li>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('sales_report','read')->access()){ ?>
                       <li class="treeview <?php  if ($this->uri->segment('2') == ("todays_sales_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/todays_sales_report')?>"><?php echo display('sales_report') ?></a></li>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('purchase_report','read')->access()){ ?>
                      <li class="treeview <?php  if ($this->uri->segment('2') == ("todays_purchase_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/todays_purchase_report')?>"><?php echo display('purchase_report') ?></a></li>
                    <?php } ?>

                    <!-- REPORT BY MEDICINE -->
                    


                     <!-- PROFIT REPORTS BY DAYS,WEEKS,MONTHS REMOVE THE COMMENT IF GUSTO NAAY DISPLAY -->
                    
           
                </ul>
            </li>
            <?php } ?>
            <!-- Report menu end -->

            <!-- human resource management menu start -->
             <?php if($this->permission1->method('add_designation','create')->access() || $this->permission1->method('manage_designation','read')->access() || $this->permission1->method('add_employee','create')->access() || $this->permission1->method('manage_employee','read')->access() || $this->permission1->method('add_attendance','create')->access() || $this->permission1->method('manage_attendance','read')->access()|| $this->permission1->method('attendance_report','read')->access() || $this->permission1->method('add_benefits','create')->access() || $this->permission1->method('manage_benefits','read')->access() || $this->permission1->method('add_salary_setup','create')->access() || $this->permission1->method('manage_salary_setup','read')->access() || $this->permission1->method('salary_generate','create')->access() || $this->permission1->method('manage_salary_generate','read')->access() || $this->permission1->method('salary_payment','create')->access() || $this->permission1->method('add_fixed_assets','create')->access() || $this->permission1->method('fixed_assets_list','read')->access() || $this->permission1->method('fixed_assets_purchase','create')->access() || $this->permission1->method('fixed_assets_purchase_manage','read')->access() || $this->permission1->method('fixed_assets_location_transfer','create')->access() || $this->permission1->method('manage_assets_location_transfer','read')->access() || $this->permission1->method('asset_stock','read')->access() || $this->permission1->module('personal_add_person')->access() || $this->permission1->module('personal_add_loan')->access() || $this->permission1->module('personal_add_payment')->access() || $this->permission1->module('personal_manage_loan')->access() || $this->permission1->module('office_add_person')->access() || $this->permission1->module('office_manage_loan')->access()){?>
            <!-- Supplier menu start -->
       <li class="treeview <?php
            if ($this->uri->segment('1') == ("Chrm") || $this->uri->segment('1') == ("Cattendance") || $this->uri->segment('1') == ("Cpayroll") || $this->uri->segment('1') == ("Cexpense") || $this->uri->segment('1') == ("Fixedassets") || $this->uri->segment('2') == ("add_person") || $this->uri->segment('2') == ("add_loan") || $this->uri->segment('2') == ("add_payment") || $this->uri->segment('2') == ("person_loan_edit") || $this->uri->segment('2') == ("manage_person") ||  $this->uri->segment('2') == ("manage_loans")|| $this->uri->segment('2') == ("person_loan_deails") || $this->uri->segment('2') == ("add1_person") || $this->uri->segment('2') == ("manage1_person") || $this->uri->segment('1') == ("Cloan")|| $this->uri->segment('2') == ("person_ledger")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
               
                <ul class="treeview-menu">
                    <li class="treeview <?php
            if ($this->uri->segment('1') == ("Chrm")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-users"></i><span><?php echo display('hrm') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
         <?php if($this->permission1->method('add_designation','create')->access()){ ?>           
            <li class="treeview <?php  if ($this->uri->segment('2') == ("add_designation")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/add_designation') ?>"><?php echo display('add_designation') ?></a></li>
     <?php } ?>
         <?php if($this->permission1->method('manage_designation','read')->access()){ ?>
                         <li class="treeview <?php  if ($this->uri->segment('2') == ("manage_designation")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/manage_designation') ?>"><?php echo display('manage_designation') ?></a></li>
                          <?php } ?>
        <?php if($this->permission1->method('add_employee','create')->access()){ ?>
                         <li class="treeview <?php  if ($this->uri->segment('2') == ("add_employee")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/add_employee') ?>"><?php echo display('add_employee') ?></a></li>
                    <?php } ?>
            <?php if($this->permission1->method('manage_employee','read')->access()){ ?>        
                         <li  class="treeview <?php  if ($this->uri->segment('2') == ("manage_employee")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/manage_employee') ?>"><?php echo display('manage_employee') ?></a></li> 
                          <?php } ?> 
                 
                </ul>
            </li>
                        <?php
            if($this->permission1->module('office_add_person')->access() || $this->permission1->module('office_manage_loan')->access()){ ?>
            <!-- Personal loan start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Cloan")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                   <i class="fa fa-university" aria-hidden="true"></i>

                    <span><?php echo display('office_loan') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                  <ul class="treeview-menu">
                     <?php if($this->permission1->method('add_ofloan_person','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_ofloan_person")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/add_ofloan_person') ?>"><?php echo display('add_person') ?></a></li>
                <?php }?>
                 <?php if($this->permission1->method('add_office_loan','create')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("add_office_loan")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/add_office_loan') ?>"><?php echo display('add_loan') ?></a></li>
                  <?php }?>
                   <?php if($this->permission1->method('add_loan_payment','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_loan_payment")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/add_loan_payment') ?>"><?php echo display('add_payment') ?></a></li>
                <?php }?>
                 <?php if($this->permission1->method('manage_ofln_person','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("manage_ofln_person")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/manage_ofln_person') ?>"><?php echo display('manage_person') ?></a></li>
                <?php }?>
                </ul>
            </li>
            <?php } ?>
                </ul>
            </li>

            
        <?php } ?>

            <!-- Human Resource management menu end -->

                    <!-- supplier menu start -->
            <?php
            if($this->permission1->module('add_supplier')->access() || $this->permission1->module('manage_supplier')->access() || $this->permission1->module('supplier_ledger')->access() || $this->permission1->module('supplier_sales_details')->access()) { ?>
                <li class="treeview <?php if ($this->uri->segment('1') == ("Csupplier")) {
                        echo "active";
                      } else {
                        echo " ";
                      } ?>">

                    <!-- REMOVE COMMENT IF NEED MAGPA DISPLAY OG SUPPLIER -->
                    

                    <ul class="treeview-menu">
                        <?php
                        if($this->permission1->method('add_supplier','create')->access()) { ?>
                             <li  class="treeview <?php  if ($this->uri->segment('1') == ("Csupplier") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csupplier') ?>"><?php echo display('add_supplier') ?></a></li>
                        <?php } ?>

                        <?php
                        if($this->permission1->method('manage_supplier','read')->access() || $this->permission1->method('manage_supplier','update')->access() || $this->permission1->method('manage_supplier','delete')->access()) { ?>
                            <li  class="treeview <?php  if ($this->uri->segment('2') == ("manage_supplier")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csupplier/manage_supplier') ?>"><?php echo display('manage_supplier') ?></a></li>
                        <?php } ?>

                        <?php
                        if($this->permission1->method('supplier_ledger','read')->access() || $this->permission1->method('supplier_ledger','update')->access() || $this->permission1->method('supplier_ledger','delete')->access()) { ?>
                            <li class="treeview <?php  if ($this->uri->segment('2') == ("supplier_ledger_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csupplier/supplier_ledger_report') ?>"><?php echo display('supplier_ledger') ?></a></li>
                        <?php } ?>

               

                    </ul>
                </li>
                <?php
                }
                ?>
            <!-- manufacturer menu end -->

             <!-- Purchase menu end -->
              <?php if($this->permission1->method('create_service','create')->access() || $this->permission1->method('manage_service','read')->access() || $this->permission1->method('service_invoice','create')->access() || $this->permission1->method('manage_service_invoice','read')->access()){?>

            <!-- Service menu start -->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cservice")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <ul class="treeview-menu">
                    <?php if($this->permission1->method('create_service','create')->access()){ ?>
                    <li class="treeview <?php  if ($this->uri->segment('1') == ("Cservice") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cservice') ?>"><?php echo display('add_service') ?></a></li>
                <?php } ?>
                 <?php if($this->permission1->method('manage_service','read')->access()){ ?>
                    <li class="treeview <?php  if ($this->uri->segment('2') == ("manage_service")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cservice/manage_service') ?>"><?php echo display('manage_service') ?></a></li>
                      <?php } ?>
                       <?php if($this->permission1->method('service_invoice','create')->access()){ ?>
                       <li class="treeview <?php  if ($this->uri->segment('2') == ("service_invoice_form")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cservice/service_invoice_form') ?>"><?php echo display('service_invoice') ?></a></li>
                       <?php } ?>
                        <?php if($this->permission1->method('manage_service_invoice','read')->access()){ ?>
                       <li class="treeview <?php  if ($this->uri->segment('2') == ("manage_service_invoice")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cservice/manage_service_invoice') ?>"><?php echo display('manage_service_invoice') ?></a></li>
                       <?php } ?>
                </ul>
            </li>
        <?php } ?>

         <!-- Search menu start            -->
            <!-- Search menu start -->
            <?php
            if($this->permission1->module('medicine_search')->access() || $this->permission1->module('customer_search')->access() || $this->permission1->module('invoice_search')->access() || $this->permission1->module('purcahse_search')->access() ){ ?>

             <li class="treeview <?php if ($this->uri->segment('1') == ("Csearch")) { echo "active";}else{ echo " ";}?>">
                
                <ul class="treeview-menu">
                    <?php
                    if($this->permission1->method('medicine_search','read')->access()){ ?>
                       <li class="treeview <?php  if ($this->uri->segment('2') == ("medicine")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csearch/medicine')?>"><?php echo display('medicine') ?></a></li>
                    <?php
                    }
                    ?>

                    <?php
                    if($this->permission1->method('customer_search','read')->access()){ ?>
                    <li class="treeview <?php  if ($this->uri->segment('2') == ("customer")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csearch/customer')?>"><?php echo display('customer') ?> </a></li>
                    <?php
                    }
                    ?>

                    <?php
                    if( $this->permission1->method('invoice_search','read')->access()){ ?>
                        <li class="treeview <?php  if ($this->uri->segment('2') == ("invoice")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csearch/invoice')?>"><?php echo display('invoice') ?> </a></li>
                        <?php
                    }
                    ?>

                    <?php
                    if($this->permission1->method('purcahse_search','read')->access() ){ ?>
                        <li class="treeview <?php  if ($this->uri->segment('2') == ("purchase")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csearch/purchase')?>"><?php echo display('purchase') ?> </a></li>
                        <?php
                    }
                    ?>

                </ul>
             </li>
            <?php
            }
            ?>
        
            <!-- Software Settings menu start -->
            <?php
            if($this->permission1->module('manage_company')->access() || $this->permission1->module('add_user')->access() || $this->permission1->module('manage_users')->access() || $this->permission1->module('language')->access() || $this->permission1->module('setting')->access() || $this->permission1->module('user_assign_role')->access() || $this->permission1->module('permission')->access() || $this->permission1->module('add_role')->access() || $this->permission1->module('role_list')->access() || $this->permission1->method('configure_sms','create')->access() || $this->permission1->method('configure_sms','update')->access() || $this->permission1->module('data_setting')->access() || $this->permission1->module('synchronize')->access() || $this->permission1->module('backup_and_restore')->access()){ ?>

                 <li class="treeview <?php if ($this->uri->segment('1') == ("Company_setup") || $this->uri->segment('1') == ("User") || $this->uri->segment('1') == ("Cweb_setting") || $this->uri->segment('1') == ("Language")|| $this->uri->segment('1') == ("Currency") || $this->uri->segment('1') == ("Permission") || $this->uri->segment('1') == ("Csms") || $this->uri->segment('1') == ("Backup_restore")) { echo "active";}else{ echo " ";}?>">
              
              <!-- REMOVE COMMENT BELLOW PARA MO DISPLAY ANG SETTINGS -->
              
                <a href="#">
                    <!-- <i class="ti-settings"></i><span><?php echo display('settings') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span> -->

                <ul class="treeview-menu">
                               <li class="treeview <?php if ($this->uri->segment('1') == ("Company_setup") || $this->uri->segment('1') == ("User") || $this->uri->segment('1') == ("Cweb_setting") || $this->uri->segment('1') == ("Language")|| $this->uri->segment('1') == ("Currency") ) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <span><?php echo display('web_settings') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    <?php
                    if($this->permission1->method('manage_company','read')->access() || $this->permission1->method('manage_company','update')->access()){ ?>
                      <li class="treeview <?php  if ($this->uri->segment('2') == ("manage_company")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Company_setup/manage_company')?>"><?php echo display('manage_company') ?></a></li>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('add_user','create')->access()){ ?>
                      <li class="treeview <?php  if ($this->uri->segment('1') == ("User") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('User')?>"><?php echo display('add_user') ?></a></li>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('manage_users','read')->access() || $this->permission1->method('manage_users','update')->access() || $this->permission1->method('manage_users','delete')->access()){ ?>
                      <li class="treeview <?php  if ($this->uri->segment('2') == ("manage_user")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('User/manage_user')?>"><?php echo display('manage_users') ?> </a></li>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('language','create')->access() || $this->permission1->method('language','read')->access() || $this->permission1->method('add_phrase','read')->access() || $this->permission1->method('add_phrase','update')->access()){ ?>
                        <li class="treeview <?php  if ($this->uri->segment('1') == ("Language") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Language')?>"><?php echo display('language') ?> </a></li>
                    <?php } ?>
                    <?php
                    if($this->permission1->method('currency','create')->access()){ ?>
                       <li  class="treeview <?php  if ($this->uri->segment('1') == ("Currency") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Currency') ?>"><?php echo display('currency') ?> </a></li>
                   <?php }?>
                    <?php
                    if($this->permission1->method('soft_setting','read')->access() || $this->permission1->method('soft_setting','update')->access()){ ?>
                        <li  class="treeview <?php  if ($this->uri->segment('1') == ("Cweb_setting") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cweb_setting')?>"><?php echo display('setting') ?> </a></li>
                    <?php } ?>


                </ul>
            </li>


            <?php
            if($this->permission1->module('user_assign_role')->access() || $this->permission1->module('permission')->access() || $this->permission1->module('add_role')->access() || $this->permission1->module('role_list')->access()){ ?>
            <!-- Role-permission menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Permission")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <span><?php echo display('role_permission') ?></span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    if($this->permission1->method('add_role','create')->access() || $this->permission1->method('add_role','read')->access() || $this->permission1->method('add_role','update')->access() || $this->permission1->method('add_role','delete')->access()){ ?>
                        <li class="treeview <?php  if ($this->uri->segment('2') == ("add_role")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Permission/add_role')?>"><?php echo display('add_role') ?></a></li>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('role_list','read')->access() || $this->permission1->method('role_list','update')->access() || $this->permission1->method('role_list','delete')->access()){ ?>
                        <li class="treeview <?php  if ($this->uri->segment('2') == ("role_list")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Permission/role_list')?>"><?php echo display('role_list') ?></a></li>
                    <?php } ?>



                    <?php
                    if($this->permission1->method('user_assign_role','create')->access() || $this->permission1->method('user_assign_role','read')->access()){ ?>
                        <li class="treeview <?php  if ($this->uri->segment('2') == ("user_assign")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Permission/user_assign')?>"><?php echo display('user_assign_role')?></a></li>
                    <?php } ?>

               


                </ul>
            </li>
            <?php } ?>


                        <!-- Sms setting start -->
             <?php if($this->permission1->method('configure_sms','create')->access() || $this->permission1->method('configure_sms','update')->access()){?>
            
         <li class="treeview <?php if ($this->uri->segment('1') == ("Csms")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <span><?php echo display('sms'); ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                
                      <li class="treeview <?php  if ($this->uri->segment('2') == ("configure")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csms/configure')?>"><?php echo display('sms_configure'); ?></a></li>
                     
 
                </ul>
             </li>
         <?php }?>
         
            <!-- Sms Setting end -->

            <!-- Synchronizer setting start -->
            <?php
            if($this->permission1->module('data_setting')->access() || $this->permission1->module('synchronize')->access() || $this->permission1->module('backup_and_restore')->access()){ ?>
                <li class="treeview <?php if ($this->uri->segment('2') == ("form") || $this->uri->segment('2') == ("synchronize") || $this->uri->segment('1') == ("Backup_restore")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <span><?php echo display('data_synchronizer') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                     <ul class="treeview-menu">
                
                    <?php if($this->permission1->method('restore','create')->access()){ ?>
           <li class="treeview <?php if ($this->uri->segment('2') == ("restore_form")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Backup_restore/restore_form') ?>"><?php echo display('restore') ?></a></li>
           <?php }?>
                 <?php if($this->permission1->method('sql_import','create')->access()){ ?>
                <li class="treeview <?php if ($this->uri->segment('2') == ("import_form")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Backup_restore/import_form') ?>"><?php echo display('import') ?></a></li>
                <?php }?>

                     <li class="treeview <?php if ($this->uri->segment('2') == ("backup_create")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Backup_restore/download') ?>"><?php echo display('backup') ?></a></li>
                </ul>
            </li>
            <?php } ?>
            <!-- Synchronizer setting end -->
             <li><a href="https://pressdy.lovestoblog.com" target="blank"><i class="fa fa-question-circle"></i> Support</a></li>
                </ul>
            </li>
 
            <?php } ?>
            <!-- Software Settings menu end -->
        
        </ul>
    </div> <!-- /.sidebar -->
</aside>