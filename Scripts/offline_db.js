function test(){
	alert('inawork');
}

function initDatabase() {
	try {
		if(!window.openDatabase) {
			console.log('Databases are not supported in this browser.');
		} else {
		
			var shortName = 'HCMP_Database';
			var version = '1.0';
			var displayName = 'HCMP LocalDatabase';
			var maxSize = 1000000000;
			//  bytes
			HCMPDB = openDatabase(shortName, version, displayName, maxSize);
			createTables();
		}
	} catch(e) {

		if(e == 2) {
			// Version number mismatch.
			console.log("Invalid database version.");
		} else {
			console.log("Unknown error " + e + ".");
		}
		return;
	}
}
/**************************************************creating the tables ****************************************************/
function createTables() {
	HCMPDB.transaction(function(transaction) {
		transaction.executeSql("CREATE TABLE IF NOT EXISTS facility_issues (id int INTEGER NOT NULL PRIMARY KEY,facility_code TEXT,s11_No TEXT,kemsa_code TEXT,batch_no TEXT,expiry_date TEXT,qty_issued TEXT,balanceAsof TEXT,date_issued TEXT,issued_to TEXT,created_at TEXT,updated_at TEXT);", [], nullDataHandler, errorHandler);
	    transaction.executeSql("CREATE TABLE IF NOT EXISTS facility_stock (id INTEGER NOT NULL PRIMARY KEY,facility_code TEXT,kemsa_code TEXT,quantity TEXT ,balance TEXT,status TEXT,manufacture TEXT ,batch_no TEXT,expiry_date TEXT,stock_date TEXT);", [], nullDataHandler, errorHandler);
	});
}
function Populate(sql) {
	HCMPDB.transaction(function(transaction) {
		transaction.executeSql(sql, [], nullDataHandler, errorHandler);
	});
}

function executeStatement(sql) {

	HCMPDB.transaction(function(transaction) {
		transaction.executeSql(sql, [], nullDataHandler, errorHandler);
	});
}

function executeStatementArray(sql_array) {
	HCMPDB.transaction(function(transaction) {
		for(sql in sql_array) {

			transaction.executeSql(sql_array[sql]);
		}
	}, transactionCallback, transactionErrorCallback);
}

function transactionCallback(transaction) {
	console.log(transaction);
}

function transactionErrorCallback(transaction) {
	console.log(transaction);
}

function errorHandler(transaction, error) {
	if(error.code == 1) {
		// DB Table already exists
		console.log('DB Exist');
	} else {
		// Error is a human-readable string.
		console.log('Oops.  Error was ' + error.message + ' (Code ' + error.code + ')');
	}
	return false;
}

function nullDataHandler() {
	console.log("SQL Query Succeeded");
}

