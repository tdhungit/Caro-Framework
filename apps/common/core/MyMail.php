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
    protected $_transport;
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