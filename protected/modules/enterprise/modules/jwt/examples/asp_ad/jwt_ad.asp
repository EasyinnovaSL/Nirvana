<!--#include file=".\lib\jwt.asp" -->
<%
    Dim sKey, sHumHubDomain, sHumHubUrlRewriting, sLdapReaderUsername, sLdapReaderPassword, sLoginErrorMessage, dM
    Dim dAttributes, sParameter, sRedirectUrl, sExternalIdField, sOrganizationField, sTagsField, sPhotoUrlField

    ' --------------------------------------------------------------------------------------------------------
    ' Please see README.md for more details.
    ' --------------------------------------------------------------------------------------------------------
    ' Begin of configuration
    ' --------------------------------------------------------------------------------------------------------

    ' Set your shared secret and Humhub Domain domain
    sKey       			= ""
    sHumHubDomain 		= "http://intranet.example.com"
    sHumHubUrlRewriting         = true

    ' Add a valid user/password for the LDAP lookups by setting the variables sLdapReaderUsername
    ' and sLdapReaderPassword below.
    sLdapReaderUsername = ""
    sLdapReaderPassword = ""

    ' The below 4 fields can optionally be sent to HumHub. In order to do so, set each variable to the field
    ' name on the local user record. E.g. sExternalIdField = "sAMAccountName" and so forth.
    sExternalIdField    = ""
    sOrganizationField  = ""
    sTagsField          = ""
    sPhotoUrlField      = ""

    ' Debug Mode Switch
    ' Set this to True to turn on Debug Mode. Set it to False to use in production.
    dM = False

    ' --------------------------------------------------------------------------------------------------------
    ' End of configuration
    ' --------------------------------------------------------------------------------------------------------

    Set dAttributes = GetAuthenticatedUser()

    If dAttributes Is Nothing Then
      Response.Write("Could not login to HumHub. Please contact your administrator.")
      Debug "Account '" & Request.ServerVariables("LOGON_USER") & "' not found."
    ElseIf dAttributes("email") = "" Then
      Response.write("Could not login to HumHub. Please contact your administrator.")
      Debug "User '" & Request.ServerVariables("LOGON_USER") & "' has no email."
    Else
      sParameter   = JWTTokenForUser(dAttributes)
      If (sHumHubUrlRewriting) Then
	      sRedirectUrl = sHumHubDomain & "/user/auth/external?authclient=jwt&jwt=" & sParameter
	  Else
	      sRedirectUrl = sHumHubDomain & "index.php?r=/user/auth/external&authclient=jwt&jwt=" & sParameter
	  End If
      If dM Then
        Debug "Redirecting to " & sRedirectUrl
      Else
        Response.redirect sRedirectUrl
      End If
    End If
%>

<%
Function JWTTokenForUser(dAttributes)
  dAttributes.Add "jti", UniqueString
  dAttributes.Add "iat", SecsSinceEpoch

  If Not isempty(Request.QueryString("return_to")) Then
    dAttributes.Add "return_to", Request.QueryString("return_to")
  End If

  Dim i, aKeys
  aKeys = dAttributes.keys

  For i = 0 To dAttributes.Count-1
    Debug("Attribute " & aKeys(i) & ": " & dAttributes(aKeys(i)))
  Next

  JWTTokenForUser = JWTEncode(dAttributes, sKey)
End Function

Function Debug(sMessage)
  If dM Then
    response.Write("[DEBUG] " & sMessage & "<br/>")
  End If
End Function

Function GetAuthenticatedUser()
  Dim sDomainContainer, sUsername, sFields

  ' Retrieve authenticated user
  sUsername = ""
  if (Request.ServerVariables("LOGON_USER") <> "") Then
	sUsername = split(Request.ServerVariables("LOGON_USER"),"\")(1)
  End If
  Debug Request.ServerVariables("LOGON_USER") & " - should be of the form DOMAIN\username - if blank, your IIS probably allows anonymous access to this file."

  Set rootDSE = GetObject("LDAP://RootDSE")
  Set oConn   = CreateObject("ADODB.Connection")

  sDomainContainer = rootDSE.Get("defaultNamingContext")
  Debug "DomainContainer: " & sDomainContainer

  oConn.Provider = "ADSDSOObject"
  oConn.properties("user id")  = sLdapReaderUsername
  oConn.properties("password") = sLdapReaderPassword
  oConn.Open "ADs Provider"

  sFields = "mail,displayName"

  If sExternalIdField > "" Then
    sFields = sFields & "," & sExternalIdField
  End If

  If sOrganizationField > "" Then
    sFields = sFields & "," & sOrganizationField
  End If

  If sTagsField > "" Then
    sFields = sFields & "," & sTagsField
  End If

  If sPhotoUrlField > "" Then
    sFields = sFields & "," & sPhotoUrlField
  End If

  sQuery  = "<LDAP://" & sDomainContainer & ">;(sAMAccountName=" & sUsername & ");adspath," & sFields & ";subtree"
  Set userRS = oConn.Execute(sQuery)

  If Not userRS.EOF and not err then
    Set dAttributes = Server.CreateObject("Scripting.Dictionary")

    dAttributes.Add "name", userRS("displayName").Value
    dAttributes.Add "email", userRS("mail").Value

    If sExternalIdField > "" Then
      dAttributes.Add "external_id", userRS(sExternalIdField).Value
    End If

    If sOrganizationField > "" Then
      dAttributes.Add "organization", userRS(sOrganizationField).Value
    End If

    If sTagsField > "" Then
      dAttributes.Add "tags", userRS(sTagsField).Value
    End If

    If sPhotoUrlField > "" Then
      dAttributes.Add "remote_photo_url", userRS(sPhotoUrlField).Value
    End If

    Set GetAuthenticatedUser = dAttributes
  else
    Set GetAuthenticatedUser = Nothing
  end if

  userRS.Close
  oConn.Close
End Function
%>
