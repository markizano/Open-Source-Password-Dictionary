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
							 "  `password` varchar(125) NOT NULL,\n" +
							 "  PRIMARY KEY (`pid`)\n" +
							 ") ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;\n\n";
		String insertValues = "INSERT INTO `dictionary` (`password`) VALUES\n";
		try {
			PrintWriter sqlList = new PrintWriter("../buildDatabase");
			sqlList.println(createDatabase + createTable + insertValues);
			try {
				Scanner passwordList = new Scanner(new File("../johnTheRipper.txt"));
				while(passwordList.hasNextLine())
				{
					String line = passwordList.nextLine();
					if(!line.contains("'"))
						sqlList.println("('"+line+"'),");
				}
				passwordList.close();
			} catch (FileNotFoundException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			try {
				Scanner passwordList = new Scanner(new File("../cainAndAble.txt"));
				while(passwordList.hasNextLine())
				{
					String line = passwordList.nextLine();
					if(!line.contains("'"))
						sqlList.println("('"+line+"'),");
				}
				passwordList.close();
			} catch (FileNotFoundException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			sqlList.println("('repen833');");
			sqlList.close();
		} catch (FileNotFoundException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}

	}

}
