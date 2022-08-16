<?php

$tutorialSteps = array(
	1 => array(
		"title" => "Step numero zero",
		"content" => sprintf("<p>*applause*</p>
			<p>Welcome, %s,</p>
			<p>To the first of a series of mini-tutorials meant to introduce you to this majestic competition.</p>
			<p>Rewards await you at the end of every step.</p>
			<p>First and foremost, go through <a href='".URL."pages/page/beginner-tutorial'>a short summary of available interfaces</a>.</p>
			<p><strong>Connecting to your account daily will grant incremental rewards proportional with the number of consecutive days.</strong></p>
			<p>The tutorial icon will keep flashing on the left. Press it when you're done reading the summary.</p>", $user['username']),
		//"complete" => "",
		"rewards" => array(
			"money" => 25,
			"exp" => 20,
			"skillPoints" => 4,
			)
		),
2 => array(
	"title" => "Me haz rewardz",
	"content" => "<p>We've delivered your reward!</p>
	<p>You can claim it in the Rewards Interface, where you can also find a history of your rewards.</p>
	<p>Please claim all of your pending rewards.</p>",
	"rewards" => array(
		"money" => 30,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),
3 => array(
	"title" => "Friends with beneftis",
	"content" => '<p>"Friends may come and go, but enemies accumulate." ~ Thomas Jones.</p>
	<p>However, the usefulness of friendships cannot be denied.</p>
	<p>If you <a href="'.URL.'dna">connect your accounts</a> you can authenticate with one click and there\'s an achievement for connecting all social accounts.</p>
	<p>Considerable rewards are at stake <a href="'.URL.'referrals">if you refer others and these rewards will keep on coming</a>.</p>
	<p>Now go and check your Friends interface. You might have a request or two pending.</p>
	<p>Press the top Headquarters navigation button, go to the Friends screen and make a decision for pending requests.</p>',

		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 20,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),
4 => array(
	"title" => "A server?",
	"content" => '<p>Servers are computers designed for heavy work.</p>
	<p>To be able to do anything useful you need to configure your 1st server so please find the Servers interface.</p>
	<p><strong>Buy the CHEAPEST components</strong> you find. Money does NOT grow in trees (sadly).</p>
	<p>You require a Power Source, a Motherboard, a CPU, a Case, one <a title="Computer Memory Card">RAM card</a> and one <a title="Hard Disk Storage">HDD</a>.</p>
	<p>Bought items go to Storage. Be careful as the storage has limited space (expands as you level or by <a href="'.URL.'alpha_coins/option/extraStorage1">Alpha Coins</a>).</p>
	<p>After building a server, you should visit your <a href="'.URL.'storage">Storage</a> to mount RAM and HDD on it.</p>',

		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 60,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),

5 => array(
	"title" => "Missions",
	"content" => '<p>Access the missions interface.</p>
	<p>Most commands you will use in missions are influenced by your skills && your main server skills and there\'s a chance they will cause damage to your software. On the Skills interface you can find out what it influences.</p>
	<p><strong>This time your task is to finish the first mission in the Computer Science missions group.</strong></p>
	<p>If you\'ll feel you do not have enough time in missions, you can make use of a <a href="'.URL.'alpha_coins/option/extraTime">Time Distortion Device</a>.</p>
	<p>Some of the missions have been designed by hackers just like you, who joined the <a href="'.URL.'alpha_coins/option/questManager">Alpha Mission Designer Intern program</a>.</p>
	',

		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 100,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),

6 => array(
	"title" => "All for one and one for party",
	"content" => '<p>In the missions interface you can see that "Parties" are an option.</p>
	<p>Skim a bit through the instructions for "Parties".</p>
	<p>A live chat box appears to party members. <a href="'.URL.'alpha_coins/option/partyChat">You can enable this Party Chat everywhere</a> (by default it\'s visible only in the mission interface).
	</p>
	<p>Party members can join shared mission instances, interacting with the very same systems.</p>
	<p>Your task is simple. Create a party and disband whenever you like.</p>',

		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 20,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),

7 => array(
	"title" => "the node maze",
	"content" => '<p>Every competitor can be found on the grid network.</p>
	<p>Through the grid you can spy and attack each other. Everyone has three layers of security plus a spy layer on top of that. We will discuss them later.</p>
	<p>The Grid is separated into Zones which in turn have subdivisions named clusters.</p>
	<p>You can own one or multiple nodes in one or more clusters of any zone but officially you are part only of the Zone you picked at first.</p>
	<p>Occupying a node is called Instantiation and can be done with specialized software.</p>
	<p>In extreme situations nodes can be destroyed so it\'s better to have more than one.</p>
	<p>Now take a quick look at the Grid, find a random citizen and access his profile.</p>',

		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 40,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),

8 => array(
	"title" => "dark side of the grid",
	"content" => '<p><a href="'.URL.'achievements">Achievements</a> are special awards. Some improve your ranking. There are as many hidden achievements as there are public ones.</p>

	<p>Your skills and server skills influence your Layers.</p>
	<p>An attacker must breach through the second layer to steal anything and if he passes through the third layer more resources are stolen.</p>
	<p>You can send your servers to attack and while they are in use they are not protecting you.</p>
	<p>You can see the influence of every skill and server (as long as it is not in use) in the Layers Interface.</p>
	<p>The <a href="'.URL.'simulator">battle simulator</a> can attempt to predict the outcome of battles.</p>
	<p>Please go to <a href="'.URL.'grid">the Grid</a> and enter the <strong>Layers Interface</strong>.</p>
	',

		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 10,
		"exp" => 20,
		"skillPoints" => 4,
		)
	),

9 => array(
	"title" => "Skills",
	"content" => '<p>We\'ve established that skills influence your security layers.</p>
	<p>Skills also increase the efficiency and hence diminish the duration of commands execution in the missions console.</p>
	<p>Access the Skills Interface upgrade your skills with all available Universal Skill Points (USP).</p>
	<p>You might find yourself going through a painful trial and error process to figure out which skills are the best to use.</p>
	<p>Skills are for all intents and purposes <strong>you</strong>!</p>

	',

		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 10,
		"exp" => 20,
		"skillPoints" => 4,
		)
	),
10 => array(
	"title" => "Abs",
	"content" => '<p>Abilities enhance your skills. They have no other contributions than to give you more specific skill points.</p>
	<p>You might want to see exactly to which skills each ability contributes before jumping into it.</p>
	<p>You can advance to the next step as soon as you\'ve learnt an ability.</p>
	<p>To access the Ability Hive, go to the Skills Interface then enter the Abilities Interface.</p>
	',
		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 10,
		"exp" => 20,
		"skillPoints" => 4,
		)
	),

11 => array(
	"title" => "Server skills and apps",
	"content" => '<p>You are doing very well indeed. We must say we are impressed!</p>
	<p>Server components and software can be damaged during Grid Battles, Missions and the lot.</p>
	<p>Server skills are generated by running apps. Please buy a cheap app (in the same shop as for components), install and run it on your main server.</p>
	<p>Observe the skill levels of your server changing.</p>
	',
		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 30,
		"exp" => 20,
		"skillPoints" => 4,
		)
	),

