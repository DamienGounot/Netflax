<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../PHPMailer/vendor/autoload.php';
include_once './log.php';

function sendActivationMail($user,$to,$hash,$domain,$from,$from_password,$time){
        
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.ionos.fr';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $from;                     //SMTP username
    $mail->Password   = $from_password;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
       
    //Recipients
    $mail->setFrom($from, "Netflax.fr");
    $mail->addAddress($to,$user);     //Add a recipient
    //$mail->addAddress($to);               //Name is optional
    //$mail->addReplyTo($from, 'Information');
    
    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Welcome to Netflax.fr !";
    
    $mail->Body    = "<!DOCTYPE html>
    <html xmlns=\"http://www.w3.org/1999/xhtml\">
      <head>
        <meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\">
        <meta content=\"width=device-width, initial-scale=1.0\" name=\"viewport\">
        <title>You're almost in! Action required before you can join Protein</title>
        <link rel=\"stylesheet\" media=\"screen\" href=\"https://assets1-production.mightynetworks.com/assets/mb_mailer_reset-4df69cebc59b306656c124f3ad93f086d0a31ac9cde7f689a5f8fc0ecc69dc0f.css\">
        <link rel=\"stylesheet\" media=\"screen\" href=\"https://assets1-production.mightynetworks.com/assets/mb_mailer_main-36fc2fa26fe4a4b817cbbd7cba62e29bf4779b6cc0c51c2c99241e6000dbadcc.css\">
        <link rel=\"stylesheet\" media=\"all\" href=\"https://cdn.mn.co/theme/mail_css/777777/aaaaaa/0a8998c6ebe1ee2d8841e89bc7c938adeabed7bdfe1a74965c512e059bab97b5_v5.css?utm_campaign=email_manual+invite&amp;utm_medium=email&amp;utm_source=transactional_emails\" class=\"theme-link theme-link-custom\">
        <style>
          table td {
            border-collapse: collapse;
          }
          @media only screen and (max-width: 480px) {
            a[href^=\"tel\"],
            a[href^=\"sms\"] {
              text-decoration: none;
              color: black;
              /* or whatever your want */
              pointer-events: none;
              cursor: default;
            }
            .mobile_link a[href^=\"tel\"],
            .mobile_link a[href^=\"sms\"] {
              text-decoration: default;
              color: orange !important;
              /* or whatever your want */
              pointer-events: auto;
              cursor: default;
            }
            #email-wrapper {
              max-width: 480px !important;
              width: 100% !important;
            }
            .gutter-padding {
              padding-left: 20px !important;
              padding-right: 20px !important;
            }
            .rsvp-buttons a {
              margin-bottom: 10px;
            }
          }
          @media only screen and (max-width: 320px) {
            #email-wrapper {
              max-width: 320px !important;
            }
            .gutter-padding {
              padding-left: 10px !important;
              padding-right: 10px !important;
            }
          }
        </style>
        <style>
          body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
          }
          .ExternalClass {
            width: 100%;
          }
          .ExternalClass {
            line-height: 100%;
          }
          img {
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
          }
          body .mighty-indicator-warning {
            display: none;
          }
          body .mighty-indicator-success {
            display: none;
          }
          body {
            background-color: #fff;
            color: #47505C;
          }
          body.communities-app {
            background-color: #F4F6FA;
          }
        </style>
      </head>
      <body id=\"email-body\" style=\"width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; color: #47505C; margin: 0; padding: 0;\" bgcolor=\"#fff\">
        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;'>
          <tr>
            <td id=\"email-background-container\" style='font-family: \"Avenir\,\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; width: 100% !important; color: #171E28; line-height: 100% !important; margin: 0; padding: 0; border: none;' bgcolor=\"#acaeb3\" valign=\"top\">
              <center id=\"email-background\" style=\"width: 100% !important; background-color: #acaeb3; color: #171E28; line-height: 100% !important; margin: 0; padding: 0;\">
                <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"email-wrapper\" style='width: 500px; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;'>
                  <tr>
                    <td id=\"email-content-container\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; position: relative; border: none;' bgcolor=\"#fff\" valign=\"top\">
                      <table align=\"center\" bgcolor=\"#FFFFFF\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"email-content\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; position: relative; border: none;'>
                        <tr>
                          <td class=\"margins\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; width: 40px; border: none;' valign=\"top\"></td>
                          <td style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;' valign=\"top\">
                            <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"email-content-header\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; margin-top: 20px; border-bottom-color: #777777; border: none;'>
                              <tr>
                                <td style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoj\"; border: none;' valign=\"middle\">
                                  <table align=\center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;'>
                                    <tr>
                                      <td class=\"center\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;' align=\"center\" valign=\"middle\">
                                          <img alt=\"Protein\" src=\"https://emotionsnumeriques.files.wordpress.com/2017/04/srjc9512.jpg?ixlib=rails-0.3.0&amp;fm=jpg&amp;q=100&amp;auto=format&amp;w=128&amp;h=128&amp;fit=crop&amp;crop=faces\" style=\"outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; position: static; top: -1px; left: -1px; width: 64px; height: 64px; -moz-border-radius: 64px; -webkit-border-radius: 64px; border-radius: 64px; z-index: 0; border: none;\">
                                        </a>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;' valign=\"middle\">
                                        <table class=\"header-title-whitespace\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; height: 10px; border: none;'></table>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;' valign=\"middle\">
                                        <div class=\"header-title center\" style=\"font-size: 18px; color: #171E28; line-height: 1.2;\" align=\"center\">
                                          Netflax.fr                                    </div>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;' valign=\"middle\">
                                  <table class=\"header-whitespace\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; height: 20px; border: none;'></table>
                                </td>
                              </tr>
                            </table>
                            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"email-content-body\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;'>
                              <tr>
                                <td style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;' valign=\"top\">
                                  <table class=\"body-top-whitespace\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; height: 30px; border: none;'></table>
                                </td>
                              </tr>
                              <tr>
                              <td style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;' valign=\"top\">
                                  <div class=\"email-invite-title-container\" style=\"margin: 32px 0;\">
                                    <div id=\"email-invite-title\" style=\"color: #171E28; font-size: 26px; line-height: 32px; font-weight: 400;\" align=\"center\">You're Almost In! 🎉</div>
                                  </div>
                                  <div id=\"email-invite-message-container\" style=\"max-width: 423px; min-width: 300px; font-weight: 400; margin: 0 auto;\">
                                    <div class=\"email-invite-message\" style=\"font-family: 'Avenir-Book'; font-weight: 300; line-height: 30px; font-size: 22px; margin-bottom: 40px; color: #1f2021;\" align=\"left\">
                                      Your account has been created, you have now to activate your account by pressing the button below.<br>
                                      <br>
                                      ------------------------<br>
                                      Username: ".$user."<br>
                                      Your account has been created at: ".$time."<br>
                                      ------------------------<br>
                                      <br>
                                      It will be not available after 10 minutes.<br>
                                      If you do not succed to activate it, please contact an administrator<br>
                                      <br>
                                      Regards, <br>
                                      Netflax.fr Team.</div>
                              <tr>
                                <td style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;' valign=\"top\">
                                  <div class=\"email-invite-join\" style=\"margin: 40px;\">
                                    <center>
                                      <table align=\"center\ border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"button-action-container\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; text-align: center; border: none;'>
                                        <tbody>
                                          <tr>
                                            <td style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;' valign=\"top\">
                                              <a class=\"mighty-btn-square-email-large mighty-btn-filled-secondary-email\" href=\"".$domain."System/verify.php?email=".$to."&hash=".$hash."\" title=\"Click Here to Join\" style=\"-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; display: inline-block; line-height: 1; cursor: pointer; text-align: center; text-decoration: none; font-weight: 500; white-space: nowrap; min-width: 100px; font-size: 18px; -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px; background-color: #aaaaaa; color: #fff; border-color: #aaaaaa; border-style: solid; border-width: 17px 25px;\">Click Here to Join</a>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </center>
                                  </div>
                                </td>
                              </tr>
                              </div>
                          </td>
                        </tr>
                        <tr>
                          <td style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; border: none;' valign=\"top\">
                            <table class=\"body-bottom-whitespace\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #171E28; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; height: 60px; border: none;'></table>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td class=\"margins\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; width: 40px; border: none;' valign=\"top\"></td>
                  </tr>
                </table>
                <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"email-footer\" style='width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #ABB0B9; font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; text-align: center; border: none;' bgcolor=\"#f3f3f3\">
                  <tr>
                    <td class=\"margins\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; width: 40px; border: none;' valign=\"top\"></td>
                    <td class=\"footer-content\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; padding-top: 20px; padding-bottom: 20px; border: none;' valign=\"top\">
                      <div class=\"pdiv small\" id=\"email-change-preferences\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; font-size: 12px; font-weight: 300; line-height: 1.5; margin: 0;'>
                      </div>
                    </td>
                    <td class=\"margins\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; width: 40px; border: none;' valign=\"top\"></td>
                  </tr>
                  <tr>
                    <td class=\"margins\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; width: 40px; border: none;' valign=\"top\"></td>
                    <td class=\"footer-content\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; padding-top: 20px; padding-bottom: 20px; border: none;' valign=\"top\">
                      <div class=\"app-store-footer\" style=\"padding-bottom: 40px;\">
    
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class=\"margins\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; width: 40px; border: none;' valign=\"top\"></td>
                    <td class=\"footer-content without-padding-top\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; padding-top: 0px; padding-bottom: 20px; border: none;' valign=\"top\">
                      <div class=\"pdiv small sent-by-mighty\" style='font-family: \"Avenir\",\"Segoe UI\",Helvetica,Arial,sans-serif,\"Apple Color Emoji\",\"Segoe UI Emoji\"; font-size: 12px; font-weight: 300; line-height: 1.5; margin: 0;'></div>
                        <br>
                      </div>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
        </center>
        </td>
        </tr>
        </table>
      </body>
    </html>";


    $mail->send();

}
?>