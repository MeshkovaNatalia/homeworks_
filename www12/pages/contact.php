<?php
/**
 * Created by PhpStorm.
 * User: PHP
 * Date: 02.10.2017
 * Time: 19:14
 */

define('KEY', '6Lei1TIUAAAAAKLLF_9esLY1CyvbH34Nm0dRCnIL');
define('SECRET_KEY', '6Lei1TIUAAAAAJOX9E44uEhrjhe9uhpYBPPJJA_h');

$errorMessages = [];
$commentsFile = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'comments.dat';
// echo '$commentsFile: ' . $commentsFile . '<br>';

function antimat($str) {
    if (!empty($str)) {
        return str_replace(
                ['Test', 'more'],
                ['T*st', 'm*re'],
                $str);
    }
}

function listComments() {
    $aComments = getComments();
    $sCommHtml = '';
    if (!empty($aComments)) {
        foreach ($aComments as $co) {
            $aEml = explode('@', $co['umail']);
            $sCommHtml .= '<div class="comment-holder">' .
                    '<div>Added on <span class="comment-date">' . $co['added'] . '</span> by ' .
                        // '<a href="mailto:'. $co['umail'] . '">' . $co['uname'] . '</a>' .
                        // <script type="text/javascript">jep_link("example.com", "mailbox", "my email", true)</script>
                        '<script type="text/javascript">jep_link("' . $aEml[1] . '", "' . $aEml[0] . '", "' . $co['uname'] . '");</script>' .
                    '</div>'.
                    '<div class="message"> ' . antimat($co['umsg']) .' </div>' .
                '</div>';
        }
    } else {
        $sCommHtml = '<div>Add your first comment.</div>';
    }
    echo $sCommHtml;
}

function addComment($data) {
    global $commentsFile, $errorMessages;
    $data['added'] = date('Y-m-d H:i:s');
    $data['ip'] = $_SERVER['REMOTE_ADDR'];
    $data['uname'] = trim(strip_tags($data['uname']));
    $data['umsg'] = trim(htmlentities($data['umsg'], ENT_COMPAT | ENT_HTML5));
    if (isset($data['g-recaptcha-response'])) {
        unset($data['g-recaptcha-response']);
    }
    //
    $prevComments = getComments();
    $allComments = array_merge($prevComments, [$data]);
    $sComments = serialize($allComments);
    if (file_put_contents($commentsFile, $sComments) !== false) {

    } else {
        $errorMessages[] = 'Error: Can`t write to file: ' . $commentsFile . ' comments: ' . $sComments . '<br>';
    }
}

function getComments() {
    global $commentsFile;
    $aComments = [];
    if (file_exists($commentsFile)) {
        $sComments = file_get_contents($commentsFile);
        $aComments = unserialize($sComments);
    }
    return $aComments;
}

function dataValid($data) {
    // die(print_r($data));

    global $errorMessages;
    $validationResult = true;

    if (!isset($data['uname']) || empty($data['uname'])) {
        $validationResult = false;
        $errorMessages[] = 'Fill user name';
    }

    if (!isset($data['umail']) || empty($data['umail'])) {
        $validationResult = false;
        $errorMessages[] = 'Fill user email';
    } elseif (!filter_var($data['umail'], FILTER_VALIDATE_EMAIL)) {
        $validationResult = false;
        $errorMessages[] = 'Wrong email format';
    }

    if (!isset($data['umsg']) || empty($data['umsg'])) {
        $validationResult = false;
        $errorMessages[] = 'Fill the message text';
    }

    if (!isset($data['g-recaptcha-response']) || empty($data['g-recaptcha-response'])) {
        $validationResult = false;
        $errorMessages[] = 'Captcha text can`t be empty';
    } else {
        $reqData = http_build_query([
            'secret' => SECRET_KEY,
            'response' => $data['g-recaptcha-response'],
            // 'remoteip' => $_SERVER['REMOTE_ADDR'],
        ]);
        $context = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $reqData,
            ]
        ]);
        $checkCaptchaRes = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        // echo '$checkCaptchaRes: ' . var_export($checkCaptchaRes, 1) . '<br>';
        // exit;
        // '{ "success": true, "challenge_ts": "2017-03-28T17:48:12Z", "hostname": "localhost" }'
        $jsObj = json_decode($checkCaptchaRes);
        if (!empty($jsObj) && $jsObj->success) {
            // reCaptcha is OK
        } else {
            $validationResult = false;
            $errorMessages[] = 'Wrong reCaptcha code';
        }
    }

    return $validationResult;
}

function listErrors() {
    global $errorMessages;
    if (!empty($errorMessages)) {
        foreach ($errorMessages as $msg) {
            echo '<div class="error">' . $msg . '</div>';
        }
    }
}

if (!empty($_POST)) {
    if (dataValid($_POST)) {
        addComment($_POST);
    }
}

?>

<div>
    <?=listErrors()?>
</div>
<div>
    <form id="comment-form-1" action="" method="post">
        <div>
            <label for="uname">Name *:</label>
            <input type="text" name="uname" placeholder="Your Name" required>
        </div>
        <div>
            <label for="umail">Email *:</label>
            <input type="email" name="umail" placeholder="your@email.com" required>
        </div>
        <div>
            <label for="umsg">Message *:</label><br>
            <textarea cols="25" rows="8" name="umsg" required></textarea>
        </div>
        <div>
            <div class="g-recaptcha" data-sitekey="<?=KEY?>"></div>
        </div>
        <div>
            <input type="submit" value="Add new message">
        </div>
        <div>
            * - required field
        </div>
    </form>
</div>
<hr>
<div class="comments-holder">
    <?=listComments()?>
</div>

