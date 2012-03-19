import java.io.File;
import java.io.FileNotFoundException;
import java.io.PrintWriter;
import java.util.Scanner;

/**
 * 
 * @author William Blankenship
 * 
 * This programs's purpose is to combine two password dictionaries into a single master
 * file without any repeated terms. (Assumes each file doesn't have any terms that
 * are repeated within the same file).
 *
 */
public class driver {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		try {
			PrintWriter masterDictionary = new PrintWriter(new File("../masterDictionary.txt"));
			Scanner fileOne = new Scanner(new File("../johnTheRipper.txt"));
			while(fileOne.hasNextLine())
			{
				String entry = fileOne.nextLine();
				if(!entry.contains("'"))
				{
					masterDictionary.println(entry);
				}
			}
			fileOne.close();
			Scanner fileTwo = new Scanner(new File("../cainAndAble.txt"));
			while(fileTwo.hasNextLine())
			{
				String entry = fileTwo.nextLine();
				if(!entry.contains("'"))
				{
					boolean add = true;
					fileOne = new Scanner(new File("../johnTheRipper.txt"));
					while(fileOne.hasNextLine())
					{
						String inDict = fileOne.nextLine();
						if(inDict.equals(entry))
							add = false;
					}
					if(add)
					{
						masterDictionary.println(entry);
					}
					fileOne.close();
				}
			}
			masterDictionary.close();			
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		}
	}
}
