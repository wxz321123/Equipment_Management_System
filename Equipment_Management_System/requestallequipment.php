aw<?php 
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
//$dbok = mysql_connect('localhost', 'madhus', 'ijfsdIfd93ru');
//$db_selected = mysql_select_db('equipment', $dbok);
//$_SESSION["SystemNameStr"]='EQUIPMENT';
if(isset($_GET["barcode"]) ){

	$barcode =$_GET["barcode"];
	$userQuery = "Select * from users where barcode_id = '$barcode'";
	$userResult = mysql_query ($userQuery);
	$userNum = mysql_num_rows($userResult);
	//echo $userQuery;
	if($userNum >= 1)
	{
		$userRow = mysql_fetch_array($userResult, MYSQL_ASSOC);

		$result = $userRow['First_Name'].'||'.$userRow['Last_Name'].'||'.$userRow['Email'].'||'.$userRow['Phone_Number'].'||'.get_user_type_desc($userRow['Type_ID']).'||'.get_programs_name($userRow['Programs_Department_ID']).'||'.get_institution_name($userRow['Institutions_ID']);
		header('Content-type: application/json');
		echo json_encode($result);

	}
	else
	echo "User Not Found. Go ahead and fill the data to create a new user. This will also create a new request.";
}
?>
<head>
<link href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<title>Priddy Loan System</title>
<style type="text/css">
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}
.requesttable .label {
width:46%;
}
</style>
<script>

$(document).ready(function (){

	if($("#itemtype").val() != "iPad"){
		$("#row_email").hide();
		$("#email").removeAttr("required");
		$("#row_email").removeClass("required");
		$("#row_phone").hide();
		$("#row_user_type").hide();
		$("#row_terms_ipad").hide();
		$("#row_program").hide();
		$("#row_date").hide();
		$("#row_no_needed").hide();
		}
	else{
		$("#row_email").show();
		$("#row_email").addClass("required");
		$("#email").attr("required");
		$("#row_phone").show();
		$("#row_user_type").show();
		$("#row_terms_ipad").show();
		$("#row_program").hide();
		$("#row_date").show();
		$("#row_no_needed").show();
		}

	if ($("#itemtype").val() != "iPad" && $("#itemtype").val() != "Laptop")
	{
		$("#row_terms").hide();
		$("#agreecheck").removeAttr("required");
	}
	else
	{
		if ($("#itemtype").val() == "Laptop")
		{
			$("#row_email").show();
			$("#row_email").addClass("required");
			$("#email").attr("required");
			$("#row_terms").show();
			$("#agreecheck").attr("required");
			$("#agreelink").attr("href","termsandconditionlaptop.php")
		}
		else
		{
		$("#row_terms").show();
		$("#agreecheck").attr("required");
		$("#agreelink").attr("href","termsandcondition.php")
		}
	}
	$("#itemtype").change(function(){


		if($("#itemtype").val() != "iPad"){
			$("#row_email").hide();
			$("#email").removeAttr("required");
			$("#row_email").removeClass("required");
			$("#row_phone").hide();
			$("#row_user_type").hide();
			$("#row_terms_ipad").hide();
			$("#row_program").hide();
			$("#row_date").hide();
			$("#row_no_needed").hide();
			}
		else{
			$("#row_email").show();
			$("#row_email").addClass("required");
			$("#email").attr("required");
			$("#row_phone").show();
			$("#row_user_type").show();
			$("#row_terms_ipad").show();
			$("#row_program").hide();
			$("#row_date").show();
			$("#row_no_needed").show();
			}

		if ($("#itemtype").val() != "iPad" && $("#itemtype").val() != "Laptop")
		{
			$("#row_terms").hide();
			$("#agreecheck").removeAttr("required");
		}
		else
		{
			if ($("#itemtype").val() == "Laptop")
			{
				$("#row_email").show();
				$("#row_email").addClass("required");
				$("#email").attr("required");
				$("#row_terms").show();
				$("#agreecheck").attr("required");
				$("#agreelink").attr("href","termsandconditionlaptop.php")
			}
			else
			{
			$("#row_terms").show();
			$("#agreecheck").attr("required");
			$("#agreelink").attr("href","termsandcondition.php")
			}
		}

		
		});
});

