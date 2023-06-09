<?php
//print_invoice.php
if (isset($_GET["pdf"]) && isset($_GET["id"])) {
    require_once 'pdf.php';
    include ('db_config.php');
    $output = '';
    $statement = $connect->prepare("SELECT * FROM header WHERE id = :id LIMIT 1");
    $statement->execute(array(':id' => '1'));
    $headerresult = $statement->fetchAll();

    foreach ($headerresult as $header) {
        $output.= '



       <style>


       .paytm-img {
    border-right: solid 1px #000;
    border-left: solid 1px #000;
}

     table{border:1px solid #000; border-left:0; border-right:0;}
       .main {font-family: sans-serif;
           border:1px solid #000;
           margin:0;
           padding:0;
           width:730px;
           display:block;
           padding:0px;
           font-size:10px;
       }
       .col-sm-4 {
            width:33%;
           display:inline-block;
           text-align:center;
       }
         .col-sm-4 {
            width:24%
           display:inline;
           text-align:center;
       }
       .col-sm-6 {
           width:50%;
           display:inline-block;
           text-align:left;
       }
       .col-sm-5 {
           width:35%;
           display:inline-block;
           text-align:left;
       }
       .col-sm-2 {
           width:28%;
           display:inline-block;
           text-align:center;
       }

       h5{
           padding:0;
           margin:0;

       }


       .invoice_date {
        display:block;
        margin:5px 0 0 0;
       }
        .header{margin-top:10px;}
       .row {
           width:100%;
       }
       .logo {
       position: absolute;
        top: -10px;
          width:100%;
          text-align:left;
          margin-top:0px;
       }
       .invoice-head_info {
          text-align:center;
          width:100%
          display:block;
          font-weight:600;font-size:30px;

       }
        .rupay-img-inline li {
    display: inline-block;vertical-align: middle;
}
       .invoice-head_info-invoice{
          text-align:center;
          width:100%
          display:block;
          font-weight:600;margin-top:10px;
          font-size:35Px;
       }

       .invoice_date {
           margin-top:15px;
            border-right-width:0px;
            border-left-width:0px;
            border-top-width:1px;
            border-style: solid;
            border-bottom-width: 0px;
            border-color:#000;

       }
       .invoice_date span{
           padding-left:5px;
       }
       .center {
           text-align:center;
           display:block;
       }
       .l_border{
                       border-top-width: 0px;
                        border-right-width: 0px;
                        border-bottom-width: 0px;
                        border-left-width: 1px;
                        border-top-style: solid;
                        border-right-style: solid;
                        border-bottom-style: solid;
                        border-left-style: solid;
                        border-top-color: rgb(0, 0, 0);
                        border-right-color: rgb(0, 0, 0);
                        border-bottom-color: rgb(0, 0, 0);
                        border-left-color: rgb(0, 0, 0);
                        border-image-source: initial;
                        border-image-slice: initial;
                        border-image-width: initial;
                        border-image-outset: initial;
                        border-image-repeat: initial;
        }

       .border-half {
            border-top-width: 0px;
                        border-right-width: 0px;
                        border-top-width: 0px;
                        border-bottom-width: 1px;
                        border-left-width: 0px;
                        border-top-style: solid;
                        border-right-style: solid;
                        border-bottom-style: solid;
                        border-left-style: solid;
                        border-top-color: rgb(0, 0, 0);
                        border-right-color: rgb(0, 0, 0);
                        border-bottom-color: rgb(0, 0, 0);
                        border-left-color: rgb(0, 0, 0);
                        border-image-source: initial;
                        border-image-slice: initial;
                        border-image-width: initial;
                        border-image-outset: initial;
                        border-image-repeat: initial;
       }
       h4 {
           margin:0;
           padding:0;
       }
       .bank_details span {
           display:block;
       }
        .bank_details {
            font-size: 13px;
            padding:10px;

        }
       .terms_{
           position:relative;
           top:0px;
           left:0;
       }
    .test-heading{font-weight: 600; }
    .logo-get-e-idea {
    position: absolute;
    right: 5px; top:40;

}
.client-box-inline li {
    display: inline; padding-right:10px;
  }

.client-box-inline  {
    margin-bottom:10px;
    width:100% float:left;
  }



       </style>
   <div class="main">
    <div class="header mt-4">
        <div class="row mt-5">
            <div class="col-sm-4">
            <span><b>GSTIN : 06ATMPD1577A1Z1</b></span>
            </div>
            <div class="col-sm-4">
             <span><b>STATE CODE: (06)</b></span>
            </div>
            <div class="col-sm-4">
             <span><b>PAN NO.: ATMPD1577A</b></span>
            </div>

            <div class="col-sm-4" style="text-align: right;">
             <span><i>Original Copy</i></span>
            </div>
        </div>
        <div class="row">
                 <div class="logo"> <img src="https://geteideabill.dotgraffe.com/image/logo-main.png" width="120" height=""></div>

                 <div class="invoice-head_info-invoice"><u>TAX INVOICE</u></div>
                 <div class="invoice-head_info">GET E IDEAS</div>
                 <div class="invoice-head_address center">' . $header["address"] . '</div>
                 <div class="invoice-head_address center" style="margin-bottom:20px;"><b><i> Tel. : ' . $header["contact_no"] . ', website: ' . $header["website_url"] . ', email : ' . $header["company_email"] . ' </i></b></div>

                <div class="logo-get-e-idea"> <img src="https://geteideabill.dotgraffe.com/image/Get-E-ideas-LOGO-Bold.png" width="160" height=""></div>


        </div>
         ';
    }
    $statement = $connect->prepare("SELECT * FROM inv_order WHERE order_id = :order_id LIMIT 1");
    $statement->execute(array(':order_id' => $_GET["id"]));
    $result = $statement->fetchAll();
  //  echo "<pre>"; print_r($result); echo "</pre>";
  //  die();
    foreach ($result as $row) $statename = $row['state_name'];
    $username = $row['order_receiver_name'];
    $invoiceno = $row['order_id'];
    $dateformate = date("d-m-Y", strtotime($row['order_date']));
    //echo $statename;
    //die();
    {
        $output.= '

      <table width="100%" cellpadding="5" border="1" cellspacing="0" style="border-right:0: border-left:0 !important:">
          <tr>
           <td width="50%" style="border:solid 1px #000; border-left:0:">
            <span style="padding-left:5px;">Invoice No. : GEI-' . $row["order_id"] . '</span><br><span style="padding-left:5px;"> Date of Invoice : ' . $dateformate . '</span>
           </td>
           <td class="l_border" width="50%" style="border-style: solid; border-left: 0px; border-right:0; ">
            <span style="padding-left:5px;"><span>Place of Supply : ' . $row["state_name"] . '</span></sapn>
           </td>
          </tr>
         </table>



         <table width="100%" cellpadding="5" border="0" cellspacing="0" style="border:none;  padding-bottom:-2px;" class="invoice-table" style="text-transform: capitalize;">
          <tr>
           <td width="50%" style="border:solid 1px #000; border-left:0; border-bottom:0; border-top:0;">
            <b><i>BILL TO :</i></b><br />
            ' . $row["order_receiver_name"] . '<br />
            Billing Address : ' . $row["order_receiver_address"] . '<br />
            <br />
              <span class="client-box-inline"><li> Client Name: ' . $row["client_name"] . '</li> <li>Mobile No: ' . $row["contact_no"] . '</li></span>
            <br /><br />
            <span class="gstin-box-number" style="margin-top:20px">GSTIN : ' . $row["gst_no"] . '</span>
           </td>
           <td class="l_border" width="50%" style="border-style: solid; border-left-width: 0px; ">
            <b><i>SHIPPED TO :</i></b><br />
            ' . $row["order_receiver_name"] . '<br />
            Shipped Address : ' . $row["order_receiver_address"] . '<br />
             <br />
             <span class="client-box-inline"><li> Client Name: ' . $row["client_name"] . '</li> <li>Mobile No: ' . $row["contact_no"] . '</li></span>
             <br /><br />
            <span class="gstin-box-number" style="margin-top:20px;">GSTIN : ' . $row["gst_no"] . '</span>
           </td>
          </tr>
         </table>

        <table width="100%" border="1" cellpadding="5" cellspacing="0" >

        <tr>
       ';
        $output.= '

         <table width="100%" border="0.1"  cellpadding="5" cellspacing="0" style="border-left:none;">
          <tr>
           <th style="border-left:0;">S/N</th>
           <th style="width:172px;" >Service Name</th>
           <th style="width:60px;">HSN Code</th>
           <th>Qty</th>
           <th style="width:50px;">Price (<img src="https://geteideabill.dotgraffe.com/image/rupay.png" style="width:4px; height:;">)</th>
            <th style="width:70px;">Actual Amt. (<img src="https://geteideabill.dotgraffe.com/image/rupay.png" style="width:4px; height:;">)</th>
            <th style="width:50px;">CGST 9%</th>
            <th style="width:50px;">SGST 9%</th>
             <th style="width:50px;">IGST 18%</th>
             <th  style="width:80px;">Amount (<img src="https://geteideabill.dotgraffe.com/image/rupay.png" style="width:4px; height:;">)</th>


          </tr>';
        $statement = $connect->prepare("SELECT * FROM inv_order_item WHERE order_id = :order_id");
        $statement->execute(array(':order_id' => $_GET["id"]));
        $item_result = $statement->fetchAll();
        $count = 0;
        if ($statename == 'Haryana (06)') {
            foreach ($item_result as $sub_row) {
                $qty = $sub_row["order_item_quantity"];
                $discountam = $sub_row['discount_amount'];
                $actulprice = $sub_row["order_item_actual_amount"];
                $finalactul = $actulprice - $discountam;
                $seinglprice = $finalactul / $qty;
                $count++;
                $texc = $sub_row['order_item_final_amount'];
                $totalex = $texc * 9 / 100;
                $secontex = $texc * 9 / 100;
                $rounded_tax = number_format($totalex, 2);
                $finalamunt = $texc + $totalex + $secontex;
                $rounded_value = number_format($finalamunt, 2);
                $output.= '
        <tr>
         <td style="border-right:0; border-left:0;">' . $count . '</td>
         <td><div calss="test-heading" style="font-weight: 600;">' . $sub_row["service_type"] . '</div> ' . $sub_row["item_name"] . '</td>
         <td>' . $sub_row["hsn_code"] . '</td>
         <td>' . $sub_row["order_item_quantity"] . '</td>
         <td>' . $seinglprice . '</td>
         <td>' . $finalactul . '</td>
         <td>' . $rounded_tax . '</td>
         <td>' . $rounded_tax . '</td>
         <td></td>
         <td>' . $rounded_value . '</td>


        </tr>
        ';
            }
        } else {
            foreach ($item_result as $sub_row) {
                $qty = $sub_row["order_item_quantity"];
                $discountam = $sub_row['discount_amount'];
                $actulprice = $sub_row["order_item_actual_amount"];
                $finalactul = $actulprice - $discountam;
                $seinglprice = $finalactul / $qty;
                $count++;
                $texc = $sub_row['order_item_final_amount'];
                $igsttaxamount = $texc * 18 / 100;
                $rounded_tax = number_format($igsttaxamount, 2);
                $finalamunt = $texc + $igsttaxamount;
                $rounded_value = number_format($finalamunt, 2);
                $output.= '
        <tr>
         <td>' . $count . '</td>
        <td><div calss="test-heading" style="font-weight: 600;">' . $sub_row["service_type"] . '</div> ' . $sub_row["item_name"] . '</td>
         <td>' . $sub_row["hsn_code"] . '</td>
         <td>' . $sub_row["order_item_quantity"] . '</td>
         <td>' . $seinglprice . '</td>
         <td>' . $finalactul . '</td>
         <td></td>
         <td></td>
         <td>' . $rounded_tax . '</td>
         <td>' . $rounded_value . '</td>



        </tr>
        ';
            }
        }
        $statement = $connect->prepare("SELECT * FROM additional_service WHERE order_id = :order_id");
        $statement->execute(array(':order_id' => $_GET["id"]));
        $ad_result = $statement->fetchAll();
        $count = 0;
        foreach ($ad_result as $addi_service) {
            $asname = $addi_service["as_name"];
            if (!empty($asname)) {
                $count++;
                $output.= '
      <tr>
       <td>' . $count . '</td>
       <td>' . $addi_service["as_name"] . '</td>
       <td>' . $addi_service["as_qunty"] . '</td>
       <td>' . $addi_service["as_price"] . '</td>
       <td>' . $addi_service["as_actulprice"] . '</td>
       <td>' . $addi_service["cgst_rate"] . '</td>
       <td>' . $addi_service["cgst_amount"] . '</td>
       <td>' . $addi_service["sgst_rate"] . '</td>
       <td>' . $addi_service["sgst_amount"] . '</td>
       <td>' . $addi_service["igst_rate"] . '</td>
       <td>' . $addi_service["igst_amount"] . '</td>
       <td>' . $addi_service["total_price"] . ' </td>


      </tr>
      ';
            } else {
                $output.= '
     <!-- <tr>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
      </tr> -->
      ';
            }
        }
        if ($statename == 'Haryana (06)') {
            $amountbefortax = $row["order_total_after_tax"];
            $totltax = $amountbefortax * 9 / 100;
            $loctotaltax = $amountbefortax * 18 / 100;
            $rounded_tax = number_format($totltax, 2);
            $finalprice = $amountbefortax + $loctotaltax;
            $rounded_value = number_format($finalprice, 2);
            $output.= '
     <tr>
       <td align="right" colspan="6" style="border-left:0;" ><b>Total</b><th>' . $rounded_tax . '</th> <th>' . $rounded_tax . '</th><th>0.00</th> </td>
      <td align="right" class="rupay-img-inline"><b><span class="fa fa-inr fa_custom"></span><li><img src="https://geteideabill.dotgraffe.com/image/rupay.png" style="width:5px; height:;"></li> <li>' . $rounded_value . '</li></span></b></td>
     </tr>
     ';
        } else {
            $amountbefortax = $row["order_total_after_tax"];
            $loctotaltax = $amountbefortax * 18 / 100;
            $rounded_tax = number_format($loctotaltax, 2);
            $finalprice = $amountbefortax + $loctotaltax;
            $rounded_value = number_format($finalprice, 2);
            $output.= '
     <tr>
       <td align="right" colspan="6"><b>Total</b><th>0.00</th> <th>0.00</th><th>' . $rounded_tax . '</th> </td>
       <td align="right" class="rupay-img-inline"><b><span class="fa fa-inr fa_custom"></span><li><img src="https://geteideabill.dotgraffe.com/image/rupay.png" style="width:5px; height:;"></li> <li>' . $rounded_value . '</li></span></b></td>
     </tr>
     ';
        }
        $amountbefortax = $row["order_total_after_tax"];
        $totltax = $amountbefortax * 18 / 100;
        $rounded_tax = number_format($totltax, 2);
        $finalprice = $amountbefortax + $totltax;
        $totalprc = $finalprice;
        $whole = floor($totalprc);
        $fraction = $totalprc - $whole;
        $rounded_digit = number_format($fraction, 2);
        //$double = $finalprice
        //$test = intval($double) . '.' . substr(end(explode('.', $double)), 0, 2);
        if ($rounded_digit > 0.50) {
            $admaunt = "0.99";
            $adam = $admaunt - $rounded_digit + 0.01;
            $finalprice = $amountbefortax + $totltax;
            $totalam = $finalprice + 1;
            $totalpric = floor($totalam);
            $output.= '

   <tr>
     <td align="right" colspan="9" style="border-left:0;">Less : Rounded Off(+)<th>' . $adam . '</th>  </td>
   </tr>


   ';
        } else {
            $finalprice = $amountbefortax + $totltax;
            $totalam = $finalprice;
            $totalpric = floor($totalam);
            $output.= '

  <tr>
    <td align="right" colspan="9" style="border-left:0;">Less : Rounded Off(-)<th>' . $rounded_digit . '</th>  </td>
  </tr>


  ';
        }
        $amountbefortax = $row["order_total_after_tax"];
        $totltax = $amountbefortax * 18 / 100;
        $rounded_tax = number_format($totltax, 2);
        $finalprice = $amountbefortax + $totltax;
        $rounded_value = number_format($finalprice, 2);
        function getIndianCurrency(float $number) {
            $no = floor($number);
            $decimal = round($number - $no, 2) * 100;
            $decimal_part = $decimal;
            $hundred = null;
            $hundreds = null;
            $digits_length = strlen($no);
            $decimal_length = strlen($decimal);
            $i = 0;
            $str = array();
            $str2 = array();
            $words = array(0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
            while ($i < $digits_length) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i+= $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
                } else $str[] = null;
            }
            $d = 0;
            while ($d < $decimal_length) {
                $divider = ($d == 2) ? 10 : 100;
                $decimal_number = floor($decimal % $divider);
                $decimal = floor($decimal / $divider);
                $d+= $divider == 10 ? 1 : 2;
                if ($decimal_number) {
                    $plurals = (($counter = count($str2)) && $decimal_number > 9) ? 's' : null;
                    $hundreds = ($counter == 1 && $str2[0]) ? ' and ' : null;
                    @$str2[] = ($decimal_number < 21) ? $words[$decimal_number] . ' ' . $digits[$decimal_number] . $plural . ' ' . $hundred : $words[floor($decimal_number / 10) * 10] . ' ' . $words[$decimal_number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
                } else $str2[] = null;
            }
            $Rupees = implode('', array_reverse($str));
            $paise = implode('', array_reverse($str2));
            $paise = ($decimal_part > 0) ? $paise . ' Paise' : '';
            return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
        }
        $amount = $totalpric;
        $toword = getIndianCurrency($amount);
        $output.= '
     <tr>
      <td colspan="9" style="border-left:0;"><b>Total Amount Before Tax :</b></td>
      <td align="right"><img src="https://geteideabill.dotgraffe.com/image/rupay.png" style="width:5px; height:;"> ' . $row["order_total_after_tax"] . '</td>
     </tr>
     <tr>
      <td colspan="9" style="border-left:0;"><b>Total Tax Amount:</b></td>
      <td align="right"><img src="https://geteideabill.dotgraffe.com/image/rupay.png" style="width:5px; height:;"> ' . $rounded_tax . '</td>
     </tr>
     <tr style="background: #fff; color: #000" boder-left:0;>
      <td colspan="9" style="border-left:0.1;"><b>Total Amount After Tax :</b></td>
      <td align="right"><img src="https://geteideabill.dotgraffe.com/image/rupay.png" style="width:5px; height:;"> ' . $totalpric . '.00</td>
     </tr>
     <tr>
      <td colspan="5" style="border-left:0;"><b>Total Amount In Word :</b></td>
      <td colspan="7" align="right" style="text-transform: capitalize;" style="border-left:0;">' . $toword . ' Only</td>
     </tr>

     ';
        $output.= '
         </table>
        </td>
       </tr>
      </table>
     ';

    if(!empty($row["payoption"])){
      $output.= '
      <div class="row border-half bank_details"  style="display:block; padding:5px 5px; ">
      <span><b>Payment Mode</b></span>
      <span style="font-size:10px;">' . $row["payoption"] . ' '.$row["checq_no"].' '.$row["bank_name"].' '.$row["upi_id"].' '.$row["nfet_no"].'</span>
  </div>
      ';
    }
    if(!empty($row["remarks"])){
      $output.= '
      <div class="row border-half bank_details"  style="display:block; padding:5px 5px; ">
          <span><b>Remarks</b></span>
          <span style="font-size:10px;">' . $row["remarks"] . '</span>
          </div>
      ';
    }
    $statement = $connect->prepare("SELECT * FROM footer WHERE id = :order_id LIMIT 1");
    $statement->execute(array(':order_id' => 1));
    $footer = $statement->fetchAll();
    foreach ($footer as $rowss) {
        $output.= '
    <footer>

    <div class="row border-half bank_details"  style="display:block; padding:5px 5px; ">
        <span><b>Bank Details:</b></span>
        <span style="font-size:10px;">HDFC Bank A/c No.- 50200059187526</span>
        <span style="font-size:10px;">IFSC Code : HDFC0000108, Branch:Panchkula Sector 8 Chandigarh - 134109</span>
    </div>

    <div class="row" style="margin-top:28px; margin-bottom:-28px;  position:relative; padding:0 5px; ">
        <div class="col-sm-5 terms_" style="margin-top:0px;" >
            <div class="content" style="position:absolute; top: -130px;" >
            <h4><u>Terms & Conditions</u></h4>
            <h4 style="margin-top:2px;font-weight:400; margin-bottom:5px;">E.& O.E.</h4>
            <h5 style="font-weight:400;"> 1. Goods once sold will not be taken back. </h5>
            <h5 style="font-weight:400; padding-top:5px;"> 2. Interest @ 18% p.a. will be charged if the payment is not made with in the stipulated time.</h5>
            <h5 style="font-weight:400; padding-top:5px;"> 3. Subject to <span>Panchkula</span> Jurisdiction only.</h5>
            </div>
        </div>

        <div class="col-sm-2 paytm-img" style="padding-bottom:2px"><div class="upi-img"><img src="https://geteideabill.dotgraffe.com/image/upi.png" width="30px" style="margin-top:4px; margin-bottom:0px;"></div><img src="https://geteideabill.dotgraffe.com/image/' . $rowss["Qr_image"] . '" width="120px" style="margin-top:1px; margin-bottom:0px;">
        </div>

             <div class="col-sm-5" style="position:relative;">

           <span style="position:absolute; top: -130px; "> <div class="receiver-border" style="border-bottom:solid 1px #000; padding-bottom:25px;">Receiver Signature :</div></span>
           <span class="div_sign"></span>
           <h4 style="position:absolute; top: -70px; text-align:center; left:35%;"> for GET  E IDEAS</h4>
           <h5 style="position:absolute; top: -30px;  left:35%;"> Authorised Signatory</h5>

        </div>
     </div>

   </footer>
   </div>
    ';
    }
  }
    $pdf = new Pdf();
    $file_name = 'GEI-' . $invoiceno . ' ' . $username . '.pdf';
    $pdf->loadHtml($output);
    $pdf->render();
    $pdf->stream($file_name, array("Attachment" => false));
}
?>
