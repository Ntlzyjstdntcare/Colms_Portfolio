/**
*@author 
*<ul>
*<li>Colm Ginty 
*</ul>
*@version Java 7
*/

import javax.swing.text.html.*;
import javax.swing.text.Element;
import javax.swing.text.ElementIterator;
import javax.swing.text.SimpleAttributeSet;
import javax.swing.text.BadLocationException;
import java.net.*;
import java.io.*;
import java.util.regex.*;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.Iterator;
import java.util.LinkedHashMap;
import java.util.LinkedList;
import java.util.List;
import java.util.Map;
import java.util.ArrayList;
import java.util.TreeMap;

class LinkChecker 
{
    /**
	* Extracts host from URL
	* <p>
	* Takes in a URL and finds its host, which it returns
	* </p>
	* @param String url
	* @return String
	*/
	public static String getDomainName(String url) throws URISyntaxException 
    {
        URI uri = new URI(url);
        String domain = uri.getHost();
        return domain.startsWith("www.") ? domain.substring(4) : domain;
    }
	
	/**
	* Sorts Map in descending order
	* <p>
	* Takes in a Map and converts its contents to a LinkedList
	* It then sorts the list in descending order, and inserts 
    * the contents of the list back into a Map	
	* </p>
	* @param Map unsortMap
	* @return Map
	*/
	private static Map sortByComparator(Map unsortMap) 
	{
 
		List list = new LinkedList(unsortMap.entrySet());
 
		// sort list based on comparator
		Collections.sort(list, new Comparator() 
		{
			public int compare(Object o1, Object o2) 
			{
				return ((Comparable) ((Map.Entry) (o2)).getValue()).compareTo(((Map.Entry) (o1)).getValue());
			}
		});
 
		// put sorted list into map again
                //LinkedHashMap make sure order in which keys were inserted
		Map sortedMap = new LinkedHashMap();
		for (Iterator it = list.iterator(); it.hasNext();) 
		{
			Map.Entry entry = (Map.Entry) it.next();
			sortedMap.put(entry.getKey(), entry.getValue());
		}
		return sortedMap;
	}
 
	/**
	* Prints contents of Map
	* <p>
	* Takes in a Map of key-value pairs
	* For every entry in the Map, prints out the key
    * and the value
	* </p>
	* @param Map map
	* @return void
	*/
	public static void printMap(Map<String, Integer> map)
	{
		for (Map.Entry entry : map.entrySet()) 
		{
			System.out.println("Key : " + entry.getKey() 
                                   + " Value : " + entry.getValue());
		}
	}
	
