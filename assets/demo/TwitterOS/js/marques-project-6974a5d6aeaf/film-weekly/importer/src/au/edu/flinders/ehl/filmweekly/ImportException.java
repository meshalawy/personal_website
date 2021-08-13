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

/**
 * basic exception class to represent an exception occurring during an import task
 *
 */
public class ImportException extends Exception {

	private static final long serialVersionUID = -7303652044847751112L;
	
	public ImportException() {
		super();
	}

	public ImportException(String arg0) {
		super(arg0);
	}

	public ImportException(Throwable arg0) {
		super(arg0);
	}

	public ImportException(String arg0, Throwable arg1) {
		super(arg0, arg1);
	}

}
