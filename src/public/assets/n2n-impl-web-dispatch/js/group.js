(function () {
	var boolCallback = function () {
		boolUpdateEnabler(this);
	};

	var boolEnabler = function () {
		var enablerElems = document.getElementsByClassName("n2n-impl-web-dispatch-enabler");

		for (var i = 0, ii = enablerElems.length; i < ii; i++) {
			enablerElems[i].removeEventListener("click", boolCallback);
			enablerElems[i].addEventListener("click", boolCallback);

			boolUpdateEnabler(enablerElems[i]);
		}
	};

	function boolUpdateEnabler(elem) {
		var displayTypeName = elem.checked ? "block" : "none";
		var groupClassName = elem.getAttribute("data-n2n-impl-web-dispatch-enabler-class");

		var groupElems = document.getElementsByClassName(groupClassName);
		for (var i = 0, ii = groupElems.length; i < ii; i++) {
			groupElems[i].style.display = displayTypeName;
		}
	}
	
	if (document.readyState === "complete" || document.readyState === "interactive") {
		boolEnabler();
	} else {
		document.addEventListener("DOMContentLoaded", boolEnabler);
	}
	
	if (n2n.dispatch) {
		n2n.dispatch.registerCallback(boolEnabler);
	}
	
	if (window.Jhtml) {
		Jhtml.ready(boolEnabler);
	}

	var enumCallback = function () {
		enumUpdateEnabler(this);
	};

	var enumEnablerFunc = function () {
		var enablerElems = document.getElementsByClassName("n2n-impl-web-dispatch-enum-enabler");
		
		for (var i = 0, ii = enablerElems.length; i < ii; i++) {
			enablerElems[i].removeEventListener("change", enumCallback);
			enablerElems[i].addEventListener("change", enumCallback);

			enumUpdateEnabler(enablerElems[i]);
		}
	};

	function enumUpdateEnabler(elem) {
		var value = elem.value;
		var groupClassName = elem.getAttribute("data-n2n-impl-web-dispatch-enabler-class")

		var groupElems = document.getElementsByClassName(groupClassName);
		for (var i = 0, ii = groupElems.length; i < ii; i++) {
			groupElems[i].style.display = "none"
		}

		var groupElems = document.getElementsByClassName(groupClassName + "-" + elem.value);
		for (var i = 0, ii = groupElems.length; i < ii; i++) {
			groupElems[i].style.display = "block"
		}
	}

	if (document.readyState === "complete" || document.readyState === "interactive") {
		enumEnablerFunc();
	} else {
		document.addEventListener("DOMContentLoaded", enumEnablerFunc);
	}

	if (n2n.dispatch) {
		n2n.dispatch.registerCallback(enumEnablerFunc);
	}

	if (window.Jhtml) {
		Jhtml.ready(enumEnablerFunc);
	}
})();