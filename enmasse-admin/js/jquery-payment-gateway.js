// JavaScript Document
function addAttributeRow(nTableId)
{
	var txtCountAttribute = document.getElementById('count');
	var nIdOfNewAttribute = parseInt(txtCountAttribute.value);
	nIdOfNewAttribute = nIdOfNewAttribute + 1;
	txtCountAttribute.value = nIdOfNewAttribute;
	var attributeTable = document.getElementById(nTableId);
	var tblTr = document.createElement("tr");
	var tblTd1 = document.createElement("td");
	var txtAttributeName=document.createElement("input");
	txtAttributeName.type="text";
	txtAttributeName.name="attribute_name[" + nIdOfNewAttribute + "]";
	txtAttributeName.id="attribute_name[" + nIdOfNewAttribute + "]";
	txtAttributeName.size="50";
	txtAttributeName.maxlength="250";
	tblTd1.appendChild(txtAttributeName);
	var tblTd2 = document.createElement("td");
	var txtAttributeValue=document.createElement("input");
	txtAttributeValue.type="text";
	txtAttributeValue.name="attribute_value[" + nIdOfNewAttribute + "]";
	txtAttributeValue.id="attribute_value[" + nIdOfNewAttribute + "]";
	txtAttributeValue.size="50";
	txtAttributeValue.maxlength="250";
	tblTd2.appendChild(txtAttributeValue);
	tblTr.appendChild(tblTd1);
	tblTr.appendChild(tblTd2);
	attributeTable.appendChild(tblTr);
	
}
