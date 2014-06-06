public class Book
{
    private String title;
	private String authorFirstName;
	private String authorSurName;
	private String authorName;
	private int ID;
	private char category;
	
	//I feel like the category variable begs for an enum type, so I've included the type here even though I haven't implemented it. We can talk about it.
	public enum Category
	{
	    F, f, N, n, B, b, S, s;
	}
	
	public Book(String title, String authorFirstName, String authorSurName, int ID, char category)
	{
	    this.title = title;
		this.authorFirstName = authorFirstName;
		this.authorSurName = authorSurName;
		authorName = authorFirstName + " " + authorSurName;
		this.ID = ID;
		this.category = category;
	}
	
	public String getTitle()
	{
	    return title;
	}
	
	public String getAuthor()
	{
	    return authorName;
	}
	
	public int getID()
	{
	    return ID;
	}
	
	public char getCategory()
	{
	   return category;
	}
}