<%
	'In this page, we open the connection to the Database FusionMapsDB
	Dim oConn
	'If not already defined, create object
	if not isObject(oConn) then
		Dim strConnQuery
		Set oConn = Server.CreateObject("ADODB.Connection")		
		oConn.Mode = 1
		
		'Create the path to database (SQL Server)
		'strConnQuery = "driver={SQL Server};uid=((Your user ID));pwd=((Your Password));database=FusionMapsDB;server=((Your Server))" 
		
		'Or, path to Access database
		strConnQuery = "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=" & Server.Mappath(".") & "\DB\FusionMapsDB.mdb"
		
		'Finally Connect
		oconn.Open strConnQuery		
	end if
%>