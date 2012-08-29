function printdiv(printpage) 
			{ 
				var headstr = "<html><head><title></title></head><body>";

				var footstr = "</body>"; 
				var newstr = document.all.item(printpage).innerHTML; 
				var oldstr = document.body.innerHTML; 
				document.body.innerHTML = headstr+newstr+footstr; 
				window.print(); 
				document.body.innerHTML = oldstr; 
				return false; 
			} 
jQuery(function(){
	jQuery('.demo').draggable().resizable(); 
});
function getdiv()
				{						
					document.getElementById("cp-x1").value=parseInt(document.getElementById("cpx1").style.left);
					document.getElementById("cp-x2").value=parseInt(document.getElementById("cpx2").style.left);
					document.getElementById("cp-x3").value=parseInt(document.getElementById("cpx3").style.left);
					document.getElementById("cp-x4").value=parseInt(document.getElementById("cpx4").style.left);
					document.getElementById("cp-x5").value=parseInt(document.getElementById("cpx5").style.left);
					
					document.getElementById("cp-y1").value=parseInt(document.getElementById("cpx1").style.top);
					document.getElementById("cp-y2").value=parseInt(document.getElementById("cpx2").style.top);
					document.getElementById("cp-y3").value=parseInt(document.getElementById("cpx3").style.top);
					document.getElementById("cp-y4").value=parseInt(document.getElementById("cpx4").style.top);
					document.getElementById("cp-y5").value=parseInt(document.getElementById("cpx5").style.top);
					
					document.getElementById("cp-width1").value=parseInt(document.getElementById("cpx1").style.width);
					document.getElementById("cp-width2").value=parseInt(document.getElementById("cpx2").style.width);
					document.getElementById("cp-width3").value=parseInt(document.getElementById("cpx3").style.width);
					document.getElementById("cp-width4").value=parseInt(document.getElementById("cpx4").style.width);
					document.getElementById("cp-width5").value=parseInt(document.getElementById("cpx5").style.width);
					
					
					document.getElementById("cp-height1").value=parseInt(document.getElementById("cpx1").style.height);
					document.getElementById("cp-height2").value=parseInt(document.getElementById("cpx2").style.height);
					document.getElementById("cp-height3").value=parseInt(document.getElementById("cpx3").style.height);
					document.getElementById("cp-height4").value=parseInt(document.getElementById("cpx4").style.height);
					document.getElementById("cp-height5").value=parseInt(document.getElementById("cpx5").style.height);
					
					document.getElementById("cp-font_size1").value=parseInt(document.getElementById("cpx1").style.font-size);	
					document.getElementById("cp-font_size2").value=parseInt(document.getElementById("cpx2").style.font-size);	
					document.getElementById("cp-font_size3").value=parseInt(document.getElementById("cpx3").style.font-size);
					document.getElementById("cp-font_size4").value=parseInt(document.getElementById("cpx4").style.font-size);
					document.getElementById("cp-font_size5").value=parseInt(document.getElementById("cpx5").style.font-size);
					
				}
function ClickHereToPrint(){
			try{ 
				var oIframe = document.getElementById('ifrmPrint');
				var oContent = document.getElementById('divToPrint').innerHTML;
				var oDoc = (oIframe.contentWindow || oIframe.contentDocument);
				if (oDoc.document) oDoc = oDoc.document;
				oDoc.write("<html><head><title>title</title>");
				oDoc.write("</head><body onload='this.focus(); this.print();'>");
				oDoc.write(oContent + "</body></html>");	    
				oDoc.close(); 	    
			}
			catch(e){
				self.print();
			}
		}