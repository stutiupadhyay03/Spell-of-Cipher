<?php 

if(!empty($_GET['participant']) and !empty($_GET['rank'])){
  $_POST['email']=$_GET['participant'];
  $_POST['order_id']=$_GET['rank'];
}else {
	header("Location:./e-400.php");	
}

$salt = '822e882a016e7b50c3a67c5dfd16861e62a9d80e'; //Pass your SALT here
$_POST['api_key'] = 'cc2f6077-2656-4d6d-ac1b-9593d95ee49c'; //Pass your API KEY here

$_POST['address_line_1']="";
$_POST['address_line_2']="";
$_POST['amount']=150;
$_POST['city']="Vadodara";
$_POST['country']="India";
$_POST['currency']="INR";
$_POST['description']="SOC";
$_POST['mode']="LIVE";
$_POST['name']="Kalp Vaidya";
$_POST['phone']=8200324879;
$_POST['return_url']="https://spellofcipher.in/redirect.php";
$_POST['state']="";
$_POST['udf1']="Spell of cipher";
$_POST['udf2']="";
$_POST['udf3']="";
$_POST['udf4']="";
$_POST['udf5']="";
$_POST['zip_code']="391750";

$hash = hashCalculate($salt, $_POST);

function hashCalculate($salt,$input){
	/* Columns used for hash calculation, Donot add or remove values from $hash_columns array */
	$hash_columns = ['address_line_1', 'address_line_2', 'amount', 'api_key', 'city', 'country', 'currency', 'description', 'email', 'mode', 'name', 'order_id', 'phone', 'return_url', 'state', 'udf1', 'udf2', 'udf3', 'udf4', 'udf5', 'zip_code',];
	/*Sort the array before hashing*/
	sort($hash_columns);

	/*Create a | (pipe) separated string of all the $input values which are available in $hash_columns*/
	$hash_data = $salt;
	foreach ($hash_columns as $column) {
		if (isset($input[$column])) {
			if (strlen($input[$column]) > 0) {
				$hash_data .= '|' . trim($input[$column]);
			}
		}
	}
	$hash = strtoupper(hash("sha512", $hash_data));
	
	return $hash;
}
?>
<p>Redirecting...</p>
<form action="https://biz.aggrepaypayments.com/v2/paymentrequest" id="payment_form" method="POST">
<input type="hidden" value="<?php echo $hash; ?>"                   name="hash"/>
<input type="hidden" value="<?php echo $_POST['api_key'];?>"        name="api_key"/>
<input type="hidden" value="<?php echo $_POST['return_url']; ?>"    name="return_url"/>
<input type="hidden" value="<?php echo $_POST['mode'];?>"           name="mode"/>
<input type="hidden" value="<?php echo $_POST['order_id'];?>"       name="order_id"/>
<input type="hidden" value="<?php echo $_POST['amount'];?>"         name="amount"/>
<input type="hidden" value="<?php echo $_POST['currency'];?>"       name="currency"/>
<input type="hidden" value="<?php echo $_POST['description'];?>"    name="description"/>
<input type="hidden" value="<?php echo $_POST['name'];?>"           name="name"/>
<input type="hidden" value="<?php echo $_POST['email'];?>"          name="email"/>
<input type="hidden" value="<?php echo $_POST['phone'];?>"          name="phone"/>
<input type="hidden" value="<?php echo $_POST['address_line_1'];?>" name="address_line_1"/>
<input type="hidden" value="<?php echo $_POST['address_line_2'];?>" name="address_line_2"/>
<input type="hidden" value="<?php echo $_POST['city'];?>"           name="city"/>
<input type="hidden" value="<?php echo $_POST['state'];?>"          name="state"/>
<input type="hidden" value="<?php echo $_POST['zip_code'];?>"       name="zip_code"/>
<input type="hidden" value="<?php echo $_POST['country'];?>"        name="country"/>
<input type="hidden" value="<?php echo $_POST['udf1'];?>"           name="udf1"/>
<input type="hidden" value="<?php echo $_POST['udf2'];?>"           name="udf2"/>
<input type="hidden" value="<?php echo $_POST['udf3'];?>"           name="udf3"/>
<input type="hidden" value="<?php echo $_POST['udf4'];?>"           name="udf4"/>
<input type="hidden" value="<?php echo $_POST['udf5'];?>"           name="udf5"/>
<noscript><input type="submit" value="Continue"/></noscript>
</form>
<script>
function formAutoSubmit () {
	var payform = document.getElementById("payment_form");
	payform.submit();
}
window.onload = formAutoSubmit;
</script>
