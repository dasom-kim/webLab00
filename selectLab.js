"use strict";

document.observe("dom:loaded", function() {
	/* Make necessary elements Dragabble / Droppables (Hint: use $$ function to get all images).
	 * All Droppables should call 'labSelect' function on 'onDrop' event. (Hint: set revert option appropriately!)
	 * 필요한 모든 element들을 Dragabble 혹은 Droppables로 만드시오 (힌트 $$ 함수를 사용하여 모든 image들을 찾으시오).
	 * 모든 Droppables는 'onDrop' 이벤트 발생시 'labSelect' function을 부르도록 작성 하시오. (힌트: revert옵션을 적절히 지정하시오!)
	 */
	
	Droppables.add("selectpad", {onDrop: labSelect, revert: true});	
	Droppables.add("labs", {onDrop: labSelect, revert: true});
	
	var labImgs = $$("#labs img");
	for (var i = 0; i < labImgs.length; i++) {
    	new Draggable(labImgs[i], {revert: true});
    }   		
	
});

function labSelect(drag, drop, event) {
	/* Complete this event-handler function 
	 * 이 event-handler function을 작성하시오.
	 */
	event.returnValue = false;
	
	if (drag.parentNode.getAttribute("id") !== drop.id) {
	
		if (drop.id === "labs") {
			$("selectpad").removeChild(drag);
			$("labs").appendChild(drag);
				
			var list = document.getElementsByTagName("li");
				
			for (var i = 0; i < list.length; i++) {
				if (list[i].innerHTML.indexOf(drag.alt) >= 0) {
					list[i].parentNode.removeChild(list[i]);
				}
			}
				
		} else {
			if ($("selectpad").descendants().length < 3) {
				$("labs").removeChild(drag);
				$("selectpad").appendChild(drag);
					
				var li = document.createElement("li");
				li.innerHTML = drag.alt;
				$("selection").appendChild(li);
				
				$("selection").pulsate({
					duration: 1.0,
					delay: 0.5
				});
			}
		}
		
	}
	
}
