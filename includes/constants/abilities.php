<?php
/* Nenu Adrian http://nenuadrian.com 2012 */


// keep a number under 2
// (1 + $x/101) <= 2 ? 1 + $x/101 : 2
// from 1 to 100 it increments between 1 and 2. After 100 it returns 2

if (!function_exists('magicFormula')) {
  function magicFormula($level = 1, $limit = 2, $magicNumber = 100)
  {
    // limit 2 means up to half, limit 1.4 is a third
    return (1 + $level / $magicNumber) <= $limit ? 1 + $level / $magicNumber : $limit;
  }
  
} //!function_exists('magicFormula')
//for ($x=1;$x<=150;$x++)
// echo $x." ".magicFormula($x, 1.5, 150)."<br/>";



function abilities($userAbilities, $userData) { 
  return array(
    1 => array(
      "name" => "Encryption",
      "description" => "The power to encode strings into humanly unreadable and hard to decode text in order to hide sensitive information from foreign eyes.",
      "image" => "encryption.png",
      "maxLevel" => 20,
      "requirements" => array(
        2 => 2,
        3 => 1,
        6 => 1
        
      ),
      "rates" => array(
        "skills" => array(
          1 => 5 * ($userAbilities[1] + 1),
          2 => 3 * ($userAbilities[1] + 1),
          5 => 3 * ($userAbilities[1] + 1)
        ),
        "time" => round(((1 * 60 * 60 * ($userAbilities[1] + 1)) / magicFormula($userAbilities[2])) / magicFormula($userAbilities[6], 1.5, 150)),
        "price" => round(100 * ($userAbilities[1] + 2) / magicFormula($userAbilities[6], 1.5, 100)),
        "energy" => round(($userData["maxEnergy"] / 3) / magicFormula($userAbilities[6], 2, 100)),
        "userLevel" => ($userAbilities[1]) * 2,
      "dataPoints" =>80 * ($userAbilities[1] + 1)
      ),
    
    ),
    2 => array(
      "name" => "Typing speed",
      "description" => "Improving your typing speed will allow you to learn other abilities faster. Not to mention the extra skill perks.",
      "image" => "typing-speed.png",
      "maxLevel" => 20,
      "rates" => array(
        "skills" => array(
          1 => 5 * ($userAbilities[2] + 1),
          9 => 5 * ($userAbilities[2] + 1),
          10 => 5 * ($userAbilities[2] + 1),
        
          
        ),
        "time" => round((1 * 60 * 60 * ($userAbilities[2] + 1)) / magicFormula($userAbilities[6], 1.5, 100)),
        "price" => round(150 * ($userAbilities[2] + 2) / magicFormula($userAbilities[6], 1.5, 100)),
        "energy" => round(($userData["maxEnergy"] / 3) / magicFormula($userAbilities[6], 2, 100)),
        "userLevel" => ($userAbilities[2]) * 2,
      "dataPoints" => 80 * ($userAbilities[2] + 1)
      )
      
    ),
    3 => array(
      "name" => "Discretion",
      "description" => "Better delete your traces. Don't leave behind any proof of your passing. A silent hacker is a powerful one.",
      "image" => "discretion.png",
      "maxLevel" => 20,
      "rates" => array(
        "skills" => array(
          3 => 4 * ($userAbilities[3] + 1),
          5 => 3 * ($userAbilities[3] + 1),
          11 => 3 * ($userAbilities[3] + 1)
        ),
        // take in account typing speed and research ability
        "time" => round(((1 * 60 * 60 * ($userAbilities[3] + 1)) / magicFormula($userAbilities[2])) / magicFormula($userAbilities[6], 1.5, 100)),
        "price" => round(150 * ($userAbilities[3] + 2) / magicFormula($userAbilities[6], 1.5, 100)),
        "energy" => round(($userData["maxEnergy"] / 3) / magicFormula($userAbilities[6], 2, 100)),
        "userLevel" => ($userAbilities[3]) * 2,
      "dataPoints" => 80 * ($userAbilities[3] + 1)
      )
    ),
    
    
    4 => array(
      "name" => "The Unseen Hand",
      "description" => "Get better and better at stealing information, the new currency of the world, and also not getting caught.",
      "image" => "unseen-hand.png",
      "maxLevel" => 20,
      "rates" => array(
        "skills" => array(
          4 => 5 * ($userAbilities[4] + 1),
          5 => 5 * ($userAbilities[4] + 1),
          11 => 4 * ($userAbilities[4] + 1),
          
        ),
        "time" => round(((1 * 60 * 60 * ($userAbilities[4] + 1)) / magicFormula($userAbilities[2])) / magicFormula($userAbilities[6], 1.5, 100)),
        "price" => round(150 * ($userAbilities[4] + 2) / magicFormula($userAbilities[6], 1.5, 100)),
        "energy" => round(($userData["maxEnergy"] / 3) / magicFormula($userAbilities[6], 2, 100)),
        "userLevel" => ($userAbilities[4]) * 2,
      "dataPoints" => 80 * ($userAbilities[4] + 1)
      )
    ),
    5 => array(
      "name" => "SQL Injection",
      "description" => "Improve your knowledge in this domain and become even more dangerous when it comes down to hacking.",
      "image" => "sql-injection.png",
      "maxLevel" => 20,
      "rates" => array(
        "skills" => array(

          2 => 2 * ($userAbilities[5] + 1),
          7 => 3 * ($userAbilities[5] + 1),
          9 => 4 * ($userAbilities[5] + 1),
          
        ),
        "time" => round(((1 * 60 * 60 * ($userAbilities[5] + 1)) / magicFormula($userAbilities[2])) / magicFormula($userAbilities[6], 1.5, 100)),
        "price" => round(150 * ($userAbilities[5] + 2) / magicFormula($userAbilities[6], 1.5, 100)),
        "energy" => round(($userData["maxEnergy"] / 3) / magicFormula($userAbilities[6], 2, 100)),
        "userLevel" => ($userAbilities[5]) * 2,
      "dataPoints" => 80 * ($userAbilities[5] + 1)
      )
    ),
    6 => array(
      "name" => "Researching",
      "description" => "Decrease learning time and resources cost of abilities. P.S. unlocks hidden abilities.",
      "image" => "research.png",
      "maxLevel" => 20,
      "rates" => array(
        "skills" => array(
          1 => 1 * ($userAbilities[6] + 1),
          2 => 1 * ($userAbilities[6] + 1),
          3 => 1 * ($userAbilities[6] + 1),
          4 => 1 * ($userAbilities[6] + 1),
          5 => 1 * ($userAbilities[6] + 1),
          6 => 1 * ($userAbilities[6] + 1),
          7 => 1 * ($userAbilities[6] + 1),
          8 => 1 * ($userAbilities[6] + 1),
          9 => 1 * ($userAbilities[6] + 1),
          10 => 1 * ($userAbilities[6] + 1),
          11 => 1 * ($userAbilities[6] + 1),
          
        ),
        "time" => round(((1 * 60 * 60 * ($userAbilities[6] + 1)) / magicFormula($userAbilities[2]))),
        "price" => round(150 * ($userAbilities[6] + 2) / magicFormula($userAbilities[6], 1.5, 100)),
        "energy" => round(($userData["maxEnergy"] / 3) / magicFormula($userAbilities[6], 2, 100)),
        "userLevel" => ($userAbilities[6]) * 2,
      "dataPoints" => 80 * ($userAbilities[6] + 1)
      )
    ),
    7 => array(
      "name" => "IP spoofing",
      "description" => "Study dueling strategies and improve your chances.",
      "image" => "spoofing.png",
      "maxLevel" => 20,
      "requirements" => array(
        1 => 10,
        2 => 10,
        5 => 5,
        5 => 5,
        6 => 2
      ),
      "rates" => array(
        "skills" => array(
          2 => 1 * ($userAbilities[7] + 1),
          5 => 2 * ($userAbilities[7] + 1),
          6 => 3 * ($userAbilities[7] + 1),
          10 => 3 * ($userAbilities[7] + 1),
          11 => 3 * ($userAbilities[7] + 1),
        ),
        "time" => round(((1 * 60 * 60 * ($userAbilities[7] + 1)) / magicFormula($userAbilities[2])) / magicFormula($userAbilities[6], 1.5, 100)),
        "price" => round(150 * ($userAbilities[7] + 2) / magicFormula($userAbilities[6], 1.5, 100)),
        "energy" => round(($userData["maxEnergy"] / 3) / magicFormula($userAbilities[6], 2, 100)),
        "userLevel" => ($userAbilities[7]) * 2,
      "dataPoints" => 80 * ($userAbilities[7] + 1)
      )
    ),
    8 => array(
      "name" => "SSL Decryption",
      "description" => "Study dueling strategies and improve your chances.",
      "image" => "decryption.png",
      "maxLevel" => 20,
      "requirements" => array(
        1 => 10,
        2 => 10,
        5 => 5,
        5 => 5,
        6 => 2
      ),
      "rates" => array(
        "skills" => array(
          2 => 1 * ($userAbilities[8] + 1),
          3 => 1 * ($userAbilities[8] + 1),
          11 => 1 * ($userAbilities[8] + 1),
        ),
        "time" => round(((1 * 60 * 60 * ($userAbilities[8] + 1)) / magicFormula($userAbilities[2])) / magicFormula($userAbilities[6], 1.5, 100)),
        "price" => round(150 * ($userAbilities[8] + 2) / magicFormula($userAbilities[6], 1.5, 100)),
        "energy" => round(($userData["maxEnergy"] / 3) / magicFormula($userAbilities[6], 2, 100)),
        "userLevel" => ($userAbilities[8]) * 2,
      "dataPoints" => 80 * ($userAbilities[8] + 1)
      )
    )
  );
}

?>