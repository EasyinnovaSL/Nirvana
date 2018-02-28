<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\user\controllers;

use humhub\modules\user\models\forms\EenValidateForm;
use Yii;
use yii\web\HttpException;
use humhub\components\Controller;
use humhub\modules\user\models\User;
use humhub\modules\user\models\Password;
use humhub\modules\user\models\forms\AccountRecoverPassword;
use humhub\modules\user\models\Auth;

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


    /**
     * Connect to EEn And validate the Form
     */
    public function actionEenValidateForm()
    {
        //http://localhost/nirvana-web/index.php?r=user/een/een-validate-form
        $model = new EenValidateForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){

            /* Wee Try to Login To Een Page */
           $resultOnLoginToEen = $this->loginToEenPage($model);

            /* If the password is correct we can store it on database */

            /* Redirect to Previous Page who made the call */
            //return $this->redirect(Yii::$app->request->referrer);
            //return $this->render('eenForm', ['model' => $model]);

        }else {
            /* If something is wrong, the user has to be redirected again */
            return $this->render('eenForm', ['model' => $model]);
        }
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

            echo $response;

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

}

?>