12 => array(
	"title" => "Data Points",
	"content" => '<p>You can <a href="'.URL.'data-points">read about Data Points here</a>.</p>
	<p>It\'s enough to say here that DPs are generated by servers under the influence of running apps.</p>
	<p>You can <a href="'.URL.'alpha_coins/option/extraDataPoints15">hire a Mining Consultant to increase your DP production</a>.</p>
	<p>All you have to do is <a href="'.URL.'data-points">give this a quick read</a>.</p>
	',
		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 30,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),

13 => array(
	"title" => "Jobs",
	"content" => '<p>The key word is freelancing. A hacker needs money and experience and not just from missions.</p>
	<p>Find the Jobs Interface and complete a job.</p>
	',
		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 30,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),

14 => array(
	"title" => "Training",
	"content" => '<p>Great! The same goes for Training.</p>
	<p>Our training programs will buggle your mind but your logic will improve exponentially. You like brain teasers? TOO BAD!</p>
	<p>If you find yourself stuck in a numbers problem, the forums and chats are always at your disposal.</p>
	<p>Train once and we shall swiftly move on!</p>
	<p>You can access the Train Interface through the Job one.</p>
	',
		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 50,
		"exp" => 20,
		"skillPoints" => 4,
		)
	),

15 => array(
	"title" => "Forumsy",
	"content" => '<p><a href="'.URL.'forum/fid/7">Say hello to us on the forums!</a></p>
	<p>Feel free to skip this step if you so desire.</p>
	',
		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 60,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),


16 => array(
	"title" => "Organizations",
	"content" => '<p>Organizations are groups of hackers with the slightest trace of a common goal. Partners in crime.</p>
	<p>Organization wars make the difference between the strong.. and the weak.</p>
	<p>Hacking Points help organizations improve. You can earn Hacking Points for your organization by doing normal missions, entering events and participating in the daily hacking missions in the Hacking Points interface of your organization.</p>
	<p>After a while, you will be kicked out of the beginners organization. Join or create your own!</p>
	<p>Your task is to find the Hacking Points Interface of your current organization (go to your organization and investigate around there).</p>
	<p>If you try you might find yourself unable to complete the Hacking Points mission as you\'re not used to the console ^^. No worries, you\'ll master it very soon.</p>
	',
		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 60,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),

