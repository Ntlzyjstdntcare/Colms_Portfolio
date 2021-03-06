import java.util.ArrayList;
import java.util.Scanner;
import java.io.FileReader;
import java.io.PrintWriter;
import java.io.FileNotFoundException;
import javax.swing.*;
//import java.awt.*;
//import java.awt.event.*;
import java.lang.Object;
/**
*@author 
*<ul>
*<li>Derek Daly, 
*<li>Indre Gerasimova, 
*<li>Colm Ginty, 
*<li>Suzanne McCarthy
*</ul>
*@version Java 6
*/
public class CYOANodeDriver {

	/**
	 * Main method.
	 * Initialises the input to read in the story; initialises the output file to receive the output, and an ArrayList to receive the file input
	 * @param args
	 * @return void
	 */
	public static void main(String[] args) {
		
		String FileIn1 ="adventure.txt";     
		String FileOut = "results.txt";		
		PrintWriter outputStream = null;	
		Scanner s = null;
				
		String lineIn;
		String newlineIn;
		ArrayList<String> CYA = new ArrayList<String>();  
		String[] breakmessage;
		 
//----------------------------------------------------------------------------------------------
//--------------------The following block reads the file data and initialises the ArrayList
		 
		try{
			s = new Scanner(new FileReader(FileIn1));
			while (s.hasNext()){
				lineIn= s.nextLine();
				
//----------------------The following code breaks the sentences in the file into a more readable version
				
				breakmessage=lineIn.split(" "); 
				int wordcount=breakmessage.length;
				for (int i=10;i<wordcount;i=i+10){
					breakmessage[i]=breakmessage[i]+"\n";
				}
				newlineIn=breakmessage[0];
				for (int i=1;i<wordcount;i++){
					newlineIn = newlineIn+" "+breakmessage[i];	
				}
				CYA.add(newlineIn);	
			}
		}
		catch (FileNotFoundException e){
			System.err.println("File not Found");
		}
		finally {
			if (s!= null){
				s.close();							
			}
		}
	
	//------------------------------------------------------------------------------------
	/**Initialises the Binary Tree with the contents of the CYA ArrayList
	  */
	//long start = System.nanoTime();
		/**
		 * Initialises the first node of the tree. Sets a copy variable to the first node, which is later updated while the root remains.
		 */
	
	CYOANode root = new CYOANode(CYA.get(0)) ; 
	CYOANode prev = root; 
	
	/**
	 * Sets up the tree, with int count to control the loop. This algorithm sets up the tree in a specific shape to make semantic sense when the game is played. 
	 * Uneven numbered nodes go left while even numbered nodes go right, but the previous node is only moved after the right node is initialised
	 */
	
	int count =1;  
	while (count < CYA.size()){
		if (count%2==1){																
			CYOANode newNode = new CYOANode(CYA.get(count)) ;
			prev.left=newNode;
		}
		if (count%2!=1){									
			CYOANode newNode = new CYOANode(CYA.get(count)) ;
			prev.right=newNode;
			prev=prev.left;
		}
		count++;
	}
	
	
	//------------------------------------------------------------------------------------------------------
	
	
	/**
	 * Sets up a Queue as a log for the adventure, made to the size of the input file.
	 * Adds opening line to the log.
	 * Prompts for user input, allowing the program to ignore the case.
	 * Sets an error message in the case of an invalid option.
	 * While the boolean from the CYOAnode class is false, the progress method is called and the story from the newly returned node is printed to the screen and added
	 * to the log.
	 * As long as there is a left child on the subtree, the user is prompted for a new option.
	 */
	
	AdventureQue CYOAQue=new AdventureQue(CYA.size());		
	CYOANode node=root;
	String[] choices = {"A", "B"};
    char option;
    String message;
    ImageIcon icon = new ImageIcon("tent.png",
             "nice yeti");
    ImageIcon icon1 = new ImageIcon("yeti.jpg",
            "nice yeti");

     while (node.left!=null){         //true) {
		message =node.getStory();
     	int response = JOptionPane.showOptionDialog(    // The following code was build upon code from Oracle (2014). Oracle Docs.Available at:
     			                                       //hhttp://docs.oracle.com/javase/tutorial/uiswing/components/dialog.html [Accessed 14 April 2014]
                  null                       // Center in window.
                , message        // Message
                , "Choose Your Own Adventure" // Title in titlebar
                , JOptionPane.YES_NO_OPTION  // Option type
                , JOptionPane.PLAIN_MESSAGE  // messageType
                , icon                      // Icon (none)
                , choices                    // Button text as above.
                , "None of your business"    // Default button's label
		
         );

     CYOAQue.addRear(node.getStory());             //adds opening line to log
       
     //... Use a switch statement to check which button was clicked.
     	 
     if((response!=0)&&(response!=1)){
    	 System.out.println("You have quit the game but will still be eaten by a Yeti.");    //error message if the user quits at the first try
         System.exit(0);           //closes program without printing log, just a design decision. Again, only if user quits at first try
     } else{
    	 if(response==0){
    		 option='a';              //node.progress('a');//
    	 } else{                     //if(response==1){
    		 option='b';            //node.progress('b');
           }
         
    	 //else{
    	 //option='x';
		//System.out.println("You quit the game but will still be eaten by a Yeti.");
		//}
				
          while(node.left!=null){                    //node.over==false){ //while boolean from node class is false (is changed in progress method)	
        	  node = node.progress(option);	//node is node returned from progress()
              message = node.getStory();
              response = JOptionPane.showOptionDialog(      // The following code was build upon code from Oracle (2014). Oracle Docs.Available at:
                                                           //http://docs.oracle.com/javase/tutorial/uiswing/components/dialog.html  [Accessed 14 April 2014]
             	       null            // Center in window.
                     , message        // Message
                     , "Choose Your Own Adventure"               // Title in titlebar
             	     , JOptionPane.YES_NO_OPTION                // Option type
             	     , JOptionPane.PLAIN_MESSAGE               // messageType
                     , icon1                                   // Icon (none)
             	     , choices                                // Button text as above.
             	     , "None of your business"               // Default button's label
             			
             );
             	//System.out.println(node.getStory());
                   CYOAQue.addRear(node.getStory());
                   
                        if((response!=0)&&(response!=1)){
                    		System.out.println("You have quit the game but will still be eaten by a Yeti.");           //error message if the user quits at the first try
                    		System.exit(0);           //closes program without printing log, just a design decision. Again, only if user quits at first try
                    	} else{
                    		 if(response==0){
                    			 option='a';    //node.progress('a');//
                    		 } else{           //if(response==1){
                    			 option='b';  //node.progress('b');
                    		 }
                          } 
           }
          
	/**
	 * Implements when the game is finished. Sets up file output writer, handling exceptions.
	 * Creates an int variable to the size of the log Queue.
	 * Prints a title to the output file and to the screen, then prints all elements in the log to the screen and the output file.
	 */
	
	System.out.println("");
	try {
		outputStream =(new PrintWriter(FileOut));  
	} 
	catch (FileNotFoundException e) {
		System.err.println("File not Found");		
	}
	
	int myqsize=CYOAQue.getSize();					
	String outelem;									
	String title="Your Adventure";
	outputStream.println(title);					
	System.out.println(title);
	
	for (int i=0;i<myqsize;i++){
		outelem=CYOAQue.peekFront();
		System.out.println(outelem);
		outputStream.println(outelem);
		CYOAQue.removeFront();
	 }
	outputStream.close();  
   }
  }
 }
}
	//System.out.println("Time: "+(end-start));
	/**Time-complexity
	*With 7 nodes: 		1219540
	*With 100 nodes:	6191692
	*With 500 nodes:	28084941
	*With 1000 nodes:	51302769
	*O(n)
	*/