
Partial Class FormBased_ExampleForm
    Inherits System.Web.UI.Page

    ' This is Form Based Example Program...

    ' Event to transfer page control to FormSubmit.aspx
    Sub dosubmit(ByVal sender As Object, ByVal e As EventArgs)
        ' Store Each ASP:TextBox Text into Context items
        Context.Items("AS1") = AS1.Text
        Context.Items("EU") = EU.Text
        Context.Items("AF") = AF.Text
        Context.Items("NA") = NA.Text
        Context.Items("SA") = SA.Text
        Context.Items("CA") = CA.Text
        Context.Items("OC") = OC.Text
        Context.Items("ME1") = ME1.Text
        ' Submit form 
        Server.Transfer("FormSubmit.aspx")
    End Sub



End Class
