<?php
// php script START
    
session_start();
$MERCHANT_KEY = $_SESSION['key'];
$SALT = $_SESSION['salt'];
$PAYU_BASE_URL = "https://sandboxsecure.payu.in";
//$PAYU_BASE_URL = "https://secure.payu.in"; //for LIVE MODE

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value;   
  }
}
$formError = 0;
if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['salt'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
      || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
  $hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';  
  foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }
    $hash_string .= $SALT;
    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
    
// php script END
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Donation Page</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        var hash = '<?php echo $hash ?>';
        function submitPayuForm() {
            if(hash == '') {
                return;
            }
            var payuForm = document.forms.payuForm;
            payuForm.submit();
        }
    </script>
  </head>
  <body onload="submitPayuForm()">
    <?php if($formError) { ?>
  
      <span style="color:red; margin-left: 10px; font-weight:bold; font-size:1.2em;">Please fill all Required fields.</span>
      <br/>
      <br/>
    <?php } ?>
    <div class="donate-page">      
      <table style="width:100%; margin-bottom: 5px; color:#ffffff;">
          <tr>
              <td valign="middle" align="center"><h3 class="message">Payment Form</h3></td>
          </tr>
      </table>
      <div class="form">
        <form class="donate-form" action="<?php echo $action; ?>" method="post" name="payuForm">
          <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
          <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
          <p class="message" style="color:#940921; font-size:1em; margin-bottom:5px; font-weight:bold; font-family:roboto;">REQUIRED</p>          
          <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
          <input type="hidden" name="salt" value="<?php echo $SALT ?>" />
          <input name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" placeholder="amount" required/>
          <input name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" placeholder="first name" required/>
          <input type="email" name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" placeholder="email" required/>
          <input name="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" placeholder="phone" required/>
          <input name="productinfo" value="<?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo']?>" placeholder="confirm merchant name" required/>          
          <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
          <input type="hidden" name="surl" value="http://localhost//TestPayment//success.php" size="64" />
          <input type="hidden" name="furl" value="http://localhost//TestPayment//failure.php" size="64" />
          <?php if(!$hash) { ?>
            <td colspan="4"><input type="submit" style="color:#ffffff; background:#16ffa9;" value=" DONATE " id="donate-button"/></td>
          <?php } ?>
          <p class="message" style="font-size:1.1em;">Visit Our Website! <a href="http://localhost//eSharingFinal//" target="_blank">Here</a></p>
        </form>
      </div>
    </div>
  </body>
</html>