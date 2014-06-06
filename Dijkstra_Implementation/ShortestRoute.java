/**
* @author 
* <ul>
* <li>Colm Ginty 
* </ul>
* @version Java 7
*/

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;
import java.util.Arrays;
import javax.swing.*;


class ShortestRoute
{	

	private ArrayList<String> nodes;
	
	/**
	* This Map will contain our distinct nodes as keys, and an int[] containing the node's tentative distance in the first element,
	* and whether it has been visited in the second
	*/
	private HashMap<String, int[]> unvisitedMap;
	
	/**
	* This will contain the two nodes(in this form - 'a/b') as keys, and the distance between them as values
	*/
	private HashMap<String, Integer> distancesMap;
	
	/**
	* This will contain our distinct nodes as keys, and its neighbouring nodes in an ArrayList
	*/
	 private HashMap<String, ArrayList<String>> neighboursMap;
	 
	/**
	* This will store the node that led to each node on the path
	*/
	private HashMap<String, String> fromNodeMap;
	
	private ArrayList<String> unvisitedSet;
	
	/**
	* We initialise this ArrayList which will be used to hold all node-pairs
	*/
	private ArrayList<String> rootKeys;
	
	private ArrayList<String> newDistinct;
	
	private ArrayList<String> distinctNodes;
	
	private ArrayList<String> rootNeighbours;
	
	private int nodesCount;
	
	private int distinctCount;
	
	/**
	* In the setStartNodeVisited method below we will wish to mark a node as 'visited'. This will entail setting its
	* distance value to 0 for housekeeping purposes.
	*/
	private int visitedDistance = 0;
	
	/**
	* In the setStartNodeVisited method below we will wish to mark a node as 'visited'. Arbitrarily, we set the second value
	* of the array to 1 to indicate that it has been visited.
	*/
	private int visited = 1;
	
	/**
	* In the workThroughGrid method we perform a check on whether a node is 'unvisited'. A node is unvisited if the second value in
	* the array is equal to zero. Here we create a class variable with that value.
	*/
	private int unvisited = 0;
	
	private int maxValue = Integer.MAX_VALUE;
	
	/**
	* This is the default int[] for unvisitedMap. 
	*/
	private int[] distanceAndVistited = {maxValue, unvisited};
	
	private boolean exists;
	
	/**
	* Constructor for ShortestRoute
	* Creates an ShortestRoute object with all the class variables initialised to their default values
	* @return ShortestRoute
	*/	
	public ShortestRoute()
	{
		nodes = new ArrayList<String>();
		unvisitedMap = new HashMap<String, int[]>();
		distancesMap = new HashMap<String, Integer>();
		neighboursMap = new HashMap<String, ArrayList<String>>();
		fromNodeMap = new HashMap<String, String>();
		unvisitedSet = new ArrayList<String>();
		rootKeys = new ArrayList<String>();
		newDistinct = new ArrayList<String>();
		distinctNodes = new ArrayList<String>();
		rootNeighbours = new ArrayList<String>();
		nodesCount = 0;
		distinctCount = 0;
		exists = false;
	}
	
	
	/**
	* Getter method for a class variable
	* Returns the ArrayList of read-in nodes
	* @return ArrayList nodes
	*/
	public ArrayList getNodes()
	{
		return nodes;
	}
	
	/**
	* Getter method for a class variable
	* Returns the HashMap of distinct nodes as keys, and tentative distance and visited status as values
	* @return HashMap unvisitedMap
	*/		
	public HashMap getUnvisitedMap()
	{
		return unvisitedMap;
	}
	
	/**
	* Getter method for a class variable
	* Returns the HashMap of distances between each pair of nodes
	* @return HashMap distancesMap
	*/
	public HashMap getDistancesMap()
	{
		return distancesMap;
	}
	
	/**
	* Getter method for a class variable
	* Returns the HashMap of neighbours for each distinct node
	* @return HashMap neighboursMap
	*/
	public HashMap getNeighboursMap()
	{
		return neighboursMap;
	}
	
	/**
	* Getter method for a class variable
	* Returns the HashMap which stores the node that led to each node by the shortest path
	* @return HashMap fromNodeMap
	*/
	public HashMap getFromNodeMap()
	{
		return fromNodeMap;
	}
	
