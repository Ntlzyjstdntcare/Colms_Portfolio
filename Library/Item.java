public class Item
{
    private int id;
	private boolean onLoan;
	private int userID;
	
	public Item (int bookID)
	{
	    id = bookID;
		onLoan = false;
        userID = 0;		
	}
	
	public int getID()
	{
	    return id;
	}
	
	public boolean isOnLoan()
	{
	    return onLoan;
	}
	
	public int getUserID()
	{
	    return userID;
	}
	
	public void borrowItem(int userID)
	{
	    if (onLoan == true)
		{
		    System.out.println("This item cannot be borrowed because it is already on loan.");
		}
		if (onLoan == false)
		{
		    onLoan = true;
			this.userID = userID;
			System.out.println("Item "+ getID() + " has been successfully borrowed by user " + getUserID());
		}
	}
	
	public void returnItem()
	{
	    if (onLoan == false)
		{
		    System.out.println("The item cannot be returned because it is not on loan.");
		}
		if (onLoan == true)
		{
		    onLoan = false;
			userID = 0;
			System.out.println("User " + getUserID() + " has successfully returned the item " + getID());
		}
	}
	
}