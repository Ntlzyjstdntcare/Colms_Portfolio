/*
Colm O'Hara & Colm Ginty
13/01/2013
This is the driver class for the entire system. It contains methods which control the user-interface menu system, and other methods which control the 
management and administration of the library system. There is a further method which populates the library with sample books, items and users. 
*/

import java.util.ArrayList;
import java.util.Scanner;

public class Library{

	private static ArrayList<Book> books;  // an arrayList of books
	private static ArrayList<Item> items;  // an arrayList of items
	private static ArrayList<User> users;  // an arrayList of users
	
	private final static int MAX_USERS = User.MAX_USERS;
	private final static int MAX_CATALOGUE = 10;
	

	/**---------------------------------------------------------------**/
	public static void initialiseLibrary () {

		books = new ArrayList<Book>(MAX_CATALOGUE);  
		items = new ArrayList<Item>(MAX_CATALOGUE);  
		users = new ArrayList<User>(MAX_USERS);  

		// Initialise the library catalogue with 5 sample books
		books.add(new Book
			("A Tale of Two Cities", "Charles", "Dickens",  11111111, 'F'));
		books.add(new Book
			("The Lord of the Rings", "John R. R.", "Tolkien", 22222222, 'F'));
		books.add(new Book
			("A Brief History of Time", "Stephen", "Hawking",  33333333, 'N'));
		books.add(new Book
			("Java Concepts", "Cay S.", "Horstmann",  44444444, 'N'));
		books.add(new Book
			("Moneyball", "Michael", "Lewis",  55555555, 'S'));
		
		
		// Initialise the library catalogue with 5 sample books		
		// Each item in the library catalogue should correspond with a book 
		// in the book array, and appear in the same order in both 
		// arraylists. 
		for (int i = 0; i < 5; i++) {
			int bookID = books.get(i).getID();
			items.add(new Item(bookID));
		}
		
		// Initialise the library membership with 4 users
		users.add(new User("Joe", "Bloggs"));
		users.add(new User("Bill", "Gates"));		
		users.add(new User("Henry", "Ford"));
		users.add(new User("Grace", "Kelly"));	
	}
	
	
	/**---------------------------------------------------------------**/
	public static void main (String[] args) {
	
		initialiseLibrary();
		
		Scanner scan = new Scanner(System.in);
		int menuOption = 0;
	
		while(true) {
			clearConsole();
			System.out.println("Please Make a selection:"); 		
			System.out.println("[1] Borrow item"); 			
			System.out.println("[2] Return item"); 
			System.out.println("[3] Search for item(s) in Library"); 			
			System.out.println("[4] Library Administration"); 
			System.out.println("[0] Exit"); 
			System.out.print("Enter your choice > "); 			

			menuOption = scan.nextInt();
			
			switch(menuOption) {
				case 0: System.exit(0);
					break;			
				case 1: borrowItemMenu();
					break;
				case 2: returnItemMenu();
					break;			
				case 3: searchItems();
					break;
				case 4: libraryAdminMenu();
					break;	
				default:
					System.out.print("You have inputted an invalid option. ");
					System.out.println("press enter to continue.");
					pauseMe();
					break;
			}	
		}	
	}
	
	/**---------------------------------------------------------------**/
	private static void clearConsole() {
		for (int i=0; i < 100; i++) {
			System.out.println("");
		}
	}	
	
	/**---------------------------------------------------------------**/
	private static void pauseMe() {
		Scanner scan = new Scanner(System.in);
		
		System.out.println("press enter to continue.");		
		scan.nextLine();
		//scan.nextLine();		
		
	}

