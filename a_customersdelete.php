<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "a_customersinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php include_once "function_1.php"?>
<?php include_once "load_1.php"?>
<?php

//
// Page class
//

$a_customers_delete = NULL; // Initialize page object first

class ca_customers_delete extends ca_customers {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_customers';

	// Page object name
	var $PageObjName = 'a_customers_delete';

    function PageName() {
        $pagename= new function_1();
        return $pagename->PageName1();
    }

    // Page URL
    function PageUrl() {
        $pageurl= new function_1();
        return $pageurl->PageUrl1($this);
    }

    // Message
    function getMessage() {
        $mess= new function_1();
        return $mess->getMessage1();
    }

    function setMessage($v) {
        $mess1= new function_1();
        $mess1->setMessage1($v);
    }

    function getFailureMessage() {
        $failure= new function_1();
        return $failure->getFailureMessage1();
    }

    function setFailureMessage($v) {
        $failure1= new function_1();
        $failure1->setFailureMessage1($v);
    }

    function getSuccessMessage() {
        $success= new function_1();
        return $success->getSuccessMessage1();
    }

    function setSuccessMessage($v) {
        $success1= new function_1();
        $success1->setSuccessMessage1($v);
    }

    function getWarningMessage() {
        $warning= new function_1();
        return $warning->getWarningMessage1();
    }

    function setWarningMessage($v) {
        $warning1= new function_1();
        $warning1->setWarningMessage1($v);
    }

    // Methods to clear message
    function ClearMessage() {
        $clearmess= new function_1();
        $clearmess->ClearMessage1();
    }

    function ClearFailureMessage() {
        $clearf= new function_1();
        $clearf->ClearFailureMessage1();
    }

    function ClearSuccessMessage() {
        $clearsucmess= new function_1();
        $clearsucmess->ClearSuccessMessage1();
    }

    function ClearWarningMessage() {
        $clearw= new function_1();
        $clearw->ClearWarningMessage1();
    }

    function ClearMessages() {
        $clearmess= new function_1();
        $clearmess->ClearMessages1();
    }

