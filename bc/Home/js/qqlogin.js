var qqWindow;
function qqlogin()
{
	window.location='index.php?m=qqlogin&a=geturl';
    /*qqWindow = window.open("index.php?m=qqlogin&a=geturl","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
	*/
} 
            
function closeqqWindow()
{
  	qqWindow.close();
}