	/**---------------------------------------------------------------**/
	public static void borrowItemMenu() {
	
		if (users.size() <= 0) {
			clearConsole();
			System.out.println("The library membership is empty. ");	
			pauseMe();
			return;
		}
		
		if (items.size() <= 0) {
			clearConsole();
			System.out.println("The library catalogue is empty. ");	
			System.out.println("There are no items available to lend. ");
			pauseMe();
			return;
		}
		
		Scanner scan = new Scanner(System.in);
		int menuOption = 0;

		while (true) {		
			clearConsole();
			System.out.println("Please Make a selection:"); 		
			System.out.println("1.[1] Borrow item from Library "); 
			System.out.println("1.[2] List all items in Library"); 	
			System.out.println("1.[3] Return to previous menu"); 		
			System.out.print("Enter your choice > "); 			

			menuOption = scan.nextInt();
			
			switch(menuOption) {	
				case 1: borrowItemFromLibrary();
					break;
				case 2: printItems();
					break;			
				case 3: return;
				default:
					System.out.print("You have inputted an invalid option. ");
					pauseMe();
					break;
			}
		}
	}

	/**---------------------------------------------------------------**/
	public static void returnItemMenu() {
	
		if (users.size() <= 0) {
			clearConsole();
			System.out.print("The library membership is empty. ");	
			System.out.println("Therefore, there are no items to return. ");
			pauseMe();
			return;
		}
		
		if (items.size() <= 0) {
			clearConsole();
			System.out.println("The library catalogue is empty. ");	
			System.out.println("Therefore, there are no items to return. ");
			pauseMe();
			return;
		}		
		
		Scanner scan = new Scanner(System.in);
		int menuOption = 0;

		while (true) {		
			clearConsole();
			System.out.println("Please Make a selection:"); 		
			System.out.println("2.[1] Return item to Library."); 
			System.out.println("2.[2] List all items in Library."); 	
			System.out.println("2.[3] Return to previous menu."); 		
			System.out.print("Enter your choice > "); 			

			menuOption = scan.nextInt();
			
			switch(menuOption) {	
				case 1: returnItemToLibrary();
					break;
				case 2: printItems();
					break;			
				case 3: return;
				default:
					System.out.print("You have inputted an invalid option. ");
					pauseMe();
					break;
			}
		}
	}		
	
	/**---------------------------------------------------------------**/
	public static void libraryAdminMenu() {
		Scanner scan = new Scanner(System.in);
		int menuOption = 0;

		while (true) {		
			clearConsole();
			System.out.println("Please Make a selection:"); 		
			System.out.println("4.[1] Add Item."); 
			System.out.println("4.[2] Delete Item."); 
			System.out.println("4.[3] List Items."); 
			System.out.println("4.[4] List Users."); 				
			System.out.println("4.[5] Return to previous menu."); 		
			System.out.print("Enter your choice > "); 			

			menuOption = scan.nextInt();
			
			switch(menuOption) {	
				case 1: 	addItem();
					break;
				case 2: 	deleteItem();
					break;	
				case 3: 	printItems();
					break;
				case 4: 	printUsers();
					break;
				case 5: return;					
				default:
					System.out.print("You have inputted an invalid option. ");
					pauseMe();
					break;
			}
		}
	}

	/**---------------------------------------------------------------**/
	
	public static void borrowItemFromLibrary()
    {
        Scanner scan = new Scanner(System.in);
		int itemID; 
        int userID = 0;

        clearConsole();
		
		System.out.println("Enter Item ID of item to borrow > ");
        itemID = scan.nextInt(); 
   
        if (!isItemInLibrary(itemID))
        {
            System.out.println("\nItem does not exist in library catalogue");
            pauseMe();
            return;
        } else if (isItemInLibrary(itemID))
        { 
            for (Item i: items)
            {
                if ((i.getID()) == (itemID))
	            {
	       	        if (i.isOnLoan())
	                {
	                    System.out.println("\nThis item cannot be borrowed because it is already on loan");
	                    pauseMe();
	                    return;
	                } else if (!i.isOnLoan()) 
	                {
	                    System.out.println("\nEnter user ID of user (borrower) > ");
                        userID = scan.nextInt();
	                }
	
	                if (!isUserInLibrary(userID))
	                {
	                    System.out.println("\nThe user ID entered does not exist in the library membership");
	                    pauseMe();
	                    return;
	                } else if (isUserInLibrary(userID))
	                {
	                    incrementUserItems(userID);	
	                    i.borrowItem(userID);
	                    pauseMe();
	                    return; 
	                }
	            } 
            }
        }  
    }	
	
