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

package au.edu.flinders.ehl.filmweekly.debug;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;

import org.apache.log4j.Logger;

import au.com.bytecode.opencsv.CSVReader;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.techxplorer.java.utils.FileUtils;
import com.techxplorer.java.utils.InputUtils;

/**
 * A class used during development / debugging 
 * 
 * outputs to a file a list of basic JSON objects
 */
public class JsonList {
	
	//declare class level variables
	private static Logger logger = Logger.getLogger(JsonList.class.getName());
	
	private String inputPath;
	private String outputPath;
	
	private BufferedReader inputFile;
	private PrintWriter    outputFile;
	
	/**
	 * Constructor for the class
	 * 
	 * @param inputPath the path to the input file
	 * @param outputPath the path to the output file
	 * 
	 * @throws RuntimeException if the paths do not pass validation
	 * @throws IllegalArgumentException if both parameters are not valid strings
	 */
	public JsonList(String inputPath, String outputPath) {
		
		if(InputUtils.isEmpty(inputPath) == true) {
			throw new IllegalArgumentException("the inputPath parameter is required");
		}
		
		if(InputUtils.isEmpty(outputPath) == true) {
			throw new IllegalArgumentException("the outputPath parameter is required");
		}
		
		// check on the paths
		if(FileUtils.isAccessible(inputPath) == false) {
			throw new RuntimeException("the input path is not accessible");
		}
		
		if(FileUtils.doesFileExist(outputPath) == true) {
			throw new RuntimeException("the file at the output path already exists");
		}
		
		this.inputPath = inputPath;
		this.outputPath = outputPath;
		
	}
	
	/**
	 * opens the input file for reading and the output file for writing
	 * 
	 * @throws IOException if either operation fails
	 */
	public void openFiles() throws IOException {
		
		logger.debug("opening input file for reading");
		
		try{
			inputFile = FileUtils.openFileForReading(inputPath);
		} catch (IOException e) {
			logger.error("Unable to open the input file", e);
			throw new IOException("Unable to open the input file", e);
		}
		
		logger.debug("opening output file for writing");
		
		try {
			outputFile = FileUtils.openNewFileForWriting(outputPath);
		} catch (IOException e) {
			logger.error("Unable to open the output file", e);
			throw new IOException("Unable to open the output file", e);
		}
	}
	
	/**
	 * undertake the task of creating a unique list basic JSON objects
	 * 
	 * @throws IOException if either a read or write operation fails
	 */
	public void doTask() throws IOException{
		
		logger.debug("undertaking the task");
		
		// create the CSVReader objects
		CSVReader reader = new CSVReader(inputFile, ',', '"', 1);
		
		//declare other helper variables
		String[] dataElems;
		String coordinate;
		ArrayList<String> coordList = new ArrayList<String>();
		
		ArrayList<Marker> markerList = new ArrayList<Marker>();
		Marker marker;
		
		// loop through the file processing each line
		try {
			
			while((dataElems = reader.readNext()) != null) {
				
				coordinate = dataElems[3] + "," + dataElems[4];
				
				if(coordList.contains(coordinate) == false) {
					
					marker = new Marker(Double.parseDouble(dataElems[3]), Double.parseDouble(dataElems[4]), dataElems[2].trim(), dataElems[1].trim());
					markerList.add(marker);
					
					coordList.add(coordinate);
				}
				
			}
		} catch (IOException e) {
			logger.error("Unable to read from the input file", e);
			throw new IOException("Unable to read from the input file", e);
		}
		
		// close the file
		reader.close();
		
		// build a JSON representation of the data and output it to the file
		Gson gson = new GsonBuilder().setPrettyPrinting().create();
		outputFile.println(gson.toJson(markerList));
		
		// close the output file
		outputFile.close();
		
		logger.debug("task completed");
	}
	
	// a private class to store details of a marker
	@SuppressWarnings("unused")
	private class Marker {
		
		private double latitude;
		private double longitude;
		private String type;
		private String locality;
		
		public Marker(double latitude, double longitude, String type, String locality) {
			this.latitude = latitude;
			this.longitude = longitude;
			this.type = type;
			this.locality = locality;
		}
	}
}