//This variable will hold the value that is returned by the subsequent function
var xmlHttp = createXmlHttpRequestObject();

//This method creates an object that can be used for communicating with the server
function createXmlHttpRequestObject()
{
    //Initialise variable
	var xmlHttp;
	
	//If on IE, create object thusly...
	if(window.ActiveXObject)
	{
	    try
		{
		    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(e)
		{
		    xmlHttp = false;
		}
	//...otherwise create it thusly
	} else
	{
	    try
		{
		    xmlHttp = new XMLHttpRequest();
		} catch(e)
		{
		    xmlHttp = false;
		}
	}
	
	//If something has gone wrong in creating the object print this alert to the screen...
	if(!xmlHttp)
	{
	    alert("Can't create that object!");
	//...otherwise return the new object which is assigned to the variable previously mentioned
	} else
	{
	    return xmlHttp;
	}
}



//This function uses the object that we just created to fetch information from the webpage and
//send it to the server. It also handles the server program's response
function process()
{	
	//If the request has not yet been initialised or has been completed...
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
	{
	    //...get the value that the user has entered into the search box on the webpage and store it
		//in a variable
		tag = encodeURIComponent(document.getElementById("search").value);
	    //We then send the contents of that variable to the php page as a GET request
		xmlHttp.open("GET", "scripts/search.php?tag=" + tag, true);
		//Whenever the state of the request/response dynamic of the client and server relationship
		//changes, we want to run the handleServerResponse funtion, which is defined subsequently
		xmlHttp.onreadystatechange = handleServerResponse;
		xmlHttp.send(null);
	//If the server takes too long to handle the request, we timeout
	} else
	{
	    setTimeout('process()', 5000);
	}
}

//This function receives the XML file sent by the server script, and parses it to
//extract the <content> element. It then displays those contents in the webpage sidebar
function handleServerResponse()
{
    //If the request to the server has been completed...
	if(xmlHttp.readyState == 4)
	{
	    //...and the request did not return an error...
	    if(xmlHttp.status == 200)
		{ 
		    //...store the response from the server in a variable. In our case the response will be
			//the XML file echoed by the server-side program
			xmlResponse = xmlHttp.responseXML;
			//Parse the XML file to extract the root element (<feed>)
			xmlDocumentElement = xmlResponse.documentElement;
			//Initialise this variable as an empty String. We will use it later
			text="";
			//Parse the root element to get the internal <entry> elements, and put them in a variable
			entries = xmlDocumentElement.getElementsByTagName("entry");
			//Iterate through the entry elements
			for (i=0; i<entries.length; i++)
			{
			    //Start building the list that will be output to the sidebar of the webpage
				text = text + "<li>";
				//For each entry element, parse the content element
				content = entries[i].getElementsByTagName("content");
				try
				{
					//Continue to build the list by adding each content element in turn
					text = text + content[0].firstChild.nodeValue + "</li>";
				} catch (er)
				{
				    text = text + "dammit</li>";
				}
			}
			//Output the list to the HTML page
			document.getElementById("result").innerHTML = '<span style="color:blue">' + text + '</span>';
			//The method will be repeated every 200 seconds
			setTimeout('process()', 200000);
		}
	} else
	{
	    //This displays a gif while the program is waiting for the server to respond
		$("#result").html("<img src='style/ajax-loader.gif'/>");
	}
}