    // Show message
    function ShowMessage() {

        $show= new function_1();
        $show->ShowMessage1($this);
    }
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (a_customers)
		if (!isset($GLOBALS["a_customers"]) || get_class($GLOBALS["a_customers"]) == "ca_customers") {
			$GLOBALS["a_customers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["a_customers"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'a_customers', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (users)
		if (!isset($UserTable)) {
			$UserTable = new cusers();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm, $UserTableConn;
		if (!isset($_SESSION['table_a_customers_views'])) { 
			$_SESSION['table_a_customers_views'] = 0;
		}
		$_SESSION['table_a_customers_views'] = $_SESSION['table_a_customers_views']+1;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (IsPasswordExpired())
			$this->Page_Terminate(ew_GetUrl("changepwd.php"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("a_customerslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Begin of modification Auto Logout After Idle for the Certain Time, by Masino Sinaga, May 5, 2012
		if (IsLoggedIn() && !IsSysAdmin()) {

			// Begin of modification by Masino Sinaga, May 25, 2012 in order to not autologout after clear another user's session ID whenever back to another page.           
			$UserProfile->LoadProfileFromDatabase(CurrentUserName());

			// End of modification by Masino Sinaga, May 25, 2012 in order to not autologout after clear another user's session ID whenever back to another page.
			// Begin of modification Save Last Users' Visitted Page, by Masino Sinaga, May 25, 2012

			$lastpage = ew_CurrentPage();
			if ($lastpage!='logout.php' && $lastpage!='index.php') {
				$lasturl = ew_CurrentUrl();
				$sFilterUserID = str_replace("%u", ew_AdjustSql(CurrentUserName(), EW_USER_TABLE_DBID), EW_USER_NAME_FILTER);
				ew_Execute("UPDATE ".EW_USER_TABLE." SET Current_URL = '".$lasturl."' WHERE ".$sFilterUserID."", $UserTableConn);
			}

			// End of modification Save Last Users' Visitted Page, by Masino Sinaga, May 25, 2012
			$LastAccessDateTime = strval(@$UserProfile->Profile[EW_USER_PROFILE_LAST_ACCESSED_DATE_TIME]);
			$nDiff = intval(ew_DateDiff($LastAccessDateTime, ew_StdCurrentDateTime(), "s"));
			$nCons = intval(MS_AUTO_LOGOUT_AFTER_IDLE_IN_MINUTES) * 60;
			if ($nDiff > $nCons) {

				//header("Location: logout.php?expired=1");
			}
		}

		// End of modification Auto Logout After Idle for the Certain Time, by Masino Sinaga, May 5, 2012
		// Update last accessed time

		if ($UserProfile->IsValidUser(CurrentUserName(), session_id())) {

			// Do nothing since it's a valid user! SaveProfileToDatabase has been handled from IsValidUser method of UserProfile object.
		} else {

			// Begin of modification How to Overcome "User X already logged in" Issue, by Masino Sinaga, July 22, 2014
			// echo $Language->Phrase("UserProfileCorrupted");

			header("Location: logout.php");

			// End of modification How to Overcome "User X already logged in" Issue, by Masino Sinaga, July 22, 2014
		}
		if (@MS_USE_CONSTANTS_IN_CONFIG_FILE == FALSE) {

			// Call this new function from userfn*.php file
			My_Global_Check();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

// Begin of modification Disable/Enable Registration Page, by Masino Sinaga, May 14, 2012
// End of modification Disable/Enable Registration Page, by Masino Sinaga, May 14, 2012
		// Page Load event

		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			print "Error: invalid post request";
		}
		if (ALWAYS_COMPARE_ROOT_URL == TRUE) {
			if ($_SESSION['php_stock_Root_URL'] <> Get_Root_URL()) {
                $strDest = check(rawurlencode($_SESSION['php_stock_Root_URL']));
				header("Location: " . $strDest);
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $a_customers;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($a_customers);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				print "Error: failed export";
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		print "Error: invalid specified URL";
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("a_customerslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in a_customers class, a_customersinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Begin of modification (20140916): http://www.hkvforums.com/viewtopic.php?f=4&t=35486&p=102440#p102440
		// Load List page SQL

		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		$load= new load_1();
		$load->LoadRow1($this);
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
        $load1= new load_1();
        $load1->LoadRowValues1($rs,$this);
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
        $load2= new load_1();
        $load2->LoadDbValues1($rs, $this);
	}

	// Render row values based on field settings
	function RenderRow() {
        $render= new load_1();
        $render->RenderRow1($this);
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Customer_ID'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Build export filter for selected records
	function BuildExportSelectedFilter() {
		global $Language;
		$sWrkFilter = "";
		if ($this->Export <> "") {
			$sWrkFilter = $this->GetKeyFilter();
		}
		return $sWrkFilter;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_customerslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url); // v11.0.4
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($a_customers_delete)) $a_customers_delete = new ca_customers_delete();

// Page init
$a_customers_delete->Page_Init();

// Page main
$a_customers_delete->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_customers_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fa_customersdelete = new ew_Form("fa_customersdelete", "delete");

// Form_CustomValidate event
fa_customersdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_customersdelete.ValidateRequired = true;
<?php } else { ?>
fa_customersdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($a_customers_delete->Recordset = $a_customers_delete->LoadRecordset())
	$a_customers_deleteTotalRecs = $a_customers_delete->Recordset->RecordCount(); // Get record count
if ($a_customers_deleteTotalRecs <= 0) { // No record found, exit
	if ($a_customers_delete->Recordset)
		$a_customers_delete->Recordset->Close();
	$a_customers_delete->Page_Terminate("a_customerslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php if (MS_SHOW_PHPMAKER_BREADCRUMBLINKS) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if (MS_SHOW_MASINO_BREADCRUMBLINKS) { ?>
<?php echo MasinoBreadcrumbLinks(); ?>
<?php } ?>
<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="belowheader") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $a_customers_delete->ShowPageHeader(); ?>
<?php
$a_customers_delete->ShowMessage();
?>
<form name="fa_customersdelete" id="fa_customersdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_customers_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_customers_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_customers">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($a_customers_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $a_customers->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($a_customers->Customer_Number->Visible) { // Customer_Number ?>
		<th><span id="elh_a_customers_Customer_Number" class="a_customers_Customer_Number"><?php echo $a_customers->Customer_Number->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_customers->Customer_Name->Visible) { // Customer_Name ?>
		<th><span id="elh_a_customers_Customer_Name" class="a_customers_Customer_Name"><?php echo $a_customers->Customer_Name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_customers->Contact_Person->Visible) { // Contact_Person ?>
		<th><span id="elh_a_customers_Contact_Person" class="a_customers_Contact_Person"><?php echo $a_customers->Contact_Person->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_customers->Phone_Number->Visible) { // Phone_Number ?>
		<th><span id="elh_a_customers_Phone_Number" class="a_customers_Phone_Number"><?php echo $a_customers->Phone_Number->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_customers->Mobile_Number->Visible) { // Mobile_Number ?>
		<th><span id="elh_a_customers_Mobile_Number" class="a_customers_Mobile_Number"><?php echo $a_customers->Mobile_Number->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_customers->Balance->Visible) { // Balance ?>
		<th><span id="elh_a_customers_Balance" class="a_customers_Balance"><?php echo $a_customers->Balance->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$a_customers_delete->RecCnt = 0;
$i = 0;
while (!$a_customers_delete->Recordset->EOF) {
	$a_customers_delete->RecCnt++;
	$a_customers_delete->RowCnt++;

	// Set row properties
	$a_customers->ResetAttrs();
	$a_customers->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$a_customers_delete->LoadRowValues($a_customers_delete->Recordset);

	// Render row
	$a_customers_delete->RenderRow();
?>
	<tr<?php echo $a_customers->RowAttributes() ?>>
<?php if ($a_customers->Customer_Number->Visible) { // Customer_Number ?>
		<td<?php echo $a_customers->Customer_Number->CellAttributes() ?>>
<span id="el<?php echo $a_customers_delete->RowCnt ?>_a_customers_Customer_Number" class="a_customers_Customer_Number">
<span<?php echo $a_customers->Customer_Number->ViewAttributes() ?>>
<?php echo $a_customers->Customer_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_customers->Customer_Name->Visible) { // Customer_Name ?>
		<td<?php echo $a_customers->Customer_Name->CellAttributes() ?>>
<span id="el<?php echo $a_customers_delete->RowCnt ?>_a_customers_Customer_Name" class="a_customers_Customer_Name">
<span<?php echo $a_customers->Customer_Name->ViewAttributes() ?>>
<?php echo $a_customers->Customer_Name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_customers->Contact_Person->Visible) { // Contact_Person ?>
		<td<?php echo $a_customers->Contact_Person->CellAttributes() ?>>
<span id="el<?php echo $a_customers_delete->RowCnt ?>_a_customers_Contact_Person" class="a_customers_Contact_Person">
<span<?php echo $a_customers->Contact_Person->ViewAttributes() ?>>
<?php echo $a_customers->Contact_Person->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_customers->Phone_Number->Visible) { // Phone_Number ?>
		<td<?php echo $a_customers->Phone_Number->CellAttributes() ?>>
<span id="el<?php echo $a_customers_delete->RowCnt ?>_a_customers_Phone_Number" class="a_customers_Phone_Number">
<span<?php echo $a_customers->Phone_Number->ViewAttributes() ?>>
<?php echo $a_customers->Phone_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_customers->Mobile_Number->Visible) { // Mobile_Number ?>
		<td<?php echo $a_customers->Mobile_Number->CellAttributes() ?>>
<span id="el<?php echo $a_customers_delete->RowCnt ?>_a_customers_Mobile_Number" class="a_customers_Mobile_Number">
<span<?php echo $a_customers->Mobile_Number->ViewAttributes() ?>>
<?php echo $a_customers->Mobile_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_customers->Balance->Visible) { // Balance ?>
		<td<?php echo $a_customers->Balance->CellAttributes() ?>>
<span id="el<?php echo $a_customers_delete->RowCnt ?>_a_customers_Balance" class="a_customers_Balance">
<span<?php echo $a_customers->Balance->ViewAttributes() ?>>
<?php echo $a_customers->Balance->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$a_customers_delete->Recordset->MoveNext();
}
$a_customers_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $a_customers_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fa_customersdelete.Init();
</script>
<?php
$a_customers_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if ($a_customers->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyDelete(this)'); function alertifyDelete(obj) { <?php global $Language; ?> if (fa_customersdelete.Validate() == true ) { alertify.confirm("<?php echo  $Language->Phrase('AlertifyDeleteConfirm'); ?>", function (e) { if (e) {	$(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyDelete'); ?>"); $("#fa_customersdelete").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_customers_delete->Page_Terminate();
?>
