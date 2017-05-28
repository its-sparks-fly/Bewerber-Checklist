<?php
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

$plugins->add_hook("admin_formcontainer_output_row", "checklist_checkbox");

function checklist_info()
{
	return array(
		"name"		=> "Bewerber-Checklist",
		"description"	=> "Zeigt Charakteren in der Bewerbungsphase eine To Do-Liste im Headerbereich an.",
		"website"	=> "http://storming-gates.de",
		"author"	=> "sparks fly",
		"authorsite"	=> "http://storming-gates.de",
		"version"	=> "1.0",
		"compatibility" => "18*"
	);
}

function checklist_install()
{
  global $db, $cache, $mybb;
  
  $db->query("ALTER TABLE `".TABLE_PREFIX."profilefields` ADD `checklist` int(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `allowvideocode`;");
  
  $setting_group = array(
    'name' => 'checklist',
    'title' => 'Bewerber-Checklist',
    'description' => 'Einstellungen für das Bewerber Checklist-Plugin',
    'disporder' => 5, // The order your setting group will display
    'isdefault' => 0
  );
  $gid = $db->insert_query("settinggroups", $setting_group);
  
  $setting_array = array(
   'checklist_application' => array(
   'title' => 'Steckbrief voraussetzen?',
   'description' => 'Brauchen Bewerber in deinem Forum einen Steckbrief?',
   'optionscode' => 'yesno',
   'value' => 1,
   'disporder' => 1
    ),
    'checklist_forum' => array(
    'title' => 'Unterforum für Bewerbungen',
    'description' => 'Gib die ID deines Unterforums für Bewerbungen an.',
    'optionscode' => 'text',
    'value' => '999', // Default
    'disporder' => 2
     ),
    'checklist_birthday' => array(
        'title' => 'Geburtstag voraussetzen?',
        'description' => 'Müssen Bewerber in deinem Forum ihr Geburtstag im Profil angeben (mit MyBB-Standardfunktion)?',
        'optionscode' => 'yesno',
        'value' => 1,
        'disporder' => 3
    ),
  );
  
  foreach($setting_array as $name => $setting)
  {
    $setting['name'] = $name;
    $setting['gid'] = $gid;
     $db->insert_query('settings', $setting);
  }
  
  rebuild_settings();
}

function checklist_is_installed()
{
  global $db;
  if($db->field_exists("checklist", "profilefields"))
  {
      return true;
  }
  return false;
}

function checklist_uninstall()
{
  global $db;
  
  if($db->field_exists("checklist", "profilefields"))
  {
    $db->drop_column("profilefields", "checklist");
  }
  
  $db->delete_query('settings', "name IN('checklist_application', 'checklist_forum', 'checklist_birthday')");
  $db->delete_query('settinggroups', "name = 'checklist'");
  
  rebuild_settings();
}

function checklist_activate()
{
  global $db, $mybb;
  
}

function checklist_deactivate()
{
  global $db, $mybb;
  
}

function checklist_checkbox($above)
{
	global $mybb, $lang, $form_container, $forum_data, $form;
	if($above['title'] == $lang->edit_profile_field || $lang->add_profile_field)
	{
		$above['content'] .= $form_container->output_row("Pflicht für Annahme des Charakters?", "Muss dieses Profilfeld ausgefüllt sein, damit der Charakter angenommen wird?", $form->generate_yes_no_radio('checklist', $mybb->input['checklist']));
	}
	return $above;
}

?>