function getUserInfo(){
	var barcode = document.getElementById('barcode').value;
	if( barcode == null || barcode == "")
	alert("Please enter the barcode number found behind you ID");
	else
	{
		$.ajax({
			  url: 'request.php?barcode='+barcode,
			  async: false,
			  dataType: 'json',
			  success : function (data) {
				//alert('data');
				//console.log(data);
			      },
	      	  error : function(json){
	      		//console.log(json);
		      	  var x = json.responseText.split("<");
		      	  if(x[0].indexOf('||')>-1)
		      	  {
		      	  var y = x[0].split("||");
		      	  //console.log(y);
		      	  var fname = y[0].split("\"");
		      	  var lname = y[3].split("\"");
		      	  var user = y[4].split("\"");
		      	  var program = y[5].split("\"");
		      	  var inst = y[6].split("\"");
		      	  $("#fname").val(fname[1]);
		      	  $("#lname").val(y[1]);
		      	  $("#email").val(y[2]);
		      	  $("#pno").val(lname[0]);
		      	  $("#utype").val(user[0]);
		      	  $("#institution").val(inst[0]);
		      	  $("#programname").val(program[0]);
		      	  }
		      	  else
		      	  {
			      	  $("#NoUserFound").html(x[0]);
		      	  }
	      	  }
			    
			});
		return false;
	}
}
function validateForm()
{
var a=document.forms["registration"]["fname"].value;
var b=document.forms["registration"]["lname"].value;
var c=document.forms["registration"]["barcode"].value;
var d=document.forms["registration"]["email"].value;
var e=document.forms["registration"]["pno"].value;
var f=document.forms["registration"]["ipads"].value;


if (a==null || a=="" || b==null || b=="" || c==null || c=="" || d==null || d=="")
  {
  alert("None of the text boxes can be empty");
  return false;
  }
/*A function call to ValidateSelect and checking if the function returns in false.*/
  if(validateSelect()==false)
  {return false;}
/*A function Call to FileCheck and checking if user wants to continue without selecting a upload*/  
  if(filecheck()==false)
  {return false;}
}

</script>
</head>
<div id="banner" style="width:90%;margin:0px;text-align:center";>EQUIPMENT MANAGEMENT SYSTEM</div>
	<div id="topnavi">
    		<?PHP if (@$_SESSION["AUTH_USER"]==true) 
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/logout.php">LOGOFF</a>';
					else
						{
						$LoginSelectStr='';
						if ($CurrentRequestURLarr[2]=="login") $LoginSelectStr=' class="selected"';
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login.php"'.$LoginSelectStr.'>Staff LOGIN</a>'; 
						}?>
			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>"<?php if ($CurrentRequestURLarr[2]=="") print ' class="selected"'?>></a>
            
	</div>	
</div>	
<h1 style = "margin-left:38%">Equipment Request Form</h1>
<label id="NoUserFound" style = "width :100%"></label><br>
<input type='button' name='getuserinfo' id = 'getuserinfo' onClick = "getUserInfo()" value = "Autofill" style = "margin-left:30%"/>
<label style = "margin-left:30%;width:100%;font-weight:normal">Enter barcode and click "Autofill" if you've requested an equipment before</label>

