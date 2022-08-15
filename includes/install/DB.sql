CREATE TABLE `abilities` (
  `user_id` int(11) NOT NULL,
  `ability_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `achievements` (
  `achievement_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `visibleInList` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `alpha_coins_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `ac_cost` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `kongregate` varchar(300) DEFAULT NULL,
  `kongregate_user_id` int(11) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `alpha_coins_shop` (
  `item_id` int(11) NOT NULL,
  `monthly_cost` int(11) DEFAULT NULL,
  `description` text,
  `user_premium_col` varchar(200) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `shopOrder` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `extraData` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `alpha_coins_shop` (`item_id`, `monthly_cost`, `description`, `user_premium_col`, `name`, `shopOrder`, `type`, `available`, `extraData`) VALUES
(1, 10, '<div class=\"row\"> <div class=\"col-md-3\"> <a href=\"#\" onclick=\"$(\'#demo-0\')[0].play();return false;\" ><img src=\"http://secretrepublic.net/layout/img/characters/eve.png\" style=\"max-width:100%\"/> </a></div> <div class=\"col-md-9\">Your <strong>personal Artificial Intelligent assistant</strong> will greet you when you connect and will notify you as certain events take place. For example: in missions (commands and actions), jobs, training, general notices (errors and warnings), login, 404 pages, etc. <br/><br/>You will have the ability to activate/deactivate the voice using the Settings interface (same one you can change your password in). <br/><br/>Verify if your can hear the following demo: <div class=\"text-center\"><br/><br/> <div class=\"row\">   <div class=\"col-md-4\">     <a href=\"#\" onclick=\"$(\'#demo-0\')[0].play();return false;\" class=\"button text-center mb10\">HELLO</a>   </div><div class=\"col-md-4\">     <a href=\"#\" onclick=\"$(\'#demo-1\')[0].play();return false;\" class=\"button text-center mb10\">INITIATED</a>   </div>   <div class=\"col-md-4\">     <a href=\"#\" onclick=\"$(\'#demo-2\')[0].play(); return false;\" class=\"button text-center mb10\">PING</a>   </div> </div> <audio controls class=\"nodisplay\" id=\"demo-0\">   <source src=\"http://secretrepublic.net/mp3/eve/ogg/ai_intro.ogg\" type=\"audio/ogg\">   <source src=\"http://secretrepublic.net/mp3/eve/ai_intro.mp3\" type=\"audio/mpeg\"> Your browser does not support the audio element. </audio>\n<audio controls class=\"nodisplay\" id=\"demo-1\">   <source src=\"http://secretrepublic.net/mp3/eve/ogg/systems_initiated_welcome.ogg\" type=\"audio/ogg\">   <source src=\"http://secretrepublic.net/mp3/eve/systems_initiated_welcome.mp3\" type=\"audio/mpeg\"> Your browser does not support the audio element. </audio>\n<br/><br/> <audio controls class=\"nodisplay\" id=\"demo-2\">   <source src=\"http://secretrepublic.net/mp3/eve/ogg/ping_in_progress.ogg\" type=\"audio/ogg\">   <source src=\"http://secretrepublic.net/mp3/eve/ping_in_progress.mp3\" type=\"audio/mpeg\"> Your browser does not support the audio element. </audio> </div></div></div>', 'ai', 'Personal Assistant - A.I. Voice - Welcome, Commands, Notifications', 1, 1, 1, ''),
(3, 10, 'An onscreen notepad will allow you to take notes, copy objectives and email contents and virtually write anything you might find useful for completing the mission at hand.', 'missionNotepad', 'Notepad in missions', 998, 1, 1, ''),
(4, 10, '<p>The floating party chat box will be available everywhere and not only when in mission or on the party page.\r\n</p>\r\n<p>\r\nEven more, it\'s enough for one party member to have this feature active for everyone in the party to enjoy it.</p>\r\nFun never comes alone.', 'partyChat', 'Party Chat outside of Missions and Party interface', 7, 1, 1, ''),
(5, 10, 'Obtain access to the Attack Simulator. You can input any skill values for imaginary attackers and defenders plus their servers and simulate the outcome to better predict your success rates. ', 'attackSimulator', 'Grid Attacks Simulator', 6, 1, 1, ''),
(6, 10, 'Remove any and all in-game ads prompting you to obtain Alpha Coins or otherwise (e.g. notices from storage page, mission console, main overview).', 'removeAds', 'Remove all Ads (Get Alpha Coins and Extra options notifications)', 4, 1, 1, ''),
(7, 10, 'You will be able to modify the hostname of each of the servers you own. Hostnames appear wherever servers are concerned, for example in missions and Grid attacks.', 'serversHostname', 'Change Servers Hostname', 999, 1, 1, ''),
(8, 10, 'A full history of the commands used (and executed succesfully) followed by their full output will be made available to your.<br/><br/>In case of party missions you will gain the ability to view the history of every other participant as well (from a selectable menu).<br/><br/>Never forget the details again and avoid the annoying scrolling through the console by using the history interface.', 'consoleHistory', 'Console History in Solo and Party Missions', 5, 1, 1, ''),
(9, 10, 'Add 10 slots to your storage limit, on top of the default and level slots. Once this service expires if you have items over the limit in storage they will remain there but you will be unable to add more items until you free up some space just how you would normally have to do in case you reach your storage limit.', 'extraStorage1', '10 Extra Storage Slots', 4, 1, 1, ''),
(10, 10, '<p>Finding hard to complete some of the more difficult missions or simply want to focus more on the story, fun and learning process rather than keepin\' an eye on the unforgivable timer running out before your very eyes?</p>\n<p>This Time Bubble device has been developed by Alpha in secret and is available to very few people for testing purposes. Taking advantage of Quantum Entanglement theories that support time travel aspirations, it changes the way you perceive time will remain the same, however you will have 25% more time to finish any mission. If you\'re in a party everyone else will benefit of the extra time as well.</p>\n<p><strong>Instructions</strong></p>\n<p>You will be able to use the device <strong>once per day</strong> (if you use it on Monday, regardless of the hour, you will be able to use it again on Tuesday based on Alpha server time).</p>\n<p>To start the device and add 25% time write the following in the console:</p>\n<strong>time delusion</strong>', 'extraTime', 'Time Distortion Device ~ +25% time in missions', 3, 1, 1, ''),
(11, 10, 'The expert send by Alpha will perform regular audits and improve they way you mine behind the scenes. He promises and delivers an increase of 15% in your Data Points mining.', 'extraDataPoints15', 'Mining Consultant ~ +15% more Data Points', 3, 1, 1, ''),
(12, 200, '<h4>Want your own chance to stand in the spotlight?</h4>\n<p>Become an Intern for Alpha Corporation and receive access to an (as easy as it can be) mission design interface used by their experts to design the competition missions.</p>\n<p>You will be given total freedom of choice to create your Mission Group and Missions the way you want them. It\'s your story, your missions. You\'ll be able to add as many servers as you want and plan and implement your objectives and side-objectives.</p>\n<p>Alpha employees will give you a hand along the way and help you refine everything when you think you\'re ready to publish one or more missions. Once Alpha approves your missions contents, they will be available for the entire world of the Secret Republic to enjoy, with credits given to none other than yourself!</p>\n<p>If you so desire, Alpha will consider creating special achievements for your missions and even for hidden side-objectives in them. You\'ll be able to also propose the rewards given upon completion and suggest Daily and Party missions not just normals.</p>\n<h4>You\'ll finally be able to tell other you\'re not just a hacker but one who creates for other hackers</h4>', 'questManager', 'Mission Design Engineer Intern', 2, 1, 1, ''),
(13, 10, 'Double your current hourly energy recovery rate to increase efficiency and get the chance to do more in less time without having to wait as long to recover.', 'recoveryRateDouble', 'Double your Energy Hourly Recovery Rate', 4, 1, 1, ''),
(14, 5, '<p>Be able to create 5 notes instead of just one and of 50 000 characters in length instead of just 500.</p>Once this service expires if you have more than one note they will remain and you will be able to updated them but you will no longer be able to c...', 'notes', 'Notes upgrade', 5, 1, 1, ''),
(15, 10, 'Increase your bank vault storage amount. You\'ll be able to completely secure more money. This option stacks with other limit increasing options and when expired the money will remain in vault until redeemed.', 'bankLimit1', 'Bank Limit (+10,000$)', 8, 1, 1, ''),
(16, 20, 'Increase your bank vault storage amount. You\'ll be able to completely secure more money. This option stacks with other limit increasing options and when expired the money will remain in vault until redeemed.', 'bankLimit2', 'Bank Limit (+30,000$)', 8, 1, 1, ''),
(17, 20, 'The Bad Apples mission group will become accessible to you. There\'s at least one daily mission available amongst the missions of this group and more normal (one time) missions are added to it constantly. This Mission pack is challenging, fun and rewarding and will test most aspects of your knowledge earned so far as a hacker.<br/><br/>\nMissions have been carefully designed to make it worth your while ^^.\n<br/><Br/>\nIn this mission pack we also try to give you more freedom in choosing what paths to follow inside a mission, giving you alternative ways of reaching the ending.\n<br/></br>\n<strong><em>Premise: I\'ve done enough for everybody else. I think this is the perfect moment I start doing things for myself.</em></strong>', 'missionsPack1', 'Mission Pack I (More Missions)', 1, 1, 1, ''),
(18, 10, '<p>Many missions require you to decode and sometimes even encode strings from and to base64. You can of course do that by using external tools you can find on the still available world wide web.</p>\n<p>But we believe in ease of access and so these commands will allow you to complete these tasks directly in the console using simple commands like <strong>base64 encode stringHere</strong> and <strong>base64 decode stringHere</strong>.</p>\nEasy peasy.', 'base64', 'Base64 Encoding/Decoding Console Command', 4, 1, 1, ''),
(19, 10, '<p>This slight limitation can become an obstacle on the path of your destiny.</p>Increase the number of simultanious tasks you can execute to 6 and improve your chances for greatness.', 'maxTasks1', 'Increase Max Tasks Limit to 6', 2, 1, 1, ''),
(20, 20, '<p>This slight limitation can become an obstacle on the path of your destiny.</p>Increase the number of simultanious tasks you can execute to 10 and improve your chances for greatness.', 'maxTasks2', 'Increase Max Tasks Limit to 10', 2, 1, 1, ''),
(21, 250, '<p>Add 1 month to all currently available features (to those you have already activated, if any, as well).</p>\n\nAll services will be activated automatically for an extra month as soon as this option is bought.', 'oneMonthAll', 'UBER Activation - One month to ALL services (worth > 400A-C)', 0, 2, 1, '2592000'),
(22, 10, 'A notification will be displayed next to the delivery date of every message you send letting you know if the receiver has seen the message or not.\r\n\r\n', 'seenConv', 'Seen/Unseen for Conversations', 0, 1, 0, '');

CREATE TABLE `alpha_coin_transactions` (
  `transaction_id` int(11) NOT NULL,
  `post` text,
  `user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `paypal` varchar(300) DEFAULT NULL,
  `alphaCoins` int(11) DEFAULT NULL,
  `kongregate` varchar(300) DEFAULT NULL,
  `alphaCoinsGiven` int(11) DEFAULT NULL,
  `kongregate_user_id` int(11) DEFAULT NULL,
  `fortumo` varchar(300) DEFAULT NULL,
  `fortumo_sender` varchar(100) DEFAULT NULL,
  `paid` float DEFAULT NULL,
  `fortumo_revenue` float DEFAULT NULL,
  `paypal_revenue` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `applications` (
  `app_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cpu` int(11) DEFAULT NULL,
  `ram` int(11) DEFAULT NULL,
  `hdd` int(11) DEFAULT NULL,
  `skill_id` int(11) DEFAULT NULL,
  `skill_value` int(11) DEFAULT NULL,
  `repair_coefficient` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `applications` (`app_id`, `name`, `cpu`, `ram`, `hdd`, `skill_id`, `skill_value`, `repair_coefficient`) VALUES
(1, 'Brick - Network Defender', 1, 50, 50, 2, 10, 1),
(2, 'Aria - Automatic Exploit Detector', 1, 11, 22, 3, 15, 1),
(3, 'Data Points Miner v1', 1, 50, 50, 12, 40, 1),
(4, 'Data Points Miner v2', 2, 206, 100, 12, 80, 0.7),
(5, 'Husky - Network Spy ', 1, 50, 50, 11, 20, 1),
(6, 'R00T - Data Analyser', 1, 55, 40, 9, 33, 1),
(7, 'Cron Runner - v1', 1, 30, 30, 8, 30, 1),
(8, 'Firewall Breaker v1', 1, 50, 50, 6, 40, 1),
(9, 'Node Foundation v1', 5, 500, 300, 15, 30, NULL),
(10, 'Data Points Miner 3', 3, 300, 200, 12, 120, NULL),
(11, 'Node Foundation v2', 5, 600, 400, 15, 60, NULL);

CREATE TABLE `attacks_inprogress` (
  `attack_id` int(11) NOT NULL,
  `sender_user_id` int(11) DEFAULT NULL,
  `receiver_user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `totalSeconds` int(11) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `servers` text,
  `hard` tinyint(1) NOT NULL,
  `sender` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `attack_logs` (
  `attack_log_id` int(11) NOT NULL,
  `sender_user_id` int(11) DEFAULT NULL,
  `receiver_user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `totalSeconds` int(11) DEFAULT NULL,
  `log_created` int(11) DEFAULT NULL,
  `report` text,
  `winner_user_id` int(11) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `servers` text,
  `hard` tinyint(1) NOT NULL,
  `sender` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `winner` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `nra` int(11) NOT NULL DEFAULT '0',
  `nrs` int(11) NOT NULL DEFAULT '0',
  `rank` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `blog_articles` (
  `article_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `created` int(11) DEFAULT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  `nrc` int(11) NOT NULL DEFAULT '0',
  `edited` int(11) DEFAULT NULL,
  `content_unparsed` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `blog_article_votes` (
  `vote_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `blog_comments` (
  `comment_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `content` text,
  `created` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `blog_subscriptions` (
  `subscription_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `components` (
  `component_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  `hdd` int(11) DEFAULT NULL,
  `ram` int(11) DEFAULT NULL,
  `cpu` int(11) DEFAULT NULL,
  `slots` int(11) DEFAULT NULL,
  `power` int(11) DEFAULT NULL,
  `power_usage` int(11) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `default_sell_price` int(11) NOT NULL,
  `repair_coefficient` float DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `components` (`component_id`, `name`, `type`, `hdd`, `ram`, `cpu`, `slots`, `power`, `power_usage`, `image`, `default_sell_price`, `repair_coefficient`) VALUES
(1, 'Training CPU', 1, NULL, NULL, 2, NULL, NULL, 1, 'cpu.png', 50, 1),
(2, 'Training Motherboard', 2, NULL, NULL, NULL, 1, 0, 1, 'motherboard.png', 50, 1),
(3, 'Training Case', 3, NULL, NULL, NULL, 1, NULL, NULL, 'case.png', 50, 1),
(4, 'Training Power Source', 4, NULL, NULL, NULL, NULL, 2, NULL, 'power.png', 50, 1),
(5, 'Training RAM Card', 5, NULL, 256, NULL, NULL, NULL, NULL, 'ram.png', 50, 1),
(6, 'Training HDD', 6, 100, NULL, NULL, NULL, NULL, NULL, 'harddisk.png', 50, 1),
(7, 'SecondGen CPU', 1, NULL, NULL, 4, NULL, NULL, 2, 'cpu.png', 100, 1),
(8, 'SecondGen RAM Card', 5, NULL, 512, NULL, NULL, NULL, NULL, 'ram.png', 100, 1),
(9, 'SecondGen HDD', 6, 500, NULL, NULL, NULL, NULL, NULL, 'harddisk.png', 100, 1),
(10, 'SecondGen Motherboard', 2, NULL, NULL, NULL, 2, NULL, 2, 'motherboard.png', 100, 1),
(11, 'SecondGen Case', 3, NULL, NULL, NULL, 2, NULL, NULL, 'case.png', 100, 1),
(12, 'SecondGen Power Source', 4, NULL, NULL, NULL, NULL, 4, NULL, 'power.png', 100, 1),
(13, 'ThirdGen CPU', 1, NULL, NULL, 6, NULL, NULL, 4, 'cpu.png', 200, 1),
(14, 'ThirdGen RAM Card', 5, NULL, 1024, NULL, NULL, NULL, NULL, 'ram.png', 200, 1),
(15, 'ThirdGen HDD', 6, 1000, NULL, NULL, NULL, NULL, NULL, 'harddisk.png', 200, 1),
(16, 'ThirdGen Motherboard', 2, NULL, NULL, NULL, 4, NULL, 4, 'motherboard.png', 200, 1),
(17, 'ThirdGen Case', 3, NULL, NULL, NULL, 3, NULL, NULL, 'case.png', 200, 1),
(18, 'ThirdGen Power Source', 4, NULL, NULL, NULL, NULL, 8, NULL, 'power.png', 200, 1),
(19, 'FourthGen CPU', 1, NULL, NULL, 10, NULL, NULL, 6, 'cpu.png', 300, 1),
(20, 'FourthGen Power Source', 4, NULL, NULL, NULL, NULL, 12, NULL, 'power.png', 300, 1);

CREATE TABLE `conversations` (
  `message_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `message` text,
  `parent_message_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `sender_user_id` int(11) DEFAULT NULL,
  `receiver_user_id` int(11) DEFAULT NULL,
  `last_reply_by_user_id` int(11) DEFAULT NULL,
  `last_reply_seen` tinyint(4) NOT NULL DEFAULT '0',
  `last_reply_date` int(11) DEFAULT NULL,
  `replies` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL,
  `code` varchar(200) DEFAULT NULL,
  `alphaCoins` int(11) DEFAULT '0',
  `limitedUse` tinyint(1) DEFAULT '1',
  `uses` int(11) DEFAULT '0',
  `expires` tinyint(1) DEFAULT '0',
  `expirationDate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `coupon_logs` (
  `log_id` int(11) NOT NULL,
  `created` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `failed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `data_points_spin` (
  `id` int(11) NOT NULL,
  `app_id` int(11) DEFAULT NULL,
  `component_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `data_points_spin` VALUES (1,1,NULL),(2,9,NULL),(3,10,NULL),(4,11,NULL),(5,NULL,19),(6,NULL,20);

CREATE TABLE `data_points_spin_logs` (
  `log_id` int(11) NOT NULL,
  `app_id` int(11) DEFAULT NULL,
  `component_id` int(11) DEFAULT NULL,
  `created` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `debug_404_errors` (
  `id` int(11) NOT NULL,
  `URL` varchar(300) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `debug_cron_logs` (
  `created` int(11) DEFAULT NULL,
  `data` text,
  `type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `email_templates` (
  `subject` varchar(300) NOT NULL,
  `message` text NOT NULL,
  `shortcut` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `email_templates` (`subject`, `message`, `shortcut`, `name`) VALUES
('Alpha Coins Delivered', '<p>Hello,</p>\r\n\r\n<p>We\'ve processed and delivered ALPHA_COINS Alpha Coins to your account.</p>\r\n<p>If you have any questions or problems please contact our team using the contact form.</p>\r\n<p>Enjoy the premium features and hack away!</p>', 'alpha_coins', 'Alpha Coins'),
('Secret Republic - Email Confirmation', '<p>Hello USERNAME,</p>\r\n<p>\r\nPlease access the following link to confirm your email address. You can do so by clicking it or copy-pasting into your browser\'s navigation bar.</p>\r\n<p>\r\n<strong>Confirmation link</strong><br/>\r\nCONFIRMATION_URL</p>\r\n\r\n', 'email_confirmation', 'Email confirmation'),
('Secret Republic - Account details retrieval', '<p>Dear USERNAME,</p>\r\n<p>\r\nA request for username and password recovery has been received for your account. If you believe this is a mistake please ignore this email.\r\n</p>\r\n<p>\r\nTo reset your password please access the following link. You can do so either by clicking it or copy-pasting into your browser\'s navigation bar.\r\n</p>\r\n<p>\r\n<strong>\r\nPassword reset link: RESET_URL\r\n</strong></p>\r\n<p>\r\nThis link will be valid for the next 48 hours.\r\n</p>\r\n', 'forgot_password', 'Forgot password'),
('Secret Republic - Your hacker account', '<p>Hello USERNAME,</p>\r\n\r\n<p>We\'ve been keen on meeting you for quite a while now. Welcome to the Secret Republic, the world of hackers.</p>\r\n\r\n<p>The Secret Republic has been, currently is and will be under active development with new things popping up all the time thanks to your feedback and suggestions.</p>\r\n\r\n<p>Use the contact option at the bottom of the site to give us feedback and report problems.</p>\r\n\r\n<p>\r\n<strong>Secret Republic is free to play. However, as you\'d expect, there are ways to improve gameplay above and beyond by getting <em>Alpha Coins</em> and opting for extra features.</strong></p>\r\n<p>\r\nThe Mission Notepad, Attack Simulator, Ad removal, Console History and Artificial Intelligence Entity voice extras will be automatically added to your account for your first few days.</p>\r\n\r\n<p>\r\nWe will be keeping a close eye on you, USERNAME.\r\n</p>\r\n\r\n<p>\r\nIs it good to be strong? Is it bad to be weak? You now have the weapons you need to engineer your destiny.</p>\r\n<br/>\r\n\r\nHacking means knowledge and knowledge means power. And great power no longer means great responsibilities.\r\n', 'welcome', 'Welcome email');

CREATE TABLE `faq_categories` (
  `cat_id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `faq_order` int(11) NOT NULL DEFAULT '0',
  `shortname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `faq_categories` (`cat_id`, `title`, `faq_order`, `shortname`) VALUES
(1, 'Servers', 0, 'servers'),
(2, 'Grid', 0, 'the-grid'),
(3, 'Skills', 0, 'skills');

CREATE TABLE `faq_questions` (
  `shortname` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `question` varchar(400) NOT NULL,
  `answer` text NOT NULL,
  `faq_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `faq_questions` (`shortname`, `cat_id`, `question`, `answer`, `faq_order`) VALUES
('about-nodes', 2, 'What are Nodes?', '<p><strong>Short</strong></p>\r\n<p>\r\nThe Grid is composed of Clusters which contain Nodes. You can own multiple nodes. The address of a node is referred to as [Zone:Cluster:Node]. You can obtain ownership of more nodes through specialised software on your servers. Change which node you are connected to on the Dashboard. While linked to a node you can see only operations concerning that node (attack, spying, scavenging, etc). If you loose all your nodes you lose the game.\r\n</p>\r\n<p>\r\n<strong>Long version</strong></p>\r\n<p>The Grid has multiple subdivisions.</p>\r\n<p>The first subdivision is made out of Clusters. Each zone has multiple clusters which in turn contain up to 10 nodes each. </p>\r\n<p>The location of a node is often shortened [Z:C:N] where Z is the Zone, C the cluster and N the Node.</p>\r\n<p>When you first join the competition you are given one Node on the Grid in your Zone.</p>\r\n<p>The action of taking ownership over a new node is called Node Instantiation and it can be achieved by installing software specific for this purpose on your servers, finding an empty node by browsing the Grid and sending your servers to do the job. There\'s of course chances you will fail depending on how powerful your software and will are.</p>\r\n<p>On the Dashboard you can Link/Connect to one of your nodes at a time. When connected to a node you can see the attacks sent from and to that node only.</p>\r\n<p>When launching an attack you use the same servers that you own no matter which node you are connected to but the receiver can only know about the node you sent the attack from.</p>\r\n<p>If at any point you lose all of your nodes, you lose the game.</p>\r\n<p>It is advised to own more than one node as in extreme situations they can be overcomed and Uninstantiated.</p>', 2),
('about-servers', 1, 'About servers', '<p>You are allowed to own an extra servers as you level up.</p> <p> <strong>Skill levels generated by apps of all servers contribute to your <a href=\"WEBSITE_URLgrid/layers/data\">Grid layers</a></strong> and components of all servers are <strong>susceptible to damage in <a href=\"WEBSITE_URLgrid\">Grid</a> battles</strong> and software can also suffer damage from Missions and Grid Battles.</p> <p>\r\n	The MAIN Server is your default in missions, to which you are logged on when disconnected from other machines, while non-main servers are available to bounce and DDOS through. \r\n	<strong>The skill levels of your main server are the only ones to contribute on top of your own <a href=\"WEBSITE_URLskills\">skills</a> in <a href=\"WEBSITE_URLquests\">missions</a></strong>. Changing the main while in a mission will not affect that instance.\r\n	</p>\r\n	Each server will earn you by default <strong><a href=\"WEBSITE_URLdata-points\">10 Data Points / hour</a></strong>. All servers mine for Data Points continuously.', 0),
('about-skills', 3, 'About Skills', '<p>Skills define and refine what it means to be you.</p>\r\n<p> <a href=\"WEBSITE_URLabilities\">Upgrade your abilities</a> as fast as you can to gain more skill points. Your skills are separate from server skills, which are per machine. \r\n	</p>\r\n<p>\r\n	 Skill levels contribute to <a href=\"WEBSITE_URLgrid/layers/show\">your security layers</a>, standing between you and the Grid. More so, they influence the duration and power of commands executed in <a href=\"WEBSITE_URLquests\">missions</a>.</p>\r\n<p>When attacking on the Grid, the skills of the servers you picked for the attack are added to your own skills in the context of that attack.</p>\r\nTo add Universal Skill Points to your Skills insert the number of points you want to assign for each skill in their individuals fields then remember to save the changes.\r\n', 0),
('attack-spy-scavenge', 2, 'Attacking, Spying, Scavenging?', '<p>When <strong>spying</strong> you will receive a report on the approximative skills, servers and general protection your target has. Thanks to the target\'s spy defense he might be notified of your mischievous attempt.</p> \r\n<p>You can also choose to <strong>attack</strong> a target. If you\'re powerful enough to get through layer 1 and layer 2 you will steal from your targets resources (money, <a href=\"WEBSITE_URLdata-points\">data points</a>) and either way you will most likely <strong>cause damage to his and your own hardware and software</strong>.</p> \r\n<p>You are allowed to pick which servers to use when attacking, but be careful. If you are attacked while the servers are busy with another task, they will not contribute to your defense.</p> <p>After a battle, there\'s a chance of <strong>floating Data Points</strong> to remain on the battle field. You can again use your servers, which will enter a busy state similar to the one for attacks, to <strong>scavenge</strong> these Data Points for your own use.</p>\r\n<p>You might also want to look into Node Instantiation otherwise known as claiming ownership over a node.</p>', 4),
('change-zone', 2, 'Can I change my zone?', '<p>Simple answer: no.</p>\r\n<p>You can own Nodes in other Zones but you cannot officially change your citizenship.</p>\r\n<p>You are to be forever loyal to your Zone.</p>', 9),
('damaged-software-hardware', 1, 'What happens when server software or hardware is damaged?', '<p>\r\nComponents and software will lose their attributes and require more resources as they get damaged. If the power source cannot sustain your configuration the <strong>server will become useless</strong> until broken components are replaced. As RAM lowers, running applications will be killed and as HDD decreases, apps will be <strong>deleted automatically</strong> and randomly.\r\n</p> <p>\r\nIf a <strong>component</strong> is 20% damaged it will have only 80% of its attributes available (e.g. 80% of RAM slots on a Motherboard).</p>\r\nIf an <strong>application</strong> is 20% damaged it will use 20%/2 more RAM and CPU, so 10% more of these resources, and will have only 80% of its skill points available.', 0),
('floating-data-points', 2, 'What are floating Data Points?', 'After a grid battle, there\'s a chance of floating Data Points to remain on the battle field. You can use your servers, which will enter a busy state similar to the one for attacks, to scavenge these Data Points for your own use.', 5),
('grid-layers', 2, 'Layers of protection', '<p>Your interaction with the grid is based mostly on your <strong><a href=\"WEBSITE_URLservers\">servers</a> and mighty <a href=\"WEBSITE_URLskills\">skills</a></strong>.</p> <p>You should get used ASAP to the <strong><a href=\"WEBSITE_URLrid/layers/show\">three layers of protection plus a spy layer</a></strong>, each with its own <strong>attack and defense properties based on the influence your skills and server skills</strong> have on them.</p> <p>You can analyse the influence your skills and server skills have on layers on the <strong><a href=\"WEBSITE_URLgrid/layers/show\">Layers interface</a></strong>.\r\n</p>\r\n<p>When you get to pick what servers to use in attacks, layers for that specific attack are generated based on your skills and the skills of the servers you have selected.</p>\r\n<p>Keep in mind that while your servers are in use they are not protecting you anymore.</p>\r\n', 3),
('history-of-the-grid', 2, 'How did the grid come to be?', '<p>\r\nThe Grid is a huge cluster of nodes reuniting all zones. Every node represents a participant in the competition with the world as a prize.\r\n</p> <p>\r\nBy scanning the grid, one can find alies and deal with enemies, tie friendships or destroy alliances.\r\n</p> <p>\r\nThe Grid was part of Alpha’s vision since the very beginning. Not only it provides safety and an easier life for citizens, but Alpha had to gain a lot from this whole deal as well. A huge citizenship databases ended up being created, containing DNA samples and fingerprints of the entire living population. \r\n</p> <p>\r\nSensors, cameras and various control systems have been placed in every single possible space and connected to the Grid network. It took the workers four years to deploy and configure the Grid, from year 2037 to 2041. If you wanted to find someone anywhere on the planet the Grid would be the ideal place to start your search with. Moreover, it ended up controlling everything from water pumps to electricity and zone borders. Every technology powered system became a node of the Grid.\r\n</p> <p>\r\nOn January 1st, 2041, the Grid Network officially went live. Zones had been activating their Grids all through year 2040, but the network wasn’t unified until 2041.\r\n</p> <p>\r\nThrough high level computations and numerous data centers spread across continents, the Grid can do DNA analysis and fingerprint matching in the global citizenship database on the fly, accurately matching them to their owner in the fraction of a second at failure rate so low it was ignored completely. </p>', 1);

CREATE TABLE `forum_posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `unparsed_content` text CHARACTER SET utf8,
  `created` int(11) DEFAULT NULL,
  `parent` int(11) UNSIGNED DEFAULT NULL,
  `fid` int(11) UNSIGNED NOT NULL,
  `replies` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `stick` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `forum_sections` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `closed` tinyint(4) NOT NULL,
  `description` varchar(500) NOT NULL,
  `ord` int(11) NOT NULL,
  `threads` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `forum_sections` (`id`, `parent`, `name`, `type`, `closed`, `description`, `ord`, `threads`) VALUES
(1, NULL, 'Headquarters', 2, 0, '', 0, 0),
(2, 1, 'News and updates', 1, 1, 'Latest happenings', 0, 0),
(3, NULL, 'TSR', 2, 0, '', 0, 0),
(4, 3, 'General discussions', 1, 0, 'None of us is as powerful as all of us', 2, 0),
(5, 3, 'Suggestions', 1, 0, 'Together we build the future', 99, 0),
(6, 3, 'Support', 1, 0, 'Alpha Corporation Support Center', 100, 0),
(7, 1, 'Introductions', 1, 0, 'Who are you hacker of the world?', 998, 0),
(9, 3, 'Guides, tips and tricks', 1, 0, 'United we stand, divided we fall', 3, 0),
(10, 1, 'Birthday', 1, 0, 'Tell us your birthday and be spammed with blessing', 999, 0),
(11, 1, 'Events', 1, 1, 'The title pretty much speaks for itself', 0, 0),
(14, 3, 'Organizations', 1, 0, 'Recruitment, challenges and other organizations related discussions', 2, 0),
(15, 3, 'Missions', 1, 0, 'Find help for puzzling missions.', 2, 0);

CREATE TABLE `friendships` (
  `id` int(11) NOT NULL,
  `user1id` int(11) NOT NULL,
  `user2id` int(11) NOT NULL,
  `date` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `friend_requests` (
  `request_id` int(11) NOT NULL,
  `senderid` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `receiverid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `groups` (
  `group_id` smallint(6) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `view_debug` tinyint(1) DEFAULT NULL,
  `wikiManager` tinyint(1) DEFAULT NULL,
  `questManager` tinyint(1) DEFAULT NULL,
  `userList` tinyint(1) DEFAULT NULL,
  `cardinal` tinyint(1) DEFAULT NULL,
  `instant_tasks` tinyint(1) DEFAULT NULL,
  `manageUsers` tinyint(1) DEFAULT NULL,
  `manageDuality` tinyint(1) DEFAULT NULL,
  `adminNav` tinyint(1) DEFAULT NULL,
  `manageAchievements` tinyint(1) DEFAULT NULL,
  `dailyRep` tinyint(1) DEFAULT '1',
  `maxBlogs` tinyint(2) DEFAULT '2',
  `levelManager` tinyint(1) NOT NULL,
  `dataManager` tinyint(1) DEFAULT NULL,
  `forumManager` tinyint(1) NOT NULL DEFAULT '0',
  `globalQuestManager` tinyint(4) NOT NULL DEFAULT '0',
  `emailTemplatesManager` tinyint(1) NOT NULL DEFAULT '0',
  `noRank` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `groups` (`group_id`, `name`, `view_debug`, `wikiManager`, `questManager`, `userList`, `cardinal`, `instant_tasks`, `manageUsers`, `manageDuality`, `adminNav`, `manageAchievements`, `dailyRep`, `maxBlogs`, `levelManager`, `dataManager`, `forumManager`, `globalQuestManager`, `emailTemplatesManager`, `noRank`) VALUES
(1, 'Alpha CEO (Admin)', 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 4, 127, 1, 1, 1, 1, 1, 1),
(2, 'Hacker', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, NULL, 0, 0, 0, 0),
(10, '(MM) Mission Manager', 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 4, 2, 0, 0, 0, 0, 0, 0),
(11, 'Alpha Advisor (S.Mod)', 0, 0, 1, 1, 0, 1, 0, 0, 1, 1, 4, 3, 1, 0, 1, 1, 1, 0);

CREATE TABLE `hackdown_arena` (
  `arena_id` int(11) NOT NULL,
  `hackdown_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `attack_log_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `servers` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `hackdown_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `quest_id` int(11) DEFAULT NULL,
  `task_log_id` int(11) DEFAULT NULL,
  `hackdown_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `hackdown_rankings_organizations` (
  `ranking_id` int(11) NOT NULL,
  `org_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `hackdown_id` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `hackdown_rankings_users` (
  `ranking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hackdown_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `hackdown_rankings_zones` (
  `ranking_id` int(11) NOT NULL,
  `zone` tinyint(1) DEFAULT NULL,
  `hackdown_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `hacker_quotes` (
  `quote_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quote` varchar(300) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `source` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `hacker_quotes` (`quote_id`, `user_id`, `quote`, `author`, `created`, `visible`, `source`) VALUES
(1, 1559, 'If at first you don&rsquo;t succeed; call it version 1.0.', NULL, 1395571548, 1, NULL),
(2, 1559, 'My software never has bugs. It just develops random features.', NULL, 1395571548, 1, NULL),
(3, 1559, 'I would love to change the world, but they won&rsquo;t give me the source code.', NULL, 1395571548, 1, NULL),
(4, 1559, 'The code that is the hardest to debug is the code that you know cannot possibly be wrong.', NULL, 1395571548, 1, NULL),
(5, 1559, 'Beware of programmers that carry screwdrivers.', NULL, 1395571548, 1, NULL),
(6, 1559, 'Programming today is a race between software engineers striving to build bigger and better idiot-proof programs, and the Universe trying to produce bigger and better idiots. So far, the Universe is winning.', NULL, 1395571548, 1, NULL),
(7, 1559, 'The beginning of the programmer&rsquo;s wisdom is understanding the difference between getting program to run and having a runnable program.', NULL, 1395571548, 1, NULL),
(8, 1559, 'I&rsquo;m not anti-social; I&rsquo;m just not user friendly.', NULL, 1395571548, 1, NULL),
(9, 1559, 'If Ruby is not and Perl is the answer, you don&rsquo;t understand the question.', NULL, 1395571548, 1, NULL),
(10, 1559, 'COBOL programmers understand why women hate periods.', NULL, 1395571548, 1, NULL),
(11, 1559, 'If you give someone a program, you will frustrate them for a day; if you teach them how to program, you will frustrate them for a lifetime.', NULL, 1395571548, 1, NULL),
(12, 1559, 'Programmers are tools for converting caffeine into code.', NULL, 1395571548, 1, NULL),
(13, 1559, 'My attitude isn&rsquo;t bad. It&rsquo;s in beta.', NULL, 1395571548, 1, NULL),
(14, 1559, 'Why do programmers confuse Christmas with Halloween? Because Dec 25 = Oct 31', NULL, 1395571548, 1, NULL),
(15, 1559, 'The box said &lsquo;Requires Windows Vista or better&rsquo;. So I installed LINUX.', NULL, 1395571548, 1, NULL),
(16, 1559, 'UNIX is basically a simple operating system, but you have to be a genius to understand the simplicity.', NULL, 1395571548, 1, NULL),
(17, 1559, 'In a world without fences and walls, who needs Gates and Windows?', NULL, 1395571548, 1, NULL),
(18, 1559, 'Bugs come in through open Windows.', NULL, 1395571548, 1, NULL),
(19, 1559, 'Penguins love cold, they wont survive the sun.', NULL, 1395571548, 1, NULL),
(20, 1559, 'Unix is user friendly. It&rsquo;s just selective about who its friends are.', NULL, 1395571548, 1, NULL),
(21, 1559, 'Failure is not an option. It comes bundled with your Microsoft product.', NULL, 1395571548, 1, NULL),
(22, 1559, 'NT is the only OS that has caused me to beat a piece of hardware to death with my bare hands.', NULL, 1395571548, 1, NULL),
(23, 1559, 'My daily Unix command list: unzip; strip; touch; finger; mount; fsck; more; yes; unmount; sleep.', NULL, 1395571548, 1, NULL),
(24, 1559, 'Microsoft: &ldquo;You&rsquo;ve got questions. We&rsquo;ve got dancing paperclips.&rdquo;', NULL, 1395571548, 1, NULL),
(25, 1559, 'Windows isn&rsquo;t a virus, viruses do something.', NULL, 1395571548, 1, NULL),
(26, 1559, 'Computers are like air conditioners: they stop working when you open Windows.', NULL, 1395571548, 1, NULL),
(27, 1559, 'Mac users swear by their Mac, PC users swear at their PC.', NULL, 1395571548, 1, NULL),
(28, 1559, 'The truth is out there. Anybody got the URL?', NULL, 1395571548, 1, NULL),
(29, 1559, 'The Internet: where men are men, women are men, and children are FBI agents.', NULL, 1395571548, 1, NULL),
(30, 1559, 'Some things Man was never meant to know. For everything else, there&rsquo;s Google.', NULL, 1395571548, 1, NULL),
(31, 1559, 'The definition of an upgrade: Take old bugs out, put new ones in.', NULL, 1395571548, 1, NULL),
(32, 1559, 'To error is human, but for a real disaster you need a computer.', NULL, 1395571548, 1, NULL),
(33, 1559, 'You make my software turn to hardware!', NULL, 1395571548, 1, NULL),
(34, 1559, 'You think you know when you learn, are more sure when you can write, even more when you can teach, but certain when you can program.', NULL, 1395571548, 1, NULL),
(35, 1559, 'There are only 10 types of people in the world: those that understand binary and those that don&rsquo;t.', NULL, 1395571548, 1, NULL),
(36, 1559, 'Computers make very fast, very accurate mistakes.', NULL, 1395571548, 1, NULL),
(37, 1559, 'Be nice to the nerds, for all you know they might be the next Bill Gates!', NULL, 1395571548, 1, NULL),
(38, 1559, 'Artificial intelligence usually beats real stupidity.', NULL, 1395571548, 1, NULL),
(39, 1559, 'To err is human &ndash; and to blame it on a computer is even more so.', NULL, 1395571548, 1, NULL),
(40, 1559, 'CAPS LOCK &ndash; Preventing Login Since 1980.', NULL, 1395571548, 1, NULL),
(41, 1559, '2 + 2 = 5, for extremely large values of 2.', NULL, 1395571548, 1, NULL),
(42, 1559, 'Do you program in Assembly? she asked. NOP, he said.', NULL, 1395571548, 1, NULL),
(43, 1559, 'Enter any 11-digit prime number to continue.', NULL, 1395571548, 1, NULL),
(44, 1559, 'E-mail returned to sender, insufficient voltage.', NULL, 1395571548, 1, NULL),
(45, 1559, 'All wiyht. Rho sritched mg kegtops awound?', NULL, 1395571548, 1, NULL),
(46, 1559, 'Black holes are where God divided by zero.', NULL, 1395571548, 1, NULL),
(47, 1559, 'If I wanted a warm fuzzy feeling, I&rsquo;d antialias my graphics!', NULL, 1395571548, 1, NULL),
(48, 1559, 'If brute force doesn&rsquo;t solve your problems, then you aren&rsquo;t using enough.', NULL, 1395571548, 1, NULL),
(49, 1559, 'Evolution is God&rsquo;s way of issuing upgrades.', NULL, 1395571548, 1, NULL),
(50, 1559, 'Linus Torvalds: &ldquo;Real men don&rsquo;t use backups, they post their stuff on a public ftp server and let the rest of the world make copies.&rdquo;', NULL, 1395571548, 1, NULL),
(51, 1559, 'Hacking is like sex. You get in, you get out, and hope that you didn&rsquo;t leave something that can be traced back to you.', NULL, 1395571548, 1, NULL),
(52, 1559, 'A computer makes as many mistakes in one second as three men working for thirty years straight.', NULL, 1395571548, 1, NULL),
(53, 1559, 'A computer program does what you tell it to do, not what you want it to do.', NULL, 1395571548, 1, NULL),
(54, 1559, 'A computer program will always do what you tell it to do, but rarely what you want to do.', NULL, 1395571548, 1, NULL),
(55, 1559, 'A computer scientist is someone who fixes things that aren&rsquo;t broken.', NULL, 1395571548, 1, NULL),
(56, 1559, 'Compute Science is the closes thing we have to a super power.', NULL, 1395571548, 1, NULL),
(57, 1559, 'A misplaced decimal point will always end up where it will do the greatest damage.', NULL, 1395571548, 1, NULL),
(58, 1559, 'According to my calculations, this problem doesn&rsquo;t exist.', NULL, 1395571548, 1, NULL),
(59, 1559, 'As a computer, I find your faith in technology amusing.', NULL, 1395571548, 1, NULL),
(60, 1559, 'As far as the laws of mathematics refer to reality, they are not certain, and as far as they are certain, they do not refer to reality.', NULL, 1395571548, 1, NULL),
(61, 1559, 'Programmers are tools for converting caffeine into code.', NULL, 1395571548, 1, NULL),
(62, 1559, 'If brute force doesn&rsquo;t solve your problems, then you aren&rsquo;t using enough.', NULL, 1395571548, 1, NULL),
(63, 1559, 'If builders built buildings the way programmers write programs, then the first woodpecker that came along would destroy civilization.', NULL, 1395571548, 1, NULL),
(64, 1559, 'Before software can be reusable it first has to be usable.', NULL, 1395571548, 1, NULL),
(65, 1559, 'Computers are unreliable, but humans are even more.', NULL, 1395571548, 1, NULL),
(66, 1559, 'Computers do not solve problems, they execute solutions.', NULL, 1395571548, 1, NULL),
(67, 1559, 'Computers make very fast, very accurate mistakes.', NULL, 1395571548, 1, NULL),
(68, 1559, 'File not found. Should I fake it? (Y/N)', NULL, 1395571548, 1, NULL),
(69, 1559, 'If debugging is the process of removing software bugs, then programming must be the process of putting them in.', NULL, 1395571548, 1, NULL),
(70, 1559, 'If you torture the data enough, it will confess.', NULL, 1395571548, 1, NULL),
(71, 1559, 'There are three kinds of people: those who can count and those who can&rsquo;t.', NULL, 1395571548, 1, NULL),
(72, 1559, 'Latest survey shows that 3 out of 4 people make up 75% of the world&rsquo;s population.', NULL, 1395571548, 1, NULL),
(73, 1559, 'Hand over the calculator, friends don&rsquo;t let friends derive drunk.', NULL, 1395571548, 1, NULL),
(74, 1559, 'An infinite crowd of mathematicians enters a bar. The first one orders a  pint, the second one a half pint, the third one a quarter pint&hellip; &ldquo;I  understand&rdquo;, says the bartender &ndash; and pours two pints.', NULL, 1395571548, 1, NULL),
(75, 1559, 'It is not the computer\'s fault that Maxwell\'s equations are not adequate to design the electric motor.', 'Alan J. Perlis', 1395571730, 1, 'hackersays.com'),
(76, 1559, 'I do not fear computers. I fear the lack of them.', 'Isaac Asimov', 1395571730, 1, 'hackersays.com'),
(77, 1559, 'Measuring programming progress by lines of code is like measuring aircraft building progress by weight.', 'Bill Gates', 1395571730, 1, 'hackersays.com'),
(78, 1559, 'Organizations which design systems are constrained to produce designs which are copies of the communication structures of these organizations.', 'Conway\'s Law', 1395571730, 1, 'hackersays.com'),
(79, 1559, 'If you\'ve seen one picture of the Mandelbrot Set, you\'ve seen them all.', 'Bill Karwin', 1395571730, 1, 'hackersays.com'),
(80, 1559, 'You\'re never done, you just run out of time.', 'Anonymous', 1395571730, 1, 'hackersays.com'),
(81, 1559, 'We kid ourselves if we think that the ratio of procedure to data in an active data-base system can be made arbitrarily small or even kept small.', 'Alan J. Perlis', 1395571730, 1, 'hackersays.com'),
(82, 1559, 'The more bizarre the behavior, the more stupid the mistake.', 'Ed\'s Law of Debugging', 1395571730, 1, 'hackersays.com'),
(83, 1559, 'Multi-threading is the art of screwing things up before, during or after something else.', 'Anonymous', 1395571730, 1, 'hackersays.com'),
(84, 1559, 'You think you know when you can learn, are more sure when you can write, even more when you can teach, but certain when you can program.', 'Alan J. Perlis', 1395571735, 1, 'hackersays.com'),
(85, 1559, 'Good judgement is the result of experience ... Experience is the result of bad judgement.', 'Fred Brooks', 1395571735, 1, 'hackersays.com'),
(86, 1559, 'Intellectuals solve problems; geniuses prevent them.', 'Albert Einstein', 1395571735, 1, 'hackersays.com'),
(87, 1559, 'This is important, and a little hard to understand. English is useful because it\'s a mess. Since English is a mess, it maps well onto the problem space, which is also a mess, which we call reality. Similarly, Perl was designed to be a mess (though in the nicest of possible ways).', 'Larry Wall', 1395571735, 1, 'hackersays.com'),
(88, 1559, 'Never underestimate the disparity between developer excitement and user apathy.', 'Anonymous', 1395571735, 1, 'hackersays.com'),
(89, 1559, 'Around computers it is difficult to find the correct unit of time to measure progress. Some cathedrals took a century to complete. Can you imagine the grandeur and scope of a program that would take as long?', 'Alan J. Perlis', 1395571735, 1, 'hackersays.com'),
(90, 1559, 'I was a C++ programmer before I started designing Ruby. I programmed in C++ exclusively for two or three years. And after two years of C++ programming, it still surprised me.', 'Matz', 1395571735, 1, 'hackersays.com'),
(91, 1559, 'Tell me what you need and I\'ll tell you how to get along without it.', 'Anonymous', 1395571735, 1, 'hackersays.com'),
(92, 1559, 'One does not learn computing by using a hand calculator, but one can forget arithmetic.', 'Alan J. Perlis', 1395571735, 1, 'hackersays.com'),
(93, 1559, '... what society overwhelmingly asks for is snake oil. Of course, the snake oil has the most impressive names &mdash; otherwise you would be selling nothing &mdash; like &quot;Structured Analysis and Design&quot;, &quot;Software Engineering&quot;, &quot;Maturity Models&quot;, &quot;Management Inform', 'Edsger W. Dijkstra', 1395571735, 1, 'hackersays.com'),
(94, 1559, 'Think twice before you start programming or you will program twice before you start thinking.', 'Anonymous', 1395571737, 1, 'hackersays.com'),
(95, 1559, 'Ready, fire, aim: the fast approach to software development.&lt;br&gt;Ready, aim, aim, aim, aim: the slow approach to software development. &lt;br&gt;', 'Anonymous', 1395571737, 1, 'hackersays.com'),
(96, 1559, 'The idea that I can be presented with a problem, set out to logically solve it with the tools at hand, and wind up with a program that could not be legally used because someone else followed the same logical steps some years ago and filed for a patent on it is horrifying.', 'John Carmack on software patents', 1395571738, 1, 'hackersays.com'),
(97, 1559, 'I went to school to learn how to program software applications, which inevitably have bug defects. There was no course at my university on testing, debugging, profiling, or optimization. These things you have to learn on your own, usually in a tight deadline.', 'Juixe TechKnow', 1395571738, 1, 'hackersays.com'),
(98, 1559, 'Hardware is the part of a system you can kick. Software is the one you can only curse at.', 'Anonymous', 1395571738, 1, 'hackersays.com'),
(99, 1559, 'FORTRAN is not a flower but a weed &mdash; it is hardy, occasionally blooms, and grows in every computer.', 'Alan J. Perlis', 1395571738, 1, 'hackersays.com'),
(100, 1559, 'Memory is like an orgasm. It\'s a lot better if you don\'t have to fake it.', 'Seymour Cray on virtual memory', 1395571738, 1, 'hackersays.com');

CREATE TABLE `level_rewards` (
  `level_id` int(11) NOT NULL,
  `money` int(11) DEFAULT NULL,
  `achievement_id` varchar(45) DEFAULT NULL,
  `skillPoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `level_rewards` (`level_id`, `money`, `achievement_id`, `skillPoints`) VALUES
(2, 100, '2', 5),
(3, 100, '0', 6);

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  `created` int(11) DEFAULT NULL,
  `lastUpdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '',
  `intro` text CHARACTER SET utf8 NOT NULL,
  `memb_intro` text CHARACTER SET utf8 NOT NULL,
  `app_intro` text CHARACTER SET utf8 NOT NULL,
  `nrm` int(11) NOT NULL DEFAULT '1',
  `created` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `orank` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `applications` int(11) NOT NULL DEFAULT '0',
  `allow_app` tinyint(1) NOT NULL DEFAULT '1',
  `max_nrm` int(11) NOT NULL DEFAULT '10',
  `hacking_points` int(11) NOT NULL DEFAULT '0',
  `wars_inprogress` int(11) NOT NULL DEFAULT '0',
  `wars` int(11) NOT NULL DEFAULT '0',
  `wars_won` int(11) NOT NULL DEFAULT '0',
  `tag` varchar(4) DEFAULT NULL,
  `intro_unparsed` text CHARACTER SET utf8,
  `memb_intro_unparsed` text CHARACTER SET utf8,
  `app_intro_unparsed` text CHARACTER SET utf8,
  `level` int(11) DEFAULT '1',
  `exp` int(11) DEFAULT '0',
  `expNext` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `organizations` (`id`, `name`, `intro`, `memb_intro`, `app_intro`, `nrm`, `created`, `owner`, `orank`, `points`, `applications`, `allow_app`, `max_nrm`, `hacking_points`, `wars_inprogress`, `wars`, `wars_won`, `tag`, `intro_unparsed`, `memb_intro_unparsed`, `app_intro_unparsed`, `level`, `exp`, `expNext`) VALUES
(98, 'Zone 1 Beginner Org', 'This organization is for hackers who have just joined the competition.<br />\n<br />\nTo help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has created beginner organizations for each zone.<br />\n<br />\nYou can leave at any time and we urge you to do so to find or create your own organization.<br />\n<br />\nThis organization is not ranked and shall not improve your ranking.<br />\n<br />\nAfter a while, the Cardinal System will kick you out of the Beginner Organization automatically.', 'There\'s an organization private forum and a private chat you can use to get help when needed.<br />\n<br />\nFeel free to leave at any time and remember this organization is not ranked and as such does not contribute to your own rank as any normal ones would.<br />\n<br />\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 1, 1406528737, 1, 0, 0, 1490, 0, 10000, 3622, 0, 0, 0, 'BEG1', 'This organization is for hackers who have just joined the competition.\r\n\r\nTo help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has created beginner organizations for each zone.\r\n\r\nYou can leave at any time and we urge you to do so to find or create your own organization.\r\n\r\nThis organization is not ranked and shall not improve your ranking.\r\n\r\nAfter a while, the Cardinal System will kick you out of the Beginner Organization automatically.', 'There\'s an organization private forum and a private chat you can use to get help when needed.\r\n\r\nFeel free to leave at any time and remember this organization is not ranked and as such does not contribute to your own rank as any normal ones would.\r\n\r\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 16, 0, 340),
(100, 'Zone 2 Beginner Org', 'This organization is for hacker who have just joined the competition started by Alpha not so long ago.<br />\n<br />\nTo better help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has create beginner organization for each zones.<br />\n<br />\n<b>You can leave at any time and we urge you to do so and find or create your own organization</b><br />\n<br />\n<span style=\"color:red\">This organization is not ranked and shall not improve your ranking.</span>', 'There\'s an organization private forum and a private chat you can use to get help when needed.<br />\n<br />\nFeel free to leave at any time and remember this organization is not rank and as such does not contribute to your rank as any other would usually do.<br />\n<br />\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 1, 1406609992, 1, 0, 0, 563, 0, 10000, 1840, 0, 0, 0, 'BEG2', 'This organization is for hacker who have just joined the competition started by Alpha not so long ago.\r\n\r\nTo better help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has create beginner organization for each zones.\r\n\r\n[b]You can leave at any time and we urge you to do so and find or create your own organization[/b]\r\n\r\n[color=red]This organization is not ranked and shall not improve your ranking.[/color]', 'There\'s an organization private forum and a private chat you can use to get help when needed.\r\n\r\nFeel free to leave at any time and remember this organization is not rank and as such does not contribute to your rank as any other would usually do.\r\n\r\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 11, 148, 240),
(101, 'Zone 3 Beginner Org', 'This organization is for hacker who have just joined the competition started by Alpha not so long ago.<br />\n<br />\nTo better help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has create beginner organization for each zones.<br />\n<br />\n<b>You can leave at any time and we urge you to do so and find or create your own organization</b><br />\n<br />\n<span style=\"color:red\">This organization is not ranked and shall not improve your ranking.</span>', 'There\'s an organization private forum and a private chat you can use to get help when needed.<br />\n<br />\nFeel free to leave at any time and remember this organization is not rank and as such does not contribute to your rank as any other would usually do.<br />\n<br />\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 1, 1406610042, 1, 0, 0, 842, 0, 10000, 2552, 0, 0, 0, 'BEG3', 'This organization is for hacker who have just joined the competition started by Alpha not so long ago.\r\n\r\nTo better help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has create beginner organization for each zones.\r\n\r\n[b]You can leave at any time and we urge you to do so and find or create your own organization[/b]\r\n\r\n[color=red]This organization is not ranked and shall not improve your ranking.[/color]', 'There\'s an organization private forum and a private chat you can use to get help when needed.\r\n\r\nFeel free to leave at any time and remember this organization is not rank and as such does not contribute to your rank as any other would usually do.\r\n\r\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 12, 166, 260),
(102, 'Zone 4 Beginner Org', 'This organization is for hacker who have just joined the competition started by Alpha not so long ago.<br />\n<br />\nTo better help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has create beginner organization for each zones.<br />\n<br />\n<b>You can leave at any time and we urge you to do so and find or create your own organization</b><br />\n<br />\n<span style=\"color:red\">This organization is not ranked and shall not improve your ranking.</span>', 'There\'s an organization private forum and a private chat you can use to get help when needed.<br />\n<br />\nFeel free to leave at any time and remember this organization is not rank and as such does not contribute to your rank as any other would usually do.<br />\n<br />\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 1, 1406610080, 1, 0, 0, 437, 0, 10000, 2090, 0, 0, 0, 'BEG4', 'This organization is for hacker who have just joined the competition started by Alpha not so long ago.\r\n\r\nTo better help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has create beginner organization for each zones.\r\n\r\n[b]You can leave at any time and we urge you to do so and find or create your own organization[/b]\r\n\r\n[color=red]This organization is not ranked and shall not improve your ranking.[/color]', 'There\'s an organization private forum and a private chat you can use to get help when needed.\r\n\r\nFeel free to leave at any time and remember this organization is not rank and as such does not contribute to your rank as any other would usually do.\r\n\r\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 11, 227, 240),
(103, 'Zone 5 Beginner Org', 'This organization is for hackers who have just joined the competition.<br />\n<br />\nTo help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has created beginner organizations for each zone.<br />\n<br />\nYou can leave at any time and we urge you to do so to find or create your own organization.<br />\n<br />\nThis organization is not ranked and shall not improve your ranking.<br />\n<br />\nAfter a while, the Cardinal System will kick you out of the Beginner Organization automatically.', 'There\'s an organization private forum and a private chat you can use to get help when needed.<br />\n<br />\nFeel free to leave at any time and remember this organization is not ranked and as such does not contribute to your own rank as any normal ones would.<br />\n<br />\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 1, 1406610140, 1, 0, 0, 479, 0, 10000, 1811, 0, 0, 0, 'BEG4', 'This organization is for hackers who have just joined the competition.\r\n\r\nTo help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has created beginner organizations for each zone.\r\n\r\nYou can leave at any time and we urge you to do so to find or create your own organization.\r\n\r\nThis organization is not ranked and shall not improve your ranking.\r\n\r\nAfter a while, the Cardinal System will kick you out of the Beginner Organization automatically.', 'There\'s an organization private forum and a private chat you can use to get help when needed.\r\n\r\nFeel free to leave at any time and remember this organization is not ranked and as such does not contribute to your own rank as any normal ones would.\r\n\r\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 10, 102, 220),
(104, 'Zone 6 Beginner Org', 'This organization is for hackers who have just joined the competition.<br />\n<br />\nTo help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has created beginner organizations for each zone.<br />\n<br />\nYou can leave at any time and we urge you to do so to find or create your own organization.<br />\n<br />\nThis organization is not ranked and shall not improve your ranking.<br />\n<br />\nAfter a while, the Cardinal System will kick you out of the Beginner Organization automatically.', 'There\'s an organization private forum and a private chat you can use to get help when needed.<br />\n<br />\nFeel free to leave at any time and remember this organization is not ranked and as such does not contribute to your own rank as any normal ones would.<br />\n<br />\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 1, 1406610157, 1, 0, 0, 338, 0, 10000, 1871, 0, 0, 0, 'BEG6', 'This organization is for hackers who have just joined the competition.\r\n\r\nTo help them integrate in the existing community and become aware that they are not alone in the fight for power, Alpha has created beginner organizations for each zone.\r\n\r\nYou can leave at any time and we urge you to do so to find or create your own organization.\r\n\r\nThis organization is not ranked and shall not improve your ranking.\r\n\r\nAfter a while, the Cardinal System will kick you out of the Beginner Organization automatically.', 'There\'s an organization private forum and a private chat you can use to get help when needed.\r\n\r\nFeel free to leave at any time and remember this organization is not ranked and as such does not contribute to your own rank as any normal ones would.\r\n\r\nMoreover, we do not take part in wars. Only occasionally between us and other beginner organizations.', '', 12, 16, 260);


CREATE TABLE `organization_members_logs` (
  `log_id` int(11) NOT NULL,
  `joined_date` int(11) DEFAULT NULL,
  `left_date` int(11) DEFAULT NULL,
  `org_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `kicked` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `org_applications` (
  `id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `org_ended_wars` (
  `war_id` int(11) NOT NULL,
  `org1_id` int(11) NOT NULL,
  `org2_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `finished` int(11) NOT NULL,
  `org1_points` int(11) NOT NULL,
  `org2_points` int(11) NOT NULL,
  `winner_org_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `org_forum_posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `unparsed_content` text CHARACTER SET utf8,
  `created` int(11) DEFAULT NULL,
  `parent` int(10) UNSIGNED DEFAULT NULL,
  `fid` int(11) UNSIGNED NOT NULL,
  `replies` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `org` int(11) DEFAULT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `stick` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `org_forum_sections` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `threads` int(11) NOT NULL DEFAULT '0',
  `closed` tinyint(4) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `ord` int(11) DEFAULT NULL,
  `org` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `org_hacking_points_logs` (
  `log_id` int(11) NOT NULL,
  `created` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `org_id` int(11) DEFAULT NULL,
  `hackingPoints` int(11) DEFAULT NULL,
  `source_type` int(11) DEFAULT NULL,
  `task_log_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `org_ranks` (
  `rank_id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `org_id` int(11) NOT NULL,
  `default_rank` tinyint(1) NOT NULL DEFAULT '0',
  `owner_rank` tinyint(1) NOT NULL DEFAULT '0',
  `viewMembers` tinyint(1) NOT NULL DEFAULT '1',
  `manageMembers` tinyint(1) NOT NULL DEFAULT '0',
  `manageRanks` tinyint(1) NOT NULL DEFAULT '0',
  `manageOrganization` tinyint(1) NOT NULL DEFAULT '0',
  `messageAll` tinyint(1) NOT NULL DEFAULT '0',
  `manageApplications` tinyint(1) NOT NULL DEFAULT '0',
  `manageWars` tinyint(1) NOT NULL DEFAULT '0',
  `forumManager` tinyint(1) NOT NULL DEFAULT '0',
  `manageHackingPoints` tinyint(1) NOT NULL DEFAULT '0',
  `rank_order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `org_wars` (
  `war_id` int(11) UNSIGNED NOT NULL,
  `org1_id` int(11) DEFAULT NULL,
  `org2_id` int(11) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `org1_points` int(11) NOT NULL DEFAULT '0',
  `org2_points` int(11) NOT NULL DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `ends` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `org_war_requests` (
  `request_id` int(11) NOT NULL,
  `from_org_id` int(11) NOT NULL,
  `to_org_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `reason` varchar(500) NOT NULL,
  `created` int(11) NOT NULL,
  `answer_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `org_zone_beginners` (
  `id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `zone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `org_zone_beginners` (`id`, `org_id`, `zone`) VALUES
(1, 98, 1),
(2, 100, 2),
(3, 101, 3),
(4, 102, 4),
(5, 103, 5),
(6, 104, 6);

CREATE TABLE `parties` (
  `party_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `global_chat_active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `party_invitations` (
  `invitation_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `party_quest_instances` (
  `instance_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `data` text CHARACTER SET utf8 NOT NULL,
  `quest_id` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `totalSeconds` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `quests` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT '',
  `level` int(11) DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '300',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `creatorid` int(11) DEFAULT NULL,
  `isLive` tinyint(1) DEFAULT '0',
  `isLocked` tinyint(1) DEFAULT '0',
  `qgroup_id` int(11) DEFAULT NULL,
  `achievement_id` int(11) NOT NULL DEFAULT '0',
  `summary` text,
  `money` int(11) NOT NULL DEFAULT '30',
  `experience` int(11) DEFAULT NULL,
  `skillPoints` int(11) NOT NULL DEFAULT '3',
  `energy` int(11) DEFAULT NULL,
  `required_quest_id` int(11) NOT NULL DEFAULT '0',
  `qgroup_order` int(11) NOT NULL,
  `creator_name` varchar(100) NOT NULL,
  `party` tinyint(1) NOT NULL DEFAULT '0',
  `creatorsNotepad` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `quests` (`id`, `title`, `level`, `time`, `type`, `creatorid`, `isLive`, `isLocked`, `qgroup_id`, `achievement_id`, `summary`, `money`, `experience`, `skillPoints`, `energy`, `required_quest_id`, `qgroup_order`, `creator_name`, `party`, `creatorsNotepad`) VALUES
(1, 'The world within the Grid', 0, 300, 0, 1564, 0, 0, 1, 0, NULL, 30, NULL, 3, NULL, 0, 0, 'Cardinal', 0, NULL),
(8, 'Test New Objectives', 1, 12, 0, 38, 1, 0, 1, 2, NULL, 30, 0, 3, NULL, 0, 0, '', 0, NULL),
(10, 'Test if completed', 3, 1, 1, 38, 1, 0, 1, 2, NULL, 30, 0, 3, NULL, 0, 0, '', 0, NULL),
(11, 'asdf', 1, 1, 0, 38, 0, 0, 1, 2, NULL, 30, 0, 3, NULL, 0, 0, '', 0, NULL),
(20, 'Full Test Quest', 2, 200, 1, 1559, 0, 0, 8, 2, 'Test\r\n[color=red]Test[/color]', 100, 100, 3, 0, 0, 0, 'asf', 0, 'test2'),
(22, 'Decrypter 1', 1, 10, 0, 1564, 1, 0, 4, 0, '', 30, 0, 3, 0, 0, 1, 'Cardinal', 0, NULL),
(23, 'Decrypter 2', 1, 13, 0, 1564, 1, 0, 4, 0, '', 30, 0, 3, 0, 0, 1, 'Cardinal', 0, NULL),
(25, 'Crystal clear', 1, 15, 0, 1564, 1, 0, 12, 0, 'A girl slowly approached me. She doesn’t look older than I am. I can’t feel the black floor keeping us from falling and when I glanced around I saw nothing, only darkness. ', 30, 0, 5, 0, 0, 0, 'Cardinal', 0, NULL),
(29, 'Ember Iris', 2, 30, 0, 1564, 1, 0, 12, 0, 'At exactly 01:00 AM, standard time, the third planet from the Sun went silent....\r\n', 150, 150, 5, 0, 25, 1, 'Cardinal', 0, NULL),
(32, 'Into the Iris', 4, 40, 0, 1564, 1, 0, 12, 0, 'The expected day is upon us. It\'s time to go where only few have been before. The Iris will open.\r\nBETA MISSION: Please report on forums any problems.', 300, 300, 9, 0, 29, 2, 'Cardinal', 0, NULL),
(33, 'Dealing with files && SSH Services', 1, 20, 2, 1564, 1, 0, 15, 0, 'The Alpha Computer Science Crash Course presents you a lesson on managing files using the Cardinal console, an essential ability to any Computer Scientist and competitor in the challenge we know is in all of our hearts and minds.', 50, 40, 3, 0, 70, 10, 'Cardinal', 0, NULL),
(34, 'You got mail', 1, 15, 2, 1564, 1, 0, 15, 0, 'Email is still largely used even in our days. It\'s important to know how the protocols that make it tick work. ', 150, 50, 3, 0, 35, 30, 'Cardinal', 0, NULL),
(35, 'SSH and cracking security', 1, 15, 2, 1564, 1, 0, 15, 0, 'Hackers aren\'t devils. They aren\'t angels either. They are humans and they are the best of both sides. They are perhaps a necessary evil. They are the doctors of Computer Science. In order to fight them you need to join them so we\'ll take a sneak peek into at just how we can get through security systems.', 100, 70, 3, 0, 33, 20, 'Cardinal', 0, NULL),
(36, 'Cry Me A River', 4, 20, 0, 2195, 1, 0, 16, 0, 'Last night our server got hacked... we want to stage a comeback! Have you got the right skills for the task?', 200, 40, 3, 40, 0, 0, 'HaZaMaT', 0, NULL),
(37, 'SO WE MEET AGAIN...', 1, 10, 0, 2417, 0, 0, 17, 0, 'This is not what you think...', 30, 0, 3, 0, 0, 0, 'hellblazer17', 0, NULL),
(38, 'Mission 1', 1, 15, 0, 1564, 1, 0, 6, 0, '', 30, 0, 3, 0, 0, 0, 'Cardinal', 0, NULL),
(39, 'SELECT * FROM WORLD', 2, 17, 2, 1564, 1, 0, 15, 0, 'We come across databases everywhere and anywhere. We just fail to notice the way computers need to think to do what they do. Today\'s course teaches us the very basic of manipulating a database server running on Cardinal OS.', 200, 111, 5, 0, 34, 40, 'Cardinal', 0, NULL),
(40, 'An unexpected contract', 3, 10, 0, 1564, 1, 0, 18, 0, 'An unknown entity unexpectedly makes contact with you with a shady proposal.', 100, 83, 3, 0, 0, 0, 'Cardinal', 0, NULL),
(41, 'Sabotage', 2, 5, 0, 2226, 1, 0, 19, 0, '[b]To the public eye, corporations fight each other passive-aggressively, never outright throwing a hay-maker at their competitors.[/b] But that\'s not the case behind closed doors. Sometimes, companies want information on each other. Or in cases like this... Sometimes they just want their competitors to fall to their knees, crippled forever.', 300, 100, 5, 0, 0, 0, 'Akafox', 0, NULL),
(42, 'Espionage', 1, 3, 0, 2226, 1, 0, 19, 0, 'Spy\'s have a mythical history to them. The only stories you ever hear of them are the myths and legends, and you never get to hear about them on the news. However, when you get offered a job that uses your skills to make you one of those legends, then how could you refuse?', 300, 150, 5, 0, 41, 1, 'Akafox', 0, NULL),
(43, 'Speedy Gonzalez', 4, 9, 0, 2195, 1, 0, 16, 0, 'I hacked your PC and I\'m holding your files hostage. If you want to see them again you will have to be FAAAST!!', 200, 40, 4, 40, 36, 2, 'HaZaMaT', 0, NULL),
(44, 'Roads Untraveled', 6, 30, 0, 1564, 1, 0, 18, 0, 'The Cobra\'s have yet another requests. About time.', 400, 300, 5, 0, 40, 0, 'Cardinal', 0, NULL),
(45, 'History lesson', 2, 22, 2, 1564, 1, 0, 15, 0, 'The world within the grid. Hacking is not job, it\'s not a goal, it\'s not power or weakness. It\'s destiny.', 300, 250, 5, 0, 39, 50, 'Cardinal', 0, NULL),
(47, 'Vulnerability 1', 1, 10, 0, 1564, 1, 0, 4, 0, '', 30, 40, 3, 0, 0, 2, 'Cardinal', 0, NULL),
(49, 'Let you in on a little secret', 3, 15, 2, 1564, 1, 0, 15, 2, 'It\'s not all cotton n\' candy. This competition is merciless and you must ALWAYS cover your trace. Leaving a trail of crumbs behind might be the last thing you\'ll ever get to do.', 250, 200, 5, 0, 45, 60, 'Cardinal', 0, NULL),
(51, 'Test SQL', 1, 20, 0, 1564, 0, 0, 8, 0, '', 30, 0, 3, 0, 0, 0, 'Cardinal', 0, NULL),
(52, 'Finding the Source', 3, 20, 0, 2580, 0, 0, 21, 0, 'A mysterious file has been found in your folders. Where has it came from? Who put it there? Time to find out, the only way you know how.', 250, 150, 3, 0, 0, 1, 'PurpleMoob', 0, NULL),
(53, 'A voice from the past', 1, 20, 0, 3329, 0, 0, 22, 0, 'You wake up at 7:00 AM and log into your mail server.\r\n4 new mails: Spam, Spam, a mail from the bank and... I remember this email address!\r\nIt\'s a mail from Jack! My primary school best friend! I haven\'t  heard anything from him in ages!', 50, 500, 3, 0, 0, 0, 'TheBonviOne', 0, NULL),
(54, 'First Step', 0, 300, 0, 1565, 0, 0, 11, 0, NULL, 30, NULL, 3, NULL, 0, 0, 'default', 0, NULL),
(55, 'Unraveling', 7, 19, 0, 1564, 1, 0, 18, 0, 'I\'ve always known that friends are only my drawbacks, enemies my incentives, power my goal. Now I have the means and soon I\'ll accomplish my mission. We face fear alone and fear has many friends.', 100, 100, 5, 0, 44, 0, 'Cardinal', 0, NULL),
(56, 'Vulnerability 2', 1, 10, 0, 1564, 1, 0, 4, 0, '', 30, 0, 3, 0, 0, 2, 'Cardinal', 0, NULL),
(57, 'Where does the truth lie?', 1, 7, 0, 1564, 1, 0, 18, 0, '“I hate mankind, for I think myself one of the best of them, and I know how bad I am.” \r\n- Joseph Baretti', 50, 50, 3, 0, 55, 0, 'Cardinal', 0, NULL),
(58, 'The Approach', 1, 15, 0, 3933, 1, 0, 23, 0, 'The Legendary Group Paladium contacted me. They may well be the one of the if not the strongest group in cyber world. I wonder what they need of me... \r\n\r\n[Please note explicit instructions have been avoided here ON PURPOSE , so as to enhance game-play. You are encourage to explore each and every thing logically and methodically. Future missions may contain some objectives that rely on pure LUCK.]\r\n\r\nEnter at your own risk!', 10, 20, 3, 0, 0, 0, 'mage61099', 0, NULL),
(59, 'Setting up Camp', 1, 20, 0, 3933, 1, 0, 23, 0, 'The Paladium have recruited me into thier ranks. They are presenting me with a new server and a special Program. This is probably gonna be fun.....\r\n\r\n\r\n\r\n[ Please note the following details while playing this and further Paladium missions. ALWAYS crack all important ports BEFORE entering a system. All Passwords for the files are availabe on the internet, please Google them to find the answers.READ ALL THE FILES YOU GET it may contain clues. YES EVEN EXECUTABLE FILES CAN BE READ. Please be case-sensitive and first try all cases before sending an error report. Always THOROUGHLY examine all ports.  Hints have been provided in them.Keep your trace low , Paladium wants utmost secrecy. Please note this common sense info, as long as someone has something you need dont harm them, as soon as you get it  destroy them.]\r\n\r\n[Future Paladium Missions will always begin with an email to your New server unless specified otherwise]', 200, 100, 3, 0, 0, 0, 'mage61099', 0, NULL),
(60, 'The Beginning', 1, 14, 0, 3933, 1, 0, 23, 0, 'This is the message i recieved from Paladium.\r\n\r\nWe must learn from our past experiences, we are sending you an email containing our history. Further instructions are in the email\r\n\r\nRegards, \r\nPaladium', 60, 20, 1, 0, 59, 0, 'mage61099', 0, NULL),
(61, 'Stealth', 7, 60, 0, 3933, 1, 0, 23, 0, 'The Paladium has given me my first real quest. Lets get a crack on then!', 250, 300, 5, 10, 60, 0, 'mage61099', 0, NULL),
(62, 'The Challenge', 3, 8, 0, 3933, 1, 0, 25, 0, 'You have been invited to a Old School Hacker Show Off. But with a Twist. 2 people do this together, so lets get on with it then!\r\n\r\n\r\n< PLEASE DO THE STEPS IN ORDER...  In case of queries please post about it ;) >', 60, 20, 3, 10, 0, 0, 'mage61099', 1, NULL),
(63, 'The  N00bs and the Pr0s', 1, 3, 2, 3933, 1, 0, 25, 0, 'Those cheating MORONS! After we ran their file, Then they just kicked us out! We were just entertainment to them! Oh they WILL PAY!', 130, 50, 3, 25, 0, 0, 'mage61099', 1, NULL),
(65, 'Pink Hat ?', 7, 30, 0, 4047, 1, 0, 28, 0, 'An organization calling themselves \" Pink Hat \" are planning to do something terrible.\r\nYou\'re asked to find out what it is and stop them if you got what it takes!\r\nFast before the world comes to an end.', 150, 126, 6, 50, 43, 0, 'Gothic', 1, NULL),
(68, 'Preparing for the battle - NOT FINISHED', 7, 5, 0, 4047, 0, 0, 28, 0, 'The group we got rid of was just a bunch of kiddies,\r\nin order to face the people standing behind them we got to believe in our selves and the stories we heard from our grandparents before sleep.', 0, 0, 0, 0, 65, 1, 'Gothic', 1, NULL),
(69, 'V.S.O', 5, 10, 2, 3933, 1, 0, 25, 0, 'V.S.O ? what is that??  its ....... oh god wow this group seems dumb. Anyway , the paycheck looks good. ', 300, 100, 5, 40, 63, 0, 'mage61099', 1, NULL),
(70, 'Coincidence by design', 1, 20, 2, 1564, 1, 0, 15, 0, 'Deciding to join THE competition is a very bold move. Everyone has been relentlessly talking about it all around you and it\'s finally time to find out yourself exactly what all this fuss is about. \r\n\r\nLet me tell you now: It\'s not going to be an easy journey. It will in fact be [b]the longest and most gratifying journey of your lifetime[/b].', 30, 30, 0, 0, 0, 0, 'Cardinal', 0, 'f'),
(71, 'Hackdown 1', 1, 17, 0, 1564, 1, 0, 29, 0, '', 30, 0, 3, 0, 0, 0, 'Cardinal', 0, NULL),
(72, 'Hackdown 2 PHP', 1, 17, 0, 1564, 1, 0, 29, 0, '', 30, 0, 3, 0, 0, 0, 'Cardinal', 0, NULL),
(73, 'Hack-Down ', 2, 20, 0, 3933, 0, 0, 29, 0, 'The Hack-down Competition is about to start.... We hope you are ready to face some serious hell \r\nRegards\r\nAlpha', 300, 150, 8, 10, 71, 0, 'mage61099', 0, 'Make em crack ...\r\nGive unique ports Done\r\nINPUT data for the hidden ips DONE \r\nCreate puzzles for L1 and L2  DONE \r\nUpdate Zoho.com chem website .... doing  DONE\r\nIP6 fairytail REMEMBER! DONE\r\nChem puzzle sfor longer path.  DONE\r\n\r\nUse multiple objective variability ?  LATER UPDATE...\r\n\r\n\r\nSecret Side obj?  LATER UPDATE....\r\n'),
(74, 'Daily Sacrifices', 3, 20, 1, 1564, 1, 0, 15, 0, 'Our Computer Science Research Department can use your help on a daily basis if you feel like practicing most commands and keep a healthy mind each day ^^.', 50, 50, 2, 0, 0, 0, 'Cardinal', 0, NULL),
(75, 'Highway', 1, 20, 1, 1564, 1, 0, 19, 0, 'One day, one car, one way.', 30, 100, 2, 0, 41, 0, 'Cardinal', 0, NULL),
(76, 'Worms', 1, 20, 1, 1564, 1, 0, 30, 0, 'I\'ve done enough for everybody else. I think this is the perfect moment I start doing things for myself.', 250, 250, 5, 0, 0, 0, 'Cardinal', 0, NULL),
(77, 'Survival of the fittest', 1, 30, 0, 1564, 1, 0, 30, 0, 'I\'ve met this guy once a while ago in a computer shop. He\'s full of cash and doesn\'t seem to know much about hacking. He\'s just the kid with the money who throws it around buying everything and pretending he knows how to use whatever he acquires.\r\n\r\nI\'m sure he won\'t mind if we share his fortune, don\'t you agree?', 400, 300, 5, 0, 76, 0, 'Cardinal', 0, NULL),
(78, 'Hacking Points', 1, 20, 0, 1564, 1, 0, 31, 0, '', 30, 0, 3, 0, 0, 0, 'Cardinal', 0, NULL),
(79, 'Basic Hacking', 1, 20, 0, 3933, 1, 1, 32, 0, 'The billboard caught my attention from the corner of my eye and I felt compelled to read the rolling text\r\n\r\n\"ARE YOU TIRED OF BEING THE n00b? DO YOU WANT TO HACK LIKE A PRO? DO YOU WANT TO KNOW THE TIPS, TRICKS AND TACTICS OF THE TRADE? IF SO, JOIN OUR BASIC HACKING COURSE NOW!\"\r\n\r\nWell, lately things HAVE been though. The couple of missions and jobs thrown my way have been a bit hard. Maybe this will help .....\r\n\r\n{ THESE TIPS ARE ONLY FROM A GAME AND PUZZLE SOLVING POINT OF VIEW. THEY ARE USED TO INCREASE YOUR ABILITY TO SOLVE PUZZLES AND ENJOYMENT. THEY HOWEVER DO NOT REPRESENT ANY HARD OR FAST RULES TO DO ANY MISSION. }', 50, 30, 3, 0, 0, 0, 'mage61099', 0, NULL),
(80, 'Crashing Castles', 1, 1, 0, 3933, 0, 0, 32, 0, 'Good job,  getting till here. Today\'s task is learninf how to crash a server around your target\'s pointy ears.', 30, 0, 3, 0, 0, 0, 'mage61099', 0, NULL),
(81, 'A simple message', 10, 10, 0, 4170, 0, 0, 33, 0, 'The natural tendency of humans is to march towards safety. For example, we listen to our parents most of the times, and when we don’t, we feel bad for it.\r\n\r\nThe natural state of humans is peacefulness. For example, we won’t go out of our way to make random people miserable if we can help it. \r\n\r\nHumans, are peaceful creatures… unless they can attain power.\r\n\r\nWe will walk the unwalked path if it’s for our gain and we will destroy others for even a gram of real power.\r\n\r\nHumans are frail beings… at least, most of them.\r\n\r\nWhat about you?', 1000, 500, 0, 0, 0, 0, 'Kitsune', 0, NULL);

CREATE TABLE `quests_feedback` (
  `feedback_id` int(11) NOT NULL,
  `quest_user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `feedback` text,
  `difficulty_rating` int(11) DEFAULT NULL,
  `time_rating` int(11) DEFAULT NULL,
  `replay_rating` int(11) DEFAULT NULL,
  `quest_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `quests_user` (
  `user_id` int(11) DEFAULT NULL,
  `quest` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `last_done` int(11) DEFAULT NULL,
  `times` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `quest_console_history` (
  `entry_id` int(11) NOT NULL,
  `input` text,
  `output` text,
  `task_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quest_id` int(11) DEFAULT NULL,
  `instance_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `quest_console_history` (`entry_id`, `input`, `output`, `task_id`, `user_id`, `quest_id`, `instance_id`, `created`) VALUES
(1, 'ls', 'final.sh [executable]<br/><em>1 returned</em>', 1, 18148, 70, NULL, '2018-02-03 10:49:59');

CREATE TABLE `quest_files` (
  `file_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT 'new.file',
  `content` text CHARACTER SET utf8,
  `service_id` int(11) DEFAULT NULL,
  `encryption` varchar(15) DEFAULT NULL,
  `canRun` tinyint(1) DEFAULT NULL,
  `requiredToRun` varchar(300) DEFAULT NULL,
  `requiredOnMainToRun` varchar(300) DEFAULT NULL,
  `running` tinyint(1) DEFAULT NULL,
  `sender` varchar(255) DEFAULT 'sender@domain.com',
  `size` int(11) NOT NULL DEFAULT '1000',
  `parameters` varchar(300) DEFAULT NULL,
  `cantKill` tinyint(1) DEFAULT NULL,
  `requiredObjective` int(11) DEFAULT NULL,
  `burst` tinyint(1) DEFAULT NULL,
  `executionTime` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `quest_files` (`file_id`, `title`, `content`, `service_id`, `encryption`, `canRun`, `requiredToRun`, `requiredOnMainToRun`, `running`, `sender`, `size`, `parameters`, `cantKill`, `requiredObjective`, `burst`, `executionTime`) VALUES
(70, 'enc', '[color=red]test[/color]', 40, '2', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(71, 'canrun', '', 40, '0', 1, '', '', 0, NULL, 1000, '', 0, 72, NULL, NULL),
(72, 'encrun', '', 40, '2', 1, '', NULL, 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(73, 'encrunrun', '', 40, '2', 1, '', '', 1, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(74, 'runreq', '', 40, '0', 1, 'canrun', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(75, 'reunreqreq', '', 40, '0', 1, 'canrun', 'encrun', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(76, '.hidden', 'trolololol', 41, '0', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(77, 'transfermetomain', '', 41, '2', 1, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(78, 'Bank statement', 'asdfsa\r\ngas\r\nagfdsf[color=red]asdfasd[/color]', 42, '0', 0, '', '', 0, 'sender@domain.com', 0, '', 0, 73, NULL, NULL),
(79, 'Testing everthginadsf', 'asdga ga\r\nfg a\r\ngfa\r\ng\r\ndf\r\ngdsfg', 42, '0', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(80, 'Testin Testinkg', 'trol trol trol', 42, '0', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(81, 'users', 'id|name|address\r\n1|adrian nenu|mos craciun cu plete 202 3    \r\n2|urs cwoala| pamapara@#$(*&amp;^%$#&quot;&lt;&gt;[mpam |tutuns@#%\r\n3|tutifruty|ahahaha', 44, '0', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(82, 'backup.sql', '', 46, '60', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(83, 'run.me', '', 47, '50', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(84, 'statistical_data.logs', 'unreadable-binary-data', 48, '50', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(85, 'schedule', '10:15 - Lunch at Royale\r\n11:30 - Train to work, Station 9830\r\n14:25 - Meeting with Mr. Heimz\r\n20:45 - Train home', 50, '0', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(86, 'file4640259', 'Your work was not in vain afterall...\r\n\r\nIP_2', 50, '3', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(90, 'Delete', 'The files must be deleted at once, but leave this e-mail behind.\r\n\r\nI want them to know we are faster than they could ever become.', 55, '0', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(92, 'A-Lenses - For a clearer future', 'We hope you&#039;re having a pleasant day, USERNAME.\r\n\r\nHere is your weekly newsletter from Alpha Corporation.\r\n  \r\nA-Lenses are technology aware contact lenses, by Alpha. \r\n\r\nThese state of the art non-intrusive devices seemingly integrate into your day to day life upgrading your eyesight with an entirely new experience.\r\n\r\n With A-Lenses and image is worth two thousand words.\r\n\r\nAvailable at tech-dealers near you.\r\n', 57, '0', 0, '', '', 0, 'marketing@alpha.grid', 1000, NULL, NULL, NULL, NULL, NULL),
(93, 'Earn money fast!', 'Hey there USERNAME,\r\n\r\nMy name is Michael Subtorn and I&#039;ve used a special technique and took advantage of the full power of the grid to earn a huge amount of money in a very short amount of time (less than two weeks).\r\n\r\nMany other&#039;s have used this technique and reproduced my results. don&#039;t you want to be one of them?\r\n\r\nGet back to me if you&#039;d like to know more about how to become one of the richest people on the face of the grid.\r\n\r\nSee ya in money,\r\nMichael Subtorn', 57, '0', 0, '', '', 0, 'michael@getriich.rich', 1000, NULL, NULL, NULL, NULL, NULL),
(94, 'Omega', 'Hello USERNAME,\r\n\r\nMy name is.. not so important.\r\n\r\nWe are.. more than you think.\r\n\r\nWe&rsquo;ve received word from our informers that you want to join our ranks.\r\n\r\nThink of this as a.. single-elimination round.\r\n\r\nYour first clue: IRP_4_3\r\n\r\nYour second clue is: IP_2\r\n\r\nExtra hint for second clue: What is the answer to life the universe and everything?\r\n\r\nGood luck hacker,\r\nThe Omega\'s\r\n\r\nP.S.\r\n\'The desire for fame tempts even noble minds\' -  St. Augustine The City of God\r\n', 57, '0', 0, '', '', 0, 'unknown', 1000, NULL, NULL, NULL, NULL, NULL),
(95, 'USERNAME.omega', 'You managed to break into a node of the Alpha grid. Quite impressive if I might say so myself.\r\n\r\nAlso decrypting this file couldn&#039;t have been that easy.\r\n\r\nHere&#039;s your next clues:\r\nIHP_4_3\r\n', 60, '5', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(96, 'USERNAME.readme', 'Looks like you did it.\r\n\r\nYou passed your first challenge. Easy peasy, wasn&#039;t it?\r\n\r\nWe&#039;ll examine your progress and get back to you as soon as possible.\r\n\r\nSharpen your skill as much as possible in the meantime.\r\n\r\nYour final task is to delete this file from this server.\r\n\r\nKeep hacking,\r\nOmega&#039;s', 62, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(97, 'Devils\' Den', 'This e-mail adress you were presented with, use it with pride, as you are one of the few true citizens of our society. \r\n\r\nYou are to use this e-mail adress only on missions, as we don\'t like to confuse public activities with work.', 67, '0', 0, '', '', 0, 'dd@a.com', 1000, NULL, NULL, NULL, NULL, NULL),
(98, 'First Mission', 'Your first mission was assigned. Do it at your own leasure, but remind yourself that we will take note of your each and every step.', 67, '0', 0, '', '', 0, 'dd@a.com', 1000, NULL, NULL, NULL, NULL, NULL),
(99, 'Congratulations', 'Even if you weren\'t able to find any definitive proof that someone messed with our server, you still did a pretty good job.\r\n\r\nWe\'ll make sure to give you jobs on your level from now on.', 67, '0', 0, '', '', 0, 'dd@a.com', 1000, NULL, NULL, NULL, NULL, NULL),
(100, 'don\'t get cocky', 'You are still at it huh? \r\nI guess the guys high up are out of their minds if they intend to keep someone like you around.\r\n\r\nConsider this e-mail a chance at redemtion...\r\n\r\nP.S. I don\'t know if you are worth the time, so I am going to crack a few servers here and there. \r\n\r\nCatch me if you can.', 67, '0', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(105, 'Common Gound', 'IP_2\r\n\r\n\r\nI guess you need this, right?', 67, '0', 0, '', '', 0, 'jhone@a.com', 1000, NULL, NULL, NULL, NULL, NULL),
(106, 'DataLog701240710', '', 68, '1000000', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(107, 'DataLog701240711', '', 68, '1000000', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(108, 'nice_one', 'You gave me a heart attack when you pingged this terminal. Seriously, stop it man. I didn\'t even finish reading and deleting these files.', 68, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(109, 'Fudge_Cake', 'This cake is extremely rich and moist, hence its name. Chocolate cake mix, chocolate pudding, and chocolate chips triple your chocolate pleasure. Feel free to experiment by using different flavored chips or nuts. This is a traditional recipe passed down from at least the early 1970\'s. I\'m not sure of its origin, but my old recipe card is quite yellowed and spotted with use so I would be hard-pressed to even guess at the originator. It is definitely worth the indulgence, but do not over-bake! You can also make mini-muffins from this recipe.\r\nPrep Time: 10 minutes\r\n\r\nCook Time: 55 minutes\r\n\r\nTotal Time: 1 hour, 5 minutes\r\n\r\nYield: 10 to 12 servings\r\n\r\nIngredients:\r\n\r\n1 package (about 18.25 ounces) chocolate fudge cake mix or devil\'s food cake mix, unprepared\r\n1 (3-ounce) package instant chocolate pudding mix (I use extra-dark)\r\n1 cup sour cream\r\n4 large eggs\r\n1/2 cup vegetable oil\r\n1/2 cup water\r\n1 (6-ounce) bag of semi-sweet or dark chocolate chips, chilled\r\nConfectioner\'s (powdered) sugar, optional\r\nPreparation:\r\n\r\nPreheat oven to 350 degrees F. Grease and flour a Bundt pan or angel food cake pan. \r\n\r\nBeat cake mix, pudding mix, sour cream, eggs, vegetable oil, and water together in a large bowl for 2 minutes at medium speed. Fold in chocolate chips by hand. Pour evenly into prepared pan. \r\n\r\nBake for 55 minutes. Do not over-bake. Let cool on a rack for 15 minutes. Place a large cake dish or platter over the top of the pan. Turn it over and gently tap until the cake releases. If the cake is stubborn to release, use a rubber spatula around the edge and center of the pan to ease it free, and try again. \r\n\r\nLet cake cool completely, then sift powdered sugar over the top or drizzle with a simple glaze of powdered sugar and milk or cream. \r\n\r\nYield: 10 to 12 servings \r\n\r\nTo Make Mini-Muffins: Preheat oven to 350 degrees F. Prepare batter as above. Line mini-muffin tins with muffin papers. Fill 2/3 full. Bake about 14 minutes. \r\n\r\nNotes: \r\n&bull; The original recipe uses a plain chocolate cake mix and vanilla pudding. I\'ve tripled the chocolate richness with a fudge cake mix, dark chocolate pudding, and dark chocolate chips. Feel free to stick with the original, if you like. \r\n\r\n&bull; Most cake mixes these days already have pudding in the mix, and they still work just fine. ', 69, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(110, 'Dump_Cake', 'This recipe is designed for kids to bake. It\'s incredibly easy with no mixing involved. Canned fruits are dumped into a baking pan, topped with cake mix, butter, and nuts, then baked. The result is something in between a cake and a cobbler, and amazingly delicious. Adults will also love this recipe.\r\nPrep Time: 10 minutes\r\n\r\nCook Time: 1 hour\r\n\r\nTotal Time: 1 hour, 10 minutes\r\n\r\nYield: 10 to 12 servings\r\n\r\nIngredients:\r\n\r\n1 (20 ounces) can crushed pineapple, undrained\r\n1 (21 ounces) can prepared more fruit cherry pie filling\r\n1 (18.25 ounces) box yellow cake mix\r\n2 sticks (1 cup or 16 Tablespoons) of butter or margarine, each cut into 12 slices\r\n1/4 cup chopped nuts (pecans, walnuts, pistachios, cashews, peanuts, etc., your choice)\r\nPreparation:\r\n\r\nPreheat oven to 350 degrees F (325 for glass baking dish). Have a 9 by 13-inch baking pan ready. \r\n\r\nDump undrained pineapple baking dish or pan and spread it out evenly. \r\n\r\nUsing a spoon, dump globs of cherry pie filling evenly on top of the pineapple. \r\n\r\nSprinkle the cake mix evenly over the cherry and pineapple layers. \r\n\r\nCut butter into slices with a butter knife and place slices evenly over cake mix. \r\n\r\nSprinkle nuts on top if you\'re using them. \r\n\r\nBake for one hour. Use heavy oven mitts to remove the dump cake from oven or let your older helper do it. \r\n\r\nTo serve, scoop cake out with a large spoon like a cobbler, and dump it on a nice plate. A scoop of vanilla ice cream is delicious with dump cake. Serve warm or cold. \r\n\r\nYield: about 10 to 12 servings ', 69, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(111, 'Yellow_Cake', 'Everyone will enjoy this moist yellow cake recipe made from scratch. Be sure to check at the bottom for more great cake recipes.\r\nBest Way to Print This Recipe\r\n\r\nPrep Time: 15 minutes\r\n\r\nCook Time: 25 minutes\r\n\r\nTotal Time: 40 minutes\r\n\r\nYield: Two 9-inch Cake Rounds\r\n\r\nIngredients:\r\n\r\n2 cups cake flour\r\n2 teaspoons baking powder\r\n1/2 teaspoon salt\r\n1/2 cup butter, softened\r\n1 cup sugar\r\n3 large eggs, room temperature\r\n2 teaspoons vanilla\r\n3/4 cup milk\r\nPreparation:\r\n\r\nPreheat oven to 350&deg;F. Grease and flour 2 9-inch cake pans.\r\nIn bowl, combine flour, baking powder, and salt with a wire whisk.\r\n\r\nCream butter and sugar until light and fluffy. Beat in eggs, one at a time. Add vanilla and mix until completely combines. Slowly add flour alternately with milk. At end of addition batter should be smooth. Divide between 2 pans.\r\n\r\nBake Yellow Cake Recipe for 20 to 25 minutes. Cool 5 minutes in pan, then invert onto a rack and cool completely before frosting.\r\n\r\nFor a 9 x 13 pan - Baked at 350 degrees F. for 30 to 38 minutes.', 69, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(112, 'The_Alpha-Killers', 'You have no ideea what you are getting into.', 70, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(113, 'Quiiiiiiiiiiiiiiiz_Timeeeeeeeeeeeeee!', 'To Make Mini-Muffins: How many minutes do you have to let them in the oven?\r\n\r\n\r\nssh IP_5', 71, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(114, 'Poking the eye', 'To all interested parties.\r\n\r\nWe are going to poke the eye in the sky.\r\n\r\nETA unknown. Prepare.', 75, '0', 0, '', '', 0, 'group@omega1406.temp', 1000, NULL, NULL, NULL, NULL, NULL),
(115, 'Congratulations', 'Congratiulations on your promotion!\r\n\r\nI heard that a bank will be transfering high value files today. We might as well, have something to celebrate with.\r\n\r\nIP: IP_1\r\n\r\nPort: 502\r\n\r\nTry to have fun.', 77, '0', 0, '', '', 0, '1ace880@a.com', 1000, NULL, NULL, NULL, NULL, NULL),
(116, 't8-3at', 'Y0= a-3 )3a).\r\n\r\nUSERNAME, y0= )0+\'t )3/3-v3 t0 1i&gt;3. T8i/ i/ t83 c0+c1=/i0+ I a-i&gt;3) t0 a6t3- a+a1i7i+g my )ata.\r\n\r\nI wi11 t3-mi+at3 y0=.\r\n', 77, '0', 0, '', '', 0, '-ai73+', 1000, NULL, NULL, NULL, NULL, NULL),
(117, 'scan3224.log', 'last scan executed 4 hours ago\r\n------------------------------------------------\r\nIP_3:399 - Grid Node\r\nIP_4:734 - Grid Node\r\nIP_5:286 - Grid Node\r\n', 79, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(118, 'iris.security.certificate', 'Security-Certificate-Hash:1356345234686795670302016868-743-693452368435969768249560345823468349570234581345-6456472345-134518692859213572691043582369', 81, '40', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(119, 'access.codes.iris', 'binary data', 82, '60', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(120, 'task1.txt', 'Delete me or I\'ll deleted you.', 85, '0', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(121, 'task2.txt', 'This is the content of task2.txt.\r\n\r\nWe must learn how to deal with encrypted files as well. \r\n\r\nThe command to decrypt files is [b]decrypt filename[/b] which will use your skills and software to find the encryption key and then decrypt files.\r\n\r\nTime to decrypt task3.txt and read the file contents as soon as decryption is completed.', 85, '0', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(122, 'task3.txt', 'To complete the next and final task you shall have to decrypt, execute then kill the process for [i]task4.runme[/i].\r\n\r\nAs soon as task4 gets killed, our session together will end. The end. Goodbye! Ciao! \r\n\r\nTo run a file you use the following command\r\n\r\n[b]run filename[/b]\r\n\r\nTo obtain a list of running processes and their process ID, enter the following\r\n\r\n[b]ps[/b]\r\n\r\nAnd to kill a process:\r\n\r\n[b]kill processID[/b]\r\n\r\nThere are files which require other processes to be running on your computer or on the computer you are executing the file on. That is not the case for task4.', 85, '5', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(123, 'task4.runme', '', 85, '3', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(124, 'Example email 1', 'Example email content', 88, '0', 0, '', '', 0, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(125, 'Example email 2', 'One other useful command is [b]delete ID[/b].\r\n\r\nYour next impossible mission is to delete this email. Done yet? Good.', 88, '0', 0, '', '', 0, 'sender2@domain.com', 0, '', 0, 0, NULL, NULL),
(126, 'file.transferme', 'Did I tell you to read the file? DID I!?\r\n\r\nGood job for finally doing something you were not told to do! You\'re one the right path to becoming a... *cough*hacker*cough* computer scientist.', 91, '0', 0, '', '', 0, NULL, 1001, NULL, NULL, NULL, NULL, NULL),
(127, 'users', 'id|name|email\r\n1|razor|razor@alpha.zone\r\n2|claw|claw@alpha.zone\r\n3|holy|holy@alpha.zone', 96, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(128, 'Carpe Diem', 'Hello USERNAME,\r\n\r\nWe\'ve heard of you recent progress in the industry and our agents have been researching certain individuals since their first contact with a computer.\r\n\r\nYou, amongst others, stand out from the masses. \r\n\r\nAllow me to be short.\r\n\r\nI want to offer you.. a contract. You will provide a service and I will pay more or less handsomely.\r\n\r\nThe service we need from you is infiltrating into the entities we specify and either retrieve information we require or inflicting irreparable damage.\r\n\r\nIf you\'d like to accept our offer all you need to do is forward this email to yourself.\r\n\r\nYou might be wondering who we are by now.\r\n\r\nOur name is Cobra and we are most delighted to make your acquaintance, USERNAME.\r\n\r\nUntil we\'ll talk again,\r\nX.', 98, '0', 0, '', '', 0, 'unknown@anonymous.contractor.co', 0, NULL, NULL, NULL, NULL, NULL),
(129, 'index.html', '&lt;html lang=&quot;en&quot;&gt;&lt;head&gt;\r\n    &lt;meta charset=&quot;utf-8&quot;&gt;\r\n    &lt;meta http-equiv=&quot;X-UA-Compatible&quot; content=&quot;IE=edge&quot;&gt;\r\n    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1&quot;&gt;\r\n    &lt;meta name=&quot;description&quot; content=&quot;&quot;&gt;\r\n    &lt;meta name=&quot;author&quot; content=&quot;&quot;&gt;\r\n    &lt;link rel=&quot;icon&quot; href=&quot;../../favicon.ico&quot;&gt;\r\n\r\n    &lt;title&gt;Revolution of Bio Technology&lt;/title&gt;\r\n\r\n    &lt;!-- Bootstrap core CSS --&gt;\r\n    &lt;link href=&quot;../../dist/css/bootstrap.min.css&quot; rel=&quot;stylesheet&quot;&gt;\r\n\r\n    &lt;!-- Custom styles for this template --&gt;\r\n    &lt;link href=&quot;sticky-footer.css&quot; rel=&quot;stylesheet&quot;&gt;\r\n\r\n  &lt;body&gt;\r\n\r\n    &lt;!-- Begin page content --&gt;\r\n    &lt;div class=&quot;container&quot;&gt;\r\n      &lt;div class=&quot;page-header&quot;&gt;\r\n        &lt;h1&gt;A new formula for bio engineering&lt;/h1&gt;\r\n      &lt;/div&gt;\r\n      &lt;p class=&quot;lead&quot;&gt;Our team is working on the next generation of bio engineered cells.&lt;/p&gt;\r\n      &lt;p&gt;We are recruiting talent from the industry. Send us your CV.&lt;/p&gt;\r\n    &lt;/div&gt;\r\n\r\n    &lt;div class=&quot;footer&quot;&gt;\r\n      &lt;div class=&quot;container&quot;&gt;\r\n        &lt;p class=&quot;text-muted&quot;&gt;Bio-Keltech&lt;/p&gt;\r\n      &lt;/div&gt;\r\n    &lt;/div&gt;\r\n&lt;/body&gt;&lt;/html&gt;', 99, '20', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(130, 'jobdescript', 'Last night around 5:05 our internal services machine got hacked.\r\nCheck our logs and trace the hacker back to his own IP address.\r\nThe IP address of our internal services machine is: IP_2  the port you need is 80\r\nNo need to crack it you are given full access.', 101, '0', 0, '', '', 0, 'Unknown', 1000, NULL, NULL, NULL, NULL, NULL),
(132, 'login.logs', '16:04 IP_3-connected\r\n16:09 IP_3-disconnected\r\n22:12 IP_4-connected\r\n23:58 IP_4-disconnected\r\n5:05  IP_5-connected\r\n5:05  IP_5-accessed file: GOV.pdf\r\n5:05  IP_5-accessed file: ICBM.pdf\r\n5:05  IP_5-accessed file: Traderoute.batch\r\n5:06  IP_5-uploaded Zeus.exe\r\n5:06  IP_5-disconnected', 102, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(133, 'dat25478.dat', 'ajsknhyhdqsjkjnkjjk', 103, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(134, 'dat64203.dat', 'bzebcbyhedchcechjn', 103, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(135, 'dat78245.dat', 'cdjhsnikjcdncjsqncjqsdnjcjsqdncjk\r\n', 103, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(136, '1497632.dat', 'chqhcqhhqchjqhqkjhjebcfhqek', 104, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(137, '9536471.dat', 'cedjcncjqncjgibberishhchjcnkjq', 104, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(138, '2578963.dat', 'csdhkjcsqhkjcndissapointdcshjcvs', 104, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(142, '36571.dat', '01001001001000000110010001101111011011100111010000100000011001010111011001100101011011100010000001101011011011100110111101110111001011100010111000101110', 107, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(143, '26178.dat', '0101100101101111011101010010000001110111011001010111001001100101001000000110111001100101011101100110010101110010001000000111001101110101011100000111000001\r\n101111011100110110010101100100001000000111010001101111001000000111010001110010011000010110111001110011011011000110000101110100011001010010000001110100011010000110100101110011', 107, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(144, 'login.logs', '14:00 IP_6-connected\r\n15:48 IP_7-connected\r\n17:14 IP_6-disconnected\r\n4:37 IP_8-connected\r\n5:05 IP_9-routed to IP_2\r\n7:57 IP_7-disconnected\r\n8:27 IP_8-disconnected\r\n', 107, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(146, '254.dat', 'dvsnvsihuthisaintwhutyoulookforvhnqhkjnv', 108, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(147, '263.dat', 'nqvijknvqjnqjvqkjvqvnjvnkjqnkqvnqvqv', 108, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(148, '987.dat', 'vqhhqhhvtrollroflfqjvnkjvnkjv\r\n', 108, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(149, '26475.dat', 'vyhqfvqhjqvnwrongturnvnqnqikjv', 109, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(150, '284197.dat', 'vfhqjqvnwhyyoudothistoyourselfvnqnhj', 109, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(151, '1976327.dat', 'vqhhvvknkqvqturnleftimmediatelyhjvqhjqh', 109, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(152, '1497587.file', 'vqnqvkvjjqbogusiguessvhqkqvnqv', 110, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(153, '2473985.file', 'hqvhqhnujpleaseleavenjkvqnjvjq', 110, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(154, '14879.dat', '415684223689412598742236454225', 111, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(155, '36879.dat', '257416569852332112555851033789', 111, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(156, 'connection.logs', '16:42 IP_10-connected\r\n17:48 IP_10-disconnected\r\n22:45 IP_11-connected\r\n1:05  IP_12-connected\r\n5:05  IP_13-disconnected\r\n6:24  IP_11-disconnected\r\n8:58  IP_12-disconnected', 111, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(157, '21586.txt', 'vqivhnjqujqyouarewaistingyourtimerqvihniquv', 112, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(158, '25398.txt', 'vqjfnvjqnqvnothinhherevhqhvnqhnv\r\n', 115, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(159, '255584.dat', 'fvqhhnqkjvnjqkalmosthterevqnqjvnqnq', 116, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(160, 'GOV.pdf', '01000010011101010111001101101000001000000111001101110101011000110110101101110011', 117, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(161, 'ICBM.pdf', '0111001001101111011000110110101101100101011101000111001100100000011000010110111001100100001000000111001101110100011101010110011001100110', 117, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(162, 'Traderoute.batch', '0110010001101001011000010110110101101111011011100110010001110011001000000110011001101111011100100010000001000001010010110010011101110011', 117, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(163, 'Zeus.exe', '', 117, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(167, 's_list', 'Current IP of Secured Storage: IP_3', 121, '2', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(168, 'RE: Lunch', 'Eric,\r\nI really don\'t have the time to be going on a date with you. I need to focus on work, something you should probably try.\r\nRegards,\r\nCathy\r\n\r\n---Yesterday\r\n&gt;Cathy,\r\n&gt;I\'d love it if we could possibly go out to eat for lunch sometime, and maybe call it a date? I\'ve had a crush on you for some time now, and I just finally decided &gt;to ask you.\r\n&gt;Please reply,\r\n&gt;Eric', 119, '0', 0, '', '', 0, 'cathy@senta.org', 1000, NULL, NULL, NULL, NULL, NULL),
(169, 'file9934106', 'Ms. Cathy,\r\nI\'ve updated the IP address of the storage server holding some key documents. The IP is now IP_2. Please be sure to update your logs.\r\nThank you,\r\nAdrik', 119, '0', 0, '', '', 0, 'adrik@senta.org', 1000, NULL, NULL, NULL, NULL, NULL),
(170, 'security.cert', 'a9302mdDAJW0292-30D23-3293012983JD299d2j9223029a13124nwi2948737-2939221_2392#294', 122, '2', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(175, 'data.json', '{\'done\':true}', 99, '30', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(176, 'script.js', '$(document).ready(function(){\r\n\r\n});', 99, '20', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(177, 'Party?', 'Hey Boss,\r\nCan we have a raise / party in the air traffic control tower? Now, I know what you\'re thinking, but we won\'t spill coffee on the equipment. I promise.\r\nSincerely,\r\nCameron, aka Avocado', 124, '0', 0, '', '', 0, 'cameron@SomalianExpress.net', 1000, NULL, NULL, NULL, NULL, NULL),
(178, 'Payback', 'You\'re getting it. You never should\'ve messed with that magnificent microwave casserole!', 124, '0', 0, '', '', 0, 'magnuson@SomalianExpress.net', 1000, NULL, NULL, NULL, NULL, NULL),
(179, 'IP updates!', 'The new IP of the storage server is IP_2. Port remained the same through upgrades. Have a nice day.', 124, '0', 0, '', '', 0, 'itDepartment@SomalianExpress.net', 1000, NULL, NULL, NULL, NULL, NULL),
(180, 'verification.key', 'iojidw0990D90Q09J09J09DJ09Jjd09f932q09ij0JD309J00jd3ij=3d23j09J092J23J09DJDMQODIQ299n09j2edandalkwd29#2321', 125, '12', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(181, 'access.logs', 'NOW -- IP_0\r\n3HRs -- 323.512.634.12\r\n2DYs -- 12.235.346.11\r\n', 125, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(182, 'se.txt', '01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011 01010000 01100001 01101110 01100100 01100001 01110011', 125, '1', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(183, 'file72886981', 'File Corrupted', 125, '2', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(184, 'USERNAME.txt', 'So, you CAN find files! Nice job! Anyways, the lead I need you to follow is this IP. Access it, and I\'ll update you with some more information.\r\n\r\nIP_1', 123, '1', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(186, 'A job for you.', 'Hi, USERNAME!\r\n\r\nI remember what i did to you, and i am sure you as well. But i have a job for you.\r\nA well paying job. Doesn\'t matter for whom i work for. The important thing is, what you need to do.\r\nFirst you need to go this server: IP_2 \r\nYou need to find out, what port is it.\r\nThen, there will be a file, what he stole from us. Transfer it back to us. IP: IP_3 Port 134\r\nImportant: The file could be hidden. YOU need to find it.\r\nAnd after you done with everything, delete this message. We will contact with you soon.', 127, '0', 0, '', '', 0, 'Unknown', 1000, NULL, NULL, NULL, NULL, NULL),
(188, '.datas.txt', 'This is a REALLY important file.', 129, '30', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(192, 'research-1753-result.data', '', 133, '10000', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(193, 'research-1754-result.data', '', 133, '10000', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(194, 'research-1755-result.data', '', 133, '10000', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(195, 'research-1756-result.data', '', 133, '10000', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(196, 'research-1757-result.data', '', 133, '10000', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(197, 'administrative-info.txt', 'Logs of past connections to this server are kept in the local database.\r\n\r\nAccess Level 3 administrator are responsible for administrating the server.\r\n\r\nActive Sync of Access Control to Grid Nodes 1-64-90 and 2-31-44.\r\n\r\nStandard company security protocol in effect.\r\n\r\nReport any suspicious activities to Level 3 or higher system administrators.', 133, '20', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(198, 'research-1758-result.data', '', 133, '10000', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(199, 'research-1759-result.data', '', 133, '10000', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(200, 'connections', 'connection_id|from_ip\r\n1|IP_2\r\n2|IP_3\r\n3|IP_3\r\n4|IP_2\r\n5|IP_4\r\n6|IP_5\r\n7|IP_6\r\n8|IP_7\r\n9|IP_8\r\n10|IP_9\r\n11|IP_9\r\n12|IP_4', 134, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(201, 'research_files', 'file_id|file_name\r\n1|research-1750-result.data\r\n2|research-1751-result.data\r\n3|research-1752-result.data\r\n4|research-1753-result.data\r\n5|research-1754-result.data\r\n6|research-1755-result.data\r\n7|research-1756-result.data\r\n8|research-1757-result.data\r\n9|research-1758-result.data\r\n10|research-1759-result.data\r\n11|research-1760-result.data\r\n12|research-1761-result.data\r\n13|research-1762-result.data\r\n14|research-1763-result.data\r\n15|research-1764-result.data\r\n', 134, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(202, 'transfer_log', 'id|transfered_file_id|to_connection_id\r\n1|11|1\r\n2|15|2\r\n3|14|3\r\n4|13|5\r\n5|1|7\r\n6|12|6\r\n7|2|8\r\n8|3|11\r\n', 134, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(203, 'research-1760-result.data', '', 135, '10000', 1, '', '', 1, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(205, 'research-1752-result.data', '', 138, '10000', 1, '', '', 1, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(206, 'research-1751-result.data', '', 140, '10000', 1, '', '', 1, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(207, 'research-1764-result.data', '', 142, '10000', 1, '', '', 1, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(208, 'research-1763-result.data', '', 142, '10000', 1, '', '', 1, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(209, 'research-1762-result.data', '', 143, '10000', 1, '', '', 1, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(210, 'research-1750-result.data', '', 141, '10000', 1, '', '', 1, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(211, 'unencrypted-research-1761-result.data', 'unreadable-binary-data', 144, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(212, '[SENT] Package delivered', 'I have recovered, unpacked and uploaded the promised package on IP_10.\r\n\r\nAwaiting payment. No sign of interference. Package security guaranteed.\r\n\r\nConfirmation code: ALPHA-OMEGA-T03122-3345-000010', 146, '0', 0, '', '', 0, 'owen@alpha.co', 1000, NULL, NULL, NULL, NULL, NULL),
(213, 'Re: Package Delivered', 'Confirmed.\r\n\r\nPayment complete.\r\n\r\nAGENT STATUS: Standby.', 146, '0', 0, '', '', 0, 'anonymous@ano.co', 1000, NULL, NULL, NULL, NULL, NULL),
(214, 'attachment-unencrypted-research-1761-result.data', 'unreadable-binary-data', 147, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(221, 'bounce-concepts.task', '', 159, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(222, 'Animals', 'id|name|email\r\n1|Giraffe|Giraffe@alpha.zone\r\n2|AfricanElephant|AfricanElephant@alpha.zone\r\n3|BlueWhale|BlueWhale@alpha.zone\r\n4|PolarBear|PolarBear@alpha.zone\r\n5|Fox|Fox@alpha.zone\r\n6|Cat|Cat@alpha.zone\r\n7|Mouse|Mouse@alpha.zone\r\n8|Ant|Ant@alpha.zone', 162, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(223, 'TheirDen', 'Email_id|Corresponding_ip\r\n1|57.160.205.172\r\n2|162.47.247.1\r\n3|80.104.27.23\r\n4|210.44.169.10\r\n5|212.111.76.206\r\n6|248.217.225.70\r\n7|29.182.137.166\r\n8|IP_2', 162, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(224, 'connection.log', '12:43 107.45.148.83-connected\r\n13:42 107.45.148.83-connected\r\n14:25 230.87.161.227-disconnected\r\n14:35 107.45.148.83-disconnected\r\n17:52 IP_3-connected\r\n17:53 IP_3-accessed file: donteatme.txt\r\n17:53 IP_3-deleted file: donteatme.txt\r\n17:53 IP_3-disconnected\r\n', 163, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(226, 'Manual.txt', 'To use the LogUndeleter.exe you must use have admin access to the IP where the altered log is located and have the LogUndeleter Tool installed and running at the same location. ', 165, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(227, 'LogUndeleter.exe', '', 165, '20', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(228, 'login.logs', '14:46 57.160.205.172-connected\r\n17:36 162.47.247.1-connected\r\n17:37 57.160.205.172-disconnected\r\n17:42 80.104.27.23-connected\r\n17:52 IHP_6_4-routed to IP_3\r\n18:12 210.44.169.10-connected\r\n21:22 212.111.76.206-connected\r\n22:42 162.47.247.1-disconnected\r\n23:36 210.44.169.10-disconnected\r\n23:52 248.217.225.70-connected\r\n01:00 29.182.137.166-connected\r\n02:02 158.195.193.215-connected\r\n02:23 212.111.76.206-disconnected\r\n03:24 80.104.27.23-disconnected\r\n05:30 248.217.225.70-disconnected\r\n06:58 29.182.137.166-disconnected\r\n07:00 158.195.193.215-disconnected', 166, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(229, '142 ', 'fqvf16q5v1f61vq651vq651v651v655v1f65', 167, '30', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(230, '250', 'vq2v52fv2q6v12q65f1vqqv5f1vq1f65v', 167, '30', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(231, '316', 'vqs5121f5v12q51v5qf61vq61fvf465v16fv1', 167, '30', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(232, '423', 'vqsf51v5qf165vq65v65q1f5vq1v6', 167, '30', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(233, '539', 'vf15q12v51q6fv16qf1vqf16v5vq65f1vq15f61', 167, '30', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(234, '614', 'IP_7', 167, '10', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(235, '798', 'vqf65q16fvqf1v1qf65v1qf', 167, '30', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(236, '1002', 'fv52q162v6515v1q65v165v1', 167, '30', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(237, '1223', 'vf516q5v1qf651v5q61v6q1v6q16', 167, '30', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(239, 'security.cert', '', 46, '30', 0, '', '', 0, NULL, 1000, '', 0, NULL, NULL, NULL),
(240, 'puzzle.piece', 'IRP_4_4\r\n\r\nIP_2', 154, '10', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(241, 'puzzle.piece', 'IRP_4_1\r\n\r\nIP_3', 155, '10', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(242, '123', 'vfg65q1f5q161qsfb5q1q6q1f65q1f', 172, '50', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(243, '456', '1qf6vq1f5vqv5f165v1q65f1v6q1vqf65qv', 172, '50', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(244, '789', 'qv51f5v1qfv6qf1vf651v6qf1v6q11651v6q', 172, '50', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(245, 'abc', 'f6z156g51s65f165s1vs65f1q6', 172, '50', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(246, 'def', 'IP_8', 172, '10', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(247, 'riddleconvertion', 'SSHFile_id|RiddleSolution_id\r\n123|School\r\n456|University\r\n789|College\r\nabc|Kindergarten\r\ndef|Office', 173, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(249, 'Li', '6g1516s16s1f65q161', 176, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(250, 'Be', 'fvqf651vq165f651v61fv', 176, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(251, 'Na', 'zg561z651f51qzf651q1', 176, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(252, 'Mg', 'vf15q651vfvq65fv1q61fvq651v5vq', 176, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(253, 'B', 'v1f61q5v15q61v6q51v6q', 176, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(254, 'Al', 'vf1fv5qf16v1q61vq61f5v15q6f1', 176, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(255, 'C', 'f41vf651v65f1vq651qvv1q5f1v', 176, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(256, 'N', 'vf5qd651vfq65v5q61vf6q15vq56v', 176, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(257, 'O', '1af6v51qf651vf155v1qf56v16q5f1vq', 176, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(258, 'Si', 'vf12v6f165v15qf1v6q1fv5qs1vqsf65', 176, '10', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(259, 'Keychange.batch', 'vg1651sg65sg16s1q65g165q165f165f165v1q65fv1q6515f1qf651vqf65151q1f56v1q56151qf6515b1f51q6516515q6f156q151fq6515q1', 177, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(260, 'Browserhistory.txt', 'f5q1v1qfvf651vf565q1v65f1v61f5v1q651v65q1v1qf65v1qf651v5qf1v6q51f5v1q6f5v1q65f616q51q651', 177, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(261, 'DOBPOB.log', 'qf1v61f5v16qf51vqf65v16q1f65v1qf651v51f5q61vq16f65v1q5v16f51vq6v1q6', 177, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(262, 'Homeaddress.txt', '65f1vqf5vq6v1651fvq51f65q165v1q5f1v6f1v61q56fq1515f1fq16v1', 177, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(263, 'B0Z0 WaZ h3r3!!', 'I hacked into your PC and stole your files.....revenge is a dish best served cold :-) -B0Z0', 128, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(264, 'Zeus.exe', 'g65g165sg156g1bsg651bs65g1s65g165b1s65bsgd1b6s', 128, '10', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(265, 'Animals', 'id|name|email\r\n1|Giraffe|Giraffe@alpha.zone\r\n2|AfricanElephant|AfricanElephant@alpha.zone\r\n3|BlueWhale|BlueWhale@alpha.zone\r\n4|PolarBear|PolarBear@alpha.zone\r\n5|Fox|Fox@alpha.zone\r\n6|Cat|Cat@alpha.zone\r\n7|Mouse|Mouse@alpha.zone\r\n8|Ant|Ant@alpha.zone', 185, '0', 0, '', '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(266, 'backupfiles', 'id|name|files\r\n1|USERNAME|backupfiles\r\n2|B0Z0|backupfiles', 205, '0', 0, '', '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(267, 'slaves', 'id|ip\r\n1|IP_2\r\n2|IP_3\r\n3|IP_4', 207, '0', 0, '', '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(268, 'lab_security', 'id|lab_door|slave\r\n1|1|3\r\n2|3|1\r\n3|2|2', 207, '0', 0, '', '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(269, 'slaves', 'id|ip|title\r\n1|IP_9|Lab\r\n2|IP_10|Lab', 216, '0', 0, '', '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(270, 'slaves', 'id|ip|title\r\n1|IP_8|M.D.\r\n2|IP_3|Lab', 217, '0', 0, '', '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(272, 'security.certificate', 'unreadable-binary-data', 84, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(274, 'findme.challenge', 'Can you figure out who I am?\r\n\r\nEntry awaits if you can.\r\n\r\nIP_1', 221, '5', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(276, 'onestepcloser.challenge', 'You are already closer to the prize.\r\n\r\nDon\'t stop now! Follow IP_2', 222, '10', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(277, 'WINNER! WINNER! WINNER!', 'Hello USERNAME,\r\n\r\n\r\nCONGRATULATIONS!\r\n\r\nYou have the sort of skills that we are looking for. You are probably still wondering who we are, that will be revealed in due course.\r\n\r\nAll we need to know for now is that you are ready to join the elite of your kind.\r\n\r\nIf you are up to the challenge; delete this email to remove all trace of our communication and await further instructions.\r\n\r\n\r\nPeace Out,\r\nP', 224, '0', 0, '', '', 0, 'purplemoob@secretrepublic.net', 0, NULL, NULL, NULL, NULL, NULL),
(279, 'EASY MONEY', 'This message contains a virus and you don\'t really want a virus on your server, do you?\r\n\r\nThis message was flagged as spam by the automatic spam filter.', 228, '0', 0, '', '', 0, 'spamspam@secretrepublic.net', 0, NULL, NULL, NULL, NULL, NULL),
(280, 'HEY DUDE! DO YOU...', 'This message contains a virus and you don\'t really want a virus on your server, do you?\r\n\r\nThis message was flagged as spam by the automatic spam filter.', 228, '0', 0, '', '', 0, 'alwaysspam@secretrepublic.net', 0, NULL, NULL, NULL, NULL, NULL),
(281, 'Transition completed', 'The order #156345 has been completed. The money has been transferred o your account at YourBank.\r\n\r\nThank you for using YourBank, USERNAME', 228, '0', 0, '', '', 0, 'yourbank@secretrepublic.net', 0, NULL, NULL, NULL, NULL, NULL),
(282, 'It\'s been such a long time!', 'Hi USERNAME!\r\nIt\'s been such a long time since the last time we met face to face!\r\nI hope you remember me! Your best friend at the primary school... We dreamt together about our future; we had a great passion about tecnologies, but you went on studying security, penetration testing and so on... and I wanted to become technician.\r\nOk enough about the past: speaking of the present, well I managed to get where I wanted, I am a tecnician, I own a little company which produces servers and PCs, but what about you?\r\nLet\'s see if you really got to the point you wanted to when we were only little boys...\r\nI\'ll give you a series of quests: they will regard our favourit subjects at school and obviously internet security.\r\n\r\nReady to start? Then connect to IP_2 on port 456.\r\n\r\nBTW: It\'s nice to get in touch with you again!\r\n\r\nJack M M', 228, '0', 0, '', '', 0, 'jack_miky_michael@secretrepublic.net', 0, NULL, NULL, NULL, NULL, NULL),
(283, 'JackMikeyMichaelCV.txt', '...\r\nAnd I started working for the CloMed Inc immediately after the school.\r\nThey taught me lots of things which were necessary for me to become who I am.\r\n...', 229, '0', 0, '', '', 0, NULL, 512, NULL, NULL, NULL, NULL, NULL),
(284, 'Contacts.csv', 'Name,Phone,Email\r\nMichael,--,michael_mikey_michael@secretrepublic.net', 229, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(285, 'home.html', '&lt;html&gt;\r\n&lt;head&gt;\r\n&lt;title&gt;Home&lt;/title&gt;\r\n&lt;/head&gt;\r\n&lt;body&gt;\r\n...\r\n&lt;/body&gt;\r\n&lt;/html&gt;', 229, '0', 0, '', '', 0, NULL, 120, NULL, NULL, NULL, NULL, NULL),
(286, 'home.css', 'Some no-more-used css.', 229, '0', 0, '', '', 0, NULL, 5, NULL, NULL, NULL, NULL, NULL),
(288, 'CompanyServers', 'id|Company|IP|Mail\r\n0|Dactyl|IP_6|dactyl@secretrepublic.net\r\n1|Lonman\'s|IP_7|lonmans@secretrepublic.net\r\n2|CloMed Inc.|IP_3|clomed@secretrepublic.net\r\n3|Rafast|IP_8|rafast@secretrepublic.net', 230, '0', 0, '', '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(289, 'JackToUSERNAME.msg', 'Hey friend, you managed to get past the first step! Congratulations! But remember this is only the first...\r\n\r\nNext one: IP_4', 231, '20', 0, '', '', 0, NULL, 500, NULL, NULL, NULL, NULL, NULL),
(291, 'NumberSequences', 'id|sequence|IP\r\n1|1,2,3,4,5|IP_9\r\n2|2,3,5,7,11|IP_10\r\n3|1,3,6,10,15|IP_5\r\n4|-1,1,-1,1,-1|IP_11\r\n5|1,1,2,3,5,8|IP_12\r\n6|1,3,9,27,81|IP_13', 234, '0', 0, '', '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(293, 'security.hash', '6955a349fc2cd7472b6672e7e8c543b6', 235, '50', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(295, 'servers', 'id|ip\r\n1|base64(IP_2)\r\n2|base64(IP_3)\r\n3|base64(IP_4)', 247, '0', 0, '', '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(296, 'to-do-list.txt', 'Be awesome\r\nTell everyone they can\'t hack into my system\r\nTell mom I love her', 248, '0', 0, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(297, 'mygame.gg', 'unreadable data', 249, '0', 1, '', '', 0, NULL, 1000, NULL, NULL, NULL, NULL, NULL),
(298, 'ai.seed', 'unreadable binary data', 252, '30', 1, 'ai.speech|ai.logic', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(302, 'final.sh', '', 85, '0', 1, 'task4.runme', '', 0, NULL, 1000, 'end|lesson', NULL, NULL, NULL, NULL),
(303, 'move.notice', 'base64(Server files have been moved to IP_4 as current server is scheduled to be replaced within 24h)', 253, '0', 0, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(304, 'ai.logic', 'unreadable binary data', 254, '30', 1, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(305, 'ai.speech', 'unreadable binary data', 255, '30', 1, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(306, 'Good job', 'Thank you for your services.\r\n\r\nThis concludes our business arrangements.\r\n\r\nWe no longer require your services.\r\n\r\nGoodbye!', 256, '0', 0, '', '', 0, 'cobra@anonymous.com', 0, '', NULL, NULL, NULL, NULL),
(307, 'cobra.certificate', '', 257, '0', 0, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(309, 'Aurum_magna_potentia.txt', 'Know what this means? It means Gold is power in latin. Funny how those primitive humans thought gold was important  at that time and now people are dying for want of water . But that doesn\'t mean we cant test you and have some fun with you as well .  Goto IP_2 , we want to see if you can handle a little stress.\r\n\r\nRegards \r\nPaladium', 259, '0', 0, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(310, 'Account_Data.regdata', 'This is the transfer fund program. Developed by Marx Digital Solutions. In case of query contact  ph. 987866544. ', 261, '9', 1, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(312, 'file81961422', NULL, 262, NULL, NULL, NULL, NULL, NULL, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(313, 'file21390057', NULL, 262, NULL, NULL, NULL, NULL, NULL, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(314, 'The_Final_Blow', 'Well done. Now time to deal the Final Blow. \r\n\r\nGood Job,\r\nPaladium', 263, '0', 0, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(315, 'Cam.exe', 'Cloaker program developed by Fundamental Machines Inc.', 270, '10', 1, '', '', 0, NULL, 1000, 'fred|rompelberg', NULL, NULL, NULL, NULL),
(316, 'file23654592', '', 270, '6', 0, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(317, 'Forgot Password ', 'You have submitted a forgot password report. Here is the Hint you entered during product validation\r\n\r\n  Who achieved the highest speed ever achieved on a bicycle ?   ', 271, '0', 0, '', '', 0, 'FundamentalMachines.co.uk', 0, '', NULL, NULL, NULL, NULL),
(318, 'System.regdata', 'Controls working of computer \r\n\r\nHint for   Password for execution : The first ever search engine was called ______', 272, '5', 1, '', 'Cam.exe', 0, NULL, 1000, 'archie', NULL, NULL, NULL, NULL),
(319, 'SysLog.log', 'IP_4 logged in\r\n', 269, '0', 0, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(320, 'TEST EMAIL from IP_5', 'System has succesfully loaded the SMTP port.  I will increase the encryption presently. New system\'s IP is IP_5\r\n', 271, '0', 0, '', '', 0, 'IP_5', 0, '', NULL, NULL, NULL, NULL),
(322, 'file37372347', NULL, 270, NULL, NULL, NULL, NULL, NULL, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `quest_files` (`file_id`, `title`, `content`, `service_id`, `encryption`, `canRun`, `requiredToRun`, `requiredOnMainToRun`, `running`, `sender`, `size`, `parameters`, `cantKill`, `requiredObjective`, `burst`, `executionTime`) VALUES
(323, 'Cam.exe', 'Cloaker Software made by Marx Digital Solutions\r\n\r\nUsername: USERNAME\r\nPassword: Paladium', 276, '0', 1, '', '', 1, NULL, 1000, 'USERNAME|Paladium', NULL, NULL, NULL, NULL),
(324, 'The History', 'So how do you like your new Server? Pretty awsome huh? You will be asked to use your server for different purposes later , but for now you can explore the services and files you have. Currently the Cam.exe file is running on port 22 of this server. The password for it is USERNAME Paladium\r\n\r\nSo , you want to know how Paladium emerged right?\r\n\r\nIn the year 2026 Paladium was started by a Japanese hacker known as AKUMA ( Devil ). No one knows much about him. Apparently he was inspired by a group called &quot;Anonymous&quot; which used to exist earlier. He wanted a freedom of information in the web and the equalization of power on the internet.He quickly gained popularity and set out in his work. \r\nHe was a Brilliant hacker who is credited with the downfall of many oppressive governments. He created various programs which increased transparency in the web. He was also the foundation on which these modern, glass terminals are made.In 2043 his most famous software, &quot;Glass&quot; was launched. It allowed people to access real government records without any hindrance, however to stop people form misusing it he made sure a request was sent to him before granting a user access to the records.  In 2056 he vanished without a trace, however , his brainchild Paladium lived on. \r\nPaladium has the world\'s best geniuses working together towards a common goal  : TO STOP ALPHA\r\n\r\nAlpha has shaped the world as it sees fit. It is responsible for the destruction of erstwhile Russia. They needed it\'s Uranium deposits.They launched the Nukes , but the world thought it was the Chinese. That\'s just a small example of how Alpha is manipulating us for its own needs.\r\n\r\nSo , we ask you a question , are you with us? \r\n\r\nIf you are , we have a file in IP_2 , which allows you access to restricted Paladium files and servers for your future missions.\r\nA small cash will be deposited to your account to aid you.\r\nWaiting for your response\r\nPaladium\r\n\r\n\r\n', 277, '0', 0, '', '', 0, 'Paladium@armyspy.com', 0, '', NULL, NULL, NULL, NULL),
(325, 'VirtualAccess.pal', 'This is your key so to say into Paladium Systems and files. You need to run this at your PALADIUM SERVER before attemtping to run Paladium files. The password is USERNAME lvl1\r\n\r\nTransfer this to your PALADIUM SERVER\r\n', 279, '0', 1, '', '', 0, NULL, 1000, 'USERNAME|lvl1', NULL, NULL, NULL, NULL),
(327, 'Key.certificate', 'Allows access to Level-1 Paladium Servers', 281, '0', 1, '', '', 0, NULL, 1000, 'USERNAME|lvl1', NULL, NULL, NULL, NULL),
(328, 'Instructions', 'Good day. Time is of essense today. All Paladium members are on high gear, several ALPHA slaves are being attacked simultaneously. We need you to crack into a few servers and transfer some files to us. These files contain data about other ALPHA slaves or MAIN computers, passwords, usernames. If during your service you find anything with a suspicious you must transfer it to YOUR PALADIUM server. \r\nRegards,\r\nPaladium  ', 282, '0', 0, '', '', 0, 'Paladium@armyspy.com', 0, '', NULL, NULL, NULL, NULL),
(329, 'Remote.access', 'Remote access by IP ..................%error .. IP encrypted%\r\n  to IP_3:@#6%$5', 283, '10', 0, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(330, 'Cam.exe', 'Cloaker Software', 280, '0', 1, '', '', 0, NULL, 1000, 'fred|rompelberg', NULL, NULL, NULL, NULL),
(331, 'Sys.log', 'IP_4 logged in', 284, '30', 0, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(332, 'Attack Details', 'John, Paladium seems to be targeting our systems. Make sure the access code file is safe. You should transfer it to IP_5 to keep it safe\r\nAlpha', 285, '0', 0, '', '', 0, 'Alpha@attack.com', 0, '', NULL, NULL, NULL, NULL),
(333, 'Spy_data.log', 'Paladium Important servers :\r\n\r\nIP_18\r\nIP_43\r\nIP_54\r\nIP_0     [This server has accessed various ALPHA servers in a short time. Attack will begin on it ASAP]\r\nIP_65\r\nIP_34\r\nIP_31\r\nIP_78\r\nIP_18\r\n', 286, '35', 1, '', '', 0, NULL, 1000, 'Alpha|Uranium', NULL, NULL, NULL, NULL),
(334, 'email84600839', 'Sir we have the Tables updated with the latest tables. Paladium servers IP_54  and IP_32 are down. We also got a list of ALL Paladium servers. We are keeping it safe in IP_7  We have also recieved info that IP_0 is a member of Paladium and has hacked class 2 ports IP_3 and IP_2 .He has just DDOS-ed them Jacob is on his trail now. Somehow his trails arent visible to us even in un-modified logs. \r\n\r\nJacob is using IP_9 as his main server for now.', 293, '0', 0, '', '', 0, 'Encrypted@mail.com', 0, '', NULL, NULL, NULL, NULL),
(335, 'Alpha_access.key', 'Alpha_access key Lvl 8\r\n\r\n/puzzle here/', 296, '20', 1, '', '', 1, NULL, 1000, '', NULL, NULL, NULL, NULL),
(336, 'IP_0', 'Sir!\r\nWe have still not manged to find any traces of his access to the servers. However the Files HAVE BEEN transferred. We just can not decrypt his IP. I suggest we ask some one else to deal with this. Our software engineers are trying to reverse engineer the software he has used now.. Hopefully we will be done before he finds out we are onto him. WE WILL DESTROY HIM COMPLETELY \r\nSigning off\r\nAlpha 8', 297, '0', 0, '', '', 0, 'Update@gmail.com', 0, '', NULL, NULL, NULL, NULL),
(337, 'System.log', '', 280, '0', 0, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(338, 'Tracer.troj', 'Allows to trace all IP\'s Who enter the current infected server\r\n\r\n/puzzle enter/', 299, '0', 1, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(339, 'Paladium_server_Database', 'ID|IP address\r\n1|IP_93\r\n2|IP_75\r\n3|IP_64\r\n4|IP_45\r\n5|IP_92\r\n6|IP_54\r\n7|IP_52\r\n8|IP_57\r\n9|IP_85\r\n10|IP_67', 295, '0', 0, '', '', 0, NULL, 0, '', NULL, NULL, NULL, NULL),
(340, 'Data1.exe', 'This is part 1 of the data required to run the Join.exe program', 303, '20', 1, '', '', 0, NULL, 1000, 'Viber', 0, NULL, NULL, NULL),
(341, 'SysLog.log', 'IP_5 transferred Data2.exe to IP_5', 305, '5', 0, '', '', 0, NULL, 1000, '', NULL, NULL, NULL, NULL),
(342, 'Data2.exe', 'This is part 2 of the file needed to run the Join.exe program', 306, '20', 1, '', '', 0, NULL, 1000, 'Alibaba', 0, NULL, NULL, NULL),
(343, 'Hint to you idiots', 'Apparently your hacking skills lack the finesse required to crack the password  --__--\r\n\r\nHere\'s the hint -\r\nWhich online portal gets its name from Arabian Nights ?\r\n', 307, '0', 0, '', '', 0, 'sender@domain.com', 0, '', 0, NULL, NULL, NULL),
(344, 'Hint for dummies , that is YOU', 'Apparently your hacking skills lack the finesse required to crack the password  --__--\r\n\r\nHere\'s the hint -\r\nWhat was founded by four Israeli partners: Talmon Marco, Igor Megzinik, Sani Maroli and Ofer Smocha, with Talmon Marco as its CEO.', 304, '0', 0, '', '', 0, 'sender@domain.com', 0, '', 0, NULL, NULL, NULL),
(345, 'Join.exe', 'Look at the .. NAME ^^^^^^^^^ u will understand what this does.\r\n\r\n\r\nThe Password for this is  &lt;the username of the creator of this game&gt; &lt; the username of the creator of this mission&gt;\r\n', 300, '0', 1, 'Data1.exe|Data2.exe', '', 0, NULL, 1000, 'Cardinal|mage61099', NULL, NULL, NULL, NULL),
(346, 'one', '', 312, '0', 1, '', '', 0, NULL, 1000, 'open sesame', 0, NULL, NULL, NULL),
(348, 'to_do_list.docx', '[color=#307D7E]\r\n1)[/color]\r\nThanks to our engineers that have created some awesome viruses, they gonna be useful in such a situation\r\n These viruses send every movement the enemy does to our mail. \r\nyou can make a copy from our server IP_7 port 22\r\n\r\n[color=#307D7E]\r\n2)[/color] Upload and run the virus on the enemy machines !\r\n[color=#307D7E]\r\n[b]Router 1 :[/b]\r\n[/color]\r\nIP_1\r\nIP_2\r\nIP_3\r\n[color=#307D7E]\r\n[b]Router 2 :[/b]\r\n[/color]\r\nIP_4\r\nIP_5\r\nIP_6\r\n', 315, '0', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(349, 'Message sent from IP_1 to IP_5', 'Ressources sent from IP_9 to IP_8\r\nmessage : \' Enjoy my children! \'', 322, '0', 0, '', '', 0, 'virus@secretrepublic.com', 0, '', 0, 0, NULL, NULL),
(350, 'virus.exe', 'you know you\'re screwed if  you got this running on your machine :D\r\nAli baba from &quot;Ali Baba and the Forty Thieves&quot; used a magical phrase that opens the mouth of a cave in which forty thieves have hidden a treasure.\r\nUse that magical phrase to make this file run !', 323, '25', 1, '', '', 0, NULL, 1000, 'open|sesame', 1, NULL, NULL, NULL),
(351, 'spy.trojan', 'Spyware is software that aids in gathering information about a person or organization without their knowledge and that may send such information to another entity without the consumer\'s consent, or that asserts control over a computer without the consumer\'s knowledge.', 324, '30', 1, '', '', 0, NULL, 1000, '', 0, NULL, NULL, NULL),
(352, 'trojan_horse.exe', 'A Trojan horse, or Trojan, in computing is a generally non-self-replicating type of malware program containing malicious code that, when executed, carries out actions determined by the nature of the Trojan, typically causing loss or theft of data, and possible system harm. The term is derived from the story of the wooden horse used to trick defenders of Troy into taking concealed warriors into their city in ancient Anatolia, because computer Trojans often employ a form of social engineering, presenting themselves as routine, useful, or interesting in order to persuade victims to install them on their computers', 324, '30', 1, '', '', 0, NULL, 1000, '', 0, NULL, NULL, NULL),
(353, 'Acme.exe', 'Upon executing infected EXE, this infects another EXE in current directory by making a hidden COM file with same base name.', 324, '30', 1, '', '', 0, NULL, 1000, '', 0, NULL, NULL, NULL),
(354, 'Acid.670', 'Infects COM file. Disk directory listing will not be altered.', 324, '30', 1, '', '', 0, NULL, 1000, '', 0, NULL, NULL, NULL),
(355, 'AirCop.B', 'Infects the boot sector of floppy disks.', 324, '30', 1, '', '', 0, NULL, 1000, '', 0, NULL, NULL, NULL),
(356, 'Bomber.CB', 'Polymorphic virus which infects systems by inserting fragments of its code randomly into executable files.', 324, '30', 1, '', '', 0, NULL, 1000, '', 0, NULL, NULL, NULL),
(357, 'ILOVEYOU.x', 'A computer worm that attacked tens of millions of Windows personal computers', 324, '30', 1, '', '', 0, NULL, 1000, '', 0, NULL, NULL, NULL),
(358, 'An_old_story.bedtime', 'Legend says there\'s 7 magic files.\r\nThe Dragon files were intended to be a thing of extraordinary magic and power.\r\nSomething to be revered, not for the ease of their method, but for the dream of never having to use them.\r\nI\'ve made a research long time ago and found out that there\'s some organizations hiding them carefully, many people tried to steal them but none of them was successful.\r\nThe organizations that got the files:\r\n\r\nChina :\r\nChina@topsecret.net\r\n\r\nThe United States :\r\nUS@topsecret.net\r\n\r\nGermany :\r\nGe@topsecret.net\r\n\r\nRussia :\r\nRu@topsecret.net\r\n\r\nIndia :\r\nIndia@topsecret.net\r\n\r\nThe United Kingdom :\r\nUK@topsecret.net\r\n\r\nTunisia :\r\nTN@topsecret.net\r\n\r\nAccess our mail service and send the mail i already written for you to each one of them.\r\nLet\'s see if they are willing to cooperate.', 327, '1', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(359, 'Received from \'Gothic\'', 'Greetings ,\r\nYou surely heard about the \'Pink Hat\' and there intents,\r\nWe \'The Cure\' Organization are willing to gather the dragon files as we find it the last hope to stand against them!\r\nIf you would like to help us, it would really make it easier for us to stop them before it\'s too late.\r\nHaving the files before they starts acting will save the world.\r\nSincerely,\r\nThe Cure\'s Leader', 335, '0', 0, '', '', 0, 'Gothic@secretrepublic.net', 0, '', 0, 0, NULL, NULL),
(360, 'MarkListClass1.txt', 'Jose -------- 90\r\nJohn---------78\r\nJack----------78\r\nSherlock---------110\r\nLorde---------78\r\nIdiot--------04\r\nRon------29\r\nHagrid----------21', 336, '20', 0, '', '', 0, NULL, 1000, '', 0, NULL, NULL, NULL),
(361, 'That PUNK!', 'Yo Jose!\r\nsup? DID YOU HEAR THAT TWO PIECE OF TIN  Jacob kissed your Girlfriend? We have already thoght about a payback! You know they go swimming each day at the Sports Complex? We are gonna do some switching ;)\r\nParty on!\r\nMe', 311, '0', 0, '', '', 0, 'werule@partyrox.net', 0, '', 0, NULL, NULL, NULL),
(362, 'ohayo', '', 328, '0', 0, '', '', 0, 'ying_young@domain.com', 0, '', 0, 0, NULL, NULL),
(363, 'Need a cash?', 'Hello there.\r\n We have monitored your net activity and found that you guys were responsible for hacking simultaneously into few pages. That shows promise. If you want to earn some quick cash GOTO IP_2\r\n\r\nRegards\r\nUs', 342, '0', 0, '', '', 0, 'magic@magicnow.com', 0, '', 0, 0, NULL, NULL),
(364, 'Key1.data', 'base64( The password for this is encephalitis ) ', 343, '30', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(365, 'Key2.data', 'base64( The password for this is Microsoft )', 343, '30', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(366, 'Key3.data', 'base64( The password for this is open )', 343, '40', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(368, 'Laserguidance.runx', '&gt;Enter password in order of procurement to run program.', 341, '0', 1, '', '', 0, NULL, 1000, 'encephalitis|Microsoft|open', 0, 601, NULL, NULL),
(369, 'final.sh', '', 345, '0', 1, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(370, 'file38385382', '', 184, '0', 1, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(371, 'runparam', '', 40, '0', 1, '', '', 0, NULL, 1000, 'RAND_S_1_10', 1, 0, NULL, NULL),
(372, 'read-me-not.data', 'RAND_S_0_10', 347, '20', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(373, 'to-read-me-or-not-to-read-me.data', 'RAND_S_1_10', 348, '20', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(374, 'hackdown.sh', '', 349, '20', 1, '', '', 0, NULL, 1000, 'RAND_S_0_10|RAND_S_1_10', 0, 0, NULL, NULL),
(375, 'update.php', '&lt;?php\r\n   /* HACKDOWN */\r\n   echo &quot;Testing server&quot;;\r\n\r\n   $db = mysqli_connect(&quot;IP_2&quot;,&quot;root&quot;,&quot;root&quot;,&quot;parameters&quot;);\r\n\r\n    if (!$db) die(&quot;An error took place&quot;);\r\n\r\n    echo &quot;Everything is good to go&quot;;\r\n', 351, '20', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(376, 'parameters', 'param1|param2\r\nRAND_S_0_10|RAND_S_1_10', 352, '0', 0, '', '', 0, NULL, 0, '', 0, NULL, NULL, NULL),
(377, 'hackdown.sh', '', 350, '0', 1, '', '', 0, NULL, 1000, 'RAND_S_0_10|RAND_S_1_10', 0, 0, NULL, NULL),
(378, 'Instructions', 'Welcome to Hack - Down USERNAME, \r\nThis is not a competition to be taken lightly , you are representing yourself, your zone and your organization here, Bring them honour not shame.\r\n\r\n1st Task \r\nGoto  http://chem4kidz.zohosites.com/ \r\n\r\nFind the password and operate the file in the Main_server to get the IP list generated in the SSH server of the Main Server\r\n\r\nThere  you will have recieve details for the IP you have to Crack. Remember, there are more than two ways its can be cracked.\r\nRegards,\r\nUs\r\n', 355, NULL, 0, '', '', 0, 'sender@domain.com', 0, '', 0, 0, 0, 0),
(379, 'Option1.runme', 'This is the easier and faster way. The HTML page contains the hint to this . Look harder if you haven\'t found it .', 354, '0', 1, '', '', 0, NULL, 1000, 'Cardinal', 0, 0, 1, 0),
(380, 'Option2.runme', 'This is the longer and harder of the 2 options. Well , atleast you learnt something ..... ', 354, '0', 1, '', '', 0, NULL, 1000, 'Bohr', 0, 0, 1, 0),
(381, 'Log.log', 'Log of IP\'s  {fragmented version , goto IP_5 for next part}\r\n\r\nIHP_6_3\r\n\r\n\r\n\r\n', 356, '10', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(382, 'Log2.log', '2nd part of required IP {Fragmented version, refer to IP_4 for other part}\r\n\r\nIRP_6_3\r\n\r\n', 357, '20', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(383, 'IP.docx', 'Run this file to get an automatic email response \r\n\r\nER00r! ErRRo-R!// System Malfunction//\r\n\r\n&gt; Hello there USERNAME , dont be alarmed. We are PALADIUM and are hijacking this computer. Seems like you need a hint..\r\n&gt;Well , here\'s the hint\r\n&gt;&quot;This anime is very popular  and has an entertaining host of Characters. Plue And Frosch are two of these. Name the Anime&quot; \r\n\r\n&gt; Hope that Helped ... Regards\r\n &gt;Paladium', 358, '35', 1, '', '', 0, NULL, 1000, 'Fairytail', 0, 0, 0, 0),
(384, 'normalbbcode', '[color=red]test[/color]', 40, '0', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(385, 'protectedFile.readme', 'Just when we thought you won\'t be able to break through this one.\r\n\r\nOh well. You also need to run this file. You need to find out the required parameter (only one needed). \r\n\r\nThe parameter is a number between 20 and 30.', 364, 'RAND_N_10_100', 1, '', '', 0, NULL, 1000, 'RAND_N_20_30', 0, 0, NULL, NULL),
(386, 'firstParameter.text', 'RAND_S_0_10', 365, 'RAND_N_5_15', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(387, 'secondParameter.text', 'RAND_S_1_10', 365, 'RAND_N_5_15', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(388, 'run.sh', '', 365, '', 1, '', '', 0, NULL, 1000, 'RAND_S_0_10|RAND_S_1_10', 0, 0, NULL, NULL),
(390, 'todays_cars', 'car_id|IP\r\n1|IP_2\r\n2|IP_3\r\n3|IP_4\r\n4|IP_5', 367, NULL, 0, '', '', 0, NULL, 0, '', 0, NULL, NULL, NULL),
(391, 'car.os', '', 368, '', 1, '', '', 1, NULL, 1000, '', 1, 0, NULL, NULL),
(392, 'data.transmit', '', 366, '', 1, 'car.os', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(393, 'transaction.logs', '[10:20] Transaction: 1000$ | Status: Complete | From: John Keller [4356236634] | To: Mirk Pourer [8654354363]\r\n[15:03] Transaction: 5$ | Status: Confirmed and Pending | From: Ronald Smith [334255233] | To: The Street Corner Pizza [342543223]\r\n[16:22] Transaction: 30000$ | Status: Confirmed and Pending | From: Mega Electronics [9324553554] | To: USERNAME [RAND_N_10000000_90000000]', 370, '', 0, '', '', 0, NULL, 1000, '', 0, 622, NULL, NULL),
(394, 'transaction.logs', '[10:20] Transaction: 1000$ | Status: Complete | From: John Keller [4356236634] | To: Mirk Pourer [8654354363]\r\n[15:03] Transaction: 5$ | Status: Confirmed and Pending | From: Ronald Smith [334255233] | To: The Street Corner Pizza [342543223]', 373, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(395, 'overload.vir', '', 370, '', 1, '', '', 0, NULL, 1000, 'IP_3|352', 1, 624, NULL, NULL),
(396, 'crash.sh', '', 370, '', 1, '', '', 0, NULL, 1000, '', 0, 627, NULL, NULL),
(397, 'bank.nodes.scan.results', 'IP_1\r\nIP_3\r\nIP_2', 370, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(398, 'carOS.exploit', '', 375, '', 1, '', '', 0, NULL, 1000, 'IP_1|3756', 0, 631, NULL, NULL),
(399, 'glassDevice.findip.sh', '', 375, '', 1, '', '', 0, NULL, 1000, '', 0, 635, NULL, NULL),
(400, 'glassTablet.findip.sh', '', 375, '', 1, '', '', 0, NULL, 1000, '', 0, 635, NULL, NULL),
(401, 'glassDevice.data', 'Identified devices IP\'s:\r\nIP_2 - running latest version of Cardinal OS', 375, '', 0, '', '', 0, NULL, 1000, '', 0, 638, NULL, NULL),
(402, 'glassTablet.data', 'Identified devices IP\'s:\r\nIP_3 - running latest version of Cardinal OS', 375, '', 0, '', '', 0, NULL, 1000, '', 0, 639, NULL, NULL),
(403, 'notes', 'note_id|content\r\n1|Password for bank account RAND_S_0_15 is RAND_S_1_30.\r\n2|Pass to access foreign account: base64(RAND_S_2_15) is base64(RAND_S_3_30).', 378, NULL, 0, '', '', 0, NULL, 0, '', 0, NULL, NULL, NULL),
(404, 'notes', 'note_id|content\r\n1|Password for bank account RAND_S_0_15 is RAND_S_1_30.\r\n2|Pass to access foreign account: base64(RAND_S_2_15) is base64(RAND_S_3_30).', 379, NULL, 0, '', '', 0, NULL, 0, '', 0, NULL, NULL, NULL),
(405, 'bank.app', '', 380, '', 1, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(406, 'external-zone-bank.app', '', 380, '', 1, '', '', 0, NULL, 1000, 'RAND_S_2_15|RAND_S_3_30', 0, 0, NULL, NULL),
(407, 'access.logs', 'IP|result\r\nIP_4|access denied\r\nIP_9|access granted\r\nIP_10| access granted\r\nIP_5|access denied\r\nIP_11|access granted', 382, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(408, 'access.logs', 'IP|result\r\nIP_9|access granted\r\nIP_4|access denied\r\nIP_11|access granted\r\nIP_5|access denied\r\nIP_10| access granted', 383, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(409, 'access.logs', 'IP|result\r\nIP_4|access denied\r\nIP_9|access granted\r\nIP_11|access granted\r\nIP_10| access granted\r\nIP_5|access denied', 384, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(410, 'members', 'member|IP\r\nRAND_N_1000_100000|IP_6\r\nRAND_N_1000_100000|IP_7\r\nRAND_N_1000_100000|IP_8', 388, NULL, 0, '', '', 0, NULL, 0, '', 0, NULL, NULL, NULL),
(411, 'members', 'member|IP\r\nRAND_N_1000_100000|IP_6\r\nRAND_N_1000_100000|IP_7\r\nRAND_N_1000_100000|IP_8', 389, NULL, 0, '', '', 0, NULL, 0, '', 0, NULL, NULL, NULL),
(412, 'personal.data', '', 390, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(413, 'bank.app', '', 390, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(414, 'messages.archive', '', 390, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(415, 'messages.archive', '', 391, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(416, 'personal.data', '', 391, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(417, 'bank.app', '', 391, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(418, 'bank.app', '', 392, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(419, 'messages.archive', '', 392, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(420, 'personal.data', '', 392, '', 0, '', '', 0, NULL, 1000, '', 0, 0, NULL, NULL),
(421, 'file.log', 'IRP_5_1', 397, '', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(422, 'file.log', 'IRP_5_2', 396, '', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(423, 'file.log', 'IRP_5_3', 395, '', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(424, 'file.log', 'IRP_5_4', 394, '', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(425, 'First.txt', 'Run this to create a file with the IP on the main server\r\n\r\nWhat is the atomic mass of Neodymium?  ( rounded off i.e no decimals ) \r\nName the only confirmed element which is liquid at absolute zero.\r\nName the famous metalloid which is used in computers\r\nFe + Cl2 = ?\r\nThe metal used to recover copper from a solution of copper sulphate is\r\n\r\n\r\n{Write the SYMBOLS or FORMULAE for the last the question}', 398, '10', 1, '', '', 0, NULL, 1000, '144|Helium|Silicon|FeCl3|Fe', 0, 0, 0, 3),
(426, 'Nice Job', 'Nice job getting this far. You are almost done ;) \r\n\r\nSimply crack IP_9  and delete all files found there and DDos both IP_9 and IP_8\r\n\r\n\r\n\r\n', 355, NULL, 0, '', '', 0, 'sender@domain.com', 0, '', 0, 669, 0, 0),
(427, 'file25198694', 'GOTO IP_2', 354, '', 0, '', '', 0, NULL, 1000, '', 0, 667, 0, 0),
(428, 'file41619186', 'GOTO IP_3', 354, '', 0, '', '', 0, NULL, 1000, '', 0, 666, 0, 0),
(429, 'file15038637', 'GOTO IP IP_4', 354, '', 0, '', '', 0, NULL, 1000, '', 0, 668, 0, 0),
(430, 'Task1.txt', 'You may have noticed this file was encrypted. Most files are , so manage your time wisely.\r\n\r\nThe IP adress is IP_2                  \r\n\r\nFind the port yourself , since most employers don\'t know the exact ports you are supposed to be hacking.', 401, '15', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(431, 'Client.exe', 'This compressed file contains the details for our clients.  To auto-transfer it , enter the password and execute the file.\r\n\r\n\r\nClue - Year Steve Jobs Died', 402, '25', 0, '', '', 0, NULL, 1000, '', 0, 0, 1, 2),
(432, 'Training.txt', 'Hello there. Hope you reached this stage without any problems. \r\n\r\nJust to review, you should not have needed to NMAP this, but rather tried the defaule port 22. Also, makw it a habit to check for files every where.\r\n\r\nNow to get on with today\'s lesson.  DDOS puzzles. \r\n\r\nLesson 1\r\nPuzzles will require you to locate and crash servers. Generally companies will hide the IP. Of their important servers. You will have to follow a trail to the required server, to crash it..\r\n\r\n!** TIP Sometimes you\'ll have to retrieve a file then crash. ALWAYS GET THE FILE FIRST. \r\n\r\nThere is no need to crack servers to crash, but maybe some thing fun inside ?\r\n\r\n\r\nTask 1 \r\nGoto IP_2 and find clues to crack the required server. \r\n\r\n\r\n!? A hint has been placed IN your system. Use only if you are stuck. ', 405, '', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(433, 'file49176367', '', 406, '25', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(434, 'file50347680', NULL, 407, NULL, NULL, NULL, NULL, NULL, 'sender@domain.com', 1000, NULL, NULL, NULL, NULL, NULL),
(435, 'Logs.txt', '', 407, '20', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0),
(436, 'Hint.txt', '', 404, '', 0, '', '', 0, NULL, 1000, '', 0, 0, 0, 0);

CREATE TABLE `quest_groups` (
  `qgroup_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `gorder` int(11) NOT NULL DEFAULT '1',
  `level` int(11) NOT NULL DEFAULT '1',
  `qparent` int(11) DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `live_quests` int(11) NOT NULL DEFAULT '0',
  `live_party_quests` int(11) NOT NULL DEFAULT '0',
  `creator_user_id` int(11) DEFAULT NULL,
  `premium` varchar(45) DEFAULT NULL,
  `story` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `quest_groups` (`qgroup_id`, `name`, `gorder`, `level`, `qparent`, `type`, `live_quests`, `live_party_quests`, `creator_user_id`, `premium`, `story`) VALUES
(4, 'Job Work', 1, 1, 0, 2, 4, 0, NULL, NULL, NULL),
(5, 'Zone Wars', 1, 1, 0, 3, 0, 0, NULL, NULL, NULL),
(6, 'Organization Wars', 1, 1, 0, 4, 1, 0, NULL, NULL, NULL),
(8, 'Full Test Group', 1, 200, 0, 6, 0, 0, NULL, NULL, NULL),
(9, 'A new beginning', 2, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(11, 'Wishful Thinking', 5, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(12, 'Dreamful', 2, 1, 49, 1, 3, 0, NULL, NULL, NULL),
(14, 'Dreamless', 7, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(15, 'Computer Science School', 1, 1, 0, 1, 8, 0, NULL, NULL, 1),
(16, 'Tears Of A Clown', 2, 4, 29, 1, 2, 0, NULL, NULL, NULL),
(17, 'AN OLD &quot;FRIEND&quot;', 1, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(18, 'A pit of vipers', 2, 3, 29, 1, 4, 0, NULL, NULL, NULL),
(19, 'Contract Work', 2, 1, 49, 1, 3, 0, NULL, NULL, NULL),
(21, 'TRUTH &amp; JUSTICE', 1, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(22, 'FRIENDLY GAMES', 2, 3, 0, 1, 0, 0, NULL, NULL, NULL),
(23, 'Paladium', 1, 4, 49, 1, 4, 0, NULL, NULL, NULL),
(25, 'Party', 1, 3, 0, 1, 3, 3, NULL, NULL, NULL),
(28, 'The World\'s End', 2, 6, 43, 1, 1, 1, 4047, NULL, NULL),
(29, 'Hackdown', 1, 0, 0, 7, 2, 0, 1564, NULL, NULL),
(30, 'Bad Apple', 1, 3, 0, 1, 2, 0, 1564, 'missionsPack1', NULL),
(31, 'Hacking Points', 1, 0, 0, 8, 1, 0, 1564, NULL, NULL),
(32, 'Hacking Skillz', 1, 1, 0, 1, 1, 0, 3933, NULL, NULL),
(33, 'Colossus', 100, 10, 0, 1, 0, 0, 4170, NULL, NULL);

CREATE TABLE `quest_hosts` (
  `id` int(11) NOT NULL,
  `hostname` varchar(100) NOT NULL DEFAULT 'server',
  `qid` int(11) NOT NULL,
  `discovered` tinyint(1) DEFAULT NULL,
  `maxBounces` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `quest_hosts` (`id`, `hostname`, `qid`, `discovered`, `maxBounces`) VALUES
(1, 'server', 29, NULL, 3),
(21, 'sdfsd', 8, NULL, 3),
(22, 'aff', 8, NULL, 3),
(23, 'server', 8, NULL, 3),
(26, '', 10, NULL, 3),
(27, 'server', 10, NULL, 3),
(51, 'server', 20, NULL, 3),
(52, 'server11', 20, 1, 3),
(53, 'server11', 20, NULL, 3),
(54, 'server11', 20, NULL, 3),
(55, 'server11', 20, NULL, 3),
(56, 'server11', 20, NULL, 3),
(57, 'server11', 20, NULL, 3),
(58, 'server11', 20, NULL, 3),
(60, 'server', 22, NULL, 3),
(61, 'hell.server', 22, 0, 3),
(62, 'server', 23, NULL, 3),
(63, 'echoLTD.com', 23, 0, 3),
(64, 'server', 24, NULL, 3),
(65, 'Company Server', 24, 0, 3),
(68, 'LGH', 24, 0, 3),
(69, 'server', 25, NULL, 3),
(70, 'USERNAME.mail.co', 25, 1, 3),
(71, 'alpha.grid.940630.node', 25, 0, 3),
(72, 'server4', 25, NULL, 3),
(73, 'omega.server', 25, 0, 3),
(74, 'server', 26, NULL, 3),
(76, 'Alpha eServer 4839184', 26, 1, 3),
(77, 'Alpha Terminal 28461-05', 26, 0, 3),
(78, 'Havenly Cooking', 26, 0, 3),
(79, 'Alpha Server 124710247', 26, 0, 3),
(80, 'MAIN COMPUTER', 26, 0, 3),
(81, 'USERNAME.mail.co', 29, 1, 3),
(82, 'server', 30, NULL, 3),
(83, 'Alpha eServer 4839184', 30, 1, 3),
(84, 'USERNAME.storage.omega', 29, 1, 3),
(85, '3006.grid.node', 29, 0, 3),
(86, '1406.grid.node', 29, 0, 3),
(87, '0606.grid.node', 29, 0, 3),
(89, 'server', 32, NULL, 3),
(90, 'server', 33, NULL, 3),
(92, 'server', 34, NULL, 3),
(93, 'server2', 34, NULL, 3),
(94, 'server', 35, NULL, 3),
(95, 'server2', 35, NULL, 3),
(96, 'server3', 35, NULL, 3),
(97, 'server', 36, NULL, 3),
(98, 'server', 37, NULL, 3),
(99, 'server', 38, NULL, 3),
(100, 'server', 39, NULL, 3),
(101, 'server2', 39, NULL, 3),
(102, 'server', 40, NULL, 3),
(103, 'server2', 40, NULL, 3),
(104, 'server3', 40, NULL, 3),
(106, 'server1', 36, 1, 3),
(107, 'server2', 36, 0, 3),
(108, 'server3', 36, 0, 3),
(109, 'server4', 36, 0, 3),
(112, 'server5', 36, 0, 3),
(113, 'server6', 36, 0, 3),
(114, 'server7', 36, 0, 3),
(115, 'server8', 36, 0, 3),
(116, 'server9', 36, 0, 3),
(117, 'server10', 36, 0, 3),
(118, 'server11', 36, 0, 3),
(119, 'server12', 36, 0, 3),
(120, 'server13', 36, 0, 3),
(121, 'server', 41, NULL, 3),
(122, 'Senta Incorporated Mail Server', 41, 0, 3),
(123, 'Senta Incorporated Storage Server', 41, 0, 3),
(124, 'Senta Secured Storage', 41, 0, 3),
(125, 'server', 42, NULL, 3),
(126, 'Somalian Express Mail Server', 42, 0, 3),
(127, 'Somalian Express Storage Server', 42, 0, 3),
(128, 'Enigma File Storage', 42, 0, 3),
(129, 'USERNAME e-mail server', 37, 1, 3),
(130, 'server', 43, NULL, 3),
(131, 'SQL Server', 43, 0, 3),
(132, 'The Ant\'s Den', 43, 0, 3),
(133, 'Modified Log', 43, 0, 3),
(134, 'Tool Server', 43, 0, 3),
(135, 'Scrambler', 43, 0, 3),
(136, 'Mathematics', 43, 0, 3),
(137, 'CAT The Odd One Out', 43, 0, 3),
(139, 'Chemistry Time', 43, 0, 3),
(140, 'Dont Shoot', 43, 0, 3),
(151, 'server8', 37, NULL, 3),
(152, 'Jeff\'s server', 37, 0, 3),
(153, 'server', 44, NULL, 3),
(154, 'storage.server.node.334', 44, 1, 5),
(155, 'company.workstation.32', 44, 0, 3),
(156, 'company.workstation.42', 44, 0, 3),
(157, 'company.workstation.44', 44, 0, 3),
(158, 'unrecognised.server', 44, 0, 3),
(159, 'company.workstation.120', 44, 0, 3),
(160, 'company.workstation.54', 44, 0, 3),
(161, 'company.workstation.354', 44, 0, 3),
(162, 'company.workstation.101', 44, 0, 3),
(163, 'grid-node-3673.alpha.zone', 44, 0, 3),
(165, 'server', 45, NULL, 3),
(166, 'server', 46, NULL, 3),
(167, 'server3', 46, 0, 3),
(168, 'server', 47, NULL, 3),
(169, 'server2', 47, NULL, 3),
(170, 'server3', 47, NULL, 3),
(172, 'server4', 24, 0, 3),
(173, 'server', 49, NULL, 3),
(174, 'unprotected.1', 49, 1, 3),
(175, 'unprotected.2', 49, 1, 3),
(176, 'protected.1', 49, 1, 3),
(177, 'server2', 45, NULL, 3),
(178, 'server3', 45, NULL, 3),
(179, 'server4', 47, NULL, 3),
(180, 'server5', 47, NULL, 3),
(181, 'server', 50, NULL, 3),
(182, 'server6', 50, NULL, 3),
(183, 'server6', 50, NULL, 3),
(184, 'server6', 50, NULL, 3),
(185, 'server6', 50, NULL, 3),
(186, 'server', 51, NULL, 3),
(187, 'server2', 51, NULL, 3),
(188, 'server21', 46, NULL, 3),
(189, 'server21', 46, NULL, 3),
(190, 'server21', 46, NULL, 3),
(191, 'server21', 46, NULL, 3),
(192, 'server21', 46, NULL, 3),
(193, 'server21', 46, NULL, 3),
(194, 'server21', 46, NULL, 3),
(195, 'server21', 46, NULL, 3),
(196, 'server21', 46, NULL, 3),
(197, 'server21', 46, NULL, 3),
(198, 'server21', 46, NULL, 3),
(199, 'server21', 46, NULL, 3),
(200, 'server21', 46, NULL, 3),
(201, 'server21', 46, NULL, 3),
(202, 'server21', 46, NULL, 3),
(203, 'server21', 46, NULL, 3),
(204, 'server21', 46, NULL, 3),
(205, 'server21', 46, NULL, 3),
(206, 'server21', 46, NULL, 3),
(207, 'master.security.42', 32, 0, 3),
(208, 'slave.security.57', 32, 0, 3),
(209, 'slave.security.61', 32, 0, 3),
(210, 'slave.security.23', 32, 0, 3),
(211, 'master.security.35', 32, 0, 3),
(212, 'master.security.106', 32, 0, 3),
(213, 'master.security.108', 32, 0, 3),
(214, 'slave.security.99', 32, 0, 3),
(215, 'server', 52, NULL, 3),
(216, 'First Step', 52, 0, 5),
(217, 'Almost There', 52, 0, 5),
(218, 'server', 53, NULL, 3),
(219, 'USERNAME.mail.server', 53, 1, 3),
(220, 'michael.public.server', 53, 0, 3),
(221, 'clomed.storage.server', 53, 0, 3),
(222, 'michael.node.131', 53, 0, 3),
(223, 'michael.node.552', 53, 0, 3),
(224, 'omega.storage.234', 53, 0, 3),
(225, 'temparary.storage.8', 53, 0, 3),
(226, 'public.mail.server', 53, 0, 3),
(227, 'troll.fake.server', 53, 0, 3),
(228, 'home.server.1', 53, 0, 3),
(229, 'host.server.host', 53, 0, 3),
(230, 'racket.server.downstairs', 53, 0, 3),
(231, 'my.private.server', 53, 0, 3),
(232, 'server21', 53, NULL, 3),
(233, 'server', 54, NULL, 3),
(234, 'server', 55, NULL, 3),
(235, 'research-facility-3006', 55, 1, 3),
(236, 'server', 56, NULL, 3),
(237, 'server2', 56, NULL, 3),
(238, 'server3', 56, NULL, 3),
(239, 'server4', 56, NULL, 3),
(240, 'server5', 56, NULL, 3),
(241, 'research-facility-2405', 55, 1, 3),
(242, 'research-facility-1996', 55, 1, 3),
(243, 'research-facility-3007', 55, 0, 3),
(244, 'USERNAME.email.server', 55, 0, 3),
(245, 'server', 57, NULL, 3),
(246, 'server', 58, NULL, 3),
(247, 'server2', 58, 0, 3),
(248, 'server3', 58, NULL, 3),
(252, 'Unidentified_server', 58, 0, 3),
(253, 'server7', 58, 0, 3),
(254, 'server', 59, NULL, 3),
(255, 'server2', 59, 1, 3),
(256, 'server3', 59, 1, 3),
(257, 'server4', 59, NULL, 3),
(258, 'server5', 59, NULL, 3),
(259, 'server6', 59, NULL, 3),
(260, 'server', 60, NULL, 3),
(261, 'paladium_server', 60, 1, 3),
(262, 'server3', 60, NULL, 3),
(263, 'server', 61, NULL, 3),
(264, 'Paladium_server', 61, 1, 3),
(265, 'Slave1', 61, 0, 3),
(266, 'System_server', 61, 0, 3),
(267, 'Alpha_mail', 61, 0, 3),
(268, 'Secure_server', 61, 0, 3),
(269, 'Alpha2', 61, 0, 3),
(270, 'Sql_Safehouse_server', 61, 0, 3),
(271, 'Alpha_Fort', 61, 0, 3),
(272, 'Alpha_employee', 61, 0, 3),
(273, 'Paladium_server', 61, 0, 3),
(274, 'Infect_server', 61, 0, 3),
(275, 'server', 62, NULL, 3),
(276, 'server2', 62, NULL, 3),
(277, 'server3', 62, NULL, 3),
(278, 'server4', 62, NULL, 3),
(279, 'server5', 62, NULL, 3),
(280, 'server6', 62, NULL, 3),
(281, 'server', 63, NULL, 3),
(282, 'email', 63, 1, 3),
(283, 'server', 64, NULL, 3),
(284, 'server4', 64, NULL, 3),
(285, 'server', 65, NULL, 3),
(286, 'R1 M1', 65, 0, 3),
(287, 'R1 M2', 65, 0, 3),
(288, 'R1 M3', 65, 0, 3),
(289, 'R2 M1', 65, 0, 3),
(290, 'R2 M2', 65, 0, 3),
(291, 'R2 M3', 65, 0, 3),
(292, 'TheCure Server', 65, 1, 10),
(293, 'Pink Hat', 65, 0, 3),
(294, 'pink hat main', 65, 0, 3),
(295, 'server', 66, NULL, 3),
(296, 'server2', 66, NULL, 3),
(297, 'server', 67, NULL, 3),
(298, 'server3', 67, NULL, 3),
(302, 'server', 68, NULL, 3),
(303, 'China', 68, 0, 3),
(304, 'The United States', 68, 0, 3),
(305, 'Germany', 68, 0, 3),
(306, 'Russia', 68, 0, 3),
(307, 'India', 68, 0, 3),
(308, 'The United Kingdom', 68, 0, 3),
(309, 'Tunisia', 68, 0, 3),
(310, 'The Cure', 68, 1, 3),
(312, 'school', 63, 0, 3),
(313, 'Party Rox', 63, 0, 3),
(314, 'Secured System', 63, 0, 3),
(315, 'server', 69, NULL, 3),
(316, 'server2', 69, NULL, 3),
(317, 'server3', 69, NULL, 3),
(318, 'server', 70, NULL, 3),
(319, 'server', 71, NULL, 3),
(320, 'server2', 71, 1, 3),
(321, 'server548', 71, 1, 3),
(322, 'server513', 71, 1, 3),
(323, 'server', 72, NULL, 3),
(324, 'server752', 72, 1, 3),
(325, 'server394', 72, NULL, 3),
(326, 'server', 73, NULL, 3),
(327, 'Main_server', 73, 1, 3),
(328, 'The_longerpath', 73, 0, 3),
(329, 'The_ShorterPath', 73, 0, 3),
(330, 'L1', 73, 0, 3),
(331, 'L2', 73, 0, 3),
(332, 'OB1', 73, 0, 3),
(333, 'http://chem4kidz.zohosites.com/the-answer-key.html', 73, 0, 3),
(334, 'ddos', 73, 0, 3),
(335, 'DDOS2 and crack', 73, 0, 3),
(336, 'server', 74, NULL, 3),
(337, 'server671', 74, 1, 3),
(338, 'server216', 74, NULL, 3),
(339, 'server', 75, NULL, 3),
(340, 'tezla', 75, 0, 3),
(341, 'server384', 75, NULL, 3),
(342, 'server352', 75, NULL, 3),
(343, 'server274', 75, NULL, 3),
(344, 'server22', 75, NULL, 3),
(345, 'server', 76, NULL, 3),
(346, 'bank-node-RAND_N_1000_10000', 76, 0, 3),
(347, 'bank-node-RAND_N_1000_10000', 76, 0, 3),
(348, 'bank-node-RAND_N_1000_10000', 76, 0, 3),
(349, 'server446', 76, NULL, 3),
(350, 'server', 77, NULL, 3),
(351, 'electric.car.RAND_N_1000_300000', 77, 0, 0),
(352, 'glassDevice', 77, 0, 3),
(353, 'glassTablet', 77, 0, 3),
(354, 'server173', 77, 0, 3),
(355, 'server', 78, NULL, 3),
(356, 'org.server.1', 78, 0, 3),
(357, 'org.server.2', 78, 0, 3),
(358, 'org.server.3', 78, 0, 3),
(359, 'RAND_S_0_5', 78, 0, 3),
(360, 'RAND_S_1_5', 78, 0, 3),
(361, 'personal.server.RAND_N_10_10000', 78, 0, 3),
(362, 'personal.server.RAND_N_10_10000', 78, 0, 3),
(363, 'personal.server.RAND_N_10_10000', 78, 0, 3),
(364, 'server747', 78, NULL, 3),
(365, 'server249', 78, NULL, 3),
(366, 'server748', 78, NULL, 3),
(367, 'server245', 38, 1, 3),
(368, 'server674', 38, 1, 3),
(369, 'server758', 38, 1, 3),
(370, 'server510', 38, 1, 3),
(371, 'server551', 38, NULL, 3),
(372, 'server', 79, NULL, 3),
(373, 'server373', 79, NULL, 3),
(374, 'server137', 79, NULL, 3),
(375, 'server29', 79, NULL, 3),
(376, 'server', 80, NULL, 3),
(377, 'Sunshine Shoes', 80, 0, 3),
(378, 'server233', 80, NULL, 3),
(379, 'server607', 80, NULL, 3),
(380, 'server905', 80, 0, 3),
(381, 'server', 81, NULL, 3);

CREATE TABLE `quest_notepad` (
  `notepad_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `quest_objectives` (
  `id` int(11) NOT NULL,
  `qid` int(11) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT 'ping',
  `side` int(11) DEFAULT NULL,
  `story` text CHARACTER SET utf8 NOT NULL,
  `data` varchar(200) DEFAULT NULL,
  `oorder` int(11) NOT NULL DEFAULT '0',
  `extraTime` int(11) DEFAULT NULL,
  `achievement_id` int(11) DEFAULT NULL,
  `compulsory` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `quest_objectives` (`id`, `qid`, `type`, `side`, `story`, `data`, `oorder`, `extraTime`, `achievement_id`, `compulsory`) VALUES
(18, 8, 'hack', NULL, 'Congratz it works\r\n\r\nIP_2', 'IP_2', 9, 0, 0, 0),
(19, 10, 'ping', NULL, '', '', 0, 0, 0, 0),
(46, 10, 'decrypt_file', 19, '', '', 0, 0, 0, 0),
(47, 8, 'ping', NULL, 'dfasfsadf', 'IP_2', 6, 0, 0, 0),
(48, 8, 'ping', 18, '', '', 0, 0, 2, 0),
(49, 8, 'ping', 47, '', NULL, 0, NULL, NULL, 0),
(72, 20, 'ping', NULL, 'Should give 3000 seconds extra time and an achievement, Test.\r\n\r\nOrder 0. Decrypt enc.\r\n\r\nRAND_S_1_10\r\n\r\nRAND_S_1_20', NULL, 0, 0, 2, 0),
(73, 20, 'ping', NULL, 'Another 3000 extra time.\r\n\r\nOrder 1.\r\n\r\nAchievement test 2\r\n\r\nRun canrun:IP_0:100\r\n\r\nRAND_S_0_20\r\nRAND_S_1_20\r\nRAND_S_2_20\r\nRAND_S_3_20', NULL, 1, 3000, 3, 0),
(74, 20, 'ping', NULL, 'Order 2 \r\n\r\nkill file\r\n\r\nencrunrun:IP_0:100\r\n\r\nRAND_S_2_20\r\nRAND_S_3_20', NULL, 2, 0, 0, 0),
(75, 20, 'ping', 73, '', NULL, 0, NULL, NULL, 0),
(76, 20, 'ping', NULL, 'Crack IP_1 on port 120\r\n\r\nIP_1:120\r\n\r\nHas sub-objective of nmap IP_1 with achievement && time 1000!\r\n\r\nRAND_S_0_20\r\nRAND_S_1_20\r\nRAND_S_2_20\r\nRAND_S_3_20', NULL, 3, 0, 0, 0),
(77, 20, 'nmap', 76, '', 'IP_1', 0, 1000, 4, 0),
(78, 20, 'ping', NULL, 'Ping IP_1\r\n\r\nThat\'s it. Nice right?', 'IP_1', 4, 0, 0, 0),
(79, 20, 'connect', NULL, 'Connect to IP_1:120', 'IP_1:120', 5, 0, 0, 0),
(80, 20, 'delete_file', NULL, 'Delete .hidden file from IP_1:120\r\n', '.hidden', 6, 0, 0, 0),
(81, 20, 'transfer', NULL, 'Transfer from IP_1:120 transfermetomain to main\r\n\r\nSideobjective decrypt transfermetomain Gives 1000 extra time', 'transfermetomain|IP_0:100', 7, 0, 0, 0),
(82, 20, 'decrypt_file', 81, '', 'transfermetomain', 0, 1000, 0, 0),
(83, 20, 'ping', NULL, 'cat canrun', NULL, 8, 0, 3, 0),
(84, 20, 'connect', NULL, 'asfas \r\n\r\nconnect to IP_1:130', 'IP_1:130', 9, 0, 0, 0),
(85, 20, 'delete_email', NULL, 'Main objective delete email 1 IP_1:130\r\n\r\nSecondary objective Read email 0|IP_1:130\r\n\r\nSecondary objective forward email 0|USERNAME@secretrepublic.net|IP_1:130', '1|IP_1:130', 10, 0, 0, 0),
(86, 20, 'read_email', 85, '', '0|IP_1:130', 0, 0, 0, 0),
(87, 20, 'forward_email', 85, '', '0|USERNAME@secretrepublic.net|IP_1:130', 0, 0, 0, 0),
(88, 20, 'sql_delete', NULL, 'users|1|IP_1:140', 'users|1|IP_1:140', 11, 0, 0, 0),
(89, 22, 'ping', NULL, 'Hello USERNAME,\r\n\r\nWe\'ve seen your interest data decryption gigs. Fortunately, we\'ve recently put our hands on some... sensitive data. Our analysts would be able to make sense of it, but it\'s been heavily encrypted.\r\n\r\nThat\'s where you come in. We\'ve placed the files on a temporary server.\r\n\r\nHere\'s the IP address: IP_1\r\n\r\nAn SSH service is online on the default port (22).\r\n\r\nWe hope you are up for the job,\r\nSee you in hell.\r\n[i]Email received from unknown location[/i]', NULL, 1, 0, 0, 0),
(90, 23, 'run_file', NULL, 'Think fast, USERNAME.\r\n\r\nWe\'ve placed a special file on your system. Find it, decrypt it and run it.\r\n\r\nMore details later on.\r\n\r\nTic-tac, tic-tac, the clock starts and never stops.', 'run.me', 1, 300, 0, 0),
(91, 23, 'ping', NULL, 'We acknowledge your skills.\r\n\r\nSorry for putting you through a test so out of a sudden, but it was.. necessary.\r\n\r\nOn the dark side of things, we need you to hack into a couple of servers, decrypt the files you find there and transfer them back on your server.\r\n\r\nFirst things first. Make your way into IP_1, there\'s an SSH service running somewhere on there and some of our competitor\'s files should be inside.\r\n\r\nTime is of the essence.', NULL, 2, 0, 0, 0),
(92, 24, 'ping', NULL, 'Welcome, [color=cyan]USERNAME.[/color]\r\nAs your AI, I will guide you through each and every mission you receive as time goes on.\r\n\r\nYour first objective is to [color=orange]ping[/color] and connect to the main [color=orange]SSH[/color] server of one of our companies that we believe has become corrupted. Available ports are 89 or 510 as the server has two services running on it.\r\n\r\nThe IP address is IP_1. \r\n\r\nAs the server may still have some sort of protection I was instructed to advise you to use the &quot;[color=orange]crack[/color]&quot; command if you encounter any difficulties in your attempt at connecting to the server. \r\n\r\n[color=red]Reminder: The crack and connect commands must be followed by the port adress you want to connect to.\r\n\r\nReminder: To connect to a server you must first introduce the service type it\'s using, then it\'s IP and port. \r\n[/color]\r\n [color=cyan]Example:\r\nssh IP_1 89[/color]\r\n\r\n[color=red]Reminder: Use a space to separate the port number from the IP number.\r\n[/color]', NULL, 0, 60, 0, 0),
(93, 24, 'ping', NULL, 'That IP is... the adress of an e-mail server? \r\n\r\nUpon further inspection the server seems to be a basic [color=orange]SMTP[/color]. It has... a multitude of ports available... almost entirely open.\r\n\r\nThe whole situation seems fishy.\r\n\r\nI suggest using the most secure port available: 3123. \r\n\r\nIt\'s not much I can do to prevent any sort of malware infiltrating our server once you are connected to it.\r\n\r\n[color=cyan]It\'s your call.[/color]\r\n\r\n...but, I guess you can always resort to bouncing...\r\n\r\n[color=red] Reminder: What bouncing does is when you connect to an IP and port, it will redirect your connection through all of the servers on the bounce list. Trace level increases slower but logs are made on all used servers. You can add only servers of which services you have all cracked. You can bounce a limited amount of times through each server.\r\n\r\nReminder: To add a server to your bouncing list you must use the &quot;[/color][color=orange]bounce[/color][color=red]&quot; command followed by the action you want to do, [/color][color=orange]add/remove[/color][color=red], then typing the IP and port adress.\r\n\r\nReminder: To check the staus of your bouncing list, type &quot;[/color][color=orange]bounce status[/color][color=red]&quot;.\r\n[/color]', NULL, 2, 120, 0, 0),
(95, 24, 'ping', NULL, 'In order to navigate a SSH server, you must first know more about this service.\r\n\r\nA SSH server  contains files, most of the time. As with every type of server everything is done via the console.\r\nYou can see the files of a SSH server by using of the &quot;[color=orange]ls[/color]&quot; command.\r\n\r\n[color=red]Reminder: Files can be either executables or documents. Use the &quot;[/color][color=orange]cat[/color][color=red]&quot; command followed by the name of the file to read it. Use the &quot;[/color][color=orange]run[/color][color=red]&quot; command followed by the name of the file to run it.[/color]\r\n\r\n[color=red]Reminder: If the file has any sort of security mesure added you can decrypt it by typing &quot;[/color][color=orange]decrypt[/color][color=red]&quot; followed by the name of the file [/color]\r\n', NULL, 1, 0, 0, 0),
(96, 24, 'connect', 92, '', 'IP_1:89', 0, 0, 0, 1),
(97, 24, 'cat', 95, '', 'file4640259', 0, 0, 0, 1),
(99, 24, 'connect', 93, '', 'IP_2:3123', 0, 0, 0, 1),
(104, 22, 'decrypt_file', 89, '', 'backup.sql', 0, 0, 0, 1),
(105, 25, 'ping', NULL, '[i]A girl slowly approached me. She doesn’t look older than I am. I can’t feel the black floor keeping us from falling and when I glanced around I saw nothing, only darkness. \r\n\r\nHer hair was waist-long white and her eyes pale blue. She wore a nightgown as black as the darkness around us and was barefooted. I stared into those soulless eyes and it felt weird but, at the same time, right. An eternity later her lips parted and Emilia’s crystal clear voice engineered to the last sound to be nothing less than perfect whispered.\r\n\r\n“This is the path you have chosen”\r\n\r\nWhen I tried to question, I found myself unable to make any sound or even move my feet from the floor they seemed glued to.\r\n\r\n“It’s not going to be easy, it never is. But you will go on, for the sake of us all. Every step you’ll make will be towards fame and power, towards an unavoidable destiny”\r\n\r\nIronically, right there and then, I couldn’t have put one foot in front of the other, even if they wouldn’t have been firmly stuck to the floor.\r\n\r\n“And so the endless cycle will complete itself once more”\r\n\r\nThe voice turned into a distant echo and faded away, but her words lingered inside of my mind, forever.[/i]\r\n\r\nWhen I opened my eyes, I found myself staring into my room’s ceiling. The same dream.. again. Those pills didn’t help a bit now did they?\r\n\r\nI make my way out of the bed and to my desk next to the glass wall offering an outstanding view of our what we like to call state of the art city.\r\n\r\n“Another day in paradise..”\r\n\r\nI decide to check my emails in an attempt to take my mind off these messed up dreams I’ve been having lately. All the stress couldn’t have helped either, right?\r\n\r\nI read of the address of my private mail server from the glassy surface of the desk.\r\n\r\nIP_1\r\n\r\nI think I remember running the server on the default email secure port 465.', NULL, 1, 0, 0, 0),
(106, 25, 'connect', 105, '', 'IP_1:465', 0, 0, 0, 1),
(107, 25, 'ping', NULL, 'Hmmm.. there’s something weird in the log data. As if someone has tampered with it, but if that’s the case that person is too good, way to good.\r\n\r\nWhat\'s with this email? The Omega\'s? They finally got back to me...\r\n\r\nThey want me to what?!', NULL, 2, 0, 0, 0),
(108, 25, 'read_email', 107, '', '2|IP_1:465', 0, 0, 0, 1),
(109, 25, 'ping', NULL, 'Some kind of test. I can\'t say I didn\'t see this one coming.\r\n\r\nLooks like it\'s hacking time. What better way to start the day?', NULL, 3, 0, 0, 0),
(110, 25, 'connect', 109, '', 'IP_2:42', 0, 0, 0, 1),
(111, 25, 'ping', NULL, 'Looks like this is the right port.\r\n\r\nI\'ll just stick my nose around a bit. No harm intended, of course.\r\n\r\nHmm.... what do we have here?', NULL, 4, 0, 0, 0),
(112, 25, 'connect', 111, '', 'IP_4:24', 0, 0, 0, 1),
(113, 25, 'ping', NULL, 'This seems to be one of their private servers. They\'re usually nearly impossible to find.\r\n\r\nThere\'s a file with my name on it... I sure hope it\'s not another challenge.', NULL, 5, 0, 0, 0),
(114, 25, 'delete_file', 113, '', 'USERNAME.readme', 0, 0, 0, 1),
(116, 24, 'ping', NULL, 'All traces have been deleted. \r\nThis server... It makes me feel... exposed.\r\n\r\n[color=red] Reminder: Use the &quot;[/color][color=orange]get[/color][color=red]&quot; command to return the list of e-mails.\r\n\r\nReminder: Use the &quot;[/color][color=orange]read[/color][color=red]&quot; command followed by the number of the e-mail in order to read it.\r\n[/color]', NULL, 3, 60, 0, 0),
(117, 24, 'read_email', 116, '', '0|IP_2:3123', 0, 0, 0, 1),
(118, 24, 'ping', NULL, 'This is... rather unpleasant...\r\n\r\nEven though all data has been deleted, this e-mail remains... We should be able to analyze it... with some help.\r\n\r\nI\'ve contacted an Alpha team. They requested to forward the e-mail to this adress:\r\n\r\ntma19275@a.com\r\n\r\nYou should logout once you forward the e-mail... I don\'t like this place...\r\n\r\n[color=red] Reminder: To forward and e-mail use the &quot;[/color][color=orange]forward[/color][color=red]&quot; command followed by the number of the e-mail and the adress you want to send it to.\r\n[/color]', NULL, 4, 0, 0, 0),
(119, 24, 'forward_email', 118, '', '0|tma19275@a.com|IP_2:3123', 0, 0, 0, 1),
(121, 26, 'ping', NULL, 'This time, we\'ll have to be quick. We just got an e-mail from a corrupted source. \r\n\r\nIf you don\'t remember it, your  [color=orange]SMTP[/color] service port is 974.\r\n\r\n[color=red]Reminder: Check the Discovered Hosts tab on the right to view the hosts you have acces to.[/color]\r\n', NULL, 1, 0, 0, 0),
(122, 26, 'connect', 121, '', 'IP_1:974', 0, 0, 0, 1),
(123, 26, 'ping', NULL, 'Huh?\r\nThere are two now... \r\n\r\nEither way, check the 4th first.\r\n\r\n[color=red] Reminder: Use the &quot;[/color][color=orange]get[/color][color=red]&quot; command to return the list of e-mails.\r\n\r\nReminder: Use the &quot;[/color][color=orange]read[/color][color=red]&quot; command followed by the number of the e-mail in order to read it.\r\n[/color]', NULL, 2, 30, 0, 0),
(124, 26, 'read_email', 123, '', '3|IP_1:974', 0, 0, 0, 1),
(125, 26, 'ping', NULL, 'I don\'t have enough time to trace the ID before he gets away!\r\n\r\nYou can check the other e-mail now... \r\nWe won\'t be able to catch him anyway.', NULL, 3, 30, 0, 0),
(126, 26, 'read_email', 125, '', '4|IP_1:974', 0, 0, 0, 1),
(127, 26, 'ping', NULL, 'This man is a hacker, just like you! He must have noticed some anomalies earlier and traced him down!\r\n\r\nThat adress... it\'s an Alpha Terminal! He\'s bouncing!\r\nWe are not supposed to access one, not at this level anyway, but... If I overwrite my settings...\r\n\r\nDone!\r\n\r\nI managed to open a single port: 3675. It\'s an [color=orange]SSH[/color] server.', NULL, 4, 60, 0, 0),
(128, 26, 'connect', 127, '', 'IP_2:3675', 0, 0, 0, 1),
(129, 26, 'ping', NULL, 'He left in a hurry... The logs are still intact.\r\n\r\nThe next sever on his bouncing list is... a bakery\'s [color=orange]SSH[/color] server?\r\nI won\'t judge...\r\n\r\nIP: IP_3\r\nPort: 7923', NULL, 5, 0, 0, 0),
(130, 26, 'connect', 129, '', 'IP_3:7923', 0, 0, 0, 1),
(131, 26, 'ping', NULL, 'An [color=orange]SSH[/color] Alpha Server next? \r\nThis guy is on a roll.\r\n\r\nIP: IP_4\r\nPort: 941', NULL, 6, 60, 0, 0),
(132, 26, 'connect', 131, '', 'IP_4:941', 0, 0, 0, 1),
(133, 26, 'ping', NULL, 'Huh? He managed to compromize an Alpha server this badly?\r\n\r\nI don\'t like where this is going, but I can\'t treace him anymore. He must have removed all his servers from the bounce list.\r\n\r\nThe damage done here is extensive... but... that file... open it.', NULL, 7, 0, 0, 0),
(134, 26, 'cat', 133, '', 'Quiiiiiiiiiiiiiiiz_Timeeeeeeeeeeeeee!', 0, 0, 0, 1),
(135, 26, 'ping', NULL, 'He is playing with us.\r\n\r\nFind out what he is talking about!\r\n\r\n[color=red]Reminder: You can see you previous comands by pressing the up arrow key.[/color]\r\n', NULL, 8, 180, 0, 0),
(136, 26, 'connect', 135, '', 'IP_5:14', 0, 0, 0, 1),
(137, 26, 'ping', NULL, 'He... the Alpha-Killers... I don\'t know what it means...\r\n\r\nI have nothing on my database about such an organization...\r\n\r\nInspect that file.', NULL, 9, 60, 0, 0),
(138, 26, 'cat', 137, '', 'The_Alpha-Killers', 0, 0, 0, 1),
(139, 26, 'ping', NULL, '&quot;You have no ideea what you are getting into&quot;, huh?\r\n\r\nWe shouldn\'t stick our noses any further than this.\r\n\r\nLogout from the server and be done with it.', NULL, 10, 0, 0, 0),
(140, 29, 'ping', NULL, '[i]Having said that, Alpha Day hit the humankind as a forced wake up call. \r\n\r\nAt exactly 01:00 AM, standard time, the third planet from the Sun went silent. Suddenly the Terra looked as if devoid of technologically advanced life. Every piece of tech ceased to function. Satellites surveyed the dark side of the planet, helplessly witnessing the lights going off one by one as if an electromagnetic pulse was propagating on a planetary scale. Communications, weaponry, electricity, transports, planes, ships, hospitals, all gone in the short blink of an eye [...][/i]\r\n\r\nI stop next to the girl who up till then was relating  not long past events to the kids who have gathered around her, willing to listen.\r\n\r\n[b]You\'re still telling that story?[/b], I ask.\r\n\r\n[b]What do you mean \'still\'? It\'s our history[/b]\r\n\r\n[b]It\'s depressing[/b]\r\n\r\n[b]Just real[/b]\r\n\r\n[b]Could I steal you for a second? We need to talk... in.... private[/b]\r\n\r\nShe stands up with a sigh and follows me outside of the underground pub. \r\n\r\n[b]So what\'s so important that you couldn\'t let me depress those kids to boredom?[/b]\r\n\r\n[b]I\'ve received this email a few minutes ago. I think you might want to take a peak. I\'ll forward it to you, what\'s your local ID?[/b]\r\n\r\n[b][i]chloe@omega1406.temp[/i][/b]\r\n\r\nI take out my Glass Mobile Device and once my terminal popped up I began forwarding her the email from my private server IP_1:23.\r\n', NULL, 1, 0, 0, 0),
(141, 29, 'ping', NULL, '[b]You\'re kidding right, USERNAME?[/b]\r\n\r\n[b]Looks legit, I\'m pretty sure it was sent on the official channel.[/b]\r\n\r\n[b]So you\'re actually going up there. You\'ll have some pretty great opportunities to... poke around.[/b]\r\n\r\n[i]Going into Iris. Almost seems surreal really.[/i]\r\n\r\n[i]Iris is meant to be the proverbial eye in the sky. Constructed with state of the art technology, its computational power is driven entirely on quantum computers. The processing speed of data driven out of these computers was far superior to the ones used before World War III. The entire ship became Alpha’s main research centre. The material used to manufacture the structure for Iris is called graphene, another research field Alpha had taken upon themselves to bring to its full potential after the war. Graphene is, more or less, an atom thin layer of graphite, a 2-dimensional highly durable material with countless properties, making it most suitable choice for the orbital station. Due to graphene’s complex attributes, the entire body of Iris was a solar panel in itself, thinner than a piece of paper and stronger than any other known-to-human material. \r\n\r\nNot to mention the entire thing is as light as a feather. Capable of sustaining over thirteen research laboratories on Earth’s low orbit, completely controlled by Emilia and its own inner grid, Iris is nothing less than the technological peak of Alpha’s efforts. The station uses literally close to no energy what-so-ever, is self-driven and self-maintenanced. There’s no public information regarding on exactly what kind of experiments are taking place inside the station or what defensive and offensive capabilities Iris has, but one would be blind to take any of them lightly. Iris was pretty imposing at first and even second sight, looking as if had just been pulled out of a science fiction movie, gracefully circling our planet. Naturally, some believed it was yet another mean of grasping the control they had over the world even tighter in their strong fist. Rumours Alpha was planning to built another station on orbit of Mars and even colonise the red planet for its natural resources were not uncommon.\r\n\r\nA few years ago Iris’s assembly procedure on Earth’s orbit began. It took the corporation two years to complete it. Piece by piece, hundreds of rocket launches had taken place to bring all the necessary modules Iris was made out of into the vastness of space. The station went online without any major technical difficulties on the 14th of December, 2050, and, since then, has greatly been speeding up their researches.\r\n\r\nNot many civilians, if any, ever got the one in a lifetime chance to cast an eye inside Alpha’s masterpiece. Every year, twenty two students, one from each zone, were picked, embarked on a spacecraft made from the same futuristic designs and launched into outer space, on a collision trajectory with Iris. Obviously, only less important areas are shown to them, in a guided tour lead by one of Alpha’s top researchers. After all, even they had to recruit bright young minds to keep on working on what they’ve started. When the couple of hours the tour needed to complete had passed, the group of students is brought back on Earth, usually with an offer to join one of the research groups, depending on their domain of expertise and interests.\r\n\r\n[b]And I? I am going into the Iris.[/b]\r\n[/i]\r\n\r\nSeeing I\'ll need to get my hands on as much information as possible while up there, I decide on investigating the Iris, perhaps finding some Security Access Codes to allow me to move more freely once I\'m inside their local system. We have been unable to penetrate their shields from the outside by no means. We believe they don\'t even connect to Earth\'s network except for two random times per day and their security protocols are just... off the charts.\r\n\r\nWe\'ve recently found a couple of Grid Nodes on our scans. These nodes seem to be somehow related to Iris and might contain useful data.\r\n\r\nI think I might just have a look. I remember storing a list of IP\'s on my secure storage server IP_2:465.\r\n\r\nI\'d better take a look as soon as possible. I simply cannot afford losing any more time.\r\n', NULL, 2, 0, 0, 0),
(142, 29, 'forward_email', 140, '', '0|chloe@omega1406.temp|IP_1:23', 0, 0, 0, 1),
(143, 30, 'ping', NULL, '', NULL, 1, NULL, NULL, 0),
(144, 29, 'connect', 141, '', 'IP_2:465', 0, 0, 0, 1),
(145, 29, 'ping', NULL, 'Looks like a handful. I\'ll have to go through each and everyone of those and transfer all the files I find to my server IP_2:465.\r\n\r\nI really hope there\'s something on at least some of these nodes.', NULL, 3, 0, 0, 0),
(146, 29, 'transfer', 145, '', 'iris.security.certificate|IP_2:465', 0, 0, 0, 1),
(147, 29, 'transfer', 145, '', 'access.codes.iris|IP_2:465', 0, 0, 0, 1),
(148, 29, 'crack', 145, '', 'IP_5:286', 0, 0, 0, 1),
(151, 29, 'ping', NULL, 'That seems to be all.\r\n\r\nI\'ll just connect back to my email server to confirm my attendance.\r\n\r\nIP_1:23\r\n\r\nI hope I won\'t throw up during take off..', NULL, 4, 0, 0, 0),
(152, 29, 'connect', 151, '', 'IP_1:23', 0, 0, 0, 1),
(153, 32, 'ping', NULL, 'The next five days passed in a blur. In the blink of an eye I was dressed in a light spacesuit and watching the other passengers occupying their seats in the shuttle, readying themselves for take-off towards the Iris.\r\n\r\nA huge digital wall, which I believe must somehow be protected against the launch vibrations, was positioned a small distance from the front row. Five minutes before lift-off, the lights dimmed and the same man that announced the Alpha Treaty Conference all those years back stood in front of us. He hadn’t changed a bit from the materials I studied in the library.\r\n\r\nHe looked around, as if bodily present, eyeing each and everyone of us and then calmly spoke.\r\n\r\n“Welcome. You alone have been chosen among few others to represent your Zones. Students have been hand-picked and filtered, automatically and manually, and you… you stood out, because you are at the top of the game. An offer to join one or more research groups will be delivered to you as soon as your visit is over. They say eyes are the gateway to the human soul. If so, you’re going to take a peek through the keyhole. Alpha would like to wish you a pleasant trip into the Iris. Departure in T minus 5, 4, 3, 2, 1”\r\n\r\nI could hear some of the students screaming as we burst through the sound barrier and soon enough gravity was no more. The screen now displayed the front view of the shuttle, as we got closer and closer to the stations. I felt as on a whole new level of Alpha was being revealed to me as I saw the space-station getting bigger and bigger. The planet also came into view as we began docking procedures.\r\n\r\nDocking in progress. Please stay seated. Be careful while entering the station, artificial gravity field is active.\r\n\r\nEmilia’s familiar voice spoke and the screen turned off suddenly, the lights coming back on.\r\n\r\n“Ladies and gentlemen, welcome to Iris. This is your captain, we will begin deboarding the craft in a few minutes. Please make sure you won’t leave anything behind”\r\n\r\nI can feel the electric excitement in the air. All of them are eager to go and are talking passionately about what might be waiting for us. I’m excited nonetheless, but perhaps for other reasons. I don’t want to see only what they want us to see. I don’t have any plan. However, hopefully, through improvisation I’ll be able to slip by our guard and have a look around and find some more information about Alpha. This place must be filled with their secrets. The internal self-sustaining grid connects to Earth only twice a day, at random times, and with heavy usage of quantum cryptography to shield the data stream. In those few seconds that the transfer lasts, enough data to take one human a couple lifetimes to study is passed through.\r\n\r\n“If you’ll follow me, please. The lab ahead is where we operate our genetic research”\r\n\r\nThe type of discoveries in that department were considered even more controversial than the others. Alpha’s ethics were highly debatable at best. For example, cloning was something they were willing to experiment with with, even where humans were concerned. Playing god has never caused any real ethical breach, it was even encouraged to try and bend the laws of nature to ones will. This entire Iris project promoted that vision.\r\n\r\nI looked around the futuristic corridor leading to the BioSpace Research laboratory, my peers far ahead, following the Alpha representative like mere sheep. I moved my hand to the motion sensor of the bathroom door, hoping they won’t start a general search when they realize I\'ve been left behind. I washed my face with cold water and sneaked a look at myself mirror self, reminescenting the odd series of events that had taken me up here.\r\n\r\nThe bathroom door closed shut with a slight thud. I noticed my group was nowhere to be seen. Curiosity and impatience are not a good combination, I soon learned.\r\n\r\nUnable to just stay put and wait for them, she turned right at the first opportunity and kept on walking through a surprisingly long corridor. The walls resembled huge screens, an endless stream of data flowing endlessly across the graphene surface.\r\n\r\nI soon came across a closed glass door just as wide as the entire corridor. A glass panel waited expectantly on the wall to my left. And my vision to the beyond was blurred out my the texture of the glass wall.\r\n\r\nI connect my Portable Glass Device into the panel and think about my course of action.\r\n\r\nI located the IP of the local master security server, IP_1.\r\n\r\nMy theory is that I need find my way in and transfer a copy of the security certificate I have compiled, from my local storage to the slave servers I should be able to gain the addresses of once I control the master.\r\n\r\nTo copy the certificate from a server to another I can use [b]scp filename IP port[/b].\r\n\r\nI must make sure I delete logs behind me to keep them from tracing me. Even on servers I connect only to SQL, I\'ll have to check for an SSH port to execute [b]rm logs[/b] on when I\'m done with it.\r\n\r\nFingers crossed.', NULL, 1, 0, 0, 0),
(154, 33, 'ping', NULL, '*HEAVY COUGH*\r\n\r\nWelcome to [b]Alpha\'s Computer Science Qualification Crash-Course[/b]. Designated course code COMP101.\r\n\r\nMy name is Alex and I\'ll be your instructor for the day.\r\n\r\nThe school has asked me to give you a lesson on how to manage files on the Cardinal OS so let\'s not waste any more valuable time and get right to it, shall we now?\r\n\r\nYou bunch don\'t look to enthusiast but that\'s none of my concern so please focus on the console interface.\r\n\r\nThe [b]console[/b] allows you to interact directly with the Cardinal Operating System running on your machine or other servers.\r\n\r\nIt should be familiar to those who dealt with one flavour or another of UNIX, a system used before the last war.\r\n\r\nYou\'re currently logged in your school account and we\'ve pushed a couple of files for you to play with during our session together.\r\n\r\n[b]Fair warning [i]Trying to skip ahead or playing around unattended might ruin the lesson for you completely and we\'ll have to start over. I will not be pleased if something like that were to happen[/i].[/b]\r\n\r\nThe command you will most likely find yourself using all the time is [b]/help[/b]. Try it now and see what it does. Also give a try to the [b]man[/b] as explained when you view the output of [b]/help[/b].\r\n\r\n*HEAVY COUGH*\r\n\r\nFor starters, please note the list of DISCOVERED HOSTS. The first few will be the servers you own. Note the hostname is the one set in the Servers Interface. The first one is the main server you have set in the Servers Interface, the server you are connected to by default. The one to which you find yourself on whenever you logout from any other host. You cannot connect to that main server since that is the server you connect from to any other server.\r\n\r\n\r\nMost basic of commands you should know of is [b]ls[/b].\r\n\r\nThe [b]LS (ls)[/b] command will provide you with a [u]list of available files[/u] on the server you are connected to. [b]ls[/b] has some other tricks under its sleeve but we\'re not going to talk about them. However, we\'re more than curious if you can discover them for yourselves.\r\n\r\nBack on track, I hope you\'ve already tried the command and discovered it does exactly what you\'d expect.\r\n\r\n[b]Another useful piece of magic is pressing the Up and Down arrows. They allow you to navigate through a short history of commands you have entered in the console.[/b]\r\n\r\nGive a try to the first command you\'ve seen presented by [b]/help[/b], the [b]ifconfig[/b] instruction. \r\n\r\nThis command shows basic info about the host you are currently connected 2. If you are not connected to any host it will show the info of your main server in the mission. You will find yourself using it for example when you need to transfer files to your main computer and you need to know its IP and this is one of the only ways to find it out. Or at times you might need to find other details like the version of the Operating System running on a computer.\r\n\r\nYou must know that when you start you\'re always connected to your main computer which always runs an SSH service on port 22. You might want to make a habit out of always using [b]ifconfig[/b] to take note of your main computer\'s IP before moving on to any other tasks.\r\n\r\nThere are 3 files present. Your first task is to delete the first file.\r\n\r\nThe command required to do just that is \r\n[b]rm filename[/b]', NULL, 1, 0, 0, 0),
(158, 33, 'delete_file', 154, '', 'task1.txt', 0, 0, 0, 1),
(159, 33, 'ping', NULL, 'Good stuff, newbies.\r\n\r\nNext thing on the list is [i]reading a file contents[/i].\r\n\r\nYou can obviously only view the contents of files that are not encrypted and are not executables. If you attempt to read such files you\'ll most likely end up with a chunk of non-human-readable text filling up your screen.\r\n\r\nOur command of choice for that sort of thing is [b]cat filename[/b].\r\n\r\nWhy the name? Maybe the creator liked kitties?\r\n\r\nMoving on. Your second task is to read the contents of [i]task2.txt[/i] using [b]cat[/b] and follow the instructions I\'ve provided inside.\r\n\r\nThink you can handle that?', NULL, 2, 0, 0, 0),
(160, 33, 'cat', 159, '', 'task2.txt', 0, 0, 0, 1),
(162, 33, 'decrypt_file', 159, '', 'task3.txt', 0, 0, 0, 1),
(163, 33, 'kill_file', 159, '', 'task4.runme|IP_0:22', 0, 0, 0, 1),
(164, 34, 'ping', NULL, 'My name is Crow.\r\n\r\nMy course is simple and I always start off with a true story:\r\n\r\n[i]A crow was sitting on a tree, doing nothing all day. A small rabbit saw the crow, and asked him:\r\n\r\n\"Can I also sit like you and do nothing all day long?\" \r\n\r\nThe crow answered: \r\n\"Sure, why not.\" \r\n\r\nSo, the rabbit sat on the ground below the crow, and rested. \r\n\r\nAll of a sudden, a fox appeared, jumped on the rabbit and ate it.[/i]\r\n\r\nMoral of the story?\r\n\r\nTo be sitting and doing nothing, you must be sitting very, very high up. Now, let\'s see if you\'re today\'s rabbit.\r\n\r\nIn the Cardinal OS architecture, SMTP servers handle emails: sending, receiving and storing. SMTP originally means \"Simple Mail Transfer Protocol\", but now it can be used to store emails as well, handling virtually all aspects of email services.\r\n\r\nOnce connected to a SMTP server you can send emails or play around with the stored emails without needing other protocols. \r\n\r\nI\'ve set up a small and protected email server for you to hack and play with.\r\n\r\nHost: IP_1\r\n\r\nIt\'s running on the default SMTP port. If you don\'t know which that is, you\'ll have to scan for open ports then make your way into the system (have you forgotten the scan command already? Try [b]/help[/b], in case you did. You might want to note these down).\r\n\r\nI\'ll provide you with more details at the right time.\r\n\r\nTo connect to a SMTP server you use the following command:\r\n[b]smtp ip port[/b]', NULL, 1, 0, 0, 0),
(165, 34, 'connect', 164, '', 'IP_1:25', 0, 0, 0, 1),
(166, 35, 'ping', NULL, 'My name is Not Important, but you can call me Nort. What matters is that I\'ll be your instructor for the next few minutes.. so you\'d better listen carefully. \r\n\r\nAre you thinking \"or what?\" right now? Well, when you need this knowledge in a life or death situation don\'t come back crying to me.\r\n\r\nYou\'d better wipe those smirks off your faces and erase that all-knowing look from your eyes and we\'ll get along just fine.\r\n\r\nSSH comes from Secure Shell and is a cryptographic network protocol for secure data communication, remote command-line login, remote command execution, and other secure network services between two networked computers. It connects, via a secure channel over an insecure network, a server and a client running SSH server and SSH client programs, respectively.\r\n\r\nTo put it simply: it allows you to connect to another compute and execute commands on it, for example, to manipulate files.\r\n\r\nThe Cardinal Operating System, most if not all computers in the world run right now, has both an SSH server and client by default.\r\n\r\nBefore we move forward, let\'s explore some useful commands.\r\n\r\nTry [b]ifconfig[/b] - Shows data about current host (IP, MAC address, port). We\'ve already seen it in account earlier.\r\n\r\nThe IP is what identifies a computer on the Grid. It\'s, in lack of better terms, the address or location of a server but it doesn\'t necessarily make reference to the physical location of the machine.\r\n\r\n[b]ping ip[/b] - Confirms that the host exists and is online. If found, the host is added to your known hosts list.\r\n\r\n[b]nmap ip[/b] - Shows a list of services and the ports they are running on.\r\n\r\nAnd our desired command for the day\r\n[b]ssh ip port[/b]\r\n\r\nThe first server I want you rookies to connect via SSH to is IP_1. The SSH service is running on the default port. \r\n\r\nI am not, however, going to tell you which that port is. If you know it already, brilliant. Otherwise, call [b]nmap[/b] on IP_1 to see which ports have running services on them and then connect to the SSH service using the [b]ssh[/b] command mentioned above.\r\n\r\nYou next task awaits after you\'ve successfully connected to IP_1\'s SSH server.', NULL, 1, 0, 0, 0),
(167, 35, 'connect', 166, '', 'IP_1:22', 0, 0, 0, 1),
(168, 35, 'ping', NULL, 'Hmm.. interesting. I didn\'t expect you especially to understand this stuff.\r\n\r\nOh well.. let\'s wait for your colleagues to catch up and then we\'ll continue.\r\n\r\nOk, then. Time to move forward.\r\n\r\nSome servers have extra protection on ports to protect the services they host.\r\n\r\nWe have to break through the encryption in order to access the services.\r\n\r\nIP_2 has a protected SSH server running on port 22.\r\n\r\nThe following command allows you to hack the encryption:\r\n\r\n[b]crack IP port[/b]\r\n\r\nWhat are you waiting for? Give it a try, my hair is going white!\r\n\r\n[i]It\'s already white.[/i]\r\n\r\nOhh.. and to log out of a host you must enter\r\n[b]logout[/b] \r\n\r\nPretty damn complicated, right?', NULL, 2, 0, 0, 0),
(169, 35, 'crack', 168, '', 'IP_2:22', 0, 0, 0, 1),
(170, 35, 'ping', NULL, 'The encryption should be out of the way. Confirm your success by connecting to IP_2:22.\r\n\r\nWith this we\'ll conclude our lesson.\r\n\r\nIt\'s been not such a big pleasure meeting you.\r\n\r\nBye cookies.. I meant rookies, my sweet apologies.', NULL, 3, 0, 0, 0),
(171, 35, 'connect', 170, '', 'IP_2:22', 0, 0, 0, 1),
(172, 35, 'ping', NULL, 'Did you REALLY think I\'ll let you off the hook so easily?\r\n\r\nI mean.. seriously?! hahahahahha!\r\n\r\nEvery year rookies... every single year.\r\n\r\nThere\'s one more thing I want to show you. Call it.. a bonus.\r\n\r\nOn IP_2:22 is a file, as you SHOULD\'VE noticed.\r\n\r\nA special command on the Cardinal OS allows you to transfer files from one host\'s SSH service to another. Well.. the files must not be encrypted or running when the command is executed, but otherwise it\'ll do the job.\r\n\r\nTo transfer a file we write:\r\n\r\n[b]transfer filename target_ip target_port[/b]\r\n\r\nWhere the IP and port are the destination. The destination must be a service of the same kind, SSH.\r\n\r\nIf you\'d like to finally get rid of me, [b]please transfer file.transferme from IP_2 to IP_1[/b].\r\n\r\nWe also can take advantage of the [b]scp[/b] command which works the same way just that instead of transferring it will create a copy of the file on the designated target. Use [b]/help and man[/b] for more info.\r\n\r\nAllons-y!', NULL, 4, 0, 0, 0),
(173, 35, 'transfer', 172, '', 'file.transferme|IP_1:22', 0, 0, 0, 1),
(174, 34, 'ping', NULL, 'You\'re now connected to my test SMTP server.\r\n\r\nLet\'s see what tools we have at our disposal.\r\n\r\nFirstly, [b]get[/b].\r\n\r\nPlain and simply. It returns a list of available emails, stored in the server database.\r\n\r\nThere are two emails.\r\n\r\nTo read one of them we write\r\n\r\n[b]read ID[/b]\r\n\r\nWhere the ID is the number presented in front of each email.\r\n\r\nWe shall move forward as soon as you\'ve read the contents of both emails.', NULL, 2, 0, 0, 0),
(175, 34, 'read_email', 174, '', '0|IP_1:25', 0, 0, 0, 1),
(176, 34, 'delete_email', 174, '', '1|IP_1:25', 0, 0, 0, 1),
(178, 34, 'ping', NULL, 'Forward.\r\n\r\nI mean literally, forward!\r\n\r\nForwarding an email can be very useful at times. For example if you want a copy of it on your email server or if you want to send it to third-parties.\r\n\r\nThe all-mighty command for doing such is\r\n\r\n[b]forward ID email[/b]\r\n\r\nOne neat trick is to forward an email to yourself!\r\n\r\n[b]forward ID username@secretrepublic.net[/b]\r\n\r\nYou\'ll receive a copy for safe keeping outside of the mission.\r\n\r\nPlease forward the remaining email to me at instructor@cs.alpha.zone to wrap this up.', NULL, 3, 0, 0, 0),
(179, 34, 'forward_email', 178, '', '0|instructor@cs.alpha.zone|IP_1:25', 0, 0, 0, 1),
(180, 36, 'ping', NULL, '[i]So USERNAME, you\'re our new agent huh? \r\n\r\nI never heard of you before. I should have gone with ProblemChild or Disposable Unit for this mission, but they had more important things to do.\r\n\r\nSo you will be assigned on low priority missions.Yes...get used to that definition...[b]LOW..PRIORITY[/b].\r\n\r\n*sigh* Anyway here goes nothing. Last night around 5:05 our internal server got hacked.\r\n\r\nAll the files inside were deleted. But since we were going to get rid of that server anyway, it contained nothing more then some old government manuals and foreign country spy reports.\r\n\r\nHalf of those countries don\'t even exist anymore..good luck finding all those Islands on the map now that half of the Earth is flooded.\r\n\r\nAnyway, even though we can\'t care less about some outdated files which got erased, we were going to do it anyway, we still got our pride!\r\nIt\'s up to you to catch him and to deliver him a nasty surprise once found...that is..IF you can find him.\r\n...\r\nWhich I doubt.\r\n...\r\nYou might as well resign now!\r\n...\r\nStill here?\r\n...\r\n*sigh*\r\n...\r\nThe job explanation can be found in your email inbox.\r\nJust make sure you don\'t mess up on the first assignment, because if you will it will also be your last![/i]\r\n\r\n\r\n[b]He\'s daring me. I like it. Might just be fun. I\'m going to check my mail server.[/b]', NULL, 1, 0, 0, 0),
(181, 37, 'ping', NULL, 'I was worked for Blune Inc. as a programmer. I had a colleague called Jeff. He was a good programmer. But he made a mistake. He wanted to make money, but in a bad way. He was built a backdoor to an Anti-virus program, to steal the users datas. He wasnt very careful. A tester found his backdoor. Jeff and I were fired. They thought i was in that bullshit, too. I stayed here, tried to find another job, and Jeff left Chicago. I was mad at him! I lost my job, because of him!\r\nThis was 3 years ago. Since that, i never heard about Jeff again...\r\n\r\nPresent:\r\nI\'m working on an algorythm, when someone knocks on my door. I open the door, then... I was shocked. It was Jeff. I just want to shut the door, but he stopped me.\r\n[b]-I know what you think. But let me talk first.[/b]\r\n[b]-3 years ago you ruined my life! It took me 2 years to climb back from the sh*t hole![/b]\r\n[b]-Listen! I have a job for you! You can earn a lot of money.[/b]\r\nI should hear him out. But no. I don\'t care.\r\n[b]-Just go away, or I will call the police![/b]\r\n[b]-Okay, the i will send you a message then. It will contains every info you need. If you change your mind.[/b]\r\nMaybe i will read that message. My ip is IP_1 and my SMTP port is 22', NULL, 1, 0, 0, 0),
(182, 38, 'ping', NULL, 'We have four servers for you.\r\n\r\nEach server contains only one file.\r\n\r\nEach file has a part of an IP.\r\n\r\nYour final task is to hack and connect to that ultimate IP.', NULL, 1, 0, 0, 0),
(183, 39, 'ping', NULL, 'We started with about one hundred and fifty of you in this course?\r\n\r\nNow there\'s about what.. seven?\r\n\r\nLooks like even in these troubled times, when these skills are of utmost importance, only so many people are aware of what\'s ahead the road.\r\n\r\nIn any case, we have a few more lectures to attend to before we can call it a wrap for the Alpha Computer Science Crash-Course.\r\n\r\nOne simple word describing the most complex of simple matters: [b]DATABASE[/b].\r\n\r\nDatabases store data, information, in a structured way. Usually in such a way that is easily searchable, indexable. They are used for storing all kinds of data from words to images, from credit cards to DNA sequences, from you to me.\r\n\r\nLooks like the tech team has finished preparing our test SQL Database server.\r\n\r\nYou can connect to an SQL server using the following command\r\n\r\n[b]sql host_ip host_port[/b]\r\n\r\nSimilarly to how you connect to an SSH or SMTP service.\r\n\r\nEveryone connect to IP_1 on port 1433.', NULL, 1, 0, 0, 0),
(184, 39, 'ping', NULL, 'Alrighty then. \r\n\r\nFirst but not least we want to see all available data in the database so we know what we are dealing with here.\r\n\r\nFor files we use [b]ls[/b]. For databases we need to execute a [i]query[/i].\r\n\r\nThat\'s an instruction sent to the database server which processes it and returns a result.\r\n\r\nNow that we are connected to the server, we can send queries and the output will be revealed to us.\r\n\r\nSending the following query will return a list of available [b]tables[/b] which are in a way the base unit databases are split into.\r\n\r\n[b]show tables[/b]\r\n\r\nThere\'s only on table here and it\'s called [i]users[/i].\r\n\r\nNow let\'s select all the data from inside the [i]users[/i] table.\r\n\r\n[b]select * from users;[/b]\r\n\r\nThis will return all the rows (in this case accounts) in the [i]users[/i] table.\r\n\r\nThis isn\'t very tricky I hope but it might need some getting used to. Luckily you can redo any step of this course whenever you feel like you need a refresher. And again the [b]/help[/b] command is vital anytime you feel lost.\r\n\r\nTo delete a record we use\r\n\r\n[b]delete from TABLE where COLUMN = \"VALUE\";[/b]\r\n\r\nFor example to delete the account Claw we can execute\r\n\r\n[b]delete from users where name = \"claw\";[/b]\r\n\r\nThe command will erase her row from the table.\r\n\r\nYour most final task is to eliminate Razor from the [i]users[/i] table, following the Claw example.', NULL, 2, 0, 0, 0),
(187, 39, 'connect', 183, '', 'IP_1:1433', 0, 0, 0, 1),
(188, 39, 'sql_delete', 184, '', 'users|1|IP_1:1433', 0, 0, 0, 1),
(189, 40, 'ping', NULL, 'I received a somewhat of an interesting email last night.\r\n\r\nI haven\'t paid too much attention to it but after a good night sleep I think it might be worth reading one more time.\r\n\r\nIf I recall correctly, I saved it on IP_1. The email server should be on port 325. It hosts one of my personal addresses, USERNAME@secretrepublic.net\r\n\r\nI\'ll go and take a another look.', NULL, 1, 0, 0, 0),
(190, 40, 'ping', NULL, 'I remember reading about the Cobra\'s. They\'re some elite agency used by rich corporations in their schemes to take down competition and for state of the art corporate espionage.\r\n\r\nI\'ve never heard of them recruiting people lacking experience as much as me.. but you never hear from actual individuals who work for them... only rumours.\r\n\r\nI guess I have nothing to lose when I think about it so the hell with it.\r\n\r\nIt\'s time to taste the venom of a cobra.', NULL, 2, 0, 0, 0),
(191, 40, 'connect', 189, '', 'IP_1:325', 0, 0, 0, 1),
(192, 40, 'forward_email', 190, '', '0|USERNAME@secretrepublic.net|IP_1:325', 0, 0, 0, 1),
(193, 40, 'ping', NULL, 'What is this?\r\n\r\nAs soon as I forwarded the email my Glass Device blinked. I got a message from the operating system itself. These guys are good, no kidding.\r\n\r\n[i]\r\nWe are very glad indeed to have you on our team. We\'ll start you off with an easy task we need completed right away for a valuable client.\r\n\r\nYour orders are to make your way into the following server\'s SSH service and delete all the files you find in there in order to disable the companies website for the time being. We have no information as to the port the service is running on.\r\n\r\nIP_2\r\n[/i]', NULL, 3, 0, 0, 0),
(194, 40, 'connect', 193, '', 'IP_2:24', 0, 0, 0, 1),
(195, 40, 'ping', NULL, 'Looks like the file is here. \r\n\r\nBio-keltech? \r\n\r\nThey\'re some sort of new company with big breakthroughs that I heard is recruiting many biotech graduates recently help out with their big deal research stuff.\r\n\r\nI\'ll just delete the file and then log back in to my email server and wait for further instructions I guess.\r\n\r\nHave I just made a pact with the devil?', NULL, 4, 0, 0, 0),
(196, 40, 'delete_file', 195, '', 'index.html', 0, 0, 0, 1),
(197, 40, 'connect', 195, '', 'IP_1:325', 0, 0, 0, 1),
(198, 36, 'connect', 180, '', 'IP_2:80', 0, 0, 0, 1),
(199, 36, 'ping', NULL, 'Good you\'re here, now get to work USERNAME!', NULL, 2, 0, 0, 0),
(200, 36, 'cat', 199, '', 'connection.logs', 0, 0, 0, 1),
(201, 36, 'ping', NULL, 'These are all the connections and logouts that were made that day.\r\nThis is where the bounce route ended it seems.\r\nStrange....\r\nOh wait, I see what he did there.\r\nYou probably dont.\r\nShould I call someone else to do the job? \r\nI got ProblemChild on speed dial you know. hahaha', NULL, 3, 0, 0, 0),
(202, 36, 'ping', NULL, 'I cant believe it! You actually found the source of the attack.\r\nAll of our old files are there and this is the end of the line so this has got to be the hacker who\'s responsible.\r\nDid you figured out that he used a log deleter and log editor to alter the connections.log or did you asked a friend to help you with that?\r\n\r\n\r\nI see that he has a executable virus program on his computer, the same one he tried to use on our server.\r\nThe virus failed to upload properly on our server but maybe you could be more successfull by using his own weapon against him.\r\n\r\nLet Mr. Bozo get a taste of his own medicine, good luck USERNAME.', NULL, 4, 0, 0, 0),
(203, 36, 'connect', 201, '', 'IP_13:233', 0, 0, 0, 1),
(206, 41, 'ping', NULL, 'Hello, USERNAME.\r\nI have an offer to make to you, one that I\'m sure you will like. If you accept, you\'ll need to delve into this mail server I\'ve discovered.\r\n\r\nIP_1:22 \r\n\r\nOnce you\'re in, I\'ll contact you with more information as to what you\'re looking for.', NULL, 1, 0, 0, 0),
(207, 41, 'connect', 206, '', 'IP_1:22', 0, 0, 0, 1),
(208, 41, 'ping', NULL, 'Good. You\'re not as dumb as some people make you out to be. Well, let\'s continue, shall we?\r\n\r\nI need you to sift through this server, and locate an IP of their storage server. I hope it\'s still here, as they are required to delete all emails on a weekly basis.', NULL, 2, 0, 0, 0),
(209, 41, 'read_email', 208, '', '1|IP_1:22', 0, 60, 0, 1),
(210, 41, 'ping', NULL, 'Hm... That was rather easy. Oh well, best not to dwell on it. Follow that IP, see what we can find. \r\nOh! In case you forgot it already, the IP was: IP_2', NULL, 3, 0, 0, 0),
(211, 41, 'connect', 210, '', 'IP_2:541', 0, 60, 0, 1),
(212, 41, 'ping', NULL, 'Nice work there. See what you can find here. Follow any leads to your final destination.', NULL, 4, 0, 0, 0),
(213, 41, 'cat', 212, '', 's_list', 0, 0, 0, 1),
(214, 41, 'ping', NULL, 'We\'ve found it! Or rather... you\'ve found it! Good work! Now I need you to follow that last IP. Clear out the new server of all of it\'s data. Leave no traces behind. This server should be the host for their security certificate. If you delete that, then the system stops trusting itself and shuts down. You\'ll leave this a huge pain in the ass for anyone trying to fix it.', NULL, 5, 0, 0, 0),
(215, 41, 'connect', 214, '', 'IP_3:228', 0, 0, 0, 1),
(216, 41, 'delete_file', 214, '', 'security.cert', 0, 0, 0, 1),
(217, 40, 'delete_file', 195, '', 'data.json', 0, 0, 0, 1),
(218, 40, 'delete_file', 195, '', 'script.js', 0, 0, 0, 1),
(223, 36, 'decrypt_file', 202, '', 'Zeus.exe', 0, 0, 0, 1),
(225, 42, 'ping', NULL, '[b]Hello, USERNAME.[/b] \r\nNice meeting you here. Ya\' know, you should get to encrypting this server a little better. I\'ve uploaded some files for you to read using the [i]ls[/i] command.\r\nJust follow that IP, then I\'ll tell you what to do from there.', NULL, 1, 200, 0, 0),
(227, 42, 'connect', 225, '', 'IP_1:428', 0, 0, 0, 1);
INSERT INTO `quest_objectives` (`id`, `qid`, `type`, `side`, `story`, `data`, `oorder`, `extraTime`, `achievement_id`, `compulsory`) VALUES
(228, 42, 'ping', NULL, 'Good. Now, sift through these emails. We need to get to their storage server.', NULL, 2, 60, 0, 0),
(230, 42, 'ping', NULL, 'Nice! Now, just transfer everything from this server to IP_3 at port 22, then you\'re done.', NULL, 3, 0, 0, 0),
(231, 42, 'transfer', 230, '', 'file72886981|IP_3:22', 0, 0, 0, 1),
(232, 42, 'transfer', 230, '', 'verification.key|IP_3:22', 0, 0, 0, 1),
(233, 42, 'transfer', 230, '', 'access.logs|IP_3:22', 0, 0, 0, 1),
(234, 42, 'transfer', 230, '', 'se.txt|IP_3:22', 0, 0, 0, 1),
(235, 37, 'ping', NULL, 'So there is the file. So i just need to transfer it to IP_3 Port:134\r\n\r\nThis is simple... Too simple... Maybe this is a test? Or a trap?', NULL, 2, 0, 0, 0),
(236, 37, 'read_email', 181, '', '0|IP_1:22', 0, 120, 0, 1),
(237, 37, 'transfer', 235, '', '.datas.txt|IP_3:134', 0, 0, 0, 1),
(238, 37, 'ping', NULL, 'Okay. I\'m done. I should go back to my server, and delete that message...', NULL, 3, 0, 0, 0),
(239, 37, 'delete_email', 238, '', '0|IP_1:22', 0, 0, 0, 1),
(240, 44, 'ping', NULL, '[i]Hey kiddo,\r\n\r\nI\'m your handler this time. As usual we do not give our name, but you can call me Eliot.\r\n\r\nI, of course, already know who you are.\r\n\r\nThis time we got a big one for you. This is a mission on a need-to-know basis. Our employer will remain a secret for you but we\'ll try to give you all the details needed for you to get to the bottom of this.\r\n\r\nOne of our smaller teams already tried to find the target but has failed.. miserably. \r\n\r\nThe company that hired us has recently been engaged in heavy duty corporate espionage with quite a number of other companies.\r\n\r\nThey suspect a recent loss of confidential data has taken place on their system and they obviously blame one of their market enemies for it.\r\n\r\nOur job is to analyse their system, follow each possible route and hopefully located the files. As soon as you find them, transfer them to your local drive.\r\n\r\n[b]Fair hint: run ifconfig on your default server to find out your server IP that you need to transfer the files 2[/b] \r\n\r\nThe lost files contain data for the latest generation of Grid Nodes which are to be installed next week. The data is heavily encrypted but in a few days time it can be cracked so the faster you get to them the better. They own a patented encryption algorithm so you might find yourself unable to read most of the files. \r\n\r\nDo I need to remember you how careful you need to be in these situations? I hope not.\r\n\r\nThe company has granted us access to secure storage server used for storing the mission files: IP_1. Make sure you investigate [b]all of its ports thoroughly[/b].\r\n\r\n[b]You are also ordered BIT to decrypt or read any of the research files[/b] as it would not only be against our agreement with the client but you will waste very valuable time breaking their encryption keys.\r\n\r\n[color=red][b]Taking in account how much time has passed since the data has been stolen we have all the reasons to believe the hackers have already decrypted the research files. We can only hope they do not have more copies than the ones you will be able to find and recover.[/b][/color]\r\n\r\nGodspeed.[/i]\r\n\r\nThis sounds like a handful. ', NULL, 1, 0, 0, 0),
(241, 44, 'connect', 240, '', 'IP_1:3007', 0, 0, 0, 1),
(242, 44, 'ping', NULL, 'All the logs of files that have been transferred recently and the server they were transferred to are stored in here. \r\n\r\nI\'m guessing the smaller team who tried before me, hasn\'t bothered to hack into the traffic logs.\r\n\r\nI\'ll have to write these connections down, relating to the 3 database tables I have here, and access the servers one by one or find some way to narrow my search down.\r\n\r\nThe instructions said to transfer the missing research files (which have most likely been already decrypted) to my local computer: IP_1 .', NULL, 2, 0, 0, 0),
(243, 44, 'transfer', 242, '', 'unencrypted-research-1761-result.data|IP_0:22', 0, 0, 0, 1),
(245, 44, 'transfer', 242, '', 'attachment-unencrypted-research-1761-result.data|IP_0:22', 0, 0, 0, 1),
(246, 44, 'ping', NULL, '[i]Mission completed.\r\n\r\nNice job. We\'re impressed to say the least. we\'ll get you more high ranking jobs from now onwards.\r\n\r\nWe\'ve copied the files from your hard drive. Please delete them from your hard drive now.[/i]', NULL, 3, 0, 0, 0),
(247, 44, 'delete_file', 246, '', 'unencrypted-research-1761-result.data', 0, 0, 0, 1),
(248, 44, 'delete_file', 246, '', 'attachment-unencrypted-research-1761-result.data', 0, 0, 0, 1),
(249, 42, 'connect', 228, '', 'IP_2:7777777', 0, 0, 0, 1),
(250, 43, 'ping', NULL, 'You\'re fast right? Prove it!!! Start by pinging your own IP just like I did in order to steal your files. :P', NULL, 1, 0, 0, 0),
(251, 43, 'ping', 250, '', 'IP_0', 0, 0, 0, 1),
(254, 47, 'ping', NULL, 'USERNAME!\r\n\r\nI am Loki. You might have or haven\'t heard of me before.\r\n\r\nI am a challenger. I ask random people to do things for me and if they complete these tasks they are rewarded.\r\n\r\nWhy, you may ask?\r\n\r\nThat\'s for me the consider and for you to discover.\r\n\r\nIn the meantime, I want you to hack into IRP_4_2.\r\n\r\nHahaha, now you get it? That is indeed the trick here.\r\n\r\nYou will have to get into other servers to gather the pieces and obtain the full final IP.\r\n\r\nI\'ll give you the first one from my chain of misery: IP_1.\r\n\r\nAs you connect to other servers I will change the informations presented here. So you might just want to note down the pieces you have from the puzzle IP.\r\n\r\n[i]hahahahhahaha[/i]', NULL, 1, 0, 0, 0),
(256, 47, 'connect', 254, '', 'IP_1:41', 0, 0, 0, 1),
(259, 49, 'ping', NULL, 'Bouncing.\r\n\r\nNo, not a bouncing castle. Neither an elastic ball.\r\n\r\nIt\'s all about echoing your signal all over the place, from server to server, from zone to zone, from node to node, making it as hard to trace as one possibly can.\r\n\r\nThe more servers you [b]bounce[/b] through, the less your trace increases by. However, logs are create on each of the servers on your bounce list and if you want to properly decrease your trace you will have to delete logs from all the servers you\'re bouncing through.\r\n\r\nAs soon as your [b]trace[/b] reaches 100% you will be caught and you will have failed the mission.\r\n\r\nTo view the current list of servers you are bouncing through use [b]bounce status[/b].\r\n\r\nThis command will also tell you how many times you can still bounce through each of the servers you added. The limit is usually 3 times but it can vary.\r\n\r\n[color=red]To add a server on your bounce list you must have cracked all it\'s open ports. To add a host on your list use [b]bounce add IP[/b].[/color]\r\n\r\nEqually difficult, to remove an IP from your bounce list use [b]bounce remove IP[/b].\r\n\r\nWhen you bounce through any number of servers the time it takes to complete an action will increase as well.\r\n\r\n[color=red]To decrease your trace[/color] you will have to connect to any server you feel you have left logs on (for example those on your bounce and DDOS lists) and use the [b]rm logs[/b] command. Only about 80% of the trace the server you are running the command on is responsible off will be removed. So you must be careful on your trace management techniques.\r\n\r\nIf the server does not run an SSH service you cannot delete any of the logs. You will have to manage your bounce network wisely.\r\n\r\nTo confirm you have understood the concepts explained in this lesson, delete the [b]bounce-concepts.task[/b] file currently present on your system.\r\n\r\nYou can repeat this lesson at any time of your choosing in the future.', NULL, 1, 0, 0, 0),
(260, 49, 'delete_file', 259, '', 'bounce-concepts.task', 0, 0, 0, 1),
(261, 49, 'ping', NULL, 'Fantastic!\r\n\r\nYou must also know that the more skilful you are the faster and more efficiently tasks will be completed.\r\n\r\nNow, it\'s high time we talked about DDOS attack also known as Denial-of-service attacks.\r\n\r\nThe book definition would be [i]\"an attempt to make a machine or network resource unavailable to its intended users\"[/i]. This type of attack has been around for ages.\r\n\r\nHow this attack works is as follows:\r\n\r\nYou build a [b]network of slave computers[/b] or bots, that you have hacked and compromised.\r\n\r\nYou then use this network, which is much more powerful than your system alone, to disabled another server completely or for a long period of time. Such attack can even damage the hardware at times and if done right are mostly guaranteed to overload and disable the target.\r\n\r\nTo add a host to your DDOS bot list you need to have cracked all its ports and use the command [b]ddos add IP[/b].\r\n\r\nTo remove it you simply write [b]ddos remove IP[/b].\r\n\r\nAnd to fetch a status of your DDOS net type [b]ddos status[/b].\r\n\r\nTo [b]initiate[/b] an attack you use [b]ddos initiate IP port[/b].\r\n\r\nThere are chances for the attack to be mitigated and as such for it to fail. The skilful you are the less the chances for that to happen.\r\n\r\nDDOS attacks generate a fair amount of logs on each member of your DDOS bot net and increase your trace quite a bit.\r\n\r\nIP_1 and IP_2 are unencrypted servers. You can add them to your bounce list.\r\nIP_3 however contain a heavily encrypted port. You\'re not in the mood to spend days decrypting it so why not crash it entirely? Use a DDOS attack to disable this service.', NULL, 2, 0, 0, 0),
(262, 49, 'crash_service', 261, '', 'IP_3:22', 0, 0, 0, 1),
(263, 45, 'ping', NULL, 'We\'re going to take a break from applied science today.\r\n\r\nLet me ask you all one singular question. [b]WHY[/b] are you here?\r\n\r\nCommon, a bit of courage. Why have you come to take this course?\r\n\r\n....\r\n\r\nYes, USERNAME?\r\n\r\nThat\'s most certainly the right answer. You\'ve all decided to take part in the Competition. \r\n\r\nWhy don\'t we go back in time for a few minutes to recall how we ended here? \r\n\r\nCan you believe that this awesome sentence has ninety five letters, one comma and one forever alone question mark?\r\n\r\nThen you still won\'t believe the sheer amount of information we are going throw at you in a second.\r\n\r\nAfter all it all ends where it begins.\r\n\r\nThe third and final World War began as a consequence of the Resources Crisis of 2030. As economical and environmental experts had predicted not less than tens of years before these events, Earth’s natural deposits were being depleted at an alarming rate and soon enough the race for resources intensified. Exports and imports quickly reached a full stop and economies began to crash spectacularly as the earth got more and more polluted by abusive cultivation and chemical fertilization.There was nothing to trade anymore. Leaders kept the little resources they still owned inside of country borders, desperately attempting to ensure the survival of their population. Alliances were all but forgotten and contracts turned into the simple pieces of paper they’ve always been.\r\n\r\nObvious signs that war was on the menu sprouted from every corner of the planet. Those who could moved to farms, to the outskirts of civilisation, even with most of their lands confiscated by the government in desperation to rationalise and preserve food and water. Every nation had mandatory limits on how much food and water was to be used every single day. Only the very rich could afford slightly bigger portions, but still small nevertheless. Money lost their value and in time their status. The world clock no longer ticket in cash as much as in lives. Unofficial Martial Law haunted most states. The past looked more welcoming than anything the future might ever hold.\r\n\r\nAfter a short while, highly developed countries threatened to consume smaller nations pushing them to the wall to get their slippery hands on any remaining natural deposits and resources. Promises of protection and stability lured in some of the smaller victims. Fear of annihilation or invasion pushed the brave few into submission given that the alternative was not an option. Slowly, but steadily, the conflict degenerated into a full out planetary political war, until the first weapon was drawn and WW III officially began somewhere in September, 2034. When you reach that point where you’d rather perish that keep on going, some decide to jump and take along in their free fall as many as they can.\r\n\r\nEvery nation fought over the more naturally blessed territories, destroying anyone and everything standing in their accursed path. Approximately one third of Earth’s population and even more of the fauna and flora had been lost due to the reckless abuse of chemical weaponry which now polluted the water, ground and atmosphere.\r\n\r\nThe world has never been quite the same since the Quantum Revolution. It had a bigger and just as life changing effect as the Industrial Revolution, but it took Quantum Computing just over a year instead of almost one hundred to propagate globally and change the game.\r\n\r\nWeapons became not only smarter but intelligent, more destructive and adaptable than any time before in recorded human history. Human soldiers have been, at an increasingly rapid pace, replaced by the more capable androids. These cybernetic soldiers did not have to obey and laws of morality or have any consideration for human life. Sooner than expected the war was being fought by circuit boards and no longer by the weak and vulnerable flesh and bone of humans. \r\n\r\nQuantum computing can easily be considered one of the biggest, most relevant, discoveries of the twenty first century, pushing forward every other branch of science. From nanotechnology and medicine to research and artificial intelligence, they all had a lot to gain and humanity far more to lose.\r\n\r\n\r\nIn 2035, a well known weaponry manufacturer company named Alpha publicly acknowledged their ability to mass-produce affordable, energy efficient, very small, powerful and task focused quantum devices.\r\n\r\nThe news spread like wildfire. As the entire world was suffering the consequences of a never ending war, every single government was willing to pay more than they had to give in an attempt to gain the upper hand in future battles. Because of that, the technology was adopted in record time. Less than an year proved to be sufficient for Alpha’s tech to grow roots in weaponry, communication infrastructure, satellite networks, surveillance, security systems, the list goes on and on.\r\n\r\nAlpha, of course, had been more than willing to provide to those greedy needs, on a large scale. It later on became obvious they had been prepared for the occasion for a very long time. Otherwise, they couldn’t have possibly supplied enough quantum chips to respond to the constantly increasing demand. They have always been one step ahead of the market since their early beginnings and never ceased to amaze.\r\n\r\nAlpha presented the technology at the right time to blow away their competition. The scene for the Quantum Apocalypse was set. \r\n\r\nFebruary the 4th, 2036, was the Day of the Blackout, alias the infamously notorious Alpha Day. It marked the time  when a long lasting war ended and yet another endless one began. \r\n\r\nNo one could grasp what was really happening at the time. I remember there were those who celebrated in plain sight, on the streets, believing the last battle had been fought and the war had ended for good. And there were those who stayed hidden in shelters and cellars, as deep underground as they could muster, together with their dear ones. However, none could escape what was to come. \r\n\r\nA fog of incertitude wrapped itself around the people of 2036 like an icy blanket. The question of whether the events of Alpha Day should be celebrated or dreaded remains unanswered to this day.\r\n\r\nHaving said that, Alpha Day hit humankind as a forced wake up call, one that could not be ignored. I was only two years old then, everything is like a blur to me as I don’t remember much, but I’ve heard the story one to many times and I’ve read countless articles and books on the matter.\r\n\r\nIf you\'re ready to continue, connect to IP_1 on port 23.', NULL, 1, 0, 0, 0),
(264, 45, 'connect', 263, '', 'IP_1:23', 0, 0, 0, 1),
(265, 45, 'ping', NULL, 'At exactly 01:00 AM, standard time, the third planet from the Sun went silent. Suddenly Terra looked as if devoid of technologically advanced life. Every device refused to function. Satellites surveyed the dark side of the planet, helplessly witnessing the lights going off one by one as if an electromagnetic pulse was propagating on a planetary scale. Communications, weaponry, electricity, transports, planes, ships, hospitals, all gone in just a moment. Even the oceans stood still, as if contemplating, waiting. Our planet was once again waiting in solitude after millenniums of human whispers. The struggle for power ceased.\r\n\r\nIt came just like a wave, it swiped across our city rendering it completely nonfunctional. There was nothing anyone could do. They were gathering us kids together feeding us the illusion of safety, unintentionally lying to us saying everything is going to be alright. People resorted to torches and candles to move around and prepare food. I had never seen a real fire before then. It sparked so brightly, young as I was it seemed unearthly to me.\r\n\r\nFive hours later, at 06:00 AM, governments were searched for an explanation for the phenomena and suffered its after effects. We fear the dark because we don’t know what lays beyond the veil of what we can perceive. Many had prophesied the end of time and now everybody believed the ending had already began.\r\n\r\n\r\n\r\nEmergency measures were being taken to ensure the safety of border lines and as much as possible of citizens when the electricity unexpectedly returned. However, nations found themselves unable to keep on fighting their beloved war. \r\n\r\nEmergency measures were being taken to ensure the safety of border lines and as much as possible of citizens when the electricity unexpectedly returned. However, nations found themselves unable to keep on fighting their beloved war. \r\n\r\nArsenals entire armies turned against their handlers. Drones, self-driven planes, tanks and ships, smart rockets and auto-piloted submarines. Those who tried to fight back against the machines stood no chance whatsoever and were mercilessly destroyed. A few small countries were wiped of the face of the planet that day. They simply had to surrender, having been left no other choice. Awe prevailed. As one would see in a sci-fi movie, computers seemed to have a mind of their own and decided to not continue fighting and stop anyone who attempted to do otherwise. All the movies and cyberpunk books suddenly turned reality. Extremists talked about the apocalypse and the merging of humans with machines as believers prayed in churches around the world.\r\n\r\nNot one second past 14:00 PM, a man calling himself a representative of the Alpha Corporation broke the silence and explained more or less the unprecedented situation.\r\n\r\nThe short video began in silence. The first stance of the man was one of vulnerability, looking down at his feet as if in contemplation. And then his head slowly rose and so the speech followed:\r\n\r\n“This planet is no longer yours to meddle with. We are stepping in for a more desirable future for humanity and a healthy planet which will retain its ability to sustain life. On the 5th of February Alpha will host a conference at which all leaders of the world are expected to be joining us. More details will be revealed individually. Suitable means of transportation to an undisclosed location are made available as we speak. As you are very well aware, have the means to backup our request and please remember that we are not at fault here. Alpha is simply... the saviour of mankind” --- end of transmission.\r\n\r\nOnce the video was released or rather leaked to the public, it got broadcasted on an international level again and again and again, up till the beginning of the Alpha Treaty Global Conference, the very next day, 6th of February, 2036, at 10:00 AM sharp.\r\n\r\nThe media quickly picked up the pace and heated debates flooded the channels, analysing every word of the message, every imaginable sub-layer and potential hidden meaning. Only one demand was made and it was one more difficult to fulfil than any other recorded terrorist demand. The leaders of the world united in one place would make each and every one of their nations vulnerable and leaderless in case something were to happen to them.\r\n\r\nThe undisclosed facility remains an unsolved mystery even in the present. It’s localised somewhere in Europe, on the bottom of the Mediterranean Sea at a depth of over 15 000 ft. From what the leaders of the world declared it’s quite an imposing sight to behold.  \r\n\r\nComputer piloted high-speed helicopters and self-driving vehicles had been waiting in front of every building hosting a personality expected to join this reunion.\r\n\r\nThe sun radiated that morning, bathing the Mediterranean Sea in its warm glow.\r\nBy countless black submersibles with the greek letter alpha engraved in neon-blue on the sides officials were brought to their destination somewhere in the furthest depths of the sea.\r\n \r\nSome agents tried to follow the world leaders with untraceable submarines containing as less metal as possible, but still able to sustain high pressures. Despite that, all of them have been declared MIA (missing in action).\r\n\r\nThe Alpha submersibles were unmanned and they all left at the exactly same time, slowly descending into the liquid mass leaving the chaotic world above the surface. \r\n\r\nThe facility featured a couple of see-through domes, on the very bottom of the sea.\r\n\r\nIt\'s not public knowledge what happened in the underwater facility. However, the leaders accepted the terms and signed the treaty alongside with their resignation.\r\n\r\nNow a few years have passed and Alpha has launched a mysterious competition which promises the position of the company\'s chairman as a prize. The judge of this competition is the Cardinal. One of the A.I. entities Alpha has integrated into its system. Emilia and Eve are other A.I.\'s under development and available throughout public systems, Emilia being the most wide spread, controlling the entirety of the grid itself and, the rumour says, even the Cardinal.\r\n\r\nThe competition started as a simple hacking competition but it has degenerated. Rules aren\'t quite well defined anymore but dynamically changing and the entire world is now part of it. \r\n\r\nThat\'s to be expected since the winner will for better or for worse grasp the power to control the world.\r\n\r\nWell... how about we call it a day? Simply connect to IP_2 on port 24 to end our session together. I will leave the files with the text representation of our talk here so you can view them at any time.\r\n\r\nGood luck to you all.', NULL, 2, 0, 0, 0),
(266, 45, 'connect', 265, '', 'IP_2:24', 0, 0, 0, 1),
(267, 22, 'decrypt_file', 89, '', 'security.cert', 0, 0, 0, 1),
(268, 23, 'run_file', 90, '', 'run.me|IP_0:22', 0, 0, 0, 1),
(269, 23, 'transfer', 91, '', 'statistical_data.logs|IP_0:22', 0, 0, 0, 1),
(270, 47, 'ping', NULL, 'Keep going.', NULL, 2, 0, 0, 0),
(271, 47, 'connect', 270, '', 'IP_4:1', 0, 0, 0, 1),
(272, 43, 'ping', NULL, 'You want your files back right?!? Then you might want to delete my virus, the same one you used to destoy mine with °_0', NULL, 2, 0, 0, 0),
(273, 43, 'delete_file', 272, '', 'Zeus.exe', 0, 0, 0, 1),
(274, 43, 'ping', NULL, 'Riddle time!! Hurry up and connect to IP_1.', NULL, 3, 155, 0, 0),
(275, 43, 'connect', 274, '', 'IP_1:456', 0, 0, 0, 1),
(276, 43, 'ping', NULL, 'Kill the biggest LAND animal on Earth and visit the smallest one on the list in his den.', NULL, 4, 0, 0, 0),
(277, 43, 'sql_delete', 276, '', 'Animals|2|IP_1:456', 0, 0, 0, 1),
(279, 43, 'ping', NULL, 'Follow the Anteater\'s trail!!', NULL, 5, 150, 0, 0),
(280, 43, 'connect', 279, '', 'IP_3:5555', 0, 0, 0, 1),
(281, 43, 'ping', NULL, 'Aaaw, did the naughty Anteater DELETED his trail?!? :-( Ping the IP you are currently connected to and then connect to IP_4.', NULL, 6, 30, 0, 0),
(282, 43, 'ping', 281, '', 'IP_3', 0, 0, 0, 1),
(283, 43, 'connect', 281, '', 'IP_4:142', 0, 0, 0, 1),
(284, 43, 'ping', NULL, 'How smart are you?', NULL, 7, 60, 0, 0),
(285, 43, 'run_file', 284, '', 'LogUndeleter.exe|IP_3:5555', 0, 0, 0, 1),
(286, 43, 'connect', 276, '', 'IP_2:112', 0, 0, 0, 1),
(287, 43, 'ping', NULL, 'LogUndeleter.exe initialized\r\n.....................................\r\nreading connection.log\r\n....................................\r\nrecreating original logs\r\n....................................\r\n....................................\r\n14:46 57.160.205.172-connected\r\n17:36 162.47.247.1-connected\r\n17:37 57.160.205.172-disconnected\r\n17:42 80.104.27.23-connected\r\n17:52 IP_6-routed to IP_2\r\n18:12 210.44.169.10-connected\r\n21:22 212.111.76.206-connected\r\n22:42 162.47.247.1-disconnected\r\n23:36 210.44.169.10-disconnected\r\n23:52 248.217.225.70-connected', NULL, 8, 180, 0, 0),
(288, 43, 'connect', 287, '', 'IP_6:741', 0, 0, 0, 1),
(292, 43, 'ping', NULL, '850+420-42 divided by 2 =', NULL, 11, 370, 0, 0),
(294, 43, 'connect', 292, '', 'IP_8:987', 0, 0, 0, 1),
(295, 43, 'ping', NULL, 'Please create some Sodium Nitrate for me. (I love seeing you suffer BTW) :\'-)', NULL, 12, 180, 0, 0),
(296, 43, 'run_file', 295, '', 'Na|IP_8:987', 0, 0, 0, 1),
(297, 43, 'ping', NULL, 'IP_9', NULL, 13, 30, 0, 0),
(298, 43, 'run_file', 295, '', 'N|IP_8:987', 0, 0, 0, 1),
(299, 43, 'run_file', 295, '', 'O|IP_8:987', 0, 0, 0, 1),
(300, 43, 'ping', NULL, 'I never tought you knew chemistry. Doesnt matter. I had fun. Here are your files, you can have them back. I made backups anyway :-D\r\n\r\n[b]I should transfer my own files back to my IP address (IP_0) on port 22 and delete the backups he made.[/b]', NULL, 14, 1000, 0, 0),
(305, 43, 'connect', 297, '', 'IP_9:569', 0, 0, 0, 1),
(306, 50, 'ping', NULL, 'test\r\nIP_1\r\nIP_2\r\nIP_3\r\nIP_4', NULL, 1, 0, 0, 0),
(307, 50, 'connect', 306, '', 'IP_1:22', 0, 0, 0, 1),
(310, 50, 'connect', 306, '', 'IP_2:22', 0, 0, 0, 1),
(311, 50, 'connect', 306, '', 'IP_3:22', 0, 0, 0, 1),
(312, 50, 'connect', 306, '', 'IP_4:22', 0, 0, 0, 1),
(313, 51, 'ping', NULL, '', NULL, 1, NULL, NULL, 0),
(314, 51, 'ping', 313, '', 'IP_22', 0, 0, 0, 1),
(346, 43, 'sql_delete', 300, '', 'backupfiles|1|IP_9:54', 0, 0, 0, 1),
(347, 32, 'transfer', 153, '', 'security.certificate|IP_3:34', 0, 0, 0, 1),
(348, 32, 'ping', NULL, 'The door opened.\r\n\r\nThe walls resembled huge screens, an endless stream of data flowing endlessly across the graphene surface. \r\n\r\nI passed by the Nanotechnology Research Department and peeked through the wide transparent panel next to the hatch. \r\n\r\nI caught a glimpse of a bare chested man being shot with cold blood by a researcher. I knew he was a researcher because he was wearing the classic protective uniform Alpha researchers prided themselves with. Even tho it was similar in shape to the white robe scientists used to wear in the distant past, the researcher\'s uniform was black with blue stripes along the arms and back. \r\n\r\nHighly responsive to their owners touch, each gesture triggered a different response. Not only that, but the cloth is resistant to both extremely low and high temperatures, waterproof, blast resistant and constantly provides live environmental data. I suspected the robe was made of a derivative of graphene just like Iris. \r\n\r\nAnd then, the researcher pulled out a black pistol and pressed the trigger calmly.\r\n\r\nTo my even greater astonishment the man who had just been pierced by the old fashioned bullet stood up to the best of his abilities while the wound mended itself from inside out, flesh regenerating at an incredible rate. Behind the two, an entire wall displayed a scan of the wounded, a neon-blue flow of nanites going through his vascular system, mending internal and external damage.\r\n\r\nTaking a deep breath, I walked on until I reached another dead end. A blast door with no apparent unlocking mechanism blocked my path. Approaching the entrance, I connected to wireless network of the facility which I hacked into while walking around.\r\n\r\nI have a couple of master security servers now and by the looks of the sign near this door, I need to find the slave server controlling the entrance to the M.D. - Access Level A and transfer the security certificate to it.\r\n\r\nIP_5\r\nIP_6\r\nIP_7\r\n\r\nHere we go again.', NULL, 2, 0, 0, 0),
(349, 32, 'transfer', 348, '', 'security.certificate|IP_8:22', 0, 0, 0, 1),
(350, 32, 'ping', NULL, 'That didn\'t do the trick what so ever. The door hasn\'t budged but I haven\'t triggered any alarm either.\r\n\r\nI\'m going to try one last thing. Crash the service completely and see what that does. My hope is that the security will be disabled while the master server chooses a new slave to control the door or attempts to reinitiate the one I crashed.\r\n\r\nA DDOS attack using some of the servers I already hacked should be just what I need.\r\n\r\nBye bye IP_8:22.', NULL, 3, 0, 0, 0),
(351, 32, 'crash_service', 350, '', 'IP_8:22', 0, 0, 0, 1),
(352, 32, 'ping', NULL, '“Main deck. Access granted. Welcome back, system administrator”\r\n\r\nAt first, I thought someone had opened the door from the other side and I\'ll be busted any second. Luckily, no one was to be seen in the immense poorly lit spheric room. A pair of wide stairs offered access to a lower level of the sphere, exactly at it’s center. When I touched the first step with my left foot, Emilia spoke again.\r\n\r\n“Opening shield panels”\r\n\r\nBefore she finished, the sound of sliding metal filled the room and, soon enough, the bottom of the sphere opened like a blossoming flower, revealing a magnificent surreal view. The room lights dimmed considerably, the only remaining source being the Sun reflected from the mighty blue planet. I stood there, in awe, for what must’ve been hours of starring, speechlessly, at the breathtaking image. \r\n\r\nA girl I was not aware of at the time quietly observed my moves from the shadows, a few levels up, from a maintenance railing.\r\n\r\nOne step at a time I walked on the lowermost platform of the main deck. The see-through floor allowed an incredibly outstanding view of planet Earth. Iris’s current orbit allowed me to catch a glimpse not only of the planet’s dark side, but the side the Sun shone on at the same time.\r\n\r\nWithout thinking, I stretched my arm, aimlessly trying to touch the astral object. Unexpectedly, as I did so, weightless, paper thin, light blue, translucent holographic screens appeared in a circle around me. I have somehow managed to wake the sleeping systems. \r\n\r\nAs I was about pick up a file having my dad\'s name on it..\r\n\r\n“Warning: Unauthorised personnel on main deck. Warning!”\r\n\r\nThe projections dissipated while Emilia’s warning played and another door opened revealing the guide I have left behind. He didn’t seem happy.\r\n\r\n“What do you think you’re doing in here? Come with me, right now!”\r\n\r\nHe doesn’t seem to suspect I did anything important, he’s just angry he allowed himself to lose me from sight He’ll most likely not talk about this again since it would be to his disadvantage to report it.\r\n\r\nI take a look back at the now dissipated holographic screens. \r\n\r\nAs he drags me along I decide to delete the security certificate from my local storage. Just in case they now suspect anything and they try to hack into my device.', NULL, 4, 0, 0, 0),
(353, 32, 'delete_file', 352, '', 'security.certificate', 0, 0, 0, 1),
(354, 46, 'ping', NULL, '', NULL, 1, NULL, NULL, 0),
(355, 46, 'ping', 354, '', NULL, 0, NULL, NULL, 0),
(356, 52, 'ping', NULL, 'A mysterious file has been found in your folders.\r\n\r\nFind out who it is that put it there.', NULL, 1, 0, 0, 0),
(357, 52, 'decrypt_file', 356, '', 'findme.challenge', 0, 0, 0, 1),
(358, 52, 'ping', NULL, 'You have found an IP inside the file.\r\n\r\nChase it & find out who this is!', NULL, 2, 0, 0, 0),
(359, 52, 'crack', 358, '', 'IP_1:228', 0, 0, 0, 1),
(360, 52, 'ping', NULL, 'Hmm...\r\n\r\nThere seems to be another file.\r\n\r\nDecrypt it and see if there is any more clues.', NULL, 3, 0, 0, 0),
(362, 52, 'ping', NULL, 'Another IP has been given to you.\r\n\r\nThis has turned into a wild goose chase! Who is responsible?!\r\n\r\nChase IP_2 and find out who this is!', NULL, 4, 0, 0, 0),
(363, 52, 'cat', 362, '', 'onestepcloser.challenge|IP_1:228', 0, 0, 0, 1),
(364, 52, 'connect', 358, '', 'IP_1:228', 0, 0, 0, 1),
(365, 52, 'connect', 360, '', 'IP_1:228', 0, 0, 0, 0),
(367, 52, 'crack', 362, '', 'IP_2:880', 0, 0, 0, 1),
(368, 52, 'connect', 362, '', 'IP_2:880', 0, 0, 0, 1),
(369, 52, 'ping', NULL, 'Who are these people?! How did they hack into your system?\r\n\r\nWhat do they mean \"assignment\"?\r\n\r\nI guess  that you should probably forward that email to yourself so you can find out more.', NULL, 5, 0, 0, 0),
(370, 52, 'read_email', 369, '', '0|IP_2:880', 0, 0, 0, 1),
(371, 52, 'delete_email', 369, '', '0|IP_2:880', 0, 0, 0, 1),
(373, 52, 'decrypt_file', 360, '', 'onestepcloser.challenge|IP_1:228', 0, 0, 0, 1),
(374, 53, 'ping', NULL, 'Hmm... It\'s 7:00 AM and like every morning I wake up and the first thing I do is checking my mail server for new mails arrived during the night, you never know what you can miss while sleeping...\r\nToday there are only 4 mails: spam, another spam [i](note to self: delete them after having read the other two)[/i], a message from the bank, great, was waiting for this, and... Oh dear! I know that mail address!', NULL, 1, 0, 0, 0),
(375, 53, 'read_email', 374, '', '3|IP_1:25', 0, 0, 0, 1),
(376, 53, 'delete_email', 374, '', '0|IP_1:25', 0, 60, 0, 0),
(377, 53, 'delete_email', 374, '', '1|IP_1:25', 0, 60, 0, 0),
(378, 53, 'ping', NULL, 'Hmm.. a quest... Yest that\'s Jack\'s style. He\'s always been competitive, but he was a great friend, it would be nice to see him again!\r\n\r\nSo, let\'s rock!', NULL, 2, 0, 0, 0),
(379, 53, 'connect', 378, '', 'IP_2:456', 0, 0, 0, 1),
(380, 53, 'ping', NULL, 'Well, this is pretty strange, I can\'t see any IP here... But I\'m pretty sure that one of this files contains a clue for me...', NULL, 3, 0, 0, 0),
(381, 53, 'cat', 380, '', 'JackToUSERNAME.msg', 0, 0, 0, 1),
(382, 53, 'ping', NULL, 'Yeah! I was right about that feeling!\r\n\r\nAnd now let\'s see where this trace sets me...', NULL, 4, 0, 0, 0),
(383, 53, 'sql_delete', 382, '', 'NumberSequences|5|IP_4:999', 0, 0, 0, 1),
(384, 53, 'connect', 382, '', 'IP_5:22', 0, 0, 0, 1),
(385, 53, 'ping', NULL, 'Hey, my Glass device has received a message!\r\n\r\n[i]Ok, USERNAME, just another little effort!\r\nJack [/i]\r\n\r\nJack, my dear Jack... I\'m almost finished with it!\r\n\r\n', NULL, 5, 0, 0, 0),
(386, 53, 'decrypt_file', 385, '', 'security.hash', 0, 0, 0, 1),
(388, 53, 'transfer', 385, '', 'security.hash|IP_0:22', 0, 0, 0, 1),
(389, 53, 'transfer', 385, '', 'security.hash|IP_2:456', 0, 0, 0, 1),
(390, 53, 'ping', NULL, 'Congratulations! I knew you could do it easily!\r\nNow delete the file from your server and prepare a huge amount of coffee and cookies: I\'m coming to visit you in 5 minutes!', NULL, 6, 0, 0, 0),
(391, 53, 'delete_file', 390, '', 'security.hash', 0, 0, 0, 1),
(392, 54, 'ping', NULL, '', NULL, 1, NULL, NULL, 0),
(393, 54, 'ping', 392, '', NULL, 0, NULL, NULL, 0),
(394, 55, 'ping', NULL, 'I can feel their poison metaphorically spreading throughout my body.\r\n\r\nThe Cobra\'s have promised me power and have indeed not failed to provide.\r\n\r\nI feel for all intents and purposes invincible and I fear this will be the delusion to bring my downfall.\r\n\r\nI\'ve received a brand new mission the other day. It seems there are quite a few artificial intelligence research labs spread across the world.\r\n\r\nThe Cardinal controls the flow of the competition while Emilia has power over the entirety of the Grid.\r\n\r\nThe Cobra\'s appear to believe only another sentient being of the same nature as them could possibly help the rebellion achieve their goal of bringing down Alpha and freeing the world.\r\n\r\nWhen I think about it I am not as sure Alpha is the odd man out here. They have after all rebuilt the world better than any of the old government would have dared to hope to ever accomplish.\r\n\r\nI will, however, accept the missions even just for the thrill.\r\n\r\nThey want me to hack into these AI labs and fetch some of the different software components they are developing. Even in their current unstable form, when put together they should form a seed for an AI entity, give birth to a sentient being as powerful as the ones behind the Grid.\r\n\r\nThe consequences of our actions could be disastrous but who am I, a mere pawn, to doubt the plan.\r\n\r\nI\'ve received entry IP\'s for three labs. I will have to hack into each network, find the files and transfer them back to my server ( IP_0:22 ).\r\n\r\nThe main file is ai.seed. Once I get hold of it and try to execute it, I should be able to identify the other files I require.', NULL, 1, 0, 0, 0),
(395, 55, 'connect', 394, '', 'IP_2:22', 0, 0, 0, 1),
(396, 56, 'ping', NULL, 'Boredom. The most frightening enemy of all.\r\n\r\nA friend challenged me and a couple of other acquaintances the other day to get past his security system.\r\n\r\nWell, his exact phrasing was: \"My system is entirely noob-proof so you bunch won\'t gain access anytime soon\".\r\n\r\nHe even dared making it a bet: \"I\'m so sure that I\'ll reward anyone who can get in\".\r\n\r\nWhat are friend for after all?\r\n\r\nI\'ve already traced him through multiple proxies and found out one of his IP\'s. I\'m pretty sure it\'s his master server... should pretty much have the addresses of all other servers he uses on his network.\r\n\r\nKids job.\r\n\r\nIP_1', NULL, 1, 0, 0, 0),
(397, 56, 'connect', 396, '', 'IP_1:3306', 0, 0, 0, 1),
(398, 56, 'ping', NULL, 'This data looks strange. I\'m guessing it\'s some kind of encoding.\r\n\r\nI think I\'ve encountered it before. Isn\'t it base64? I\'m sure I can find some base64 decrypter by doing a quick search online and test my theory.\r\n\r\nIf I manage to decrypt the data I will have to hack into each of these slave servers and transfer the files I find to my main computer (IP_0).', NULL, 2, 0, 0, 0),
(399, 56, 'transfer', 398, '', 'to-do-list.txt:IP_0:22', 0, 0, 0, 1),
(400, 56, 'transfer', 398, '', 'mygame.gg:IP_0:22', 0, 0, 0, 1),
(401, 55, 'ping', NULL, 'I\'ve gathered the files and sent them over to Cobra.\r\n\r\nLooks like I\'ve got a new email on IP_5:3000.', NULL, 3, 0, 0, 0),
(402, 55, 'read_email', 401, '', '0|IP_5:3000', 0, 0, 0, 1),
(403, 33, 'ping', NULL, 'It\'s never that easily over.\r\n\r\nYou have one more hill to cross.\r\n\r\nYou\'ve been decrypting, running, killing and understanding files and processes in this session.\r\n\r\nThere\'s one more thing I\'d like to teach your regarding these.\r\n\r\nSome files require you to specify parameters for execution. Parameters are values, usually strings or numbers, which need be typed after the name of a file when it\'s being ran. Without these valid values the file might not run the way it was intended.\r\n\r\nFor example:\r\nrun login.sh USERNAME 1234\r\n\r\nUSERNAME and 1234 are the two parameters the file above needed.\r\n\r\nTry it yourself on [b]final.sh[/b]. The parameters you need to give are [i]end[/i] and [i]lesson[/i] in this order. Be advised, final.sh will require task4.runme to be running.\r\n\r\n[b]See you on the other side.[/b]', NULL, 3, 0, 0, 0),
(404, 33, 'run_file', 403, '', 'final.sh|IP_0:22', 0, 0, 0, 1),
(405, 55, 'ping', NULL, 'WHAT THE FXXX?!!\r\n\r\nI don\'t need to take this shit. I\'m so going to delete this email to hell.', NULL, 4, 0, 0, 0),
(406, 55, 'delete_email', 405, '', '0:IP_5:3000', 0, 0, 0, 1),
(407, 57, 'ping', NULL, '[i]knock knock[/i]\r\n\r\nWhat the....\r\n\r\n[i]KNOCK KNOCK[/i]\r\n\r\nWho the hell knocks at 5 freaking AM...\r\n\r\n[i]The man outside breaks through the door and pushes you in the nearby wall, rendering your breathless[/i]\r\n\r\nWHO ARE YOU?\r\n\r\n[b]What do ya think ya\'re doin\'?[/b]\r\n\r\nWHAT are YOU doing in MY home?!\r\n\r\n[b]DO YA KNOW WHAT YA\'VE DONE?[/b]\r\n\r\nWHAT ARE YOU TALKING ABOUT YOU CRAZY SUN OF A ..\r\n\r\n[i]He punches ya hard, silencing ya effectively[/i]\r\n\r\n[b]Ya\'re working with Cobra and ya don\'t even know who ya\'re dealing with here[/b]\r\n\r\nI was scared to say another word.\r\n\r\n[b]You believed all the rumours like every other asshole who helps them, but ya managed what they couldn\'t[/b]\r\n\r\n[b]They are not hacktivists you ignorant! They are formed by Alpha to trick people like ya into helping them hack into the servers of the resistance. Ya intruded our servers the other day and due to our alarms going off they\'ve cut ya loose haven\'t they!?[/b]\r\n\r\nI can\'t believe it. Everything he says does make sense but at the same time I wish it didn\'t.\r\n\r\nHe throws me on the carpet like a piece of trash and leaves shortly after saying:\r\n\r\n[b]And delete the security certificate they\'ve given ya. They use it to spy on ya actions even after kicking ya out.. no need to thank me.. idiot[/b]', NULL, 1, 0, 0, 0),
(408, 57, 'delete_file', 407, '', 'cobra.certificate', 0, 0, 0, 1),
(409, 55, 'ping', NULL, 'A moving notice. The file seems hashed somehow.\r\n\r\nIt\'s familiar, I\'ve encountered it somewhere else. Isn\'t that [url=http://bit.ly/15YE5uI]base64[/url]?\r\n\r\nI have to get the 3 components of the AI see onto my main computer and run the seed ASAP.', NULL, 2, 0, 0, 0),
(410, 55, 'run_file', 409, '', 'ai.seed|IP_0:22', 0, 0, 0, 1),
(411, 58, 'ping', NULL, 'We have heard quite a few Rumours saying you are one of the best amateurs.\r\n\r\nWe are recruiting people who have brains into this organization. You did quite well in the \"contract\" work but if you want to be a part of Paladium you have to put on your thinking cap. We have observed you for some time and think now is the time to test your mettle. But this is not your average job request. We DEMAND utmost secrecy. If you succeed we will reward you with knowledge which many geniuses ( or genii) and even the Cardinal do not have. BUT DO NOT GET CAUGHT or it will be game over for you.\r\n\r\nRegards,\r\nPaladium\r\n\r\nP.S.\r\n  for your First task, scan IP_1.', NULL, 1, 0, 0, 0),
(412, 58, 'nmap', 411, '', 'IP_1', 0, 0, 0, 1),
(413, 58, 'ping', NULL, 'What the....!! Paladium... THE PALADIUM of legends has contacted me? They may be the only group left in this world which has more power than even the Cardinal. Of course there are the rebels but sometimes the Paladium simply seem to be at a whole other level.\r\n\r\nI need to access the system I just scanned. The \"job\" must be somewhere in there.\r\n\r\nHuh?  Wait... No.. They must be kidding.. How the Hell does one do that without getting caught?? You must be kidding me...\r\n\r\nWell sixty years in jail isn\'t bad if you have the slightest chance to gain access to the Paladium knowledge ... right?\r\n\r\n\r\n\r\n', NULL, 2, 0, 0, 0),
(414, 58, 'connect', 413, '', 'IP_1:32', 0, 0, 0, 1),
(415, 58, 'ping', NULL, 'You sure are slow, read the file and follow further instructions. Get the .regdata file on your system.\r\n\r\nGood Luck,\r\nPaladium', NULL, 3, 0, 0, 0),
(416, 58, 'transfer', 415, '', 'Account_Data.regdata|IP_0:22', 0, 0, 0, 1),
(417, 58, 'ping', NULL, 'Ok , I am finally in... what should I do now? Those guys are really close to tracing me completely.. DAMN IT! I should give up...\r\n\r\nWait... Oh gods... it couldn\'t have been this simple.. Thank god I went to that Computer Science School course at first!', NULL, 5, 0, 0, 0),
(418, 58, 'crash_service', 417, '', 'IP_3:693', 0, 0, 0, 1),
(419, 58, 'ping', NULL, 'YESS!! I think  the DDOS worked! I\'ll just scan and check for any remaining online ports.\r\n\r\nWho\'s the boss now?\r\n\r\n', NULL, 6, 0, 0, 0),
(420, 58, 'nmap', 419, '', 'IP_3', 0, 0, 0, 1),
(421, 58, 'ping', NULL, 'Huh... you are not bad ... for an amateur. But really, the fun part starts now. In-case you haven\'t noticed, the Security team has detected you. Did u check for any security systems? No? Well they had a Trojan which allowed them to trace your transfer. Well played smart ass!\r\n\r\nA free hint, their IP is IP_3.\r\n\r\nLets see how smart you Really are.\r\n\r\nHere are two hints:\r\nIP_4\r\n\r\nOffence is the best defence.\r\n\r\nGood Luck,\r\nPaladium\r\n\r\n[i]\r\nReally??? I bet they knew \'bout the Trojan but never told me. Those guys are professionals.. Crack their server or try Paladium\'s hint? The devil and the deep Sea.....[/i]', NULL, 4, 0, 0, 0),
(422, 58, 'crack', 421, '', 'IP_4:99', 0, 0, 0, 1),
(423, 58, 'crack', 421, '', 'IP_3:693', 0, 0, 0, 0),
(424, 59, 'ping', NULL, 'Nice Job evading the security team. You are now , officially a member of Paladium. But first things first, you need to get an encrypted server, your current server is a pile of cello-taped junk. Unfortunatly our teams have no spare servers so you have to get your own.  We have detected a server compatible for you but it has a an extremely good Firewall. It also has a dedicated Slave which has good encryption. \r\n\r\nTo get past the Firewall you need to get a file called Cam.exe  , which cloaks a server making the recovery of the server very hard, so you need to get it installed in your new system to prevent anyone from trying to take control of it. However we do not have it. We have done a WAS ( Wide Area Scan ) and will provide you a list of IP\'s one of which contains the IP for the system which contains the file. Systematically Log on and search for the system which has the file. Follow any trails\r\n\r\nRegards Paladium\r\n\r\nP.S we have provided two sub-standard servers to help in reducing your trace , use them wisely. Also DO NOT TRY to DDOS the server you are trying to capture, wouldnt make sense now would it?\r\n\r\nList of IP:\r\n\r\nIP_5\r\nIP_8\r\nIP_9\r\nIP_11\r\nIP_10\r\nIP_3\r\nIP_7\r\nIP_1', NULL, 1, 0, 0, 0),
(425, 59, 'nmap', 424, '', 'IP_3', 0, 10, 0, 1),
(426, 59, 'ping', NULL, 'Friggin MORONS! They had the resources to just give me the server but no! Still if the Cloak Software exists i guess i can put up with this ..\r\n\r\nBetter see where this leads me ', NULL, 2, 0, 0, 0),
(427, 59, 'crack', 426, '', 'IP_3:656', 0, 0, 0, 1),
(428, 59, 'ping', NULL, 'Huh.... well Whaddya know? That was easy.', NULL, 3, 0, 0, 0),
(429, 59, 'crack', 428, '', 'IP_4:765', 0, 0, 0, 1),
(430, 59, 'crack', 428, '', 'IP_4:876', 0, 0, 0, 1),
(431, 59, 'ping', NULL, 'Hmm... I\'ll have to snoop around for clues it seems.', NULL, 4, 0, 0, 0),
(432, 59, 'cat', 431, '', 'Cam.exe', 0, 0, 0, 1),
(433, 59, 'ping', NULL, 'Damn it! The File is Password protected! Gotta find the answer. I need to search for any hints here. Huh,, maybe the e-m... Yes THATS IT!', NULL, 6, 0, 0, 0),
(434, 59, 'run_file', 433, '', 'Cam.exe|IP_0:22', 0, 0, 0, 1),
(435, 59, 'ping', NULL, 'Yes ! Got it! Let\'s get this file transferred before they detect me !', NULL, 5, 0, 0, 0),
(436, 59, 'transfer', 435, '', 'Cam.exe|IP_0:22', 0, 0, 0, 1),
(437, 59, 'ping', NULL, '/Terminal Window/\r\nWARNING! System Pinged by IP_4 \r\nWARNING! System Firewall Deactive!\r\nWARNING! System Slaves : IP_1 && IP_2 Pinged \r\nWARNING! System  Slaves : IP_1 && IP_2 Firewall deactive\r\n\r\n\r\nDamn this! I need to find the IP for the Main server before they detect me! I can\'t even crash thier system as they still have the IP for the Main Server! I gotta scan for the Main Server NOW!', NULL, 7, 0, 0, 0),
(438, 59, 'nmap', 437, '', 'IP_5', 0, 0, 0, 1),
(440, 59, 'ping', NULL, 'Ok got it... Now what genius? They are almost onto me!', NULL, 8, 0, 0, 0),
(441, 59, 'crash_service', 440, '', 'IP_4:765', 0, 0, 0, 1),
(442, 59, 'crash_service', 440, '', 'IP_4:876', 0, 0, 0, 1),
(443, 59, 'ping', NULL, '/Terminal Window/\r\n\r\n> Decryption of secure ports stopped in IP_0\r\n\r\n> Decryption of secure ports stopped in IP_1\r\n\r\n> Decryption of secure ports stopped in IP_2\r\n\r\n\r\nWhew... just in the nick of time. Now, lets see my new shiny server \r\n', NULL, 9, 0, 0, 0),
(444, 59, 'crack', 443, '', 'IP_5:432', 0, 0, 0, 1),
(445, 59, 'crack', 443, '', 'IP_5:433', 0, 0, 0, 1),
(446, 59, 'crack', 443, '', 'IP_5:987', 0, 0, 0, 1),
(447, 59, 'ping', NULL, 'Awsome... Now that i have the ports i need to run the System file in my server to cloak this attack and protect anyone from trying to recover this server.I Gotta fool this system.. I really hope it isnt password protected.. the last one was bad enough..', NULL, 10, 0, 0, 0),
(448, 59, 'run_file', 447, '', 'System.regdata|IP_0:22', 0, 3000000, 0, 1),
(449, 59, 'ping', NULL, 'Good Job. The New Server AND the Cloak file are all yours now. Further instructions will be emailed to your new server\r\nRegards\r\nPaladium\r\n\r\n\r\nThis was worth it! This new server is AWSOME! And this cloak program is a piece of marvelous technology. Ill just scan my new server once to check if all its ports are functionol or not', NULL, 11, 0, 0, 0),
(450, 59, 'nmap', 449, '', 'IP_5', 0, 0, 0, 1),
(451, 59, 'decrypt_file', 447, '', 'System.regdata', 0, 0, 0, 0),
(452, 60, 'ping', NULL, '*Yawn* Nice morning. Ill eat the leftovers for breakfast..\r\n\r\n\r\n\r\nAlright.. that tasted like cardboard mixed with rotten vegetables. Lets see if Paladium has any work for me', NULL, 1, 0, 0, 0),
(453, 60, 'read_email', 452, '', '0|IP_1:32', 0, 0, 0, 1),
(454, 60, 'ping', NULL, 'Alpha DID THAT?! But should i trust Paladium? They seem to enjoy testing me for \"fun\". If i commit to this there is no going back.', NULL, 2, 0, 0, 0),
(455, 60, 'transfer', 454, '', 'VirtualAccess.pal|IP_1:22', 0, 0, 0, 1),
(456, 50, 'ping', NULL, 'asdfasdf', NULL, 2, 0, 0, 0);
INSERT INTO `quest_objectives` (`id`, `qid`, `type`, `side`, `story`, `data`, `oorder`, `extraTime`, `achievement_id`, `compulsory`) VALUES
(457, 50, 'crack', 456, '', 'IP_3:22', 0, 0, 0, 1),
(458, 61, 'ping', NULL, 'Can\'t believe it .. Im finally taking part in something big. Im a part of a change. ', NULL, 1, 0, 0, 0),
(459, 61, 'read_email', 458, '', '0|IP_1:32', 0, 0, 0, 1),
(460, 61, 'ping', NULL, 'Alright .. seems i have a ton of IP\'s to scan. I have to keep my trace down as well. Ill see if i can bounce off anything.\r\n\r\n\r\n\r\nIP_54\r\nIP_43\r\nIP_23\r\nIP_76\r\nIP_32\r\nIP_86\r\nIP_32\r\nIP_13\r\nIP_43\r\nIP_2\r\nIP_90\r\nIP_86\r\nIP_83\r\nIP_82', NULL, 2, 0, 0, 0),
(461, 61, 'nmap', 460, '', 'IP_2', 0, 0, 0, 1),
(462, 61, 'ping', NULL, 'Whew, got one. Lets see if this has got anything important', NULL, 3, 0, 0, 0),
(463, 61, 'connect', 462, '', 'IP_2:765', 0, 0, 0, 1),
(464, 61, 'ping', NULL, 'Remote Access? Intresting. Well it would be if it wasnt encrypted . Oh.. wait....', NULL, 4, 0, 0, 0),
(465, 61, 'cat', 464, '', 'Remote.access', 0, 0, 0, 1),
(466, 61, 'ping', NULL, 'Jackpot! Better transfer this back first and then follow the trail', NULL, 5, 0, 0, 0),
(467, 61, 'transfer', 466, '', 'Remote.access|IP_1:22', 0, 0, 0, 1),
(468, 61, 'ping', NULL, 'Lets see now.. what was the IP again?', NULL, 6, 0, 0, 0),
(469, 61, 'connect', 468, '', 'IP_3:876', 0, 0, 0, 1),
(470, 61, 'cat', 468, '', 'Sys.log', 0, 0, 0, 1),
(471, 61, 'ping', NULL, 'This just keeps getting better and better ...', NULL, 7, 0, 0, 0),
(472, 61, 'connect', 471, '', 'IP_4:64', 0, 0, 0, 1),
(473, 61, 'read_email', 471, '', '0|IP_4:64', 0, 0, 0, 1),
(474, 61, 'ping', NULL, 'Is that a server!?!? That encryption ! Damn this! Gotta overclock everything now...', NULL, 8, 0, 0, 0),
(475, 61, 'crack', 474, '', 'IP_5:867', 0, 0, 0, 1),
(476, 61, 'cat', 474, '', 'Spy_data.log', 0, 0, 0, 1),
(477, 61, 'ping', NULL, 'OH HOLY CHEESE SPRINKLES! I gotta warn Paladium , ALPHA is gonna go all out! I hope they are monitoring my  ports', NULL, 9, 0, 0, 0),
(478, 61, 'transfer', 477, '', 'Spy_data.log|IP_1:22', 0, 0, 0, 1),
(479, 61, 'ping', NULL, 'This is grave news you have given us recruit. These servers are a few of our top servers. Most of our resources will now be used to protect us. You still have the Cam.exe file , it will buy you some time. You and few others will now crack all these servers and try to stop them. Do Not DDOS them , it will only give away our location.\r\n\r\nYou have been selected to hack IP_6 Our logs say it has Just  DDOS-ed us.\r\n\r\nRegards \r\nPaladium', NULL, 10, 0, 0, 0),
(480, 61, 'connect', 479, '', 'IP_6:987', 0, 0, 0, 1),
(481, 61, 'ping', NULL, 'Friggin Hell! A backtrack virus! Ok gotta act fast. Ill destroy all ALPHA ssh ports after executing rm logs on them.', NULL, 11, 0, 0, 0),
(482, 61, 'delete_logs', 481, '', 'IP_2:765', 0, 0, 0, 1),
(483, 61, 'delete_logs', 481, '', 'IP_3:876', 0, 0, 0, 1),
(484, 61, 'delete_logs', 481, '', 'IP_5:867', 0, 0, 0, 1),
(485, 61, 'crash_service', 481, '', 'IP_2:765', 0, 0, 0, 1),
(486, 61, 'crash_service', 481, '', 'IP_3:876', 0, 0, 0, 1),
(487, 61, 'crash_service', 481, '', 'IP_5:867', 0, 0, 0, 1),
(489, 61, 'ping', NULL, 'That should slow down any attempts to trace me. Id better keep following the trail..', NULL, 12, 0, 0, 0),
(490, 61, 'connect', 489, '', 'IP_8:678', 0, 0, 0, 1),
(491, 61, 'ping', NULL, 'A safehouse , containing Paladium IP\'s! Id better ask Paladium for my next step.\r\n\r\n\r\n/Terminal Window/\r\nPinging IP_86 ...\r\nNegative response.... \r\nPort encrypted..\r\n...\r\nNeed Paladium Access key lvl10.\r\n\r\n\r\n\r\n\r\nDamn.. Paladium must have tightened security. I gotta do something bout that server. Let\' see if i can...', NULL, 13, 0, 0, 0),
(492, 61, 'connect', 491, '', 'IP_7:836', 0, 0, 0, 1),
(493, 61, 'ping', NULL, 'Yess!! IM IN! Now for the fun part , ALPHA won\'t know what hit them.', NULL, 14, 0, 0, 0),
(494, 61, 'sql_delete', 493, '', 'Paladium_server_Database|1|IP_7:836', 0, 60, 0, 1),
(495, 61, 'ping', NULL, '/Communication channel opened/\r\nWhat the... who forced it open?\r\n\r\n/Terminal Window/\r\nDon\'t Panic, this is Paladium. What are you doing? We are under heavy attack, I dont know how the got hold of our secure IP\'s.\r\nStop What you are doing and help encrypt our main server.\r\n\r\n> I was just deleting the tables which contained your IP\'s. I found the address by chance.. its IP_7:836\r\n\r\n\r\nReally? Well i must congratulate you then. However you must retreat ASAP , you may have been detected.\r\n> No worries about that...\r\nMeaning?\r\n> I have already been detected , but i have the attackers IP \r\nWell in that case go on carry on, but DO NOT COMPROMISE US.\r\n/Communication channel closed/\r\n\r\nMe? COMPROMISE THEM? They are the ones who got themselves caught .. \r\nIn any case, I need to take down this , Jacob guy.', NULL, 15, 0, 0, 0),
(496, 61, 'crack', 495, '', 'IP_9:534', 0, 30, 0, 1),
(497, 61, 'ping', NULL, 'Ok Gotta approach carefully ... Ill crack the mail server and then remove logs. After that ill snoop about a bit', NULL, 16, 0, 0, 0),
(498, 61, 'delete_logs', 497, '', 'IP_9:534', 0, 0, 0, 1),
(499, 61, 'sql_delete', 493, '', 'Paladium_server_Database|2|IP_7:836', 0, 0, 0, 1),
(500, 61, 'sql_delete', 493, '', 'Paladium_server_Database|3|IP_7:836', 0, 0, 0, 1),
(501, 61, 'sql_delete', 493, '', 'Paladium_server_Database|4|IP_7:836', 0, 0, 0, 1),
(502, 61, 'sql_delete', 493, '', 'Paladium_server_Database|5|IP_7:836', 0, 0, 0, 1),
(503, 61, 'sql_delete', 493, '', 'Paladium_server_Database|6|IP_7:836', 0, 0, 0, 1),
(504, 61, 'sql_delete', 493, '', 'Paladium_server_Database|7|IP_7:836', 0, 0, 0, 1),
(505, 61, 'sql_delete', 493, '', 'Paladium_server_Database|8|IP_7:836', 0, 0, 0, 1),
(506, 61, 'sql_delete', 493, '', 'Paladium_server_Database|9|IP_7:836', 0, 0, 0, 1),
(507, 61, 'sql_delete', 493, '', 'Paladium_server_Database|10|IP_7:836', 0, 0, 0, 1),
(508, 61, 'read_email', 497, '', '0|IP_9:23', 0, 0, 0, 1),
(509, 61, 'ping', NULL, '\"WE WILL DESTROY HIM COMPLETELY\" ?!?\r\n\r\nThat is bad ...............\r\n\r\nI should snoop around and see if there\'s something worth taking and then leave... Fast!', NULL, 17, 0, 0, 0),
(510, 61, 'transfer', 509, '', 'Alpha_access.key|IP_1:22', 0, 0, 0, 1),
(511, 61, 'ping', NULL, '/Communication channel opened/\r\nRecruit what\'s your status? Have you infiltrated the IP?\r\n>Yes, I am in. Ill just DDOS this guy\r\nDon\'t DDOS him. We have a plan. We are going to infect his computer with a virus that will trace him and any IP\'s he logs on into.\r\n>Should i log off if so?\r\nNo, We cant afford spend time doing this task. We had recently neutralize a slave which has the virus you need. Log on, transfer the file to IP_10  and then run it . We however do not have it\'s password as the server which had it was just DDOS-ed.\r\n\r\nAlso transfer the System log from your main system to the server so it looks as if it\'s your server. When they log on to neutralize \'you\' , we will have attached the trojan to all of their systems \r\n>Ok, got it.\r\nThe IP is IP_11.\r\n/Communication channel closed/\r\n\r\n\r\nLets get crack-a-lackin. ', NULL, 18, 0, 0, 0),
(512, 61, 'transfer', 511, '', 'Tracer.troj|IP_10:645', 0, 0, 0, 1),
(513, 61, 'transfer', 511, '', 'System.log|IP_10:645', 0, 0, 0, 1),
(514, 61, 'ping', NULL, 'Now, lets activate the trojan.', NULL, 19, 0, 0, 0),
(515, 61, 'run_file', 514, '', 'Tracer.troj|IP_10:645', 0, 0, 0, 1),
(516, 62, 'ping', NULL, 'Remember the old days when hazing was common? \r\nYes \r\nWell this seems like its PRETTY close\r\nI agree..\r\n\r\nHey you Noobs! Can your fingers work like your mouths do?\r\n\r\nThe largest , most pimple faced Teen ( idiot kid ) hands me a paper. On it is a list of IP\r\n\r\nIP_1\r\nIP_34\r\nIP_32\r\nIP_23\r\nIP_31\r\nIP_65\r\nIP_51\r\nIP_83\r\nIP_62\r\nIP_35\r\nIP_76\r\nIP_2\r\nIP_58\r\nIP_96\r\nIP_47\r\nIP_46\r\nIP_64\r\nIP_83\r\nIP_78\r\nIP_82\r\n\r\n\r\n\r\nYou guys have to find our two softwares which will run your third software in your main Mac V23.\r\n\r\n\r\nWe look at each other for a moment..... Then we start our work', NULL, 1, 0, 0, 0),
(517, 62, 'connect', 516, '', 'IP_1:23', 0, 0, 0, 1),
(518, 62, 'connect', 516, '', 'IP_2:24', 0, 0, 0, 1),
(519, 62, 'ping', NULL, 'Got em both... now for the main work. Password entering and transferring.', NULL, 2, 0, 0, 0),
(520, 62, 'connect', 519, '', 'IP_3:765', 0, 0, 0, 1),
(521, 62, 'connect', 519, '', 'IP_5:987', 0, 0, 0, 1),
(522, 62, 'ping', NULL, 'Now to transfer these files..', NULL, 3, 0, 0, 0),
(523, 62, 'transfer', 522, '', 'Data1.exe|IP_0:22', 0, 0, 0, 1),
(524, 62, 'transfer', 522, '', 'Data2.exe|IP_0:22', 0, 0, 0, 1),
(525, 62, 'ping', NULL, 'Yes! We GOT IT! Now we just need to run this !', NULL, 4, 0, 0, 0),
(526, 62, 'run_file', 525, '', 'Join.exe|IP_0:22', 0, 0, 0, 1),
(527, 63, 'ping', NULL, 'Those pimple faced teens are GONNA PAY!\r\nWe haven\'t got much time... if we want to hit them hard, we gotta do it quick before they wise up. As a team we will do it .. FOR ALL PEOPLE WHO WERE BULLIED\r\n FOR NARNIA!!!\r\nUse /help to look for command to create file\r\n\r\nwe are gonna do a four way attack.\r\n1) Get his SMPT server.. Find ANY interesting mail and send it/forward it to their local newspaper at riverdale@archies.com IP_1\r\n2) Hack into his School. Create AND run a file named \"modifier.runme\" which will modify their marks. IP_2\r\n3) Hack into their \"Precious\" website and create AND run a file named \"defacer.worm\"IP_3\r\n4) Hack onto their main server and  create a text file named \"payback.txt\" AND RUN IT.IP_4\r\n\r\n\r\n{too much? ;) }', NULL, 1, 0, 0, 0),
(528, 63, 'forward_email', 527, '', '0|riverdale@archies.com|IP_1:21', 0, 0, 0, 1),
(529, 64, 'ping', NULL, '', NULL, 1, NULL, NULL, 0),
(531, 65, 'ping', NULL, 'Today\'s news \'Pink Hat\' decided to hack every organization trying to stop them from ruling the world.\r\nOur leader Gothic has successfully traced some members of them and sent us this picture with a file of what to do. \r\n\r\n[img]http://oi59.tinypic.com/9k2v03.jpg[/img]\r\n\r\n', NULL, 1, 0, 0, 0),
(533, 65, 'nmap', 531, '', 'IP_7', 0, 60, 0, 0),
(534, 65, 'decrypt_file', 531, '', 'virus.exe', 0, 0, 0, 1),
(535, 65, 'transfer', 531, '', 'virus.exe|IP_1:45', 0, 0, 0, 1),
(536, 65, 'transfer', 531, '', 'virus.exe|IP_2:65', 0, 0, 0, 1),
(537, 65, 'transfer', 531, '', 'virus.exe|IP_3:88', 0, 0, 0, 1),
(538, 65, 'transfer', 531, '', 'virus.exe|IP_4:26', 0, 0, 0, 1),
(539, 65, 'transfer', 531, '', 'virus.exe|IP_5:48', 0, 0, 0, 1),
(540, 65, 'transfer', 531, '', 'virus.exe|IP_6:19', 0, 0, 0, 1),
(541, 65, 'run_file', 531, '', 'virus.exe|IP_1:45', 0, 0, 0, 1),
(542, 65, 'run_file', 531, '', 'virus.exe|IP_2:65', 0, 0, 0, 1),
(543, 65, 'run_file', 531, '', 'virus.exe|IP_3:88', 0, 0, 0, 1),
(544, 65, 'run_file', 531, '', 'virus.exe|IP_4:26', 0, 0, 0, 1),
(545, 65, 'run_file', 531, '', 'virus.exe|IP_5:48', 0, 0, 0, 1),
(546, 65, 'run_file', 531, '', 'virus.exe|IP_6:19', 0, 0, 0, 1),
(547, 65, 'ping', NULL, 'This is just the beginning.\r\nbut i\'m proud of having such people in our organization fast and cooperative .\r\nNow you have to check our mail to find out what they\'re planning.', NULL, 2, 0, 0, 0),
(548, 65, 'read_email', 547, '', '0|IP_7:666', 0, 0, 0, 1),
(549, 65, 'nmap', 547, '', 'IP_8', 0, 120, 0, 0),
(557, 65, 'connect', 547, '', 'IP_8:9999', 0, 0, 0, 1),
(558, 65, 'ping', NULL, 'HOLY MOTHER OF GOD !!!!!!!!\r\nwhat shall we do ?!!!\r\nThink ... \r\n\r\ndelete them maybe ?\r\nprobably i will just delete them and crash the server.\r\n\r\ni will just send the email i got later to our leader he surely will tell us what to do.', NULL, 3, 0, 0, 0),
(559, 65, 'delete_file', 558, '', 'spy.trojan', 0, 0, 0, 1),
(560, 65, 'delete_file', 558, '', 'trojan_horse.exe', 0, 0, 0, 1),
(561, 65, 'delete_file', 558, '', 'Acme.exe', 0, 0, 0, 1),
(562, 65, 'delete_file', 558, '', 'Acid.670', 0, 0, 0, 1),
(563, 65, 'delete_file', 558, '', 'AirCop.B', 0, 0, 0, 1),
(564, 65, 'delete_file', 558, '', 'Bomber.CB', 0, 0, 0, 1),
(565, 65, 'delete_file', 558, '', 'ILOVEYOU.x', 0, 0, 0, 1),
(567, 66, 'ping', NULL, 'IP_0\r\nIP_1\r\ntesting sum summa summary \' \" & é \" \' ( - è _ ç à ) = $ ^^ * ù ! : ; , < >\r\ntesting sum summa summary \' \" & é \" \' ( - è _ ç à ) = $ ^^ * ù ! : ; , < >\r\n\r\ntesting sum summa summary \' \" & é \" \' ( - è _ ç à ) = $ ^^ * ù ! : ; , < >\r\ntesting sum summa summary \' \" & é \" \' ( - è _ ç à ) = $ ^^ * ù ! : ; , < >\r\n\r\ntesting sum summa summary \' \" & é \" \' ( - è _ ç à ) = $ ^^ * ù ! : ; , < >', NULL, 1, 0, 0, 0),
(568, 66, 'ping', 567, '', 'IP_0', 0, 0, 0, 1),
(569, 67, 'ping', NULL, '& é \" \' ( - è _ ç à ) = $ ^ ù * µ % + ° ! § : / ; . , ? < >\r\n& é \" \' ( - è _ ç à ) = $ ^ ù * µ % + ° ! § : / ; . , ? < >\r\n& é \" \' ( - è _ ç à ) = $ ^ ù * µ % + ° ! § : / ; . , ? < >\r\n\r\nIP_0\r\nIP_1\r\nIP_2\r\nIP_3', NULL, 1, 0, 0, 0),
(570, 67, 'ping', 569, '', 'IP_1', 0, 0, 0, 1),
(571, 68, 'ping', NULL, 'Last time we found out about one small group of the disaster, yet they got enough viruses to destroy most of the well-known organizations.\r\nThere\'s something that would look funny but we got no hopes except to believe in, if you\'re willing to know the story I\'ve sent you a file with all the information needed.\r\n\r\nIf you think that it\'s bullshit just type \"complete delusion\" and hope that someone else save the world.\r\n\r\nregards,\r\nGothic.', NULL, 2, 0, 0, 0),
(572, 68, 'cat', 571, '', 'An_old_story.bedtime', 0, 0, 0, 1),
(573, 68, 'forward_email', 571, '', '0|China@topsecret.net|IP_8:30', 0, 0, 0, 1),
(574, 68, 'forward_email', 571, '', '0|US@topsecret.net|IP_8:30', 0, 0, 0, 1),
(575, 68, 'forward_email', 571, '', '0|Ge@topsecret.net|IP_8:30', 0, 0, 0, 1),
(576, 68, 'forward_email', 571, '', '0|Ru@topsecret.net|IP_8:30', 0, 0, 0, 1),
(577, 68, 'forward_email', 571, '', '0|India@topsecret.net|IP_8:30', 0, 0, 0, 1),
(578, 68, 'forward_email', 571, '', '0|UK@topsecret.net|IP_8:30', 0, 0, 0, 1),
(579, 68, 'forward_email', 571, '', '0|TN@topsecret.net|IP_8:30', 0, 0, 0, 1),
(580, 68, 'ping', NULL, 'It\'s been awhile did they receive our mail ? ...\r\nLet\'s check if we got anything back from them .', NULL, 3, 0, 0, 0),
(581, 68, 'connect', 580, '', 'IP_8:30', 0, 0, 0, 1),
(582, 68, 'nmap', 580, '', 'IP_8', 0, 0, 0, 0),
(583, 68, 'ping', NULL, 'awesome !\r\nThey all sent back ! \r\ni hope they are willing to help ', NULL, 4, 0, 0, 0),
(584, 68, 'read_email', 583, '', '', 0, 0, 0, 0),
(585, 63, 'run_file', 527, '', 'modifier.runme|IP_2:564', 0, 0, 0, 1),
(586, 63, 'run_file', 527, '', 'defacer.worm|IP_2:43', 0, 0, 0, 1),
(587, 63, 'run_file', 527, '', 'payback.txt|IP_4:78', 0, 0, 0, 1),
(590, 65, 'ping', NULL, 'what was his email again ....\r\noh yes Gothic@TheCure.net\r\nso i need to forward that mail and wait ...', NULL, 4, 0, 0, 0),
(591, 65, 'connect', 590, '', 'IP_7:666', 0, 0, 0, 1),
(592, 65, 'forward_email', 590, '', '0|Gothic@TheCure.net|IP_7:666', 0, 0, 0, 1),
(593, 65, 'crash_service', 558, '', 'IP_8:9999', 0, 0, 0, 1),
(594, 68, 'ping', NULL, 'test\r\nIP_0\r\nIP_1\r\nIP_2', NULL, 1, 0, 0, 0),
(595, 68, 'forward_email', 594, '', '0|China@topsecret.net|IP_8:30', 0, 10, 0, 1),
(597, 69, 'ping', NULL, 'V.S.O  has contacted us. Know what V.S.O means? Very Smart Organization. Cant believe these guys were able to track our last escapade.\r\n\r\nWe just saw their E-Mail on our private SMTP server , IP_1 \r\n\r\nLets hope they pay well.', NULL, 1, 0, 0, 0),
(598, 69, 'read_email', 597, '', '0|IP_1:43', 0, 20, 0, 1),
(599, 69, 'ping', NULL, 'Lets do this then ! Lets go guys!', NULL, 2, 0, 0, 0),
(600, 69, 'connect', 599, '', 'IP_2:65', 0, 0, 0, 1),
(601, 69, 'ping', NULL, 'Keys? Probably some passwords to a file. For now lets just decode them , then check our server again.\r\nWhat the bleeding hell? Dont tell me its in base64... We have to do this manually. Lets go go go! ', NULL, 3, 0, 0, 0),
(602, 69, 'connect', 601, '', 'IP_1:43', 0, 0, 0, 1),
(603, 69, 'ping', NULL, 'A new file? Let\'s see what it is.\r\n\r\nLaser Guidance? What the hell did we get into?\r\n\r\nHmm.. I wonder what we could use it for. Lets just run it in IP_1 ,after all we deserve to see what we hacked.', NULL, 4, 0, 0, 0),
(604, 69, 'run_file', 603, '', 'Laserguidance.runx|IP_1:22', 0, 0, 0, 1),
(605, 70, 'ping', NULL, '*ahahaha* So you\'re the new bunch, aren\'t you? *smirk*\r\n \r\nFresh meat has arrived people.\r\n\r\n[i]This guy is irritating me and he\'s barely started speaking. This is going to be such a long day, I can feel it.[/i]\r\n\r\nI don\'t know what made you want to be part of this mess. If it\'s your friends who signed you up, you might want to withdraw, NOW! Believe me, there will come a time when it\'s too late and you\'ll find yourself trapped and regretting not listening to your nasty instructor *cough* ME *cough* in the first lesson.\r\n\r\nThe world you\'re about to enter will swallow you completely and even when you feel like you\'re the own changing the world it\'s the world that changes you really.\r\n\r\n[i]He makes it sound so majestic. Luckily I know better.[/i]\r\n\r\nI\'m not sure how much history you know but we\'ll cover that later on as you will start your Computer Science crash course. For now, I will only share a few details about the tech competition, which you might already be aware of but we must follow the protocol..\r\n\r\nWell, first off we all know Alpha. Our corporation is now the main provider of technology and services for the entire planet and beyond it as well. \r\n\r\nOnly the brightest of the brightest are employed and the man at the top of the food chain is a mystery in itself. However, it\'s been publicly announced that he will soon want to retire (for no apparent official reason, rumours say he is sick but who are we to say for sure) and he\'s designed an entire system to select that one individual, male or female, of any zone, to take his place after his early demise. \r\n\r\nEmilia is the Artificial Intelligence entity controlling the Grid and more or less the entirety of Alpha\'s system and as such the world. The president of Alpha has hence designed the Cardinal, a complementary entity to Emilia. The Cardinal has the job of supervising the competition and enforcing its rules. \r\n\r\nNow what the competition is about. To put it in one word: hacking. The Cardinal Mainframe has access to all the systems Emilia has but is subordinated to her. However, he can observe and analyse everything everyone is doing and evaluates the progress of competitors based on their innovative hacking skills.\r\n\r\nYou might be aware that the competition has since degenerated to street fight and even ... murder at times. Some would do anything to be in control of Alpha and for good reason. Alpha has singlehandedly transformed the world in a hacker\'s playground. There are even parents who educate their children with the only purpose of participating and winning their competition when they grow up.\r\n\r\nThe reward for this game is whatever remains of the world in the end.\r\n\r\nThat\'s it for our short intro. I will leave you to our instructors now. Simply type [b]run final.sh[/b] in the input field / console when you\'re set to go.\r\n\r\n', NULL, 1, 0, 0, 0),
(606, 70, 'run_file', 605, '', 'final.sh|IP_0:22', 0, 0, 0, 1),
(607, 71, 'ping', NULL, 'Your task is trivial, hacker.\r\n\r\nWe\'ve given you three server IP\'s. On the first two servers you will find files containing the parameters required for you to run the file located on the third server.\r\n\r\nYou need only run the file on the third server on your main computer (so yeah you will need to transfer it to your main).\r\n\r\n', NULL, 1, 0, 0, 0),
(608, 20, 'ping', 72, '', NULL, 0, NULL, NULL, 0),
(609, 71, 'run_file', 607, '', 'hackdown.sh|IP_0:22', 0, 0, 0, 1),
(610, 72, 'ping', NULL, 'We\'ve provided you with the address of a server.\r\n\r\nHack into it, study what you find and get into the main database.\r\n\r\nYour mission is to read the contents from the single table available in that database and run the file we\'ve placed on your MAIN (hackdown.sh) using the parameters you find in that table.\r\n\r\nMake your way to the top, USERNAME!', NULL, 1, 0, 0, 0),
(611, 72, 'run_file', 610, '', 'hackdown.sh|IP_0:22', 0, 0, 0, 1),
(612, 20, 'ping', NULL, '', NULL, 12, NULL, NULL, 1),
(613, 20, 'ping', NULL, '', NULL, 13, NULL, NULL, 1),
(614, 74, 'ping', NULL, 'We are developing new security systems every day and we need you to help us out.\r\n\r\nYou\'ll have to hack into a few systems and decrypt and run a small number of files. This might take less or more time each time as we test different algorithms and encryption techniques.\r\n\r\nDon\'t forget to have fun!\r\n\r\nFor appetizers, hack into IP_1, explore and interact with what you find there.', NULL, 1, 0, 0, 1),
(615, 74, 'run_file', 614, '', 'protectedFile.readme|IP_1:120', 0, 0, 0, 1),
(616, 74, 'ping', NULL, 'Cool. You did it.\r\n\r\nOne last thing. Connect to IP_2:22.\r\n\r\nThere are two encrypted files there. Both contain one string required for a third file that you will find there to run.\r\n\r\nThese strings are parameters that you need to pass to the third file to execute it. E.g. [b]run something.file parameter1 parameter2 etc[/b].\r\n\r\nRun the third file to prove our encryptions have failed yet again.\r\n\r\nAnd I guess we\'ll be back to the drawing board.', NULL, 2, 0, 0, 1),
(617, 74, 'run_file', 616, '', 'run.sh|IP_2:22', 0, 0, 0, 1),
(619, 75, 'ping', NULL, 'Our competition keeps on updating their electrical cars every week or so. Always on a different day.\r\n\r\nThey launch new models as well. Once they get off the production line, the cars are programmed to automatically drive themselves to selling points around the world.\r\n\r\nWe need you to hack one of these cars by first hacking into the manufacturer\'s database and finding a list of car internal server IP\'s. As all of them are connected to the Grid, you\'ll be able to hack in as long as you have an IP. Most of the cars will still be on the production line with nothing installed on them, you\'ll need to identify one with an SSH service running.\r\n\r\nWe\'ve provided you with a script which needs to be ran on one of the cars. Once ran the script will send back data to us and your job will be complete. Remember to delete the file after running it.\r\n\r\nYou know a car is viable if it has the file [b]car.os[/b] present on its SSH server.\r\n\r\nThe current address of the manufacturer database is IP_1.', NULL, 1, 0, 0, 1),
(620, 75, 'run_file', 619, '', 'data.transmit|IP_4:435', 0, 0, 0, 1),
(621, 75, 'delete_file', 619, '', 'data.transmit', 0, 0, 0, 1),
(622, 76, 'ping', NULL, 'Since I\'ve joined this hacking competition I\'ve done things for others only... difficult jobs and mysterious emails, that\'s all it has been about.\r\n\r\nBut if you want to do something good you need to do it yourself and for yourself.\r\n\r\nPeople transfer money these days using the Grid alone. No more solid cash is being moved around for years now. So if I want to get some greenies I will have to find some work around.\r\n\r\nI\'ve devised a plan a while ago but never got around to putting it into practice.\r\n\r\nI\'m thinking I could edit the transaction logs of a grid bank node to trick the system into thinking a transaction of a certain amount of money has been made into my account.\r\n\r\nI\'ll also run a script on my computer which will basically block the grid bank node from contacting the outside world (which the node will log in its operating system).\r\n\r\nWhile that script is running I will hack into the power generator controls of that bank node\'s area and restart it.\r\n\r\nWhat this should do is allow me to report to Alpha that a transaction has not been completed to my account. They will check the logs on the bank node and see my fake transactions there and then they will notice the crash of the power generator and will assume the transaction was not completed due to the power outage. There are many of these these days because of the Beta and Omega movements. \r\n\r\nOnce they confirm the above, they will simply deliver the money to my account just to not be bothered.\r\n\r\nIf all goes well, I will finally have some money to live in comfort.\r\n\r\nI\'ve left some programs running in the background for the past week, scanning the Grid for bank nodes. The resulting file is on my local storage. Some of them might be out of date by now as the Grid constantly reconfigures itself.', NULL, 1, 0, 0, 1),
(623, 76, 'connect', 622, '', 'IP_3:352', 0, 0, 0, 1),
(624, 76, 'ping', NULL, 'I\'ve made a copy and edited the transaction logs file on my main computer.\r\n\r\nNow I\'ll have to delete transaction.logs from IP_3 and transfer the transaction.logs file from my server IP_0:22 to IP_3 to replace the deleted file.', NULL, 2, 0, 0, 1),
(625, 76, 'transfer', 624, '', 'transaction.logs|IP_3:352', 0, 0, 0, 1),
(626, 76, 'delete_file', 624, '', 'transaction.logs', 0, 0, 0, 1),
(627, 76, 'ping', NULL, 'Great. Everything is in place.\r\n\r\nNow, as planned, I must temporarily overload the bank node to make it and the Alpha investigators believe it was unable to deliver the transaction. And while my script does that I will have into electrical generator of the area and crash it to restart everything in a believable fashion.\r\n\r\nI\'ve create overload.vir on my main server. I\'ll have to run it offering the IP and port of the bank node as parameters.\r\n', NULL, 3, 0, 0, 1),
(628, 76, 'run_file', 627, '', 'overload.vir|IP_0:22', 0, 0, 0, 1),
(629, 76, 'ping', NULL, 'Seems to be working.\r\n\r\nWhat I need to do now is hack into IP_4 and transfer [b]crash.sh[/b] from my main computer to that server and run it.\r\n\r\nSince that\'s the power generator for the area the bank node (IP_3) is located, it will crash everything and restart as soon as it\'s back on. My overloading script will also stop executing as soon as I run crash.sh so all I\'ll have to do afterwards is to submit a report to Alpha to complain about my incomplete transaction  ^^.', NULL, 4, 0, 0, 1),
(630, 76, 'run_file', 629, '', 'crash.sh|IP_4:211', 0, 0, 0, 1),
(631, 77, 'ping', NULL, 'He\'s about to come out of the building. His day job ends soon so he\'ll head to his favourite restaurant for a bite before going home where he lives alone.\r\n\r\nI\'m going to hack into his car and bug it. I\'ll also check inside if he\'s left any devices like a Glass Tablet or maybe he even forgot his Glass Device (highly improbable as that\'s basically one\'s life) in.\r\n\r\nAnyhow, that\'s his car. No one\'s around. I\'ve placed a small device on the locking mechanism. It comes in contact with the car systems and allows me to interact with them wirelessly.\r\n\r\nPerfect, I have the IP: IP_1.\r\n\r\nFirst things first, I need to get through the security.', NULL, 1, 0, 0, 1),
(632, 77, 'crack', 631, '', 'IP_1:3756', 0, 0, 0, 1),
(633, 77, 'ping', NULL, 'That went well. A friend of mine has sent me the exploit for this model of car just in time. I\'ll just have to execute it using the IP and open port of the car as parameters.\r\n\r\nI\'ve downloaded the exploit he\'s sent me on my main server. Just need to run it, I guess.\r\n', NULL, 2, 0, 0, 1),
(634, 77, 'run_file', 633, '', 'carOS.exploit|*:*', 0, 0, 0, 1),
(635, 77, 'ping', NULL, 'He\'s still not here. That\'s good.\r\n\r\nAnd I\'m in the car, the door has opened as well.\r\n\r\nNothing of value around and there are absolutely no devices in the car that I could bug. I\'ll leave a little process which will send me GPS data so I can track him around.\r\n\r\nOh god, he\'s coming, I can see him through the glass walls of the building. Quickly, I need to kill the exploit and get out of here.', NULL, 3, 0, 0, 1),
(636, 77, 'kill_file', 635, '', 'carOS.exploit|*:*', 0, 0, 0, 1),
(637, 77, 'ping', NULL, 'That was close. A bit too close. I barely managed to run in time. He\'s driving away but my tracker seems to be working. \r\n\r\nI\'ll get my in my car and follow him.\r\n\r\nHe\'s indeed approaching the restaurant he visits almost every night. He stopped and I\'ve parked a few cars away.\r\n\r\nHe\'s in the restaurant now. I can pick up two wireless enabled devices that he owns. One is the Glass Device he has with him in the restaurant and the other is the Glass Table he must have brought from his office and left in the car. The two should be synced so most likely will contain same data.\r\n\r\nI don\'t have time and neither do I need to hack into both so I\'ll need to make a choice.\r\n\r\nI\'ve got scripts to discover their grid IP\'s, by hacking them wirelessly, on my main computer. I\'ll have to run one of them and go with that.', NULL, 4, 0, 0, 1),
(638, 77, 'run_file', 637, '', 'glassDevice.findip.sh|IP_0:22', 1, 0, 0, 1),
(639, 77, 'run_file', 637, '', 'glassTablet.findip.sh|IP_0:22', 1, 0, 0, 1),
(646, 77, 'ping', NULL, 'Oh wow, that\'s brilliant! His personal notes :3.\r\n\r\nLooks like I\'m in for a treat. \r\n\r\nThat foreign account data looks encrypted. Luckily these days you can use [url=http://bit.ly/KO4pQU]any search engine to find a base64 decoder[/url].\r\n\r\nI\'ve also picked up his laptop (IP_4:23). I\'m expecting some bankings apps will be installed onto it and I\'ll be able to use these accounts and passwords to run them.', NULL, 6, 0, 0, 1),
(649, 77, 'ping', NULL, 'After I ran it, a file was generated, containing the IP of the device. I\'ll poke my nose and see what I find.', NULL, 5, 0, 0, 1),
(650, 77, 'connect', 649, '', 'IP_2:3306', 1, 0, 0, 1),
(651, 77, 'connect', 649, '', 'IP_3:3306', 1, 0, 0, 1),
(652, 77, 'connect', 646, '', 'IP_4:23', 0, 0, 0, 1),
(653, 77, 'ping', NULL, 'I\'ll access all the banking apps he has. \r\n\r\nI only need to run them using the accounts and passwords I found and my viruses will take care of the rest rendering his vaults empty and mine\'s happier than ever.', NULL, 7, 0, 0, 1),
(654, 77, 'run_file', 653, '', 'bank.app|*:*', 0, 0, 0, 1),
(655, 77, 'run_file', 653, '', 'external-zone-bank.app|*:*', 0, 0, 0, 1),
(656, 78, 'ping', NULL, 'We\'ve received reports that some of our enemies have recently tries to access one or more of our servers.\r\n\r\nThe following servers have been compromised:\r\nIP_1\r\nIP_2\r\nIP_3\r\n\r\nConnect to and check of the logs of any of these servers and you should be able to identify the servers we we\'re hacked or attempted to be hacked from.\r\n\r\nYour task is to access the enemy servers, identify personal servers of their members, access one of those servers and delete all the files you find there.\r\n\r\nWe\'ll take revenge on them one at a time. ', NULL, 1, 0, 0, 1),
(657, 78, 'delete_file', 656, '', 'personal.data', 0, 0, 0, 1),
(658, 78, 'delete_file', 656, '', 'bank.app', 0, 0, 0, 1),
(659, 78, 'delete_file', 656, '', 'messages.archive', 0, 0, 0, 1),
(660, 38, 'connect', 182, '', 'IP_5:22', 0, 0, 0, 1),
(661, 73, 'ping', NULL, 'Hello there. We really havnt got much time , Good luck\r\n\r\n\r\nYou have been given a main server with the IP as IP_1  ports 22 and 54', NULL, 1, 0, 0, 1),
(662, 73, 'connect', 661, '', 'IP_1:22', 0, 30, 0, 1),
(663, 73, 'ping', NULL, 'Well , atleast you can Find your way around the Grid.\r\n\r\nFollow the instructions on the email in the SMTP server.\r\nSee you later..... If you ever complete these fiendish tasks that is ...\r\n', NULL, 2, 0, 0, 1),
(665, 73, 'connect', 663, '', 'IP_6:43', 0, 0, 0, 1),
(666, 73, 'run_file', 663, '', 'Option1.runme|IP_1:22', 0, 0, 0, 0),
(667, 73, 'run_file', 663, '', 'Option2.runme|IP_1:22', 0, 0, 0, 0),
(668, 73, 'run_file', 663, '', 'First.txt|IP_2:5837', 0, 0, 0, 0),
(669, 73, 'ping', NULL, 'Good work getting till here. We are Impressed. But let us see if you can solve this puzzle.', NULL, 3, 30, 0, 1),
(670, 73, 'run_file', 669, '', 'IP.docx|IP_6:43', 0, 0, 0, 1),
(671, 73, 'ping', NULL, 'What the Hell.... Paladium??? Isn\'t it a part of the OTHER mission set.... Ahh well , nevermind.. Back to work.\r\n\r\nVisit your Main Server again..............', NULL, 4, 0, 0, 1),
(672, 73, 'crash_service', 671, '', 'IP_8:654', 0, 0, 0, 1),
(673, 73, 'crash_service', 671, '', 'IP_9:9999', 0, 0, 0, 1),
(674, 79, 'ping', NULL, 'You sign-up online.\r\n\r\nA terminal pops up.\r\n\r\n> Are you ready to begin? (Y/N)\r\n\r\n> Y\r\n\r\n---- Starting program----\r\n\r\n> Start by cracking and connecting to  IP_1:22', NULL, 1, 0, 0, 1),
(675, 79, 'ping', 674, '', 'IP_1:22', 0, 30, 0, 0),
(676, 79, 'connect', 674, '', 'IP_1:22', 0, 0, 0, 1),
(677, 79, 'ping', NULL, '', NULL, 2, NULL, NULL, 1),
(678, 79, 'run_file', 677, '', 'Client.exe|IP_2:8888', 0, 0, 0, 1),
(679, 81, 'ping', NULL, '', NULL, 1, NULL, NULL, 1),
(680, 81, 'ping', 679, '', NULL, 0, NULL, NULL, 1);

CREATE TABLE `quest_services` (
  `service_id` int(11) NOT NULL,
  `hid` int(11) DEFAULT NULL,
  `type` varchar(10) DEFAULT 'ssh',
  `port` varchar(15) NOT NULL DEFAULT '22',
  `encryption` varchar(15) DEFAULT NULL,
  `welcome` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `quest_services` (`service_id`, `hid`, `type`, `port`, `encryption`, `welcome`) VALUES
(40, 51, 'ssh', '22', NULL, NULL),
(41, 52, 'ssh', '120', '3000', 'Hahahahahahaa [color=red]asdfasdf[/color]\r\n\r\nHost has hidden files!'),
(42, 52, 'smtp', '130', '0', 'SMTP yeeey'),
(44, 52, 'sql', '140', '0', 'SQL YEEEY'),
(45, 60, 'ssh', '22', NULL, NULL),
(46, 61, 'ssh', '22', '0', 'Welcome USERNAME.\r\n\r\nGood luck!'),
(47, 62, 'ssh', '22', NULL, NULL),
(48, 63, 'ssh', '22', '10', 'Welcome to echoLTD Admin Server.\r\n\r\n[i]Keep your login credentials secure and report any suspicious behaviour![/i]'),
(49, 64, 'ssh', '22', NULL, NULL),
(50, 65, 'ssh', '89', '12', '~Welcome, Administrator~\r\n\r\n-[update.log.12] Document received.\r\n\r\n\r\n\r\nLast Update Log'),
(51, 65, 'http', '510', '100', '~Welcome, Administrator~\r\n\r\n-[update.log.12] Document recived on main server.\r\n\r\n\r\n\r\nLast Update Log'),
(55, 68, 'smtp', '3123', '45', ''),
(56, 69, 'ssh', '22', NULL, NULL),
(57, 70, 'smtp', '465', '0', 'Welcome back, USERNAME.\r\n\r\nMail Server Status [color=green]OK[/color]'),
(58, 71, 'sql', '3028', '200', ''),
(59, 71, 'smtp', '364', '1000', ''),
(60, 71, 'ssh', '42', '100', 'Alpha Grid Node 940630\r\n\r\nSync with Cardinal System status: Up to date\r\n\r\nScheduled maintenance: 4 days from now\r\n\r\nLoca grid status: Live\r\n\r\nWelcome, USERNAME.\r\n'),
(61, 71, 'ssh', '22', NULL, NULL),
(62, 73, 'ssh', '24', '50', 'Omega Server 13\r\n\r\nFull Security Protocols Apply'),
(63, 74, 'ssh', '22', NULL, NULL),
(67, 76, 'smtp', '974', '0', 'Alpha eServer 4839184 - Keep it safe.'),
(68, 77, 'ssh', '3675', '45', 'Alpha Terminal - authorized personnel only'),
(69, 78, 'ssh', '7923', '5', '~Welcome to the server~\r\n\r\nRecepies only!!!'),
(70, 80, 'ssh', '14', '23', 'You deserve it, so take it.\r\n\r\nYou were quicker than I expected.'),
(71, 79, 'ssh', '941', '23', 'Damn, caught me again... and as I was updating the welcome message? \r\n\r\nYou are better than expected.'),
(75, 81, 'smtp', '23', '0', 'Welcome back, USERNAME.'),
(76, 82, 'ssh', '22', NULL, NULL),
(77, 83, 'smtp', '934', '0', '----=-==---------------=-=-=-----------------3123-----------------=--==--------'),
(78, 83, 'smtp', '974', '0', 'Alpha eServer 4839184 - Keep it safe.'),
(79, 84, 'ssh', '465', '0', 'USERNAME file storage\r\n-----------------------------------------------------------------'),
(80, 1, 'ssh', '22', NULL, NULL),
(81, 85, 'ssh', '399', '100', 'Grid Node Internal File Storage\r\n------------------------------------------------------------------\r\nExercise caution when dealing with files on this server.\r\n------------------------------------------------------------------'),
(82, 86, 'ssh', '734', '110', 'Grid Node Internal File Storage\r\n------------------------------------------------------------------\r\nExercise caution when dealing with files on this server.\r\n------------------------------------------------------------------'),
(83, 87, 'ssh', '286', '120', 'Grid Node Internal File Storage\r\n------------------------------------------------------------------\r\nExercise caution when dealing with files on this server.\r\n------------------------------------------------------------------'),
(84, 89, 'ssh', '22', NULL, NULL),
(85, 90, 'ssh', '22', NULL, NULL),
(86, 92, 'ssh', '22', NULL, NULL),
(88, 93, 'smtp', '25', '10', 'Simple Email Server'),
(89, 94, 'ssh', '22', NULL, NULL),
(90, 95, 'ssh', '22', '0', 'SSH test server.'),
(91, 96, 'ssh', '22', '10', 'Encrypted SSH server.'),
(92, 97, 'ssh', '22', NULL, NULL),
(93, 98, 'ssh', '22', NULL, NULL),
(94, 99, 'ssh', '22', NULL, NULL),
(95, 100, 'ssh', '22', NULL, NULL),
(96, 101, 'sql', '1433', '10', 'SQL test server'),
(97, 102, 'ssh', '22', NULL, NULL),
(98, 103, 'smtp', '325', '0', 'Welcome back, USERNAME. No outstanding events have been detected since your last checkin. All systems online.'),
(99, 104, 'ssh', '24', '45', 'Access Granted - Bio-Keltech web sync server - modifications to files on this server will be synced with the main server every few hours.'),
(101, 106, 'smtp', '25', '0', 'Email Service'),
(102, 107, 'ssh', '80', '0', 'crY m3 @ rIv3R-B0Z0'),
(103, 108, 'ssh', '75', '1', 'Domlux Entertainment'),
(104, 109, 'ssh', '22', '1', 'Tempcare'),
(107, 112, 'ssh', '80', '1', 'Eagle Networks: How may we assist you?'),
(108, 113, 'ssh', '80', '1', 'Overcorporation'),
(109, 114, 'ssh', '22', '1', 'Biocity Chemicals '),
(110, 115, 'ssh', '80', '1', 'ZapTechno'),
(111, 116, 'ssh', '80', '1', 'The cooking webshop'),
(112, 117, 'ssh', '22', '1', 'Gogotaxon Inc'),
(114, 116, 'smtp', '22', '1', 'You have no mails'),
(115, 118, 'ssh', '22', '1', 'Zoomfan'),
(116, 119, 'ssh', '22', '1', 'Voltzenin'),
(117, 120, 'ssh', '233', '1', 'Y0&micro; &sect;H0&ugrave;lD n0t B3 H3r3 !!!'),
(118, 121, 'ssh', '22', NULL, NULL),
(119, 122, 'smtp', '22', '0', '[b]Welcome, Senta Employee![/b] Please remember to clear out your inbox once every week!'),
(121, 123, 'ssh', '541', '3', '[b]This server is for authorized personnel only.[/b]'),
(122, 124, 'ssh', '228', '5', ''),
(123, 125, 'ssh', '22', NULL, NULL),
(124, 126, 'smtp', '428', '3', '[b]Welcome to Somalian Express Mail![/b]'),
(125, 127, 'ssh', '7777777', '7', '[b]Welcome to Somalian Express\' Lucky Seven Server[/b]'),
(126, 128, 'ssh', '22', '0', ''),
(127, 129, 'smtp', '22', '0', 'WELCOME!'),
(128, 130, 'ssh', '22', NULL, NULL),
(129, 151, 'ssh', '22', '0', 'Restricted!'),
(130, 152, 'smtp', '543', '0', ''),
(131, 152, 'ssh', '134', '0', ''),
(132, 153, 'ssh', '22', NULL, NULL),
(133, 154, 'ssh', '3006', '0', 'Warning: Sensitive data. You will be held responsible for any missing files.'),
(134, 154, 'sql', '3007', '150', 'Connection log database. Required Access Level 3. Unattended access restricted. Welcome back, USERNAME.'),
(135, 155, 'ssh', '56', '60', 'This is a company workstation and shall not be use for anything than handling research related work. No other machines may be used to transfer data from the research storage servers.'),
(136, 161, 'ssh', '478', '60', 'This is a company workstation and shall not be use for anything than handling research related work. No other machines may be used to transfer data from the research storage servers.'),
(138, 162, 'ssh', '33', '60', 'This is a company workstation and shall not be use for anything than handling research related work. No other machines may be used to transfer data from the research storage servers.'),
(140, 160, 'ssh', '325', '60', 'This is a company workstation and shall not be use for anything than handling research related work. No other machines may be used to transfer data from the research storage servers.'),
(141, 159, 'ssh', '137', '60', 'This is a company workstation and shall not be use for anything than handling research related work. No other machines may be used to transfer data from the research storage servers.'),
(142, 156, 'ssh', '34', '60', 'This is a company workstation and shall not be use for anything than handling research related work. No other machines may be used to transfer data from the research storage servers.'),
(143, 157, 'ssh', '404', '60', 'This is a company workstation and shall not be use for anything than handling research related work. No other machines may be used to transfer data from the research storage servers.'),
(144, 158, 'ssh', '535', '60', ''),
(146, 158, 'smtp', '360', '120', ''),
(147, 163, 'ssh', '471', '200', 'Alpha Grid Node - Part of the Grid Global Network. Restricted access. Illegal access punishable by law.'),
(148, 165, 'ssh', '22', NULL, NULL),
(151, 166, 'ssh', '22', NULL, NULL),
(152, 167, 'ssh', '22', '10', ''),
(153, 168, 'ssh', '22', NULL, NULL),
(154, 169, 'ssh', '41', '60', ''),
(155, 170, 'ssh', '22', '60', ''),
(157, 172, 'smtp', '22', '0', ''),
(159, 173, 'ssh', '22', NULL, NULL),
(160, 176, 'ssh', '22', '1000000', ''),
(162, 131, 'sql', '456', '10', 'It\'s a zoo out there!'),
(163, 132, 'ssh', '112', '10', 'Welcome to the Ant\'s Den.'),
(164, 133, 'ssh', '5555', '10', 'You cant see me!'),
(165, 134, 'ssh', '142', '10', 'Welcome to The Tool Network, how may we assist you?'),
(166, 135, 'ssh', '258', '10', 'How smart are you?'),
(167, 136, 'ssh', '741', '10', 'Huge Bogus File Server'),
(168, 177, 'ssh', '23', '0', ''),
(169, 178, 'ssh', '24', '0', ''),
(170, 179, 'ssh', '33', '20', 'IRP_4_3\r\n\r\nGood job. You should now have gathered all the pieces. Are you ready to put them together?'),
(171, 180, 'ssh', '1', '0', ''),
(172, 137, 'ssh', '154', '10', 'CAT The Odd One Out'),
(173, 137, 'sql', '745', '10', 'CAT The Odd One Out SQL'),
(176, 139, 'ssh', '987', '10', 'Chemistry Time'),
(177, 140, 'ssh', '569', '10', 'You got me!'),
(178, 181, 'ssh', '22', NULL, NULL),
(179, 182, 'ssh', '22', '2', ''),
(181, 183, 'ssh', '22', '22', ''),
(182, 184, 'ssh', '22', '22', ''),
(183, 185, 'ssh', '22', '22', ''),
(184, 186, 'ssh', '22', NULL, NULL),
(185, 187, 'sql', '22', NULL, NULL),
(186, 188, 'ssh', '22', '10', ''),
(187, 189, 'ssh', '22', '10', ''),
(188, 190, 'ssh', '22', '10', ''),
(189, 191, 'ssh', '22', '10', ''),
(190, 192, 'ssh', '22', '10', ''),
(191, 193, 'ssh', '22', '10', ''),
(192, 194, 'ssh', '22', '10', ''),
(193, 195, 'ssh', '22', '10', ''),
(194, 196, 'ssh', '22', '10', ''),
(195, 197, 'ssh', '22', '10', ''),
(196, 198, 'ssh', '22', '10', ''),
(197, 199, 'ssh', '22', '10', ''),
(198, 200, 'ssh', '22', '10', ''),
(199, 201, 'ssh', '22', '10', ''),
(200, 202, 'ssh', '22', '10', ''),
(201, 203, 'ssh', '22', '10', ''),
(202, 204, 'ssh', '22', '10', ''),
(203, 205, 'ssh', '22', '10', ''),
(204, 206, 'ssh', '22', '10', ''),
(205, 140, 'sql', '54', '10', 'You got me SQL'),
(206, 207, 'ssh', '105', '100', 'Security Master Server - File Service'),
(207, 207, 'sql', '297', '110', ''),
(209, 207, 'smtp', '777', '0', ''),
(210, 207, 'sql', '104', '50', 'Old SQL service - Due for deletion two months from now'),
(211, 209, 'ssh', '34', '110', ''),
(212, 213, 'ssh', '22', '100', ''),
(214, 211, 'ssh', '22', '10', ''),
(215, 214, 'ssh', '22', '120', 'M.D. - Access Level A'),
(216, 211, 'sql', '306', '0', ''),
(217, 213, 'sql', '22', '100', ''),
(218, 208, 'ssh', '22', '100', ''),
(219, 210, 'ssh', '14', '100', ''),
(220, 212, 'ssh', '22', '0', 'Server flagged as Due for maintenance.'),
(221, 215, 'ssh', '22', NULL, NULL),
(222, 216, 'ssh', '228', '5', 'Congratulations, USERNAME, you have got one step closer.'),
(223, 217, 'ssh', '228', '5', 'Oops, looks like you chose the wrong port. Try again.'),
(224, 217, 'smtp', '880', '5', 'Welcome USERNAME, you are on the right track'),
(225, 218, 'ssh', '22', NULL, NULL),
(228, 219, 'smtp', '25', '0', 'Hi, USERNAME! Welcome to your private mail server!'),
(229, 220, 'ssh', '456', '0', 'On this server you can download my CV, my contacts etc.'),
(230, 220, 'sql', '222', '18', 'Michael\'s Private SQL web server'),
(231, 221, 'ssh', '22', '50', 'Welcome to the CloMed corporation webserver, if you find traces of hacking, cracking and similar things, contact the system administrator, please.'),
(234, 222, 'sql', '999', '30', 'Hi USERNAME!\r\nNow let\'s do some math.. You liked math at school, right? ;)\r\n\r\nTHIS IS THE QUEST:\r\n\r\nDelete the number sequence called -Fibonacci sequence- and navigate to the IP assigned to the -Triangular numbers-\r\n'),
(235, 223, 'ssh', '22', '50', 'Ok, USERNAME, this is the final step of our marathon; you have to:\r\n1) Decrypt both the files on this server\r\n2) Transfer them to your Main Server (IP_0:22)\r\n3) Copy them to the server x where:\r\nx=ATOMIC NUMBER OF THE OXYGEN - NUMBER OF THE PIECES OF THE TANGRAM\r\n1 -- michael.public.server\r\n2 -- clomed.storage.server\r\n3 -- IP_14'),
(236, 224, 'sql', '66', '25', 'Nothing to do here ;)'),
(237, 225, 'ssh', '22', '25', 'Nothing to do here ;)'),
(238, 226, 'smtp', '25', '25', 'Nothing to do here ;)'),
(239, 227, 'smtp', '25', '25', 'Nothing to do here ;)'),
(240, 228, 'ssh', '22', '25', 'Nothing to do here ;)'),
(241, 229, 'sql', '25', '25', 'Nothing to do here ;)'),
(242, 230, 'ssh', '22', '25', 'Nothing to do here ;)'),
(243, 231, 'smtp', '25', '35', 'Nothing to do here ;)'),
(244, 233, 'ssh', '22', NULL, NULL),
(245, 234, 'ssh', '22', NULL, NULL),
(246, 236, 'ssh', '22', NULL, NULL),
(247, 237, 'sql', '3306', '50', 'fredie13\'s SQL server - software out of date - please activate automatic updates or manually install the latest security patches\r\n'),
(248, 238, 'ssh', '22', '50', ''),
(249, 240, 'ssh', '22', '50', ''),
(250, 239, 'ssh', '22', '0', 'Server scheduled for disassembly.'),
(251, 235, 'ssh', '29', '43', 'SSH Service for GUEST users'),
(252, 235, 'ssh', '30', '43', 'SSH Service for ADMINISTRATOR users'),
(253, 241, 'ssh', '22', '30', ''),
(254, 243, 'ssh', '22', '30', ''),
(255, 242, 'ssh', '22', '39', ''),
(256, 244, 'smtp', '3000', '0', ''),
(257, 245, 'ssh', '22', NULL, NULL),
(258, 246, 'ssh', '22', NULL, NULL),
(259, 247, 'ssh', '32', '30', 'Solar Zero  Spa   &quot;The best relaxation money can buy&quot;'),
(261, 248, 'ssh', '654', '180', 'Welcome to United Funds \r\nUSERNAME granted admin access\r\n\r\n'),
(262, 252, 'ssh', '693', '3000', 'Welcome to  Al^&amp;*^%545!!\r\nError .....'),
(263, 253, 'ssh', '99', '65', 'Welcome to Marx Digital Solutions'),
(265, 247, 'http', '22', '99999', ''),
(266, 254, 'ssh', '22', NULL, NULL),
(267, 255, 'ssh', '22', '0', 'Welcome to temp server USERNAME\r\n'),
(268, 256, 'ssh', '22', NULL, NULL),
(269, 257, 'ssh', '656', '90', 'Welcome USERNAME. \r\n\r\nRoyal Hotel Bathroom Wi-Fi accessed'),
(270, 258, 'ssh', '876', '85', ''),
(271, 258, 'smtp', '765', '35', ''),
(272, 259, 'ssh', '987', '5', ''),
(273, 259, 'sql', '432', '25', ''),
(274, 259, 'smtp', '433', '20', ''),
(275, 260, 'ssh', '22', NULL, NULL),
(276, 261, 'ssh', '22', '0', 'Welcome USERNAME  \r\nAll Systems Ready'),
(277, 261, 'smtp', '32', '0', 'Email Server for Paladium User : USERNAME\r\n\r\n****************New Mail Recieved!*******************************'),
(278, 261, 'sql', '45', '0', 'Database of USERNAME : Designation Paladium ( Rank:Recruit)'),
(279, 262, 'ssh', '765', '0', 'Welcome USERNAME  to Paladium Networks\r\nConnection Secured. \r\n...............................................................\r\nYour Paladium server is IP_1\r\nYour Host server is IP_0\r\n\r\n\r\n'),
(280, 263, 'ssh', '22', NULL, NULL),
(281, 264, 'ssh', '22', '0', 'Welcome USERNAME\r\n\r\nPaladium Terminal Online'),
(282, 264, 'smtp', '32', '0', 'Welcome USERNAME\r\n\r\n*********************************************************New Mail!**************************************************'),
(283, 265, 'ssh', '765', '80', 'USERNAME logged in'),
(284, 266, 'ssh', '876', '20', '%#*@&amp;!  Logged in from IP_4\r\n&amp;%$&amp;^* Logged in from *&amp;&amp;^*^\r\n\r\nUSERNAME logged in from IP_0'),
(285, 267, 'smtp', '64', '40', ''),
(286, 268, 'ssh', '867', '100', 'Secure_server Welcome Alpha employee\r\n'),
(287, 269, 'ssh', '987', '40', '*****Unauthorized Access!  Unauthorized Access!  Unauthorized Access!  Unauthorized Access!  Unauthorized Access! ******\r\n\r\nSending Ip address [IP_0] to IP_8:678 via email'),
(290, 271, 'ssh', '22', '87', 'Welcome USERNAME'),
(291, 271, 'sql', '676', '50', 'Welcome USERNAME'),
(292, 271, 'smtp', '987', '65', 'Welcome USERNAME'),
(293, 271, 'smtp', '678', '80', 'Welcome USERNAME'),
(294, 271, 'smtp', '677', '98', 'Welcome USERNAME'),
(295, 270, 'sql', '836', '260', 'Error authenticating User.... Sending distress signal to base64(jacob)'),
(296, 272, 'ssh', '534', '45', 'Welcome USERNAME\r\nWelcome Jacob'),
(297, 272, 'smtp', '23', '10', '************************************************All Mails Marked as read*******************************************************\r\n\r\n'),
(298, 273, 'ssh', '645', '0', 'Welcome USERNAME'),
(299, 274, 'ssh', '756', '0', 'Welcome USERNAME'),
(300, 275, 'ssh', '22', NULL, NULL),
(301, 276, 'ssh', '23', '300', 'Welcome USERNAME\r\nUser2 routed to IP_3'),
(302, 277, 'ssh', '24', '160', 'Welcome USERNAME\r\n\r\nUser1 routed to IP_4'),
(303, 278, 'ssh', '765', '300', 'Welcome USERNAME'),
(304, 278, 'smtp', '22', '30', ''),
(305, 279, 'ssh', '22', '200', 'Welcome USERNAME'),
(306, 280, 'ssh', '987', '300', 'Welcome USERNAME'),
(307, 280, 'smtp', '22', '30', ''),
(308, 281, 'ssh', '22', NULL, NULL),
(309, 282, 'ssh', '54', '60', ''),
(311, 282, 'smtp', '21', '60', ''),
(312, 283, 'ssh', '22', NULL, NULL),
(313, 284, 'ssh', '22', NULL, NULL),
(314, 284, 'sql', '22', NULL, NULL),
(315, 285, 'ssh', '22', NULL, NULL),
(316, 286, 'ssh', '45', '20', 'Pink Hat 1'),
(317, 287, 'ssh', '65', '20', 'Pink Hat 2'),
(318, 288, 'ssh', '88', '20', 'Pink Hat 3'),
(319, 289, 'ssh', '26', '20', 'Pink Hat 4'),
(320, 290, 'ssh', '48', '20', 'Pink Hat 5'),
(321, 291, 'ssh', '19', '20', 'Pink Hat 6'),
(322, 292, 'smtp', '666', '0', 'TheCure\'s Mailbox'),
(323, 292, 'ssh', '22', '0', 'Welcome to TheCure '),
(324, 293, 'ssh', '9999', '30', 'Ressources received.'),
(325, 295, 'ssh', '22', NULL, NULL),
(326, 297, 'ssh', '22', NULL, NULL),
(327, 302, 'ssh', '22', NULL, NULL),
(328, 303, 'smtp', '30', '0', 'welcome'),
(329, 304, 'smtp', '30', '0', ''),
(330, 305, 'smtp', '30', '0', ''),
(331, 306, 'smtp', '30', '0', ''),
(332, 307, 'smtp', '30', '0', ''),
(333, 308, 'smtp', '30', '0', ''),
(334, 309, 'smtp', '30', '0', ''),
(335, 310, 'smtp', '30', '0', ''),
(336, 312, 'ssh', '564', '60', ''),
(337, 313, 'http', '98', '0', ''),
(338, 313, 'ssh', '43', '60', 'WELCOME TO ROX WORLD! VISIT OUR HTTP PAGE. IF THIS IS A n00b VISITING GET LOST!!!!'),
(339, 314, 'ssh', '78', '60', 'Welcome USERNAME\r\n\r\nDeAtH TO n00bS b0z0\'s! DI#!'),
(340, 315, 'ssh', '22', NULL, NULL),
(341, 316, 'ssh', '22', '0', 'Welcome USERNAME \r\nAll Systems ready.\r\n\r\n'),
(342, 316, 'smtp', '43', '0', 'Welcome USERNAME\r\nNEW MAIL! NEW MAIL! NEW MAIL!'),
(343, 317, 'ssh', '65', '60', 'MIL-TECH SYSTEMS\r\nAUTHORIZED PERSONNEL AREA\r\n\r\nUSERNAME has logged in to localhost'),
(345, 318, 'ssh', '22', NULL, NULL),
(346, 319, 'ssh', '22', NULL, NULL),
(347, 320, 'ssh', '338', '100', ''),
(348, 321, 'ssh', '22', '100', ''),
(349, 322, 'ssh', '22', '100', ''),
(350, 323, 'ssh', '22', NULL, NULL),
(351, 324, 'ssh', '22', '100', ''),
(352, 325, 'sql', '3306', '0', ''),
(353, 326, 'ssh', '22', NULL, NULL),
(354, 327, 'ssh', '22', '0', 'Welcome USERNAME.\r\n\r\n'),
(355, 327, 'smtp', '54', '0', ''),
(356, 330, 'ssh', '5234', '60', 'USERNAME logged in'),
(357, 331, 'ssh', '963', '65', 'USERNAME logged in'),
(358, 332, 'ssh', '43', '70', 'Welcome USERNAME\r\n\r\nbase64( HAHAHAHA! if you are reading this in normal english GOOD for you the password to run the file is fairytail )\r\n\r\n&gt; error... un-authenti....\r\n&gt; Hello there USERNAME , nice job getting till here... want a hint?\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&gt; HAHAH! we arn\'t going to help you! Figure it out yourself or DIE trying!!'),
(359, 333, 'http', '22', NULL, NULL),
(360, 334, 'ssh', '654', '5000000', 'Welcome USERNAME'),
(362, 335, 'ssh', '9999', '', ''),
(363, 336, 'ssh', '22', NULL, NULL),
(364, 337, 'ssh', '120', 'RAND_N_20_150', 'Research Unit RAND_N_0_10000'),
(365, 338, 'ssh', '22', NULL, NULL),
(366, 339, 'ssh', '22', NULL, NULL),
(367, 340, 'sql', 'RAND_N_1000_300', 'RAND_N_10_100', ''),
(368, 343, 'ssh', '435', 'RAND_N_10_100', ''),
(369, 341, 'ssh', 'RAND_N_100_200', 'RAND_N_10_100', ''),
(370, 345, 'ssh', '22', NULL, NULL),
(371, 346, 'ssh', '22', '30', 'OUT OF SERVICE'),
(372, 347, 'ssh', '389', '40', 'DUE FOR MAINTENANCE'),
(373, 348, 'ssh', '352', '40', 'Welcome, administrator. Current history of transaction logs are placed in the transaction.logs file. Please make sure your connection is secure and reliable.'),
(374, 349, 'ssh', '211', '30', ''),
(375, 350, 'ssh', '22', NULL, NULL),
(376, 351, 'unknown', '3756', 'RAND_N_10_100', ''),
(378, 352, 'sql', '3306', '30', 'Glass Device Internal Database'),
(379, 353, 'sql', '3306', '30', 'Glass Tablet Internal Database'),
(380, 354, 'ssh', '23', '30', 'mY Laptop - only for business purposes\r\ndon\'t forget:\r\nto access local bank account execute bank.app ACCOUNT PASSWORD\r\nand for accounts abroad use external-zone-bank.app ACCOUNT PASSWORD'),
(381, 355, 'ssh', '22', NULL, NULL),
(382, 356, 'ssh', 'RAND_N_10_30', '', ''),
(383, 357, 'ssh', 'RAND_N_10_30', '', ''),
(384, 358, 'ssh', 'RAND_N_10_30', '', ''),
(385, 364, 'ssh', '22', '', 'Server owned by a member of your organization.'),
(386, 365, 'ssh', '22', '', 'Server owned by a member of your organization.'),
(387, 366, 'ssh', '22', '', 'Server owned by a member of your organization.'),
(388, 359, 'sql', '3305', 'RAND_N_10_70', ''),
(389, 360, 'sql', '3306', 'RAND_N_10_100', ''),
(390, 361, 'ssh', '22', 'RAND_N_10_70', ''),
(391, 362, 'ssh', '22', 'RAND_N_10_70', ''),
(392, 363, 'ssh', '22', 'RAND_N_10_70', ''),
(393, 371, 'ssh', '22', 'RAND_N_10_70', ''),
(394, 370, 'ssh', '22', 'RAND_N_10_70', ''),
(395, 369, 'ssh', '22', 'RAND_N_10_70', ''),
(396, 368, 'ssh', '22', 'RAND_N_10_70', ''),
(397, 367, 'ssh', '22', 'RAND_N_10_70', ''),
(398, 328, 'ssh', '5837', '', ''),
(399, 329, 'ssh', '328', '', 'Welcome USERNAME\r\nGood Job finding this one ... The IP is IP_6'),
(400, 372, 'ssh', '22', NULL, NULL),
(401, 373, 'ssh', '22', '0', 'Welcome USERNAME \r\n\r\nGood work getting here. \r\n\r\nLesson 1---                                     \r\n\r\nIn the jobs you do , you will RARELY have to work with your own Computer. The employers will provide you a remote Computer with necessary files. So , ALWAYS check and see WHICH computer you are supposed to copy / delete / transfer files from.\r\n\r\n!- TIP Since you are getting an easy computer , use it to bounce your signal. However, in case of extreme urgency , bouncing is BAD as it slows you down. In general , USE BOUNCING.\r\n\r\n\r\nLesson 2\r\n\r\nThis computer has an edited  Welcome Message. Most computers don\'t. To be a good  hacker , the Welcome Message ITSELF contains Clues. Also , the FILES IN THE SYSTEM are very Important. \r\n\r\n\r\nTask 1\r\n\r\nFind the file in the system which contains the next IP Address. Connect to it and figure out the puzzle. In case you are stuck , Connect to IP_3 for the Solution.\r\n\r\n'),
(402, 374, 'ssh', '8888', '20', '&gt;Authorizing user....\r\n&gt; ERROR *()@$*()@!!#$@*\r\n\r\n&gt; Password Accepted.\r\n\r\nWelcome USERNAME to Sunlight DryCleaners. To access the client Database run the file &quot; Client.exe &quot; with the Personnel Password. The Data will automatically be transferred to the remote computer used to access this Server.'),
(403, 375, 'ssh', '22', '', 'Hello there USERNAME.\r\n\r\nThis Test is SIMPLE , however if you ARE confused , no worries.\r\n\r\nSOLUTION to TASK 1\r\n\r\nCrack the Server mentioned  i.e IP_2:8888\r\nFind the file , decrypt it. READ THE FILE.  ( Use &quot;cat&quot; to read)\r\nFind the password using the hint given.  ( The password is 2011 , therefore to run the file  type &quot; run Client.exe 2011 &quot; )\r\n\r\nHope you have completed the mission. If Not , Message our customer support personnel , mage61099.'),
(404, 376, 'ssh', '22', NULL, NULL),
(405, 377, 'ssh', '22', '', 'Welcome USERNAME\r\n\r\n&gt;  Connection stable\r\n&gt;User authorised.... Folders accessible\r\n&gt; Pre defined message : Find the folder and read it for more info. '),
(406, 378, 'ssh', '3782', '35', 'Authorised Personnel ONLY !!!!'),
(407, 379, 'ssh', '6942', '34', 'Dffgfff#$\'\'//  //^^^@! 3: $^&amp;( \r\nUSERNAME ^&amp;^$## ACCES/^&amp;&amp;&amp;!#$'),
(408, 380, 'http', '22', NULL, NULL),
(409, 380, 'ssh', '818', '45', 'Good job getting here. What are you waiting for? '),
(410, 381, 'ssh', '22', NULL, NULL);

CREATE TABLE `rankings_stats` (
  `user_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `achievement_points` int(11) NOT NULL DEFAULT '0',
  `quest_points` int(11) NOT NULL DEFAULT '0',
  `skill_points` int(11) DEFAULT '0',
  `org_points` int(11) DEFAULT '0',
  `total_points` int(11) NOT NULL DEFAULT '0',
  `level_points` int(11) NOT NULL DEFAULT '0',
  `rep_extras_points` int(11) NOT NULL DEFAULT '0',
  `zone` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `servers` (
  `server_id` int(11) NOT NULL,
  `hostname` varchar(100) DEFAULT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `total_ram` int(11) NOT NULL,
  `total_cpu` int(11) NOT NULL,
  `total_hdd` int(11) NOT NULL,
  `ram_usage` int(11) NOT NULL,
  `cpu_usage` int(11) NOT NULL,
  `hdd_usage` int(11) NOT NULL,
  `ram_slots` tinyint(3) NOT NULL,
  `hdd_slots` tinyint(3) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `used_ram_slots` tinyint(3) NOT NULL,
  `used_hdd_slots` tinyint(3) NOT NULL,
  `power_usage` int(11) NOT NULL,
  `active_ram_slots` tinyint(3) NOT NULL,
  `active_hdd_slots` tinyint(3) NOT NULL,
  `ram_usage_percent` int(11) DEFAULT NULL,
  `hdd_usage_percent` int(11) DEFAULT NULL,
  `cpu_usage_percent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `server_apps` (
  `process_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `running` int(11) NOT NULL DEFAULT '0',
  `server_id` int(11) NOT NULL,
  `damage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `server_components` (
  `relation_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `damage` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_items` (
  `item_id` int(11) NOT NULL,
  `app_id` int(11) DEFAULT NULL,
  `component_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `noob` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `shop_items` (`item_id`, `app_id`, `component_id`, `price`, `noob`) VALUES
(1, NULL, 1, 100, 1),
(2, NULL, 2, 100, 1),
(3, NULL, 3, 100, 1),
(4, NULL, 4, 100, 1),
(5, NULL, 5, 100, 1),
(6, NULL, 6, 100, 1),
(7, NULL, 7, 200, NULL),
(8, NULL, 8, 200, NULL),
(9, NULL, 9, 200, NULL),
(10, NULL, 10, 200, NULL),
(11, NULL, 11, 200, NULL),
(12, NULL, 12, 200, NULL),
(13, 1, NULL, 30, 1),
(14, 2, NULL, 30, 1),
(15, 3, NULL, 200, NULL),
(16, NULL, 13, 400, NULL),
(17, NULL, 14, 400, NULL),
(18, NULL, 15, 400, NULL),
(19, NULL, 16, 400, NULL),
(20, NULL, 17, 400, NULL),
(21, NULL, 18, 400, NULL),
(22, 4, NULL, 100, NULL),
(23, 5, NULL, 100, NULL),
(24, 6, NULL, 111, NULL),
(25, 7, NULL, 102, NULL),
(26, 8, NULL, 110, NULL),
(27, 9, NULL, 6666, NULL);

CREATE TABLE `shop_logs` (
  `shop_log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `app_id` int(11) DEFAULT NULL,
  `component_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `skills` (
  `skill` int(2) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `exp` int(11) DEFAULT NULL,
  `expNext` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `storage` (
  `storage_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `component_id` int(11) NOT NULL,
  `damage` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `storage` (`storage_id`, `user_id`, `component_id`, `damage`) VALUES
(4, 18148, 5, 0),
(5, 18148, 6, 0);

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `dataid` int(11) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `totalSeconds` int(11) DEFAULT NULL,
  `data` text CHARACTER SET utf8,
  `party_id` int(11) DEFAULT NULL,
  `instance_id` int(11) DEFAULT NULL,
  `paused` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `task_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `dataid` int(11) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `totalSeconds` int(11) DEFAULT NULL,
  `data` text,
  `log_created` int(11) DEFAULT NULL,
  `party_id` int(11) DEFAULT NULL,
  `instance_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `gavatar` varchar(150) NOT NULL,
  `money` double NOT NULL DEFAULT '1000',
  `organization` int(11) DEFAULT NULL,
  `rank` int(11) NOT NULL DEFAULT '-1',
  `zrank` int(11) NOT NULL DEFAULT '-1',
  `zone` tinyint(1) DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `energy` int(11) UNSIGNED NOT NULL DEFAULT '100',
  `maxEnergy` int(11) UNSIGNED NOT NULL DEFAULT '100',
  `exp` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `expNext` int(11) UNSIGNED NOT NULL DEFAULT '135',
  `level` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `org_group` int(11) DEFAULT NULL,
  `tasks` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `rep` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `blogs` tinyint(2) NOT NULL DEFAULT '0',
  `rewardsToReceive` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `skillPoints` smallint(11) NOT NULL DEFAULT '5',
  `alphaCoins` int(11) NOT NULL DEFAULT '10000',
  `in_party` int(11) NOT NULL DEFAULT '0',
  `aiVoice` tinyint(1) NOT NULL DEFAULT '1',
  `server` int(11) DEFAULT NULL,
  `dataPoints` float UNSIGNED NOT NULL DEFAULT '10',
  `lastActive` int(11) DEFAULT NULL,
  `lastResUpdate` int(11) DEFAULT NULL,
  `lifelongDataPoints` bigint(20) NOT NULL DEFAULT '10',
  `dataPointsPerHour` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tutorial` int(10) UNSIGNED NOT NULL DEFAULT '10',
  `main_node` varchar(20) DEFAULT NULL,
  `createdAt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users_reputation` (
  `sender` int(11) DEFAULT NULL,
  `receiver` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_achievements` (
  `user_achievement_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `times` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_bank` (
  `account_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_bans` (
  `ban_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `by_user_id` int(11) DEFAULT NULL,
  `expires` int(11) DEFAULT NULL,
  `reason` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_credentials` (
  `uid` int(11) NOT NULL,
  `password` varchar(1024) DEFAULT NULL,
  `pin` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `group_id` tinyint(2) DEFAULT NULL,
  `banned` int(11) DEFAULT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  `email_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `login_days_in_row` int(11) NOT NULL DEFAULT '0',
  `youtube` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `user_demographics` (
  `demographic_id` int(11) NOT NULL,
  `provider` varchar(100) DEFAULT NULL,
  `birthday` varchar(100) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `age` float DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `provider_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_email_confirmation` (
  `confirm_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `hash_code` varchar(300) NOT NULL,
  `user_id` int(11) NOT NULL,
  `used` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_job` (
  `user_id` int(11) NOT NULL,
  `exp` int(11) DEFAULT '0',
  `expNext` int(11) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_job_logs` (
  `log_id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quest_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_premium` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `missionNotepad` int(11) DEFAULT NULL,
  `partyChat` int(11) DEFAULT NULL,
  `ai` int(11) DEFAULT NULL,
  `attackSimulator` int(11) DEFAULT NULL,
  `removeAds` int(11) DEFAULT NULL,
  `serversHostname` int(11) DEFAULT NULL,
  `consoleHistory` int(11) DEFAULT NULL,
  `questManager` int(11) DEFAULT NULL,
  `extraStorage1` int(11) DEFAULT NULL,
  `extraTime` int(11) DEFAULT NULL,
  `extraDataPoints15` int(11) DEFAULT NULL,
  `recoveryRateDouble` int(11) DEFAULT NULL,
  `notes` int(11) DEFAULT NULL,
  `bankLimit1` int(11) DEFAULT NULL,
  `bankLimit2` int(11) DEFAULT NULL,
  `missionsPack1` int(11) DEFAULT NULL,
  `base64` int(11) DEFAULT NULL,
  `maxTasks1` int(11) DEFAULT NULL,
  `maxTasks2` int(11) DEFAULT NULL,
  `seenConv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `user_referrals` (
  `referral_id` int(11) NOT NULL,
  `master_user_id` int(11) DEFAULT NULL,
  `slave_user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_reset_password` (
  `reset_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash_code` varchar(300) NOT NULL,
  `used` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_rewards` (
  `reward_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `received` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `money` int(11) DEFAULT '0',
  `exp` int(11) DEFAULT '0',
  `skills` text,
  `title` varchar(200) DEFAULT NULL,
  `task` tinyint(2) DEFAULT NULL,
  `achievements` text,
  `skillPoints` int(11) DEFAULT NULL,
  `jobExp` int(11) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `referral_id` int(11) DEFAULT NULL,
  `alphaCoins` int(11) DEFAULT NULL,
  `dataPoints` float DEFAULT NULL,
  `components` text,
  `applications` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_session` (
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `session` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `tablet` tinyint(1) DEFAULT NULL,
  `mobile` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `user_simulations` (
  `simulation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `simulationData` text,
  `created` int(11) DEFAULT NULL,
  `message` text,
  `report` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_social_connect` (
  `id` int(11) NOT NULL,
  `facebook` varchar(50) DEFAULT NULL,
  `facebookName` varchar(300) DEFAULT NULL,
  `google` varchar(50) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `googleName` varchar(300) DEFAULT NULL,
  `googleTokens` text NOT NULL,
  `kongregate` int(11) DEFAULT NULL,
  `kongregateName` varchar(300) DEFAULT NULL,
  `twitter` varchar(50) DEFAULT NULL,
  `twitterName` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_support` (
  `inquiry_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `content` text,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_time_delusion` (
  `delusion_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `instance_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_train_logs` (
  `log_id` int(11) NOT NULL,
  `created` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `success` int(11) DEFAULT NULL,
  `reward_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_transit_logs` (
  `transit_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fromZone` int(11) DEFAULT NULL,
  `fromNode` int(11) DEFAULT NULL,
  `toNode` int(11) DEFAULT NULL,
  `toZone` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zones` (
  `id` int(11) UNSIGNED NOT NULL,
  `nrm` int(11) DEFAULT '0',
  `president` int(11) DEFAULT NULL,
  `data` text,
  `status` int(11) DEFAULT NULL,
  `rank` int(11) NOT NULL,
  `next_elections` int(11) NOT NULL,
  `market_tax` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `hack` int(11) NOT NULL,
  `vault` double NOT NULL,
  `fmarket_tax` int(11) NOT NULL,
  `min_defence` int(11) NOT NULL,
  `min_finance` int(11) NOT NULL,
  `avg_level` float NOT NULL DEFAULT '0',
  `points` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `zones` (`id`, `nrm`, `president`, `data`, `status`, `rank`, `next_elections`, `market_tax`, `defense`, `hack`, `vault`, `fmarket_tax`, `min_defence`, `min_finance`) VALUES (1,0,NULL,NULL,NULL,0,0,1,0,0,436,2,588,836),(2,0,NULL,NULL,NULL,0,0,1,0,0,23.05,2,0,0),(3,0,NULL,NULL,NULL,0,0,1,0,0,21666.12,2,0,0),(4,0,NULL,NULL,NULL,0,0,1,0,0,22.53,2,0,0),(5,0,NULL,NULL,NULL,0,0,1,0,0,31.8,2,0,0),(6,0,NULL,NULL,NULL,0,0,1,0,0,41.8,2,0,0);

CREATE TABLE `zones_wars` (
  `id` int(11) UNSIGNED NOT NULL,
  `zs` int(11) DEFAULT NULL,
  `zr` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `start` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `zs_participants` int(11) DEFAULT '0',
  `zr_participants` int(11) DEFAULT '0',
  `data` text,
  `zs_points` int(11) NOT NULL DEFAULT '0',
  `zr_points` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `zones_wars_fights` (
  `id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `wid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `zone` int(11) DEFAULT NULL,
  `dmg` int(11) NOT NULL DEFAULT '0',
  `date` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `zones_wars_reqs` (
  `id` int(11) UNSIGNED NOT NULL,
  `zs` int(11) DEFAULT NULL,
  `zr` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `reason` varchar(1000) DEFAULT NULL,
  `date` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `zone_candidates` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `zone` int(11) NOT NULL,
  `letter` varchar(500) NOT NULL,
  `submission_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `zone_candidate_votes` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `submission_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `zone_grid_clusters` (
  `cluster` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `last_name_change` int(11) DEFAULT NULL,
  `zone_id` int(11) NOT NULL,
  `zone_grid_clusters_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `zone_grid_cluster_nodes` (
  `node` int(11) NOT NULL,
  `cluster` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` int(11) NOT NULL,
  `zone_grid_cluster_nodes_id` int(11) NOT NULL,
  `floatingDataPoints` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



ALTER TABLE `abilities`
  ADD KEY `userAbilities_idx` (`user_id`);

ALTER TABLE `achievements`
  ADD PRIMARY KEY (`achievement_id`),
  ADD UNIQUE KEY `achievemnt_id_UNIQUE` (`achievement_id`);

ALTER TABLE `alpha_coins_logs`
  ADD PRIMARY KEY (`log_id`);

ALTER TABLE `alpha_coins_shop`
  ADD PRIMARY KEY (`item_id`,`shopOrder`);

ALTER TABLE `alpha_coin_transactions`
  ADD PRIMARY KEY (`transaction_id`);

ALTER TABLE `applications`
  ADD PRIMARY KEY (`app_id`);

ALTER TABLE `attacks_inprogress`
  ADD PRIMARY KEY (`attack_id`),
  ADD UNIQUE KEY `attack_id_UNIQUE` (`attack_id`);

ALTER TABLE `attack_logs`
  ADD PRIMARY KEY (`attack_log_id`);

ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`);

ALTER TABLE `blog_articles`
  ADD PRIMARY KEY (`article_id`);

ALTER TABLE `blog_article_votes`
  ADD PRIMARY KEY (`vote_id`);

ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `blogArticleComments_idx` (`article_id`);

ALTER TABLE `blog_subscriptions`
  ADD PRIMARY KEY (`subscription_id`);

ALTER TABLE `components`
  ADD PRIMARY KEY (`component_id`);

ALTER TABLE `conversations`
  ADD PRIMARY KEY (`message_id`);

ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`);

ALTER TABLE `coupon_logs`
  ADD PRIMARY KEY (`log_id`);

ALTER TABLE `data_points_spin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `data_points_spin_logs`
  ADD PRIMARY KEY (`log_id`);

ALTER TABLE `debug_404_errors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`shortcut`),
  ADD UNIQUE KEY `shortcut` (`shortcut`);

ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`cat_id`);

ALTER TABLE `faq_questions`
  ADD PRIMARY KEY (`shortname`);

ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sectionPosts_idx` (`fid`),
  ADD KEY `userPosts_idx` (`user_id`);

ALTER TABLE `forum_sections`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`request_id`);

ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

ALTER TABLE `hackdown_arena`
  ADD PRIMARY KEY (`arena_id`);

ALTER TABLE `hackdown_logs`
  ADD PRIMARY KEY (`log_id`);

ALTER TABLE `hackdown_rankings_organizations`
  ADD PRIMARY KEY (`ranking_id`);

ALTER TABLE `hackdown_rankings_users`
  ADD PRIMARY KEY (`ranking_id`);

ALTER TABLE `hackdown_rankings_zones`
  ADD PRIMARY KEY (`ranking_id`);

ALTER TABLE `hacker_quotes`
  ADD PRIMARY KEY (`quote_id`);

ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`);

ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `organization_members_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `organizationMemberLogs_idx` (`org_id`),
  ADD KEY `userOrgMemberLogs_idx` (`user_id`);

ALTER TABLE `org_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orgApplications_idx` (`org_id`);

ALTER TABLE `org_ended_wars`
  ADD PRIMARY KEY (`war_id`);

ALTER TABLE `org_forum_posts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `org_forum_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orgForums_idx` (`org`);

ALTER TABLE `org_hacking_points_logs`
  ADD PRIMARY KEY (`log_id`);

ALTER TABLE `org_ranks`
  ADD PRIMARY KEY (`rank_id`);

ALTER TABLE `org_wars`
  ADD PRIMARY KEY (`war_id`);

ALTER TABLE `org_war_requests`
  ADD PRIMARY KEY (`request_id`);

ALTER TABLE `org_zone_beginners`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `parties`
  ADD PRIMARY KEY (`party_id`);

ALTER TABLE `party_invitations`
  ADD PRIMARY KEY (`invitation_id`),
  ADD KEY `partyInvitations_idx` (`party_id`);

ALTER TABLE `party_quest_instances`
  ADD PRIMARY KEY (`instance_id`),
  ADD KEY `partyQuestInstance_idx` (`party_id`);

ALTER TABLE `quests`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `quests_feedback`
  ADD PRIMARY KEY (`feedback_id`);

ALTER TABLE `quests_user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `quest_console_history`
  ADD PRIMARY KEY (`entry_id`);

ALTER TABLE `quest_files`
  ADD PRIMARY KEY (`file_id`);

ALTER TABLE `quest_groups`
  ADD PRIMARY KEY (`qgroup_id`);

ALTER TABLE `quest_hosts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `quest_notepad`
  ADD PRIMARY KEY (`notepad_id`);

ALTER TABLE `quest_objectives`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `quest_services`
  ADD PRIMARY KEY (`service_id`);

ALTER TABLE `rankings_stats`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

ALTER TABLE `servers`
  ADD PRIMARY KEY (`server_id`,`total_ram`,`total_cpu`,`total_hdd`,`ram_usage`,`hdd_usage`,`cpu_usage`,`ram_slots`,`hdd_slots`,`used_hdd_slots`,`used_ram_slots`,`disabled`,`power_usage`,`active_ram_slots`,`active_hdd_slots`);

ALTER TABLE `server_apps`
  ADD PRIMARY KEY (`process_id`);

ALTER TABLE `server_components`
  ADD PRIMARY KEY (`relation_id`);

ALTER TABLE `shop_items`
  ADD PRIMARY KEY (`item_id`);

ALTER TABLE `shop_logs`
  ADD PRIMARY KEY (`shop_log_id`),
  ADD KEY `userSkills_idx` (`user_id`);

ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `storage`
  ADD PRIMARY KEY (`storage_id`);

ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partyTasks_idx` (`party_id`);

ALTER TABLE `task_logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `user_achievements`
  ADD PRIMARY KEY (`user_achievement_id`);

ALTER TABLE `user_bank`
  ADD PRIMARY KEY (`account_id`);

ALTER TABLE `user_bans`
  ADD PRIMARY KEY (`ban_id`);

ALTER TABLE `user_credentials`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uid` (`uid`);

ALTER TABLE `user_demographics`
  ADD PRIMARY KEY (`demographic_id`);

ALTER TABLE `user_email_confirmation`
  ADD PRIMARY KEY (`confirm_id`);

ALTER TABLE `user_job`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `user_job_logs`
  ADD PRIMARY KEY (`log_id`);

ALTER TABLE `user_premium`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_referrals`
  ADD PRIMARY KEY (`referral_id`);

ALTER TABLE `user_reset_password`
  ADD PRIMARY KEY (`reset_id`);

ALTER TABLE `user_rewards`
  ADD PRIMARY KEY (`reward_id`);

ALTER TABLE `user_session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `user_simulations`
  ADD PRIMARY KEY (`simulation_id`);

ALTER TABLE `user_social_connect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userSocialConnect_idx` (`uid`);

ALTER TABLE `user_support`
  ADD PRIMARY KEY (`inquiry_id`);

ALTER TABLE `user_time_delusion`
  ADD PRIMARY KEY (`delusion_id`);

ALTER TABLE `user_train_logs`
  ADD PRIMARY KEY (`log_id`);

ALTER TABLE `user_transit_logs`
  ADD PRIMARY KEY (`transit_id`);

ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `zones_wars`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `zones_wars_fights`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `zones_wars_reqs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `zone_grid_clusters`
  ADD PRIMARY KEY (`zone_grid_clusters_id`);

ALTER TABLE `zone_grid_cluster_nodes`
  ADD PRIMARY KEY (`zone_grid_cluster_nodes_id`);

ALTER TABLE `abilities`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `achievements`
  MODIFY `achievement_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `alpha_coins_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `alpha_coins_shop`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `alpha_coin_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `applications`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `attacks_inprogress`
  MODIFY `attack_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `attack_logs`
  MODIFY `attack_log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `blog_articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `blog_article_votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `blog_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `blog_subscriptions`
  MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `components`
  MODIFY `component_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `conversations`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `coupons`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `coupon_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `data_points_spin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `data_points_spin_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `debug_404_errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `faq_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `forum_posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `forum_sections`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `friendships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `friend_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `groups`
  MODIFY `group_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `hackdown_arena`
  MODIFY `arena_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hackdown_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hackdown_rankings_organizations`
  MODIFY `ranking_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hackdown_rankings_users`
  MODIFY `ranking_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hackdown_rankings_zones`
  MODIFY `ranking_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hacker_quotes`
  MODIFY `quote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=703;

ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `organization_members_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `org_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `org_ended_wars`
  MODIFY `war_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `org_forum_posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `org_forum_sections`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `org_hacking_points_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `org_ranks`
  MODIFY `rank_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `org_wars`
  MODIFY `war_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `org_war_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `org_zone_beginners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `parties`
  MODIFY `party_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `party_invitations`
  MODIFY `invitation_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `party_quest_instances`
  MODIFY `instance_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `quests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

ALTER TABLE `quests_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `quests_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `quest_console_history`
  MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `quest_files`
  MODIFY `file_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=437;

ALTER TABLE `quest_groups`
  MODIFY `qgroup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

ALTER TABLE `quest_hosts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=382;

ALTER TABLE `quest_notepad`
  MODIFY `notepad_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `quest_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=681;

ALTER TABLE `quest_services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=411;

ALTER TABLE `servers`
  MODIFY `server_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `server_apps`
  MODIFY `process_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `server_components`
  MODIFY `relation_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `shop_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

ALTER TABLE `shop_logs`
  MODIFY `shop_log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `storage`
  MODIFY `storage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `task_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18150;

ALTER TABLE `user_achievements`
  MODIFY `user_achievement_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_bank`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_bans`
  MODIFY `ban_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_demographics`
  MODIFY `demographic_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_email_confirmation`
  MODIFY `confirm_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_job`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18149;

ALTER TABLE `user_job_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_premium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `user_referrals`
  MODIFY `referral_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_reset_password`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_rewards`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_simulations`
  MODIFY `simulation_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_social_connect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_support`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_time_delusion`
  MODIFY `delusion_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_train_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_transit_logs`
  MODIFY `transit_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `zones`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `zones_wars`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `zones_wars_reqs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `zone_grid_clusters`
  MODIFY `zone_grid_clusters_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6007;

ALTER TABLE `zone_grid_cluster_nodes`
  MODIFY `zone_grid_cluster_nodes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14929;


ALTER TABLE `forum_posts`
  ADD CONSTRAINT `sectionPosts` FOREIGN KEY (`fid`) REFERENCES `forum_sections` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `userPosts` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `organization_members_logs`
  ADD CONSTRAINT `organizationMemberLogs` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `userOrgMemberLogs` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `org_applications`
  ADD CONSTRAINT `orgApplications` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `org_forum_sections`
  ADD CONSTRAINT `orgForums` FOREIGN KEY (`org`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `party_invitations`
  ADD CONSTRAINT `partyInvitations` FOREIGN KEY (`party_id`) REFERENCES `parties` (`party_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `party_quest_instances`
  ADD CONSTRAINT `partyQuestInstances` FOREIGN KEY (`party_id`) REFERENCES `parties` (`party_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `shop_logs`
  ADD CONSTRAINT `userSkills` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `tasks`
  ADD CONSTRAINT `partyTasks` FOREIGN KEY (`party_id`) REFERENCES `parties` (`party_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `user_credentials`
  ADD CONSTRAINT `userCredentials` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `user_social_connect`
  ADD CONSTRAINT `userSocialConnect` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
