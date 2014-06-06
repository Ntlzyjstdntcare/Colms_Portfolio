/**
*@author 
*<ul>
*<li>Colm Ginty 
*<li>Suzanne McCarthy
*</ul>
*@version Java 6
*/

public class CYOANode {
	/**
	 * Initialises three nodes for use in progress method
	 */
	protected CYOANode curr, left, right;
	
	/**
	 * Initialises a String that will be contained in a node and holds a portion of the adventure story
	 */
	protected String story;
	
	/**
	 * Used to check if the story has finished. Made public in order to be accessible directly from driver
	 */
	private boolean over=false;
			
	/**
	*Constructor for CYOAnode
	*Creates a CYOAnode containing a string
	*@param String story
	*@return CYOAnode
	*/	
	public CYOANode (String story){
		this.story=story;
		left=right=null;
	}
	
	public boolean isOver(){
		return this.over;
	}
	
	public void setOver(boolean over){
		this.over = over;
	}
		
	
	/**
	*Getter method used to tell the story
	*Returns the string story contained in a CYOAnode
	*@param none
	*@return String story
	*/		
	public String getStory(){
		return this.story;
	}
		
	
	/**
	*Progresses the story by going right or left on the tree.
	*Converts the current CYOAnode into its left or right child depending on the input given. Checks if the current node is a leaf and if so, returns the node and so ends the game. 		
	* Otherwise,converts node to either its right or left child.
	*@param char option
	*@return CYOAnode
	*/		
	public CYOANode progress(char option){
  
		
		//CYOAnode finish = new CYOAnode("end");
				
		    CYOANode node = this; 
   
			if (option=='a'){
				if(node.left==null){ //if there's no left node, changes public boolean "over" to true
					over=true;
					return node;
                                       //return finish; //and returns the current node (change back to return node
				}
				node=node.left; //otherwise, progresses and returns new node
                             	return node;
				
				
			}
			else if (option=='b'){
				if(node.right==null){ //all as above
					over=true;
					return node; //return finish; //change back to return node
				}
				node=node.right;
				return node;
				
				
			}
			return node; //return finish; //returns current node in case of invalid input change back to return node
			}
									

}								