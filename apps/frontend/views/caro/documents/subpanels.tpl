<h3 id="subpanel-relation">Subpanel Relation</h3>

<p>Edit $detail_view in Model</p>

<p>Example: Users Model</p>

<pre>
    public $detail_view = array(
        'title' => 'name',
        'fields' => array(
            'avatar' => array(
                'type' => 'image',
                'label' => 'Avatar'
            ),
            'username' => array(
                'type' => 'text',
                'label' => 'Username'
            ),
            'email' => array(
                'type' => 'text',
                'label' => 'Email'
            ),
            'name' => array(
                'type' => 'text',
                'label' => 'Full name'
            )
        ),
        'subpanels' => array(
            'user_groups' => array(
                'type' => 'many-many',
                'current_model' => 'Users',
                'current_field' => 'id',
                'rel_model' => 'UserGroups',
                'rel_field' => 'id',
                'mid_model' => 'UserGroupsUsers',
                'mid_field1' => 'user_id',
                'mid_field2' => 'group_id',
                'list' => array(
                    'name' => array(
                        'type' => 'text',
                        'label' => 'Name',
                    ),
                    'status' => array(
                        'type' => 'select',
                        'label' => 'Status'
                    ),
                ),
                'buttons' => true
            )
        )
    );
</pre>

<p>Render View</p>
<pre><img src="{{ static_url() }}/themes/caro/images/documents/view_relate.jpg" width="100%" /></pre>

<p>Add Relate</p>
<pre><img src="{{ static_url() }}/themes/caro/images/documents/add_relate.jpg" width="100%" /></pre>