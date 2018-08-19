<jsp:useBean id="tmanager" scope="page" class="com.mis.beans.TableManager"/>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;" />
<link rel="stylesheet" type="text/css" href="/mis/css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/mis/css/apex_max_css.css" media="screen" />
<title>Apex MIS</title>
</head>
<body>
<div id="centerColumn">
<%@ include file="/includes/header.jsp"%>
<%
tmanager.connectDataBase();
String sql="select * from calendar";
tmanager.executeSelect(sql);
tmanager.nextItem();
%>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="3"><div class="pagetitle">Academic Calendar</div></td>
	</tr>
</table>
<table border="0" align="center">
	<tr><td><a href="addcalendar.jsp">Edit Calendar</a></td></tr>
	<tr>
		<td><%out.println(tmanager.getStringValue("calendar"));%></td>
	</tr>
</table>
</div>
<div>

<%@ include file="/includes/footer.jsp"%>
<%tmanager.closeDataBase();%>