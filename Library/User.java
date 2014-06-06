public class User
{
    private String userFirstName;
	private String userSurName;
	private String userName;
	private int ID;
	private int numOfItemsBorrowed;
	private static int nextID = 100;
	public final static int MAX_USERS = 5;
	public final static int MAX_ITEMS = 3;
	
	public User (String userFirstName, String userSurName)
	{
	    this.userFirstName = userFirstName;
		this.userSurName = userSurName;
		userName = userFirstName + " " + userSurName;
		ID = nextID;
		nextID++;
		numOfItemsBorrowed = 0;
	}
	
	public String getName()
	{
	    return userName;
	}
	
	public int getID()
	{
	    return ID;
	}
	
	public int getNumOfItemsBorrowed()
	{
	    return numOfItemsBorrowed;
	}
	
	public void incrementItems()
	{
	    if (numOfItemsBorrowed >= MAX_ITEMS)
		{
		    System.out.println("The user cannot borrow an item from the library because the user has already borrowed " + getNumOfItemsBorrowed() + " items.");
		} else
		{
		    numOfItemsBorrowed++;
			System.out.println("The user now has " + getNumOfItemsBorrowed() + " items.");
		}
	}
	
	public void decrementItems()
	{
	    if (numOfItemsBorrowed <= 0)
		{
		    System.out.println("The user cannot return an item to the library because the user has not borrowed any items.");
		} else
		{
		    numOfItemsBorrowed--;
			System.out.println("The user now has " + getNumOfItemsBorrowed() + " item(s).");
		}
	}
}