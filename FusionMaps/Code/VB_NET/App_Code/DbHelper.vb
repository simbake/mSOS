Imports Microsoft.VisualBasic
Imports System.Data
Imports System.Data.Odbc
Imports System.Web
Imports System.Configuration

Namespace DataConnection
    Public Class DbConn
        ' Create a database Connection. using here Access Database
        ' Return type object of OdbcConnection

        Public connection As OdbcConnection
        Public ReadData As OdbcDataReader
        Public aCommand As OdbcCommand
        Public DataAdapter As OdbcDataAdapter
        Public DataSet As DataSet

        Public Sub New()

            Dim connectionName As String = "MSAccessConnection"

            ' connectionName = "sqlServerConnection"

            Dim ConnectionString As String = ConfigurationManager.ConnectionStrings(connectionName).ConnectionString
            Try

                connection = New OdbcConnection()
                connection.ConnectionString = ConnectionString
                connection.Open()

            Catch e As Exception

                HttpContext.Current.Response.Write(e.Message.ToString())
            End Try
            DataSet = New DataSet()

        End Sub

        Public Sub New(ByVal strQuery As String)

            Dim connectionName As String = "MSAccessConnection"

            ' connectionName = "sqlServerConnection";


            Dim ConnectionString As String = ConfigurationManager.ConnectionStrings(connectionName).ConnectionString
            Try

                connection = New OdbcConnection()
                connection.ConnectionString = ConnectionString
                connection.Open()
                GetReader(strQuery)

            Catch e As Exception

                HttpContext.Current.Response.Write(e.Message.ToString())
            End Try
        End Sub


        ' Create an instance dataReader
        ' Return type object of OdbcDataReader
        Public Sub GetReader(ByVal strQuery As String)

            '  Create a Command object
            aCommand = New OdbcCommand(strQuery, connection)
            ' Create data reader object using strQuery string

            ReadData = aCommand.ExecuteReader(CommandBehavior.CloseConnection)

        End Sub

        Public Sub GetDataSet(ByVal strQuery As String, ByVal TableName As String)

            '  Create a Command object
            aCommand = New OdbcCommand(strQuery, connection)
            ' Create Data Adapter
            DataAdapter = New OdbcDataAdapter(aCommand)
            ' Fill dataset with record

            DataAdapter.Fill(DataSet, TableName)
        End Sub
    End Class
    
End Namespace
