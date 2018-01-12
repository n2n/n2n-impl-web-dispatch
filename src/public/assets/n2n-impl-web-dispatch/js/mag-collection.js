(function () {
	function MagCollection(elem) {
		this.containerElem = elem;
		this.collectionItemElems = Array.from(elem.children);
		this.hiddenElems = [];
		this.numExisting = this.containerElem.dataset.magCollectionItemExisting;
		this.btnAddAttrs = JSON.parse(this.containerElem.dataset.magCollectionAddAttrs);
		this.btnRemoveAttrs = JSON.parse(this.containerElem.dataset.magCollectionRemoveAttrs);
		this.addBtn = this.createAddBtn();
		this.init();
	}

	MagCollection.prototype.init = function() {
		this.setupBtns();
		for (var i = this.numExisting; i < this.collectionItemElems.length; i++) {
			this.collectionItemElems[i].remove();
			this.hiddenElems.push(this.collectionItemElems[i]);
		}
	}

	MagCollection.prototype.setupBtns = function() {
		for (var i = 0; i < this.collectionItemElems.length; i++) {
			var elem = this.collectionItemElems[i];
			$(elem).find('.mag-collection-control-wrapper').append(this.createRemoveBtn(elem));
		}

		this.containerElem.parentElement.appendChild(this.addBtn);
	}

	MagCollection.prototype.createAddBtn = function() {
		var elem = document.createElement("button");
		elem.innerHTML = "+";
		elem.style.cursor = "pointer";

		for (i in this.btnAddAttrs) {
			elem.setAttribute(i, this.btnAddAttrs[i]);
		}

		var that = this;
		elem.onclick = function(e) {
			that.containerElem.appendChild(that.hiddenElems.pop());
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
		elem.innerHTML = "-";
		elem.style.cursor = "pointer";

		for (var i in this.btnRemoveAttrs) {
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

	var initedMagColElems = [];

	var init = function (elements) {
		var magColElems = [];
		for (var i in elements) {
			magColElems.push(Array.from(elements[i].getElementsByClassName("n2n-impl-web-dispatch-mag-collection")));
		}

		for (var i = 0; i < magColElems.length; i++) {
			if (initedMagColElems.indexOf(magColElems[i][0]) > -1) {
				continue;
			}

			new MagCollection(magColElems[i][0]);
			initedMagColElems.push(magColElems[i][0]);
		}
	}

	if (document.readyState === "complete" || document.readyState === "interactive") {
		init([document.documentElement]);
	} else if (!window.Jhtml) {
		document.addEventListener("DOMContentLoaded", init([document.documentElement]));
	}

	if (window.Jhtml) {
		Jhtml.ready(function (elements) {
			init(elements);
		});
	}
})();


/*
var lastScript = [].slice.call(document.getElementsByTagName("script")).slice(-1)[0];
var container = lastScript.parentElement.getElementsByTagName("div")[0];
var reformer = new MagCollection(container,
	3, //numExisting
	'alert-success', // 'btnAddAttrs' => $uiOutfitter->buildAttrs(UiOutfitter::NATURE_BTN_PRIMARY),
	'alert-danger') // 'btnRemoveAttrs' => $uiOutfitter->buildAttrs(UiOutfitter::NATURE_BTN_SECONDARY)))) ?>);*/


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

	if (window.Jhtml) {
		Jhtml.ready(function (elements) {
			enumEnablerFunc(elements);
		});
	} else if (document.readyState === "complete" || document.readyState === "interactive") {
		enumEnablerFunc([document.documentElement]);
	} else {
		document.addEventListener("DOMContentLoaded", enumEnablerFunc([document.documentElement]));
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