	public static void returnItemToLibrary()
    {
        Scanner scan = new Scanner(System.in); 
        int itemID;
        int itemIndex;
	
        clearConsole();
		
		System.out.println("Enter ID of item to return > ");
        itemID = scan.nextInt();

        if (!isItemInLibrary(itemID))
        {
            System.out.println("\nItem does not exist in library catalogue");
            pauseMe();
            return;
        } else if (isItemInLibrary(itemID))
        {
            for (Item i: items)
            {
                if ((i.getID()) == (itemID))
                {
	                if (!i.isOnLoan())
                    {
                        System.out.println("\nItem cannot be returned because it is not on loan");
                        pauseMe();
                        return;
                    } else if (i.isOnLoan())
                    {
	                    for (User u: users)
	                    {  
	                        if ((u.getID()) == (i.getUserID()))
	                        {
	                            decrementUserItems(u.getID());
	                            i.returnItem();
								pauseMe();
                                return;
                            }
                        }
                    }
                } 
            }	
        }
    }
	
	public static boolean isUserInLibrary(int userID)
    {
        boolean returnValue = false;
  
        for (User u: users)
        {
            if ((u.getID()) == (userID))
            {
                returnValue = true;
            }
        }	
        return returnValue;
    }
	
	public static boolean isItemInLibrary(int itemID)
    {
        boolean returnValue = false;

        for (Item i: items) 
        {
            if ((i.getID()) == (itemID))
            {
                returnValue = true;
            }
        }	
        return returnValue;
    }
	
	/*
	This method prints to the screen all items that are in the library catalogue, when the system user chooses to do so via the menu system.
	If no items are present in the catalogue a message will be printed to the screen to that effect.
	A message is printed to the screen informing the system user of the number of items in the catalogue.
	If items are present, details of each item are printed to screen in turn.
	Calls the clearConsole() method to create a blank screen.
	Calls various getter methods on the three arraylists.
	Calls the pauseMe() method to prompt the system user for input which will bring him back to the previous menu screen.
	*/
	public static void printItems()
	{
	    //This variable will later hold the user in the users array that has borrowed a particular book.
		int usersElement = 0;
		
		clearConsole();
		
		//If there are no items in the catalogue, print this to screen.
		if (items.size() == 0)
		{
		    System.out.println("The library has no items in its catalogue.");
		}
		
		//In all cases, print the number of items in the catalogue.
		System.out.println("\nThe total number of items in the library catalogue is " + items.size() + "\n");
		
		//Loop through the items array, and if it contains items, print the details of each item.
		for (int i = 0; i < items.size(); i++)
		{
		    System.out.println("Item " + (i+1) + " in library:");
		    System.out.println("        " + books.get(i).getTitle());
		    System.out.println("        " + books.get(i).getAuthor());
		    System.out.println("        " + books.get(i).getID());
		    System.out.println("        " + books.get(i).getCategory());
		
			//If an item has a userID attached to it (i.e. is on loan), assign the index of that user in the users arraylist to a variable.
			for (int z = 0; z < users.size(); z++)
	        {
	            if (items.get(i).getUserID() == users.get(z).getID())
		        {
		            usersElement = z;
		        }
	        } 
			
			//If an item is not on loan, print this to screen.
		    if (!items.get(i).isOnLoan())
		    {
		        System.out.println("This item is available.\n");
		    }
		    
			//If an item is on loan, print this to screen, using the variable we declared earlier to find the user that has borrowed the item.
			if (items.get(i).isOnLoan())
		    {
		        System.out.println("This item is on loan to user ID: " + users.get(usersElement).getID() + "\n");
		    }
		}
		//Run pauseMe() method to prompt the system user for input which will bring him back to the previous menu screen.
		pauseMe();
	}
	
