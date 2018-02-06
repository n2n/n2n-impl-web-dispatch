(function () {
	function MagCollection(elem, adderClassName, removerClassName, filledCount) {
		this.containerElem = elem;
		this.collectionItemContainer = elem.getElementsByClassName("n2n-impl-web-dispatch-mag-collection-items")[0];
		this.collectionItemElems = [].slice.call(this.collectionItemContainer.getElementsByClassName("n2n-impl-web-dispatch-mag-collection-item"));
		this.hiddenElems = [];
		this.adderClassName = adderClassName;
		this.removerClassName = removerClassName;
		this.filledCount = filledCount;
		this.adderBtn = this.containerElem.getElementsByClassName(this.adderClassName)[0];

		this.init();
	}

	MagCollection.prototype.init = function() {
		var that = this;

		this.adderBtn.onclick = function (e) {
			var elem = that.hiddenElems.shift();
			that.collectionItemContainer.appendChild(elem.children[0]);

			if (that.hiddenElems.length === 0) {
				that.adderBtn.style.display = "none";
			}

			e.stopPropagation();
			return false;
		};

		var showCount = this.filledCount;
		for (let collectionItemElem of this.collectionItemElems) {
			var template = document.createElement("template");
			let removerBtn = collectionItemElem.getElementsByClassName(that.removerClassName)[0];

			removerBtn.onclick = function () {
				that.hiddenElems.push(template);
				template.appendChild(collectionItemElem);
				if (that.hiddenElems.length > 0) {
					that.adderBtn.style.display = "block";
				}

				return false;
			};

			if (showCount > 0) {
				showCount--;
				return;
			}

			this.hiddenElems.push(template);
			template.appendChild(collectionItemElem);
		}
	}

	var init = function (elements) {
		var collectionElements = [];
		for (var elem of elements) {
			var collectionElemsArr = [].slice.call(elem.getElementsByClassName("n2n-impl-web-dispatch-mag-collection"));
			collectionElements = collectionElements.concat(collectionElemsArr);
		}

		for (var collectionElem of collectionElements) {
			var adderClass = collectionElem.dataset.magCollectionItemAdderClass;
			var removerClass = collectionElem.dataset.magCollectionItemRemoverClass;
			var showCount = collectionElem.dataset.magCollectionShowCount;

			new MagCollection(collectionElem, adderClass, removerClass, showCount);
		};
	}

	// To make sure this script is executed after other javascript files have been loaded,
	// javascript files that could potentially set events on the to-be removed objects,
	// setTimeout is used. setTimeout() requeues the execution queue and the init function is placed at the end.
	if (window.Jhtml) {
		Jhtml.ready(function (elements) {
			setTimeout(function () { init(elements); });
		});
	} else if (document.readyState === "complete" || document.readyState === "interactive") {
		setTimeout(function () { init([document.documentElement]); });
	} else {
		document.addEventListener("DOMContentLoaded", function () {
			setTimeout(function () { init([document.documentElement]); });
		});
	}
})();

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