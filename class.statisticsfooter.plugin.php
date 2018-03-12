<?php if (!defined('APPLICATION')) exit();
//Original Plugin by @peregrine, Redistributed by VrijVlinder with Peregrine's permission.


class StatisticsFooterPlugin extends Gdn_Plugin {

  public function __construct() {

    }

    public function assetModel_styleCss_handler($sender) {
        $sender->addCssFile('sfooter.css', 'plugins/StatisticsFooter');
    }

  /*public function DiscussionsController_Render_Before($sender) {
        $sender->AddCssFile('/plugins/StatisticsFooter/design/sfooter.css');
    }
*/

  public function discussionsController_AfterRenderAsset_Handler($sender) {

   $AssetName = GetValueR('EventArguments.AssetName', $sender);

    if ($AssetName != "Content") return;
    $CurTime = time();
    $LastTime = Gdn::Get('TimeCheck',$LastTime );
    $SFVcount = Gdn::Get('ViewCount',$SFVcount );
    $SFUcount = Gdn::Get('UserCount',$SFUcount);
    $SFDcount = Gdn::Get('DiscussionCount',$SFDcount);
    $SFCcount = Gdn::Get('CommentCount',$SFCcount);

    // refresh counts every 60 seconds unless config is set
  //   e.g. $Configuration['Plugins']['StatisticsFooter']['Refresh'] = '90';

    $IncSec = c('Plugins.StatisticsFooter.Refresh', 60);

    if ($CurTime  > $LastTime) {
      $LastTime= time() + $IncSec ;
      Gdn::Set('TimeCheck',$LastTime);
      $SFVcount = $this->GetViewCount();
      Gdn::Set('ViewCount',$SFVcount);
      $SFUcount = $this->GetUserCount();
      Gdn::Set('UserCount',$SFUcount);
      $SFDcount = $this->GetDiscussionCount();
      Gdn::Set('DiscussionCount',$SFDcount);
      $SFCcount = $this->GetCommentCount();
      Gdn::Set('CommentCount',$SFCcount);
      }

    $SFPcount = $SFDcount + $SFCcount;


 $ShowMe =   c('Plugins.StatisticsFooter.Show');


   if (strpos($ShowMe, "v")  !== FALSE)
   echo Wrap(Wrap(T('View Count')) . Gdn_Format::BigNumber($SFVcount), 'div', array('class' => 'SFBox SFVCBox'));

  if (strpos($ShowMe, "u") !== FALSE)
   echo Wrap(Wrap(T('User Count')) . Gdn_Format::BigNumber($SFUcount), 'div', array('class' => 'SFBox SFUBox'));

  if (strpos($ShowMe, "t") !== FALSE)
   echo Wrap(Wrap(T('Topic Count')) . Gdn_Format::BigNumber($SFDcount), 'div', array('class' => 'SFBox SFTBox'));

  if (strpos($ShowMe, "c") !== FALSE)
   echo Wrap(Wrap(T('Post Count')) . Gdn_Format::BigNumber($SFPcount), 'div', array('class' => 'SFBox SFPBox'));
    }

 public function GetUserCount(){
     $UModel = new Gdn_Model('User');
    return $UModel->SQL
        ->Where("Deleted <","1")
        ->GetCount('User');

 }

 public function GetViewCount(){
      $DModel = new Gdn_Model('Discussion');
        $sender->UserData = $DModel->SQL
        ->Select('Sum(CountViews) AS SumViewCount')
        ->From('Discussion')
        ->Get();
       $Result =  $sender->UserData->Result();
        return current((array)$Result[0]);

 }

 public function GetDiscussionCount(){
     $VModel = new Gdn_Model('Discussion');
    return $VModel->SQL
        ->GetCount('Discussion');
 }

public function GetCommentCount(){
   $CModel = new Gdn_Model('Comment');
    return $CModel->SQL
        ->GetCount('Comment');
        }


   /*public function CategoriesController_Render_Before($sender) {

        $this->DiscussionsController_Render_Before($sender);
    }
*/

    public function CategoriesController_AfterRenderAsset_Handler($sender) {
       $this->DiscussionsController_AfterRenderAsset_Handler($sender);
    }


    public function PluginController_StatisticsFooter_Create($sender) {
        $sender->Title('Statistics Footer');
        $sender->AddSideMenu('plugin/statisticsfooter');
        $sender->Permission('Garden.Settings.Manage');
        $sender->Form = new Gdn_Form();
        $Validation = new Gdn_Validation();
        $ConfigurationModel = new Gdn_ConfigurationModel($Validation);
        $ConfigurationModel->SetField(array(
            'Plugins.StatisticsFooter.Show',

        ));
        $sender->Form->SetModel($ConfigurationModel);


        if ($sender->Form->AuthenticatedPostBack() === FALSE) {
            $sender->Form->SetData($ConfigurationModel->Data);
        } else {
            $Data = $sender->Form->FormValues();

            if ($sender->Form->Save() !== FALSE)
                $sender->StatusMessage = T("Your settings have been saved.");
        }
        $sender->render('sf-settings', '', 'plugins/StatisticsFooter');
        //$sender->Render($this->GetView('sf-settings.php'));
    }


  public function Setup() {

    }

    }
