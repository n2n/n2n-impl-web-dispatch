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
			that.collectionItemContainer.append(elem);

			if (that.hiddenElems.length === 0) {
				that.adderBtn.style.display = "none";
			}

			e.stopPropagation();
			return false;
		};

		var showCount = this.filledCount;
		for (let collectionItemElem of this.collectionItemElems) {
			var removerBtn = collectionItemElem.getElementsByClassName(that.removerClassName)[0];

			removerBtn.onclick = function (e) {
				collectionItemElem.remove();
				that.hiddenElems.push(collectionItemElem);

				if (that.hiddenElems.length > 0) {
					that.adderBtn.style.display = "block";
				}
				e.stopPropagation();
				return false;
			};

			if (showCount > 0) {
				showCount--;
				return;
			}

			collectionItemElem.remove();
			that.hiddenElems.push(collectionItemElem);
		}
	}

	var init = function (elements) {
		let collectionElements = [];
		for (let elem of elements) {
			let collectionElemsArr = [].slice.call(elem.getElementsByClassName("n2n-impl-web-dispatch-mag-collection"));
			collectionElements = collectionElements.concat(collectionElemsArr);
		}

		for (let collectionElem of collectionElements) {
			var adderClass = collectionElem.dataset.magCollectionItemAdderClass;
			var removerClass = collectionElem.dataset.magCollectionItemRemoverClass;
			var showCount = collectionElem.dataset.magCollectionShowCount;

			new MagCollection(collectionElem, adderClass, removerClass, showCount);
		};
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