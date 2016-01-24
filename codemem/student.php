<HTML>
<HEAD>
    <TITLE> Add/Remove dynamic rows in HTML table </TITLE>
    <SCRIPT language="javascript">
        function addRow(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var cell1 = row.insertCell(0);
            var element1 = document.createElement("input");
            element1.type = "checkbox";
            element1.name="chkbox[]";
            cell1.appendChild(element1);
 
 
            var cell2 = row.insertCell(1);
            var element2 = document.createElement("input");
            element2.type = "text";
            element2.name = "txtbox[]";
            cell2.appendChild(element2);
 
            var cell3 = row.insertCell(2);
            var element3 = document.createElement("input");
            element3.type = "text";
            element3.name = "txtbox[]";
            cell3.appendChild(element3);
 
 
            var cell4 = row.insertCell(3);
            var element4 = document.createElement("input");
            element4.type = "text";
            element4.name = "txtbox[]";
            cell4.appendChild(element4);
            var cell5 = row.insertCell(4);
            var element5 = document.createElement("input");
            element5.type = "text";
            element5.name = "txtbox[]";
            cell5.appendChild(element5);
 
        }
 
        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
 
 
            }
            }catch(e) {
                alert(e);
            }
        }
 
    </SCRIPT>
</HEAD>
<BODY>
 
    <INPUT type="button" value="Add Row" onclick="addRow('dataTable')" />
 
    <INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable')" />
 
    <TABLE id="dataTable" width="350px" border="1">
        <TR><TH>CHECK</TH><TH>LINE NO</TH><TH>TYPE</TH><TH>VARIABLE NAME</TH><TH>VALUE</TH></TR>
        <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD> <INPUT type="text" /> </TD>
            <TD> <INPUT type="text" /> </TD>
            <TD> <INPUT type="text" /> </TD>
            <TD> <INPUT type="text" /> </TD>
        </TR>
    </TABLE>
 
</BODY>
</HTML>