17=> array(
	"title" => "Easy peasy",
	"content" => '<p>About time for another easy task.</p>
	<p>You can set an Youtube video to appear on your profile page! How cool is that?!</p>
	<p>All you need is the video code, an example is provided in the DNA/Settings Interface.</p>
	<p>Access this Interface by clicking your avatar in the dashboard or on your profile page and set an Youtube video for yourself. Optionally investigate how to update your avatar as well!</p>',
		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 33,
		"exp" => 20,
		"skillPoints" => 2,
		)
	),


18 => array(
	"title" => "My Computer Science Degree",
	"content" => '<p>Last but not least, finish the "SELECT * FROM WORLD" mission available in the Computer Science missions group.</p>
	<p><strong>You will have to do missions in the group one by one until you reach that one.</strong></p>
	<p>Did you notice the <strong>PAUSE</strong> button available in missions?</p>
	<p>
	Please remember to like, follow our social channels and download our mobile/tablet apps to show your support to this challenging project.
	</p>
	<p>And we apologise beforehand for the bugs you might encounter ^^.
	</p>

	',
		//"complete" => "That's how it's done!",
	"rewards" => array(
		"money" => 100,
		"exp" => 40,
		"skillPoints" => 10,
		)
	),
);


function tutorial_step_1_check()
{
	global $GET;

	if ($GET['currentPage'] == 'pages' && $GET['page'] == "beginner-tutorial")
		tutorial_step_complete();
}

function tutorial_step_2_check()
{

	global $user;

	if (!$user['rewardsToReceive'])
		tutorial_step_complete();
}

function tutorial_step_3_check()
{

	global $GET;

	if ($GET['currentPage'] == 'friends')
		tutorial_step_complete();
}

function tutorial_step_4_check()
{

	global $user;

	if ($user['server'])
		tutorial_step_complete();
}

function tutorial_step_5_check()
{

	global $db, $user;
	$check = $db->where('user_id', $user['id'])->where('quest', 70)->getOne('quests_user', 'id');
	if ($check['id'])
		tutorial_step_complete();
}


function tutorial_step_6_check()
{

	global $user;
	if ($user['in_party'])
		tutorial_step_complete();
}

function tutorial_step_7_check()
{

	global $GET;

	if ($GET['currentPage'] == 'profile')
		tutorial_step_complete();
}

function tutorial_step_8_check()
{

	global $GET;

	if ($GET['currentPage'] == 'grid/grid' && $GET['layers'])
		tutorial_step_complete();
}

function tutorial_step_9_check()
{

	global $GET, $user;

	if ($GET['currentPage'] == 'skills' && !$user['skillPoints'])
		tutorial_step_complete();
}


function tutorial_step_10_check()
{

	global $user, $db;
	$check = $db->where('user_id', $user['id'])->where('level > 0')->getOne('abilities', 'ability_id');

	if ($check['ability_id'])
		tutorial_step_complete();
}

function tutorial_step_11_check()
{

	global $user, $db;
	$check = $db->where('server_id', $user['server'])->where('running is not null and running != 0')->getOne('server_apps', 'process_id');

	if ($check['process_id'])
		tutorial_step_complete();
}

function tutorial_step_12_check()
{
	global $GET;

	if ($GET['currentPage'] == 'data-points')
		tutorial_step_complete();
}

function tutorial_step_13_check()
{

	global $user, $db;
	$check = $db->where('user_id', $user['id'])->getOne('user_job_logs', 'log_id');

	if ($check['log_id'])
		tutorial_step_complete();
}

function tutorial_step_14_check()
{

	global $user, $db;
	$check = $db->where('user_id', $user['id'])->getOne('user_train_logs', 'log_id');

	if ($check['log_id'])
		tutorial_step_complete();
}

function tutorial_step_15_check()
{

	global $user, $db;
	$check = $db->where('user_id', $user['id'])->where("fid", 7)->getOne('forum_posts', 'id');

	if ($check['id'])
		tutorial_step_complete();
}




function tutorial_step_16_check()
{

	global $GET;

	if ( $GET['view'] == "hackingPoints")
		tutorial_step_complete();
}

function tutorial_step_17_check()
{


	if ($_POST['youtube'])
		tutorial_step_complete();
}

function tutorial_step_18_check()
{

	global $db, $user;

	$check = $db->where('quest', 39)->where('user_id', $user['id'])->getOne('quests_user', 'id');
	if ($check['id'])
		tutorial_step_complete();
}


function tutorial_step_complete()
{

	global $tutorial, $uclass, $myModal;
	$tutorial['status'] = 1;
	$myModal['show'] = true;
	$uclass->updatePlayer(array('tutorial' => $tutorial['step'] * 10 + $tutorial['status']));
}
