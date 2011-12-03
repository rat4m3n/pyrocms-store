<?php

class PayPalAPI {

	/**
	 * PayPal environment variables
	 */
	protected $API_ENVIRONMENT;
	protected $API_USERNAME;
	protected $API_PASSWORD;
	protected $API_SIGNATURE;
	protected $API_ENDPOINT;
	protected $VERSION;
	protected $SUBJECT;
	protected $USE_PROXY;
	protected $PROXY_HOST;
	protected $PROXY_PORT;
	protected $USE_PAYPAL_URL;
	protected $PAYPAL_URL;
	protected $SHOW_ERRORS = FALSE;
	protected $SHOW_RESPONSE = FALSE;

	/**
	 * NVP Variables
	 */
	public $nvpHeader;
	public $nvpStr;
	public $nvpReq;
	public $nvpArray = array();
	public $reqArray = array();
	public $resArray = array();
	public $nvpResArray = array();
	public $nvpReqArray = array();
	public $response;
	public $ack;
	public $errorOccurred;

	/**
	 * authorization mode constants
	 */
	public $getAuthModeFromConstantFile;
	public $AuthMode;

	/**
	 * PayPal Variables
	 */
	public $methodName;
	public $paymentType;
	public $firstName;
	public $lastName;
	public $address1;
	public $address2;
	public $city;
	public $state;
	public $zip;
	public $creditCardType;
	public $creditCardNumber;
	public $encryptedCreditCardNumber;
	public $expDateMonth;
	public $padDateMonth;
	public $expDateYear;
	public $cvv2Number;
	public $amount;
	public $custom;
	public $countryCode = 'US';
	public $currencyCode = 'USD';
	public $paymentAction = 'Sale';
	public $emailAddress;
	public $token;
	public $paymentAmount;
	public $currCodeType;
	public $payerID;
	public $serverName;
	public $authorizationID;
	public $completeCodeType;
	public $invoiceID;
	public $currency;
	public $note;
	public $transactionID;
	public $refundType;
	public $memo;
	public $action;
	public $emailSubject;
	public $receiverType;
	public $startDateStr;
	public $endDateStr;
	public $iso_start;
	public $iso_end;
	public $profileID;

	//recurring profiles variables
	public $profileDesc;
	public $billingPeriod;
	public $billingFrequency;
	public $totalBillingCycles;
	public $profileStartDateDay;
	public $padprofileStartDateDay;
	public $profileStartDateMonth;
	public $padprofileStartDateMonth;
	public $profileStartDateYear;
	public $profileStartDate;
	public $initAmount;
	public $failedInitAmountAction;

	public $eciFlag;
	public $cavv;
	public $xid;
	public $enrolled;
	public $pAResStatus;

	public function __construct() {
		$this->API_ENVIRONMENT = 'sandbox';
		$this->USE_PROXY = FALSE;
		$this->USE_PAYPAL_URL = FALSE;

		if(strtolower($this->API_ENVIRONMENT) == 'sandbox') {
			$this->API_USERNAME = 'paypal_1280477328_biz_api1.nojobmonsterhere.com';
			$this->API_PASSWORD = '1280477339';
			$this->API_SIGNATURE = 'ASeFDs5cKWtSVoLGLiLWCeHMnnbYAFjGCMlUc7Hbheyr5zd8wDPNZRGE';
			$this->API_ENDPOINT = 'https://api-3t.sandbox.paypal.com/nvp';
			$this->VERSION = '63.0';
			$this->SUBJECT = '';
		} elseif(strtolower($this->API_ENVIRONMENT) == 'live') {
			$this->API_USERNAME = 'payment_api1.nojobmonsterhere.com';
			$this->API_PASSWORD = 'PSC8ZFG7EGJVTP9L';
			$this->API_SIGNATURE = 'AP3Nm5KP5DtFz2GI1TPc1j9abL3lAf45wqkcsEj-.ZXrbjeayI6mHmxj';
			$this->API_ENDPOINT = 'https://api-3t.paypal.com/nvp';
			$this->VERSION = '63.0';
			$this->SUBJECT = '';
		}

		if($this->USE_PROXY == TRUE) {
			$this->PROXY_HOST = '';
			$this->PROXY_PORT = '';
		}

		//if you're directing users to the paypal site you must have the paypal URL
		if($this->USE_PAYPAL_URL == TRUE) {
			if(strtolower($this->API_ENVIRONMENT) == 'sandbox') {
				$this->PAYPAL_URL = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
			} elseif(strtolower($this->API_ENVIRONMENT) == 'live') {
				$this->PAYPAL_URL = '';
			}
		}

	}

