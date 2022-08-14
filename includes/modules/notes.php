<?php
$cardinal->mustLogin();
$maxContentSize = $_SESSION['premium']['notes'] ? 50000 : 500;
$nrNotes = $_SESSION['premium']['notes'] ? 5 : 1;

if ($GET['note'])
{
	$note = $db->where('user_id', $user['id'])->where('note_id', $GET['note'])->getOne('notes');
	if (!$note['note_id']) $cardinal->redirect(URL."notes");

	if ($GET['edit'])
	{


		if($_POST)
		{
			if (strlen($_POST['title']) > 0 && strlen($_POST['title']) > 100)
				$errors[] = "Title must have between 1 and 100 characters";
			if (strlen($_POST['content']) > $maxContentSize)
				$errors[] = "Content must have less than ".number_format($maxContentSize)." characters.";

			if (!count($errors))
			{
				$voice = 'note_saved';
				$db->where('note_id', $note['note_id'])->update('notes', array('title' => htmlentities($_POST['title']), 'content' => $_POST['content'], 'lastUpdate' => time()));
				$cardinal->redirect(URL."notes/note/".$note['note_id']);
			}
		}
	}
	else
	{
		$parser = new \JBBCode\Parser();
		$parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
		$parser->parse($note['content']);
		$note['content'] = $parser->getAsHtml();
	}
	$tVars['note'] = $note;
	$tVars['display'] = "notes/note.tpl";

}
else
{


if ($_POST['delete'])
{
	$db->where('user_id', $user['id'])->where('note_id', $_POST['delete'])->delete('notes', 1);
}
$notes = $db->where('user_id', $user['id'])->get('notes', null, 'note_id, title');

if ($_POST['new'] && count($notes) < $nrNotes)
{
	$db->insert("notes", array("title" => "New note", "user_id" => $user['id'], 'created' => time()));
	$voice = 'note_saved';
	$cardinal->redirect(URL_C);
}

$tVars['nrNotes'] = $nrNotes;
$tVars['maxContentSize'] = $maxContentSize;
$tVars['notes'] = $notes;
$tVars['display'] = "notes/notes.tpl";
}
