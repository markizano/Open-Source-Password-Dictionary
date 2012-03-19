import java.io.File;
import java.io.FileNotFoundException;
import java.io.PrintWriter;
import java.util.Scanner;


public class Driver {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		String createDatabase = "CREATE DATABASE `passwordDictionary` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;\n" +
								"USE `passwordDictionary`;\n";
		String createTable = "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n\n" +
							 "CREATE TABLE IF NOT EXISTS `dictionary` (\n" +
							 "  `pid` int(11) NOT NULL AUTO_INCREMENT,\n" +
							 "  `password` varchar(125) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,\n" +
							 "  PRIMARY KEY (`pid`),\n" +
							 "  UNIQUE (`password`)\n" +
							 ") ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;\n\n";
		try {
			PrintWriter sqlDatabase = new PrintWriter(new File("../buildDatabase"));
			sqlDatabase.println(createDatabase + createTable + "INSERT INTO `dictionary` (`password`) VALUES");
			Scanner passwordList = new Scanner(new File("../masterDictionary.txt"));
			
			while(passwordList.hasNextLine())
			{
				String entry = passwordList.nextLine();
				sqlDatabase.println("('"+entry+"'),");
			}
			
			sqlDatabase.println("('repen833');");
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		}
	}

}
