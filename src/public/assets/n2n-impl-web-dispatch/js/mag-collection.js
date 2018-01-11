(function () {
	function MagCollection(elem) {
		this.container = container;
		this.elems =  [].slice.call(this.container.children);
		this.hiddenElems = [];
		this.addBtn = this.createAddBtn();
		this.numExisting = 0;
		this.btnAddAttrs = '';
		this.btnRemoveAttrs = '';

		this.init();
	}

	MagCollection.prototype.init = function() {
		this.setupBtns();
		for (var i = this.numExisting; i < this.elems.length; i++) {
			this.elems[i].remove();
			this.hiddenElems.push(this.elems[i]);
		}
	}

	MagCollection.prototype.setupBtns = function() {
		for (var i = 0; i < this.elems.length; i++) {
			var elem = this.elems[i];
			elem.appendChild(this.createRemoveBtn(elem));
		}

		this.container.parentElement.appendChild(this.addBtn);
	}

	MagCollection.prototype.createAddBtn = function() {
		var elem = document.createElement("button");
		elem.innerHTML = "add";
		elem.style.cursor = "pointer";

		for (i in this.btnAddAttrs) {
			elem.setAttribute(i, this.btnAddAttrs[i]);
		}

		var that = this;
		elem.onclick = function(e) {
			that.container.appendChild(that.hiddenElems.pop());
			if (that.hiddenElems.length === 0) {
				this.style.display = "none";
			}

			e.stopPropagation();
			return false;
		};

		return elem;
	}

	MagCollection.prototype.createRemoveBtn = function(arrayElem) {
		var elem = document.createElement("button");
		elem.innerHTML = "remove";
		elem.style.cursor = "pointer";

		for (i in this.btnRemoveAttrs) {
			elem.setAttribute(i, this.btnRemoveAttrs[i]);
		}

		var that = this;
		elem.onclick = function(e) {
			arrayElem.remove();
			that.hiddenElems.push(arrayElem);
			that.addBtn.style.display = "";

			e.stopPropagation();
			return false;
		};

		return elem;
	}

	var lastScript = [].slice.call(document.getElementsByTagName("script")).slice(-1)[0];
	var container = lastScript.parentElement.getElementsByTagName("div")[0];
	var reformer = new MagCollection(container,
		3, //numExisting
		'alert-success', // 'btnAddAttrs' => $uiOutfitter->buildAttrs(UiOutfitter::NATURE_BTN_PRIMARY),
		'alert-danger') // 'btnRemoveAttrs' => $uiOutfitter->buildAttrs(UiOutfitter::NATURE_BTN_SECONDARY)))) ?>);

	var collectionElements = document.getElementsByClassName("n2n-impl-web-dispatch-mag-collection");
	for (var i = 0; i < collectionElements.length; i++) {
		MagCollection.init(collectionElements[i]);
	}
})();



/*
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
(function () {

	if (document.readyState === "complete" || document.readyState === "interactive") {
		enumEnablerFunc([document.documentElement]);
	} else {
		document.addEventListener("DOMContentLoaded", enumEnablerFunc([document.documentElement]));
	}

	if (window.Jhtml) {
		Jhtml.ready(function (elements) {
			alert("helloWorld");
			enumEnablerFunc(elements);
		});
	}
})();
/*
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
}*/