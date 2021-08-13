/**
 * Film Weekly Data Importer for the MARQues System
 * 
 * This application imports the Film Weekly data stored in the various
 * Microsoft Excel workbooks directly into the MARQues database
 * 
 * The workbooks must be saved in the CSV format for processing
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

package au.edu.flinders.ehl.filmweekly;

import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

import org.apache.commons.cli.CommandLine;
import org.apache.commons.cli.CommandLineParser;
import org.apache.commons.cli.HelpFormatter;
import org.apache.commons.cli.OptionBuilder;
import org.apache.commons.cli.Options;
import org.apache.commons.cli.PosixParser;
import org.apache.commons.configuration.Configuration;
import org.apache.commons.configuration.ConfigurationException;
import org.apache.commons.configuration.PropertiesConfiguration;
import org.apache.log4j.Logger;
import org.apache.log4j.PropertyConfigurator;

import au.edu.flinders.ehl.filmweekly.debug.JsonList;
import au.edu.flinders.ehl.filmweekly.debug.CoordList;

import com.techxplorer.java.utils.FileUtils;

/**
 * Main driving class for the application
 */
public class FwImporter {
	
	// public class level constants
	/**
	 * name of the application
	 */
	public static final String APP_NAME      = "Film Weekly Data Importer";
	
	/**
	 * copyright statement
	 */
	public static final String APP_COPYRIGHT = "Copyright 2011, Flinders University";
	
	/**
	 * license URL
	 */
	public static final String APP_LICENSE   = "License: http://opensource.org/licenses/bsd-license.php";
	
	/**
	 * version information
	 */
	public static final String APP_VERSION   = "Version: 1.0.3";
	
	/**
	 * URL for more information
	 */
	public static final String APP_MORE_INFO = "More info: http://code.google.com/p/marques-project/wiki/FilmWeeklyImporter";
	
	// private class variables
	private static final String[] APP_HEADER = {APP_NAME + " - " + APP_VERSION, APP_COPYRIGHT, APP_LICENSE, APP_MORE_INFO};
	
	private static final String[] REQD_PROPERTIES = {"db-host", "db-name", "db-user", "db-password"};
	
	private static Logger logger = Logger.getLogger(FwImporter.class.getName());