	public function __destruct() {

	}

	public function DoAuthorization() {
		$this->methodName = "DoAuthorization";

		$orderId = urlencode($_SESSION['order_id']);
		$amount = urlencode($_SESSION['amount']);
		$currency = urlencode($_SESSION['currency']);

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpStr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr = "&TRANSACTIONID=$orderId&AMT=$amount&CURRENCYCODE=$currency";

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<font size=2 color=black face=Verdana><b>Do Authorization</b></font>
				<br><br>
		
				<b>Authorization Response details:</b><br><br>
		
			    <table class="api">
			<?php $this->ShowAllResponse(); ?>
				</table>
			</center>		
			<?php
		}
	}

	public function DoReauthorization() {
		$this->methodName = "DoReauthorization";

		$this->authorizationID=urlencode($_SESSION['authorizationID']);
		$this->amount=urlencode($_SESSION['amount']);
		$this->currency=urlencode($_SESSION['currency']);

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpstr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr="&AUTHORIZATIONID=".$this->authorizationID."&AMT=".$this->amount."&CURRENCYCODE=".$this->currency;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<font size=2 color=black face=Verdana><b>Do Authorization</b></font>
				<br><br>
		
				<b>Reauthorization Response details:</b><br><br>
		
			    <table class="api">
					<?php $this->ShowAllResponse(); ?>
				</table>
			</center>		
			<?php
		}
	}

	public function DoExpressCheckoutPayment() {
		$this->methodName = "DoExpressCheckoutPayment";

		ini_set('session.bug_compat_42',0);
		ini_set('session.bug_compat_warn',0);

		/* Gather the information to make the final call to
		finalize the PayPal payment.  The variable nvpStr
		holds the name value pairs
		*/
		$this->token =urlencode( $_SESSION['token']);
		$this->paymentAmount =urlencode ($_SESSION['TotalAmount']);
		if(isset($_SESSION['paymentType'])) {$this->paymentType = urlencode($_SESSION['paymentType']); }
		$this->currCodeType = urlencode($_SESSION['currCodeType']);
		$this->payerID = urlencode($_SESSION['payer_id']);
		$this->serverName = urlencode($_SERVER['SERVER_NAME']);

		$this->nvpStr = '&TOKEN='.$this->token.'&PAYERID='.$this->payerID.'&PAYMENTACTION='.$this->paymentAction.'&AMT='.$this->paymentAmount.
		'&CURRENCYCODE='.$this->currCodeType.'&IPADDRESS='.$this->serverName ;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
	    		<table width =400>
	         		<?php $this->ShowAllResponse(); ?>
	    		</table>
	    	</center>
			<?php
		}
	}

	public function DoDirectPayment() {
		$this->methodName = "DoDirectPayment";

		//Get required parameters from the web form for the request
		if(isset($_SESSION['paymentType'])) {$this->paymentType = urlencode($_SESSION['paymentType']); }
		$this->firstName =urlencode( $_SESSION['firstName']);
		$this->lastName =urlencode( $_SESSION['lastName']);
		$this->creditCardType =urlencode( $_SESSION['creditCardType']);
		$this->creditCardNumber = urlencode($_SESSION['creditCardNumber']);
		$this->encryptedCreditCardNumber = str_pad(substr($this->creditCardNumber, strlen($this->creditCardNumber) - 4), strlen($this->creditCardNumber), 'X', STR_PAD_LEFT);
		$this->expDateMonth =urlencode( $_SESSION['expDateMonth']);

		// Month must be padded with leading zero
		$this->padDateMonth = str_pad($this->expDateMonth, 2, '0', STR_PAD_LEFT);

		$this->expDateYear =urlencode( $_SESSION['expDateYear']);
		$this->cvv2Number = urlencode($_SESSION['cvv2Number']);
		$this->address1 = urlencode($_SESSION['address1']);
		if(isset($_SESSION['address2'])) {
			$this->address2 = urlencode($_SESSION['address2']);
		};
		$this->city = urlencode($_SESSION['city']);
		$this->state =urlencode( $_SESSION['state']);
		$this->zip = urlencode($_SESSION['zip']);
		$this->amount = urlencode($_SESSION['amount']);
		if(isset($_SESSION['currencyCode'])) {
			$this->currencyCode = urlencode($_SESSION['currencyCode']);
		}
		if(isset($_SESSION['custom'])) {
			$this->custom = urlencode($_SESSION['custom']);
		}

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpStr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr = "&PAYMENTACTION=".$this->paymentAction."&AMT=".$this->amount."&CREDITCARDTYPE=".$this->creditCardType."&ACCT=".$this->creditCardNumber.
		"&EXPDATE=".$this->padDateMonth.$this->expDateYear."&CVV2=".$this->cvv2Number."&FIRSTNAME=".$this->firstName."&LASTNAME=".$this->lastName."&STREET=".$this->address1.
		"&CITY=".$this->city."&STATE=".$this->state."&ZIP=".$this->zip."&COUNTRYCODE=".$this->countryCode."&CURRENCYCODE=".$this->currencyCode;

		if(isset($this->custom) && $this->custom != '') {
			$this->nvpStr .= "&CUSTOM=".$this->custom;
		}

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
	    		<table width =400>
	         		<?php $this->ShowAllResponse(); ?>
	    		</table>
	    	</center>
			<?php
		}
	}

	public function DoCapture() {
		$this->methodName = "DoCapture";

		$this->authorizationID=urlencode($_SESSION['authorization_id']);
		$this->completeCodeType=urlencode($_SESSION['CompleteCodeType']);
		$this->amount=urlencode($_SESSION['amount']);
		$this->invoiceID=urlencode($_SESSION['invoice_id']);
		$this->currency=urlencode($_SESSION['currency']);
		$this->note=urlencode($_SESSION['note']);

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpStr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr = "&AUTHORIZATIONID=".$this->authorizationID."&AMT=".$this->amount."&COMPLETETYPE=".$this->completeCodeType.
		"&CURRENCYCODE=".$this->currency."&NOTE=".$this->note;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
			    <table width=400>
			
			        <?php $this->ShowAllResponse(); ?>
			    </table>
		    </center>
			<?php
		}
	}

	public function DoVoid() {
		$this->methodName = 'DoVoid';

		$this->authorizationID=urlencode($_SESSION['authorization_id']);
		$this->note=urlencode($_SESSION['note']);

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpStr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr="&AUTHORIZATIONID=".$this->authorizationID."&NOTE=".$this->note;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<table width =400>
	          		<?php $this->ShowAllResponse(); ?>
	    		</table>
	    	</center>
			<?php
		}
	}

	public function GetBalance() {
		$this->methodName = 'GetBalance';

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpStr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr="";

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<table width =400>
	          		<?php $this->ShowAllResponse(); ?>
	    		</table>
	    	</center>
			<?php
		}
	}

	public function BillOutstandingAmount() {
		$this->methodName = 'BillOutstandingAmount';

		$this->profileID=urlencode($_SESSION['profileID']);
		$this->amount = urlencode($_SESSION['amount']);

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpstr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr = "&PROFILEID=".$this->profileID."&AMT=".$this->amount;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<table width=400>
					<?php 
					foreach($this->resArray as $key => $value) {
						echo "<tr><td>$key:</td><td>$value</td>";
					}
			    	?>
				</table>
			</center>
			<?php
		}
	}

	public function CreateRecurringPaymentsProfile() {
		$this->methodName = 'CreateRecurringPaymentsProfile';

		if(isset($_SESSION['paymentType'])) {$this->paymentType = urlencode($_SESSION['paymentType']); }
		$this->firstName =urlencode( $_SESSION['firstName']);
		$this->lastName =urlencode( $_SESSION['lastName']);
		$this->creditCardType =urlencode( $_SESSION['creditCardType']);
		$this->creditCardNumber = urlencode($_SESSION['creditCardNumber']);
		$this->encryptedCreditCardNumber = str_pad(substr($this->creditCardNumber, strlen($this->creditCardNumber) - 4), strlen($this->creditCardNumber), 'X', STR_PAD_LEFT);
		$this->expDateMonth =urlencode( $_SESSION['expDateMonth']);

		// Month must be padded with leading zero
		$this->padDateMonth = str_pad($this->expDateMonth, 2, '0', STR_PAD_LEFT);

		$this->expDateYear =urlencode( $_SESSION['expDateYear']);
		$this->cvv2Number = urlencode($_SESSION['cvv2Number']);
		$this->address1 = urlencode($_SESSION['address1']);
		$this->address2 = urlencode($_SESSION['address2']);
		$this->city = urlencode($_SESSION['city']);
		$this->state =urlencode( $_SESSION['state']);
		$this->zip = urlencode($_SESSION['zip']);
		$this->amount = urlencode($_SESSION['amount']);
		if(isset($_SESSION['currencyCode']) && $_SESSION['currencyCode'] != '') { $this->currencyCode = $_SESSION['currencyCode']; }
		//if(isset($_SESSION['profileDesc'])) { $this->profileDesc = urlencode($_SESSION['profileDesc']); }

		$this->profileDesc = 'Monthly payments to be billed until end of one year subscription unless cancelled by client or merchant';
		$this->billingPeriod = 'Month';
		$this->billingFrequency = '1';

		$this->profileStartDateDay = date('d');
		$this->padprofileStartDateDay = str_pad($this->profileStartDateDay, 2, '0', STR_PAD_LEFT);// Day must be padded with leading zero
		$this->profileStartDateMonth = date('m', strtotime('+1 month'));
		$this->padprofileStartDateMonth = str_pad($this->profileStartDateMonth, 2, '0', STR_PAD_LEFT);// Month must be padded with leading zero
		$this->profileStartDateYear = date('Y');

		$this->profileStartDate = urlencode($this->profileStartDateYear . '-' . $this->padprofileStartDateMonth . '-' . $this->padprofileStartDateDay . 'T00:00:00Z');

		//additional values
		$this->totalBillingCycles = '11';
		if(isset($_SESSION['initAmount'])) { $this->initAmount = urlencode($_SESSION['initAmount']); }
		if(isset($_SESSION['failedInitAmountAction'])) { $this->failedInitAmountAction = urlencode($_SESSION['failedInitAmountAction']); }

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpstr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr = "&INITAMT=".$this->initAmount."&AMT=".$this->amount."&CREDITCARDTYPE=".$this->creditCardType."&ACCT=".$this->creditCardNumber."&EXPDATE=".$this->padDateMonth.$this->expDateYear.
		"&CVV2=".$this->cvv2Number."&FIRSTNAME=".$this->firstName."&LASTNAME=".$this->lastName."&STREET=".$this->address1."&CITY=".$this->city."&STATE=".$this->state.
		"&ZIP=".$this->zip."&COUNTRYCODE=".$this->countryCode."&CURRENCYCODE=".$this->currencyCode."&PROFILESTARTDATE=".$this->profileStartDate."&DESC=".$this->profileDesc.
		"&BILLINGPERIOD=".$this->billingPeriod."&BILLINGFREQUENCY=".$this->billingFrequency."&TOTALBILLINGCYCLES=".$this->totalBillingCycles;
		//echo $this->nvpStr;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<table width=400>
					<?php $this->ShowAllResponse(); ?>
				</table>
			</center>
			<?php
		}
	}

	public function GetRecurringPaymentsProfileDetails() {
		$this->methodName = 'GetRecurringPaymentsProfileDetails';

		$this->profileID=urlencode($_SESSION['profileID']);

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpstr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr = "&PROFILEID=".$this->profileID;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<table width=400>
					<?php 
					foreach($this->resArray as $key => $value) {
						echo "<tr><td>$key:</td><td>$value</td>";
					}
			    	?>
				</table>
			</center>
			<?php
		}
	}

	public function ManageRecurringPaymentsProfileStatus() {
		$this->methodName = 'ManageRecurringPaymentsProfileStatus';

		$this->profileID = urlencode($_SESSION['profileID']);
		$this->action = urlencode($_SESSION['action']) ;

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpstr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr = "&PROFILEID=".$this->profileID."&ACTION=".$this->action;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<table width=400>
					<?php 
					foreach($this->resArray as $key => $value) {
						echo "<tr><td>$key:</td><td>$value</td>";
					}
			    	?>
				</table>
			</center>
			<?php
		}
	}

	public function MassPay() {
		$this->methodName = 'MassPay';

		//Get required parameters from the web form for the request
		$this->emailSubject =urlencode($_SESSION['emailSubject']);
		$this->receiverType = urlencode($_SESSION['receiverType']);
		$this->currency = urlencode($_SESSION['currency']);

		$this->nvpStr = '';

		$count= count($_SESSION['receiveremail']);
		for($i=0,$j=0;$i<$count;$i++) {
			if (isset($_SESSION['receiveremail'][$i]) && $_SESSION['receiveremail'][$i]!='' ) {
				$receiverEmail = urlencode($_SESSION['receiveremail'][$i]);
				$amount = urlencode($_SESSION['amount'][$i]);
				$uniqueID = urlencode($_SESSION['uniqueID'][$i]);
				$note = urlencode($_SESSION['note'][$i]);
				$this->nvpStr.="&L_EMAIL$j=$receiverEmail&L_Amt$j=$amount&L_UNIQUEID$j=$uniqueID&L_NOTE$j=$note";
				$j++;
			}
		}
		/* Construct the request string that will be sent to PayPal.
		The variable $nvpStr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr.="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency";

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<table width =400>
	          		<?php $this->ShowAllResponse(); ?>
	    		</table>
	    	</center>
			<?php
		}
	}

	public function Refund() {
		$this->methodName = 'RefundTransaction';

		$this->transactionID = urlencode($_SESSION['transactionID']);
		$this->refundType = urlencode($_SESSION['refundType']);
		$this->amount = urlencode($_SESSION['amount']);
		$this->currency = urlencode($_SESSION['currency']);
		$this->memo = urlencode($_SESSION['memo']);

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpstr contains all the variables and is a
		name value pair string with & as a delimiter */

		$this->nvpStr = "&TRANSACTIONID=".$this->transactionID."&REFUNDTYPE=".$this->refundType."&CURRENCYCODE=".$this->currency."&NOTE=".$this->memo;
		if(strtoupper($this->refundType)=="PARTIAL") $this->nvpStr = $this->nvpStr."&AMT=".$amount;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<table width =400>
	          		<?php $this->ShowAllResponse(); ?>
	    		</table>
	    	</center>
			<?php
		}
	}

	public function ThreeDSecure() {
		$this->methodName = '';

		$this->paymentType =urlencode( $_SESSION['paymentType']);
		$this->firstName =urlencode( $_SESSION['firstName']);
		$this->lastName =urlencode( $_SESSION['lastName']);
		$this->creditCardType =urlencode( $_SESSION['creditCardType']);
		$this->creditCardNumber = urlencode($_SESSION['creditCardNumber']);
		$this->encryptedCreditCardNumber = str_pad(substr($this->creditCardNumber, strlen($this->creditCardNumber) - 4), strlen($this->creditCardNumber), 'X', STR_PAD_LEFT);
		$this->expDateMonth =urlencode( $_SESSION['expDateMonth']);
		$this->startDateMonth =urlencode( $_SESSION['startDateMonth']);

		// Month must be padded with leading zero
		$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		$padStartDateMonth = str_pad($startDateMonth, 2, '0', STR_PAD_LEFT);

		$this->expDateYear =urlencode( $_SESSION['expDateYear']);
		$this->startDateYear =urlencode( $_SESSION['startDateYear']);
		$this->cvv2Number = urlencode($_SESSION['cvv2Number']);
		$this->address1 = urlencode($_SESSION['address1']);
		$this->address2 = urlencode($_SESSION['address2']);
		$this->city = urlencode($_SESSION['city']);
		$this->state =urlencode( $_SESSION['state']);
		$this->zip = urlencode($_SESSION['zip']);
		$this->amount = urlencode($_SESSION['amount']);
		if(isset($_SESSION['paymentType'])) {$this->paymentType = urlencode($_SESSION['paymentType']); }
		if(isset($_SESSION['currencyCode']) && $_SESSION['currencyCode'] != '') {
			$this->currencyCode = $_SESSION['currencyCode'];
		}

		//3D Secure fields
		$this->eciFlag = urlencode($_SESSION['eciFlag']);
		$this->cavv = urlencode($_SESSION['cavv']);
		$this->xid = urlencode($_SESSION['xid']);
		$this->enrolled = urlencode($_SESSION['enrolled']);
		$this->pAResStatus = urlencode($_SESSION['pAResStatus']);

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpstr contains all the variables and is a
		name value pair string with & as a delimiter */
		$this->nvpStr = "&PAYMENTACTION=".$this->paymentAction."&AMT=".$this->amount."&CREDITCARDTYPE=".$this->creditCardType.
		"&ACCT=".$this->creditCardNumber."&EXPDATE=".$this->padDateMonth.$this->expDateYear."&CVV2=".$this->cvv2Number.
		"&FIRSTNAME=".$this->firstName."&LASTNAME=".$this->lastName."&STREET=".$this->address1."&CITY=".$this->city."&STATE=".$this->state.
		"&ZIP=".$zip."&COUNTRYCODE=".$this->countryCode."&CURRENCYCODE=".$this->currencyCode."&STARTDATE=".$this->padStartDateMonth.$this->startDateYear.
		"&ECI3DS=".$this->eciFlag."&CAVV=".$this->cavv."&XID=".$this->xid."&MPIVENDOR3DS=".$this->enrolled."&AUTHSTATUS3DS=".$this->pAResStatus;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<table width =400>
	          		<?php $this->ShowAllResponse(); ?>
	    		</table>
	    	</center>
			<?php
		}
	}

	public function TransactionSearchResults() {
		$this->methodName = 'TransactionSearch';

		$this->nvpStr = '';

		$this->startDateStr=$_SESSION['startDateStr'];
		$this->endDateStr=$_SESSION['endDateStr'];
		$this->transactionID=urlencode($_SESSION['transactionID']);
		if(isset($this->startDateStr)) {
			$this->start_time = strtotime($this->startDateStr);
			$this->iso_start = date('Y-m-d\T00:00:00\Z',  $this->start_time);
			$this->nvpStr="&STARTDATE=".$this->iso_start;
		}

		if(isset($this->endDateStr)&&$this->endDateStr!='') {
			$this->end_time = strtotime($this->endDateStr);
			$this->iso_end = date('Y-m-d\T24:00:00\Z', $this->end_time);
			$this->nvpStr.="&ENDDATE=".$this->iso_end;
		}

		if($this->transactionID!='')
		$this->nvpStr = $this->nvpStr."&TRANSACTIONID=".$this->transactionID;

		$this->DoAPICall();

		if($this->errorOccurred == false) {
			?>
			<center>
				<font size=3 color=black face=Verdana><b>Transaction Search Results</b></font>
				<br><br>
				    <table class="api">
						<?php  if(!isset($this->resArray["L_TRANSACTIONID0"])){ //checking for Transaction ID in NVP response ?>
							<tr>
								<td colspan="6" class="field">No Transaction Selected</td>
							</tr>
						<?php 
						}else {
							$count=0;
							//counting no.of  transaction IDs present in NVP response arrray.
							while (isset($this->resArray["L_TRANSACTIONID".$count]))
							$count++;
					?>	
						<tr>
			            <td colspan="6" class="thinfield">
			                 Results - <? echo $count; ?>
			            </td>
			        </tr>
			        <tr>
			            <td ></td>
			            <td ><b>ID</b></td>
			            <td ><b>Time</b></td>
			            <td ><b>Status</b></td>
			            <td ><b>Payer Name</b></td>
			            <td ><b>Gross Amount</b></td>
			        </tr>
			        
					<?php 
					$ID=0;
					while ($count>0) {
						$transactionID = $this->resArray["L_TRANSACTIONID".$ID];
						$timeStamp = $this->resArray["L_TIMESTAMP".$ID];
						$payerName  = $this->resArray["L_NAME".$ID];
						$amount  = $this->resArray["L_AMT".$ID];
						$status  = $this->resArray["L_STATUS".$ID];
						$count--; $ID++;
					?>
						    <tr>
							    <td><?=$ID ?></td>
					            <td><a id="TransactionDetailsLink0"  href="TransactionDetails.php?transactionID=<?=$transactionID ?>"><?=$transactionID ?></a></td>
					            <td><?=$timeStamp?> <!--12/7/2005 9:57:58 AM--></td>
					            <td><?=$status?></td>
					            <td><?=$payerName?></td>
					            <td>USD<?=$amount?></td>
					        </tr>
					<?php }// while
					}//else ?>
			     </table>
		    </center><?php
		}
	}

	public function DoAPICall() {
		$this->errorOccurred = false;
		$this->getAuthModeFromConstantFile = true;
		//$this->getAuthModeFromConstantFile = false;
		$this->nvpHeader = "";

		if(!$this->getAuthModeFromConstantFile) {
			//$this->AuthMode = "3TOKEN"; //Merchant's API 3-TOKEN Credential is required to make API Call.
			//$this->AuthMode = "FIRSTPARTY"; //Only merchant Email is required to make EC Calls.
			$this->AuthMode = "THIRDPARTY"; //Partner's API Credential and Merchant Email as Subject are required.
		} else {
			if(!empty($this->API_USERNAME) && !empty($this->API_PASSWORD) && !empty($this->API_SIGNATURE) && !empty($this->SUBJECT)) {
				$this->AuthMode = "THIRDPARTY";
			}else if(!empty($this->API_USERNAME) && !empty($this->API_PASSWORD) && !empty($this->API_SIGNATURE)) {
				$this->AuthMode = "3TOKEN";
			}else if(!empty($this->SUBJECT)) {
				$this->AuthMode = "FIRSTPARTY";
			}
		}

		switch($this->AuthMode) {

			case "3TOKEN" :
				$this->nvpHeader = "&PWD=".urlencode($this->API_PASSWORD)."&USER=".urlencode($this->API_USERNAME)."&SIGNATURE=".urlencode($this->API_SIGNATURE);
				break;
			case "FIRSTPARTY" :
				$this->nvpHeader = "&SUBJECT=".urlencode($this->SUBJECT);
				break;
			case "THIRDPARTY" :
				$this->nvpHeader = "&PWD=".urlencode($this->API_PASSWORD)."&USER=".urlencode($this->API_USERNAME)."&SIGNATURE=".urlencode($this->API_SIGNATURE)."&SUBJECT=".urlencode($this->SUBJECT);
				break;

		}

		$this->nvpStr = $this->nvpHeader.$this->nvpStr;
		//echo $this->nvpStr;

		/* Make the API call to PayPal, using API signature.
		The API response is stored in an associative array called $resArray */
		$this->hash_call();

		/* Next, collect the API request in the associative array $reqArray
		as well to display back to the browser.
		Normally you wouldnt not need to do this, but its shown for testing */

		$this->reqArray = $_SESSION['nvpReqArray'];

		/* Display the API response back to the browser.
		If the response from PayPal was a success, display the response parameters'
		If the response was an error, display the errors received using APIError.php.
		*/
		$this->ack = strtoupper($this->resArray["ACK"]);

		if($this->ack != "SUCCESS"){
			$_SESSION['reshash'] = $this->resArray;
			$this->APIError();
			$this->errorOccurred = true;
		} else {
			$this->errorOccurred = false;
		}
	}

	/**
	 * hash_call: Function to perform the API call to PayPal using API signature
	 * returns an associtive array containing the response from the server.
	 */
	public function hash_call() {

		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->API_ENDPOINT);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		//if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
		//Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php
		if($this->USE_PROXY) {
			curl_setopt($ch, CURLOPT_PROXY, $this->PROXY_HOST.":".$this->PROXY_PORT);
		}

		//check if version is included in $nvpStr else include the version.
		if(strlen(str_replace('VERSION=', '', strtoupper($this->nvpStr))) == strlen($this->nvpStr)) {
			$this->nvpStr = "&VERSION=" . urlencode($this->VERSION) . $this->nvpStr;
		}

		$this->nvpReq = "METHOD=".urlencode($this->methodName).$this->nvpStr;

		//setting the nvpReq as POST FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$this->nvpReq);

		//getting response from server
		$this->response = curl_exec($ch);

		//convrting nvpResponse to an Associative Array
		$this->nvpResArray = $this->deformatNVP($this->response);
		$this->nvpReqArray = $this->deformatNVP($this->nvpReq);
		$_SESSION['nvpReqArray'] = $this->nvpReqArray;

		if (curl_errno($ch)) {
			// moving to display page to display curl errors
			$_SESSION['curl_error_no'] = curl_errno($ch) ;
			$_SESSION['curl_error_msg'] = curl_error($ch);
			$this->APIError();
		} else {
			//closing the curl
			curl_close($ch);
		}

		$this->resArray = $this->nvpResArray;
	}

	/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
	 * It is usefull to search for a particular key and displaying arrays.
	 * @nvpStr is NVPString.
	 * @nvpArray is Associative Array.
	 */
	function deformatNVP($nvpStr) {
		$intial=0;
		$nvpArray = array();

		while(strlen($nvpStr)){
			//postion of Key
			$keypos= strpos($nvpStr,'=');
			//position of value
			$valuepos = strpos($nvpStr,'&') ? strpos($nvpStr,'&'): strlen($nvpStr);

			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpStr,$intial,$keypos);
			$valval=substr($nvpStr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpStr=substr($nvpStr,$valuepos+1,strlen($nvpStr));
		}
		//echo "<pre>"; var_dump($nvpArray); echo "</pre>";
		return $nvpArray;
	}

	public function ShowAllResponse() {
		if($this->SHOW_RESPONSE == TRUE) {
			?>
			<table class="api" width=400>
		        <?php
		        if(isset($this->resArray) && is_array($this->resArray)) {
		        	foreach($this->resArray as $key => $value) {
		        		echo "<tr><td> $key:</td><td>$value</td>";
		        	}
		        }
		        ?>
	  		</table>
	  		<?php
		}
	}

	public function APIError() {
		if($this->SHOW_ERRORS == TRUE) {
			$this->resArray=$_SESSION['reshash'];
			?>
			
			<center>
				<table width="280">
					<tr>
						<td colspan="2" class="header">The API has returned an error!</td>
					</tr>
				
					<?php  //it will print if any URL errors 
			if(isset($_SESSION['curl_error_no'])) {
				$errorCode= $_SESSION['curl_error_no'] ;
				$errorMessage=$_SESSION['curl_error_msg'] ;
				session_unset();
					?>
				   
					<tr>
							<td>Error Number:</td>
							<td><?= $errorCode ?></td>
					</tr>
					<tr>
						<td>Error Message:</td>
						<td><?= $errorMessage ?></td>
					</tr>
				</table>
			</center>
			<?php } else {

				/* If there is no URL Errors, Construct the HTML page with
				Response Error parameters.
				*/
			?>
			
			<center>
				<font size=2 color=black face=Verdana><b></b></font>
				<br><br>
			
				<b>API Error</b><br><br>
				
			    <table width = 400>
			    	<?php $this->ShowAllResponse(); ?>
			    </table>
			    </center>		
				
			<?php 
			}// end else
			?>
			</center>
				</table>
			<br><?php
		}
	}

}

?>