	/*
	This method prints to the screen all users that are in the library membership, when prompted by the system user.
	If no users are present a message will be printed to the screen to that effect.
	A message is printed to the screen informing the system user of the number of users in the membership.
	If users are present, details of each user are printed to screen in turn.
	Calls the clearConsole() method to create a blank screen.
	Calls various getter methods on the users arraylist.
	Calls the pauseMe() method to prompt the system user for input which will bring him back to the previous menu screen.
	*/
	public static void printUsers()
	{
	    clearConsole();
		
		//If there are no users in the membership, print this to screen.
		if (users.size() == 0)
		{
		    System.out.println("The library membership is empty.");
		}
		
		//In all cases, print the number of users in the membership.
		System.out.println("\nThe total number of users in the library catalogue is " + users.size() + "\n");
		
		//Loop through the users array, and if it contains users, print the details of each user.
		for ( int i = 0; i < users.size(); i++)
		{
		    System.out.println("User " + (i+1) + " in library:");
			System.out.println("        Name: " + users.get(i).getName());
			System.out.println("        ID: " + users.get(i).getID());
			System.out.println("        Number of items borrowed: " + users.get(i).getNumOfItemsBorrowed() + "\n");
		}
		//Run pauseMe() method to prompt the system user for input which will bring him back to the previous menu screen.
		pauseMe();
	}
	
	/*
	This method allows the system user to search the library catalogue for items that begin with a specified search string.
	If the library catalogue is empty, a message is printed to the screen to that effect.
	If items are found which begin with the search string their details are printed to the screen
	If no item is present that begins with the search string, a message is printed to the screen to that effect.
	Calls the clearConsole() method to create a blank screen.
	Calls various getter methods on the three arraylists.
	Calls the pauseMe() method to prompt the system user for input which will bring him back to the previous menu screen.
	*/
	public static void searchItems()
	{
		Scanner scan = new Scanner(System.in);
		//Will hold the specified search string.
		String enteredString = null;
		//Will hold the length of the search string.
		int stringLength = 0;
		//Will hold the user in the users array that has borrowed a particular book.
		int usersElement = 0;
		
		clearConsole();
		
		//If there are no items in the catalogue print this message to screen, and exit method.
		if (items.size() <= 0)
		{
		    System.out.println("\nThe library catalogue is empty.");
			pauseMe();
			return;
		} else 
		{
		    //If there are items in catalogue, prompt user for search string, and assign to variable.
			System.out.print("This option allows you to search for an item(s) whose title starts with a specific string." + 
		                     "Please enter the search string, paying heed to capitalisation > ");
     		
            enteredString = scan.nextLine();
		    //Assign length of search string to variable.
			stringLength = enteredString.length();
		    //Start a counter which will be used to determine if the search string matched any items, for later use.
			int count = 0;
			
		    //Loop through books arraylist, checking to see if the search string matches the beginning of any book titles.
			//If so, print book details to screen.
			for (int i = 0; i < books.size(); i++)
		    {
			    if (books.get(i).getTitle().substring(0, stringLength).equals(enteredString))
			    {
			        System.out.println("\nItem " + (i+1) + " in library:");
				    System.out.println("        " + books.get(i).getTitle());
				    System.out.println("        " + books.get(i).getAuthor());
				    System.out.println("        " + books.get(i).getID());
				    System.out.println("        " + books.get(i).getCategory());
												
		            //If an item has a userID attached to it (i.e. is on loan), assign the index of that user in the users arraylist to a variable.
					for (int z = 0; z < users.size(); z++)
	                {
	                    if (items.get(i).getUserID() == users.get(z).getID())
		                {
		                    usersElement = z;
		                }
	                } 
			            	
				    //If item is not on loan print this message.
				    if (!items.get(i).isOnLoan())
		            {
		                System.out.println("This item is available.\n");
		            }
		            //If item is on loan print this message.
					if (items.get(i).isOnLoan())
		            {
		                System.out.println("This item is on loan to user ID: " + users.get(usersElement).getID() + "\n");
		            }
					count++;  	
		        }	
			}
			//If no items were found whose title matched the search string, print this message and exit method.
			if (count == 0)
			{
			    System.out.println("No items found.");
				pauseMe();
                return;	
			} else
			{
			    //Otherwise print this message and exit.
				System.out.println("Found " + count + " item(s) in total.\n");
			    pauseMe();
                return;	
			}
			
		}
	}
	
