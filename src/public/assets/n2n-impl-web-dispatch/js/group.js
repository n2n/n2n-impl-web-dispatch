
n2n.dispatch.registerCallback(function () {
	var enablerElems = document.getElementsByClassName("n2n-impl-web-dispatch-enabler");
	var callback = function () {
		updateEnabler(this);
	};
	
	for (var i = 0, ii = enablerElems.length; i < ii; i++) {
		enablerElems[i].removeEventListener("click", callback);
		enablerElems[i].addEventListener("click", callback);
		
		updateEnabler(enablerElems[i]);
	}
	
	function updateEnabler(elem) {
		var displayTypeName = elem.checked ? "block" : "none";
		var groupClassName = elem.getAttribute("data-n2n-impl-web-dispatch-enabler-class");
	
		var groupElems = document.getElementsByClassName(groupClassName);
		for (var i = 0, ii = groupElems.length; i < ii; i++) {
			groupElems[i].style.display = displayTypeName;
		}
	}
});