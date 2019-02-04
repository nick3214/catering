
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" style="background:#f4f4f4;color:black;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header" style="background: #069;color:white;">MAIN NAVIGATION</li>
        <li class="active">
          <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
        </li>
        <?php if($_SESSION['user_role'] == '0'):?>
        <li>
          <a href="calendar.php"><i class="fa fa-calendar"></i> <span>Calendar</span> </a>
        </li>
         <li>
          <a href="messages.php"><i class="fa fa-envelope"></i> <span>Messages 
               <span class="label label-success">1</span>
          </span> </a>
        </li>
        <li>
          <a href="customer.php"><i class="fa fa-users"></i> Customers </a>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-plus"></i>
            <span>File Maintenance</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!-- <li><a href="paluto_menu.php"><i class="fa fa-circle-o"></i> Paluto Menu</a></li>
            <li><a href="paluto_package.php"><i class="fa fa-circle-o"></i> Paluto Package</a></li> -->
            <li><a href="additional.php"><i class="fa fa-circle-o"></i> Additional</a></li>
            <li><a href="amenities.php"><i class="fa fa-circle-o"></i> Other Services</a></li>
            <li><a href="food_categories.php"><i class="fa fa-circle-o"></i> Category</a></li>
             <li><a href="sub_category.php"><i class="fa fa-circle-o"></i> Sub Category</a></li>
            <!--
            <li><a href="menu.php"><i class="fa fa-circle-o"></i> Menus</a></li>
          -->
            <li><a href="food_items.php"><i class="fa fa-circle-o"></i> Menu</a></li>
            <!--
            <li><a href="package_types.php"><i class="fa fa-circle-o"></i> Package Type</a></li>
          -->
            <li><a href="packages.php"><i class="fa fa-circle-o"></i> Packages</a></li>
            
            <li><a href="freebies.php"><i class="fa fa-circle-o"></i> Freebie List</a></li>
          
          
            <li><a href="occasion.php"><i class="fa fa-circle-o"></i> Occasion</a></li>
            <li><a href="motif.php"><i class="fa fa-circle-o"></i> Motif</a></li>
          
            <!--
            <li><a href="staff.php"><i class="fa fa-circle-o"></i> System User</a></li>
            -->
            <li><a href="photo.php"><i class="fa fa-circle-o"></i> Front End Photo</a></li>
            <!--
            <li><a href="city.php"><i class="fa fa-circle-o"></i> City</a></li>
            <li><a href="contact.php"><i class="fa fa-circle-o"></i> Contact Us</a></li>
          -->
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i>
            <span>Reservations</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="online-reservation.php"><i class="fa fa-circle-o"></i> Online Reservations</a></li>
             <li><a href="paluto.php"><i class="fa fa-circle-o"></i> Paluto</a></li>
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-calendar"></i>
            <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li><a href="print-amenities.php"><i class="fa fa-circle-o"></i> Other Services</a></li>

            <li><a href="print-sales.php"><i class="fa fa-circle-o"></i> Sales Report</a></li>
            <li><a href="print-cancel.php"><i class="fa fa-circle-o"></i> Cancelled Reports</a></li>
            <li><a href="print-customer.php"><i class="fa fa-circle-o"></i> Customers</a></li>

            <li><a href="print-package.php"><i class="fa fa-circle-o"></i> Packages</a></li>
            <li><a href="print-items.php"><i class="fa fa-circle-o"></i> Menu</a></li>
             
          <li><a href="print-products.php"><i class="fa fa-circle-o"></i> Freebies</a></li>
          <li><a href="preview-occassion.php" target="_blank"><i class="fa fa-circle-o"></i> Occassion</a></li>
          <li><a href="preview-motif.php" target="_blank"><i class="fa fa-circle-o"></i> Motif</a></li>
            <li><a href="print-resched.php"><i class="fa fa-circle-o"></i> Re-scheduled Reports</a></li>
            
          </ul>
        </li>
        <!--
        <li>
          <a href="themes.php"><i class="fa fa-list"></i> <span>Themes</span> </a>
        </li>
      -->
        <li>
          <a href="settings.php"><i class="fa fa-wrench"></i> <span>Settings</span> </a>
        </li>
        <?php else:?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-calendar"></i>
            <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href=""><i class="fa fa-circle-o"></i> Amenities</a></li>
            <li><a href=""><i class="fa fa-circle-o"></i> Cancelled Reservations</a></li>
            <li><a href=""><i class="fa fa-circle-o"></i> Customers</a></li>
            <li><a href=""><i class="fa fa-circle-o"></i> Payments</a></li>
            <li><a href=""><i class="fa fa-circle-o"></i> Packages</a></li>
            <li><a href=""><i class="fa fa-circle-o"></i> Menus</a></li>
            <li><a href=""><i class="fa fa-circle-o"></i> Re-scheduled Reservations</a></li>
            
          </ul>
        </li>
        <li><a href="walkin-reservation.php"><i class="fa fa-circle-o"></i> Walkin Reservations</a></li>
        <?php endif;?>
        <li>
          <!--
          <a href="terms.php"><i class="fa fa-file"></i> <span>Terms and Conditions</span> </a>
        -->
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>