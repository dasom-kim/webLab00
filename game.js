"use strict";

var numberOfBlocks = 9;
var targetBlocks = [];
var trapBlock;
var targetTimer;
var trapTimer;
var instantTimer;


document.observe('dom:loaded', function(){
	$("start").observe("click", function() {
		$("state").update("Ready!");
		$("score").update("0");
		for(var i = 0; i < numberOfBlocks; i++) {
			$$(".block")[i].removeClassName("target");
			$$(".block")[i].removeClassName("trap");
			$$(".block")[i].removeClassName("wrong");
		}
		instantTimer = setTimeout(startGame , 3000);
	});
	$("stop").observe("click", function() {
		stopGame();
	});
});

function startGame(){
	targetBlocks = [];
	startToCatch();
}

function stopGame(){
	$("state").update("Stop");
	clearInterval(targetTimer);	
	clearInterval(trapTimer);
	clearInterval(instantTimer);	
	targetBlocks = [];
	trapBlock = null;
	instantTimer = null;
}

function startToCatch(){
	$("state").update("Catch!");
	
	var score = 0;
	var temp;
	
	for(var i = 0; i < numberOfBlocks; i++) {
		$$(".block")[i].observe("click",function(event){
			temp = this.getAttribute("data-index"); //클릭한 버튼의 인덱스를 temp에 저장함.
			
			for (var c = 0; c < targetBlocks.length; c++) {
				if (temp == targetBlocks[c]) {
					score += 20;					
					$("score").update(score);
					targetBlocks.splice(c, 1);
					$$(".block")[temp].removeClassName("target");
				} else {
					if (c == targetBlocks.length - 1) {
						if (temp == trapBlock) {
							score -= 30;
							$("score").update(score);
							$$(".block")[temp].removeClassName("trap");
						} else {
							score -= 10;
							$("score").update(score);
							$$(".block")[temp].addClassName("wrong");
							setTimeout(function() {
								$$(".block")[temp].removeClassName("wrong");
							}, 100);				
						}
					}
				
				}				
			}
					
		});
	}
	
	targetTimer = setInterval(function() {	
		var rand = Math.floor(Math.random()*9);
		
		for (var c = 0; c < targetBlocks.length; c++) {
			if (rand == targetBlocks[c]) {
				do {
					rand = Math.floor(Math.random()*9);
				}
				while (rand == targetBlocks[c]);
			}					
		}
		
		targetBlocks.push(rand);
		$$(".block")[rand].addClassName("target");
		if(targetBlocks.length > 4) {
			alert("you lose! :(");
			for(var i = 0; i < numberOfBlocks; i++) {
				$$(".block")[i].stopObserving("click");
			}
			stopGame();
		}
	}, 1000);
	
	trapTimer = setInterval(function() {
		var rand = Math.floor(Math.random()*9);
			
		for (var c = 0; c < targetBlocks.length; c++) {
			if (rand == targetBlocks[c]) {
				do {
					rand = Math.floor(Math.random()*9);
				}
				while (rand == targetBlocks[c]);
			}					
		}
		
		trapBlock = rand;
		
		$$(".block")[trapBlock].addClassName("trap");
		setTimeout(function() {
			$$(".block")[trapBlock].removeClassName("trap");
			trapBlock = null;
		}, 2000);
	}, 3000);

}







