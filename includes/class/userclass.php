<?php
class UserClass extends Alpha
{

    function __construct()
    {
        parent::__construct();
    }
    function canDoTask()
    {
        $userLimit = $this->config["max_tasks"];
        $userLimit = $_SESSION['premium']['maxTasks1'] ? 5 : $userLimit;
        $userLimit = $_SESSION['premium']['maxTasks2'] ? 10 : $userLimit;

        if ($this->user["tasks"] >= $userLimit)
        {
            add_alert("The Cardinal System has your tasks limit set to " . $userLimit . " and you've already got that many running.  <a href='" . URL . "alpha_coins/'>Would you like to remove this limit?</a>");
            return false;
        }
        return true;
    }

    function areUsersFriends($user1, $user2)
    {
        $check = $this
            ->db
            ->where("(user1id = ? and user2id =?) or (user1id = ? and user2id = ?)", array(
            $user1,
            $user2,
            $user2,
            $user1
        ))->getOne("friendships", "id");
        return $check['id'] ? $check['id'] : false;
    }
    function get_friends($id, $limit = '')
    {

        $friends = $this
            ->db
            ->rawQuery('select uf.id,hu.username,hu.zone, hu.lastActive from friendships as uf
                        inner join users  hu
                        on (hu.id=uf.user2id and user1id= ?)
                        or (hu.id=uf.user1id and user2id= ?)
                        order by lastActive desc, username desc ' . $limit, array(
            $id,
            $id
        ));

