<?php
include('db.php');
   include('db_config.php');
   session_start();
   if(isset($_SESSION["username"]))
   {
    $AdminName = $_SESSION["username"];
     $user_id = $_SESSION["discount_rate"];
     $role = $_SESSION["roledata"];
     $designationrole = $_SESSION["designation_role"];
     $m_3 = $_SESSION["m_3"];
     $m_2 = $_SESSION["m_2"];

     if($designationrole=='M3'){
       $m_3 = $AdminName;
       $m_2 = "";
     }
     if($designationrole=='M2'){
       $m_3 = $m_3;
       $m_2 = $AdminName;
     }
     if($designationrole=='M1'){
       $m_3 = $m_3;
       $m_2 = $m_2;
     }
     $query = "SELECT * FROM login WHERE id = :id";

     $statement = $connect->prepare($query);

     $statement->execute(
          array(
                ':id'       =>    $dis
          )
     );

     $result = $statement->fetchAll();
      foreach ($result as $test)
      $dis_prsent = $test['discount_rate'];

   try{
   $statement = $connect->prepare("SELECT * FROM inv_order ORDER BY order_id DESC");

   $statement->execute();

   $all_result = $statement->fetchAll();

   $total_rows = $statement->rowCount();

   if(isset($_POST["create_invoice"]))
   {
  //  echo "<pre>"; print_r($_POST); echo "</pre>";
  // die();
     $chestate = $_POST["state_name"];
     $oldbill = $_POST["oldbill"];
     //$gststatecode = trim($_POST["gststatecode"]);
    // $gst_no = trim($_POST["gst_no"]);
    // $finalgstcode = $gststatecode.$gst_no;
     $randnam = rand(10,100);
     $invoice_no = "GEI-$randnam";
     $order_total_before_tax = 0;
     $order_total_tax1 = 0;
     $order_total_tax2 = 0;
     $order_total_tax3 = 0;
     $order_total_tax = 0;
     $order_total_after_tax = 0;
     $total_discount_amount = 0;
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (empty($oldbill)) {
      $statement = $connect->prepare("INSERT INTO inv_order (M3, M2, order_date, order_receiver_name, client_name, contact_no, order_receiver_address, remarks, state_name, gst_no, payoption, checq_no, bank_name, upi_id, nfet_no, order_total_before_tax, order_total_tax1, order_total_tax2, order_total_tax3, order_total_tax, order_total_after_tax, total_discount_amount, created_by, order_datetime) VALUES (:M3, :M2, :order_date, :order_receiver_name, :client_name, :contact_no, :order_receiver_address, :remarks, :state_name, :gst_no, :payoption, :checq_no, :bank_name, :upi_id, :nfet_no, :order_total_before_tax, :order_total_tax1, :order_total_tax2, :order_total_tax3, :order_total_tax, :order_total_after_tax, :total_discount_amount, :created_by, :order_datetime)");

         $statement->execute(
           array(
               ':M3'                          => $m_3,
               ':M2'                          => $m_2,
               ':order_date'                 =>  trim($_POST["order_date"]),
               ':order_receiver_name'        =>  trim($_POST["order_receiver_name"]),
               ':client_name'                =>  trim($_POST["client_name"]),
               ':contact_no'                 =>  trim($_POST["contact_no"]),
               ':order_receiver_address'     =>  trim($_POST["order_receiver_address"]),
               ':remarks'                    =>  trim($_POST["remarks"]),
               ':state_name'                 =>  trim($_POST["state_name"]),
               ':gst_no'                     =>  trim($_POST["gst_no"]),
               ':payoption'                  =>  trim($_POST["payoption"]),
               ':checq_no'                   =>  trim($_POST["checq_no"]),
               ':bank_name'                  =>  trim($_POST["bank_name"]),
               ':upi_id'                     =>  trim($_POST["upi_id"]),
               ':nfet_no'                    =>  trim($_POST["nfet_no"]),
               ':order_total_before_tax'     => $order_total_before_tax,
               ':order_total_tax1'           => $order_total_tax1,
               ':order_total_tax2'           => $order_total_tax2,
               ':order_total_tax3'           => $order_total_tax3,
               ':order_total_tax'            => $order_total_tax,
               ':order_total_after_tax'      => $order_total_after_tax,
               ':total_discount_amount'      => $total_discount_amount,
               ':created_by'                 => $AdminName,
               ':order_datetime'             =>  time()
           )
         );
         $statement = $connect->query("SELECT LAST_INSERT_ID()");
         $orderId = $statement->fetchColumn();
     }

     if (!empty($oldbill)) {

       $statement = $connect->prepare("INSERT INTO inv_order (order_id, M3, M2, order_date, order_receiver_name, client_name, contact_no, order_receiver_address, remarks, state_name, gst_no, payoption, checq_no, bank_name, upi_id, nfet_no, order_total_before_tax, order_total_tax1, order_total_tax2, order_total_tax3, order_total_tax, order_total_after_tax, total_discount_amount, created_by, order_datetime) VALUES (:order_id, :M3, :M2, :order_date, :order_receiver_name, :client_name, :contact_no, :order_receiver_address, :remarks :state_name, :gst_no, :payoption, :checq_no, :bank_name, :upi_id, :nfet_no, :order_total_before_tax, :order_total_tax1, :order_total_tax2, :order_total_tax3, :order_total_tax, :order_total_after_tax, :total_discount_amount, :created_by, :order_datetime)");

          $statement->execute(
            array(
                ':order_id'                   =>         $oldbill,
                ':M3'                         =>         $m_3,
                ':M2'                         =>         $m_2,
                ':order_date'                 =>        trim($_POST["order_date"]),
                ':order_receiver_name'        =>        trim($_POST["order_receiver_name"]),
                ':client_name'                =>        trim($_POST["client_name"]),
                ':contact_no'                 =>        trim($_POST["contact_no"]),
                ':order_receiver_address'     =>        trim($_POST["order_receiver_address"]),
                ':remarks'                    =>        trim($_POST["remarks"]),
                ':state_name'                 =>        trim($_POST["state_name"]),
                ':gst_no'                     =>        trim($_POST["gst_no"]),
                ':payoption'                  =>        trim($_POST["payoption"]),
                ':checq_no'                   =>        trim($_POST["checq_no"]),
                ':bank_name'                  =>        trim($_POST["bank_name"]),
                ':upi_id'                     =>        trim($_POST["upi_id"]),
                ':nfet_no'                    =>        trim($_POST["nfet_no"]),
                ':order_total_before_tax'     =>        $order_total_before_tax,
                ':order_total_tax1'           =>        $order_total_tax1,
                ':order_total_tax2'           =>        $order_total_tax2,
                ':order_total_tax3'           =>        $order_total_tax3,
                ':order_total_tax'            =>        $order_total_tax,
                ':order_total_after_tax'      =>        $order_total_after_tax,
                ':total_discount_amount'      =>        $total_discount_amount,
                ':created_by'                 =>        $AdminName,
                ':order_datetime'             =>        time()
            )
          );

          $orderId = $oldbill;
     }


       $qty = $_POST["as_qunty"];
       $price = $_POST["as_price"];
       $state = $_POST["state_name"];
       $actul = $qty * $price;
       if($state == 'Haryana(06)'){
         $cgst_rate = '9';
         $sgst_rate =   '9';
         $igst_rate =   '0';
         $igst_amount = '0';
         $cgst_amount = $actul * 9/100;
         $sgst_amount = $actul * 9/100;
         $total_price = $actul + $sgst_amount + $cgst_amount;
       } else{
         $cgst_rate = '0';
         $sgst_rate = '0';
         $cgst_amount = '0';
         $sgst_amount = '0';
         $igst_rate = '18';
         $igst_amount = $actul * 18/100;
         $total_price = $actul + $igst_amount;

       }

       $statement = $connect->prepare("
       INSERT INTO additional_service
       (order_id, as_name, as_price, as_actulprice, as_qunty, cgst_rate, sgst_rate, cgst_amount, sgst_amount, igst_rate, igst_amount, total_price) VALUES (:order_id, :as_name, :as_price, :as_actulprice, :as_qunty, :cgst_rate, :sgst_rate, :cgst_amount, :sgst_amount, :igst_rate, :igst_amount, :total_price)
       ");
       $statement->execute(
         array(
           ':order_id'         => $orderId,
           ':as_name'          => $_POST["As_name"],
           ':as_price'         => $_POST["as_price"],
           ':as_qunty'         => $_POST["as_qunty"],
           ':cgst_rate'        =>  $cgst_rate,
           ':sgst_rate'        =>  $sgst_rate,
           ':cgst_amount'      =>  $cgst_amount,
           ':sgst_amount'      =>  $sgst_amount,
           ':igst_rate'        =>  $igst_rate,
           ':igst_amount'      =>  $igst_amount,
           ':total_price'      =>  $total_price,
           ':as_actulprice'    =>  $actul,
         )
       );


       for($count=0; $count<$_POST["total_item"]; $count++)
       {
         $order_total_before_tax = $order_total_before_tax + floatval(trim($_POST["order_item_actual_amount"][$count]));

         $order_total_tax1 = $order_total_tax1 + floatval(trim($_POST["order_item_tax1_amount"][$count]));

         $order_total_tax2 = $order_total_tax2 + floatval(trim($_POST["order_item_tax2_amount"][$count]));

         $order_total_tax3 = $order_total_tax3 + floatval(trim($_POST["order_item_tax3_amount"][$count]));

         $total_discount_amount = $total_discount_amount + floatval(trim($_POST["discount_amount"][$count]));

         $order_total_after_tax = $order_total_after_tax + floatval(trim($_POST["order_item_final_amount"][$count]));

         $statement = $connect->prepare("
           INSERT INTO inv_order_item
           (order_id, service_type, item_name, hsn_code, order_item_quantity, order_item_price, order_item_actual_amount, discount_rate, discount_amount, order_item_final_amount)
           VALUES (:order_id, :service_type, :item_name, :hsn_code, :order_item_quantity, :order_item_price, :order_item_actual_amount, :discount_rate, :discount_amount, :order_item_final_amount)
         ");

         $statement->execute(
           array(
             ':order_id'                       =>  $orderId,
             ':service_type'                   =>  trim($_POST["service_type"][$count]),
             ':item_name'                      =>  trim($_POST["item_name"][$count]),
             ':hsn_code'                       =>  trim($_POST["hsn_code"][$count]),
             ':order_item_quantity'            =>  trim($_POST["order_item_quantity"][$count]),
             ':order_item_price'               =>  trim($_POST["order_item_price"][$count]),
             ':order_item_actual_amount'       =>  trim($_POST["order_item_actual_amount"][$count]),
             ':discount_rate'                  =>  trim($_POST["discount_rate"][$count]),
             ':discount_amount'                =>  trim($_POST["discount_amount"][$count]),
             ':order_item_final_amount'        =>  trim($_POST["order_item_final_amount"][$count])
           )
         );
       }
       $order_total_tax = $order_total_tax1 + $order_total_tax2 + $order_total_tax3;

       $statement = $connect->prepare("
         UPDATE inv_order
         SET order_total_before_tax = :order_total_before_tax,
         order_total_tax1 = :order_total_tax1,
         order_total_tax2 = :order_total_tax2,
         order_total_tax3 = :order_total_tax3,
         order_total_tax = :order_total_tax,
         total_discount_amount = :total_discount_amount,
         order_total_after_tax = :order_total_after_tax
         WHERE order_id = :order_id
       ");
       $statement->execute(
         array(
           ':order_total_before_tax'   =>  $order_total_before_tax,
           ':order_total_tax1'         =>  $order_total_tax1,
           ':order_total_tax2'         =>  $order_total_tax2,
           ':order_total_tax3'         =>  $order_total_tax3,
           ':order_total_tax'          =>  $order_total_tax,
           ':total_discount_amount'    =>  $total_discount_amount,
           ':order_total_after_tax'    =>  $order_total_after_tax,
           ':order_id'                 =>  $orderId
         )
       );

       header("location:invoice.php");
   }
   }catch(PDOException $e)
     {
     echo "Error: " . $e->getMessage();
     }

   if(isset($_GET["delete"]) && isset($_GET["id"]))
   {

     $statement = $connect->prepare("DELETE FROM inv_order WHERE order_id = :id");
     $statement->execute(
       array(
         ':id'       =>      $_GET["id"]
       )
     );
     $statement = $connect->prepare(
       "DELETE FROM inv_order_item WHERE order_id = :id");
     $statement->execute(
       array(
         ':id'       =>      $_GET["id"]
       )
     );
     header("location:invoice.php");
   }

   ?>

   <style>


.cheque-box-section{width:30%; float:left;}
.cheque-box-section-second{width:69%; float:left;}

.ntf-box-width{width:100%;float:left;margin-bottom:20px;}

.gst-flex {
    display: flex;
    / align-items: center; /
}
select#gst_code {
    width: 88px;
}

.form-group.client_infoinput {
    margin-right: 7px;
}

.form-group.client_info{
    display: flex;
}

a.cancelbtn {
    background: #c60a0a;
    color: #fff;
    padding: 5px 7px;
    border-radius: 4px;
  }
/* Smartphones (portrait and landscape) ----------- */
@media only screen and (min-width: 320px) and (max-width: 767px) {
  /* Styles */

 .aw-mobile .form-group {
    margin-bottom: 15px;
    margin-right: 8px;

}
 .mobile-tab-pro {
    zoom: 84% !important;
}
ul.pagination li {

    font-size: 10px;
}
ul.pagination {
    width: 210px !important;
}
.pro-table-responsive th {
    display: block;
}
.mobile-tab-pro th {
    width: 218px !important;
}
.mobile-tab-pro td, th {
    width: 95% !important;
  }

#data-table_filter input.form-control.input-sm {
    width: 76%;
}



  }

   </style>
<?php
   include ('header.php');
    ?>
<?php
   include ('sidebar.php');

    ?>
<div class="home-content">
   <div class="overview-boxes adstate">
      <div class="container-fluid">
         <br>
         <?php
            if(isset($_GET["add"]))
            {
            ?>
         <form method="post" id="invoice_form">
         <div class="table-responsive create-table pro-table-one aw-mobile">
            <table class="table table-bordered card">
               <tr>
                  <td colspan="2">
                     <div class="row">
                        <div class="col-md-8">
                           <b>Company Name</b><br />
                           <div class="form-group">
                              <input type="text" name="order_receiver_name" id="order_receiver_name" class="form-control input-sm" placeholder="Enter Company Name" />
                           </div>
                           <div class="form-group">
                              <textarea name="order_receiver_address" id="order_receiver_address" class="form-control" placeholder="Enter Billing Address"></textarea>
                           </div>
                           <div class="form-group client_info">
                              <input type="text" name="client_name" id="client_name" class="form-control input-sm" placeholder="Enter Client Name" />
                              <input type="text" name="contact_no" id="contact_no" class="form-control input-sm" maxlength="10" placeholder="Enter Contact Number" />
                           </div>

                        </div>
                        <input type="hidden" name="order_no" id="order_no" value="1236548" class="form-control input-sm number_only" maxlength="12" placeholder="Enter Invoice No." />
                        <div class="col-md-4">
                          <?php
                             $role = $_SESSION["roledata"];
                             if ($role == '0'){
                             ?>
                             <b>Date</b><br />
                             <div class="form-group">
                                <input type="date" name="order_date" class="form-control input-sm" placeholder="Select Invoice Date" />
                             </div>
                          <?php } else


                          {
                                 $curntdate = date("Y-m-d");
                            ?>
                          <input type="text" name="order_date" value="<?php echo $curntdate; ?>" class="form-control input-sm" readonly placeholder="Select Invoice Date" />

                        <?php  }?>

                        <b>State</b><br />
                        <?php
                           $statement = $connect->prepare("SELECT * FROM state ORDER BY id ASC");

                           $statement->execute();

                           $state_result = $statement->fetchAll();

                            ?>
                        <div class="form-group">
                           <select name="state_name" id="stateget" class="Destination">
                              <option value="">Select state</option>
                              <?php
                                 foreach($state_result as $state)
                                 {
                                   ?>
                              <option value="<?php echo $state['state_name'];?> (<?php echo $state['state_code'];?>)"><?php echo $state['state_name']; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                           <b>GST Number</b><br />
                             <div class="form-group">
                                 <div class="gst-flex">
                        <!--       <select class="gstcode" name="gststatecode" id="gst_code">
                               </select>  -->
                              <input type="text" name="gst_no" id="gst_no" class="form-control input-sm"  maxlength="15"  required placeholder="GST Number" />
                           </div>
                           </div>

                        </div>
                     </div>

                     <div class="form-group">
                        <textarea name="remarks" id="remarks" class="form-control" placeholder="Enter Remarks"></textarea>
                     </div>

                <script>
                  $(document).ready(function(){
                      $(".select_payment").change(function(){
                          $(this).find("option:selected").each(function(){
                              var optionValue = $(this).attr("value");
                              if(optionValue){
                                  $(".box").not("." + optionValue).hide();
                                  $("." + optionValue).show();
                              } else{
                                  $(".box").hide();
                              }
                          });
                      }).change();
                  });
              </script>




            <div class="ntf-box-width">

               <div class="cheque-box-section">

          <div>
        <select name="payoption" class="select_payment">
            <option>Select Payment Type</option>
                <option value="Cheque">Cheque</option>
                <option value="NEFT">NEFT</option>
                <option value="UPI">UPI</option>
                  <option value="Cash">Cash</option>
        </select>
    </div>
    </div>

 				  <div class="cheque-box-section-second">

    <div class="Cash box">
    </div>

    <div class="Cheque box">
      <div class="form-group client_info">
         <input type="text" name="checq_no" id="checq_no" class="form-control input-sm" placeholder="Enter Cheque NO" />
         <input type="text" name="bank_name" id="bank_name" class="form-control input-sm" placeholder="Enter Bank Name" />
      </div>
    </div>

    <div class="UPI box">
      <div class="form-group client_info">
         <input type="text" name="upi_id" id="upi_id" class="form-control input-sm" placeholder="Enter Transaction Id" />
      </div>
    </div>

    <div class="NEFT box">
      <div class="form-group client_info">
         <input type="text" name="nfet_no" id="nfet_no" class="form-control input-sm" placeholder="Enter NEFT Id" />
      </div>
    </div>


	</div>



              </div>


                     <?php
                        $role = $_SESSION["roledata"];
                        if ($role == '0'){
                        ?>
                        <b>Only For Deleted Bill NO</b><br />
                        <div class="form-group">
                          <input type="text" name="oldbill"  class="oldbill" placeholder="Please Enter Deleted Bill No" style="width : 20%;">
                        </div>
                     <?php } ?>

                     <br />
                     <table id="invoice-item-table" class="table table-bordered table-hover table-striped pro-table-responsive invoice-tab">
                        <tr>
                          <th width="5%">S/N.</th>
                          <th width="15%">Service Type</th>
                          <th width="20%">Item Name</th>
                          <th width="10%">HSN Code</th>
                          <th width="8%">Quantity</th>
                          <th width="8%">Discount %</th>
                          <th width="8%">MRP</th>
                          <th width="8%">Discount Amount</th>
                          <th width="8%">Actual Amt.</th>
                          <th width="10%">Final Amount</th>
                        </tr>
                        <tr>
                           <td><span id="sr_no">1</span></td>
                           <?php
                              $statement = $connect->prepare("SELECT * FROM service_type ORDER BY id ASC");

                              $statement->execute();

                              $service_type = $statement->fetchAll();

                               ?>
                           <td>
                              <select name="service_type[]" id="service_type" class="form-control input-sm" />
                                 <option>Select Service Type </option>
                                 <?php
                                    foreach($service_type as $servicetype)
                                    {
                                      ?>
                                 <option value="<?php echo $servicetype['service_type']; ?>"><?php echo $servicetype['service_type']; ?></option>
                                 <?php }
                                    ?>
                              </select>
                           </td>
                           <?php
                              $statement = $connect->prepare("SELECT * FROM service ORDER BY service_type ASC");

                              $statement->execute();

                              $service_result = $statement->fetchAll();

                               ?>
                           <td>
                              <select name="item_name[]" id="item_name" class="form-control input-sm" />
                              </select>
                           </td>
                             <td>
                               <select name="hsn_code[]" id="hsn_code" data-srno="1" class="form-control input-sm hsn_code" />
                             </select>
                             </td>
                            <td><input type="text" name="order_item_quantity[]" id="order_item_quantity1" data-srno="1" class="form-control input-sm order_item_quantity" placeholder="Enter Quantity"/></td>
                            <?php if ($role == '0'){ ?>
                              <td><input type="number" name="discount_rate[]" id="discount_rate1" data-srno="1" class="form-control input-sm number_only discount_rate" min="0" max="100" placeholder="Enter Discount"/></td>
                            <?php } else { ?>
                              <td><input type="number" name="discount_rate[]" id="discount_rate1" data-srno="1" class="form-control input-sm number_only discount_rate" min="0" max="<?php echo $dis_prsent; ?>" placeholder="Enter Discount"/></td>
                          <?php  } ?>

                           <td>
                             <select name="order_item_price[]" id="order_item_price1" data-srno="1" class="form-control input-sm number_only order_item_price" />
                           </select>
                         </td>
                           <td><input type="text" name="discount_amount[]" id="discount_amount1" data-srno="1" readonly class="form-control input-sm discount_amount" placeholder="Discount"/></td>
                           <td><input type="text" name="order_item_actual_amount[]" id="order_item_actual_amount1" data-srno="1" class="form-control input-sm order_item_actual_amount" readonly placeholder="Actual Amount" /></td>
                           <td><input type="text" name="order_item_final_amount[]" id="order_item_final_amount1" data-srno="1" readonly class="form-control input-sm order_item_final_amount" placeholder="Final Amount" /></td>
                           <td></td>
                        </tr>
                     </table>
                     <?php
                        $role = $_SESSION["roledata"];
                        if ($role == '0'){
                        ?>
                  <!--   <input type="text" id="fname" name="As_name" value="" placeholder="ADDITIONAL SERVICE">
                     <input type="text" id="lname" name="as_qunty" value="" placeholder="quantity">
                     <input type="text" id="lname" name="as_price" value="" placeholder="price">  -->
                     <?php } ?>
                     <div align="right">
                        <button type="button" name="add_row" id="add_row" class="btn btn-success">+</button>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td align="right"><b>Total</b></td>
                  <td align="right"><b><span id="final_total_amt"></span></b></td>
               </tr>
               <tr>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td colspan="2" align="center">
                     <input type="hidden" name="total_item" id="total_item" value="1" />
                     <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-success" value="Create" />
                     <a class="cancelbtn" href="https://geteideabill.dotgraffe.com/invoice.php">cancel</a>

                  </td>
               </tr>
            </table>
            </div>

      </div>
      </form>
      <script>

      $('#stateget').change(function(){
      var state_code = $(this).val();
        // alert(state_code);
      $.ajax({
      url: 'state_code_get.php',
      type: "POST",
      data: {
      state_code:state_code
      },
      cache: false,
      success: function(result){
      $("#gst_code").html(result);

      }
      });
      });

         $('#service_type').change(function(){
         var service_type = $(this).val();
         $.ajax({
         url: 'service_list.php',
         type: "POST",
         data: {
         service_type:service_type
         },
         cache: false,
         success: function(result){
         $("#item_name").html(result);

         }
         });
         });

         $('#service_type').change(function(){
         var get_hsn = $(this).val();
          $.ajax({
          url: 'hsncodeshow.php',
          type: "POST",
         data: {
          get_hsn:get_hsn
          },
          cache: false,
          success: function(result){
          $("#hsn_code").html(result);

          }
          });
         });

      </script>
      <script>
         $(document).ready(function(){
           var final_total_amt = $('#final_total_amt').text();
           var count = 1;

           $(document).on('click', '#add_row', function(){
             count++;
             $('#total_item').val(count);
             var html_code = '';
             html_code += '<tr id="row_id_'+count+'">';
             html_code += '<td><span id="sr_no">'+count+'</span></td>';
             html_code += ' <td><select name="service_type[]" id="service_type'+count+'" class="form-control input-sm" <option value="">Select Service Type </option> <option value="">Select Service Type </option> <?php foreach($service_type as $servicetype) { ?> <option value="<?php echo $servicetype['service_type']; ?> "><?php echo $servicetype['service_type']; ?></option> <?php } ?> ></select></td>';
             html_code += ' <td><select name="item_name[]" id="item_name'+count+'" class="form-control input-sm" </select></td>';
             html_code += '<td><select name="hsn_code[]" id="hsn_code'+count+'" data-srno="'+count+'" class="form-control input-sm hsn_code" /> </select></td>';
             html_code += '<td><input type="text" name="order_item_quantity[]" id="order_item_quantity'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_quantity" placeholder="Enter Quantity"/></td>';
             <?php $role = $_SESSION["roledata"];  if ($role == '0'){ ?>
             html_code += '<td><input type="number" name="discount_rate[]" id="discount_rate'+count+'" data-srno="'+count+'" class="form-control input-sm number_only discount_rate" min="0" max="100" placeholder="Enter Discount" /></td>';
                <?php } else { ?>
            html_code += '<td><input type="number" name="discount_rate[]" id="discount_rate'+count+'" data-srno="'+count+'" class="form-control input-sm number_only discount_rate" min="0" max="<?php echo $dis_prsent; ?>" placeholder="Enter Discount"/></td>';
            <?php } ?>
             html_code += '<td><select name="order_item_price[]" id="order_item_price'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_price" /> </select></td>';
             html_code += '<td><input type="text" name="discount_amount[]" id="discount_amount'+count+'" data-srno="'+count+'" class="form-control input-sm discount_amount" readonly placeholder="Discount Amount"/></td>';
             html_code += '<td><input type="text" name="order_item_actual_amount[]" id="order_item_actual_amount'+count+'" data-srno="'+count+'" class="form-control input-sm order_item_actual_amount" readonly placeholder="Actual Amount"/></td>';
             html_code += '<td><input type="text" name="order_item_final_amount[]" id="order_item_final_amount'+count+'" data-srno="'+count+'" readonly class="form-control input-sm order_item_final_amount" placeholder="Final Amount"/></td>';
             html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
             html_code += '</tr>';
             $('#invoice-item-table').append(html_code);
           });

               $(document).on('change', '#service_type2', function(){
               var service_multi = $(this).val();
                $.ajax({
                url: '2ndservice_list.php',
                type: "POST",
               data: {
                service_multi:service_multi
                },
                cache: false,
                success: function(result){
                $("#item_name2").html(result);

                }
                });
               });

               $(document).on('change', '#service_type3', function(){
               var service_multi3 = $(this).val();
                $.ajax({
                url: '3rdservice_list.php',
                type: "POST",
               data: {
                service_multi3:service_multi3
                },
                cache: false,
                success: function(result){
                $("#item_name3").html(result);

                }
                });
               });

               $(document).on('change', '#service_type4', function(){
               var service_multi4 = $(this).val();
                $.ajax({
                url: 'fourthservice_list.php',
                type: "POST",
               data: {
                service_multi4:service_multi4
                },
                cache: false,
                success: function(result){
                $("#item_name4").html(result);

                }
                });
               });

               $(document).on('change', '#service_type5', function(){
               var service_multi5 = $(this).val();
                $.ajax({
                url: 'fifthservice_list.php',
                type: "POST",
               data: {
                service_multi5:service_multi5
                },
                cache: false,
                success: function(result){
                $("#item_name5").html(result);

                }
                });
               });

               $(document).on('change', '#service_type6', function(){
               var six_service = $(this).val();
                $.ajax({
                url: 'sixservice_list.php',
                type: "POST",
               data: {
                six_service:six_service
                },
                cache: false,
                success: function(result){
                $("#item_name6").html(result);

                }
                });
               });

               $(document).on('change', '#service_type7', function(){
               var seven_service = $(this).val();
                $.ajax({
                url: 'sevenservice_list.php',
                type: "POST",
               data: {
                seven_service:seven_service
                },
                cache: false,
                success: function(result){
                $("#item_name7").html(result);

                }
                });
               });

               $(document).on('change', '#service_type8', function(){
               var eight_service = $(this).val();
                $.ajax({
                url: 'eightservice_list.php',
                type: "POST",
               data: {
                eight_service:eight_service
                },
                cache: false,
                success: function(result){
                $("#item_name8").html(result);

                }
                });
               });

               $(document).on('change', '#service_type9', function(){
               var nine_service = $(this).val();
                $.ajax({
                url: 'nineservice_list.php',
                type: "POST",
               data: {
                nine_service:nine_service
                },
                cache: false,
                success: function(result){
                $("#item_name9").html(result);

                }
                });
               });

               $(document).on('change', '#service_type10', function(){
               var ten_service = $(this).val();
                $.ajax({
                url: 'tenservice_list.php',
                type: "POST",
               data: {
                ten_service:ten_service
                },
                cache: false,
                success: function(result){
                $("#item_name10").html(result);

                }
                });
               });

               $(document).on('change', '#service_type11', function(){
               var eleven_service = $(this).val();
                $.ajax({
                url: 'elevenservice_list.php',
                type: "POST",
               data: {
                eleven_service:eleven_service
                },
                cache: false,
                success: function(result){
                $("#item_name11").html(result);

                }
                });
               });

               $(document).on('change', '#service_type12', function(){
               var twelve_service = $(this).val();
                $.ajax({
                url: 'twelveservice_list.php',
                type: "POST",
               data: {
                twelve_service:twelve_service
                },
                cache: false,
                success: function(result){
                $("#item_name12").html(result);

                }
                });
               });

               $(document).on('change', '#service_type13', function(){
               var thirteen_service = $(this).val();
                $.ajax({
                url: 'thirteenservice_list.php',
                type: "POST",
               data: {
                thirteen_service:thirteen_service
                },
                cache: false,
                success: function(result){
                $("#item_name13").html(result);

                }
                });
               });

               $(document).on('change', '#service_type14', function(){
               var fourteen_service = $(this).val();
                $.ajax({
                url: 'fourteenservice_list.php',
                type: "POST",
               data: {
                fourteen_service:fourteen_service
                },
                cache: false,
                success: function(result){
                $("#item_name14").html(result);

                }
                });
               });

               $(document).on('change', '#service_type15', function(){
               var fifteen_service = $(this).val();
                $.ajax({
                url: 'fifteenservice_list.php',
                type: "POST",
               data: {
                fifteen_service:fifteen_service
                },
                cache: false,
                success: function(result){
                $("#item_name15").html(result);

                }
                });
               });

               $(document).on('change', '#item_name', function(){
                 var item_name1 = $(this).val();
                 $.ajax({
                   url: 'firstprice.php',
                   type: "POST",
                   data: {
                     item_name1:item_name1
                   },
                   cache: false,
                   success: function(result){
                     $("#order_item_price1").html(result);
                   }
                 });

               });

               $(document).on('change', '#item_name2', function(){
                 var item_name2 = $(this).val();
                 $.ajax({
                   url: 'secondprice.php',
                   type: "POST",
                   data: {
                     item_name2:item_name2
                   },
                   cache: false,
                   success: function(result){
                     $("#order_item_price2").html(result);
                   }
                 });

               });

               $(document).on('change', '#item_name3', function(){
                 var item_name3 = $(this).val();
                 $.ajax({
                   url: 'thirdprice.php',
                   type: "POST",
                   data: {
                     item_name3:item_name3
                   },
                   cache: false,
                   success: function(result){
                     $("#order_item_price3").html(result);
                   }
                 });

               });

        $(document).on('change', '#item_name4', function(){
          var item_name4 = $(this).val();
          $.ajax({
            url: 'fourthprice.php',
            type: "POST",
            data: {
              item_name4:item_name4
            },
            cache: false,
            success:function(result){
              $("#order_item_price4").html(result);
            }
          });
        });

        $(document).on('change', '#item_name5', function(){
          var item_name5 = $(this).val();
          $.ajax({
            url: 'fifthprice.php',
            type: "POST",
            data: {
              item_name5:item_name5
            },
            cache: false,
            success:function(result){
              //console.log(result);
              $("#order_item_price5").html(result);
            }
          });
        });

        $(document).on('change', '#item_name6', function(){
          var item_name6 = $(this).val();
          $.ajax({
            url: 'sixprice.php',
            type: "POST",
            data: {
              item_name6:item_name6
            },
            cache: false,
            success:function(result){
              $("#order_item_price6").html(result);
            }
          });
        });

        $(document).on('change', '#item_name7', function(){
          var item_name7 = $(this).val();
          $.ajax({
            url: 'sevenprice.php',
            type: "POST",
            data: {
              item_name7:item_name7
            },
            cache: false,
            success:function(result){
              $("#order_item_price7").html(result);
            }
          });
        });

        $(document).on('change', '#item_name8', function(){
          var eight_item = $(this).val();
          $.ajax({
            url: 'eight_price.php',
            type: "POST",
            data: {
              eight_item:eight_item
            },
            cache: false,
            success:function(result){
              $("#order_item_price8").html(result);
            }
          });
        });

        $(document).on('change', '#item_name9', function(){
          var nine_item = $(this).val();
          $.ajax({
            url: 'nine_price.php',
            type: "POST",
            data: {
              nine_item:nine_item
            },
            cache: false,
            success:function(result){
              $("#order_item_price9").html(result);
            }
          });
        });

        $(document).on('change', '#item_name10', function(){
          var ten_item = $(this).val();
          $.ajax({
            url: 'ten_price.php',
            type: "POST",
            data: {
              ten_item:ten_item
            },
            cache: false,
            success:function(result){
              $("#order_item_price10").html(result);
            }
          });
        });

        $(document).on('change', '#item_name11', function(){
          var eleven_item = $(this).val();
          $.ajax({
            url: 'eleven_price.php',
            type: "POST",
            data: {
              eleven_item:eleven_item
            },
            cache: false,
            success:function(result){
              $("#order_item_price11").html(result);
            }
          });
        });

        $(document).on('change', '#item_name12', function(){
          var twelve_item = $(this).val();
          $.ajax({
            url: 'twelve_price.php',
            type: "POST",
            data: {
              twelve_item:twelve_item
            },
            cache: false,
            success:function(result){
              $("#order_item_price12").html(result);
            }
          });
        });

        $(document).on('change', '#item_name13', function(){
          var thirteen_item = $(this).val();
          $.ajax({
            url: 'thirteen_price.php',
            type: "POST",
            data: {
              thirteen_item:thirteen_item
            },
            cache: false,
            success:function(result){
              $("#order_item_price13").html(result);
            }
          });
        });

        $(document).on('change', '#item_name14', function(){
          var fourteen_item = $(this).val();
          $.ajax({
            url: 'fourteen_price.php',
            type: "POST",
            data: {
              fourteen_item:fourteen_item
            },
            cache: false,
            success:function(result){
              $("#order_item_price14").html(result);
            }
          });
        });

        $(document).on('change', '#item_name15', function(){
          var fifteen_item = $(this).val();
          $.ajax({
            url: 'fifteen_price.php',
            type: "POST",
            data: {
              fifteen_item:fifteen_item
            },
            cache: false,
            success:function(result){
              $("#order_item_price15").html(result);
            }
          });
        });




        $(document).on('change', '#service_type2', function() {
          var hsnscond = $(this).val();
          $.ajax({
           url: 'hsncodeshow2.php',
           type: "POST",
           data: {
             hsnscond:hsnscond
           },
           cache: false,
           success: function(result){
             $("#hsn_code2").html(result);
           }
          });
        });

        $(document).on('change', '#service_type3', function(){
          var hsn_third = $(this).val();
          $.ajax({
            url: 'hsncode3rdshow.php',
            type: "POST",
            data: {
              hsn_third:hsn_third
            },
            cache: false,
            success: function(result){
              $("#hsn_code3").html(result)
            }

          });
        });

        $(document).on('change', '#service_type4', function(){
          var hsn_fourth = $(this).val();
          $.ajax({
            url: 'hsncode4thshow.php',
            type: "POST",
            data: {
              hsn_fourth:hsn_fourth
            },
            cache: false,
            success: function(result){
              $("#hsn_code4").html(result)
            }

          });
        });

        $(document).on('change', '#service_type5', function(){
          var hsn_fifth = $(this).val();
          $.ajax({
            url: 'hsncode5thshow.php',
            type: "POST",
            data: {
              hsn_fifth:hsn_fifth
            },
            cache: false,
            success: function(result){
              $("#hsn_code5").html(result)
            }

          });
        });

        $(document).on('change', '#service_type6', function(){
          var hsn_six = $(this).val();
          $.ajax({
            url: 'hsncode6thshow.php',
            type: "POST",
            data: {
              hsn_six:hsn_six
            },
            cache: false,
            success: function(result){
              $("#hsn_code6").html(result)
            }

          });
        });

        $(document).on('change', '#service_type7', function(){
          var hsn_seven = $(this).val();
          $.ajax({
            url: 'hsncode7thshow.php',
            type: "POST",
            data: {
              hsn_seven:hsn_seven
            },
            cache: false,
            success: function(result){
              $("#hsn_code7").html(result)
            }

          });
        });

        $(document).on('change', '#service_type8', function(){
          var hsn_eight = $(this).val();
          $.ajax({
            url: 'hsncode_eight.php',
            type: "POST",
            data: {
              hsn_eight:hsn_eight
            },
            cache: false,
            success: function(result){
              $("#hsn_code8").html(result)
            }

          });
        });

        $(document).on('change', '#service_type9', function(){
          var hsn_nine = $(this).val();
          $.ajax({
            url: 'hsncode_nine.php',
            type: "POST",
            data: {
              hsn_nine:hsn_nine
            },
            cache: false,
            success: function(result){
              $("#hsn_code9").html(result)
            }

          });
        });

        $(document).on('change', '#service_type10', function(){
          var hsn_ten = $(this).val();
          $.ajax({
            url: 'hsncode_ten.php',
            type: "POST",
            data: {
              hsn_ten:hsn_ten
            },
            cache: false,
            success: function(result){
              $("#hsn_code10").html(result)
            }

          });
        });

        $(document).on('change', '#service_type11', function(){
          var hsn_eleven = $(this).val();
          $.ajax({
            url: 'hsncode_eleven.php',
            type: "POST",
            data: {
              hsn_eleven:hsn_eleven
            },
            cache: false,
            success: function(result){
              $("#hsn_code11").html(result)
            }

          });
        });

        $(document).on('change', '#service_type12', function(){
          var hsn_twelve = $(this).val();
          $.ajax({
            url: 'hsncode_twelve.php',
            type: "POST",
            data: {
              hsn_twelve:hsn_twelve
            },
            cache: false,
            success: function(result){
              $("#hsn_code12").html(result)
            }

          });
        });

        $(document).on('change', '#service_type13', function(){
          var hsn_thirteen = $(this).val();
          $.ajax({
            url: 'hsncode_thirteen.php',
            type: "POST",
            data: {
              hsn_thirteen:hsn_thirteen
            },
            cache: false,
            success: function(result){
              $("#hsn_code13").html(result)
            }

          });
        });

        $(document).on('change', '#service_type14', function(){
          var hsn_fourteen = $(this).val();
          $.ajax({
            url: 'hsncode_fourteen.php',
            type: "POST",
            data: {
              hsn_fourteen:hsn_fourteen
            },
            cache: false,
            success: function(result){
              $("#hsn_code14").html(result)
            }

          });
        });

        $(document).on('change', '#service_type15', function(){
          var hsn_fifteen = $(this).val();
          $.ajax({
            url: 'hsncode_fifteen.php',
            type: "POST",
            data: {
              hsn_fifteen:hsn_fifteen
            },
            cache: false,
            success: function(result){
              $("#hsn_code15").html(result)
            }

          });
        });

           $(document).on('click', '.remove_row', function(){
             var row_id = $(this).attr("id");
             var total_item_amount = $('#order_item_final_amount'+row_id).val();
             var final_amount = $('#final_total_amt').text();
             var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
             $('#final_total_amt').text(result_amount);
             $('#row_id_'+row_id).remove();
             count--;
             $('#total_item').val(count);
           });

           function cal_final_total(count)
           {
             var final_item_total = 0;
             for(j=1; j<=count; j++)
             {
               var pricedata = 0;
               var quantitydata = 0;
               var discount =  0;
               var discount_amount = 0;
               var actual_amount = 0;
               var tax1_rate = 0;
               var tax1_amount = 0;
               var tax2_rate = 0;
               var tax2_amount = 0;
               var tax3_rate = 0;
               var tax3_amount = 0;
               var item_total = 0;
              pricedata = $('#order_item_price'+j).val();
              //  alert(price);
              // quantity = $('#order_item_quantity'+j).val();
               //alert(quantity);
            //   console.log(price);
               if(pricedata > 0)
               {
                 quantitydata = $('#order_item_quantity'+j).val();
              //   alert(quantity);
                 if(quantitydata > 0)
                 {
                   discount_amount

                   actual_amount = parseFloat(pricedata) * parseFloat(quantitydata);
                   //console.log(actual_amount);
                   $('#order_item_actual_amount'+j).val(actual_amount);

                   discount = $('#discount_rate'+j).val();
                  // alert(discount);
                   if(discount => 0)
                   {
                   discount_amount = parseFloat(actual_amount)*parseFloat(discount)/100;
                //   alert(discount_amount);
                   $('#discount_amount'+j).val(discount_amount);
                 }

                   item_total = parseFloat(actual_amount) - parseFloat(discount_amount);
                   final_item_total = parseFloat(final_item_total) + parseFloat(item_total);
                   $('#order_item_final_amount'+j).val(item_total);
                 }
               }
             }
             $('#final_total_amt').text(final_item_total);
           }

           $(document).on('blur', '.order_item_price', function(){
             cal_final_total(count);
           });

           $('#create_invoice').click(function(){
             if($.trim($('#order_receiver_name').val()).length == 0)
             {
               alert("Please Enter Reciever Name");
               return false;
             }

             if($.trim($('#order_no').val()).length == 0)
             {
               alert("Please Enter Invoice Number");
               return false;
             }

            // if($.trim($('#order_date').val()).length == 0)
          //   {
            //   alert("Please Select Invoice Date");
            //   return false;
          //   }
             if($.trim($('#gst_no').val()).length == 0){
               alert("Please Enter GST No");
               return false;
             }

             for(var no=1; no<=count; no++)
             {


               if($.trim($('#order_item_quantity'+no).val()).length == 0)
               {
                 alert("Please Enter Quantity");
                 $('#order_item_quantity'+no).focus();
                 return false;
               }

               if($.trim($('#order_item_price'+no).val()).length == 0)
               {
                 alert("Please Enter Price");
                 $('#order_item_price'+no).focus();
                 return false;
               }

             }

             $('#invoice_form').submit();

           });

         });

      </script>
      <script>
         $('.Destination').change(function(){
           var Destination=$('.Destination').val();
           $.ajax({url:"stateget.php?Destination="+Destination,cache:false,success:function(result){
              $(".ShowSelectedValueDiv").html(result);
           }});
           });


      </script>
      <?php
         }
         else
         {
         ?>

         <?php if($role == 0){
           $userdata = "SELECT * FROM login";
           $statement = $connect->prepare($userdata);
           $statement->execute();
           $userget = $statement->fetchAll();
           ?>
           <div align="right" class="fixform">
             <form method="post" action="importdata.php">

                 <span>From Date</span>
                 <input type="date" name="from" placeholder="Select date from" required>
                   <span>To Date</span>
                 <input type="date" name="to"  placeholder="Select date to" required>

                 <select name="userlist">
                   <option value="All">All</option>
                   <?php
                    foreach($userget as $alluser){
                      ?>
                      <option value="<?php echo $alluser['username']; ?>"><?php echo $alluser['name']; ?></option>
                    <?php }
                    ?>
                 </select>
                           <button type="submit" name="submit" class="btn btn-success" value="submit">Download</button>
                     </form>
                     <div class="createnew">
              <a href="invoice.php?add=1" class="btn btn-success">Create New</a>
            </div>

           </div>
        <?php }
        elseif($role == 1){
          $userdata = "SELECT * FROM login";
          $statement = $connect->prepare($userdata);
          $statement->execute();
          $userget = $statement->fetchAll();
          ?>
          <div align="right" class="fixform">
            <form method="post" action="importdata.php">

                <span>From Date</span>
                <input type="date" name="from" placeholder="Select date from" required>
                  <span>To Date</span>
                <input type="date" name="to"  placeholder="Select date to" required>

                <select name="userlist">
                  <option value="All">All</option>
                  <?php
                   foreach($userget as $alluser){
                     ?>
                     <option value="<?php echo $alluser['username']; ?>"><?php echo $alluser['name']; ?></option>
                   <?php }
                   ?>
                </select>
                          <button type="submit" name="submit" class="btn btn-success" value="submit">Download</button>
                    </form>
                    <div class="createnew">
             <a href="invoice.php?add=1" class="btn btn-success">Create New</a>
           </div>

          </div>
       <?php }
         else{ ?>
           <div align="right" class="fixform create-page">
             <form method="post" action="importdata.php">
                 <span>From Date</span>
                 <input type="date" name="from" placeholder="Select date from" required>
                   <span>To Datee</span>
                 <input type="date" name="to"  placeholder="Select date to" required>
                           <button type="submit" name="submit" class="btn btn-success" value="submit">Download</button>
                     </form>
                     <div class="createnew">
              <a href="invoice.php?add=1" class="btn btn-success">Create New</a>
            </div>

           </div>

      <?php   }?>
      <br />

      <div style= "text-align: center">
         <p>
         <h3> Invoice List</h3>
         <p>
      </div>
      <?php
         if($designationrole == 'M4'){
           ?>
		   	<div class="table-responsive create-table ">
      <table id="data-table" class="table table-bordered table-striped card table-hover mobile-tab-pro">
         <thead>
            <tr>
               <th>Invoice No.</th>
               <th>Invoice Date</th>
               <th>Receiver Name</th>
               <th>Invoice Total</th>
               <th>PDF</th>
               <th>Created By</th>
          <!--    <th>Edit</th> -->
              <th>Delete</th>
            </tr>
         </thead>
         <?php
            if($total_rows > 0)
            {
              foreach($all_result as $row)
              {
                $dateformate = date("d-m-Y", strtotime($row["order_date"]));
                echo '
                  <tr>
                    <td>GEI-'.$row["order_id"].'</td>
                    <td>'.$dateformate.'</td>
                    <td>'.$row["order_receiver_name"].'</td>
                    <td>'.$row["order_total_after_tax"].'</td>
                   <td><a target="_blank" href="printInvoice.php?pdf=1&id='.$row["order_id"].'">PDF</a></td>
                     <td>'.$row["created_by"].'</td>
                <!--     <td><a href="invoice.php?update=1&id='.$row["order_id"].'"><span class="glyphicon glyphicon-edit"></span></a></td> -->
                     <td><a href="#" id="'.$row["order_id"].'" class="delete text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                  </tr>
                ';
              }
            }
            ?>
      </table>
	  </div>
      <?php
         }

         elseif($designationrole =='M3'){

           $statement = $connect->prepare("SELECT * FROM inv_order WHERE M3=:Man_3 ORDER BY order_id DESC");
           $statement->execute(
             array(
               'Man_3'       =>   $AdminName
             )
           );
           $M3data = $statement->fetchAll();
           ?>
		   	<div class="table-responsive create-table ">
      <table id="data-table" class="table table-bordered table-striped card table-hover mobile-tab-pro">
         <thead>
            <tr>
               <th>Invoice No.</th>
               <th>Invoice Date</th>
               <th>Receiver Name</th>
               <th>Invoice Total</th>
               <th>PDF</th>
               <th>Created By</th>
          <!--    <th>Edit</th> -->
              <th>Delete</th>
            </tr>
         </thead>
         <?php

              foreach($M3data as $row)
              {
                $dateformate = date("d-m-Y", strtotime($row["order_date"]));
                echo '
                  <tr>
                    <td>GEI-'.$row["order_id"].'</td>
                    <td>'.$dateformate.'</td>
                    <td>'.$row["order_receiver_name"].'</td>
                    <td>'.$row["order_total_after_tax"].'</td>
                   <td><a target="_blank" href="printInvoice.php?pdf=1&id='.$row["order_id"].'">PDF</a></td>
                     <td>'.$row["created_by"].'</td>
                <!--     <td><a href="invoice.php?update=1&id='.$row["order_id"].'"><span class="glyphicon glyphicon-edit"></span></a></td> -->
                     <td><a href="#" id="'.$row["order_id"].'" class="delete text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                  </tr>
                ';
              }

            ?>
      </table>
	  </div>
      <?php
         }


         elseif($designationrole == 'M2'){
           $statement = $connect->prepare("SELECT * FROM inv_order WHERE M2=:M2 ORDER BY order_id DESC");

           $statement->execute(
             array(
               'M2'       =>   $AdminName
             )
           );
           $m3dtails = $statement->fetchAll();
           ?>
		   	<div class="table-responsive create-table ">
      <table id="data-table" class="table table-bordered table-striped card table-hover mobile-tab-pro">
         <thead>
            <tr>
               <th>Invoice No.</th>
               <th>Invoice Date</th>
               <th>Receiver Name</th>
               <th>Invoice Total</th>
               <th>PDF</th>
               <th>Created By</th>
          <!--    <th>Edit</th> -->
              <th>Delete</th>
            </tr>
         </thead>
         <?php
            if($total_rows > 0)
            {
              foreach($m3dtails as $row)
              {
                $dateformate = date("d-m-Y", strtotime($row["order_date"]));
                echo '
                  <tr>
                    <td>GEI-'.$row["order_id"].'</td>
                    <td>'.$dateformate.'</td>
                    <td>'.$row["order_receiver_name"].'</td>
                    <td>'.$row["order_total_after_tax"].'</td>
                   <td><a target="_blank" href="printInvoice.php?pdf=1&id='.$row["order_id"].'">PDF</a></td>
                     <td>'.$row["created_by"].'</td>
                <!--     <td><a href="invoice.php?update=1&id='.$row["order_id"].'"><span class="glyphicon glyphicon-edit"></span></a></td> -->
                     <td><a href="#" id="'.$row["order_id"].'" class="delete text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                  </tr>
                ';
              }
            }
            ?>
      </table>
	  </div>
      <?php
         }

         else{
           $statement = $connect->prepare("SELECT * FROM inv_order WHERE created_by=:user ORDER BY order_id DESC");
           $statement->execute(
             array(
               'user'       =>   $AdminName
             )
           );

           $userdetails = $statement->fetchAll();
         ?>
      <table id="data-table" class="table table-bordered table-striped card table-hover">
         <thead>
            <tr>
               <th>Invoice No.</th>
               <th>Invoice Date</th>
               <th>Receiver Name</th>
               <th>Invoice Total</th>
               <th>PDF</th>
               <th>Created By</th>
               <!--    <th>Edit</th>
                  <th>Delete</th>  -->
            </tr>
         </thead>
         <?php
            if($total_rows > 0)
            {
              foreach($userdetails as $row)
              {
                $dateformate = date("d-m-Y", strtotime($row["order_date"]));
                echo '
                  <tr>
                    <td>GEI-'.$row["order_id"].'</td>
                    <td>'.$dateformate.'</td>
                    <td>'.$row["order_receiver_name"].'</td>
                    <td>'.$row["order_total_after_tax"].'</td>
                   <td><a href="printInvoice.php?pdf=1&id='.$row["order_id"].'">PDF</a></td>
                     <td>'.$row["created_by"].'</td>
            <!--     <td><a href="invoice.php?update=1&id='.$row["order_id"].'"><span class="glyphicon glyphicon-edit"></span></a></td>
                     <td><a href="#" id="'.$row["order_id"].'" class="delete text-danger"><span class="glyphicon glyphicon-remove"></span></a></td> -->
                  </tr>
                ';
              }
            }
            ?>
      </table>
      <?php
         }
                        }
                      ?>
   </div>
   <br>
</div>
</div>
</body>
</html>
<?php }
   else
   {
       header("location:/index.php");
   } ?>
<script type="text/javascript">
   $(document).ready(function(){
     var table = $('#data-table').DataTable({
           "order":[],
           "columnDefs":[
           {
             "targets":[4, 5, 6],
             "orderable":false,
           },
         ],
         "pageLength": 10
         });
     $(document).on('click', '.delete', function(){
       var id = $(this).attr("id");
       if(confirm("Are you sure you want to remove this?"))
       {
         window.location.href="invoice.php?delete=1&id="+id;
       }
       else
       {
         return false;
       }
     });
   });

</script>
<script>
   $(document).ready(function(){
   $('.number_only').keypress(function(e){
   return isNumbers(e, this);
   });
   function isNumbers(evt, element)
   {
   var charCode = (evt.which) ? evt.which : event.keyCode;
   if (
   (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
   (charCode < 48 || charCode > 57))
   return false;
   return true;
   }
   });
</script>
<script>
   $(document).ready(function(){
     $('#order_date').datepicker({
       format: "dd-mm-yyyy",
       autoclose: true
     });
   });
</script>

<script>
   $(document).ready(function(){
     $('#datefrom').datepicker({
       format: "dd-mm-yyyy",
       autoclose: true
     });
   });
</script>

<script>
   $(document).ready(function(){
     $('#dateto').datepicker({
       format: "dd-mm-yyyy",
       autoclose: true
     });
   });
</script>
