<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


#[AllowDynamicProperties]
class Alpha {

  /** @var Container */
  protected $container;

  function __construct(Container $container) {
    $this->container = $container;
  }

  // ---------------------------------------------------------------
  // Property-style accessors that read/write through the container
  // so existing call-sites like $this->db, $this->user, etc. keep
  // working without any changes in subclasses or modules.
  // ---------------------------------------------------------------

  public function &__get($name) {
    switch ($name) {
      case 'db':
        $val = $this->container->db();
        return $val;
      case 'config':
        $val = &$this->container->get('config');
        return $val;
      case 'user':
        $val = &$this->container->get('user');
        return $val;
      case 'templateVariables':
      case 'tVars':
        return $this->container->tVars;
      case 'GET':
        return $this->container->GET;
      case 'url':
        return $this->container->url;
      case 'voice':
        return $this->container->voice;
      case 'info':
        return $this->container->info;
      case 'success':
        return $this->container->success;
      case 'errors':
        return $this->container->errors;
      case 'warnings':
        return $this->container->warnings;
      case 'messenger':
        return $this->container->messenger;
      case 'logged':
        return $this->container->logged;
      case 'pages':
        return $this->container->pages;
      case 'uclass':
        return $this->container->uclass();
      case 'taskclass':
        return $this->container->taskclass();
      default:
        // Allow dynamic properties for subclass-specific data
        $null = null;
        return $null;
    }
  }

  public function __set($name, $value) {
    switch ($name) {
      case 'db':
        $this->container->set('db', $value);
        break;
      case 'config':
        $this->container->set('config', $value);
        break;
      case 'user':
        $this->container->set('user', $value);
        break;
      case 'templateVariables':
      case 'tVars':
        $this->container->tVars = $value;
        break;
      case 'GET':
        $this->container->GET = $value;
        break;
      case 'url':
        $this->container->url = $value;
        break;
      case 'voice':
        $this->container->voice = $value;
        break;
      case 'info':
        $this->container->info = $value;
        break;
      case 'success':
        $this->container->success = $value;
        break;
      case 'errors':
        $this->container->errors = $value;
        break;
      case 'warnings':
        $this->container->warnings = $value;
        break;
      case 'messenger':
        $this->container->messenger = $value;
        break;
      case 'logged':
        $this->container->logged = $value;
        break;
      case 'pages':
        $this->container->pages = $value;
        break;
      default:
        // Store subclass-specific dynamic properties in a local array
        $this->_dynamicProps[$name] = $value;
        break;
    }
  }

  public function __isset($name) {
    $mapped = ['db','config','user','templateVariables','tVars','GET','url',
               'voice','info','success','errors','warnings','messenger',
               'logged','pages','uclass','taskclass'];
    if (in_array($name, $mapped)) return true;
    return isset($this->_dynamicProps[$name]);
  }

  /** @var array Stores subclass-specific dynamic properties */
  protected $_dynamicProps = [];

  function generate_captcha_box() {
    $config = $this->container->config();
    if (!$config['recaptcha_site_key'] || !$config['recaptcha_secret_key']) {
      return '<p>Cannot load captcha! Undefined Public or Private key in constants.php!!</p>';
    } else {
      return '
      <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                <div class="g-recaptcha text-center" data-sitekey="' . $config['recaptcha_site_key'] . '"></div>
         ';
    }
  }

  function verify_captcha_response() {
    if (isset($_POST['g-recaptcha-response'])) {
      $config = $this->container->config();
      $secret  = $config['recaptcha_secret_key'];
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
    $config = $this->container->config();

    if ($config['smtp_host']) {
      $mail = new PHPMailer(true);
      $mail->isSMTP(); // Set mailer to use SMTP
      $mail->Host       = $config['smtp_host']; // Specify main and backup SMTP servers
      $mail->SMTPAuth   = true; // Enable SMTP authentication
      $mail->Username   = $config['smtp_username']; // SMTP username
      $mail->Password   = $config['smtp_password']; // SMTP password
      $mail->SMTPSecure = $config['smtp_secure']; // Enable TLS encryption, `ssl` also accepted
      $mail->Port       = $config['smtp_port']; // TCP port to connect to

      $mail->setFrom($config['smtp_from'], $config['smtp_name']);
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
    $template            = $this->container->db()->where('shortcut', $template_shortcut)->getOne('email_templates');
    $template['subject'] = str_replace($whatToReplace, $withWhatToReplace, $template['subject']);
    $template['message'] = str_replace($whatToReplace, $withWhatToReplace, $template['message']);
    return $template;
  }

  function addMessenger($message, $type = null) {
    if (isset($type))
      $this->container->messenger[] = array(
        'message' => $message,
        'type' => $type
      );
    else
      $this->container->messenger[] = array(
        'message' => $message
      );
  }
  function show_404() {

    $this->container->voice = '404';

    $this->container->tVars['show_404'] = true;

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

    if (count($this->container->errors))
      $_SESSION['error'] .= ($_SESSION['error'] != '' ? '<br/>' : '') . (is_array($this->container->errors) ? implode('<br/>', $this->container->errors) : $this->container->errors);

    if ($this->container->success)
      $_SESSION['success'] .= ($_SESSION['success'] != '' ? '<br/>' : '') . (is_array($this->container->success) ? implode('<br/>', $this->container->success) : $this->container->success);

    if ($this->container->info)
      $_SESSION['info'] .= ($_SESSION['info'] != '' ? '<br/>' : '') . (is_array($this->container->info) ? implode('<br/>', $this->container->info) : $this->container->info);

    if ($this->container->warnings)
      $_SESSION['warnings'] .= ($_SESSION['warnings'] != '' ? '<br/>' : '') . (is_array($this->container->warnings) ? implode('<br/>', $this->container->warnings) : $this->container->warnings);

    if ($this->container->voice)
      $_SESSION['voice'] = $this->container->voice;

    if ($this->container->myModals[0])
      $_SESSION['myModal'] = $this->container->myModals[0];

    if ($keepPostData && count($_POST)) {
      $_SESSION['post_data'] = $_POST;
    }

    header('Location: ' . $url);
    exit;
  }
  public function __clone() {
    exit;
  }

}