        foreach ($friends as & $friend)
        {
            if ($friend['lastActive'] >= time() - 10 * 60) $friend['online'] = true;

        } //$friends as &$friend
        return $friends;
    }

    function update_user($update, $user, $refresh = true)
    {
        $this
            ->db
            ->rawQuery('update users set ' . $update . ' where id = ? limit 1', array(
            $user
        ));

    }

    function updatePlayer($updateData, $user_id = false)
    {
        if (!$user_id) $user_id = $this->user['id'];
        if (!$user_id) return false;

        $this
            ->db
            ->where('id', $user_id)->update('users', $updateData, 1);

        if ($user_id == $this->user['id']) $this->user = array_merge($this->user, $updateData);
    }

    function getJob($user_id, $timeBetweenJobs = false)
    {
        $job = $this
            ->db
            ->where('user_id', $user_id)->getOne('user_job uj', 'uj.*' . ($timeBetweenJobs ? ',
					(select created from user_job_logs ujl where ujl.user_id = uj.user_id and created > ' . (time() - $timeBetweenJobs) . ' order by created desc limit 1) last_work' : ''));

        if (!$job['user_id'])
        {
            $insertData = array(
                'expNext' => $this->jobLevelExperience(2) ,
                'user_id' => $user_id
            );
            $this
                ->db
                ->insert('user_job', $insertData);

            $job = $this
                ->db
                ->where('user_id', $user_id)->getOne('user_job');
        } //!$job['user_id']
        return $job;
    }

    function addEnergy($energy)
    {
        $this->user['energy'] += $energy;
        if ($this->user['energy'] > $this->user['maxEnergy']) $this->user['energy'] = $this->user['maxEnergy'];

        $this
            ->db
            ->where('id', $this->user['id'])
            ->update('users', array(
            'energy' => $this->user['energy']
        ));
    }
    function addJobExperience($user_id, $experience)
    {
        $job = $this->getJob($user_id);
        if ($job['user_id'])
        {
            $job['exp'] += $experience;
            if ($job['exp'] >= $job['expNext'])
            {
                $job['exp'] = 0;
                $job['level']++;
                $job['expNext'] = $this->jobLevelExperience($job['level'] + 1);
            } //$job['exp'] >= $job['expNext']
            $this
                ->db
                ->where('user_id', $user_id)->update('user_job', $job);

        } // if
        
    }

    function jobLevelExperience($lvl)
    {
        return ($lvl - 1) * 50 + 100;
    }
    function add_exp($exp)
    {

        $this->user['exp'] += $exp;
        while ($this->user['exp'] >= $this->user['expNext'])
        {
            $this->user['level']++;
            $this->user['exp'] = $this->user['exp'] - $this->user['expNext'];
            $this->user['expNext'] = $this->levelExperience($this->user['level'] + 1);
            $this->user['energy'] = $this->user['maxEnergy'] = $this->levelEnergy($this->user['level']);

            $reward = $this
                ->db
                ->where('level_id', $this->user['level'])
                ->getOne('level_rewards');
            if ($reward['level_id'])
            {

                if ($reward['achievement_id']) $levelReward['achievements'][] = $reward['achievement_id'];

                $levelReward['money'] = $reward['money'];
                $levelReward['skillPoints'] = $reward['skillPoints'];
                $levelUp = true;
                $this->addReward($this->user['id'], $levelReward, 'Level up ' . $this->user['level']);
            } //$reward['level_id']
            $this->rewardUserReferral();
        } //$this->user['exp'] >= $this->user['expNext']
        $updateData = array(
            'exp' => $this->user['exp'],
            'expNext' => $this->user['expNext'],
            'level' => $this->user['level'],
            'maxEnergy' => $this->user['maxEnergy'],
            'energy' => $this->user['energy']
        );
        $this->updatePlayer($updateData);
    }

    static function levelExperience($lvl)
    {
        $exp = 0;
        for ($j = 1;$j <= $lvl - 1;$j++)
        {

            $exp += round(30 * pow(2, 1 + $j / 20));

        } //$j = 1; $j <= $lvl - 1; $j++
        return round($exp);

    }

    static function levelEnergy($lvl)
    {
        return ($lvl - 1) * 10 + 100;
    }

    public static function computeSkillExperience($skill, $level)
    {
        global $theskills;
        return round(($level + 1) * 5 * (isset($theskills[$skill]['expRate']) ? $theskills[$skill]['expRate'] : 1));
    } //
    function addSkillExperience($uid, $skill, $exp)
    {
        $skillData = $this->getUserSkill($uid, $skill);

        $skillData['exp'] += $exp;

        while ($skillData['exp'] >= $skillData['expNext'])
        {
            $skillData['exp'] = $skillData['exp'] - $skillData['expNext'];
            $skillData['level']++;
            $skillData['expNext'] = $this->computeSkillExperience($skill, $skillData['level']);

        } // while upgrade level
        $this
            ->db
            ->where('uid', $uid)->where('skill', $skill)->update('skills', $skillData);

    } // addSkillExperience
    function getUserSkill($uid, $skill)
    {
        return $this->getUserSkills($uid, $skill);
    }

    function getUserSkills($uid, $skillsToFetch = false)
    {
        $skills = is_array($skillsToFetch) ? $skillsToFetch : array(
            $skillsToFetch
        );

        $skillsString = implode(',', $skills);
        $this
            ->db
            ->where('skill in (' . $skillsString . ')');

        $skillsData = $this
            ->db
            ->where('uid', $uid)->get('skills', is_array($skills) ? count($skills) : 1, 'exp, expNext, level, skill');

        $foundSkillIds = array();
        foreach ($skillsData as $skillData)
        {
            $foundSkillIds[] = $skillData['skill'];
            unset($skills[array_search($skillData['skill'], $skills) ]);
        }

        foreach ($skills as $skill)
        {
            $skillData = array(
                'uid' => $uid,
                'skill' => $skill,
                'exp' => 0,
                'level' => 1,
                'expNext' => $this->computeSkillExperience($skill, 2)
            );
            $skillsData[] = $skillData;
            $this
                ->db
                ->insert('skills', $skillData);
        }

        if (!is_array($skillsToFetch)) return $skillsData[0];

        $userSkills = array();
        foreach ($skillsData as $skillData) $userSkills[$skillData['skill']] = $skillData;

        return $userSkills;

    } // getUserSkills
    function getUserAbility($user_id, $ability_id)
    {
        $abilityData = $this->getUserAbilities($user_id, array(
            $ability_id
        ));
        return $abilityData[$ability_id];
    }

    function getUserAbilities($user_id, $abilitiesArray)
    {
        if (!count($abilitiesArray) || !is_array($abilitiesArray)) return false;

        $abilities = $this
            ->db
            ->where('user_id', $user_id)->where('ability_id in (' . implode(',', $abilitiesArray) . ')')->get('abilities', null, ' ability_id, level');;

        foreach ($abilities as $ability)
        {
            $return[$ability['ability_id']] = $ability;
            unset($abilitiesArray[array_search($ability['ability_id'], $abilitiesArray) ]);
        }

        foreach ($abilitiesArray as $ability)
        {
            $abilityData = array(
                'user_id' => $user_id,
                'ability_id' => $ability
            );
            $this
                ->db
                ->insert('abilities', $abilityData);
            $return[$ability] = array();
        }
        return $return;
    } // getUserAbilities
    function addAbilityLevel($user_id, $ability_id, $addLevel)
    {
        $abilityData = $this->getUserAbility($user_id, $ability_id);

        $abilityData['level'] += $addLevel;
        $this
            ->db
            ->where('user_id', $user_id)->where('ability_id', $ability_id)->update('abilities', $abilityData);

    }

    function send_msg($sid, $rid, $msg, $title = 'Message', $type = 1)
    {
        $parser = new \JBBCode\Parser();
        $parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
        $parser->parse($msg);
        $msg = $parser->getAsHtml();

        if ($sid == - 2 && $type == 1)
        {
            $type = 4;
            $title = "Organization notifications";
        }
        if ($sid == - 1 && $type == 1)
        {
            $type = 6;
            $title = "Cardinal notifications";
        }

        $message = array(
            'created' => time() ,
            'sender_user_id' => $sid,
            'title' => htmlentities($title) ,
            'message' => $msg,
            'last_reply_date' => time() ,
            'last_reply_by_user_id' => $sid,
            'replies' => 1,
            'type' => $type,
        );

        $reply = array(
            'message' => $msg,
            'sender_user_id' => $sid,
            'created' => time() ,
        );

        if (!is_array($rid)) $rid = array(
            $rid
        );

        $msg_id = false;
        foreach ($rid as $r)
        {
            if ($sid < 0)
            {
                $checkIfConvExists = $this
                    ->db
                    ->where('receiver_user_id', $r)->where('parent_message_id is null')
                    ->where('sender_user_id', $sid)->getOne('conversations', 'message_id');
                if ($checkIfConvExists['message_id'])
                {

                    $reply['parent_message_id'] = $checkIfConvExists['message_id'];

                    $reply_id = $this
                        ->db
                        ->insert('conversations', $reply);

                    $this
                        ->db
                        ->rawQuery("update conversations
                         set replies = replies + 1, last_reply_by_user_id = ?, last_reply_date = ?, last_reply_seen = 0
                   where message_id = ? limit 1", array(
                        $sid,
                        time() ,
                        $checkIfConvExists['message_id']
                    ));

                    continue;
                }
            }

            $message['receiver_user_id'] = $r;
            $msg_id = $this
                ->db
                ->insert('conversations', $message);
        }

        return $msg_id;

    }

    function addReward($user_id, $insertData, $title)
    {
        if (!$user_id) return;
        $user = $this
            ->db
            ->where('id', $user_id)->getOne('users', 'rewardsToReceive');
        $this
            ->db
            ->where('id', $user_id)->update('users', array(
            'rewardsToReceive' => $user['rewardsToReceive'] + 1
        ));
        $insertData['user_id'] = $user_id;
        $insertData['created'] = time();
        $insertData['title'] = $title;
        $insertData['skills'] = is_array($insertData['skills']) ? serialize($insertData['skills']) : null;
        $insertData['achievements'] = is_array($insertData['achievements']) ? serialize($insertData['achievements']) : null;
        $insertData['applications'] = is_array($insertData['applications']) ? serialize($insertData['applications']) : null;
        $insertData['components'] = is_array($insertData['components']) ? serialize($insertData['components']) : null;

        $reward_id = $this
            ->db
            ->insert('user_rewards', $insertData);

        return $reward_id;
    }

    function giveAchievement($uid, $aid, $count = 1)
    {
        $achievement = $this
            ->db
            ->where('achievement_id', $aid)->getOne('achievements');

        if ($achievement['achievement_id'])
        {
            $userAchievement = $this
                ->db
                ->where('achievement_id', $achievement['achievement_id'])->where('user_id', $uid)->getOne('user_achievements');
            // has user received achievement before?
            if ($userAchievement['user_achievement_id'])
            {

                $update = array(
                    'times' => $userAchievement['times'] + $count
                );
                $this
                    ->db
                    ->where('achievement_id', $achievement['achievement_id'])->where('user_id', $uid)->update('user_achievements', $update);

            } //$userAchievement['user_achievement_id']
            else
            {
                $userAchievement = array(
                    'achievement_id' => $achievement['achievement_id'],
                    'user_id' => $uid,
                    'times' => $count
                );

                $this
                    ->db
                    ->insert('user_achievements', $userAchievement);

            }

            return true;

        } // does achievement exist?
        
    } // giveAchievement
    

    function getPremiumData($uid = false)
    {
        if (!$uid) $uid = $this->user['id'];

        $premium = $this
            ->db
            ->where('user_id', $uid)->getOne('user_premium');
        if (!$premium['id']) $premium['id'] = $this
            ->db
            ->insert('user_premium', array(
            'user_id' => $uid
        ));

        return $premium;
    }

    function getUserStorage($user_id = false, $in = array() , $onlyDamaged = false)
    {
        if (!$user_id) $user_id = $this->user['id'];
        $storage = $this
            ->db
            ->rawQuery('select c.*, s.* from storage s
	                          left outer join components c on c.component_id = s.component_id
							  where s.user_id = ? ' . (count($in) ? ' and s.storage_id in (' . implode(',', $in) . ')' : '') . ($onlyDamaged ? ' and s.damage != 0 and s.locked is null' : '') . ' order by c.type asc', array(
            $user_id
        ));

        return $storage;
    }

    function getUserStorageItem($storage_id)
    {
        $component = $this
            ->db
            ->join('components c', 'c.component_id = s.component_id', 'left outer')
            ->where('storage_id', $storage_id)->getOne('storage s');

        return $component['component_id'] ? $component : false;
    }
    function rewardUserReferral()
    {
        $referral = $this
            ->db
            ->where('slave_user_id', $this->user['id'])
            ->getOne('user_referrals', 'referral_id, master_user_id');
        if ($referral['referral_id']) if ($this->user['level'] == 10)
        {
            $this
                ->db
                ->where('referral_id', $referral['referral_id'])->update('user_referrals', array(
                'status' => 2
            ) , 1);
            $reward = array(
                'alphaCoins' => 5,
                'referral_id' => $referral['referral_id']
            );

            $this->addReward($this->user['id'], $reward, 'A referral has reached Level 10');

            // check if another batch of 5 referrals have achieved level 10
            $referralsBatch = $this
                ->db
                ->where('master_user_id', $referral['master_user_id'])->where('status', 2)
                ->getOne('user_referrals', 'count(*) nrr');
            if ($referralsBatch['nrr'] == 5)
            {
                $reward = array(
                    'alphaCoins' => 5,
                    'referral_id' => $referral['referral_id']
                );
                $this
                    ->db
                    ->where('master_user_id', $referral['master_user_id'])->where('status', 2)
                    ->update('user_referrals', array(
                    'status' => 3
                ));

                $this->addReward($referral['master_user_id'], $reward, 'A referrals batch of 5 have reached Level 10');

            }
        }
    }

    function alphaCoinsPurchase($user_id, $alphaCoins)
    {
        /*
        on first purchase 25% bonus
        */
        $u = $this
            ->db
            ->where('uid', $user_id)->getOne('user_credentials', "email");

        $check = $this
            ->db
            ->where('user_id', $user_id)->getOne('alpha_coin_transactions', 'transaction_id');
        if (!$check['transaction_id']) $alphaCoins += floor(($alphaCoins / 100) * 25);

        $alphaCoins = intval($alphaCoins);
        $this
            ->db
            ->rawQuery('update users set alphaCoins = alphaCoins + ? where id = ? limit 1', array(
            $alphaCoins,
            $user_id
        ));

        $replace = array(
            "ALPHA_COINS"
        );
        $with = array(
            $alphaCoins
        );
        $email = $this->getEmailTemplate("alpha_coins", $replace, $with);

        $email['recipients'] = array(
            $u['email']
        );

        $this->sendEmail($email);

        $rewardTier1 = intval(($alphaCoins / 100) * 20);
        $rewardTier2 = intval(($alphaCoins / 100) * 5);
        if (!$rewardTier1) return;

        $user = $this
            ->db
            ->where('id', $user_id)->getOne('users', 'level');
        if ($user['level'] < 4) return;

        $referral = $this
            ->db
            ->where('slave_user_id', $user_id)->getOne('user_referrals', 'master_user_id, referral_id');
        if (!$referral['referral_id']) return;

        $reward = array(
            'alphaCoins' => $rewardTier1,
            'referral_id' => $referral['referral_id']
        );
        $this->addReward($referral['master_user_id'], $reward, 'A referral has purchased A-Coins');

        if (!$rewardTier2) return;
        $referralTier2 = $this
            ->db
            ->where('slave_user_id', $referral['master_user_id'])->getOne('user_referrals', 'master_user_id, referral_id');

        if (!$referralTier2['referral_id']) return;

        $reward = array(
            'alphaCoins' => $rewardTier2,
            'referral_id' => $referralTier2['referral_id']
        );
        $this->addReward($referralTier2['master_user_id'], $reward, 'A referral has purchased A-Coins');

    }

    function spendAlphaCoins($amount, $reason, $user_id = false)
    {
        if (!$user_id) $user_id = $this->user['id'];

        $alphaCoins = $this
            ->db
            ->where('id', $user_id)->getOne('users', 'alphaCoins');

        if ($alphaCoins['alphaCoins'] < $amount) return false;

        $logInsert = array(
            'created' => time() ,
            'ac_cost' => $amount,
            'user_id' => $user_id,
            'reason' => $reason,
        );
        if (!$this
            ->db
            ->insert('alpha_coins_logs', $logInsert)) return false;

        $this->updatePlayer(array(
            'alphaCoins' => $alphaCoins['alphaCoins'] - $amount
        ) , $user_id);

        return true;
    }

    function claimReward($reward_id, $reward = false)
    {
        if (!$reward) $reward = $this
            ->db
            ->where('reward_id', $reward_id)->getOne('user_rewards');
        if (!$reward['reward_id']) return false;

        $user = $this
            ->db
            ->where('id', $reward['user_id'])->getOne('users', 'id, money, alphaCoins,skillPoints, rewardsToReceive, dataPoints');
        if (!$user['id']) return false;

        if ($reward['components'])
        {
            $components = unserialize($reward['components']);
            if ($this
                ->uclass
                ->getAvailableStorageSlots() < count($components)) add_alert('Not enough slots available to claim the hardware.');
        }

        if ($reward['applications'])
        {
            $applications = unserialize($reward['applications']);

            $neededHDD = 0;
            foreach ($applications as $app)
            {
                $app = $this
                    ->db
                    ->where('app_id', $app['app_id'])->getOne('applications', 'hdd');
                $neededHDD += $app['hdd'];
            }
            require ("../includes/class/class.server.php");
            $server = new Server($this->user['server']);

            if ($server->server['total_hdd'] - $server->server['hdd_usage'] < $neededHDD) add_alert("Not enough HDD on main server to store the apps");
        }

        $reward['skills'] = unserialize($reward['skills']);
        $reward['achievements'] = unserialize($reward['achievements']);

        if (!there_are_errors())
        {

            foreach ($components as $component)
            {
                $newItem = array(
                    'component_id' => $component['component_id'],
                    'damage' => $component['damage'],
                    'user_id' => $this->user['id']
                );

                $this
                    ->db
                    ->insert('storage', $newItem);
            }

            foreach ($applications as $app)
            {
                $server->installApp($app);
            }

            if ($reward['exp']) $this->add_exp($reward['exp']);

            if ($reward['jobExp']) $this->addJobExperience($reward['user_id'], $reward['jobExp']);

            if ($reward['energy']) $this->addEnergy($reward['user_id'], $reward['energy']);

            $user['money'] += floatval($reward['money']);
            $user['skillPoints'] += intval($reward['skillPoints']);
            $user['dataPoints'] += floatval($reward['dataPoints']);
            $user['alphaCoins'] += intval($reward['alphaCoins']);
            $this->updatePlayer(array(
                'money' => $user['money'],
                'skillPoints' => $user['skillPoints'],
                'alphaCoins' => $user['alphaCoins'],
                'rewardsToReceive' => $user['rewardsToReceive'] - 1,
                'dataPoints' => $user['dataPoints']
            ) , $user['id']);

            if (is_array($reward['skills'])) foreach ($reward['skills'] as $skill => $amount) $this->addSkillExperience($reward['user_id'], $skill, $amount);

            if (is_array($reward['achievements'])) foreach ($reward['achievements'] as $achievement) $this->giveAchievement($reward['user_id'], $achievement);

            $reward['received'] = time();
            $this
                ->db
                ->where('reward_id', $reward['reward_id'])->update('user_rewards', array(
                'received' => $reward['received']
            ));

            return true;
        }
    }

    function computeUserSkillsCommandsInfluence($user_id = false, $skills = false, $allServers = false)
    {

        if (!$user_id || $user_id == $this->user['id'])
        {
            $user_id = $this->user['id'];
            $main = $this->user['server'];
        }
        else
        {
            $user = $this
                ->db
                ->where('id', $user_id)->getOne('users', 'id, server');
            $main = $user['server'];
        }
        require ('../includes/constants/skills.php');

        if (!$user_id) return array();

        if (!$skills)
        {
            $skillsToFetch = array_keys($theskills);

            $skills = $this
                ->uclass
                ->getUserSkills($user_id, $skillsToFetch);
        } //!$skills
        

        $commandsInfluence = array();
        foreach ($skills as $skill => $data) if (is_array($theskills[$skill]['commands'])) foreach ($theskills[$skill]['commands'] as $command => $influenceRate) $commandsInfluence[$command] += $influenceRate * $data['level'];

        if ($main)
        {
            require_once ('../includes/class/class.server.php');

            $servers = array();
            if ($allServers)
            {
                $servers = $this
                    ->db
                    ->where('user_id', $user_id)->get('servers');

            }

            foreach ($servers as & $srv)
            {
                $srv = new Server($srv['server_id'], $srv);
                $srv->fetchSkills();
            }
            if (!$allServers)
            {
                $server = new Server($main);
                $server->fetchSkills();
                $servers[] = $server;
            }
            $commandsInfluence = array();
            foreach ($servers as $server)
            {
                $srvCommandsInfluence = $server->computeSkillsCommandsInfluence();
                foreach ($srvCommandsInfluence as $c => $v) $commandsInfluence[$c] += $v;
            }

        }

        return $commandsInfluence;
    }

    function recomputeDataPointsStats($user_id)
    {
        if (!$user_id) return;

        $servers = $this
            ->db
            ->where('user_id', $user_id)->get('servers');

        $dataPointsPerHour = 0;
        if (count($servers))
        {
            $dataPointsPerHour = count($servers) * 10;

            $influence = $this->computeUserSkillsCommandsInfluence($user_id, false, true);

            $dataPointsPerHour += $influence['data_points_mining'];
        }

        $this->updatePlayer(array(
            'dataPointsPerHour' => $dataPointsPerHour
        ) , $user_id);

    }

    function getTotalStorageSlots()
    {
        $user_level = $this->user['level'];
        $user_premium = $_SESSION['premium']['extraStorage1'];
        $user_premium = $user_premium ? 10 : 0;

        return 6 + floor($user_level / 7) + $user_premium;
    }

    function getAvailableStorageSlots()
    {
        $user_id = $this->user['id'];

        $used = $this
            ->db
            ->where('user_id', $user_id)->getOne('storage', 'count(*) nrs');

        return ($freeSlots = $this->getTotalStorageSlots() - $used['nrs']) > 0 ? $freeSlots : 0;
    }

    function hasEnoughResources($user, $resources)
    {
        if ($user['money'] < $resources['money']) return false;
        if ($user['dataPoints'] < $resources['dataPoints']) return false;
        if ($user['energy'] < $resources['energy']) return false;

        return true;
    }

    function substractResources($resources, $user_id)
    {
        if (!$user_id) return;
        $resources['money'] = floatval($resources['money']);
        $resources['energy'] = intval($resources['energy']);
        $resources['dataPoints'] = floatval($resources['dataPoints']);

        if (!$resources['money']) $resources['money'] = 0;
        if (!$resources['energy']) $resources['energy'] = 0;
        if (!$resources['dataPoints']) $resources['dataPoints'] = 0;

        $this
            ->db
            ->rawQuery('update users set energy = energy - ?,
                                          money = money - ?,
                                          dataPoints = dataPoints - ?
                          where id = ? limit 1', array(
            $resources['energy'],
            $resources['money'],
            $resources['dataPoints'],
            $user_id
        ));
    }

    function sendAchievements($achievements = array() , $user_id = false, $unique = false, $title = "Achievement")
    {
        if (!$user_id) $user_id = $this->user['id'];
        if (!$user_id) return false;

        if ($unique)
        {
            foreach ($achievements as $key => $achievement)
            {
                $check = $this
                    ->db
                    ->where('user_id', $user_id)->where('achievement_id', $achievement)->getOne('user_achievements', 'user_achievement_id');
                if ($check['user_achievement_id']) unset($achievements[$key]);
            }
        }

        $reward = array(
            "achievements" => array(
                3
            )
        );
        $this
            ->uclass
            ->addReward($user_id, $reward, $title);

    }

    function getAvailableServersForAttack($user_id = false)
    {

        if (!$user_id) $user_id = $this->user['id'];
        if (!$user_id) return false;

        $servers = $this
            ->db
            ->where('user_id', $user_id)->get("servers");
        $usedServers = $this
            ->db
            ->where('sender_user_id', $user_id)->where('servers is not null')
            ->get('attacks_inprogress');
        $usedServersIds = array();
        foreach ($usedServers as $inprogressAttack) $usedServersIds = array_merge($usedServersIds, explode(",", $inprogressAttack['servers']));

        foreach ($servers as & $server) if (in_array($server['server_id'], $usedServersIds)) $server['cant_use'] = true;

        return $servers;
    }
}

$uclass = new UserClass();

?>
