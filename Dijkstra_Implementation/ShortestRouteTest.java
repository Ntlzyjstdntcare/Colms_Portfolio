/**
* @author 
* <ul>
* <li>Colm Ginty, 
* </ul>
* @version Java 7
*/

import java.io.FileReader;
import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;
import java.util.Arrays;
import java.util.Scanner;
import javax.swing.*;


class ShortestRouteTest
{
    /**
	* Main method.
	* Initialises the input to create the grid. Initialises file-handling objects 
	* @param args
	*/
	public static void main (String args[]) throws IOException
    {
        /**
	    * This is the input file which will be read in
	    */
		String fileIn = System.getProperty("user.dir") + File.separator + "input2.txt";

		BufferedReader nodesIn = new BufferedReader(new FileReader(fileIn));
		BufferedReader nodesIn2 = new BufferedReader(new FileReader(fileIn));
		BufferedReader nodesIn3 = new BufferedReader(new FileReader(fileIn));

		String message;

		ShortestRoute test = new ShortestRoute();
		
		try
		{
			long start = System.nanoTime();

			message = "Please populate the input2.txt file with valid data, and press the button below.\n" +
			          "Node pairs should be entered in the following format: a/b(12), where 'a' and 'b'\n are nodes and " +
					  "12 is the distance between them. To ensure the validity of the\n data, please ensure that all node pairs" +
					  " are entered on a new line, and that no\n blank lines are left between node pairs. Also, please ensure " +
					  "that every node\n is represented as the first node in a node pair. The surest way to do this is to\n enter " +
					  "each node pair 'both ways'. E.g. for the nodes 'a' and 'b', enter a/b(12),\n and on a new line, b/a(12).";

			JOptionPane.showMessageDialog(    
                  null                       // Center in window.
                , message        // Message
                , "Find the Shortest Route Between Two Nodes of a Grid" // Title in titlebar
                , JOptionPane.INFORMATION_MESSAGE  // messageType
		
            );
			
			String x;
			try
            {    			
				while ((x = nodesIn.readLine()) != null)
				{
					/**
	                * This keeps track of how many lines are read in, for invalid input checks, and for beginning
	                * the process of creating a list of our distinct nodes, beginning with ArrayList distinctNodes 
	                */
					test.initialiseNodesList(x);
				}
				nodesIn.close();
				
			} catch (FileNotFoundException e) 
			{
		        System.out.println("File not Found");		
	        }			

			if (test.getNodesCount() == 0)
            {
                System.out.println("The input file for the program is empty. Please input valid data and run the program again.");
				System.exit(0);
            }	

			if (test.getNodesCount() == 1)
            {
                System.out.println("Invalid input. Please ensure that all nodes in your graph are represented BEFORE the '/'.");
				System.exit(0);
            }			

			test.populateNewDistinct();

			String startNode = JOptionPane.showInputDialog("Please enter a start node: ");

		    test.doesStringExist(startNode);
	
		    String input = new String("");

			while(!test.doesExist())
			{
				input = JOptionPane.showInputDialog("The node you entered does not exist. Please enter a valid node: ");
			    test.doesStringExist(input);
		    }

			if (!input.equals(""))
			{
			    startNode = input;
			}

		    String endNode = JOptionPane.showInputDialog("Please enter an end node: ");

			while(endNode.equals(startNode))
			{
			    System.out.println("You have entered the same node twice. The distance between these nodes is, of course, 0. Thank you for using this program!");
				System.exit(0);
			}

			test.setExists(false);

			test.doesStringExist(endNode);
		
		    input = "";

			while(!test.doesExist())
			{
				input = JOptionPane.showInputDialog("The node you entered does not exist. Please enter a valid node: ");
			    test.doesStringExist(input);
		    }

			if (!input.equals(""))
			{
			    endNode = input;
			}
	
			test.populateFromNodeMap();

			test.populateUnvisitedSet();

			test.populateUnvisitedMap();
			
			String z;
			
            try
            {			
				/**
	            * We read in from the file again, in order to parse the distances and the node-pairs from the input Strings.
				* This will allow us to populate the distancesMap
	            */
				while ((z = nodesIn2.readLine()) != null)
				{
					test.populateDistancesMap(z);
                }	
                nodesIn2.close();
			} catch (FileNotFoundException e) 
			{
		        System.out.println("File not Found");		
	        }	

			test.populateNeighboursMapKeys();
			
			String neighboursCheck;
				
			try
			{
			    /**
	            * We read in from the input file again, in order to populate the Map that contains a nodes' neighbours
	            */
				while ((neighboursCheck = nodesIn3.readLine()) != null)
				{
				    test.populateNeighboursMapValues(neighboursCheck);
				
				}
			    nodesIn3.close();
			} catch (FileNotFoundException e) 
			{
		        System.out.println("File not Found");		
	        }

			test.createNeighboursList(startNode);

			test.populateRootKeys();

			test.updateUnvisitedMapStartNode(startNode);

			test.setStartNodeVisited(startNode);
				
            /**
	        * This performs the act of visiting the next unvisited node with the smallest distance attached to
	        * it, and assigning distances to each of its neighbours. This process is repeated until the end node
	        * is visited
	        */				
			test.workThroughGrid(endNode);
			 
			/**
	        * This gives as output the shortest distance between the two nodes, and the route taken
	        */ 
			test.tracePath(endNode, startNode);						

			long end = System.nanoTime();
		    System.out.println("Time: "+(end-start));
			/**Time-complexity
	        *With 6 nodes: 		7518709952
	        *With 18 nodes:	    21528290150
	        *With 24 nodes:		17101947400
	        *O(n)
	        */
        } catch (IOException e) 
        {
            throw new RuntimeException("IO Exception!!!!!", e);
        } catch (NullPointerException e)
		{
		    System.err.println("Oops! Something has gone wrong. The most likely explanation is that the data in " + 
			                   "the input file is invalid. Please check the validity of the data and try again.");
		} catch (ArrayIndexOutOfBoundsException e)
		{
		    System.err.println("Oops! Something has gone wrong. The most likely explanation is that the data in " + 
			                   "the input file is invalid. Please check the validity of the data and try again.");
        } catch (NumberFormatException e)
		{
		    System.err.println("Oops! Something has gone wrong. The most likely explanation is that there are " + 
			                   "blank lines in the input file. Please check the validity of the data and try again.");
		} finally
		{
            if (nodesIn != null)
            {
                nodesIn.close();
            }
            if (nodesIn2 != null)
            {
                nodesIn2.close();
            }
			if (nodesIn3 != null)
            {
                nodesIn3.close();
            }
        }	
	}
}