	/**
	* Getter method for a class variable
	* Returns the ArrayList which stores the unvisited nodes
	* @return ArrayList unvisitedSet
	*/
	public ArrayList getUnvisitedSet()
	{
		return unvisitedSet;
	}
	
	/**
	* Getter method for a class variable
	* Returns the ArrayList which stores the node-pairs
	* @return ArrayList rootKeys
	*/
	public ArrayList getRootKeys()
	{
		return rootKeys;
	}
	
	/**
	* Getter method for a class variable
	* Returns the ArrayList which stores the distinct nodes
	* @return ArrayList newDistinct
	*/
	public ArrayList getNewDistinct()
	{
		return newDistinct;
	}
	
	/**
	* Getter method for a class variable
	* Returns the ArrayList which stores the distinct nodes
	* @return ArrayList distinctNodes
	*/
	public ArrayList getDistinctNodes()
	{
		return distinctNodes;
	}
	
	/**
	* Getter method for a class variable
	* Returns the ArrayList which stores the start node's neighbours
	* @return ArrayList rootNeighbours
	*/
	public ArrayList getRootNeighbours()
	{
		return rootNeighbours;
	}
	
	/**
	* Getter method for a class variable
	* Returns the int which keeps track of how many nodes we have
	* @return int nodesCount
	*/
	public int getNodesCount()
	{
		return nodesCount;
	}
	
	/**
	* Getter method for a class variable
	* Returns the int which keeps track of how many distinct nodes we have
	* @return int distinctCount
	*/
	public int getDistinctCount()
	{
		return distinctCount;
	}
	
	/**
	* Getter method for a class variable
	* Returns the boolean which helps us to check if the values entered by the user are valid
	* @return boolean exists
	*/
	public boolean doesExist()
	{
		return exists;
	}
	
	/**
	* Setter method for a class variable
	* Sets the value of the boolean which helps us to check if the values entered by the user are valid
	* @param boolean setter
	*/
	public void setExists(boolean setter)
	{
		exists = setter;
	}
  
	/**
	* This keeps track of how many lines are read in, for invalid input checks, and for beginning
	* the process of creating a list of our distinct nodes, beginning with ArrayList distinctNodes 
	* @param String x
	*/
	public void initialiseNodesList(String x)
	{
		nodesCount++;
				
		int count = 0;
					
		char[] stringArray = x.toCharArray();
					
		for (int i = 0; i < x.length(); i++)
		{
					
			if(stringArray[i] == '/')
			{
				break;
			}
			count++;
		}
				
		char[] newArray = new char[count];
				 
		for (int i = 0; i < (count); i++)
		{
			newArray[i] = stringArray[i];
		}
			
		String y = new String(newArray);
				
		nodes.add(y);
	}		
		
	/**
	* This populates the ArrayList of distinct nodes
	*/
	public void populateNewDistinct()
	{				

		for (int i = 0; i < nodesCount; i++)
		{
			distinctNodes.add("");
		}		
				
		for (int i = 0; i < nodes.size(); i++)
		{
			for (int j = 0; j < distinctNodes.size(); j++)
			{
				if (distinctNodes.get(j).equals(nodes.get(i)))
				{
					break;
				} else if (distinctNodes.get(j).equals(""))
				{
					distinctNodes.set(j, nodes.get(i));
					break;
				}
			}
		}		
				
		for (int i = 0; i < distinctNodes.size(); i++)
		{
			if (distinctNodes.get(i).equals(""))
			{
				break;
			}	
			distinctCount++;
		}
			
		for (int i = 0; i < distinctCount; i++)
		{
			newDistinct.add(distinctNodes.get(i));
		}
	}

	/**
	* This checks if the input entered by the user for start and end nodes is valid
	* @param String input
	*/
	public void doesStringExist(String input)	
	{		
		for (int i = 0; i < newDistinct.size(); i++)
		{
			if(newDistinct.get(i).equals(input))
			{
				exists = true;
				break;
			}
		}
	}		
	
	/**
	* This populates the map which keeps track of which nodes led to the end node via the shortest path
	*/		
	public void populateFromNodeMap()
	{
		for (int i = 0; i < newDistinct.size(); i++)
		{
			fromNodeMap.put(newDistinct.get(i), "");
		}
	}
	