	public static boolean incrementUserItems(int userID)
    {
        boolean returnValue = false;
        int uNumBeforeInc = 0;
        int uNumAfterInc = 0;

        if (!isUserInLibrary(userID))
        {
            return returnValue;
        } else if (isUserInLibrary(userID))
        {
            for (User u: users)
            {  
                if((u.getID()) == (userID))
                {
                    uNumBeforeInc = u.getNumOfItemsBorrowed();
                    u.incrementItems();
                    uNumAfterInc = u.getNumOfItemsBorrowed();
                }
	
	            if (((uNumAfterInc) - (uNumBeforeInc)) == 1)
	            {
	                returnValue = true;
	            }
            }
        }
        return returnValue;
    }	
	
	public static boolean decrementUserItems(int userID)
    {
        boolean returnValue = false;
        int uNumBeforeDec = 0;
        int uNumAfterDec = 0;

        if (!isUserInLibrary(userID))
        {
            return returnValue;
        } else if (isUserInLibrary(userID))
        {
            for (User u: users)
            {
                if ((u.getID()) == (userID))
                {
                    uNumBeforeDec = u.getNumOfItemsBorrowed();
                    u.decrementItems();
                    uNumAfterDec = u.getNumOfItemsBorrowed();
                }
  
                if ((uNumBeforeDec) - (uNumAfterDec) == 1)
                {
	                returnValue = true;
                }
            }
        }
        return returnValue;
    }
	
	/*
	This method allows the system user to add new items to the library catalogue. 
	If the catalogue is full the system user is not allowed to enter a new item, and is prompted to return to the previous menu.
	Otherwise the system user is prompted to enter the various details of the new item.
	Calls the clearConsole() method to create a blank screen.
	Calls a getter method on the items arraylist.
	Calls the pauseMe() method to prompt the system user for input which will bring him back to the previous menu screen.
	*/
	public static void addItem()
	{
	    Scanner scan = new Scanner(System.in);
		//These variables will hold the details of the new item that are entered by the system user.
		String enteredTitle;
		String enteredFirstName;
		String enteredSurName;
		int enteredID;
		String enteredCategory;
		//This variable will hold the first character of the string that is entered by the system user when he is prompted to enter
		//the category of the new item. This is needed because if we try to use enteredCategory as a parameter for the new book object
		//we will produce an error message, because we have not checked that the entered string is not empty.
		char ultimateCategory = '\u0000';
		
		clearConsole();
		
		//If the catalogue is full print this message to the screen and exit method.
		if (items.size() >= MAX_CATALOGUE)
		{
		    System.out.println("\nThe library catalogue is full. The library catalogue limit is " + MAX_CATALOGUE + " items.");
			pauseMe();
			return;
		} else
		{		
			//Else prompt the user to enter the details of the new item.
		    System.out.print("\nEnter title of item > ");
		    enteredTitle = scan.nextLine();
			
		    System.out.print("\nEnter first name of author > ");
		    enteredFirstName = scan.nextLine();
			
		    System.out.print("\nEnter surname of author > ");
		    enteredSurName = scan.nextLine();
			
		    System.out.print("\nEnter Item ID > ");
			enteredID = scan.nextInt();
			for (int i = 0; i < items.size(); i++)
			{
			     //If the entered ID is already attached to an item, print this message and exit.
				if (items.get(i).getID() == enteredID)
				{
					System.out.println("The ID you have entered is attached to an item already in the system. Please return to the previous menu.");
					pauseMe();
				    return;
				} 
				//Here we attach the constraint of the ID having 8 digits by declaring that it must be between these two numbers. 
				//If it is not, print message and exit.
				if ((enteredID < 11111111) || (enteredID > 99999999))
				{
				    System.out.println("The ID must be a number between 11111111 and 99999999. Please return to the previous menu."); 
					pauseMe();
				    return;
				}
			}
		    
		    System.out.print("\nEnter category of item [F]iction, [N]on-fiction, [B]iography, [S]port > ");
			enteredCategory = scan.next();
			
			//If entered string is not empty and is one of the required letters, assign first character to variable.
			if ((enteredCategory.length() > 0) && ((enteredCategory.equals("F")) || (enteredCategory.equals("f")) || (enteredCategory.equals("N")) 
			   || (enteredCategory.equals("n")) || (enteredCategory.equals("B")) || (enteredCategory.equals("b")) || (enteredCategory.equals("S")) 
			   || (enteredCategory.equals("s"))))
			{
			    ultimateCategory = enteredCategory.charAt(0);
			} else
			{
			    //Otherwise print this message and exit.
				System.out.println("You have not entered a valid category.");
				pauseMe();
				return;
			}
				    
			//Add a new book object to the books arraylist with the attributes entered by the system user.
			books.add(new Book(enteredTitle, enteredFirstName, enteredSurName, enteredID, ultimateCategory));
				
			//Add a new item object to the items arraylist with the attribute entered by the system user.
			items.add(new Item(enteredID));
				
			System.out.println("\nItem " + enteredID + " successfully added to library.");
				
			pauseMe();
			return;
		}
	}
	
