<?php
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

$plugins->add_hook("global_intermediate", "checklist_global");

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

  $db->query("ALTER TABLE `".TABLE_PREFIX."profilefields` ADD `checklist` int(1)  NOT NULL DEFAULT '1';");

  $setting_group = array(
    'name' => 'checklist',
    'title' => 'Bewerber-Checklist',
    'description' => 'Einstellungen für das Bewerber Checklist-Plugin',
    'disporder' => 5, // The order your setting group will display
    'isdefault' => 0
  );
  $gid = $db->insert_query("settinggroups", $setting_group);

  $setting_array = array(
    'checklist_group' => array(
    'title' => 'Benutzergruppe für Bewerber',
    'description' => 'Wie lautet die Gruppen-ID der Bewerber?',
    'optionscode' => 'text',
    'value' => '996', // Default
    'disporder' => 1
     ),
    'checklist_fields' => array(
    'title' => 'Benötigte Profilfelder',
    'description' => 'Gib hier die IDs der benötigten Profilfelder ein. Trennen mit <strong>", "</strong>!',
    'optionscode' => 'text',
    'value' => '997, 998', // Default
    'disporder' => 2
     ),
   'checklist_application' => array(
   'title' => 'Steckbrief voraussetzen?',
   'description' => 'Brauchen Bewerber in deinem Forum einen Steckbrief?',
   'optionscode' => 'yesno',
   'value' => 1,
   'disporder' => 3
    ),
    'checklist_forum' => array(
    'title' => 'Unterforum für Bewerbungen',
    'description' => 'Gib die ID deines Unterforums für Bewerbungen an.',
    'optionscode' => 'text',
    'value' => '999', // Default
    'disporder' => 4
     ),
    'checklist_birthday' => array(
    'title' => 'Geburtstag voraussetzen?',
    'description' => 'Müssen Bewerber in deinem Forum ihr Geburtstag im Profil angeben (mit MyBB-Standardfunktion)?',
    'optionscode' => 'yesno',
    'value' => 1,
    'disporder' => 5
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

  $db->delete_query('settings', "name IN('checklist_group', 'checklist_fields', 'checklist_application', 'checklist_forum', 'checklist_birthday')");
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

function checklist_global() 
{
  global $db, $mybb, $lang, $templates, $field, $checklist_check, $header_checklist;
  $lang->load('checklist');
  $uid = $mybb->user['uid'];
  if($mybb->usergroup['uid'] == $mybb->settings['checklist_group']) {
    $fields = explode(", ", $db->escape_string($mybb->settings['checklist_fields']));
    foreach($fields as $db->escape_string($field)) {
      $query = $db->simple_select("profilefields", "fid, name, length", "fid = '".$field."'");
      $field = $db->fetch_array($query);
      $fid = "fid".$field['fid'];
      if(empty($mybb->user[$fid]) || strln($mybb->user[$fid] < $field['length']) {
        eval("\$checklist_check .= \"".$templates->get("checklist_field_checked")."\";");
      }
      else {
        eval("\$checklist_check .= \"".$templates->get("checklist_field_unchecked")."\";");
      }
    }
    if($mybb->settings['checklist_birthday'] == "1") {
      if(!empty($mybb->user['birthday'])) {
        eval("\$checklist_check .= \"".$templates->get("checklist_birthday_checked")."\";");
      }
      else {
        eval("\$checklist_check .= \"".$templates->get("checklist_birthday_unchecked")."\";");
      }
    }
    if($mybb->settings['checklist_application'] == "1") {
      $query = $db->simple_select("threads", "*", "uid = '".$uid."'");
      $application = $db->fetch_array($query);
      if(!empty($application)) {
        eval("\$checklist_check .= \"".$templates->get("checklist_application_checked")."\";");
      }
      else {
        eval("\$checklist_check .= \"".$templates->get("checklist_application_unchecked")."\";");
      }
    }
    eval("\$header_checklist .= \"".$templates->get("checklist")."\";");
  }
}
?>
