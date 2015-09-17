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
        <pre>
            'category_id' => array(
                'type' => 'relate',
                'label' => 'Category',
                'model' => 'Categories' // model name relate
            )
        </pre>
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