<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Donation Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>  
<body onload="submitPayuForm()">
    <div class="donate-page">      
        <table style="width:100%; margin-bottom: 5px; color:#ffffff;">
            <tr>
                <td valign="middle" align="center"><h3 class="message">Select Merchant</h3></td>
            </tr>
        </table>
        <div class="form">
            <form class="donate-form" action="getkey.php" method="post">
                <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                <p class="message" style="color:#940921; font-size:1em; margin-bottom:5px; font-weight:bold; font-family:roboto;"> REQUIRED </p>
                <input name="ngoid" value="<?php echo (empty($posted['key'])) ? '' : $posted['key'] ?>" placeholder="merchant name" />
                <p class="message" style="color:#16ffa9; font-size:1em; margin-bottom:5px; font-weight:bold; font-family:roboto;"> OR </p>
                <input name="key" value="<?php echo (empty($posted['key'])) ? '' : $posted['key'] ?>" placeholder="merchant key" />
                <td colspan="4"><input type="submit" style="color:#ffffff; background:#16ffa9;" value=" DONATE " id="donate-button"/></td>
            </form>
            <p class="message" style="font-size:1.1em;">Visit Our Website! <a href="#" target="_blank"> Here </a></p>
        </div>
    </div>
</body>
</html>