	/**
	* This populates the set of unvisited nodes
	*/	
	public void populateUnvisitedSet()
	{			
		for (int i = 0; i < distinctCount; i++)
		{
			unvisitedSet.add(newDistinct.get(i));
		}
	}

	/**
	* This populates the map which keeps track of the tentative distance and visited status for each node
	*/
	public void populateUnvisitedMap()
	{			
		for (int i = 0; i < newDistinct.size(); i++)
		{
			unvisitedMap.put(newDistinct.get(i), distanceAndVistited);
		}
	}
	
	/**
	* This populates the map which keeps track of the distance between each pair of nodes
	* @param String z
	*/		
	public void populateDistancesMap(String z)
	{
		int count = 0;
			
		char[] stringArray = z.toCharArray();
		
		for (int i = 0; i < z.length(); i++)
		{
			if(stringArray[i] == '(')
			{
				break;
			}
			count++;
		}
			
		char[] newArray = new char[count];
		
		for (int i = 0; i < (count); i++)
		{
			newArray[i] = stringArray[i];
		}
		
		String sub = new String(newArray);
			
		int beginSub = 0;
		int endSub = 0;
		
		for (int i = 0; i < stringArray.length; i++)
		{		
			if(stringArray[i] == '(')
			{
				beginSub = i + 1;
			}
			if(stringArray[i] == ')')
			{
				endSub = i;
			}
		}
		
		String integerString = z.substring(beginSub, endSub);
		
		distancesMap.put(sub, Integer.parseInt(integerString));
	}
	
	/**
	* This populates, with keys, the map which keeps track of each nodes'neighbours
	*/
	public void populateNeighboursMapKeys()
	{
		for (int i = 0; i < distinctCount; i++)
		{
			neighboursMap.put(newDistinct.get(i), new ArrayList<String>());
		}
	}

	/**
	* This populates, with values, the map which keeps track of the distance between each pair of nodes
	* @param String neighboursCheck
	*/
	public void populateNeighboursMapValues(String neighboursCheck)
	{
		int firstWordCount = 0;
		int secondWordCount = 0;
		
		char[] neighboursCheckArray = neighboursCheck.toCharArray();
			
		for (int i = 0; i < neighboursCheck.length(); i++)
		{
				   
			if (neighboursCheckArray[i] == '/')
			{
				break;
			}
			firstWordCount++;
		}
		
		char[] newBaseArray = new char[firstWordCount];
				
		for (int i = 0; i < firstWordCount; i++)
		{
			newBaseArray[i] = neighboursCheckArray[i];
		}
		
		String fromNode = new String(newBaseArray);
		
		for (int i = 0; i < neighboursCheck.length(); i++)
		{
			if (neighboursCheckArray[i] == '(')
			{
				break;
			}
			secondWordCount++;
		}
			
		secondWordCount = secondWordCount - firstWordCount - 1;
			
		char[] newNeighbourArray = new char[secondWordCount];
		
		int q = 0;
		
		for (int i = fromNode.length() + 1; i < fromNode.length() + 1 + secondWordCount; i++)
		{
			newNeighbourArray[q] = neighboursCheckArray[i];
			q++;
		}
		
		String neighbourNode = new String(newNeighbourArray);
		
		if (neighboursMap.containsKey(fromNode))
		{
			neighboursMap.get(fromNode).add(neighbourNode);
		}
	}
	
	/**
	* This creates the List of neighbours for the start node
	* @param String input
	*/
	public void createNeighboursList(String input) 
	   {
		rootNeighbours = neighboursMap.get(input);
	}
	
	/**
	* This creates the List of node-pairs
	*/
	public void populateRootKeys()
	{	
		for (String key : distancesMap.keySet() ) 
		{
			rootKeys.add(key );
		}
	}
	
