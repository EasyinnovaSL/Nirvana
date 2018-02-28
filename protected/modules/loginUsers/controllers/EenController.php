<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\loginUsers\controllers;

use humhub\modules\loginUsers\models\ExtraDataUser;
use humhub\modules\user\models\forms\EenValidateForm;
use Yii;
use yii\web\HttpException;
use humhub\components\Controller;
use humhub\modules\user\models\User;
use humhub\modules\user\models\Password;
use humhub\modules\user\models\forms\AccountRecoverPassword;
use humhub\modules\user\models\Auth;
use humhub\modules\user\models\GroupUser;

/**
 * Password Recovery
 *
 * @since 1.1
 */
class EenController extends Controller
{

    /**
     * @inheritdoc
     */
    public $layout = "@humhub/modules/user/views/layouts/main";

    /**
     * @inheritdoc
     */
    public $subLayout = "_layout";

    public $loginSuccessful = 1;
    public $loginUnSuccessful = -1;
    public $registrationUnSuccessful = -1;
    public $registrationUnSuccessfulEmail = -2;
    public $registrationSuccessful = 1;
    public $registrationError = -2;

    /**
     * Open Een Modal
     */
    public function actionOpenEenForm(){

        /* Check if the user is logged in */
        if (!Yii::$app->user->isGuest) {

            /* Check if the user is a innovation advisor */
            $statsTopGroup = GroupUser::find()->where(['user_id' => Yii::$app->user->id, 'group_id' => INNOVATION_ADVISOR_GROUP_ID])->one();

            if(isset($statsTopGroup) && count($statsTopGroup->getAttributes()) > 0){
                $model = new EenValidateForm();
                return $this->render('eenModalForm', ['model' => $model]);
            }
        }
    }

    /**
     * Open Easypp Modal
     */
    public function actionOpenEasyppForm(){

        /* Check if the user is logged in */
        if (!Yii::$app->user->isGuest) {

            /* Check if the user is a innovation advisor */
            $statsTopGroup = GroupUser::find()->where(['user_id' => Yii::$app->user->id, 'group_id' => INNOVATION_ADVISOR_GROUP_ID])->one();

            if(isset($statsTopGroup) && count($statsTopGroup->getAttributes()) > 0){
                $model = new EenValidateForm();
                return $this->render('easyppModalForm', ['model' => $model]);
            }
        }
    }

