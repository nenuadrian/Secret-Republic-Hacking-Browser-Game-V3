$(document).ready(function() {

    var zones = {
        1: { description: 'Strict yet possessing a certain delicacy that the inhabitants of other zones lack, the majority populating Zone 1 is known to have a large monetary support. To them, one of the two existent inhibitions in this contest apply, that being that users registered from here can participate with only a small fraction of their daily life income towards the purchase of applications and hardware. Do not try to delude yourself that you will ever manage to understand their true goals hidden behind their identical smiles.<br/><br/><strong>Start with</strong><br/>Dynamic Programming - Level 3' },
        2: { description: 'Since the Great Authentication War, Zone 2 is known to possess the most strict and protective regulations towards it\'s inhabitants, setting it appart as the safest and yet the most avoided zone in general. Hackers that emerge from here feel the need to better guard themselves against the cruel world they are about to step in.<br/><br/>Word to describe Zone 2 people: "Emotionless".<br/><br/><strong>Start with</strong><br/>Network protection - Level 2<br/>Intrusion detection - Level 2' },
        3: { description: 'Throughout history, this insular country had withstanded a lot of hardships and invasions alike, which made it’s inhabitants prone to judge newcomers poorly. Through seclusion a nation can become powerful on its own, though this is not the case for Zone 3. Though the nation as a whole is weak, the population isn’t. You could call them frail, but that doesn’t mean they are incapable of dealing with others in their own way. Even though the crime rate in Zone 3 isn’t high, theft is an everyday thing.<br/><br/><strong>Start with</strong><br/>Tracing prevention - Level 2<br/>Firewall Cracking - Level 2' },
        4: { description: 'Before the war, humanity was slowly succumbing to technology, robots replacing humans in increasingly more tasks. Now, Zone 4 is the main industrial cluster, the few remaining survivors of the war witnessing the infancy of a system where robots build robots without human intervention. Independence and creativity are the price paid for survival. Hackers arising from this Zone do not believe in this path and want to subdue technology again. First step: conquering the Grid. <br/><br/><strong>Start with</strong><br/>Task Automation - Level 2<br/>Data Processing - Level 2' },
        5: { description: 'Though they were once high class citizens as well, the fast advances in technology left them into dust. Rapid development was out of the question for their frail economy, therefore they entered a period of recession. The inhabitants of Zone 5 have one single emotion in common, that being envy towards their neighbours. Their way of thinking is quite level headed, but that doesn’t mean their emotions can’t cloud their judgement. <br/><br/><strong>Start with</strong><br/>Dynamic Programming - Level 2<br/>Tracing prevention - Level 2' },
        6: { description: 'The religious movement Iscariot. Zone 6 is their main area of operation, as for the inhabitants of said zone, to them one of the two existent inhibitions in this contest apply, that being that users registered from here must not use their political power as means of securing servers or any violations against rules in the Code of Codes. Zone 6 has the highest crime rate among all of the other five zones, the result of a rotten infrastructure that dates to the foundation of this zone as a country.<br/><br/><strong>Start with</strong><br/>Vulnerability analysis - Level 4' }
    };
    // register
    $(".zoneSelect").click(function() {

        clicked = this;
        $("#" + $(clicked).prop("id") + "_checkbox").prop('checked', true);

        $(clicked).css('opacity', 1);

        $('#zone_info').slideUp('slow', function() {
            $('#zone_info').html(zones[$(clicked).attr('data-zone')].description);
            $('#zone_info').slideDown('slow');
        });

        $(".zoneSelect").each(function() {
            if (this != clicked) {
                $(this).css("opacity", ".6");
                $("#" + $(this).prop("id") + "_checkbox").prop('checked', false);
            }
        });


    });



});