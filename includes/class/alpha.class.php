<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Alpha {

  function __construct() {
    global $db, $tVars, $info, $pages, $voice, $config, $user, $GET, $logged, $taskclass, $url, $success, $messenger, $errors, $warnings, $uclass;
    $this->db =& $db;
    $this->templateVariables =& $tVars;
    $this->config =& $config;
    $this->user =& $user;
    $this->GET =& $GET;
    $this->info =& $info;
    $this->taskclass =& $taskclass;
    $this->url =& $url;
    $this->voice =& $voice;
    $this->uclass =& $uclass;
    $this->success =& $success;
    $this->errors =& $errors;
    $this->warnings =& $warnings;
    $this->messenger =& $messenger;
    $this->logged =& $logged;
    $this->pages =& $pages;

  }

  function generate_captcha_box() {
    if (!$this->config['recaptcha_site_key'] || !$this->config['recaptcha_secret_key']) {
      return '<p>Cannot load captcha! Undefined Public or Private key in constants.php!!</p>';
    } else {
      return '
      <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                <div class="g-recaptcha text-center" data-sitekey="' . $this->config['recaptcha_site_key'] . '"></div>
         ';
    }
  }
  
  function verify_captcha_response() {
    if (isset($_POST['g-recaptcha-response'])) {
      $secret  = $this->config['recaptcha_secret_key'];
      $recaptcha = new \ReCaptcha\ReCaptcha($secret);
      
      $resp = $recaptcha->verify($_POST['g-recaptcha-response']);
        if ($resp->isSuccess()) {
          return true;
        } else {
           $errors = $resp->getErrorCodes();
        }
    }
    return false;
  }

  function sendEmail($data = array()) {
    $message = $this->buildEmail($data['message']);
    
    if ($this->config['smtp_host']) {
      $mail = new PHPMailer(true); 
      $mail->isSMTP(); // Set mailer to use SMTP
      $mail->Host       = $this->config['smtp_host']; // Specify main and backup SMTP servers
      $mail->SMTPAuth   = true; // Enable SMTP authentication
      $mail->Username   = $this->config['smtp_username']; // SMTP username
      $mail->Password   = $this->config['smtp_password']; // SMTP password
      $mail->SMTPSecure = $this->config['smtp_secure']; // Enable TLS encryption, `ssl` also accepted
      $mail->Port       = $this->config['smtp_port']; // TCP port to connect to

      $mail->setFrom($this->config['smtp_from'], $this->config['smtp_name']);
      foreach ($data['recipients'] as $rec)
        $mail->addAddress($rec); // Add a recipient

      //Attachments
      $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
      $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

      //Content
      $mail->isHTML(true); // Set email format to HTML
      $mail->Subject = $data['subject'];
      $mail->Body    = $message;
      $mail->AltBody = strip_tags($message);

      $mail->send();
    }

  }

  function buildEmail($msg) {
    $f = "font-family: 'Abel', proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif';";

    $content = '
      <table cellpadding="8" cellspacing="0" style="text-shadow: 0px 0px 10px rgba(0, 149, 255, 0.75);background:#000000;background-color:#000000;' . $f . 'color:rgb(199, 199, 199);padding:0;width:100%!important;margin:0;" border="0"><tbody><tr><td valign="top">
        <center>
          <table cellpadding="0" cellspacing="0" style="border-radius:4px;border:2px #81ADCF solid; border-bottom:0; border-top:0;background-color:rgba(0, 0, 0, 1); background:rgba(56, 57, 62, 0.47);background-color:rgba(56, 57, 62, 0.47);   box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.06), 0 3px 5px rgba(0,0,0,0.3);" border="0" align="center"><tbody>
            <tr><td width="500" style="text-shadow: 0px 0px 10px rgba(0, 149, 255, 0.75);color:rgb(199, 199, 199);padding:35px;white-space: normal;word-wrap: break-word;word-break: break-word;line-height:25px">' . $msg . '</td></tr>
            </tbody>
          </table>
          <br/><br/>
          <small style="color:#676767;">the secret republic of hackers</small>
          <br/><br/>
        </center>
      </td></tr></tbody></table><br/>';

    return str_replace("\n", '', $content);
  }

  function getEmailTemplate($template_shortcut, $whatToReplace = array(), $withWhatToReplace = array()) {
    $template            = $this->db->where('shortcut', $template_shortcut)->getOne('email_templates');
    $template['subject'] = str_replace($whatToReplace, $withWhatToReplace, $template['subject']);
    $template['message'] = str_replace($whatToReplace, $withWhatToReplace, $template['message']);
    return $template;
  }

  function addMessenger($message, $type = null) {
    if (isset($type))
      $this->messenger[] = array(
        'message' => $message,
        'type' => $type
      );
    else
      $this->messenger[] = array(
        'message' => $message
      );
  }
  function show_404() {

    $this->voice = '404';

    $this->templateVariables['show_404'] = true;

  }


  function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) //check ip from share internet
      {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) //to check ip is pass from proxy
      {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
    }

    return ($ip);
  }


  function curlURL($url) {
    // create curl resource
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    // set url
    curl_setopt($ch, CURLOPT_URL, $url);

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);

    // close curl resource to free up system resources
    curl_close($ch);

    return $output;
  }

  function curlPOST($url, $data) {
    $data_string = json_encode($data);
    $ch          = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string)
    ));
    return curl_exec($ch);
  }

  function redirect($url, $keepPostData = false) {

    global $myModals;
    /*echo <<<META
    <html><head><meta http-equiv='Refresh' content='0;URL={$url}' /></head><body></body></html>
    META;*/

    if (count($this->errors))
      $_SESSION['error'] .= ($_SESSION['error'] != '' ? '<br/>' : '') . (is_array($this->errors) ? implode('<br/>', $this->errors) : $this->errors);

    if ($this->success)
      $_SESSION['success'] .= ($_SESSION['success'] != '' ? '<br/>' : '') . (is_array($this->success) ? implode('<br/>', $this->success) : $this->success);

    if ($this->info)
      $_SESSION['info'] .= ($_SESSION['info'] != '' ? '<br/>' : '') . (is_array($this->info) ? implode('<br/>', $this->info) : $this->info);

    if ($this->warnings)
      $_SESSION['warnings'] .= ($_SESSION['warnings'] != '' ? '<br/>' : '') . (is_array($this->warnings) ? implode('<br/>', $this->warnings) : $this->warnings);

    if ($this->voice)
      $_SESSION['voice'] = $this->voice;

    if ($myModals[0])
      $_SESSION['myModal'] = $myModals[0];

    if ($keepPostData && count($_POST)) {
      $_SESSION['post_data'] = $_POST;
    }

    // echo $this-
    //header_remove();

    header('Location: ' . $url);
    exit;
    /*            echo <<<SCRIPT
    <html><body><script>location='{$url}';</script></body></html>
    SCRIPT;*/
  }
  public function __clone() {
    exit;
  }

}
