<h3>Welcome!</h3>
<p>
    Welcome to Caro framework.<br>
    Our mission is to give you an advanced tool for developing the faster web sites and applications with PHP.
</p>

<h3>What is Caro Framework?</h3>
<p>
    Caro Framework base on <a href="http://phalconphp.com">PhalconPHP</a><br>
    Caro Framework is an open source, full stack framework for PHP written as a C-extension, optimized for high performance.<br>
    You don’t need to learn or use the C language, since the functionality is exposed as PHP classes ready for you to use.<br>
    Caro Framework also is loosely coupled, allowing you to use its objects as glue components based on the needs of your application.<br>
    Caro Framework is not only about performance, our goal is to make it robust, rich in features and easy to use!
</p>

<h3 id="table-of-contents">Table of Contents</h3>
<ul>
    <li>Installation</li>
    <ul>
        <li><a href="https://docs.phalconphp.com/en/latest/reference/install.html" target="_blank">Install PhalconPHP extension</a></li>
        <li><a href="http://carophp.com">Download Caro Framework</a></li>
        <li><a href="">Getting started</a></li>
    </ul>
</ul>

<h3 id="getting-started">Getting started</h3>
<p>Go to source website. Example http://localhost/carofw/install</p>
<p>Fill all information</p>
<pre><img src="{{ static_url() }}/themes/caro/images/documents/install.jpg" width="100%" /></pre>
<p> </p>
<p>Now you can login to admin page</p>
<p>Go to settings, click repair</p>

<h3 id="caro-structure">Caro Framework structure</h3>
<pre><img src="{{ static_url() }}/themes/caro/images/documents/structure.jpg" /></pre>
<p> </p>
<ul>
    <li>
        apps: application core
        <ul>
            <li>backend: admin module with MVC model</li>
            <li>frontend: frontend module with MVC model</li>
            <li>cache: file cache</li>
            <li>
                common: core file
                <ul>
                    <li>core: libraries core</li>
                    <li>layouts: layouts</li>
                </ul>
            </li>
            <li>config: file config: application, database, const</li>
        </ul>
    </li>
    <li>
        public
        <ul>
            <li>themes</li>
            <li>index.php: bootstrap</li>
        </ul>
    </li>
</ul>

<h3 id="config-app">Application config</h3>
<p>Go to apps/config/config.ini. Edit "baseUrl"</p>

<h3 id="generate-database">Generate Database</h3>
<p>Go to apps/config/database_structures.php</p>
<p>Go to admin settings --> repair</p>

<h3 id="backend-module">Backend Module</h3>
<p>Create table database in apps/config/database_structures.php. Example table name: example</p>
<p>Create model: models/Example.php</p>
<pre>
namespace Modules\Backend\Models;

class Example extends ModelBase
{
    public $id; // default
    public $created; // default
    public $user_created_id; // default
    public $deleted; // default
    ... // var like column in database table example

    // config list view
    public $list_view = array(
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => 'Name',
                'link' => true
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'Description'
            )
        )
    );

    // config detail view
    public $edit_view = array(
        'title' => 'name',
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => 'Name',
                'required' => true
            ),
            'description' => array(
                'type' => 'textarea',
                'label' => 'Description',
                'required' => true
            ),
        )
    );

    // config edit view
    public $detail_view = array(
        'title' => 'name',
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => 'Name'
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'Description'
            ),
        ),
        'subpanels' => array(
            'user_groups' => array(
                'type' => 'one-many',
                'current_model' => 'AuthRoles',
                'current_field' => 'id',
                'rel_model' => 'UserGroups',
                'rel_field' => 'role_id',
                'list' => array(
                    'name' => array(
                        'type' => 'text',
                        'label' => 'Name',
                    ),
                    'status' => array(
                        'type' => 'select',
                        'label' => 'Status'
                    ),
                )
            )
        )
    );
}
</pre>

<p>Create controller: controllers/exampleController.php</p>
<pre>
namespace Modules\Backend\Controllers;

class ExampleController extends ControllerBase
{
    protected $model_name = 'Example'; // model relate

}
</pre>

<p>We will have list/detail/edit page</p>
<pre>

</pre>

<h3 id="field-type">Field type</h3>
<ul>
    <li>
        text
        <pre>
            'example_field' => array (
                'type' => 'text',
                'label' => 'Name'
            )
        </pre>
    </li>
    <li>
        select
        <pre>
            'example_field' => array (
                'type' => 'select',
                'label' => 'Name',
                'options' => 'example_option'
            )
        </pre>
        example_option define in apps/config/const.php
        <pre>
            return array(
                'app_list_strings' => array(
                    'example_option' => array(
                        'Active' => 'Active',
                        'Inactive' => 'Inactive'
                    )
                ),
            );
        </pre>
    </li>
    <li>
        textarea
        <pre>
            'description' => array(
                'type' => 'textarea',
                'label' => 'Description'
            )
        </pre>
    </li>
    <li>
        relate
    </li>
    <li>
        image
        <pre>
            'avatar' => array(
                'type' => 'image',
                'label' => 'Avatar'
            )
        </pre>
    </li>
</ul>

<h3 id="subpanel-relation">Subpanel Relation</h3>