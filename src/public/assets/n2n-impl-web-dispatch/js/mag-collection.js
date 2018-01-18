(function () {
	function MagCollection(elemJq, adderClassName, removerClassName) {
		this.containerElemJq = elemJq;
		this.collectionItemContainerJq = elemJq.find(".n2n-impl-web-dispatch-mag-collection-items")
		this.collectionItemElemJqs = this.collectionItemContainerJq.children();
		this.hiddenElemJqs = [];
		this.adderClassName = adderClassName;
		this.removerClassName = removerClassName;
		this.init();
	}

	MagCollection.prototype.init = function() {
		var adderBtnJq = this.containerElemJq.find("." + this.adderClassName);
		var that = this;

		adderBtnJq.click(function (e) {
			var elemJq = that.hiddenElemJqs.pop();
			elemJq.show();
			that.collectionItemContainerJq.append(elemJq);

			if (that.hiddenElemJqs.length === 0) {
				adderBtnJq.hide();
			}

			e.stopPropagation();
			return false;
		});

		this.collectionItemElemJqs.each(function (i, elem) {
			var collectionItemElemJq = $(elem);
			var removerBtnJq = collectionItemElemJq.find("." + that.removerClassName);
			removerBtnJq.click(function (e) {
				collectionItemElemJq.hide();
				that.hiddenElemJqs.push(collectionItemElemJq);

				if (that.hiddenElemJqs.length > 0) {
					that.containerElemJq.find("." + that.adderClassName).show();
				}

				e.stopPropagation();
				return false;
			});

			collectionItemElemJq.hide();
			that.hiddenElemJqs.push(collectionItemElemJq);
		})
	}

	var init = function (elements) {
		$(elements).find(".n2n-impl-web-dispatch-mag-collection").each(function(e, magCollectionElem) {
			var magCollectionElemJq = $(elements).find(magCollectionElem);
			var adderClass = magCollectionElemJq.data("magCollectionItemAdderClass");
			var removerClass = magCollectionElemJq.data("magCollectionItemRemoverClass");

			new MagCollection(magCollectionElemJq, adderClass, removerClass);
		});
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