<form name="registration" action="sendRequest.php" method="post" onsubmit="return validateForm(this)" style = "margin-left:30%">
	<table border="1" class = "requesttable">
		<tr id = "row_item_type">
			<td><label for='itemtype' ><b>Item Type:</b></label></td>
			<td>	
				<select name="itemtype" id="itemtype">
				<?php 
	// Build the query
				$query = "SELECT description FROM item_type ORDER BY description ASC";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				echo '<option value="'.$row['description'].'" >'.$row['description'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr class = "required" id = "row_barcode">
			<td class = "label"><label for='barcode' style = "width:100%"><b>Patron Barcode:</b></label></td>
			<td><input type='number' name='barcode' id='barcode' max="99999999999999" style="width:98%"/ required placeholder="Barcode Number"></td>
			
		</tr>
		<tr id = "row_find_barcode">
				<td colspan="2" style ="font-size :0.8em">
				<b>Click <a target="_blank" style = "color: blue;text-decoration : underline" href = "http://shadygrove.umd.edu/library/services/find-lib-barcode">here</a> to find your library barcode number</b>
			</td>
		</tr>
		<tr class = "required" id = "row_first_name">
			<td><label for='fname' ><b>First Name:</b></label></td>
			<td><input type='text' name='fname' id='fname' maxlength="50" style="width:98%" required placeholder="First Name"/></td>
		</tr>
		<tr class = "required" id = "row_last_name">
			<td><label for='Last Name' ><b>Last Name:</b></label></td>
			<td><input type='text' name='lname' id='lname' maxlength="50" style="width:98%"/ required placeholder="Last Name"></td>
		</tr>
		<tr class = "required" id = "row_email">
			<td><label for='Email' ><b>Email:</b></label></td>
			<td><input type='text' name='email' id='email' maxlength="50" style="width:98%"/ required placeholder="Enter a valid email address"></td>
		</tr>
		<tr id = "row_phone">
			<td><label for='phone' ><b>Phone Number:</b></label></td>
			<td><input type='number' name='pno' id='pno' maxlength="10" style="width:98%"/ placeholder="Enter 10 digit phone number"></td>
		</tr>
		<tr id = "row_user_type">
			<td>
				<label for='User Type:' ><b> User Type:</b></label></td>
			<td>
				<select name="utype" id = "utype">
				<?php 
				// Build the query
				$query = "SELECT description FROM user_types ORDER BY description ASC";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				echo'<option value="'.$row['description'].'">'.$row['description'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr id = "row_institution">
			<td><label for='Institution' ><b>Institution:</b></label></td>
			<td>	
				<select name="institution" id = "institution">
				<?php 
	// Build the query
				$query = "SELECT name FROM institutions ORDER BY name ASC";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				echo '<option value="'.$row['name'].'" >'.$row['name'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr id = "row_program">
			<td><label for='programname' ><b>Program:</b></label></td>
			<td>	
				<select name="programname" id = "programname">
				<?php 
	// Build the query
				$query = "SELECT department_name FROM programs_department ORDER BY department_name ASC";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				echo '<option value="'.$row['department_name'].'" >'.$row['department_name'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr class = "required" id = "row_date">
			<td><label for='Date needed' ><b>Date needed:</b></label></td>
			<td><input type='date' name='request_date' id='request_date' value = "<?php echo date('Y-m-d'); ?>" required maxlength="50" style="width:98%"/></td>
		</tr>
		<tr class = "required" id = "row_no_needed">
			<td><label for='No of Items:' ><b> No. Needed :</b></label><br><b><span style = "font-size:11">(Subject to availability)</span></b></td>
			<td><input type='number' name='items' id='items' max="25" style="width:98%"/ value = "1" required placeholder="Quantity"></td>
		</tr>
		<tr id = "row_terms_ipad">
		
			<td colspan="2" style ="font-size :0.7em">
				- Students can request only one iPad at a time<br>
				- Faculty requests of multiple iPads should be made atleast one week in advance
			</td>
		</tr>
		<tr id = "row_terms">
		
			<td colspan="2" style ="font-size :0.8em">
				<input type='checkbox' id ="agreecheck" required/><b>I agree to the equipment loan <a style = "color: blue;text-decoration : underline" href = "termsandcondition.php" id = "agreelink">terms and conditions</b></a>
			</td>
		</tr>
		<tr id = "row_submit">
			<td colspan="2" align="center">
				<input type='submit' value='Submit Request'/>
			</td>
			
		</tr>
	</table>
	
	</form>