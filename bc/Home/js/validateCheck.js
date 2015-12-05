// JavaScript Document
function emptyCheck(input)
{
	var $this = $(input);
	var name = $this.val();
	if(name=="")
	{
		$this.next().css("display","inline-block");
		$this.focus();
		return false;
	}
	else
	{
		$this.next().css("display","none");
		return true;
	}
}
function c_orderSubmit()
{
	
	if(!emptyCheck("#guest-name"))
	{
		return false;
	}
	if(!emptyCheck("#guest-phone"))
	{
		return false;
	}
	if(!emptyCheck("#guest-address"))
	{
		return false;
	}
	
	return true;
	
}