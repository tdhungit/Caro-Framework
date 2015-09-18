<h3>REST API</h3>

<p>Create function in a model return a Array. Example Users model</p>
<pre>
    public function list_users() {
        return $this->find()->toArray();
    }
</pre>

<p>Edit controller: RestController.php</p>
<p>Register REST function by $register_api</p>
<pre>
    protected $register_api = array(
        '[model]/[function]' => '[method (get|post)]'
    );

    Example

    protected $register_api = array(
        'Users/list_users' => 'get'
    );
</pre>

<p>Go to: /api/[model]/[function]</p>
<p>Example:</p>
<pre>
    http://example.com/api/Users/list_users
</pre>
<p>Result:</p>
<pre>{"status":1,"data":[{"id":"1","created":"2015-09-05 06:11:31","user_created_id":"0","deleted":"0","username":"admin","email":"admin@gmail.com","password":"21232f297a57a5a743894a0e4a801fc3","name":"admin","status":"Active","avatar":"http:\/\/localhost\/youaddon\/Caro-Framework\/public\/uploads\/images\/2015\/09\/09\/nhung-nu-game-thu-moi-noi-tieng-trong-lang-game-viet.jpg"},{"id":"2","created":"2015-09-10 04:58:04","user_created_id":"0","deleted":"0","username":"jacky","email":"jacky@hocvui.tv","password":"e10adc3949ba59abbe56e057f20f883e","name":"Jacky","status":"Active","avatar":"http:\/\/localhost\/youaddon\/Caro-Framework\/public\/uploads\/images\/2015\/09\/10\/nhung-nu-game-thu-moi-noi-tieng-trong-lang-game-viet.jpg"}]}</pre>