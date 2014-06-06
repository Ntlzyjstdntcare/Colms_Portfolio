/**
*@author  Derek Daly
*@version Java 6
*/
public class AdventureQue {
	int capacity;
	String[] myarr;
	int front = 0;
	int rear=0;
	int size=0;
	
	/**
	*Constructor for AdventureQue
	*Creates an AdventureQue, a Queue implemented with an array, to hold the steps taken by the user during gameplay
	*@param int capacity
	*@return AdventureQue
	*/
	public AdventureQue (int capacity){ 
		this.capacity=capacity;
		myarr= new String[capacity];
	}
	
	/**
	*Adds a string to the rear of the AdventureQue
	*Checks if the AdventureQue is empty and adds the newly inputted String to the rear of the AdventureQue. Increments size.
	*@param String elem
	*@return void
	*/
	public void addRear(String elem){
		myarr[rear]=elem;
		if ((rear ==capacity-1) && (front!=0)){
			rear=0;
		}
		else{
		rear++;
		}
		if (size !=capacity){
			size++;
		}
		
	}
	
	/**
	*Returns the current size of the AdventureQue
	*@param none
	*@return int size
	*/
	public int getSize(){
		return size;
	}
	
	/**
	*Checks whether the AdventureQue is empty
	*@param none
	*@return boolean
	*/
	public boolean isEmpty(){
		return (this.size==0);
	}
	
	/**
	*Removes the element at the front of the AdventureQue
	*Checks whether the AdventureQue has anything at the front. If so, increments the front and decrements the size.
	*@param none
	*@return void
	*/
	public void removeFront(){
		if (front ==capacity-1){
			front=0;
		}
		else{
			front++;
		}
		size--;
	}
	
	/**
	*Shows the element at the front of the AdventureQue
	*Returns the element at the front of the AdventureQue, for the purposes of output
	*@param none
	*@return String
	*/
	public String peekFront(){
		return myarr[front];
	}
	
	/**
	*Shows the element at the rear of the AdventureQue
	*Returns the element at the rear of the AdventureQue, for the purposes of output
	*@param none
	*@return String
	*/
	public String peekRear(){
		return myarr[rear];
	}
	
	/**
	*Empties the AdventureQue; sets size to zero
	*@param none
	*@return void
	*/
	public void clearQue(){
	size=0;
	}
	
}

