using System;
using System.Data;
using System.Data.Odbc;
using System.Web;
using System.Configuration;

namespace DataConnection
{
    /// <summary>
    /// Summary description for DbHelper.
    /// </summary>
    public class DbConn
    {

        //  Create a database Connection. using here Access Database
        //  Return type object of OdbcConnection

        public OdbcConnection connection;
        public OdbcDataReader ReadData;
        public OdbcCommand aCommand;
        public OdbcDataAdapter DataAdapter;
        public DataSet DataSet;

        public DbConn()
        {

            string connectionName = "MSAccessConnection";

            // connectionName = "sqlServerConnection";

            string ConnectionString = ConfigurationManager.ConnectionStrings[connectionName].ConnectionString;
            try
            {
                connection = new OdbcConnection();
                connection.ConnectionString = ConnectionString;
                connection.Open();
            }
            catch (Exception e)
            {
                HttpContext.Current.Response.Write(e.Message.ToString());
            }
            DataSet = new DataSet();

        }

        public DbConn(string strQuery)
        {

            string connectionName = "MSAccessConnection";

            // connectionName = "sqlServerConnection";


            string ConnectionString = ConfigurationManager.ConnectionStrings[connectionName].ConnectionString;
            try
            {
                connection = new OdbcConnection();
                connection.ConnectionString = ConnectionString;
                connection.Open();
                GetReader(strQuery);
            }
            catch (Exception e)
            {
                HttpContext.Current.Response.Write(e.Message.ToString());
            }
        }


        // Create an instance dataReader
        // Return type object of OdbcDataReader
        public void GetReader(string strQuery)
        {
            //  Create a Command object
            aCommand = new OdbcCommand(strQuery, connection);
            // Create data reader object using strQuery string

            ReadData = aCommand.ExecuteReader(CommandBehavior.CloseConnection);


        }

        public void GetDataSet(string strQuery, string TableName)
        {
            //  Create a Command object
            aCommand = new OdbcCommand(strQuery, connection);
            // Create Data Adapter
            DataAdapter = new OdbcDataAdapter(aCommand);
            // Fill dataset with record

            DataAdapter.Fill(DataSet, TableName);
        }
    }
}