<%
Dim conn
set conn = server.createobject("ADODB.CONNECTION")
on error resume next
conn.open = "Provider=msdaora;Data Source=cpprd;User Id=auditoria;Password=$way07;"
if err.number <> 0 then
   response.write err.number 
end if
%>