	/**
	* Main method.
	* Takes in URL and scans the page, extracting all href attributes
	* Analyses hrefs and filters out any that are not URLs
    * Visits each URL and records response code
    * If response code is not 200, link is assumed to be broken and output to webpage
    * Also counts the number of instances of each distinct host among the broken links
    * and prints that information to a table	
	* @param args
	* @return void
	*/
	public static void main (String args[]) throws Exception
    {
        //long start = System.nanoTime();
		/**
	    * Initialises Strings which will read from and printed to using the PrintWriters
		* and BufferedReaders which we will initialise subsequently
	    */
		String fileOut = System.getProperty("user.dir") + File.separator + "page_contents.txt";
        String fileOut2 = System.getProperty("user.dir") + File.separator + "page_contents.txt";
        String fileURLOut = System.getProperty("user.dir") + File.separator + "urls.txt";
        String brokenLinks = System.getProperty("user.dir") + File.separator + "brokenTest.html";
		String hosts = System.getProperty("user.dir") + File.separator + "hosts.txt";
		String hostsTable = System.getProperty("user.dir") + File.separator + "hosts_tableTest.html";		
        
		/**
	    * Initialises PrintWriters and BufferedReaders which will perform 
		* our file handling
	    */
		PrintWriter outputStream = new PrintWriter(new FileWriter(fileOut));
        BufferedReader URLIn = new BufferedReader(new FileReader(fileOut2));
        PrintWriter URLOut = new PrintWriter(new FileWriter(fileURLOut));
        PrintWriter brokenOut = new PrintWriter(new FileWriter(brokenLinks));
		PrintWriter hostsOut = new PrintWriter(new FileWriter(hosts));
		PrintWriter hostsTableOut = new PrintWriter(new FileWriter(hostsTable));
		BufferedReader hostsIn = new BufferedReader(new FileReader(hosts));
		BufferedReader hostsIn2 = new BufferedReader(new FileReader(hosts));
		
		/**
	    * These two objects will be used much later to help count the number of different hosts
	    */
		String[] hostsArray;
		int count = 0;
		
        try 
        {
			/**
	        * Begin to create html page to which we will output all of our broken links
	        */
            brokenOut.println("<html>");
			brokenOut.println("<head>");
			brokenOut.println("<title>Broken Links</title>");
			brokenOut.println("</head>");
			brokenOut.println("<body>");
			brokenOut.println("<ul>");
			
			/**
	        * Begin to create html page to which we will output each distinct host among our broken links,
			* and the number of links at that host
	        */
			hostsTableOut.println("<html>");
			hostsTableOut.println("<head>");
			hostsTableOut.println("<title>Count and Investigation</title>");
			hostsTableOut.println("</head>");
			hostsTableOut.println("<body>");	
			hostsTableOut.println("<table style='width:900px' border='2' cellpadding='10'>");
			hostsTableOut.println("<tr bgcolor='#faf7b0'>");
			hostsTableOut.println("<td><h4>Host</h4></td>");
			hostsTableOut.println("<td style='width:180px'><h4>Number of Broken Links</h4></td>");
			hostsTableOut.println("<td><h4>Reason for Broken Links</h4></td>");
			hostsTableOut.println("</tr>");
			
			/**
	        * This is where we store the URL that the user enters at the command line.
	        */
			URL rootURL = new URL(args[0]);
    			
            /**
	        * HTMLEditorKit and HTMLReader are used for treating a document as a HTML page,
            * and scanning it			
	        */
			HTMLEditorKit kit = new HTMLEditorKit(); 
            HTMLDocument doc = (HTMLDocument) kit.createDefaultDocument(); 
            doc.putProperty("IgnoreCharsetDirective", Boolean.TRUE);
            Reader HTMLReader = new InputStreamReader(rootURL.openConnection().getInputStream()); 
            kit.read(HTMLReader, doc, 0); 
            						
            /**
	        * This is a regex which we will check our extracted href attributes against, to see
            * if they are valid urls			
	        */
			String urlPattern = "((https?|ftp|gopher|telnet):((//)|(\\\\))+[\\w\\d:#@%/;$()~_?\\+-=\\\\\\.&]*)";
			
            /**
	        * We extract all A tags from the HTML document			
	        */
            HTMLDocument.Iterator it = doc.getIterator(HTML.Tag.A);
            
			/**
	        * We extract all href attributes from the A tags, and print to a text file			
	        */
			while (it.isValid()) 
            {
				SimpleAttributeSet s = (SimpleAttributeSet)it.getAttributes();

                String link = (String)s.getAttribute(HTML.Attribute.HREF);
                if (link != null) 
                {
                    outputStream.println(link);
                }
               it.next();
            }
            outputStream.close();
									
            /**
	        * We then read in from that text file			
	        */
     		String x;
						
            while ((x = URLIn.readLine()) != null)
            {
				
				/**
	            * As explained in the report, this URL caused the program to crash, and no solution could be found
                * I have simply converted it to the URL that the 'faulty' URL directs to				
	            */
				if (x.equals("http://www.newstatesman.co.uk/"))
				{
				    x = "http://www.newstatesman.com";
					System.out.println("Changed string!!!\n\n\n\n\n\n\n");
				}
				
				/**
	            * I check the href that I have read from the text file agains the regex		
	            */
				Pattern p = Pattern.compile(urlPattern,Pattern.CASE_INSENSITIVE);
					
                Matcher m = p.matcher(x);
					
                if (m.find())				
                {
                    
					try
					{  
					    /**
	                    * If it matches, I print to a new text file which only contains well-formed URLs		
	                    */
						URLOut.println(x.substring(m.start(0),m.end(0)));  

						/**
	                    * I attempt to connect to the URL		
	                    */
						URL url = new URL(x.substring(m.start(0),m.end(0)));
						HttpURLConnection http = (HttpURLConnection)url.openConnection();
						http.setConnectTimeout(5000);
						http.setRequestMethod("HEAD");
						for (int i=0; ; i++) 
						{
							String name = http.getHeaderFieldKey(i);
							String value = http.getHeaderField(i);
						
							if (name == null && value == null)     // end of headers
							{
								break;         
							}

							if (name == null)     // first line of headers
							{
								/**
	                            * If the response code is not 200, I print the URL to the HTML file that I began constructing earlier		
	                            */
								if(!value.substring(9, 12).equals("200"))
								{
									brokenOut.println("<li><a href=\"" + url + "\">" + url + "</a>" + " " + value.substring(9, 12) + "</li>");
									
									/**
	                                * I get the host of the 'broken' URL, and write to another text file
                                    * and increment the count variable so that it will store the number of hosts									
	                                */
									String host = getDomainName(url.toString());
									count++;
									hostsOut.println(host);
								}
							}
							else
							{
								/**
	                            * This is to help see that the program is running properly		
	                            */
								System.out.println(name + "=" + value + "!!!!!!");
							}
						}
					} catch (java.net.SocketTimeoutException e)
					{
					    System.out.println("Timeout!!" + e.getMessage());
					}
                }
            }
			hostsOut.close();
			
			
				
            
            /**
	        * Here we finish building the webpage of broken links		
	        */
			brokenOut.println("</ul>");
			brokenOut.println("</body>");
			brokenOut.println("</html>");
			
			
			/**
            * I initialise the array to store the hosts Strings, and set each element to an empty String	
	        */
			hostsArray = new String[count];
			for (int i = 0; i < count; i++)
            {
                hostsArray[i] = "";
            }		
			
			/**
	        * I read in each of the hosts and check to see if they are already stored in the array
            * In this way I populate the array only with distinct host names			
	        */
			String y;
			
			while ((y = hostsIn.readLine()) != null)
			{
			    System.out.println("Reading from hosts list!!!\n\n\n");
				System.out.println("Count is: " + count);
				for (int i = 0; i < count; i++)
				{
				    if (hostsArray[i].equals(y))
					{
					    break;
					} else if (hostsArray[i].equals(""))
					{
					    hostsArray[i] = y;
						break;
					}
				}	
			}
			hostsIn.close();

			/**
	        * I then count the number of distinct host names		
	        */
			int count1 = 0;
			for (int i = 0; i < count; i++)
			{
			    if(!hostsArray[i].equals(""))
				{
				    count1++;
				}
			}
			
			/**
	        * I initialise an ArrayList which will hold the distinct host names		
	        */
			ArrayList<String> hostsArrayList = new ArrayList<String>(5);
			
			
			/**
	        * Here I add the names to the ArrayList		
	        */
			while ((y = hostsIn2.readLine()) != null)
			{
				hostsArrayList.add(y);	
			}	
				
			/**
	        * I initialise a Map which will hold the name of the host as Key and the number of instances of that 
            * host name as value			
	        */
			Map<String, Integer> unsortMap = new HashMap<String, Integer>();
			
			/**
	        * I iterate through the array of host names counting the number of instances of each name
            * I add each name and its count to the Map as a key-value pair			
	        */
			for (int i = 0; i < count1; i++)
            {			
				int count2 = 0;
				for (int j = 0; j < count; j++)
				{
					if (hostsArray[i].equals(hostsArrayList.get(j)))
					{
						count2++;
						
					}
				}
				unsortMap.put(hostsArray[i], count2);	
			}		
			
			/**
	        * I print the unsorted key-value pairs to check that the program is working correctly		
	        */
			System.out.println("Unsort Map......");
		    
			printMap(unsortMap);
			
			System.out.println("Sorted Map......");
			
		    /**
	        * Here the Map is sorted, and then printed to screen		
	        */
			Map<String, Integer> sortedMap = sortByComparator(unsortMap);
			printMap(sortedMap);
			
			/**
	        * We loop through the map, adding each key and value to the table that we began constructing earlier,
            * in which we display each distinct host and its number of instances			
	        */
			for (String name: sortedMap.keySet())
			{
			    String key =name.toString();
				String value = sortedMap.get(name).toString();  
				hostsTableOut.println("<tr>");
			    hostsTableOut.println("<td><em>" + key + "</em></td>");
			    hostsTableOut.println("<td>" + value + "</td>");
			    hostsTableOut.println("<td>Reason to be entered manually</td>");
		        hostsTableOut.println("</tr>");
            } 
			
			 
			/**
	        * We finish building the above-mentioned table	
	        */
			hostsTableOut.println("</table");
			hostsTableOut.println("</body>");
			hostsTableOut.println("</html>");
			
        
		/**
	    * Here we catch all thrown exceptions	
	    */
		} catch (MalformedURLException e) 
        {
            System.out.println("Malformed URL!!!!!");
        } catch (IllegalArgumentException e) 
        {
            System.out.println("IllegalArgumentException!!!!!" + e.getMessage());
			new Throwable().getStackTrace();
        } catch (IOException e) 
        {
            throw new RuntimeException("IO Exception!!!!!", e);
        
		/**
	    * Finally, we close any open file streams		
	    */
		} finally
        {
            if (outputStream != null)
            {
                outputStream.close();
            }
            if (URLIn != null)
            {
                URLIn.close();
            }
            if (URLOut != null)
            {
                URLOut.close();
            }
            if (brokenOut != null)
            {
                brokenOut.close();
            }
			if (hostsOut != null)
            {
                hostsOut.close();
            }
			if (hostsTableOut != null)
            {
                hostsTableOut.close();
            }
			if (hostsIn != null)
            {
                hostsIn.close();
            }
			if (hostsIn2 != null)
            {
                hostsIn2.close();
            }
        }
		//long end = System.nanoTime();
	    //System.out.println("Time for first page is: " + (end-start));
		/** Running Time
	    * http://computing.dcu.ie/~humphrys/computers.internet.links.html :     143723514192
	    * http://computing.dcu.ie/~humphrys/news.links.html :     152216242660
	    * http://humphrysfamilytree.com/links.html :     169959727476  
	    * http://humphrysfamilytree.com/sources.html :     448419285037
		*/
	}	
} 