	/**
	 * Main method for the class
	 * 
	 * @param args array of command line arguments
	 */
	public static void main(String[] args) {
		
		// before we do anything, output some useful information
		for(int i = 0; i < APP_HEADER.length; i++) {
			System.out.println(APP_HEADER[i]);
		}
		
		// parse the command line options
		CommandLineParser parser = new PosixParser();
		CommandLine cmd = null;
		
		try {
			cmd = parser.parse(createOptions(), args);
		}catch(org.apache.commons.cli.ParseException e) {
			// something bad happened so output help message
			printCliHelp("Error in parsing options:\n" + e.getMessage());
		}
		
		// get and check on the log4j properties path option if required
		if(cmd.hasOption("log4j") == true) {
			String log4jPath = cmd.getOptionValue("log4j");
			if(FileUtils.isAccessible(log4jPath) == false) {
				printCliHelp("Unable to access the specified log4j properties file\n   " + log4jPath);
			}
			
			// configure the log4j framework
			PropertyConfigurator.configure(log4jPath);
		}
		
		// get and check on the properties path option
		String propertiesPath = cmd.getOptionValue("properties");
		if(FileUtils.isAccessible(propertiesPath) == false) {
			printCliHelp("Unable to access the specified properties file\n   " + propertiesPath);
		}
		
		// get and check on the input file path option
		String inputPath = cmd.getOptionValue("input");
		if(FileUtils.isAccessible(inputPath) == false) {
			printCliHelp("Unable to access the specified input file");
		}
		
		// open the properties file
		Configuration config = null;
		try {
			config = new PropertiesConfiguration(propertiesPath);
		} catch (ConfigurationException e) {
			printCliHelp("Unable to read the properties file file: \n" + e.getMessage());
		}
		
		// check to make sure all of the required configuration properties are present
		for(int i = 0; i < REQD_PROPERTIES.length; i++ ) {
			if(config.containsKey(REQD_PROPERTIES[i]) == false) {
				printCliHelp("Unable to find the required property: " + REQD_PROPERTIES[i]);
			}
		}
		
		if(cmd.hasOption("debug_coord_list") == true) {
			
			// output debug info
			logger.debug("undertaking the debug-coord-list task");
			
			// undertake the debug coordinate list task
			if(FileUtils.doesFileExist(cmd.getOptionValue("debug_coord_list")) == true) {
				printCliHelp("the debug_coord_list file already exists");
			} else {
				CoordList list = new CoordList(inputPath, cmd.getOptionValue("debug_coord_list"));
				
				try {
					list.openFiles();
					list.doTask();
				} catch (IOException e) {
					logger.error("unable to undertake the debug-coord-list task", e);
					errorExit();
				}
				
				System.out.println("Task completed");
				System.exit(0);
			}
		}
		
		if(cmd.hasOption("debug_json_list") == true) {
			
			// output debug info
			logger.debug("undertaking the debug-json-list task");
			
			// undertake the debug coordinate list task
			if(FileUtils.doesFileExist(cmd.getOptionValue("debug_json_list")) == true) {
				printCliHelp("the debug_json_list file already exists");
			} else {
				JsonList list = new JsonList(inputPath, cmd.getOptionValue("debug_json_list"));
				
				try {
					list.openFiles();
					list.doTask();
				} catch (IOException e) {
					logger.error("unable to undertake the debug_json_list task", e);
					errorExit();
				}
				
				System.out.println("Task completed");
				System.exit(0);
			}
		}
		
		// if no debug options present assume import
		System.out.println("Importing data into the database.");
		System.out.println("*Note* if this input file has been processed before duplicate records *will* be created.");
		
		// get a connection to the database
		try {
			Class.forName("com.mysql.jdbc.Driver").newInstance();
		} catch (Exception e) {
			logger.error("unable to load the MySQL database classes", e);
			errorExit();
		}
		
		Connection database = null;
		
		//private static final String[] REQD_PROPERTIES = {"db-host", "db-user", "db-password", "db-name"};
		
		String connectionString = "jdbc:mysql://" + config.getString(REQD_PROPERTIES[0])
		                        + "/" + config.getString(REQD_PROPERTIES[1])
		                        + "?user=" + config.getString(REQD_PROPERTIES[2])
		                        + "&password=" + config.getString(REQD_PROPERTIES[3]);
		
		try {
			database = DriverManager.getConnection(connectionString);
		}catch (SQLException e) {
			logger.error("unable to connect to the MySQL database", e);
			errorExit();
		}
		
		// do the import
		DataImporter importer = new DataImporter(database, inputPath);
		
		try {
			importer.openFiles();
			importer.doTask();
			
			System.out.println("Task completed");
			System.exit(0);
		} catch (IOException e) {
			logger.error("unable to complete the import");
			errorExit();
		} catch (ImportException e) {
			logger.error("unable to complete the import");
			errorExit();
		} finally {
			// play nice and tidy up
			try {
				database.close();
			} catch (SQLException e) {
				logger.error("Unable to close the database connection: ", e);
			}
			
		}
	}
	
	/*
	 * private method to exit the app
	 */
	private static void errorExit() {
		System.out.println("Error: the task was aborted, see log for details");
		System.exit(-1);
	}
	
	/*
	 * private method to output the command line options help
	 */
	private static void printCliHelp(String message) {
		System.out.println("Error: " + message);
		HelpFormatter formatter = new HelpFormatter();
		formatter.printHelp("java -jar FwImporter.jar", createOptions());
		System.exit(-1);
	}

	/*
	 * private method to create the list of command line options
	 */
	private static Options createOptions() {

		Options options = new Options();

		OptionBuilder.withArgName("path");
		OptionBuilder.hasArg(true);
		OptionBuilder.withDescription("path to the properties file");
		OptionBuilder.isRequired(true);
		options.addOption(OptionBuilder.create("properties"));
		
		OptionBuilder.withArgName("path");
		OptionBuilder.hasArg(true);
		OptionBuilder.withDescription("optional path to the log4j properties file");
		OptionBuilder.isRequired(false);
		options.addOption(OptionBuilder.create("log4j"));
		
		OptionBuilder.withArgName("path");
		OptionBuilder.hasArg(true);
		OptionBuilder.withDescription("path to the input file");
		OptionBuilder.isRequired(true);
		options.addOption(OptionBuilder.create("input"));
		
		OptionBuilder.withArgName("path");
		OptionBuilder.hasArg(true);
		OptionBuilder.withDescription("path to the coordinate list file");
		OptionBuilder.isRequired(false);
		options.addOption(OptionBuilder.create("debug_coord_list"));
		
		OptionBuilder.withArgName("path");
		OptionBuilder.hasArg(true);
		OptionBuilder.withDescription("path to the json list file");
		OptionBuilder.isRequired(false);
		options.addOption(OptionBuilder.create("debug_json_list"));

		return options;
	}

}
