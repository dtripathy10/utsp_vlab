function fetchobj(objid){
	return document.getElementById(objid);
}
function expCol(objid,len){
	for(var i=1;i<=len;i++){
		obj=fetchobj(objid+i);
		if(obj.style.display=='none') {
			obj.style.display='';
		}
		else{
			obj.style.display='none';
		}
	}
}



/*
var stile = "top=200, left=400, width=800, height=500 status=no, menubar=no, toolbar=no, scrollbar=yes";
function Popup(apri)
{
                window.open(apri, "", stile);
} 
*/
var stile = "top=200,left=400,width=800,height=500,status=0,scrollbars=1";
function Popup(apri)
{
                window.open(apri, "", stile);
} 