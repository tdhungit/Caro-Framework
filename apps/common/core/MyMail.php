<?php
/**
 * Created Jacky.
 * User: Jacky
 */

namespace Modules\Core;


use Phalcon\Mvc\User\Component;

require_once APP_PATH . 'apps/common/third_party/swiftmailer5/swift_required.php';

class MyMail extends Component
{
    /**
     * @var
     */
    protected $_transport;

    /**
     * @var
     */
    protected $mailSettings;

    /**
     * Settings
     * Structure:
     *  Array(
     *      'fromName' =>
     *      'fromEmail' =>
     *      'smtp' => array(
     *          'server' =>
     *          'port' =>
     *          'security' =>
     *          'username' =>
     *          'password' =>
     *      )
     * )
     *
     * @param $mailSettings
     */
    public function setMailSettings($mailSettings)
    {
        $this->mailSettings = json_decode(json_encode($mailSettings));
    }

    /**
     * @param $settingModel
     * @return array
     */
    public function getDefaultSettings($settingModel)
    {
        $setting = $settingModel::findFirst("name = 'mail_config'");

        if (!$setting) {
            return false;
        }

        $mail_config = json_decode($setting->value, true);
        return array(
            'fromName' => $mail_config['from_name'],
            'fromEmail' => $mail_config['from_email'],
            'smtp' => array(
                'server' => $mail_config['smtp_server'],
                'port' => $mail_config['smtp_port'],
                'security' => $mail_config['smtp_security'],
                'username' => $mail_config['smtp_username'],
                'password' => $mail_config['smtp_password'],
            )
        );

    }

    /**
     * @param $settingModel
     */
    public function setDefaultSettings($settingModel)
    {
        $mailSettings = $this->getDefaultSettings($settingModel);
        $this->setMailSettings($mailSettings);
    }

    /**
     * Send Mail
     *
     * @param $to
     * @param $subject
     * @param $body
     * @return mixed
     */
    public function send($to, $subject, $body)
    {
        //Settings
        $mailSettings = $this->mailSettings;
        $template = $body;

        // Create the message
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom(array(
                $mailSettings->fromEmail => $mailSettings->fromName
            ))
            ->setBody($template, 'text/html');

        if (!$this->_transport) {
            $this->_transport = \Swift_SmtpTransport::newInstance(
                $mailSettings->smtp->server,
                $mailSettings->smtp->port,
                $mailSettings->smtp->security
            )
                ->setUsername($mailSettings->smtp->username)
                ->setPassword($mailSettings->smtp->password);
        }

        // Create the Mailer using your created Transport
        $mailer = \Swift_Mailer::newInstance($this->_transport);
        return $mailer->send($message);
    }
}