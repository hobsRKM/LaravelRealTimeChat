
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Fusion Mate</title>
    </head>

    <body bgcolor="#8d8e90">
        <table width="100%" border="0"  cellspacing="0" cellpadding="0" bgcolor="#fff">
            <tr>
                <td><table width="600" border="0" style='border: 1px solid #ccc' cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
                        <tr style="background-color:#2196f3" >
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="64"><img style='     margin-left: 7px;
                                                             margin-top: 6px;   border-radius: 25px;' height="50px" width="50px" src="https://fusionmate.com/fmlogont.png"/></td>
                                                             <td><h2 style="color:#fff">fusionmate</h2></td>
                                        <td width="393"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="46" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        </table></td>
                                                </tr>
                                                <tr>
                                                </tr>
                                            </table></td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="10%">&nbsp;</td>
                                        <td width="80%" align="left" valign="top"><font style="font-family: Georgia, 'Times New Roman', Times, serif; color:#010101; font-size:14px"><strong><em>Hi {{ucfirst($user->first_name)}},</em></strong></font><br /><br />
                                            <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; "> 

                                                We have received a password reset request.<br/>
                                                To reset your password click on RESET PASSWORD.<br/>
                                                This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
                                                <center><a style=' 
                                                           background-color: #38A2CC;
                                                           color: #ffffff;
                                                           text-decoration: none;
                                                           margin : 20px;
                                                           padding: 10px 20px 10px 20px;
                                                           display: inline-block;' href="{{ URL::to('password/reset', array($token))}}">RESET PASSWORD</a></center><br/>

                                                <br /><br />

                                            </font></td>
                                        <td width="10%">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align="right" valign="top"><table width="108" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                              <!--                    <td><img src="http://i.imgur.com/DYRnFew.png"  style="display:block" border="0" alt=""/></td>-->
                                                </tr>

                                            </table></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <!--<td><img src="images/PROMO-GREEN2_07.jpg" width="598" height="7" style="display:block" border="0" alt=""/></td>-->
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                                </table></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center"><font style="font-family:'Myriad Pro', Helvetica, Arial, sans-serif; color:#5e5e5e; font-size:12px">If you are not the intended recipient of this email, you must neither take any action based upon its contents, nor copy or show it to anyone.

                                    Please contact us if you believe you have received this email in error. <a href= "https://fusionmate.com" style="color:#010203; text-decoration:none"><br/><strong>support@fusionmate.com</strong></a></font></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table></td>
            </tr>
        </table>
    </body>
</html>