	/**
	* This updates unvisitedMap for the start node
	* @param String input
	*/		
	public void updateUnvisitedMapStartNode(String input)
	{
		for (int i = 0; i < rootKeys.size(); i++)
		{
			int keyCount = 0;

			Integer distance = 0;
			
			char[] keyArray = rootKeys.get(i).toCharArray();
			
			for (int j = 0; j < keyArray.length; j++)
			{
				if (keyArray[j] == '/')
				{
					break;
				}			
				keyCount++;				
			}
			
			String from = rootKeys.get(i).substring(0, keyCount);

			String to = rootKeys.get(i).substring(keyCount + 1, rootKeys.get(i).length());
			
			if (from.equals(input) || to.equals(input))
			{
				distance = distancesMap.get(rootKeys.get(i));
			}
						
			if ((distance != 0) && (!to.equals(input)))
			{
				int[] updatedDistance = {distance, unvisited};
				unvisitedMap.put(to, updatedDistance);
			}	
		}
	}
	
	/**
	* This removes the entered node from the set of visited nodes
	* @param String input
	*/		
	public void setStartNodeVisited(String input)
	{
		int[] updateRoot = {visitedDistance, visited};
		unvisitedMap.put(input, updateRoot);
		
		for (int i = 0; i < unvisitedSet.size(); i++)
		{
			if (unvisitedSet.get(i).equals(input))
			{
				unvisitedSet.remove(i);
			}
		}
	}
	
	/**
	* This performs the act of visiting the next unvisited node with the smallest distance attached to
	* it, and assigning distances to each of its neighbours. This process is repeated until the end node
	* is visited
	* @param String input
	*/		
	public void workThroughGrid(String input)	
	{	
		while(unvisitedMap.get(input)[1] != visited)
		{
			String minObj= null;
			
			int min= maxValue;
				
			for(Map.Entry<String, int[]> entry: unvisitedMap.entrySet())
			{
				if((entry.getValue()[0] < min) && (entry.getValue()[1] == unvisited))
				{
					min= entry.getValue()[0];
					minObj= entry.getKey();
				}
			}
			
			for (int i = 0; i < rootKeys.size(); i++)
			{
				int keyCount = 0;
				
				Integer distance = 0;

				char[] keyArray = rootKeys.get(i).toCharArray();
				
				for (int j = 0; j < keyArray.length; j++)
				{
					if (keyArray[j] == '/')
					{
						break;
					}			
					keyCount++;				
				}
				
				String from = rootKeys.get(i).substring(0, keyCount);
				String to = rootKeys.get(i).substring(keyCount + 1, rootKeys.get(i).length());

				if (from.equals(minObj) || to.equals(minObj))
				{
					distance = min + distancesMap.get(rootKeys.get(i));
				}
					
				boolean isVisited = true;
				for (int integer = 0; integer < unvisitedSet.size(); integer++)
				{
					if (unvisitedSet.get(integer).equals(to))
					{
						isVisited = false;
						break;
					}
				}

				int[] currentArray = unvisitedMap.get(to);

				if ((distance < currentArray[0]) && (from.equals(minObj)) && (isVisited == false))
				{
					int[] updatedDistance = {distance, unvisited};
					unvisitedMap.put(to, updatedDistance);
					fromNodeMap.put(to, from);
				}	
			}

			int[] updateNode = {min, visited};
			unvisitedMap.put(minObj, updateNode);
			
			for (int i = 0; i < unvisitedSet.size(); i++)
			{
				if (unvisitedSet.get(i).equals(minObj))
				{
					unvisitedSet.remove(i);
				}
			}
		}
	}
	
	/**
	* This gives as output the shortest distance between the two nodes, and the route taken
	* @param String endNode, string startNode
	*/
	public void tracePath(String endNode, String startNode)
	{
		Integer shortestRoute = unvisitedMap.get(endNode)[0];

		String trackBack = "Shortest distance from " + startNode + " to " + endNode + " is " + shortestRoute + "\n";
		
		trackBack = trackBack + "Commencing track-back. End node is: " + endNode + "\n";

		String previous = fromNodeMap.get(endNode);

		if((!previous.equals("")))
		{
			trackBack = trackBack + "Previous node is: " + previous + "\n";
			
			while (!previous.equals(""))
			{
				previous = fromNodeMap.get(previous);
				if (!previous.equals(""))
				{
					trackBack = trackBack + "Previous node on the trail is: " + previous + "\n";
				}
			}
		}
		trackBack = trackBack + "First node on the trail is: " + startNode;

		JOptionPane.showMessageDialog(null, trackBack, "Shortest Route", JOptionPane.INFORMATION_MESSAGE);
	}
}