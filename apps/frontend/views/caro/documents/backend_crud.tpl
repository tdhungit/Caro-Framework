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
    http://example.com/admin/list : list
    http://example.com/admin/edit : create
    http://example.com/admin/edit/1 : edit item id=1
    http://example.com/admin/delete/1 : delete item id=1
</pre>