    public function saveExtraDataUserEEN($model){
        $user = ExtraDataUser::find()->where(['user_id' => Yii::$app->user->id, 'source_type_id' => 1])->one();
        $username = $model->emailEen;
        $password = $model->passwordEen;
        $key = $username;
        $iv = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
            MCRYPT_DEV_URANDOM
        );
        $encrypted = base64_encode(
            $iv .
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $key, true),
                $password,
                MCRYPT_MODE_CBC,
                $iv
            )
        );

        if ($user != null) {
            $user->dismissed = 2;
            $user->username = $username;
            $user->password = $encrypted;
            $user->update();
        } else {
            $user = new ExtraDataUser();
            $user->dismissed = 2;
            $user->username = $username;
            $user->password = $encrypted;
            $user->source_type_id = 1;
            $user->user_id = Yii::$app->user->id;
            $user->insert();
        }
    }

    public function saveExtraDataUserEasyPP($model){
        $user = ExtraDataUser::find()->where(['user_id' => Yii::$app->user->id, 'source_type_id' => 2])->one();
        $username = $model->emailEen;
        $password = $model->passwordEen;
        $key = $username;
        $iv = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
            MCRYPT_DEV_URANDOM
        );
        $encrypted = base64_encode(
            $iv .
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $key, true),
                $password,
                MCRYPT_MODE_CBC,
                $iv
            )
        );

        if ($user != null) {
            $user->dismissed = 2;
            $user->username = $username;
            $user->password = $encrypted;
            $user->update();
        } else {
            $user = new ExtraDataUser();
            $user->dismissed = 2;
            $user->username = $username;
            $user->password = $encrypted;
            $user->source_type_id = 2;
            $user->user_id = Yii::$app->user->id;
            $user->insert();
        }
    }

    /**
     * Connect to EEn And validate the Form
     */
    public function actionEenValidateForm()
    {
        //http://localhost/nirvana-web/index.php?r=user/een/een-validate-form
        $model = new EenValidateForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){

            /* We Try to Login To Een Page */
           $resultOnLoginToEen = $this->loginToEenPage($model);

            if($resultOnLoginToEen == $this->loginSuccessful){

                /* If the login was correct we can store it on database */
                $this->saveExtraDataUserEEN($model);
                return $this->render('eenSuccessForm', ['model' => $model, 'errorOnValidate' => false]);

            }else{
                /* If something is wrong, the user has to be redirected again */
                return $this->render('eenModalForm', ['model' => $model, 'errorOnValidate' => true]);
            }

        }else {
            /* If something is wrong, the user has to be redirected again */
            return $this->render('eenModalForm', ['model' => $model, 'errorOnValidate' => true]);
        }
    }

    public function actionEasyppInputForm()
    {
        $model = new EenValidateForm();
        return $this->render('easyppModalForm', ['model' => $model, 'errorOnValidate' => false]);
    }

    public function actionEasyppCreateAccount()
    {
        /* Try to log-in to EasyPP with the same credentials */
        $model = new EenValidateForm();
        $email = User::findOne(["id" => Yii::$app->user->id])->email;
        if($model->load(Yii::$app->request->post()) && $model->validate()){

            /* Try to create a new account to EasyPP using the same credentials as EEN */
            $resultOnRegisterToEasyPP = $this->registerToEasyPPPage($model,$email);
            if ($resultOnRegisterToEasyPP == $this->registrationSuccessful) {
                /* Account created correctly -> save credentials */
                $this->saveExtraDataUserEasyPP($model);
                return $this->render('easyppSuccessForm', ['model' => $model, 'errorOnValidate' => false]);
            } else if ($resultOnRegisterToEasyPP == $this->registrationUnSuccessful) {
                /* User already registered to EasyPP */
                return $this->render('easyppModalForm', ['model' => $model, 'errorRegistered' => 1]);
            } else if ($resultOnRegisterToEasyPP == $this->registrationUnSuccessfulEmail) {
                /* User already registered to EasyPP */
                return $this->render('easyppModalForm', ['model' => $model, 'errorRegistered' => 2]);
            } else if ($resultOnRegisterToEasyPP == $this->registrationError) {
                /* Error on registering user to EasyPP */
                return $this->render('easyppModalForm', ['model' => $model, 'errorRegistered' => 3]);
            }


        }else {
            /* If something is wrong, the user has to be redirected again */
            return $this->render('easyppModalForm', ['model' => $model, 'errorOnValidate' => true]);
        }
    }

    /**
     * Connect to EasyPP And validate the Form
     */
    public function actionEasyppValidateForm()
    {
        $model = new EenValidateForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){

            /* Try to log-in in EasyPP with the same credentials */
            $resultOnLoginToEasyPP = $this->loginToEasyPPPage($model);
            if ($resultOnLoginToEasyPP == $this->loginSuccessful) {
                /* If logged in, save credentials */
                $this->saveExtraDataUserEasyPP($model);
                return $this->render('easyppSuccessForm', ['model' => $model, 'errorOnValidate' => false]);
            } else {
                /* Error */
                return $this->render('easyppModalForm', ['model' => $model, 'errorOnValidate' => true]);
            }

        }else {
            /* If something is wrong, the user has to be redirected again */
            return $this->render('easyppModalForm', ['model' => $model, 'errorOnValidate' => true]);
        }
    }

    /**
     * Dismiss the EEn connection
     */
    public function actionEenDismissForm()
    {
        $user = ExtraDataUser::find()->where(['user_id' => Yii::$app->user->id, 'source_type_id' => 1])->one();
        if ($user == null) {
            $user = new ExtraDataUser();
            $user->dismissed = 2;
            $user->source_type_id = 1;
            $user->user_id = Yii::$app->user->id;
            $user->insert();
        } else {
            $user->dismissed = 1;
            $user->update();
        }
        $model = new EenValidateForm();
        return $this->render('eenDismissedForm', ['model' => $model, 'dismissed' => true]);
    }

    /**
     * Dismiss the EasyPP connection
     */
    public function actionEasyppDismissForm()
    {
        $user = ExtraDataUser::find()->where(['user_id' => Yii::$app->user->id, 'source_type_id' => 2])->one();
        if ($user == null) {
            $user = new ExtraDataUser();
            $user->dismissed = 2;
            $user->source_type_id = 2;
            $user->user_id = Yii::$app->user->id;
            $user->insert();
        } else {
            $user->dismissed = 1;
            $user->update();
        }
        $model = new EenValidateForm();
        return $this->render('easyppDismissedForm', ['model' => $model, 'dismissed' => true]);
    }

    /*
     * This Function calls the EasyPP API to create a new account
     */
    function registerToEasyPPPage($model,$email)
    {
        $urlToConnect = 'http://res.ivf.se:8080/api/registration';

        $fields = array(
            'UserID' => urlencode($model->emailEen),
            'Password' => urlencode($model->passwordEen),
            'Email' => $email,
            'FirstName' => "TestName",
            'LastName' => "TestName",
            'BBSId' => urlencode($model->emailEen),
            'BBSPwd' => urlencode($model->passwordEen),
        );
        $json = json_encode($fields);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json))
        );
        curl_setopt($curl, CURLOPT_URL, $urlToConnect);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result=$this->registrationSuccessful;

        $res = curl_exec($curl);

        if ($res && strpos($res, "UserID already taken")) {
            $result = $this->registrationUnSuccessful;
        } else if ($res && strpos($res, "Email already taken")) {
            $result = $this->registrationUnSuccessfulEmail;
        } else if(!$res || !strpos($res, '"Status":true')) {
            $result = $this->registrationError;
        } // else: everything ok!

        curl_close($curl);

        return $result;
    }

    /*
     * This Function tries to Login via POST to EEN web page
     */
    private function loginToEenPage($model){

        if(isset($model)){

            $urlToConnect = 'http://een.ec.europa.eu/tools/Account/LogOn';

            $fields = array(
                'UserName' => urlencode($model->emailEen),
                'Password' => urlencode($model->passwordEen),
            );

            //url-ify the data for the POST
            $fields_string = '';
            foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');

            /* Open The Connection */
            $curlResource = curl_init();

            /* set the url, number of POST vars, POST data */
            curl_setopt($curlResource,CURLOPT_URL, $urlToConnect);
            curl_setopt($curlResource,CURLOPT_POST, count($fields));
            curl_setopt($curlResource,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($curlResource, CURLOPT_RETURNTRANSFER, 1);
            //curl_setopt($curlResource, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


            $User_Agent = 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31';

            $request_headers = array();
            $request_headers[] = 'User-Agent: '. $User_Agent;
            $request_headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';

            curl_setopt($curlResource, CURLOPT_HTTPHEADER, $request_headers);
            //curl_setopt($curlResource, CURLOPT_USERAGENT, $User_Agent);


            curl_setopt($curlResource, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlResource, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curlResource, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curlResource, CURLOPT_COOKIESESSION, true);
            /* This is necessary for curl, to act as a browser and to follow the redirection*/
            curl_setopt($curlResource, CURLOPT_COOKIEJAR, 'cookie.txt');


            /* Execute post */
            $response = curl_exec($curlResource);
            $responseHeaders = curl_getinfo($curlResource);

            /* Check cURL error */
            $errorNumber = curl_errno($curlResource);
            $errorMessage = curl_error($curlResource);

            /* Close Connection */
            curl_close($curlResource);

            //echo $response;

            if ($errorNumber > 0) {
                return $this->loginUnSuccessful;
            }
            if (strncmp($responseHeaders['http_code'], '20', 2) !== 0) {
                return $this->loginUnSuccessful;
            }

            // return $this->processResponse($response, $this->determineContentTypeByHeaders($responseHeaders));

            /* Check if the user i login in the web page */
            $userHasLoggedIn = strpos($response, 'Logout');

            /*Login was unsuccessful. Please correct the errors and try again.*/
            /* If the account exists but we introduced a bad password */
            /*Either your username/password is incorrect or you need to contact your partner administrator.*/

            /* If the account don't exist on EEn database */
            /* Your account has not been found in the database */

            if(!$userHasLoggedIn){
                return $this->loginUnSuccessful;
            }else{
                return $this->loginSuccessful;
            }

        }else{
            return $this->loginUnSuccessful;
        }

    }

    /*
     * This Function tries to Login via POST to EasyPP web page
     */
    private function loginToEasyPPPage($model){

        if(isset($model)){

            $urlToConnect = 'http://res.ivf.se/easyPP/default.asp';

            $fields = array(
                'userId' => urlencode($model->emailEen),
                'password' => urlencode($model->passwordEen),
            );

            //url-ify the data for the POST
            $fields_string = '';
            foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');

            /* Open The Connection */
            $curlResource = curl_init();

            /* set the url, number of POST vars, POST data */
            curl_setopt($curlResource,CURLOPT_URL, $urlToConnect);
            curl_setopt($curlResource,CURLOPT_POST, count($fields));
            curl_setopt($curlResource,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($curlResource, CURLOPT_RETURNTRANSFER, 1);
            //curl_setopt($curlResource, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


            $User_Agent = 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31';

            $request_headers = array();
            $request_headers[] = 'User-Agent: '. $User_Agent;
            $request_headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';

            curl_setopt($curlResource, CURLOPT_HTTPHEADER, $request_headers);
            curl_setopt($curlResource, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlResource, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curlResource, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curlResource, CURLOPT_COOKIESESSION, true);
            /* This is necessary for curl, to act as a browser and to follow the redirection*/
            curl_setopt($curlResource, CURLOPT_COOKIEJAR, 'cookie.txt');


            /* Execute post */
            $response = curl_exec($curlResource);
            $responseHeaders = curl_getinfo($curlResource);

            /* Check cURL error */
            $errorNumber = curl_errno($curlResource);
            $errorMessage = curl_error($curlResource);

            /* Close Connection */
            curl_close($curlResource);

            if ($errorNumber > 0) {
                return $this->loginUnSuccessful;
            }
            if (strncmp($responseHeaders['http_code'], '20', 2) !== 0) {
                return $this->loginUnSuccessful;
            }

            /* Check if the user i login in the web page */
            $userHasLoggedIn = strpos($response, 'Log out');

            if(!$userHasLoggedIn){
                return $this->loginUnSuccessful;
            }else{
                return $this->loginSuccessful;
            }

        }else{
            return $this->loginUnSuccessful;
        }

    }

}

?>
