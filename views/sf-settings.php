<?php if (!defined('APPLICATION')) exit();?>

<h1><?php echo Gdn::Translate('Statistics Footer'); ?></h1>




<?php
echo $this->Form->Open();
echo $this->Form->Errors();?>




<table class="AltRows">
    <thead>
        <tr>
            <th class="Alt"><?php echo Gdn::Translate('Description'); ?></th>
            <th><?php echo Gdn::Translate('Option'); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="Alt">
             <?php echo Gdn::Translate('Select Option'); ?>
            </td>
  
            <td>

                <?php
                $Options = array('vutc' => 'All (views, users, topics, posts)', 
                                   'vut' => 'views, users, topics',
                                   'vuc' => 'views, users, posts', 
                                   'vtc' => 'views, topics, posts',
                                   'vtu' => 'views, topics, users',
                                   'vt' => 'views, topics',  
                                   'vu' => 'views, users',
                                   'vc' => 'views, posts',
                                   'tc' => 'topics, posts',
                                   'tu' => 'topics, users',
                                   'up' => 'users, posts',
                                    'v' => 'views',
                                    'u' => 'users',
                                    't' => 'topics',
                                    't' => 'posts');
                $Fields = array('TextField' => 'Code', 'ValueField' => 'Code');
                echo $this->Form->DropDown('Plugins.StatisticsFooter.Show', $Options, $Fields);
                ?>

            </td>
          
        </tr>
      </tbody>     
       
</table>
<?php echo $this->Form->Close('Save');

