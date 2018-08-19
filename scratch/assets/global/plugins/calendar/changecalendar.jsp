<jsp:useBean id="calendar" scope="page" class="MISbean.Calendar"/>
<%
String text="", calid="";
calid = request.getParameter("calendar_id");
text = request.getParameter("calendar");
//int section_id=Integer.parseInt(secid);
//out.println(text);
calendar.connectDataBase();

if("Cancel".equals(request.getParameter("button"))) {
	calendar.closeDataBase();
	//out.print("Cancelled");
	response.sendRedirect("calendar.jsp");
} else if("add".equals(request.getParameter("op"))) {
	String result = calendar.storeCalendar(text.replace('\'', '"'));
	calendar.closeDataBase();
	//out.println(result);
	response.sendRedirect("calendar.jsp");
}
%>
