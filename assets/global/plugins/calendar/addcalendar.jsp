<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/mis/css/style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/mis/css/apex_max_css.css" media="screen" />
	<title>Apex MIS</title>
</head>
<body>
<div id="centerColumn">
<%@ include file="/includes/header.jsp"%>

<jsp:useBean id="tmanager" scope="page" class="MISbean.coreBeans.TableManager"/>

<%
	tmanager.connectDataBase();
%>

<script language="JavaScript" type="text/javascript" src="javascript/wysiwyg.js"></script>
<script>
	function check(aForm) {
		if(document.aForm.calendar.value=="") {
			alert('You must enter calendar.');
			document.aForm.subject.focus();
			return false;
		}  
		return document.aForm.routing.value;
	}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="3"><div class="pagetitle">Add / Edit Calendar</div></td>
	</tr>
</table>

<div align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="1" class="main_title_big">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="center" colspan="5" height="22">&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td width="50%" class="errorbig"><font face="Arial, Helvetica, sans-serif" size="-1"><img src="../new/apex_max_images/MaxBit.gif" width="1" height="1"></font></td>
	</tr>
</table>
<%
		String sql = "";
		sql = "select * from calendar where calendar_id = 1";
		tmanager.executeSelect(sql);
		tmanager.nextItem();
		%>
<table width="70%" border="0" cellspacing="2" cellpadding="4">
	<tr>
		<td align="center">
			<form action="changecalendar.jsp?calendar_id=<%=tmanager.getStringValue("calendar_id")%>" method="post" onSubmit="return check(this)">
				<textarea id="content" name="calendar" ><%=tmanager.getStringValue("calendar")%></textarea>
				<script language="javascript1.2">
					generate_wysiwyg('content');
				</script>
				<input type="hidden" name="op" value="add" />
				<br><br>
				<input type="submit" name="button" value="Submit" />
				<input type="submit" name="button" value="Cancel" />
			</form>
		</td>
	</tr>	
</table>
</div>

<%tmanager.closeDataBase(); %>
<%@ include file="../../includes/footer.jsp"%>