
// bust potential caching of external pages after initial request? (1=yes, 0=no)
var bustcachevar = 1;
var loadedobjects = "";
var rootdomain = "http://" + window.location.hostname;
var bustcacheparameter = "";

function ajaxpage(url, containerid)
{
	var page_request = false;
	
	if (window.XMLHttpRequest) // if Mozilla, Safari etc
	{
		page_request = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) // if IE
	{
		try
		{
			page_request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				page_request = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch (e) {}
		}
	}
	else
	{
		return false;
	}
	
	page_request.onreadystatechange = function()
	{
		loadpage(page_request, containerid);
	};
	
	if (bustcachevar) // if bust caching of external page
	{
		bustcacheparameter = (url.indexOf("?") != -1) ? "&"
				+ new Date().getTime() : "?" + new Date().getTime();
	}
	
	page_request.open('GET', url + bustcacheparameter, true);
	page_request.send(null);
}

function loadpage(page_request, containerid)
{
	if (page_request.readyState == 4 && (page_request.status == 200 || window.location.href.indexOf("http") == -1))
	{
		document.getElementById(containerid).innerHTML = page_request.responseText;
	}
}