	/*
	This method allows the system user to delete items from the library catalogue. 
	If the catalogue is empty the system user is not allowed to delete an item, and is prompted to return to the previous menu.
	Otherwise the system user is prompted to enter the ID of the item to be deleted.
	If the entered ID exists in the catalogue and is not on loan, it is deleted from the catalogue.
	Calls the clearConsole() method to create a blank screen.
	Calls a getter method on the items arraylist.
	Calls the pauseMe() method to prompt the system user for input which will bring him back to the previous menu screen.
	*/
	public static void deleteItem()
	{
	    Scanner scan = new Scanner(System.in);
		//Will hold the ID of the item to be deleted.
		int enteredID;
		//Will hold the index in the items arraylist of the item that is to be deleted.
		int itemsElement = 0;
		//Will hold the item that is to be deleted.
		Item newItem = null;
		
		clearConsole();
		
		//If the catalogue is empty print this message and exit method.
		if (items.size() <= 0)
		{
		    System.out.println("\nThe library catalogue is empty.");
			pauseMe();
			return;
		} else 
		{
		    //Otherwise prompt the user for the ID of the item that is to be deleted.
			System.out.print("Enter the itemID of the item to be deleted > ");
			enteredID = scan.nextInt();
			
			//Find the index in the items arraylist of the item to be deleted.
			for (int i = 0; i < items.size(); i++)
		    {
		        if (items.get(i).getID() == enteredID)
			    {
			        itemsElement = i;
					newItem = items.get(i);
			    }  
		    }
			
			//If the item is not in the arraylist print this message.
			if (items.indexOf(newItem) == -1)
			{
			    System.out.println("\nThe item ID entered does not exist in the library catalogue.");
			} else if (items.get(itemsElement).isOnLoan())
			{
			    //If the item is on loan print this message.
				System.out.println("\nItem " + enteredID + " cannot be deleted because it is currently on loan to user " + items.get(itemsElement).getUserID() + ".");
			} else
			{
			    //If the item is in the arraylist and is not on loan, remove it from the books and items arraylists and print this message.
				books.remove(items.indexOf(newItem));
				items.remove(items.indexOf(newItem));
				
				System.out.print("\nItem " + enteredID + " was successfully deleted.\n");
			}
			//Exit method.
			pauseMe();
			return;
		}
	}
}